<?php

namespace App\Http\Controllers;
use App\Caza;
use App\Gouvernate;
use Auth;
use Illuminate\Http\Request;

class CazaController extends Controller {
	public function index(Request $request) {
		$gouvernate = Gouvernate::all();
		return view('admin.caza.list', compact('gouvernate'));
	}

	public function loadCaza(Request $request) {
		if (request()->ajax()) {
			$formData = $request->all();
			$data = Caza::select('gouvernate.name as gov_name', 'caza.*')
				->leftJoin('gouvernate', 'gouvernate.id', 'caza.gouvernate_id');
			if (isset($formData['name']) && !empty($formData['name'])) {
				$data->where('caza.name', 'like', "%" . $formData['name'] . "%");
			}
			if (isset($formData['gouvernate']) && !empty($formData['gouvernate'])) {
				$data->where('caza.gouvernate_id', 'like', "%" . $formData['gouvernate'] . "%");
			}
			if (isset($formData['id']) && !empty($formData['id'])) {
				$data->where('caza.id', $formData['id']);
			}
			return datatables()->of($data)
				->addColumn('action', function ($data) {
					$actions = "";
					$edit = '<a href="' . route('edit-caza', $data->id) . '" class="btn btn-primary  m-btn--pill m-btn--custom m-btn--icon m-btn--air"><i class="la la-edit"></i> Edit</a>';
					$delete = '<a href="javascript:;" onclick="deleteCaza(' . $data->id . ')" class="btn btn-danger  m-btn--pill m-btn--custom m-btn--icon m-btn--air"><i class="la la-trash"></i> Delete</a>';
					if (Auth::user()->hasrole('admin')) {
						$actions .= $edit . " " . $delete;
					}
					return $actions;
				})
				->rawColumns(['action'])->make(true);
		}
	}

	public function add(Request $request) {
		if ($request->isMethod('post')) {
			$formData = $request->all();
			$request->validate([
				'name' => 'required|string|unique:caza',
			]);

			$cazaObj = new Caza();
			$cazaObj->gouvernate_id = $formData['gouvernate'];
			$cazaObj->name = $formData['name'];
			$cazaObj->arabic = $formData['arabic'];
			if ($cazaObj->save()) {
				$request->session()->flash('success', "Caza successfully added.");
				return redirect('caza-list');
			} else {
				$request->session()->flash('error', "Whoops! Something went wrong please try again later.");
				return redirect('add-caza');
			}
		}
		$gouvernate = Gouvernate::all();
		return view('admin.caza.add', compact('gouvernate'));
	}
	public function edit($id, Request $request) {
		$cazaObj = Caza::find($id);
		if (empty($cazaObj)) {
			$request->session()->flash('error', "Caza not found");
			return redirect('caza-list');
		}
		if ($request->isMethod('post')) {
			$formData = $request->all();
			$request->validate([
				'name' => 'required|string',
			]);

			$cazaObj->gouvernate_id = $formData['gouvernate'];
			$cazaObj->name = $formData['name'];
			$cazaObj->arabic = $formData['arabic'];
			if ($cazaObj->save()) {
				$request->session()->flash('success', "Caza successfully updated.");
				return redirect('caza-list');
			} else {
				$request->session()->flash('error', "Whoops! Something went wrong please try again later.");
				return redirect('add-caza');
			}
		}
		$gouvernate = Gouvernate::all();
		return view('admin.caza.edit', compact('cazaObj', 'gouvernate'));
	}

	public function delete(Request $request) {
		$error = '';
		$message = '';
		Caza::find($request['id'])->delete();
		$response = [
			'response' => "Caza successfully deleted",
			'error' => $error,
		];
		$request->session()->flash('success', "Caza successfully deleted");
		return response()->json($response);
	}

	public function getAjazCaza(Request $request) {
		$gov_id = $request['gov_id'];
		if (empty($gov_id)) {
			$caza = Caza::all();
		} else {
			$caza = Caza::where('gouvernate_id', $gov_id)->get();
		}
		$cityArray = [];
		if (count($caza) > 0) {
			foreach ($caza as $value) {
				$subArray = [];
				$subArray['id'] = $value->id;
				$subArray['name'] = ucfirst($value->name);
				$subArray['arabic'] = !empty($value->arabic) ? ucfirst($value->arabic) : "";
				array_push($cityArray, $subArray);
			}
		}

		$response = [
			'response' => $cityArray,
		];
		return response()->json($response);
	}
}
