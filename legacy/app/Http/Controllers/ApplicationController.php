<?php

namespace App\Http\Controllers;
use App;
use App\Application;
use App\Applicationvalue;
use App\Caza;
use App\Collector;
use App\Form;
use App\Gouvernate;
use App\Helpers\Email_sender;
use App\Partner;
use App\Status;
use App\User;
use Auth;
use Session;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;

class ApplicationController extends Controller {
	public function index(Request $request) {
		$partners = Partner::all();
		$collectors = Collector::join('users', 'users.id', 'collectors.user_id')->get();
		$status = Status::all();
		$gouvernates = Gouvernate::all();
		return view('admin.application.list', compact('partners', 'collectors', 'status','gouvernates'));
	}

	public function loadApplication(Request $request) {
		$formData = $request->all();
		/*$data = Application::select('application.*', 'part.name as partner_name', 'col.firstname as collector_name', 'status.name as status_name','gouvernate.name as gov_name')
			->leftJoin('users as col', 'col.id', 'application.collector_id')
			->join('collectors', 'collectors.user_id', 'application.collector_id')
			->leftJoin('partners as part', 'part.user_id', 'collectors.partner_id')
			->leftJoin('status', 'status.id', 'application.status')
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->leftJoin('gouvernate','gouvernate.id','application_value.gouvarnate')
			->where('application_value.type', "post_test")
			->orderBy('application.id','desc');*/

		$data = Gouvernate::select('application.*', 'part.name as partner_name', 'col.firstname as collector_name', 'status.name as status_name','gouvernate.name as gov_name')
			->leftJoin('application_value','application_value.gouvarnate','gouvernate.id')
			->leftJoin('application', 'application.id', 'application_value.application_id')
			->leftJoin('users as col', 'col.id', 'application.collector_id')
			->join('collectors', 'collectors.user_id', 'application.collector_id')
			->leftJoin('partners as part', 'part.user_id', 'collectors.partner_id')
			->leftJoin('status', 'status.id', 'application.status')
			->where('application_value.type', "pre_test")
			->distinct()
			->orderBy('application.id','desc');
		if (isset($formData['code']) && !empty($formData['code'])) {
			$data->where('application.code', 'like', "%" . $formData['code'] . "%");
		}
		if (isset($formData['pre_test_date']) && !empty($formData['pre_test_date'])) {
			$data->where('application.pre_test_date', 'like', "%" . $formData['pre_test_date'] . "%");
		}
		if (isset($formData['post_test_date']) && !empty($formData['post_test_date'])) {
			$data->where('application.post_test_date', 'like', "%" . $formData['post_test_date'] . "%");
		}
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
		if (isset($formData['governorate_filter']) && !empty($formData['governorate_filter'])) {
			$data->where('gouvernate.id', $formData['governorate_filter']);
		}
		if((Session::has('from') && !empty(Session::get('from')))){
			$data->take(Session::get('from'));
			/*$data->where('application.id',"<=",Session::get('to'));*/
        }
		return datatables()->of($data)
			->addColumn('partner', function ($data) {
				return ucfirst($data->partner_name);
			})
			->addColumn('gouvernate', function ($data) {
				return ucfirst($data->gov_name);
			})
			->addColumn('pre_test_score', function ($data) {
				$preTest = Applicationvalue::select('score', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $data->id)->where('type', 'pre_test')->first();
				$finalpreTestScore = 0;
				if (!empty($preTest) && isset($preTest->score)) {
					if (isset($preTest->score) && !empty($preTest->score) && $preTest->score != "na") {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->score);
					}
					/*if(isset($preTest->conduct_scale) && !empty($preTest->conduct_scale) && $preTest->conduct_scale != "na"){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
						                        }
						                        if(isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale) && $preTest->peer_problem_scale != "na"){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
						                        }
						                        if(isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale) && $preTest->hyper_activity_scale != "na"){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
					*/
				}
				return $finalpreTestScore;
			})
			->addColumn('post_test_score', function ($data) {
				$preTest = Applicationvalue::select('score', 'emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $data->id)->where('type', 'post_test')->first();
				$finalpreTestScore = 0;
				if (!empty($preTest) && isset($preTest->score)) {
					if (isset($preTest->score) && !empty($preTest->score) && $preTest->score != "na") {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->score);
					}
					/*if(isset($preTest->conduct_scale) && !empty($preTest->conduct_scale) && $preTest->conduct_scale != "na"){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
						                        }
						                        if(isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale) && $preTest->peer_problem_scale != "na"){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
						                        }
						                        if(isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale) && $preTest->hyper_activity_scale != "na"){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
					*/
				}
				return $finalpreTestScore;
			})
			->addColumn('change', function ($data) {
				$preTest = Applicationvalue::select('score', 'emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $data->id)->where('type', 'pre_test')->first();
				$postTest = Applicationvalue::select('score', 'emotional_scale', 'conduct_scale', 'peer_problem_scale', 'pro_social_scale', 'hyper_activity_scale')->where('application_id', $data->id)->where('type', 'post_test')->first();

				if (!empty($preTest)) {
					$finalpreTestScore = 0;
					if (isset($preTest->score) && !empty($preTest->score) && $preTest->score != "na") {
						$finalpreTestScore = $finalpreTestScore + intval($preTest->score);
					}
					/*if(isset($preTest->emotional_scale) && !empty($preTest->emotional_scale)){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->emotional_scale);
						                        }
						                        if(isset($preTest->conduct_scale) && !empty($preTest->conduct_scale)){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->conduct_scale);
						                        }
						                        if(isset($preTest->peer_problem_scale) && !empty($preTest->peer_problem_scale)){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->peer_problem_scale);
						                        }
						                        if(isset($preTest->hyper_activity_scale) && !empty($preTest->hyper_activity_scale)){
						                            $finalpreTestScore = $finalpreTestScore + intval($preTest->hyper_activity_scale);
					*/
				}

				if (!empty($postTest)) {
					$finalpostTestScore = 0;
					if (isset($preTest->score) && !empty($postTest->score) && $postTest->score != "na") {
						$finalpostTestScore = $finalpostTestScore + intval($postTest->score);
					}
					/*if(isset($postTest->emotional_scale) && !empty($postTest->emotional_scale)){
						                            $finalpostTestScore = $finalpostTestScore + intval($postTest->emotional_scale);
						                        }
						                        if(isset($postTest->conduct_scale) && !empty($postTest->conduct_scale)){
						                            $finalpostTestScore = $finalpostTestScore + intval($postTest->conduct_scale);
						                        }
						                        if(isset($postTest->peer_problem_scale) && !empty($postTest->peer_problem_scale)){
						                            $finalpostTestScore = $finalpostTestScore + intval($postTest->peer_problem_scale);
						                        }
						                        if(isset($postTest->hyper_activity_scale) && !empty($postTest->hyper_activity_scale)){
						                            $finalpostTestScore = $finalpostTestScore + intval($postTest->hyper_activity_scale);
					*/
				}
				// echo $finalpostTestScore;
				// echo $finalpreTestScore;exit;

				if (isset($finalpostTestScore) && isset($finalpreTestScore) && $finalpostTestScore > 0 && $finalpreTestScore > 0) {

					// echo "aaa";exit;
					if ($finalpostTestScore > $finalpreTestScore) {
						return "Decrease";
					} elseif ($finalpostTestScore < $finalpreTestScore) {
						return "Increase";
					} elseif ($finalpostTestScore == $finalpreTestScore) {
						return "Same";
					} else {
						return "-";
					}
				} else {
					// echo "bbb";exit;
					return "-";
				}
			})
			->addColumn('collector', function ($data) {
				return ucfirst($data->collector_name);
			})
			->addColumn('action', function ($data) {
				if (Auth::user()->hasrole('admin|partner|collector')) {
					$actions = '<span class="dropdown">
	                                <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
	                                  <i class="la la-ellipsis-h"></i>
	                                </a>
                                	<div class="dropdown-menu dropdown-menu-right">';
					if ($data->status_name != "NA") {
						if (empty($data->pre_test_date)) {
							$pre_test = '<a href="' . route('pre-test-application', $data->code) . '" class="dropdown-item"><i class="la la-edit"></i>Pre Test</a>';
						} elseif (empty($data->post_test_date)) {
							$pre_test = '<a href="' . route('post-test-application', $data->code) . '" class="dropdown-item"><i class="la la-edit"></i>Post Test</a>';
						} else {
							$pre_test = "";
						}
					} else {
						$pre_test = "";
					}
					$view = '<a href="' . route('view-application', $data->code) . '" class="dropdown-item"><i class="la la-eye"></i> View</a>';
					
					if (intval(Auth::user()->is_readonly) != 1) {
						if (Auth::user()->hasrole('collector')) {
							$actions .= $pre_test;
						}
						if (Auth::user()->hasrole('partner') && intval($data->status) < 7) {
							$change_collector = '<a href="' . route('change-collector', $data->code) . '" class="dropdown-item "><i class="la la-exchange"></i> Change Collector</a>';
							$actions .= $change_collector;
						}
					}
					$actions .= $view;
					$actions .= '</div></span>';
					return $actions;
				} else {
					return "";
				}
			})
			/*->limit(function($query) {
				if((Session::has('from') && !empty(Session::get('from')))){
					return $query->take(Session::get('from'));
		        }
	         })*/
			->rawColumns(['action'])
			->make(true);
		if (request()->ajax()) {
		}
	}

	public function add(Request $request) {
		if ($request->isMethod('post')) {
			$formData = $request->all();
			$request->validate([
				'category' => 'required',
				'pre_test_date' => 'required',
				'post_test_date' => 'required',
				'gouvarnate' => 'required',
				'caza' => 'required',
			]);
			$lastId = Application::latest()->first();

			if (!empty($lastId)) {
				$applicationId = $lastId->id + 1;
			} else {
				$applicationId = 1;
			}
			$collectorObj = Collector::where('user_id', Auth::user()->id)->first();
			if (empty($collectorObj)) {
				$request->session()->flash('error', "Collector not found or unauthorized user");
				return redirect('application-list');
			}
			$prefix = Partner::where('user_id', Auth::user()->partner_id);
			$username = strtoupper(substr(Auth::user()->firstname, 0, 2));
			$date = date('Y');
			$applicationCode = $date . "-" . $username . "-" . $applicationId;

			$applicationObj = new Application();
			$applicationObj->code = $applicationCode;
			$applicationObj->category = $formData['category'];
			$applicationObj->pre_test_date = $formData['pre_test_date'];
			$applicationObj->post_test_date = $formData['post_test_date'];
			$applicationObj->gouvarnate = $formData['gouvarnate'];
			$applicationObj->caza = $formData['caza'];
			$applicationObj->save();

			if ($applicationObj->id > 0) {
				$request->session()->flash('success', trans('messages.application_successfully_aded'));
				return redirect('application-list');
			} else {
				$request->session()->flash('error', trans('messages.something_went_wrong'));
				return view('admin.application.add');
			}
		}
		$forms = Form::get();
		return view('admin.application.add', compact('forms'));
	}

	public function generateApplication(Request $request) {
		$formData = $request->all();
		$userObj = Auth::user();
		if (empty($userObj)) {
			$request->session()->flash('error', trans('messages.user_not_found'));
			return redirect('application-list');
		}
		$collectorObj = Collector::where('user_id', Auth::user()->id)->first();
		if (empty($collectorObj)) {
			$request->session()->flash('error', "Collector not found or unauthorized user");
			return redirect('application-list');
		}
		$partnerObj = Partner::select('users.email', 'partners.*')->leftJoin('users', 'users.id', 'partners.user_id')
			->where('partners.user_id', $collectorObj->partner_id)->first();
		$applicationArray = array();
		if (!empty($partnerObj) && !empty($partnerObj->prefix)) {
			$partnerPrefix = $partnerObj->prefix;
			$collectors = Collector::select('user_id')->where('partner_id', $partnerObj->user_id)->get()->toArray();
			$applicationCount = Application::whereIn('collector_id', $collectors)->count();
			if ($applicationCount >= intval($partnerObj->max_app_per_year)) {
				Email_sender::sendLimitReachedEmail(['user_name' => $partnerObj->name, 'email' => $partnerObj->email, 'limit' => $partnerObj->max_app_per_year]);
				$request->session()->flash('error', "Max limit or " . intval($partnerObj->max_app_per_year) . " reached");
				return redirect('application-list');
			}
		} else {
			$request->session()->flash('error', "Partner Prefix not added");
			return redirect('application-list');
		}

		if (!empty($collectorObj) && !empty($collectorObj->prefix)) {
			$collectorPrefix = $collectorObj->prefix;
		} else {
			$request->session()->flash('error', "Collector Prefix not added");
			return redirect('application-list');
		}

		if ($userObj->hasrole('collector')) {
			$applicationArray['collector_id'] = $userObj->id;
		}
		$statusObj = Status::where('name', "LIKE", "Pre Test")->first();
		if (!empty($statusObj)) {
			$applicationArray['status'] = $statusObj->id;
		} else {
			$applicationArray['status'] = 0;
		}

		$applicationCount1 = Application::select('id')->where('collector_id', Auth::user()->id)->count();
		if(empty($applicationCount1)){
			$applicationId = 1;
		}else{
			$applicationId = $applicationCount1+1;
		}
		$date = date('y');
		$applicationCode = $partnerPrefix . "-" . $collectorPrefix . "-" . $applicationId;
		$applicationArray['code'] = $applicationCode;
		//$applicationObj = Application::create($applicationArray);
		/*$applicationObj = Application::select('application.*', 'status.name as status_name')
			->leftJoin('status', 'status.id', 'application.status')
			->where('application.code', $applicationArray['code'])
			->first();*/
		$applicationObj = new Application();
		if (!empty($applicationObj)) {
			/*DB::table('application_log')->insert([
				'application_id' => $applicationObj->id,
				'causer_id' => Auth::user()->id,
				'text' => "Application Pretest was created at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
			]);
			$request->session()->flash('success', trans('messages.application_generated') . $applicationObj->code);*/
			return redirect()->route('pre-test-application', $applicationArray['code']);
		} else {
			$request->session()->flash('error', trans('messages.something_went_wrong'));
			return redirect('application-list');
		}
	}

	public function getPreTest($code, Request $request) {
		if (empty($code)) {
			$request->session()->flash('error', trans('messages.application_code_missing'));
			return redirect('application-list');
		}
		$applicationObj = Application::where('code', $code)->first();
		/*if (empty($applicationObj)) {
			$request->session()->flash('error', trans('messages.application_code_error'));
			return redirect('application-list');
		}*/
		$preTestObj = Applicationvalue::select('application_value.*', 'application.*', 'gouvernate.name as gouvarnate_name', 'caza.name as caza_name', 'status.name as status_name')
			->leftJoin('application', 'application.id', 'application_value.application_id')
			->leftJoin('gouvernate', 'gouvernate.id', 'application_value.gouvarnate')
			->leftJoin('caza', 'caza.id', 'application_value.caza')
			->leftJoin('status', 'status.id', 'application.status')
			->where('application_value.type', 'pre_test')
			->where('application.code', $code)
			->first();

		if (empty($preTestObj)) {
			/*$applicationObj = Applicationvalue::create([
				'application_id' => $applicationObj->id,
				'type' => "pre_test",
			]);*/

			/*$preTestObj = Applicationvalue::select('application_value.*', 'application.*', 'gouvernate.name as gouvarnate_name', 'caza.name as caza_name', 'status.name as status_name')
				->leftJoin('application', 'application.id', 'application_value.application_id')
				->leftJoin('gouvernate', 'gouvernate.id', 'application_value.gouvarnate')
				->leftJoin('caza', 'caza.id', 'application_value.caza')
				->leftJoin('status', 'status.id', 'application.status')
				->where('application_value.type', 'pre_test')
				->where('application.code', $code)
				->first();*/
			$preTestObj = new Applicationvalue();
		}
		$forms 			= Form::get();
		$gouvernates 	= Gouvernate::all();
		$type 			= "pre_test";
		$collectorObj 	= Collector::where('user_id', Auth::user()->id)->first();
		$partnerObj 	= Partner::select('partners.name as partner_name')
			->leftJoin('users', 'users.id', 'partners.user_id')
			->where('partners.user_id', $collectorObj->partner_id)->first();

		$preTestObj->code 				= $code;
		$collectorObj->partner_name 	= $partnerObj->partner_name;
		$preTestObj->agency_name 		= $partnerObj->partner_name;
		$preTestObj->interviewers_name 	= Auth::user()->firstname." ".Auth::user()->lastname;
		return view('admin.application.pre_test', compact('preTestObj', 'forms', 'gouvernates', 'type','collectorObj','code'));
	}

	public function savePreTest(Request $request) {
		$formData = $request->all();
		$naCount = 0;
		$validationArray = [
			'code' => "required",
			'form' => "required",
			'agency_name' => 'required',
			'category' => 'required',
			'donor_name' => 'required',
			'interview_date' => 'required|before:'.date('Y-m-d',strtotime("+2 day")),
			'interviewers_name' => 'required',
			'age' => 'required',
			'gender' => 'required',
			'nationality' => 'required',
			'gouvarnate' => "required",
			'caza' => "required",
			'area' => "required",
			'may_i_start_now' => "required",
			'may_i_start_now' => "required",
		];
		$validationArray1 = [
			'considerate_of_other_peoples_feelings' => 'required',
			'restless_overactive_cannot_stay_still_for_long' => 'required',
			'often_complains_of_headaches_stomach_aches_or_sickness' => 'required',
			'shares_readily_with_other_children_for_example_toys' => 'required',
			'often_loses_temper' => 'required',
			'rather_solitary_prefers_to_play_alone' => 'required',
			'generally_well_behaved_usually_does_what_adults_request' => 'required',
			'many_worries_or_often_seems_worried' => 'required',
			'helpful_if_someone_is_hurt_upset_or_feeling_ill' => 'required',
			'constantly_fidgeting_or_squirming' => 'required',
			'has_at_least_one_good_friend' => 'required',
			'often_fights_with_other_hildren_or_bullies_them' => 'required',
			'often_unhappy_depressed_or_tearful' => 'required',
			'generally_liked_by_other_children' => 'required',
			'easily_distracted_concentration_wanders' => 'required',
			'nervous_or_clingy_in_new_situations_easily_loses_confidence' => 'required',
			'kind_to_younger_children' => 'required',
			'often_lies_or_cheats' => 'required',
			'picked_on_or_bullied_by_other_children' => 'required',
			'thinks_things_out_before_acting' => 'required',
			'steals_from_home_school_or_elsewhere' => 'required',
			'gets_along_better_with_adults_than_with_other_children' => 'required',
			'many_fears_easily_scared' => 'required',
			'good_attention_span_sees_chores_or_homework_through_to_the_end' => 'required',
			'often_offers_to_help_others' => 'required',
		];
		if($formData['form'] == "Form 6-11"){
			$validationArray['age'] = "required|integer|between:6,11";
		}else{
			$validationArray['age'] = "required|integer|between:12,17";
		}
		if($formData['nationality'] == "Other Nationality"){
			$validationArray['other_nationality'] = "required|string";
		}
		if (isset($formData['may_i_start_now']) && !empty($formData['may_i_start_now']) && $formData['may_i_start_now'] == "yes") {
			$validationArray = array_merge($validationArray, $validationArray1);
		}

		$selectedForm = $formData['form'];
		$code = $formData['code'];
		$submit = $formData['submit'];
		$userObj = Auth::user();
		if (empty($userObj)) {
			$request->session()->flash('error', trans('messages.user_not_found'));
			return redirect('application-list');
		}
		if ($userObj->hasrole('partner')) {
			$formData['partner_id'] = $userObj->id;
		}

		if ($userObj->hasrole('collector')) {
			$formData['collector_id'] = $userObj->id;
		}
		$formData['type'] = "pre_test";
		$formData['child_code'] = $formData['code'];
		$applicationObj = Application::where('code', $formData['code'])->first();
		if(empty($applicationObj)){
			$applicationArray = array();

			if ($userObj->hasrole('collector')) {
				$applicationArray['collector_id'] = $userObj->id;
			}
			$statusObj = Status::where('name', "LIKE", "Pre Test")->first();
			if (!empty($statusObj)) {
				$applicationArray['status'] = $statusObj->id;
			} else {
				$applicationArray['status'] = 0;
			}
			$applicationArray['code'] = $formData['code'];
			$applicationObj = Application::create($applicationArray);
			$applicationObj = Application::select('application.*', 'status.name as status_name')
			->leftJoin('status', 'status.id', 'application.status')
			->where('application.code', $applicationArray['code'])
			->first();

			if (isset($applicationObj->code) && !empty($applicationObj->code)) {
				DB::table('application_log')->insert([
					'application_id' => $applicationObj->id,
					'causer_id' => Auth::user()->id,
					'text' => "Application Pretest was created at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
				]);
			}
		}
		if (isset($applicationObj->id) && !empty($applicationObj->id)) {
			if ($applicationObj->pre_test_date != NULL || $applicationObj->pre_test_date != null || $applicationObj->pre_test_date != "") {
				$request->session()->flash('error', trans('messages.one_time_pre_test_error'));
				return redirect('application-list');
			}
			if ($formData['may_i_start_now'] == "no" && isset($submit) && $submit == 'submit') {
				unset($formData['considerate_of_other_peoples_feelings']);
				unset($formData['restless_overactive_cannot_stay_still_for_long']);
				unset($formData['often_complains_of_headaches_stomach_aches_or_sickness']);
				unset($formData['shares_readily_with_other_children_for_example_toys']);
				unset($formData['often_loses_temper']);
				unset($formData['rather_solitary_prefers_to_play_alone']);
				unset($formData['generally_well_behaved_usually_does_what_adults_request']);
				unset($formData['many_worries_or_often_seems_worried']);
				unset($formData['helpful_if_someone_is_hurt_upset_or_feeling_ill']);
				unset($formData['constantly_fidgeting_or_squirming']);
				unset($formData['has_at_least_one_good_friend']);
				unset($formData['often_fights_with_other_hildren_or_bullies_them']);
				unset($formData['often_unhappy_depressed_or_tearful']);
				unset($formData['generally_liked_by_other_children']);
				unset($formData['easily_distracted_concentration_wanders']);
				unset($formData['nervous_or_clingy_in_new_situations_easily_loses_confidence']);
				unset($formData['kind_to_younger_children']);
				unset($formData['often_lies_or_cheats']);
				unset($formData['picked_on_or_bullied_by_other_children']);
				unset($formData['thinks_things_out_before_acting']);
				unset($formData['steals_from_home_school_or_elsewhere']);
				unset($formData['gets_along_better_with_adults_than_with_other_children']);
				unset($formData['many_fears_easily_scared']);
				unset($formData['good_attention_span_sees_chores_or_homework_through_to_the_end']);
				unset($formData['often_offers_to_help_others']);
				unset($formData['score']);
				unset($formData['code']);
				unset($formData['emotional_scale']);
				unset($formData['conduct_scale']);
				unset($formData['hyper_activity_scale']);
				unset($formData['peer_problem_scale']);
				unset($formData['pro_social_scale']);
				unset($formData['score']);
				$formData['type'] = "pre_test";
				$formData['form'] = $selectedForm;
				$applicationValueObj = Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'pre_test')->first();
				unset($formData['_token']);
				unset($formData['submit']);

				unset($formData['code']);
				unset($formData['partner_id']);
				unset($formData['collector_id']);
				if (isset($applicationValueObj->application_id) && !empty($applicationValueObj->application_id)) {
					Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'pre_test')->update($formData);
				} else {
					Applicationvalue::create($formData);
				}

				$statusObj = Status::where('name', "Pre Test No Permission")->first();
				$statusObj1 = Status::where('name', "Pre Test Completed")->first();
				if (!empty($statusObj)) {
					$statusId = $statusObj->id;
				} else {
					$statusId = $statusObj1->id;
				}
				$applicationObj->status = $statusId;
				$applicationObj->pre_test_date = date('Y-m-d H:i:s');
				$applicationObj->post_test_date = date('Y-m-d H:i:s');
				$applicationObj->save();
				$message = trans('messages.pre_test_no_permission');
				DB::table('application_log')->insert([
					'application_id' => $applicationObj->id,
					'causer_id' => Auth::user()->id,
					'text' => "Application Pre Test No Permission at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
				]);
				$request->session()->flash('error', trans('messages.pre_test_no_permission'));
				return redirect('application-list');
			} else {

				$formData['application_id'] = $applicationObj->id;
				$formData['application_id'] = $applicationObj->id;
				$applicationValueObj = Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'pre_test')->first();
				unset($formData['_token']);
				unset($formData['submit']);

				unset($formData['code']);
				unset($formData['partner_id']);
				unset($formData['collector_id']);
				if (isset($submit) && $submit == 'submit') {
					$scoreArray = $applicationObj->countScore($formData);
					$formData = array_merge($formData, $scoreArray);
					$naCount = $formData['na_count'];
					unset($formData['na_count']);
				}
				if (isset($applicationValueObj->application_id) && !empty($applicationValueObj->application_id)) {
					Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'pre_test')->update($formData);
				} else {
					Applicationvalue::create($formData);
				}
				$applicationValueObj = Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'pre_test')->first();
				if ($naCount > 3) {
					$statusObj = Status::where('name', "NA")->first();
					$applicationObj->status = $statusObj->id;
					$message = trans('messages.pre_test_draft_saved');
					DB::table('application_log')->insert([
						'application_id' => $applicationObj->id,
						'causer_id' => $userObj->id,
						'text' => "Application Pretest was NA at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", $userObj->getRoleNames())) . " " . $userObj->firstname . " " . $userObj->firstname,
					]);
					$applicationObj->save();
					$request->session()->flash('error', "Application submitted as NA");
					return redirect('application-list');
				} elseif (isset($submit) && $submit == 'save') {
					$statusObj = Status::where('name', "Pre Test Pending")->first();
					$statusObj1 = Status::where('name', "Pre Test")->first();
					if (!empty($statusObj)) {
						$statusId = $statusObj->id;
					} else {
						$statusId = $statusObj1->id;
					}
					$applicationObj->status = $statusId;
					$message = trans('messages.pre_test_draft_saved');
					DB::table('application_log')->insert([
						'application_id' => $applicationObj->id,
						'causer_id' => Auth::user()->id,
						'text' => "Application Pretest was saved at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
					]);
				} else {
					$formData['code'] = $code;
					$validator = Validator::make($formData, $validationArray);
					if (!$validator->fails()) {
						$statusObj = Status::where('name', "Post Test")->first();
						$statusObj1 = Status::where('name', "Pre Test Completed")->first();
						if (!empty($statusObj)) {
							$statusId = $statusObj->id;
						} else {
							$statusId = $statusObj1->id;
						}
						$applicationObj->status = $statusId;
						$applicationObj->pre_test_date = date('Y-m-d H:i:s');
						$message = trans('messages.pre_test_submitted');
						DB::table('application_log')->insert([
							'application_id' => $applicationObj->id,
							'causer_id' => Auth::user()->id,
							'text' => "Application Pretest was Submitted succesfully at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
						]);
					} else {
						return redirect()->back()->withInput($request->all)->withErrors($validator->errors());
					}
				}
				$applicationObj->save();
				if (isset($submit) && $submit != 'save') {
					$formData['code'] = $code;
					$validator = Validator::make($formData, $validationArray);

					if ($validator->fails()) {
						return redirect()->back()->withInput($request->all)->withErrors($validator->errors());
					}
				}
				$applicationValueObj1 = Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'post_test')->first();

				unset($formData['considerate_of_other_peoples_feelings']);
				unset($formData['restless_overactive_cannot_stay_still_for_long']);
				unset($formData['often_complains_of_headaches_stomach_aches_or_sickness']);
				unset($formData['shares_readily_with_other_children_for_example_toys']);
				unset($formData['often_loses_temper']);
				unset($formData['rather_solitary_prefers_to_play_alone']);
				unset($formData['generally_well_behaved_usually_does_what_adults_request']);
				unset($formData['many_worries_or_often_seems_worried']);
				unset($formData['helpful_if_someone_is_hurt_upset_or_feeling_ill']);
				unset($formData['constantly_fidgeting_or_squirming']);
				unset($formData['has_at_least_one_good_friend']);
				unset($formData['often_fights_with_other_hildren_or_bullies_them']);
				unset($formData['often_unhappy_depressed_or_tearful']);
				unset($formData['generally_liked_by_other_children']);
				unset($formData['easily_distracted_concentration_wanders']);
				unset($formData['nervous_or_clingy_in_new_situations_easily_loses_confidence']);
				unset($formData['kind_to_younger_children']);
				unset($formData['often_lies_or_cheats']);
				unset($formData['picked_on_or_bullied_by_other_children']);
				unset($formData['thinks_things_out_before_acting']);
				unset($formData['steals_from_home_school_or_elsewhere']);
				unset($formData['gets_along_better_with_adults_than_with_other_children']);
				unset($formData['many_fears_easily_scared']);
				unset($formData['good_attention_span_sees_chores_or_homework_through_to_the_end']);
				unset($formData['often_offers_to_help_others']);
				unset($formData['score']);
				unset($formData['code']);
				unset($formData['emotional_scale']);
				unset($formData['conduct_scale']);
				unset($formData['hyper_activity_scale']);
				unset($formData['peer_problem_scale']);
				unset($formData['pro_social_scale']);
				unset($formData['score']);
				unset($formData['interview_date']);
				unset($formData['may_i_start_now']);
				$formData['type'] = "post_test";
				$formData['form'] = $selectedForm;
				if (isset($applicationValueObj1->application_id) && !empty($applicationValueObj1->application_id)) {
					Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'post_test')->update($formData);
					DB::table('application_log')->insert([
						'application_id' => $applicationValueObj1->id,
						'causer_id' => Auth::user()->id,
						'text' => "Application Post-test was created on " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
					]);
				} else {
					$application = Applicationvalue::create($formData);

					$application_id = $application->id;
					DB::table('application_log')->insert([
						'application_id' => $application_id,
						'causer_id' => Auth::user()->id,
						'text' => "Application Post-test was created on " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
					]);
				}
			}
		} else {
			$request->session()->flash('error', trans('messages.application_code_error'));
			return redirect('application-list');
		}

		$applicationObj = Application::select('application.*', 'application_value.*', 'status.name as status_name')
			->leftJoin('application_value', 'application_value.application_id', 'application.id')
			->leftJoin('status', 'status.id', 'application.status')
			->where('application.id', $applicationObj->id)
			->first();

		if (isset($applicationObj->code) && !empty($applicationObj->code)) {
			$request->session()->flash('success', $message);
			return redirect('application-list');
		} else {
			$request->session()->flash('error', trans('messages.something_went_wrong'));
			return redirect('application-list');
		}
	}

	public function getPostTest($code, Request $request) {
		if (empty($code)) {
			$request->session()->flash('error', trans('messages.application_code_missing'));
			return redirect('application-list');
		}
		$applicationObj = Application::where('code', $code)->first();
		if (empty($applicationObj)) {
			$request->session()->flash('error', trans('messages.application_code_error'));
			return redirect('application-list');
		}
		$preTestObj = Applicationvalue::select('application_value.*', 'application.*', 'gouvernate.name as gouvarnate_name', 'caza.name as caza_name', 'status.name as status_name')
			->leftJoin('application', 'application.id', 'application_value.application_id')
			->leftJoin('gouvernate', 'gouvernate.id', 'application_value.gouvarnate')
			->leftJoin('caza', 'caza.id', 'application_value.caza')
			->leftJoin('status', 'status.id', 'application.status')
			->where('application_value.type', 'post_test')
			->where('application.code', $code)
			->first();

		if (empty($preTestObj)) {
			$applicationObj = Applicationvalue::create([
				'application_id' => $applicationObj->id,
				'type' => "post_test",
			]);

			$preTestObj = Applicationvalue::select('application_value.*', 'application.*', 'gouvernate.name as gouvarnate_name', 'caza.name as caza_name', 'status.name as status_name')
				->leftJoin('application', 'application.id', 'application_value.application_id')
				->leftJoin('gouvernate', 'gouvernate.id', 'application_value.gouvarnate')
				->leftJoin('caza', 'caza.id', 'application_value.caza')
				->leftJoin('status', 'status.id', 'application.status')
				->where('application_value.type', 'post_test')
				->where('application.code', $code)
				->first();
		}
		$forms = Form::get();
		$gouvernates = Gouvernate::all();
		$type = "post_test";
		$collectorObj 	= Collector::where('user_id', Auth::user()->id)->first();
		$partnerObj 	= Partner::select('partners.name as partner_name')
			->leftJoin('users', 'users.id', 'partners.user_id')
			->where('partners.user_id', $collectorObj->partner_id)->first();
		$collectorObj->partner_name = $partnerObj->partner_name;
		return view('admin.application.pre_test', compact('preTestObj', 'forms', 'gouvernates', 'type','collectorObj'));
	}

	public function savePostTest(Request $request) {
		$formData = $request->all();
		$formData['score'] = mt_rand(1, 20);
		unset($formData['services']);
		$validationArray = [
			'code' => "required",
			'form' => "required",
			'agency_name' => 'required',
			'category' => 'required',
			'donor_name' => 'required',
			'interview_date' => 'required|before:'.date('Y-m-d',strtotime("+2 day")),
			'interviewers_name' => 'required',
			'age' => 'required',
			'gender' => 'required',
			'nationality' => 'required',
			'total_number_of_hours_in_your_program' => "required|gte:number_of_hours_that_the_child_attended",
			'number_of_hours_that_the_child_attended' => "required|lte:total_number_of_hours_in_your_program",
			'dropout_reason' => "required",
		];
		$validationArray1 = [
			'considerate_of_other_peoples_feelings' => 'required',
			'restless_overactive_cannot_stay_still_for_long' => 'required',
			'often_complains_of_headaches_stomach_aches_or_sickness' => 'required',
			'shares_readily_with_other_children_for_example_toys' => 'required',
			'often_loses_temper' => 'required',
			'rather_solitary_prefers_to_play_alone' => 'required',
			'generally_well_behaved_usually_does_what_adults_request' => 'required',
			'many_worries_or_often_seems_worried' => 'required',
			'helpful_if_someone_is_hurt_upset_or_feeling_ill' => 'required',
			'constantly_fidgeting_or_squirming' => 'required',
			'has_at_least_one_good_friend' => 'required',
			'often_fights_with_other_hildren_or_bullies_them' => 'required',
			'often_unhappy_depressed_or_tearful' => 'required',
			'generally_liked_by_other_children' => 'required',
			'easily_distracted_concentration_wanders' => 'required',
			'nervous_or_clingy_in_new_situations_easily_loses_confidence' => 'required',
			'kind_to_younger_children' => 'required',
			'often_lies_or_cheats' => 'required',
			'picked_on_or_bullied_by_other_children' => 'required',
			'thinks_things_out_before_acting' => 'required',
			'steals_from_home_school_or_elsewhere' => 'required',
			'gets_along_better_with_adults_than_with_other_children' => 'required',
			'many_fears_easily_scared' => 'required',
			'good_attention_span_sees_chores_or_homework_through_to_the_end' => 'required',
			'often_offers_to_help_others' => 'required',
		];
		if (isset($formData['dropout_reason']) && $formData['dropout_reason'] == "Did Not Drop Out") {
			$validationArray['gouvarnate'] = "required";
			$validationArray['caza'] = "required";
			$validationArray['area'] = "required";
			$validationArray['may_i_start_now'] = "required";
			$validationArray['gateway_type'] = "required";
			if($formData['form'] == "Form 6-11"){
				$validationArray['age'] = "required|integer|between:6,11";
			}else{
				$validationArray['age'] = "required|integer|between:12,17";
			}

			if($formData['nationality'] == "Other Nationality"){
				$validationArray['other_nationality'] = "required|string";
			}
			if (isset($formData['may_i_start_now']) && !empty($formData['may_i_start_now']) && $formData['may_i_start_now'] == "yes") {
				$validationArray = array_merge($validationArray, $validationArray1);
			}
		} else {
			$validationArray['justify_the_dropout_reason'] = "required";
		}

		if (isset($formData['do_the_child_receive_any_other_child_protection_services']) && count($formData['do_the_child_receive_any_other_child_protection_services']) > 0) {
			$formData['do_the_child_receive_any_other_child_protection_services'] = implode(",", $formData['do_the_child_receive_any_other_child_protection_services']);
		}
		if (isset($formData['submit']) && $formData['submit'] != 'save') {
			$validator = Validator::make($formData, $validationArray);

			if ($validator->fails()) {
				return redirect()->back()->withInput($request->all)->withErrors($validator->errors());
			}
		}

		$userObj = Auth::user();
		if (empty($userObj)) {
			$request->session()->flash('error', trans('messages.user_not_found'));
			return redirect('application-list');
		}
		if ($userObj->hasrole('partner')) {
			$formData['partner_id'] = $userObj->id;
		}

		if ($userObj->hasrole('collector')) {
			$formData['collector_id'] = $userObj->id;
		}
		$formData['child_code'] = $formData['code'];
		$formData['type'] = "post_test";
		$applicationObj = Application::where('code', $formData['code'])->first();
		if (isset($applicationObj->id) && !empty($applicationObj->id)) {
			if ($applicationObj->post_test_date != NULL || $applicationObj->post_test_date != null || $applicationObj->post_test_date != "") {
				$request->session()->flash('error', trans('messages.one_time_post_test_error'));
				return redirect('application-list');
			}
			if ($formData['may_i_start_now'] == "no" && isset($formData['submit']) && $formData['submit'] == 'submit') {
				unset($formData['considerate_of_other_peoples_feelings']);
				unset($formData['restless_overactive_cannot_stay_still_for_long']);
				unset($formData['often_complains_of_headaches_stomach_aches_or_sickness']);
				unset($formData['shares_readily_with_other_children_for_example_toys']);
				unset($formData['often_loses_temper']);
				unset($formData['rather_solitary_prefers_to_play_alone']);
				unset($formData['generally_well_behaved_usually_does_what_adults_request']);
				unset($formData['many_worries_or_often_seems_worried']);
				unset($formData['helpful_if_someone_is_hurt_upset_or_feeling_ill']);
				unset($formData['constantly_fidgeting_or_squirming']);
				unset($formData['has_at_least_one_good_friend']);
				unset($formData['often_fights_with_other_hildren_or_bullies_them']);
				unset($formData['often_unhappy_depressed_or_tearful']);
				unset($formData['generally_liked_by_other_children']);
				unset($formData['easily_distracted_concentration_wanders']);
				unset($formData['nervous_or_clingy_in_new_situations_easily_loses_confidence']);
				unset($formData['kind_to_younger_children']);
				unset($formData['often_lies_or_cheats']);
				unset($formData['picked_on_or_bullied_by_other_children']);
				unset($formData['thinks_things_out_before_acting']);
				unset($formData['steals_from_home_school_or_elsewhere']);
				unset($formData['gets_along_better_with_adults_than_with_other_children']);
				unset($formData['many_fears_easily_scared']);
				unset($formData['good_attention_span_sees_chores_or_homework_through_to_the_end']);
				unset($formData['often_offers_to_help_others']);
				unset($formData['score']);
				unset($formData['code']);
				unset($formData['emotional_scale']);
				unset($formData['conduct_scale']);
				unset($formData['hyper_activity_scale']);
				unset($formData['peer_problem_scale']);
				unset($formData['pro_social_scale']);
				unset($formData['score']);
				$formData['type'] = "post_test";
				$applicationValueObj = Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'post_test')->first();
				unset($formData['_token']);
				unset($formData['submit']);

				unset($formData['code']);
				unset($formData['partner_id']);
				unset($formData['collector_id']);
				if (isset($applicationValueObj->application_id) && !empty($applicationValueObj->application_id)) {
					Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'pre_test')->update($formData);
				} else {
					Applicationvalue::create($formData);
				}

				$statusObj = Status::where('name', "Post Test No Permission")->first();
				$statusObj1 = Status::where('name', "Post Test Completed")->first();
				if (!empty($statusObj)) {
					$statusId = $statusObj->id;
				} else {
					$statusId = $statusObj1->id;
				}
				$applicationObj->status = $statusId;
				$applicationObj->post_test_date = date('Y-m-d H:i:s');
				$applicationObj->save();
				$message = trans('messages.post_test_no_permission');
				DB::table('application_log')->insert([
					'application_id' => $applicationObj->id,
					'causer_id' => Auth::user()->id,
					'text' => "Application Post Test No Permission at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
				]);
				$request->session()->flash('error', trans('messages.post_test_no_permission'));
				return redirect('application-list');
			} else {
				$formData['application_id'] = $applicationObj->id;
				$scoreArray = $applicationObj->countScore($formData);
				if (intval($scoreArray['na_count']) > 3) {
					$statusObj = Status::where('name', "NA")->first();
					$applicationObj->status = $statusObj->id;
					$message = trans('messages.pre_test_draft_saved');
					DB::table('application_log')->insert([
						'application_id' => $applicationObj->id,
						'causer_id' => $userObj->id,
						'text' => "Application posttest was NA at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", $userObj->getRoleNames())) . " " . $userObj->firstname . " " . $userObj->firstname,
					]);
					$applicationObj->save();
					$request->session()->flash('error', "Application submitted as NA");
					return redirect('application-list');
				} elseif (isset($formData['submit']) && $formData['submit'] == 'save') {
					$statusObj = Status::where('name', "Post Test Pending")->first();
					$statusObj1 = Status::where('name', "Post Test")->first();
					if (!empty($statusObj)) {
						$statusId = $statusObj->id;
					} else {
						$statusId = $statusObj1->id;
					}
					$applicationObj->status = $statusId;
					$message = "Application saved as post test draft";
					DB::table('application_log')->insert([
						'application_id' => $applicationObj->id,
						'causer_id' => Auth::user()->id,
						'text' => "Application posttest saved at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
					]);
				} elseif ($formData['dropout_reason'] != "Did Not Drop Out") {
					$statusObj = Status::where('name', "Dropout")->first();
					$statusObj1 = Status::where('name', "Post Test Completed")->first();
					if (!empty($statusObj)) {
						$statusId = $statusObj->id;
					} else {
						$statusId = $statusObj1->id;
					}
					$applicationObj->status = $statusId;
					$message = trans('messages.application_dropout');
					DB::table('application_log')->insert([
						'application_id' => $applicationObj->id,
						'causer_id' => Auth::user()->id,
						'text' => "Application dropout at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
					]);
				} else {
					if (isset($formData['submit']) && $formData['submit'] == 'submit') {
						$scoreArray = $applicationObj->countScore($formData);
						$formData = array_merge($formData, $scoreArray);
						unset($formData['na_count']);
					}

					$statusObj = Status::where('name', "Done")->first();
					$statusObj1 = Status::where('name', "Post Test Completed")->first();
					if (!empty($statusObj)) {
						$statusId = $statusObj->id;
					} else {
						$statusId = $statusObj1->id;
					}
					$applicationObj->status = $statusId;
					$applicationObj->post_test_date = date('Y-m-d H:i:s');
					$message = trans('messages.post_test_submitted');
					DB::table('application_log')->insert([
						'application_id' => $applicationObj->id,
						'causer_id' => Auth::user()->id,
						'text' => "Application Post-test was Submitted succesfully at " . date('d M Y') . " by " . str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->firstname,
					]);

				}
				$applicationObj->save();
				$formData['application_id'] = $applicationObj->id;
				$applicationValueObj = Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'post_test')->first();
				unset($formData['_token']);
				unset($formData['submit']);

				if (isset($applicationValueObj->application_id) && !empty($applicationValueObj->application_id)) {
					unset($formData['code']);
					unset($formData['partner_id']);
					unset($formData['collector_id']);
					$applicationValueObj = Applicationvalue::where('application_id', $applicationObj->id)->where('type', 'post_test')->update($formData);
				} else {
					$applicationValueObj = Applicationvalue::create($formData);
					$message1 = "Application created with post test.";
				}
			}
		} else {
			$request->session()->flash('error', trans('messages.application_code_error'));
			return redirect('application-list');
		}

		$applicationObj = Application::select('application.code')
			->where('application.id', $applicationObj->id)
			->first();

		if (isset($applicationObj->code) && !empty($applicationObj->code)) {
			$request->session()->flash('success', $message);
			return redirect('application-list');
		} else {
			$request->session()->flash('error', trans('messages.something_went_wrong'));
			return redirect('application-list');
		}
	}

	public function viewApplication($code, Request $request) {
		$formData = $request->all();
		$applicationObj = Application::select('application.*', 'part.firstname as partner_name', 'col.firstname as collector_name', 'status.name as status_name')
			->leftJoin('users as col', 'col.id', 'application.collector_id')
			->leftJoin('users as part', 'part.id', 'application.partner_id')
			->leftJoin('status', 'status.id', 'application.status')
			->where('application.code', $code)->first();
		if (empty($applicationObj)) {
			$request->session()->flash('error', trans('messages.application_code_error'));
			return redirect('application-list');
		}
		/*if(isset($applicationObj->language) && !empty($applicationObj->language)){
			            App::setLocale($applicationObj->language);
			            session()->put('locale', $applicationObj->language);
		*/
		$preTestData = Applicationvalue::select('application_value.*', 'gouvernate.name as gouvername_name', 'caza.name as caza_name', 'area.name as area_name')
			->leftJoin('gouvernate', 'gouvernate.id', 'application_value.gouvarnate')
			->leftJoin('caza', 'caza.id', 'application_value.caza')
			->leftJoin('area', 'area.id', 'application_value.area')
			->where('application_value.application_id', $applicationObj->id)
			->where('application_value.type', "pre_test")->first();
		$postTestData = Applicationvalue::select('application_value.*', 'gouvernate.name as gouvername_name', 'caza.name as caza_name', 'area.name as area_name')
			->leftJoin('gouvernate', 'gouvernate.id', 'application_value.gouvarnate')
			->leftJoin('caza', 'caza.id', 'application_value.caza')
			->leftJoin('area', 'area.id', 'application_value.area')
			->where('application_value.application_id', $applicationObj->id)
			->where('application_value.type', "post_test")->first();
		$applicationLog = DB::table('application_log')->where('application_id', $applicationObj->id)->get();

		if (!empty($preTestData)) {
			$finalpreTestScore = 0;
			if (isset($preTestData->score) && !empty($preTestData->score) && $preTestData->score != "na") {
				$finalpreTestScore = $finalpreTestScore + floatval($preTestData->score);
			}
			/*$finalpreTestScore = 0;
				            if(isset($preTestData->emotional_scale) && !empty($preTestData->emotional_scale)){
				                $finalpreTestScore = $finalpreTestScore + floatval($preTestData->emotional_scale);
				            }
				            if(isset($preTestData->conduct_scale) && !empty($preTestData->conduct_scale)){
				                $finalpreTestScore = $finalpreTestScore + floatval($preTestData->conduct_scale);
				            }
				            if(isset($preTestData->peer_problem_scale) && !empty($preTestData->peer_problem_scale)){
				                $finalpreTestScore = $finalpreTestScore + floatval($preTestData->peer_problem_scale);
				            }
				            if(isset($preTestData->hyper_activity_scale) && !empty($preTestData->hyper_activity_scale)){
				                $finalpreTestScore = $finalpreTestScore + floatval($preTestData->hyper_activity_scale);
			*/
		}

		if (!empty($postTestData)) {
			$finalpostTestScore = 0;
			if (isset($postTestData->score) && !empty($postTestData->score) && $postTestData->score != "na") {
				$finalpostTestScore = $finalpostTestScore + floatval($postTestData->score);
			}
			/*if(isset($postTestData->emotional_scale) && !empty($postTestData->emotional_scale)){
				                $finalpostTestScore = $finalpostTestScore + floatval($postTestData->emotional_scale);
				            }
				            if(isset($postTestData->conduct_scale) && !empty($postTestData->conduct_scale)){
				                $finalpostTestScore = $finalpostTestScore + floatval($postTestData->conduct_scale);
				            }
				            if(isset($postTestData->peer_problem_scale) && !empty($postTestData->peer_problem_scale)){
				                $finalpostTestScore = $finalpostTestScore + floatval($postTestData->peer_problem_scale);
				            }
				            if(isset($postTestData->hyper_activity_scale) && !empty($postTestData->hyper_activity_scale)){
				                $finalpostTestScore = $finalpostTestScore + floatval($postTestData->hyper_activity_scale);
			*/
		}
		if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
			if (floatval($finalpostTestScore) > floatval($finalpreTestScore)) {
				$change = "Decrease";
			} elseif (floatval($finalpostTestScore) < floatval($finalpreTestScore)) {
				$change = "Increase";
			} elseif (floatval($finalpostTestScore) == floatval($finalpreTestScore)) {
				$change = "Same";
			} else {
				$change = "-";
			}
		}
		$data = [
			'application' => $applicationObj->toArray(),
			'pre_test' => !empty($preTestData) ? $preTestData->toArray() : [],
			'post_test' => !empty($postTestData) ? $postTestData->toArray() : [],
			'log' => !empty($applicationLog) ? $applicationLog->toArray() : [],
			'change' => isset($change) ? $change : "-",
		];
		return view('admin.application.view', compact('data'));
	}

	public function delete(Request $request) {
		$error = '';
		$message = '';
		Application::find($request['id'])->delete();
		Applicationvalue::where('application_id', $request['id'])->delete();
		$response = [
			'response' => "Application successfully deleted",
			'error' => $error,
		];
		$request->session()->flash('success', "Application successfully deleted");
		return response()->json($response);
	}

	public function changeCollector($code, Request $request) {
		$formData = $request->all();
		$applicationObj = Application::where('code', $code)->first();
		if (empty($applicationObj)) {
			$request->session()->flash('error', trans('messages.application_code_error'));
			return redirect('application-list');
		}
		if ($request->isMethod('post')) {
			$request->validate([
				'collector' => "required",
			]);
			$applicationObj->collector_id = $formData['collector'];
			$applicationObj->save();
			$collectorObj = Collector::where('user_id', $formData['collector'])->first();
			DB::table('application_log')->insert([
				'application_id' => $applicationObj->id,
				'causer_id' => Auth::user()->id,
				'text' => str_replace('["', "", str_replace('"]', "", Auth::user()->getRoleNames())) . " " . Auth::user()->firstname . " " . Auth::user()->lastname . " assigned application to " . $collectorObj->name . " at " . date('d M Y'),
			]);
			$request->session()->flash('success', "Collector Changed for application " . $code);
			return redirect('application-list');
		}

		$collectors = Collector::join('users', 'users.id', 'collectors.user_id')
			->where('partner_id', Auth::user()->id)->get();
		return view('admin.application.change_collector', compact('applicationObj', 'collectors'));
	}

	public function export(Request $request) {
		$formData = $request->all();
		$data = Application::select('application.*', 'part.name as partner_name', 'col.firstname as collector_name', 'status.name as status_name')
			->leftJoin('users as col', 'col.id', 'application.collector_id')
			->join('collectors', 'collectors.user_id', 'application.collector_id')
			->leftJoin('partners as part', 'part.user_id', 'collectors.partner_id')
			->leftJoin('status', 'status.id', 'application.status');
		if (isset($formData['code']) && !empty($formData['code'])) {
			$data->where('application.code', 'like', "%" . $formData['code'] . "%");
		}
		if (isset($formData['pre_test_date']) && !empty($formData['pre_test_date'])) {
			$data->where('application.pre_test_date', 'like', "%" . $formData['pre_test_date'] . "%");
		}
		if (isset($formData['post_test_date']) && !empty($formData['post_test_date'])) {
			$data->where('application.post_test_date', 'like', "%" . $formData['post_test_date'] . "%");
		}
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
		if((Session::has('from') && !empty(Session::get('from')))){
			$data->take(Session::get('from'));
			/*$data->where('application.id',"<=",Session::get('to'));*/
        }
		$data = $data->get();
		/*return Excel::download($data, 'applications.xlsx');*/
		$file = fopen('php://output', 'w');
		$filename = "applications_export_" . date('Y_m_d') . ".csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		$columns = array('Code', 'Type', 'Pre Test Date', 'Post Test Date', 'Pre Test Score', 'Post Test Score', 'Change', 'Partner', 'Collector', 'Status', 'Gouvernate', "Caza", "Area", "Agency", "Form", 'Donor Name', 'Interview Date', "Interviewers Name", "Age", "Gender", "Nationality", "Gateway Type", "P-Code", "Latitude", "Longitude", "Altitude", 'Accuracy', 'May I Start Now', "Considerate Of Other Peoples Feelings", "Restless, overactive, cannot stay still for long", "Often complains of headaches, stomach-aches or sickness", "Shares readily with other children, for example toys, treats, pencils", "Often loses temper", "Rather solitary, prefers to play alone", "Generally well behaved, usually does what adults request", "Many worries or often seems worried", "Helpful if someone is hurt, upset or feeling ill", "Constantly fidgeting or squirming", "Has at least one good friend", "Often fights with other children or bullies them", "Often unhappy, depressed or tearful", "Generally liked by other children", "Easily distracted, concentration wanders", "Nervous or clingy in new situations, easily loses confidence", "Kind to younger children", 'Often lies or cheats', 'Picked on or bullied by other children', "Often offers to help others", "Thinks things out before acting", 'Steals from home, school or elsewhere', "Gets along better with adults than with other children", "Many fears, easily scared", "Good attention span, sees chores or homework through to the end", "Comment", "Child's code", "Number of hours that the child attended", "Total number of hours in your program", "Dropout reason", "Justify the dropout reason", "Do the child receive any other Child Protection services? (Please select all the relevant services)", "Emotional Scale", "Conduct Scale", "Hyper Activity Scale", "Peer Problem Scale", "Pro Social Scale",'Decrease Reason','Decrease Note');

		fputcsv($file, $columns);

		foreach ($data as $review) {
			$preTest = Applicationvalue::select('application_value.*', 'gouvernate.name as gouvername_name', 'caza.name as caza_name', 'area.name as area_name')
				->leftJoin('gouvernate', 'gouvernate.id', 'application_value.gouvarnate')
				->leftJoin('caza', 'caza.id', 'application_value.caza')
				->leftJoin('area', 'area.id', 'application_value.area')
				->where('application_id', $review->id)
				->where('type', 'pre_test')->first();
			$postTest = Applicationvalue::select('application_value.*', 'gouvernate.name as gouvername_name', 'caza.name as caza_name', 'area.name as area_name')
				->leftJoin('gouvernate', 'gouvernate.id', 'application_value.gouvarnate')
				->leftJoin('caza', 'caza.id', 'application_value.caza')
				->leftJoin('area', 'area.id', 'application_value.area')
				->where('application_id', $review->id)
				->where('type', 'post_test')->first();
			$finalpostTestScore = 0;
			$finalpreTestScore = 0;
			$change = "-";
			if (!empty($preTest)) {
				if (isset($preTest->score) && !empty($preTest->score) && $preTest->score != "na") {
					$finalpreTestScore = $finalpreTestScore + intval($preTest->score);
				}
			}

			if (!empty($postTest)) {
				if (isset($postTest->score) && !empty($postTest->score) && $postTest->score != "na") {
					$finalpostTestScore = $finalpostTestScore + intval($postTest->score);
				}
			}
			if (isset($finalpostTestScore) && isset($finalpreTestScore)) {
				if ($finalpostTestScore > $finalpreTestScore) {
					$change = "Decrease";
				} elseif ($finalpostTestScore < $finalpreTestScore) {
					$change = "Increase";
				} elseif ($finalpostTestScore == $finalpreTestScore) {
					$change = "Same";
				} else {
					$change = "-";
				}
			}
			if(!empty($preTest)){
				$preTest->may_i_start_now = $preTest->may_i_start_now == "yes" ? "Yes, permission is given" : "No, permission is not given";

				fputcsv($file, array($review->code, ucfirst(str_replace("_", " ", $preTest->type)), $review->pre_test_date, $review->post_test_date, $finalpreTestScore, $finalpostTestScore, $change, $review->partner_name, $review->collector_name, $review->status_name, $preTest->gouvername_name, $preTest->caza_name, $preTest->area_name, $preTest->agency_name, $preTest->form, $preTest->donor_name, $preTest->interview_date, $preTest->interviewers_name, $preTest->age, ucfirst($preTest->gender), $preTest->nationality, $preTest->gateway_type, $preTest->p_code, $preTest->latitude, $preTest->longitude, $preTest->altitude, $preTest->accuracy, $preTest->may_i_start_now, $preTest->considerate_of_other_peoples_feelings, $preTest->restless_overactive_cannot_stay_still_for_long, $preTest->often_complains_of_headaches_stomach_aches_or_sickness, $preTest->shares_readily_with_other_children_for_example_toys, $preTest->often_loses_temper, $preTest->rather_solitary_prefers_to_play_alone, $preTest->generally_well_behaved_usually_does_what_adults_request, $preTest->many_worries_or_often_seems_worried, $preTest->helpful_if_someone_is_hurt_upset_or_feeling_ill, $preTest->constantly_fidgeting_or_squirming, $preTest->has_at_least_one_good_friend, $preTest->often_fights_with_other_hildren_or_bullies_them, $preTest->often_unhappy_depressed_or_tearful, $preTest->generally_liked_by_other_children, $preTest->easily_distracted_concentration_wanders, $preTest->nervous_or_clingy_in_new_situations_easily_loses_confidence, $preTest->kind_to_younger_children, $preTest->often_lies_or_cheats, $preTest->picked_on_or_bullied_by_other_children, $preTest->often_offers_to_help_others, $preTest->thinks_things_out_before_acting, $preTest->steals_from_home_school_or_elsewhere, $preTest->gets_along_better_with_adults_than_with_other_children, $preTest->many_fears_easily_scared, $preTest->good_attention_span_sees_chores_or_homework_through_to_the_end, $preTest->comment, $preTest->child_code, $preTest->number_of_hours_that_the_child_attended, $preTest->total_number_of_hours_in_your_program, $preTest->dropout_reason, $preTest->justify_the_dropout_reason, $preTest->do_the_child_receive_any_other_child_protection_services, $preTest->emotional_scale, $preTest->conduct_scale, $preTest->hyper_activity_scale, $preTest->peer_problem_scale, $preTest->pro_social_scale,$review->reason_option,$review->reason_details));
			}
			if (!empty($postTest) && !empty($preTest)) {
				$postTest->may_i_start_now = $preTest->may_i_start_now == "yes" ? "Yes, permission is given" : "No, permission is not given";
				fputcsv($file, array($review->code, ucfirst(str_replace("_", " ", $postTest->type)), $review->pre_test_date, $review->post_test_date, $finalpreTestScore, $finalpostTestScore, $change, $review->partner_name, $review->collector_name, $review->status_name, $postTest->gouvername_name, $postTest->caza_name, $postTest->area_name, $postTest->agency_name, $postTest->form, $postTest->donor_name, $postTest->interview_date, $postTest->interviewers_name, $postTest->age, ucfirst($postTest->gender), $postTest->nationality, $postTest->gateway_type, $postTest->p_code, $postTest->latitude, $postTest->longitude, $postTest->altitude, $postTest->accuracy, $postTest->may_i_start_now, $postTest->considerate_of_other_peoples_feelings, $postTest->restless_overactive_cannot_stay_still_for_long, $postTest->often_complains_of_headaches_stomach_aches_or_sickness, $postTest->shares_readily_with_other_children_for_example_toys, $postTest->often_loses_temper, $postTest->rather_solitary_prefers_to_play_alone, $postTest->generally_well_behaved_usually_does_what_adults_request, $postTest->many_worries_or_often_seems_worried, $postTest->helpful_if_someone_is_hurt_upset_or_feeling_ill, $postTest->constantly_fidgeting_or_squirming, $postTest->has_at_least_one_good_friend, $postTest->often_fights_with_other_hildren_or_bullies_them, $postTest->often_unhappy_depressed_or_tearful, $postTest->generally_liked_by_other_children, $postTest->easily_distracted_concentration_wanders, $postTest->nervous_or_clingy_in_new_situations_easily_loses_confidence, $postTest->kind_to_younger_children, $postTest->often_lies_or_cheats, $postTest->picked_on_or_bullied_by_other_children, $postTest->often_offers_to_help_others, $postTest->thinks_things_out_before_acting, $postTest->steals_from_home_school_or_elsewhere, $postTest->gets_along_better_with_adults_than_with_other_children, $postTest->many_fears_easily_scared, $postTest->good_attention_span_sees_chores_or_homework_through_to_the_end, $postTest->comment, $postTest->child_code, $postTest->number_of_hours_that_the_child_attended, $postTest->total_number_of_hours_in_your_program, $postTest->dropout_reason, $postTest->justify_the_dropout_reason, $postTest->do_the_child_receive_any_other_child_protection_services, $postTest->emotional_scale, $postTest->conduct_scale, $postTest->hyper_activity_scale, $postTest->peer_problem_scale, $postTest->pro_social_scale,$review->reason_option,$review->reason_details));
			}
		}
		exit();
	}

}
