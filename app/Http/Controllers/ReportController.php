<?php

namespace App\Http\Controllers;

use App\Application;
use App\Applicationvalue;
use App\ApplicationLog;
use App\Collector;
use App\Gouvernate;
use App\Partner;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class ReportController extends Controller {
	public function index() {
		return view('admin.report');
	}
	public function analytics() {
		return view('admin.analytics');
	}

	public function reasonForDropout() {
		$data['gouvernates'] = Gouvernate::all();

		if (Auth::user()->hasrole('partner')) {
			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 3)->get();
		} else {
			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 2)->get();
		}

		return view('admin.reports.reason_for_dropout', $data);
	}

	public function loadReasonForDropout(Request $request) {

		$formData = $request->all();
		$gender = $formData['gender'];
		$form_filter = $formData['form_filter'];
		$category_filter = $formData['category_filter'];
		$nationlity_filter = $formData['nationlity_filter'];
		$governorate_filter = $formData['governorate_filter'];
		$partner_filter = $formData['partner_filter'];

		$Childwasnolongerallowedtoaccessactivity = Application::select('application.id')
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', "post_test")
			->where('application.status', 9)
			->where('application_value.dropout_reason', "Child was no longer allowed to access activity");

		if (!empty($gender)) {
			$Childwasnolongerallowedtoaccessactivity->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$Childwasnolongerallowedtoaccessactivity->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$Childwasnolongerallowedtoaccessactivity->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$Childwasnolongerallowedtoaccessactivity->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$Childwasnolongerallowedtoaccessactivity->where('application_value.gouvarnate', $governorate_filter);
		}

		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$Childwasnolongerallowedtoaccessactivity->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$Childwasnolongerallowedtoaccessactivity->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$Childwasnolongerallowedtoaccessactivity->limit(Session::get('from'))->where('application.status',8);
			/*$Childwasnolongerallowedtoaccessactivity->where('application.id',"<=",Session::get('to'));*/
        }
		$Childwasnolongerallowedtoaccessactivity = $Childwasnolongerallowedtoaccessactivity->get()->count();

		$Childsaidhedidnotwanttoparticipateinactivityanylonger = Application::select('application.id')
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', "post_test")
			->where('application.status', 9)
			->where('application_value.dropout_reason', "Child said he did not want to participate in activity any longer");
		if (!empty($gender)) {
			$Childsaidhedidnotwanttoparticipateinactivityanylonger->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$Childsaidhedidnotwanttoparticipateinactivityanylonger->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$Childsaidhedidnotwanttoparticipateinactivityanylonger->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$Childsaidhedidnotwanttoparticipateinactivityanylonger->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$Childsaidhedidnotwanttoparticipateinactivityanylonger->where('application_value.gouvarnate', $governorate_filter);
		}

		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$Childsaidhedidnotwanttoparticipateinactivityanylonger->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$Childsaidhedidnotwanttoparticipateinactivityanylonger->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$Childsaidhedidnotwanttoparticipateinactivityanylonger->limit(Session::get('from'))->where('application.status',8);
			/*$Childsaidhedidnotwanttoparticipateinactivityanylonger->where('application.id',"<=",Session::get('to'));*/
        }
		$Childsaidhedidnotwanttoparticipateinactivityanylonger = $Childsaidhedidnotwanttoparticipateinactivityanylonger->get()->count();

		$RelocationwithinLebanon = Application::select('application.id')
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', "post_test")
			->where('application.status', 9)
			->where('application_value.dropout_reason', "Relocation within Lebanon");

		if (!empty($gender)) {
			$RelocationwithinLebanon->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$RelocationwithinLebanon->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$RelocationwithinLebanon->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$RelocationwithinLebanon->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$RelocationwithinLebanon->where('application_value.gouvarnate', $governorate_filter);
		}

		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$RelocationwithinLebanon->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$RelocationwithinLebanon->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$RelocationwithinLebanon->limit(Session::get('from'))->where('application.status',8);
			/*$RelocationwithinLebanon->where('application.id',"<=",Session::get('to'));*/
        }
		$RelocationwithinLebanon = $RelocationwithinLebanon->get()->count();

		$ReturnedtoSyria = Application::select('application.id')
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', "post_test")
			->where('application.status', 9)
			->where('application_value.dropout_reason', "Returned to Syria");
		if (!empty($gender)) {
			$ReturnedtoSyria->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$ReturnedtoSyria->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$ReturnedtoSyria->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$ReturnedtoSyria->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$ReturnedtoSyria->where('application_value.gouvarnate', $governorate_filter);
		}
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$ReturnedtoSyria->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$ReturnedtoSyria->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$ReturnedtoSyria->limit(Session::get('from'))->where('application.status',8);
			/*$ReturnedtoSyria->where('application.id',"<=",Session::get('to'));*/
        }
		$ReturnedtoSyria = $ReturnedtoSyria->get()->count();

		$Leftforthirdcountry = Application::select('application.id')
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', "post_test")
			->where('application.status', 9)
			->where('application_value.dropout_reason', "Left for third country");
		if (!empty($gender)) {
			$Leftforthirdcountry->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$Leftforthirdcountry->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$Leftforthirdcountry->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$Leftforthirdcountry->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$Leftforthirdcountry->where('application_value.gouvarnate', $governorate_filter);
		}
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$Leftforthirdcountry->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$Leftforthirdcountry->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$Leftforthirdcountry->limit(Session::get('from'))->where('application.status',8);
			/*$Leftforthirdcountry->where('application.id',"<=",Session::get('to'));*/
        }
		$Leftforthirdcountry = $Leftforthirdcountry->get()->count();

		$Otherreason = Application::select('application.id')
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', "post_test")
			->where('application.status', 9)
			->where('application_value.dropout_reason', "Other reason");
		if (!empty($gender)) {
			$Otherreason->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$Otherreason->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$Otherreason->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$Otherreason->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$Otherreason->where('application_value.gouvarnate', $governorate_filter);
		}
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$Otherreason->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$Otherreason->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$Otherreason->limit(Session::get('from'))->where('application.status',8);
			/*$Otherreason->where('application.id',"<=",Session::get('to'));*/
        }
		$Otherreason = $Otherreason->get()->count();

		$array = [
			[
				"reason" => "Child was no longer allowed to access activity",
				'visits' => $Childwasnolongerallowedtoaccessactivity,
			],
			[
				"reason" => "Child said he did not want to participate in activity any longer",
				'visits' => $Childsaidhedidnotwanttoparticipateinactivityanylonger,
			],
			[
				"reason" => "Relocation within Lebanon",
				'visits' => $RelocationwithinLebanon,
			],
			[
				"reason" => "Returned to Syria",
				'visits' => $ReturnedtoSyria,
			],
			[
				"reason" => "Left for third country",
				'visits' => $Leftforthirdcountry,
			],
			[
				"reason" => "Other reason",
				'visits' => $Otherreason,
			],
		];

		echo json_encode($array);
	}

	public function loadPartnerDropout(Request $request) {
		$formData = $request->all();
		$gender = $formData['gender'];
		$form_filter = $formData['form_filter'];
		$category_filter = $formData['category_filter'];
		$nationlity_filter = $formData['nationlity_filter'];
		$governorate_filter = $formData['governorate_filter'];
		$partner_filter = $formData['partner_filter'];
		$array = array();

		if (Auth::user()->hasrole('partner')) {

			$partners = Collector::select('collectors.user_id', 'collectors.name')
				->leftJoin('users', 'users.id', 'collectors.user_id')
				->where('users.is_active', '1')
				->where('collectors.partner_id', Auth::user()->id);
			if (!empty($partner_filter)) {
				$partners->where('users.id', $partner_filter);
			}
			$partners = $partners->get();
			$partArray = array();

			foreach ($partners as $part) {
				$count = Application::select("application.id")
					->leftJoin('application_value', 'application_value.application_id', 'application.id')
					->where('application.status', 9)
					->where('application_value.type', 'pre_test')
					->where('application.collector_id', $part->user_id);
				if (!empty($gender)) {
					$count->where('application_value.gender', $gender);
				}
				if (!empty($form_filter)) {
					$count->where('application_value.form', $form_filter);
				}

				if (!empty($category_filter)) {
					$count->where('application_value.category', $category_filter);
				}
				if (!empty($nationlity_filter)) {
					$count->where('application_value.nationality', $nationlity_filter);
				}
				if (!empty($governorate_filter)) {
					$count->where('application_value.gouvarnate', $governorate_filter);
				}
				if (Session::has('year') && !empty(Session::get('year'))) {
					$count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
				}
				if((Session::has('from') && !empty(Session::get('from')))){
					$count->limit(Session::get('from'))->where('application.status',8);
					/*$count->where('application.id',"<=",Session::get('to'));*/
		        }
				$count = $count->get()->count();
				$partArray = [
					'partner' => $part->name,
					'count' => $count,
				];
				array_push($array, $partArray);
			}
		} else {

			$partners = Partner::select('partners.user_id', 'partners.name')
				->leftJoin('users', 'users.id', 'partners.user_id')
				->where('is_active', '1');

			if (!empty($partner_filter)) {
				$partners->where('users.id', $partner_filter);
			}

			$partners = $partners->get();

			$partArray = array();
			foreach ($partners as $part) {
				$collectors = Collector::select('user_id')->where('partner_id', $part->user_id)->get()->toArray();
				$count = Application::select("application.id", "gender")
					->leftJoin('application_value', 'application_value.application_id', 'application.id')
					->where('application.status', 9)
					->where('application_value.type', 'pre_test')
					->whereIn('application.collector_id', $collectors);

				if (!empty($gender)) {
					$count->where('application_value.gender', $gender);
				}
				if (!empty($form_filter)) {
					$count->where('application_value.form', $form_filter);
				}

				if (!empty($category_filter)) {
					$count->where('application_value.category', $category_filter);
				}
				if (!empty($nationlity_filter)) {
					$count->where('application_value.nationality', $nationlity_filter);
				}
				if (!empty($governorate_filter)) {
					$count->where('application_value.gouvarnate', $governorate_filter);
				}
				if (Session::has('year') && !empty(Session::get('year'))) {
					$count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
				}
				if((Session::has('from') && !empty(Session::get('from')))){
					$count->limit(Session::get('from'))->where('application.status',8);
					/*$count->where('application.id',"<=",Session::get('to'));*/
		        }
				$count = $count->get()->count();
				// $count = $count->get()->toArray();
				// $count = count($count);
				$partArray = [
					'partner' => $part->name,
					'count' => $count,
				];
				array_push($array, $partArray);
			}
		}

		//  echo "<pre>";
		// print_r($array);
		// exit;

		echo json_encode($array);
	}

	public function noramlComparison() {
		$data['gouvernates'] = Gouvernate::all();

		if (Auth::user()->hasrole('partner')) {
			// $data['partner'] = Collector::select(['collectors.user_id as id', 'users.firstname as firstname'])
			// 	->leftjoin('users', 'users.id', '=', 'collectors.user_id')
			// 	->where('collectors.partner_id', Auth::user()->id)->get();

			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 3)->get();
		} else {
			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 2)->get();
		}
		return view('admin.reports.normal_comparision', $data);
	}

	public function age_6_11() {
		$age = "Form 6-11";
		return view('admin.reports.age', compact('age'));
	}

	public function age_12_17() {
		$age = "Form 12-17";
		return view('admin.reports.age', compact('age'));
	}

	public function loadNoramlComparison(Request $request) {
		$formData = $request->all();

		$gender = $formData['gender'];
		$form_filter = $formData['form_filter'];
		$category_filter = $formData['category_filter'];
		$nationlity_filter = $formData['nationlity_filter'];
		$governorate_filter = $formData['governorate_filter'];
		$partner_filter = $formData['partner_filter'];

		$pre_emotional_scale = Application::select(DB::raw('AVG(application_value.emotional_scale) as emotional_scale'))
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "pre_test");
		if (!empty($gender)) {
			$pre_emotional_scale->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$pre_emotional_scale->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$pre_emotional_scale->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$pre_emotional_scale->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$pre_emotional_scale->where('application_value.gouvarnate', $governorate_filter);
		}
		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$pre_emotional_scale->whereIn('application.collector_id', $collectors);
		}

		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();

			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}
			$pre_emotional_scale->whereIn('application.collector_id', $collectors);
		}

		if (Session::has('year') && !empty(Session::get('year'))) {
			$pre_emotional_scale->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$pre_emotional_scale->limit(Session::get('from'))->where('application.status',8);
			/*$pre_emotional_scale->where('application.id',"<=",Session::get('to'));*/
        }
		if (isset($formData['age']) && !empty($formData['age'])) {
			$pre_emotional_scale->where('application_value.form', $formData['age']);
		}
		$post_emotional_scale = Application::select(DB::raw('AVG(application_value.emotional_scale) as emotional_scale'))
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "post_test");
		if (!empty($gender)) {
			$post_emotional_scale->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$post_emotional_scale->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$post_emotional_scale->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$post_emotional_scale->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$post_emotional_scale->where('application_value.gouvarnate', $governorate_filter);
		}
		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$post_emotional_scale->whereIn('application.collector_id', $collectors);
		}
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();

			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}
			$post_emotional_scale->whereIn('application.collector_id', $collectors);
		}

		if (Session::has('year') && !empty(Session::get('year'))) {
			$post_emotional_scale->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$post_emotional_scale->limit(Session::get('from'))->where('application.status',8);
			/*$post_emotional_scale->where('application.id',"<=",Session::get('to'));*/
        }
		if (isset($formData['age']) && !empty($formData['age'])) {
			$post_emotional_scale->where('application_value.form', $formData['age']);
		}
		$pre_emotional_scale = $pre_emotional_scale->first();
		$post_emotional_scale = $post_emotional_scale->first();

		$pre_conduct_scale = Application::select(DB::raw('AVG(application_value.conduct_scale) as conduct_scale'))
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "pre_test");
		if (!empty($gender)) {
			$pre_conduct_scale->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$pre_conduct_scale->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$pre_conduct_scale->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$pre_conduct_scale->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$pre_conduct_scale->where('application_value.gouvarnate', $governorate_filter);
		}
		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$pre_conduct_scale->whereIn('application.collector_id', $collectors);
		}
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();

			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}
			$pre_conduct_scale->whereIn('application.collector_id', $collectors);
		}
		// if (Auth::user()->hasrole('partner')) {
		// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
		// 	$pre_conduct_scale->whereIn('application.collector_id', $collectors);
		// }
		if (Session::has('year') && !empty(Session::get('year'))) {
			$pre_conduct_scale->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$pre_conduct_scale->limit(Session::get('from'))->where('application.status',8);
			/*$pre_conduct_scale->where('application.id',"<=",Session::get('to'));*/
        }
		if (isset($formData['age']) && !empty($formData['age'])) {
			$pre_conduct_scale->where('application_value.form', $formData['age']);
		}
		$post_conduct_scale = Application::select(DB::raw('AVG(application_value.conduct_scale) as conduct_scale'))
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "post_test");
		if (!empty($gender)) {
			$post_conduct_scale->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$post_conduct_scale->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$post_conduct_scale->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$post_conduct_scale->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$post_conduct_scale->where('application_value.gouvarnate', $governorate_filter);
		}
		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$post_conduct_scale->whereIn('application.collector_id', $collectors);
		}
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();

			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}
			$post_conduct_scale->whereIn('application.collector_id', $collectors);
		}
		// if (Auth::user()->hasrole('partner')) {
		// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
		// 	$post_conduct_scale->whereIn('application.collector_id', $collectors);
		// }
		if (Session::has('year') && !empty(Session::get('year'))) {
			$post_conduct_scale->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$post_conduct_scale->limit(Session::get('from'))->where('application.status',8);
			/*$post_conduct_scale->where('application.id',"<=",Session::get('to'));*/
        }
		if (isset($formData['age']) && !empty($formData['age'])) {
			$post_conduct_scale->where('application_value.form', $formData['age']);
		}
		$pre_conduct_scale = $pre_conduct_scale->first();
		$post_conduct_scale = $post_conduct_scale->first();

		$pre_hyper_activity_scale = Application::select(DB::raw('AVG(application_value.hyper_activity_scale) as hyper_activity_scale'))
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "pre_test");
		if (!empty($gender)) {
			$pre_hyper_activity_scale->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$pre_hyper_activity_scale->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$pre_hyper_activity_scale->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$pre_hyper_activity_scale->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$pre_hyper_activity_scale->where('application_value.gouvarnate', $governorate_filter);
		}
		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$pre_hyper_activity_scale->whereIn('application.collector_id', $collectors);
		}
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();

			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}
			$pre_hyper_activity_scale->whereIn('application.collector_id', $collectors);
		}

		// if (Auth::user()->hasrole('partner')) {
		// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
		// 	$pre_hyper_activity_scale->whereIn('application.collector_id', $collectors);
		// }
		if (Session::has('year') && !empty(Session::get('year'))) {
			$pre_hyper_activity_scale->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$pre_hyper_activity_scale->limit(Session::get('from'))->where('application.status',8);
			/*$pre_hyper_activity_scale->where('application.id',"<=",Session::get('to'));*/
        }
		if (isset($formData['age']) && !empty($formData['age'])) {
			$pre_hyper_activity_scale->where('application_value.form', $formData['age']);
		}
		$post_hyper_activity_scale = Application::select(DB::raw('AVG(application_value.hyper_activity_scale) as hyper_activity_scale'))
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "post_test");
		if (!empty($gender)) {
			$post_hyper_activity_scale->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$post_hyper_activity_scale->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$post_hyper_activity_scale->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$post_hyper_activity_scale->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$post_hyper_activity_scale->where('application_value.gouvarnate', $governorate_filter);
		}
		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$post_hyper_activity_scale->whereIn('application.collector_id', $collectors);
		}
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();

			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}
			$post_hyper_activity_scale->whereIn('application.collector_id', $collectors);
		}
		// if (Auth::user()->hasrole('partner')) {
		// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
		// 	$post_hyper_activity_scale->whereIn('application.collector_id', $collectors);
		// }
		if (Session::has('year') && !empty(Session::get('year'))) {
			$post_hyper_activity_scale->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$post_hyper_activity_scale->limit(Session::get('from'))->where('application.status',8);
			/*$post_hyper_activity_scale->where('application.id',"<=",Session::get('to'));*/
        }
		if (isset($formData['age']) && !empty($formData['age'])) {
			$post_hyper_activity_scale->where('application_value.form', $formData['age']);
		}
		$pre_hyper_activity_scale = $pre_hyper_activity_scale->first();
		$post_hyper_activity_scale = $post_hyper_activity_scale->first();

		$pre_peer_problem_scale = Application::select(DB::raw('AVG(application_value.peer_problem_scale) as peer_problem_scale'))
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "pre_test");
		if (!empty($gender)) {
			$pre_peer_problem_scale->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$pre_peer_problem_scale->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$pre_peer_problem_scale->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$pre_peer_problem_scale->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$pre_peer_problem_scale->where('application_value.gouvarnate', $governorate_filter);
		}
		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$pre_peer_problem_scale->whereIn('application.collector_id', $collectors);
		}
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();

			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}
			$pre_peer_problem_scale->whereIn('application.collector_id', $collectors);
		}
		// if (Auth::user()->hasrole('partner')) {
		// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
		// 	$pre_peer_problem_scale->whereIn('application.collector_id', $collectors);
		// }
		if (Session::has('year') && !empty(Session::get('year'))) {
			$pre_peer_problem_scale->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$pre_peer_problem_scale->limit(Session::get('from'))->where('application.status',8);
			/*$pre_peer_problem_scale->where('application.id',"<=",Session::get('to'));*/
        }
		if (isset($formData['age']) && !empty($formData['age'])) {
			$pre_peer_problem_scale->where('application_value.form', $formData['age']);
		}
		$post_peer_problem_scale = Application::select(DB::raw('AVG(application_value.peer_problem_scale) as peer_problem_scale'))
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "post_test");
		if (!empty($gender)) {
			$post_peer_problem_scale->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$post_peer_problem_scale->where('application_value.form', $form_filter);
		}

		if (!empty($category_filter)) {
			$post_peer_problem_scale->where('application_value.category', $category_filter);
		}
		if (!empty($nationlity_filter)) {
			$post_peer_problem_scale->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$post_peer_problem_scale->where('application_value.gouvarnate', $governorate_filter);
		}
		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$post_peer_problem_scale->whereIn('application.collector_id', $collectors);
		}
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();

			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}
			$post_peer_problem_scale->whereIn('application.collector_id', $collectors);
		}
		// if (Auth::user()->hasrole('partner')) {
		// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
		// 	$post_peer_problem_scale->whereIn('application.collector_id', $collectors);
		// }
		if (Session::has('year') && !empty(Session::get('year'))) {
			$post_peer_problem_scale->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$post_peer_problem_scale->limit(Session::get('from'))->where('application.status',8);
			/*$post_peer_problem_scale->where('application.id',"<=",Session::get('to'));*/
        }
		if (isset($formData['age']) && !empty($formData['age'])) {
			$post_peer_problem_scale->where('application_value.form', $formData['age']);
		}
		$pre_peer_problem_scale = $pre_peer_problem_scale->first();
		$post_peer_problem_scale = $post_peer_problem_scale->first();

		$array = [
			[
				"reason" => "Emotional Scale",
				'pre_test' => $pre_emotional_scale->emotional_scale != "" || $pre_emotional_scale->emotional_scale != null ? $pre_emotional_scale->emotional_scale : 0,
				"static" => 3,
				"post_test" => $post_emotional_scale->emotional_scale != "" || $post_emotional_scale->emotional_scale != null ? $post_emotional_scale->emotional_scale : 0,
			],
			[
				"reason" => "Consuct Scale",
				'pre_test' => $pre_conduct_scale->conduct_scale != "" || $pre_conduct_scale->conduct_scale != null ? $pre_conduct_scale->conduct_scale : 0,
				"static" => 3,
				"post_test" => $post_conduct_scale->conduct_scale != "" || $post_conduct_scale->conduct_scale != null ? $post_conduct_scale->conduct_scale : 0,
			],
			[
				"reason" => "Hyper activity Scale",
				'pre_test' => $pre_hyper_activity_scale->hyper_activity_scale != "" || $pre_hyper_activity_scale->hyper_activity_scale != null ? $pre_hyper_activity_scale->hyper_activity_scale : 0,
				"static" => 3,
				"post_test" => $post_hyper_activity_scale->hyper_activity_scale != "" || $post_hyper_activity_scale->hyper_activity_scale != null ? $post_hyper_activity_scale->hyper_activity_scale : 0,
			],
			[
				"reason" => "Peer Scale",
				'pre_test' => $pre_peer_problem_scale->peer_problem_scale != "" || $pre_peer_problem_scale->peer_problem_scale != null ? $pre_peer_problem_scale->peer_problem_scale : 0,
				"static" => 3,
				"post_test" => $post_peer_problem_scale->peer_problem_scale != "" || $post_peer_problem_scale->peer_problem_scale != null ? $post_peer_problem_scale->peer_problem_scale : 0,
			],
		];

		echo json_encode($array);
	}

	public function partnerAnalysys() {
		if (Auth::user()->hasrole('partner')) {
			$title = "Collector";
		} else {
			$title = "Partner";
		}
		if (Auth::user()->hasrole('partner')) {
			$partner = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 3)->get();
		} else {
			$partner = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 2)->get();
		}
		return view('admin.reports.partner_analysys', compact('title', 'partner'));
	}

	public function loadPartnerAnalysys(Request $request) {
		$formData = $request->all();

		$gender = isset($formData['gender']) ? $formData['gender'] : '';
		$form_filter = isset($formData['form_filter']) ? $formData['form_filter'] : '';
		$nationlity_filter = isset($formData['nationlity_filter']) ? $formData['nationlity_filter'] : '';
		$partner_filter = isset($formData['partner_filter']) ? $formData['partner_filter'] : '';

		$array = array();
		$governate = Gouvernate::all();
		if (Auth::user()->hasrole('partner')) {
			$partners = Collector::select('collectors.user_id', 'collectors.name')
				->leftJoin('users', 'users.id', 'collectors.user_id')
				->where('users.is_active', '1');
			if (!empty($partner_filter)) {
				$partners->where('collectors.partner_id', $partner_filter);
			} else {
				$partners->where('collectors.partner_id', Auth::user()->id);
			}

			$partners = $partners->get();
			foreach ($partners as $part) {
				$govArray = [
					'part' => $part->name,
				];
				$partArray = array();
				foreach ($governate as $gov) {
					$count = Application::select("application.id")
						->leftJoin('application_value', 'application_value.application_id', 'application.id')
						->where('application.status', 8)
						->where('application_value.type', "pre_test")
						->where('application_value.gouvarnate', $gov->id)
						->where('application.collector_id', $part->user_id);
					if (!empty($gender)) {
						$count->where('application_value.gender', $gender);
					}
					if (!empty($form_filter)) {
						$count->where('application_value.form', $form_filter);
					}
					if (!empty($nationlity_filter)) {
						$count->where('application_value.nationality', $nationlity_filter);
					}
					if (Session::has('year') && !empty(Session::get('year'))) {
						$count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
					}
					if((Session::has('from') && !empty(Session::get('from')))){
						$count->limit(Session::get('from'))->where('application.status',8);
						/*$count->where('application.id',"<=",Session::get('to'));*/
			        }
					$count = $count->get()->count();
					$partArray = [
						$gov->name => $count,
					];
					$govArray = array_merge($govArray, $partArray);
				}
				array_push($array, $govArray);
			}
		} else {

			// echo $partner_filter;exit;

			$partners = Partner::select('partners.user_id', 'partners.name')
				->leftJoin('users', 'users.id', 'partners.user_id')
				->where('is_active', '1');
			if (!empty($partner_filter)) {
				$partners->where('partners.user_id', $partner_filter);
			}
			$partners = $partners->get();

			foreach ($partners as $part) {
				$govArray = [
					'part' => $part->name,
				];
				$partArray = array();
				foreach ($governate as $gov) {
					$collectors = Collector::select('user_id')->where('partner_id', $part->user_id)->get()->toArray();
					$count = Application::select("application.id")
						->leftJoin('application_value', 'application_value.application_id', 'application.id')
						->where('application.status', 8)
						->where('application_value.type', "pre_test")
						->where('application_value.gouvarnate', $gov->id)
						->whereIn('application.collector_id', $collectors);
					if (!empty($gender)) {
						$count->where('application_value.gender', $gender);
					}
					if (!empty($form_filter)) {
						$count->where('application_value.form', $form_filter);
					}
					if (!empty($nationlity_filter)) {
						$count->where('application_value.nationality', $nationlity_filter);
					}

					if (Session::has('year') && !empty(Session::get('year'))) {
						$count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
					}
					if((Session::has('from') && !empty(Session::get('from')))){
						$count->limit(Session::get('from'))->where('application.status',8);
						/*$count->where('application.id',"<=",Session::get('to'));*/
			        }
					$count = $count->get()->count();
					$partArray = [
						$gov->name => $count,
					];
					$govArray = array_merge($govArray, $partArray);
				}
				array_push($array, $govArray);
			}
		}

		$mainArray = [
			'chartData' => $array,
			"partners" => count($governate) > 0 ? $governate->toArray() : [],
		];

		echo json_encode($mainArray);
	}

	public function loadPartnerAnalysys1(Request $request) {
		$formData = $request->all();
		$gender = $formData['gender'];
		$form_filter = $formData['form_filter'];
		$nationlity_filter = $formData['nationlity_filter'];
		$partner_filter = isset($formData['partner_filter']) ? $formData['partner_filter'] : '';
		if (Auth::user()->hasrole('partner')) {
			$partners = Collector::select('collectors.user_id', 'collectors.name')
				->leftJoin('users', 'users.id', 'collectors.user_id')
				->where('users.is_active', '1');
			// ->where('collectors.partner_id', Auth::user()->id)
			if (!empty($partner_filter)) {
				$partners->where('collectors.partner_id', $partner_filter);
			} else {
				$partners->where('collectors.partner_id', Auth::user()->id);
			}
			$partners = $partners->get();
			$mainArray = array();
			foreach ($partners as $part) {
				$count = Application::select("application.id")
					->leftJoin('application_value', 'application_value.application_id', 'application.id')
					->where('application.status', 8)
					->where('application_value.type', "pre_test")
					->where('application.collector_id', $part->user_id);
				if (!empty($gender)) {
					$count->where('application_value.gender', $gender);
				}
				if (!empty($form_filter)) {
					$count->where('application_value.form', $form_filter);
				}
				if (!empty($nationlity_filter)) {
					$count->where('application_value.nationality', $nationlity_filter);
				}
				if (Session::has('year') && !empty(Session::get('year'))) {
					$count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
				}
				if((Session::has('from') && !empty(Session::get('from')))){
					$count->limit(Session::get('from'))->where('application.status',8);
					/*$count->where('application.id',"<=",Session::get('to'));*/
		        }
				$count = $count->get()->count();
				$partArray = [
					"partner" => $part->name,
					'count' => $count,
				];
				array_push($mainArray, $partArray);
			}
		} else {
			$partners = Partner::select('partners.user_id', 'partners.name')->leftJoin('users', 'users.id', 'partners.user_id')->where('is_active', '1');
			if (!empty($partner_filter)) {
				$partners->where('partners.user_id', $partner_filter);
			}
			$partners = $partners->get();
			$mainArray = array();
			foreach ($partners as $part) {
				$collectors = Collector::select('user_id')->where('partner_id', $part->user_id)->get()->toArray();
				$count = Application::select("application.id")
					->leftJoin('application_value', 'application_value.application_id', 'application.id')
					->where('application.status', 8)
					->where('application_value.type', "pre_test")
					->whereIn('application.collector_id', $collectors);
				if (!empty($gender)) {
					$count->where('application_value.gender', $gender);
				}
				if (!empty($form_filter)) {
					$count->where('application_value.form', $form_filter);
				}
				if (!empty($nationlity_filter)) {
					$count->where('application_value.nationality', $nationlity_filter);
				}
				if (Session::has('year') && !empty(Session::get('year'))) {
					$count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
				}
				if((Session::has('from') && !empty(Session::get('from')))){
					$count->limit(Session::get('from'))->where('application.status',8);
					/*$count->where('application.id',"<=",Session::get('to'));*/
		        }
				$count = $count->get()->count();
				$partArray = [
					"partner" => $part->name,
					'count' => $count,
				];
				array_push($mainArray, $partArray);
			}
		}
		echo json_encode($mainArray);
	}

	public function govAnalysys() {

		if (Auth::user()->hasrole('partner')) {
			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 3)->get();
		} else {
			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 2)->get();
		}
		return view('admin.reports.gov_analysys', $data);
	}

	public function loadGovAnalysys(Request $request) {
		$formData = $request->all();

		$gender_com_gov = isset($formData['gender_com_gov']) ? $formData['gender_com_gov'] : '';
		$nationality_com_gov = isset($formData['nationality_com_gov']) ? $formData['nationality_com_gov'] : '';
		$age_com_gov = isset($formData['age_com_gov']) ? $formData['age_com_gov'] : '';
		$gender_com_partner = isset($formData['gender_com_partner']) ? $formData['gender_com_partner'] : '';

		$governate = Gouvernate::all();
		$mainArray = array();
		foreach ($governate as $gov) {
			$count = Application::select("application.id")
				->leftJoin('application_value', 'application_value.application_id', 'application.id')
				->where('application.status', 8)
				->where('application_value.type', "pre_test")
				->where('application_value.gouvarnate', $gov->id);

			if (!empty($gender_com_gov)) {
				$count->where('application_value.gender', $gender_com_gov);
			}
			if (!empty($age_com_gov)) {
				$count->where('application_value.form', $age_com_gov);
			}
			if (!empty($nationality_com_gov)) {
				$count->where('application_value.nationality', $nationality_com_gov);
			}

			if (Session::has('year') && !empty(Session::get('year'))) {
				$count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
			}

			if (!empty($gender_com_partner)) {
				$collectors = Collector::select('user_id')->where('partner_id', $gender_com_partner)->get()->toArray();
				$count->whereIn('application.collector_id', $collectors);
			}

			if (Auth::user()->hasrole('partner')) {
				if (!empty($partner_filter)) {
					$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
				} else {
					$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
				}

				$count->whereIn('application.collector_id', $collectors);
			}
			if((Session::has('from') && !empty(Session::get('from')))){
				$count->limit(Session::get('from'))->where('application.status',8);
				/*$count->where('application.id',"<=",Session::get('to'));*/
	        }

			// if (Auth::user()->hasrole('partner')) {
			// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			// 	$count->whereIn('application.collector_id', $collectors);
			// }
			$count = $count->get()->count();
			$partArray = [
				"gov" => $gov->name,
				'count' => $count,
			];
			array_push($mainArray, $partArray);
		}
		echo json_encode($mainArray);
	}
	public function loadGovAnalysys1(Request $request) {
		$formData = $request->all();

		$gender_mean_des_gov = isset($formData['gender_mean_des_gov']) ? $formData['gender_mean_des_gov'] : '';
		$nationality_mean_des_gov = isset($formData['nationality_mean_des_gov']) ? $formData['nationality_mean_des_gov'] : '';
		$age_mean_des_gov = isset($formData['age_mean_des_gov']) ? $formData['age_mean_des_gov'] : '';

		$partner_mean_des_gov = isset($formData['partner_mean_des_gov']) ? $formData['partner_mean_des_gov'] : '';

		$governate = Gouvernate::all();
		$mainArray = array();
		foreach ($governate as $gov) {
			$pre_count = Application::select(DB::raw('AVG(application_value.score) as score'))
				->leftJoin('application_value', 'application_value.application_id', 'application.id')
				->where('application.status', 8)
				->where('application_value.type', "pre_test")
				->where('application_value.gouvarnate', $gov->id);

			if (!empty($gender_mean_des_gov)) {
				$pre_count->where('application_value.gender', $gender_mean_des_gov);
			}
			if (!empty($age_mean_des_gov)) {
				$pre_count->where('application_value.form', $age_mean_des_gov);
			}
			if (!empty($nationality_mean_des_gov)) {
				$pre_count->where('application_value.nationality', $nationality_mean_des_gov);
			}

			if (isset($formData['age']) && !empty($formData['age'])) {
				$pre_count->where('application_value.form', $formData['age']);
			}
			if (Session::has('year') && !empty(Session::get('year'))) {
				$pre_count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
			}
			if((Session::has('from') && !empty(Session::get('from')))){
				$pre_count->limit(Session::get('from'))->where('application.status',8);
				/*$pre_count->where('application.id',"<=",Session::get('to'));*/
	        }

			if (!empty($partner_mean_des_gov)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_mean_des_gov)->get()->toArray();
				$pre_count->whereIn('application.collector_id', $collectors);
			}

			if (Auth::user()->hasrole('partner')) {
				if (!empty($partner_mean_des_gov)) {
					$collectors = Collector::select('user_id')->where('partner_id', $partner_mean_des_gov)->get()->toArray();
				} else {
					$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
				}

				$pre_count->whereIn('application.collector_id', $collectors);
			}

			// if (Auth::user()->hasrole('partner')) {
			// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			// 	$pre_count->whereIn('application.collector_id', $collectors);
			// }
			$pre_count = $pre_count->first();
			$post_count = Application::select(DB::raw('AVG(application_value.score) as score'))
				->leftJoin('application_value', 'application_value.application_id', 'application.id')
				->where('application.status', 8)
				->where('application_value.type', "post_test")
				->where('application_value.gouvarnate', $gov->id);
			if (!empty($gender_mean_des_gov)) {
				$post_count->where('application_value.gender', $gender_mean_des_gov);
			}
			if (!empty($age_mean_des_gov)) {
				$post_count->where('application_value.form', $age_mean_des_gov);
			}
			if (!empty($nationality_mean_des_gov)) {
				$post_count->where('application_value.nationality', $nationality_mean_des_gov);
			}

			if (isset($formData['age']) && !empty($formData['age'])) {
				$post_count->where('application_value.form', $formData['age']);
			}
			if (Session::has('year') && !empty(Session::get('year'))) {
				$post_count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
			}
			if((Session::has('from') && !empty(Session::get('from')))){
				$post_count->limit(Session::get('from'))->where('application.status',8);
				/*$post_count->where('application.id',"<=",Session::get('to'));*/
	        }
			if (!empty($partner_mean_des_gov)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_mean_des_gov)->get()->toArray();
				$post_count->whereIn('application.collector_id', $collectors);
			}

			if (Auth::user()->hasrole('partner')) {
				if (!empty($partner_mean_des_gov)) {
					$collectors = Collector::select('user_id')->where('partner_id', $partner_mean_des_gov)->get()->toArray();
				} else {
					$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
				}

				$post_count->whereIn('application.collector_id', $collectors);
			}
			// if (Auth::user()->hasrole('partner')) {
			// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			// 	$post_count->whereIn('application.collector_id', $collectors);
			// }
			$post_count = $post_count->first();
			$partArray = [
				"gov" => $gov->name,
				'pre_test' => isset($pre_count->score) && !empty($pre_count->score) ? $pre_count->score : 0,
				'post_test' => isset($post_count->score) && !empty($post_count->score) ? $post_count->score : 0,
			];
			array_push($mainArray, $partArray);
		}
		echo json_encode($mainArray);
	}

	public function increaseScale() {
		$data['gouvernates'] = Gouvernate::all();

		if (Auth::user()->hasrole('partner')) {
			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 3)->get();
		} else {
			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 2)->get();
		}
		return view('admin.reports.increase_scale', $data);
	}

	public function loadIncreaseScale(Request $request) {
		$formData = $request->all();

		$gender_filter = isset($formData['gender']) ? $formData['gender'] : '';
		$form_filter = isset($formData['form_filter']) ? $formData['form_filter'] : '';
		$nationality_filter = isset($formData['nationlity_filter']) ? $formData['nationlity_filter'] : '';
		$governorate_filter = isset($formData['governorate_filter']) ? $formData['governorate_filter'] : '';
		$partner_filter = isset($formData['partner_filter']) ? $formData['partner_filter'] : '';
		$scale_filter = isset($formData['scale_filter']) ? $formData['scale_filter'] : '';

		$scale = $formData['scale'];
		$preTest = Application::leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "pre_test");

		if (!empty($gender_filter)) {
			$preTest->where('application_value.gender', $gender_filter);
		}
		if (!empty($form_filter)) {
			$preTest->where('application_value.form', $form_filter);
		}
		if (!empty($nationality_filter)) {
			$preTest->where('application_value.nationality', $nationality_filter);
		}
		if (!empty($governorate_filter)) {
			$preTest->where('application_value.gouvarnate', $governorate_filter);
		}

		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$preTest->whereIn('application.collector_id', $collectors);
		}

		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}

			$preTest->whereIn('application.collector_id', $collectors);
		}
		if (isset($formData['form']) && !empty($formData['form'])) {
			$preTest->where('application_value.form', $formData['form']);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$preTest->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$preTest->limit(Session::get('from'))->where('application.status',8);
			/*$preTest->where('application.id',"<=",Session::get('to'));*/
        }

		$preTest = $preTest->get();
		$increaseScale = 0;
		$decreaseScale = 0;
		$sameScale = 0;
		$total = 0;
		foreach ($preTest as $pre) {
			$postTest = Application::leftJoin('application_value', 'application_value.application_id', 'application.id')
				->where('application.status', 8)
				->where('application_value.type', "post_test")
				->where('application_value.application_id', $pre->application_id)
				->first();
			if (isset($pre->$scale) && !empty($pre->$scale)) {
				$finalpreTestScore = intval($pre->$scale);
			}
			if (isset($postTest->$scale) && !empty($postTest->$scale)) {
				$finalpostTestScore = intval($postTest->$scale);
			}
			if (isset($finalpreTestScore) && !empty($finalpreTestScore) && isset($finalpostTestScore) && !empty($finalpostTestScore)) {
				if ($finalpostTestScore > $finalpreTestScore) {
					$decreaseScale++;
				} elseif ($finalpostTestScore < $finalpreTestScore) {
					$increaseScale++;
				} elseif ($finalpostTestScore == $finalpreTestScore) {
					$sameScale++;
				} else {
					$increaseScale++;
				}
			} else {
				$increaseScale++;
			}
		}

		$array = [
			[
				"type" => "Increase",
				'count' => $increaseScale,
			],
			[
				"type" => "Decrease",
				'count' => $decreaseScale,
			],
			[
				"type" => "Same",
				'count' => $sameScale,
			],
			[
				"type" => "Total",
				'count' => $total,
			],
		];

		echo json_encode($array);
	}

	public function uncompletedPerNgo(Request $request) {
		if (Auth::user()->hasrole('partner')) {
			$title = "Collector";
		} else {
			$title = "Partner";
		}
		return view('admin.reports.uncompleted_per_ngo', compact('title'));
	}

	public function loaduncompletedPerNgo(Request $request) {
		$formData = $request->all();
		$array = array();
		if (Auth::user()->hasrole('partner')) {
			$partners = Collector::select('collectors.user_id', 'collectors.name')
				->leftJoin('users', 'users.id', 'collectors.user_id')
				->where('users.is_active', '1')
				->where('collectors.partner_id', Auth::user()->id)
				->get();
			$partArray = array();
			foreach ($partners as $part) {
				$collectors = Collector::select('user_id')->where('partner_id', $part->user_id)->get()->toArray();
				$count = Application::select("application.id")
					->where('application.pre_test_date', "!=", "")
					->where('application.post_test_date', null)
					->where('application.status', '<', 8)
					->where('application.collector_id', $part->user_id);
				if (Session::has('year') && !empty(Session::get('year'))) {
					$count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
				}
				if((Session::has('from') && !empty(Session::get('from')))){
					$count->limit(Session::get('from'))->where('application.status',8);
					/*$count->where('application.id',"<=",Session::get('to'));*/
		        }
				$count = $count->get()->count();
				$partArray = [
					'partner' => $part->name,
					'count' => $count,
				];
				array_push($array, $partArray);
			}
		} else {
			$partners = Partner::select('partners.user_id', 'partners.name')
				->leftJoin('users', 'users.id', 'partners.user_id')
				->where('is_active', '1')
				->get();
			$partArray = array();
			foreach ($partners as $part) {
				$collectors = Collector::select('user_id')->where('partner_id', $part->user_id)->get()->toArray();
				$count = Application::select("application.id")
					->where('application.pre_test_date', "!=", "")
					->where('application.post_test_date', null)
					->where('application.status', '<', 8)
					->whereIn('application.collector_id', $collectors);
				if (Session::has('year') && !empty(Session::get('year'))) {
					$count->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
				}
				if((Session::has('from') && !empty(Session::get('from')))){
					$count->limit(Session::get('from'))->where('application.status',8);
					/*$count->where('application.id',"<=",Session::get('to'));*/
		        }
				$count = $count->get()->count();
				$partArray = [
					'partner' => $part->name,
					'count' => $count,
				];
				array_push($array, $partArray);
			}
		}

		echo json_encode($array);
	}

	public function analysisData(Request $request) {
		$data = array();
		$age1_14Array = array();
		$age15_30Array = array();
		$age31_40Array = array();
		$age41_50Array = array();
		$age51_60Array = array();
		$age61_70Array = array();
		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [1, 14]);
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age1_14Array = [
			'hours' => "1-14",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age1_14Array['increase'] = $age1_14Array['increase'] + 1;
				}
			}
		}
		$age1_14Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age1_14Array['welbeing'] = $age1_14Array['children'] > 0 ? ($age1_14Array['increase'] / $age1_14Array['children']) * 100 : $age1_14Array['children'];
		array_push($data, $age1_14Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [15, 30]);
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age15_30Array = [
			'hours' => "15-30",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age15_30Array['increase'] = $age15_30Array['increase'] + 1;
				}
			}
		}
		$age15_30Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age15_30Array['welbeing'] = $age15_30Array['children'] > 0 ? ($age15_30Array['increase'] / $age15_30Array['children']) * 100 : 0;
		array_push($data, $age15_30Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [31, 40]);
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age31_40Array = [
			'hours' => "31-40",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age31_40Array['increase'] = $age31_40Array['increase'] + 1;
				}
			}
		}
		$age31_40Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age31_40Array['welbeing'] = $age31_40Array['children'] > 0 ? ($age31_40Array['increase'] / $age31_40Array['children']) * 100 : 0;
		array_push($data, $age31_40Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [41, 50]);
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age41_50Array = [
			'hours' => "41-50",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age41_50Array['increase'] = $age41_50Array['increase'] + 1;
				}
			}
		}
		$age41_50Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age41_50Array['welbeing'] = $age41_50Array['children'] > 0 ? ($age41_50Array['increase'] / $age41_50Array['children']) * 100 : 0;
		array_push($data, $age41_50Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [51, 60]);
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age51_60Array = [
			'hours' => "51-60",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age51_60Array['increase'] = $age51_60Array['increase'] + 1;
				}
			}
		}
		$age51_60Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age51_60Array['welbeing'] = $age51_60Array['children'] > 0 ? ($age51_60Array['increase'] / $age51_60Array['children']) * 100 : 0;
		array_push($data, $age51_60Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [61, 70]);
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age61_70Array = [
			'hours' => "61-70",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age61_70Array['increase'] = $age61_70Array['increase'] + 1;
				}
			}
		}
		$age61_70Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age61_70Array['welbeing'] = $age61_70Array['children'] > 0 ? ($age61_70Array['increase'] / $age61_70Array['children']) * 100 : 0;
		array_push($data, $age61_70Array);

		$govArray = array();
		$governate = Gouvernate::all();
		foreach ($governate as $gov) {
			$govSubArray = array();
			$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
				->leftjoin('application_value', 'application_value.application_id', 'application.id')
				->where('application_value.type', 'post_test')
				->where('application_value.gouvarnate', $gov->id);
			if (Auth::user()->hasrole('partner')) {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
				$application->whereIn('application.collector_id', $collectors);
			}
			$application = $application->get();
			$govSubArray = [
				'gov' => $gov->name,
				'children' => count($application),
				'increase' => 0,
			];
			$childAttended = 0;
			$totalHours = 0;
			foreach ($application as $app) {
				$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
				$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
				$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
				$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

				if (!empty($preTest)) {
					$finalpreTestScore = 0;
					if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
					}
					if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
					}
					if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
					}
					if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
					}
				}

				if (!empty($postTest)) {
					$finalpostTestScore = 0;
					if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
						$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
					}
					if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
						$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
					}
					if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
						$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
					}
					if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
						$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
					}
				}
				if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
					if ($finalpostTestScore < $finalpreTestScore) {
						$govSubArray['increase'] = $govSubArray['increase'] + 1;
					}
				}
			}
			$govSubArray['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
			$govSubArray['welbeing'] = $govSubArray['children'] > 0 ? ($govSubArray['increase'] / $govSubArray['children']) * 100 : $govSubArray['children'];
			array_push($govArray, $govSubArray);
		}

		$gouvernates = Gouvernate::all();

		if (Auth::user()->hasrole('partner')) {
			$partner = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 3)->get();
		} else {
			$partner = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 2)->get();
		}

		return view('admin.reports.analysis_data', compact('data', 'govArray', 'gouvernates', 'partner'));
	}

	public function loadSdqAnalysisAjax(Request $request) {
		$formData = $request->all();

		// echo "<pre>";
		// print_r($formData);
		// exit;
		$gender = isset($formData['gender']) ? $formData['gender'] : '';
		$form_filter = isset($formData['form_filter']) ? $formData['form_filter'] : '';
		$nationlity_filter = isset($formData['nationlity_filter']) ? $formData['nationlity_filter'] : '';
		$governorate_filter = isset($formData['governorate_filter']) ? $formData['governorate_filter'] : '';
		$partner_filter = isset($formData['partner_filter']) ? $formData['partner_filter'] : '';

		$data = array();
		$age1_14Array = array();
		$age15_30Array = array();
		$age31_40Array = array();
		$age41_50Array = array();
		$age51_60Array = array();
		$age61_70Array = array();
		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [1, 14]);

		if (!empty($gender)) {
			$application->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$application->where('application_value.form', $form_filter);
		}
		if (!empty($nationlity_filter)) {
			$application->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$application->where('application_value.gouvarnate', $governorate_filter);
		}

		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}

		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}

			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age1_14Array = [
			'hours' => "1-14",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age1_14Array['increase'] = $age1_14Array['increase'] + 1;
				}
			}
		}
		$age1_14Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age1_14Array['welbeing'] = $age1_14Array['children'] > 0 ? ($age1_14Array['increase'] / $age1_14Array['children']) * 100 : $age1_14Array['children'];
		array_push($data, $age1_14Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [15, 30]);
		if (!empty($gender)) {
			$application->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$application->where('application_value.form', $form_filter);
		}
		if (!empty($nationlity_filter)) {
			$application->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$application->where('application_value.gouvarnate', $governorate_filter);
		}

		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}

			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age15_30Array = [
			'hours' => "15-30",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age15_30Array['increase'] = $age15_30Array['increase'] + 1;
				}
			}
		}
		$age15_30Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age15_30Array['welbeing'] = $age15_30Array['children'] > 0 ? ($age15_30Array['increase'] / $age15_30Array['children']) * 100 : 0;
		array_push($data, $age15_30Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [31, 40]);
		if (!empty($gender)) {
			$application->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$application->where('application_value.form', $form_filter);
		}
		if (!empty($nationlity_filter)) {
			$application->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$application->where('application_value.gouvarnate', $governorate_filter);
		}

		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}

			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age31_40Array = [
			'hours' => "31-40",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age31_40Array['increase'] = $age31_40Array['increase'] + 1;
				}
			}
		}
		$age31_40Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age31_40Array['welbeing'] = $age31_40Array['children'] > 0 ? ($age31_40Array['increase'] / $age31_40Array['children']) * 100 : 0;
		array_push($data, $age31_40Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [41, 50]);
		if (!empty($gender)) {
			$application->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$application->where('application_value.form', $form_filter);
		}
		if (!empty($nationlity_filter)) {
			$application->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$application->where('application_value.gouvarnate', $governorate_filter);
		}

		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}

			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age41_50Array = [
			'hours' => "41-50",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age41_50Array['increase'] = $age41_50Array['increase'] + 1;
				}
			}
		}
		$age41_50Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age41_50Array['welbeing'] = $age41_50Array['children'] > 0 ? ($age41_50Array['increase'] / $age41_50Array['children']) * 100 : 0;
		array_push($data, $age41_50Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [51, 60]);
		if (!empty($gender)) {
			$application->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$application->where('application_value.form', $form_filter);
		}
		if (!empty($nationlity_filter)) {
			$application->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$application->where('application_value.gouvarnate', $governorate_filter);
		}

		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}

			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age51_60Array = [
			'hours' => "51-60",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age51_60Array['increase'] = $age51_60Array['increase'] + 1;
				}
			}
		}
		$age51_60Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age51_60Array['welbeing'] = $age51_60Array['children'] > 0 ? ($age51_60Array['increase'] / $age51_60Array['children']) * 100 : 0;
		array_push($data, $age51_60Array);

		$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
			->leftjoin('application_value', 'application_value.application_id', 'application.id')
			->where('application_value.type', 'post_test')
			->whereBetween('application_value.total_number_of_hours_in_your_program', [61, 70]);
		if (!empty($gender)) {
			$application->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$application->where('application_value.form', $form_filter);
		}
		if (!empty($nationlity_filter)) {
			$application->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$application->where('application_value.gouvarnate', $governorate_filter);
		}

		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$application->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$application->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$application->limit(Session::get('from'))->where('application.status',8);
			/*$application->where('application.id',"<=",Session::get('to'));*/
        }
		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}

			$application->whereIn('application.collector_id', $collectors);
		}
		$application = $application->get();
		$age61_70Array = [
			'hours' => "61-70",
			'children' => count($application),
			'increase' => 0,
		];
		$childAttended = 0;
		$totalHours = 0;
		foreach ($application as $app) {
			$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
			$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
			$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

			if (!empty($preTest)) {
				$finalpreTestScore = 0;
				if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
				}
				if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
				}
				if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
				}
				if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
				}
			}

			if (!empty($postTest)) {
				$finalpostTestScore = 0;
				if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
				}
				if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
				}
				if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
				}
				if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore < $finalpreTestScore) {
					$age61_70Array['increase'] = $age61_70Array['increase'] + 1;
				}
			}
		}
		$age61_70Array['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
		$age61_70Array['welbeing'] = $age61_70Array['children'] > 0 ? ($age61_70Array['increase'] / $age61_70Array['children']) * 100 : 0;
		array_push($data, $age61_70Array);

		$govArray = array();
		$governate = Gouvernate::all();
		foreach ($governate as $gov) {
			$govSubArray = array();
			$application = Application::select('application.*', 'application_value.age', 'application_value.number_of_hours_that_the_child_attended', 'application_value.total_number_of_hours_in_your_program')
				->leftjoin('application_value', 'application_value.application_id', 'application.id')
				->where('application_value.type', 'post_test')
				->where('application_value.gouvarnate', $gov->id);
			if (!empty($gender)) {
				$application->where('application_value.gender', $gender);
			}
			if (!empty($form_filter)) {
				$application->where('application_value.form', $form_filter);
			}
			if (!empty($nationlity_filter)) {
				$application->where('application_value.nationality', $nationlity_filter);
			}
			if (!empty($governorate_filter)) {
				$application->where('application_value.gouvarnate', $governorate_filter);
			}

			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
				$application->whereIn('application.collector_id', $collectors);
			}
			if (Auth::user()->hasrole('partner')) {
				if (!empty($partner_filter)) {
					$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
				} else {
					$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
				}

				$application->whereIn('application.collector_id', $collectors);
			}
			$application = $application->get();
			$govSubArray = [
				'gov' => $gov->name,
				'children' => count($application),
				'increase' => 0,
			];
			$childAttended = 0;
			$totalHours = 0;
			foreach ($application as $app) {
				$totalHours = $totalHours + intval($app->total_number_of_hours_in_your_program);
				$childAttended = $childAttended + intval($app->number_of_hours_that_the_child_attended);
				$preTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'pre_test')->first();
				$postTest = Applicationvalue::select('emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $app->id)->where('type', 'post_test')->first();

				if (!empty($preTest)) {
					$finalpreTestScore = 0;
					if (isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)) {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
					}
					if (isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)) {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
					}
					if (isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)) {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
					}
					if (isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)) {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
					}
				}

				if (!empty($postTest)) {
					$finalpostTestScore = 0;
					if (isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)) {
						$finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
					}
					if (isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)) {
						$finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
					}
					if (isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)) {
						$finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
					}
					if (isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)) {
						$finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
					}
				}
				if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
					if ($finalpostTestScore < $finalpreTestScore) {
						$govSubArray['increase'] = $govSubArray['increase'] + 1;
					}
				}
			}
			$govSubArray['attended'] = $totalHours > 0 ? ($childAttended / $totalHours) * 100 : 0;
			$govSubArray['welbeing'] = $govSubArray['children'] > 0 ? ($govSubArray['increase'] / $govSubArray['children']) * 100 : $govSubArray['children'];
			array_push($govArray, $govSubArray);
		}

		$returnHTML = view('admin.reports.loadSdqAnalysisAjax', compact('data', 'govArray'))->render();
		return response()->json(array('success' => true, 'html' => $returnHTML));

	}

	public function analysisChange(Request $request) {

		$data['gouvernates'] = Gouvernate::all();

		if (Auth::user()->hasrole('partner')) {
			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 3)->get();
		} else {
			$data['partner'] = Partner::select(['user_id as id', 'name as firstname'])
				->join('model_has_roles', 'partners.user_id', '=', 'model_has_roles.model_id')
				->where('model_has_roles.role_id', 2)->get();
		}

		return view('admin.reports.analysis_change', $data);
	}

	public function loadanalysisChange(Request $request) {

		$formData = $request->all();
		$gender = isset($formData['gender']) ? $formData['gender'] : '';
		$form_filter = isset($formData['form_filter']) ? $formData['gender'] : '';
		$nationlity_filter = isset($formData['nationlity_filter']) ? $formData['nationlity_filter'] : '';
		$governorate_filter = isset($formData['governorate_filter']) ? $formData['governorate_filter'] : '';
		$partner_filter = isset($formData['partner_filter']) ? $formData['partner_filter'] : '';
		$service_filter = isset($formData['service_filter']) ? $formData['service_filter'] : '';

		$decreaseArray = [
			[
				"change" => "Decrease",
				'pre_test' => 0,
				"post_test" => 0,
				'count' => 0,
			],
		];
		$increaseArray = [
			[
				"change" => "Increase",
				'pre_test' => 0,
				"post_test" => 0,
				'count' => 0,
			],
		];
		$sameArray = [
			[
				"change" => "Same",
				'pre_test' => 0,
				"post_test" => 0,
				'count' => 0,
			],
		];

		$preTest = Application::leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "pre_test");

		if (!empty($gender)) {
			$preTest->where('application_value.gender', $gender);
		}
		if (!empty($form_filter)) {
			$preTest->where('application_value.form', $form_filter);
		}
		if (!empty($nationlity_filter)) {
			$preTest->where('application_value.nationality', $nationlity_filter);
		}
		if (!empty($governorate_filter)) {
			$preTest->where('application_value.gouvarnate', $governorate_filter);
		}
		// if (!empty($service_filter)) {
		// 	$preTest->where('application_value.do_the_child_receive_any_other_child_protection_services', 'like', "%" . $service_filter . "%");}

		if (!empty($partner_filter)) {
			$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			$preTest->whereIn('application.collector_id', $collectors);
		}

		if (Auth::user()->hasrole('partner')) {
			if (!empty($partner_filter)) {
				$collectors = Collector::select('user_id')->where('partner_id', $partner_filter)->get()->toArray();
			} else {
				$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			}

			$preTest->whereIn('application.collector_id', $collectors);
		}

		// if (Auth::user()->hasrole('partner')) {
		// 	$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
		// 	$preTest->whereIn('application.collector_id', $collectors);
		// }
		if (Session::has('year') && !empty(Session::get('year'))) {
			$preTest->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$preTest->limit(Session::get('from'))->where('application.status',8);
			/*$preTest->where('application.id',"<=",Session::get('to'));*/
        }
		$preTest = $preTest->get();

		foreach ($preTest as $pre) {
			$postTest = Application::leftJoin('application_value', 'application_value.application_id', 'application.id')
				->where('application.status', 8)
				->where('application_value.type', "post_test")
				->where('application_value.application_id', $pre->application_id);
			if (!empty($service_filter)) {
				$postTest = $postTest->where('application_value.do_the_child_receive_any_other_child_protection_services', 'like', "%" . $service_filter . "%");
			}
			$postTest = $postTest->first();

			if (!empty($postTest) && isset($postTest)) {

				$finalpreTestScore = floatval($pre->emotional_scale);
				$finalpostTestScore = floatval($postTest->emotional_scale);
				if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
					if ($finalpostTestScore > $finalpreTestScore) {
						$decreaseArray[0]['pre_test'] = floatval($decreaseArray[0]['pre_test']) + $finalpreTestScore;
						$decreaseArray[0]['post_test'] = floatval($decreaseArray[0]['post_test']) + $finalpostTestScore;
						$decreaseArray[0]['count'] = floatval($decreaseArray[0]['count']) + 1;
					} elseif ($finalpostTestScore < $finalpreTestScore) {
						$increaseArray[0]['pre_test'] = floatval($increaseArray[0]['pre_test']) + $finalpreTestScore;
						$increaseArray[0]['post_test'] = floatval($increaseArray[0]['post_test']) + $finalpostTestScore;
						$increaseArray[0]['count'] = floatval($increaseArray[0]['count']) + 1;
					} elseif ($finalpostTestScore == $finalpreTestScore) {
						$sameArray[0]['pre_test'] = floatval($sameArray[0]['pre_test']) + $finalpreTestScore;
						$sameArray[0]['post_test'] = floatval($sameArray[0]['post_test']) + $finalpostTestScore;
						$sameArray[0]['count'] = floatval($sameArray[0]['count']) + 1;
					} else {
						$increaseArray[0]['pre_test'] = floatval($increaseArray[0]['pre_test']) + $finalpreTestScore;
						$increaseArray[0]['post_test'] = floatval($increaseArray[0]['post_test']) + $finalpostTestScore;
						$decreaseArray[0]['count'] = floatval($decreaseArray[0]['count']) + 1;
					}
				}
			}
		}

		if (intval($decreaseArray[0]['count']) > 0) {
			$decreaseArray[0]['pre_test'] = floatval($decreaseArray[0]['pre_test']) / intval($decreaseArray[0]['count']);
			$decreaseArray[0]['post_test'] = floatval($decreaseArray[0]['post_test']) / intval($decreaseArray[0]['count']);
			unset($decreaseArray[0]['count']);
		}
		if (intval($increaseArray[0]['count']) > 0) {
			$increaseArray[0]['pre_test'] = floatval($increaseArray[0]['pre_test']) / intval($increaseArray[0]['count']);
			$increaseArray[0]['post_test'] = floatval($increaseArray[0]['post_test']) / intval($increaseArray[0]['count']);
			unset($increaseArray[0]['count']);
		}
		if (intval($sameArray[0]['count']) > 0) {
			$sameArray[0]['pre_test'] = floatval($sameArray[0]['pre_test']) / intval($sameArray[0]['count']);
			$sameArray[0]['post_test'] = floatval($sameArray[0]['post_test']) / intval($sameArray[0]['count']);
			unset($sameArray[0]['count']);
		}

		$array = array_merge($decreaseArray, $increaseArray);
		$array = array_merge($array, $sameArray);

		echo json_encode($array);
	}

	public function loadanalysisChange1(Request $request) {
		$decreaseArray = [
			[
				"change" => "Decrease",
				'pre_test' => 0,
				"post_test" => 0,
				'count' => 0,
			],
		];
		$increaseArray = [
			[
				"change" => "Increase",
				'pre_test' => 0,
				"post_test" => 0,
				'count' => 0,
			],
		];
		$sameArray = [
			[
				"change" => "Same",
				'pre_test' => 0,
				"post_test" => 0,
				'count' => 0,
			],
		];

		$preTest = Application::leftJoin('application_value', 'application_value.application_id', 'application.id')
			->where('application.status', 8)
			->where('application_value.type', "pre_test");
		if (Auth::user()->hasrole('partner')) {
			$collectors = Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
			$preTest->whereIn('application.collector_id', $collectors);
		}
		if (Session::has('year') && !empty(Session::get('year'))) {
			$preTest->whereDate('application.pre_test_date', 'LIKE', Session::get('year') . "%");
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$preTest->limit(Session::get('from'))->where('application.status',8);
			/*$preTest->where('application.id',"<=",Session::get('to'));*/
        }
		if (isset($formData['age']) && !empty($formData['age'])) {
			$preTest->where('form', $formData['age']);
		}
		if (isset($formData['gender']) && !empty($formData['gender'])) {
			$preTest->where('dender', $formData['gender']);
		}
		$preTest = $preTest->get();

		foreach ($preTest as $pre) {
			$postTest = Application::leftJoin('application_value', 'application_value.application_id', 'application.id')
				->where('application.status', 8)
				->where('application_value.type', "post_test")
				->where('application_value.application_id', $pre->application_id)
				->first();

			$finalpreTestScore = floatval($pre->score);
			$finalpostTestScore = floatval($postTest->score);
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore > $finalpreTestScore) {
					$decreaseArray[0]['pre_test'] = floatval($decreaseArray[0]['pre_test']) + $finalpreTestScore;
					$decreaseArray[0]['post_test'] = floatval($decreaseArray[0]['post_test']) + $finalpostTestScore;
					$decreaseArray[0]['count'] = floatval($decreaseArray[0]['count']) + 1;
				} elseif ($finalpostTestScore < $finalpreTestScore) {
					$increaseArray[0]['pre_test'] = floatval($increaseArray[0]['pre_test']) + $finalpreTestScore;
					$increaseArray[0]['post_test'] = floatval($increaseArray[0]['post_test']) + $finalpostTestScore;
					$increaseArray[0]['count'] = floatval($increaseArray[0]['count']) + 1;
				} elseif ($finalpostTestScore == $finalpreTestScore) {
					$sameArray[0]['pre_test'] = floatval($sameArray[0]['pre_test']) + $finalpreTestScore;
					$sameArray[0]['post_test'] = floatval($sameArray[0]['post_test']) + $finalpostTestScore;
					$sameArray[0]['count'] = floatval($sameArray[0]['count']) + 1;
				} else {
					$increaseArray[0]['pre_test'] = floatval($increaseArray[0]['pre_test']) + $finalpreTestScore;
					$increaseArray[0]['post_test'] = floatval($increaseArray[0]['post_test']) + $finalpostTestScore;
					$decreaseArray[0]['count'] = floatval($decreaseArray[0]['count']) + 1;
				}
			}
		}

		if (intval($decreaseArray[0]['count']) > 0) {
			$decreaseArray[0]['pre_test'] = floatval($decreaseArray[0]['pre_test']) / intval($decreaseArray[0]['count']);
			$decreaseArray[0]['post_test'] = floatval($decreaseArray[0]['post_test']) / intval($decreaseArray[0]['count']);
			unset($decreaseArray[0]['count']);
		}
		if (intval($increaseArray[0]['count']) > 0) {
			$increaseArray[0]['pre_test'] = floatval($increaseArray[0]['pre_test']) / intval($increaseArray[0]['count']);
			$increaseArray[0]['post_test'] = floatval($increaseArray[0]['post_test']) / intval($increaseArray[0]['count']);
			unset($increaseArray[0]['count']);
		}
		if (intval($sameArray[0]['count']) > 0) {
			$sameArray[0]['pre_test'] = floatval($sameArray[0]['pre_test']) / intval($sameArray[0]['count']);
			$sameArray[0]['post_test'] = floatval($sameArray[0]['post_test']) / intval($sameArray[0]['count']);
			unset($sameArray[0]['count']);
		}

		$array = array_merge($decreaseArray, $increaseArray);
		$array = array_merge($array, $sameArray);

		echo json_encode($array);
	}

	public function loadReports(Request $request){
		if(request()->ajax()){
    		$formData 	= $request->all();
    		$data 		= ApplicationLog::select('application_log.*','application.code','users.firstname','users.lastname')
	    		->leftjoin('users','users.id','application_log.causer_id')
	    		->leftjoin('application','application.id','application_log.application_id')
	    		->orderBy('application_log.id','desc');
    		if((Session::has('from') && !empty(Session::get('from')))){
				$data->limit(Session::get('from'))->where('application.status',8);
				/*$data->where('application.id',"<=",Session::get('to'));*/
	        }
    		return datatables()->of($data)->make(true);
    	}
	}
}
