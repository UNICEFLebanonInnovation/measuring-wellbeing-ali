<?php

namespace App\Http\Controllers;
use App;
use App\Application;
use App\Caza;
use App\Collector;
use App\Gouvernate;
use App\Partner;
use App\Status;
use App\User;
use Auth;
use Session;
use Illuminate\Http\Request;

class ChangeDecreaseController extends Controller {
	public function index(Request $request) {
		$partners = Partner::all();

		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::join('users', 'users.id', 'collectors.user_id')->where('collectors.partner_id', Auth::user()->id)->get();
		} else {
			$collectors = Collector::join('users', 'users.id', 'collectors.user_id')->get();
		}
		// echo "<pre>";
		// print_r($collectors);
		// exit;

		$status = Status::all();
		$governate = Gouvernate::get();
		$caza = Caza::get();
		return view('admin.changedecrease.list', compact('partners', 'collectors', 'status', 'governate', 'caza'));
	}

	public function loadApplication(Request $request) {
		$formData = $request->all();
		$age = isset($formData['age']) ? $formData['age'] : '';
		$gouvarnate = isset($formData['gouv']) ? $formData['gouv'] : '';
		$caza = isset($formData['caza']) ? $formData['caza'] : '';

		$data = Application::with(['get_application_value' => function ($q) use ($age, $gouvarnate, $caza) {
			if (!empty($age)) {
				$q->where('form', '=', $age);
			}
			if (!empty($gouvarnate)) {
				$q->where('gouvarnate', '=', $gouvarnate);
			}
			if (!empty($caza)) {
				$q->where('caza', '=', $caza);
			}

		}])->select('application.*', 'part.name as partner_name', 'col.firstname as collector_name', 'status.name as status_name')
			->leftJoin('users as col', 'col.id', 'application.collector_id')
			->join('collectors', 'collectors.user_id', 'application.collector_id')
			->leftJoin('partners as part', 'part.user_id', 'collectors.partner_id')
			->leftJoin('status', 'status.id', 'application.status');
		if (isset($formData['code']) && !empty($formData['code'])) {
			$data->where('application.code', 'like', "%" . $formData['code'] . "%");
		}
		if (isset($formData['pre_test_date']) && !empty($formData['pre_test_date'])) {
			$data->whereRaw('MONTH(pre_test_date) = ?', [$formData['pre_test_date']]);
		}
		if (isset($formData['post_test_date']) && !empty($formData['post_test_date'])) {
			$data->whereRaw('MONTH(post_test_date) = ?', [$formData['post_test_date']]);}
		if (Auth::user()->hasrole('partner')) {
			if (isset($formData['collector']) && !empty($formData['collector'])) {
				$data->where('application.collector_id', $formData['collector']);
			} else {
				$data->where('application.partner_id', Auth::user()->id);
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
				$data->orWhereIn('application.collector_id', $collectors);
			}
		}

		if (Auth::user()->hasrole('admin')) {
			if (isset($formData['partner']) && !empty($formData['partner']) && empty($formData['collector'])) {
				$data->where('application.partner_id', $formData['partner']);
				$collectors = Collector::select('user_id')->where('partner_id', $formData['partner'])->get()->toArray();
				$data->orWhereIn('application.collector_id', $collectors);
			} elseif (isset($formData['partner']) && !empty($formData['partner']) && isset($formData['collector']) && !empty($formData['collector'])) {
				$data->where('application.partner_id', $formData['partner']);
				$data->where('application.collector_id', $formData['collector']);
			} elseif (!empty($formData['collector'])) {
				$data->where('application.collector_id', $formData['collector']);
			}
		}
		if (Auth::user()->hasrole('collector')) {
			$data->where('application.collector_id', Auth::user()->id);
		}
		if (isset($formData['status']) && !empty($formData['status'])) {
			$data->where('application.status', $formData['status']);
		}
		if((Session::has('from') && !empty(Session::get('from'))) && (Session::has('to') && !empty(Session::get('to')))){
			$data->where('application.id',">=",Session::get('from'));
			$data->where('application.id',"<=",Session::get('to'));
        }

		$data1 = $data->get();
		$data2 = array();

		foreach ($data1 as $key => $value) {
			if (!empty($value->get_application_value[1])) {
				if ($value->get_application_value[1]->score > $value->get_application_value[0]->score) {
					$data2[] = $value;
				}
			}
		}

		return datatables()->of($data2)
			->addColumn('age_name', function ($data2) {
				return $data2->get_application_value[0]->form;
			})
			->addColumn('pre_test_score', function ($data2) {
				return $data2->get_application_value[0]->score;
			})
			->addColumn('post_test_score', function ($data2) {
				return $data2->get_application_value[1]->score;
			})
			->addColumn('gover_nate_name', function ($data2) {
				$gover_nate_name = Gouvernate::where('id', $data2->get_application_value[0]->gouvarnate)->first();
				return $gover_nate_name->name;
			})
			->addColumn('caza_name', function ($data2) {
				$caza_name = Caza::where('id', $data2->get_application_value[0]->caza)->first();
				return $caza_name->name;
			})

			->addColumn('action', function ($data2) {

				$btn = '';

				if (Auth::user()->hasrole('partner')) {

					$btn .= '<a href="javascript:;"  data-id="' . $data2->id . '" data-code="' . $data2->code . '" data-dropdown="' . $data2->reason_option . '" data-details="' . $data2->reason_details . '" class=" btn btn-primary btn-sm open_reason_popup" >Edit</a>';

					$btn .= '<a href="javascript:void(0)"   data-id="' . $data2->id . '" data-code="' . $data2->code . '" data-dropdown="' . $data2->reason_option . '" data-details="' . $data2->reason_details . '" class=" btn btn-primary btn-sm reset-action open_reason_popup" data-toggle="modal" data-target="#basicModal">Reset</a>';
					if (!empty($data2->reason_option) && !empty($data2->reason_details)) {
						$btn .= '<a href="javascript:void(0)"   data-id="' . $data2->id . '" data-code="' . $data2->code . '" data-dropdown="' . $data2->reason_option . '" data-details="' . $data2->reason_details . '" class=" btn btn-primary btn-sm reset-action open_reason_view" data-toggle="modal" data-target="#basicModal1">View</a>';
						$btn .= '<i class="fas fa-check-circle"></i>';
					}

				} else {

					if (!empty($data2->reason_option) && !empty($data2->reason_details)) {
						$btn .= '<a href="javascript:void(0)"   data-id="' . $data2->id . '" data-code="' . $data2->code . '" data-dropdown="' . $data2->reason_option . '" data-details="' . $data2->reason_details . '" class=" btn btn-primary btn-sm reset-action open_reason_view" data-toggle="modal" data-target="#basicModal1">View</a>';

					}

				}

				return $btn;
			})
			->rawColumns(['action', 'age_name', 'pre_test_score', 'post_test_score', 'gover_nate_name', 'caza_name'])
			->make(true);
		if (request()->ajax()) {
		}

	}

	public function ReasonFrom(Request $request) {
		$formData = $request->all();
		$reasons = explode("reason_option%5B%5D=", str_replace("&", "", str_replace("%20", " ", $formData['reason_option'])));
		unset($reasons[0]);
		$application = Application::find($formData['application_id']);
		$application->reason_option = isset($reasons) && is_array($reasons) ? implode(" | ", $reasons) : '';
		$application->reason_details = isset($formData['reason_details']) ? $formData['reason_details'] : '';
		$application->save();

		$response = [
			'status' => 'success',
		];
		return response()->json($response);
	}

}
