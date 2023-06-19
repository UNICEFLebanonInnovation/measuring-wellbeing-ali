<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
Use App\Application;
Use App\Applicationvalue;
use App\Gouvernate;
use App\Collector;
use App\Partner;
use App\Status;
use Validator;
Use App\User;
use App\Form;
use DB;

class ApplicationController extends BaseController
{
    function __construct(){
        $this->middleware('auth_api');
    }

    public function generateApplication(Request $request){
        $formData           = $request->all();
        $userObj            = $this->getUser($formData['token']);

        if(empty($userObj)){
            return $this->sendError(trans('messages.user_not_found'));
        }
        if(intval($userObj->is_readonly) == 1){


            return $this->sendError("access blocked");
        }

        $applicationArray = array();
        $collectorObj       = Collector::where('user_id',$userObj->id)->first();
        if(empty($collectorObj)){
            return $this->sendError("Collector not found or unauthorized user");
        }
       $partnerObj = Partner::select('users.email','partners.*')->leftJoin('users','users.id','partners.user_id')
        ->where('partners.user_id',$collectorObj->partner_id)->first();
        if(!empty($partnerObj) && !empty($partnerObj->prefix)){
            $partnerPrefix = $partnerObj->prefix;
            $collectors = Collector::select('user_id')->where('partner_id',$partnerObj->user_id)->get()->toArray();
            $applicationCount = Application::whereIn('collector_id',$collectors)->count();
            if($applicationCount >= intval($partnerObj->max_app_per_year)){
                Email_sender::sendLimitReachedEmail(['user_name'=>$partnerObj->name,'email'=>$partnerObj->email,'limit'=>$partnerObj->max_app_per_year]);
                return $this->sendError("Max limit or ".intval($partnerObj->max_app_per_year)." reached");
            }
        }else{
            return $this->sendError('Partner Prefix not added');
        }
        $applicationArray = array();
        /*if($userObj->hasrole('partner')){
            $applicationArray['partner_id'] = $userObj->id;
        }*/

        if(!empty($collectorObj) && !empty($collectorObj->prefix)){
            $collectorPrefix = $collectorObj->prefix;
        }else{
            return $this->sendError('Collector Prefix not added');
        }

        if($userObj->hasrole('collector')){
            $applicationArray['collector_id'] = $userObj->id;
        }
        $statusObj                   = Status::where('name',"LIKE","Pre Test")->first();

        if(!empty($statusObj)){
            $applicationArray['status']      = $statusObj->id;
        }else{
            $applicationArray['status']      = 0;
        }

        $lastId                      = Application::select('id')->orderBy('id','desc')->first();
        if(!empty($lastId)){
            $applicationId = $lastId->id+1;
        }else{
            $applicationId = 1;
        }
        $lastId                      = Application::select('id')->orderBy('id','desc')->first();
        $applicationId               = isset($lastId->id) && $lastId->id > 0 ? $lastId->id+1 : 1;
        $date                        = date('y');
        $applicationCode             = $partnerPrefix."-".$collectorPrefix."-".$applicationId;
        $applicationArray['code']    = $applicationCode;
        $applicationObj              = Application::create($applicationArray);
        $applicationObj              = Application::select('application.*','status.name as status_name')
        ->leftJoin('status','status.id','application.status')
        ->where('application.code',$applicationArray['code'])
        ->first();

        if(isset($applicationObj->code) && !empty($applicationObj->code)){
            DB::table('application_log')->insert([
                'application_id' => $applicationObj->id,
                'causer_id' => $userObj->id,
                'text' => "Application Pretest was created at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
            ]);
            return $this->sendResponse($applicationObj->toArray(), "Application Generated");
        }else{
            return $this->sendError(trans('messages.something_went_wrong'));
        }
    }

    public function submitPreTest(Request $request){
        $formData = $request->all();
        $naCount        = 0;
        $validationArray = [
            'code'                                                              => "required",
            'form'                                                              => "required",
            'agency_name'                                                       => 'required',
            'category'                                                          => 'required',
            'donor_name'                                                        => 'required',
            'interview_date' => 'required|before:'.date('Y-m-d',strtotime("+2 day")),
            'interviewers_name'                                                 => 'required',
            'age'                                                               => 'required',
            'gender'                                                            => 'required',
            'nationality'                                                       => 'required',
            'gouvarnate'                                                        => "required",
            'caza'                                                              => "required",
            'area'                                                              => "required",
            'may_i_start_now'                                                    => "required",
        ];
        $validationArray1 = [
            'considerate_of_other_peoples_feelings'                             => 'required',
            'restless_overactive_cannot_stay_still_for_long'                    => 'required',
            'often_complains_of_headaches_stomach_aches_or_sickness'            => 'required',
            'shares_readily_with_other_children_for_example_toys'               => 'required',
            'often_loses_temper'                                                => 'required',
            'rather_solitary_prefers_to_play_alone'                             => 'required',
            'generally_well_behaved_usually_does_what_adults_request'           => 'required',
            'many_worries_or_often_seems_worried'                               => 'required',
            'helpful_if_someone_is_hurt_upset_or_feeling_ill'                   => 'required',
            'constantly_fidgeting_or_squirming'                                 => 'required',
            'has_at_least_one_good_friend'                                      => 'required',
            'often_fights_with_other_hildren_or_bullies_them'                   => 'required',
            'often_unhappy_depressed_or_tearful'                                => 'required',
            'generally_liked_by_other_children'                                 => 'required',
            'easily_distracted_concentration_wanders'                           => 'required',
            'nervous_or_clingy_in_new_situations_easily_loses_confidence'       => 'required',
            'kind_to_younger_children'                                          => 'required',
            'often_lies_or_cheats'                                              => 'required',
            'picked_on_or_bullied_by_other_children'                            => 'required',
            'thinks_things_out_before_acting'                                   => 'required',
            'steals_from_home_school_or_elsewhere'                              => 'required',
            'gets_along_better_with_adults_than_with_other_children'            => 'required',
            'many_fears_easily_scared'                                          => 'required',
            'good_attention_span_sees_chores_or_homework_through_to_the_end'    => 'required',
            'often_offers_to_help_others'                                       => 'required',
        ];
        if($formData['form'] == "Form 6-11"){
                $validationArray['age'] = "required|integer|between:6,11";
            }else{
                $validationArray['age'] = "required|integer|between:12,17";
            }
        if($formData['nationality'] == "Other Nationality"){
            $validationArray['other_nationality'] = "required|string";
        }
        if(isset($formData['may_i_start_now']) && !empty($formData['may_i_start_now']) && $formData['may_i_start_now'] == "yes"){
            $validationArray = array_merge($validationArray,$validationArray1);
        }
        if( isset($formData['do_the_child_receive_any_other_child_protection_services']) && count($formData['do_the_child_receive_any_other_child_protection_services']) > 0){
            $formData['do_the_child_receive_any_other_child_protection_services'] = implode(",", $formData['do_the_child_receive_any_other_child_protection_services']);
        }

        $userObj            = $this->getUser($formData['token']);
        if(empty($userObj)){
            return $this->sendError(trans('messages.invalid_token'));
        }
        if(intval($userObj->is_readonly) == 1){
            return $this->sendError("access blocked");
        }

        if($userObj->hasrole('partner')){
            $formData['partner_id'] = $userObj->id;
        }

        $code                   = $formData['code'];
        if($userObj->hasrole('collector')){
            $formData['collector_id'] = $userObj->id;
            $applicationArray['collector_id'] = $userObj->id;
        }
        $statusObj                   = Status::where('name',"LIKE","Pre Test")->first();

        if(!empty($statusObj)){
            $applicationArray['status']      = $statusObj->id;
        }else{
            $applicationArray['status']      = 0;
        }
        $applicationArray['code']    = $formData['code'];
        $applicationObj      = Application::where('code',$code)->first();
        if(empty($applicationObj)){
            $applicationObj   = Application::create($applicationArray);
        }
        $formData['application_id'] = $applicationObj->id;

        $selectedForm           = $formData['form'];
        $submit                 = $formData['submit'];
        $formData['child_code'] = $formData['code'];
        unset($formData['token']);
        $formData['type']       = "pre_test";
        unset($formData['_token']);
        unset($formData['submit']);

        unset($formData['code']);
        unset($formData['partner_id']);
        unset($formData['collector_id']);
        $applicationObj      = Application::where('code',$code)->first();
        if(isset($formData['language'])){
            $applicationObj->language = $formData['language'];
            $applicationObj->save();
            unset($formData['language']);
        }
        if(isset($applicationObj->id) && !empty($applicationObj->id)){
            if($applicationObj->pre_test_date != NULL || $applicationObj->pre_test_date != null || $applicationObj->pre_test_date != ""){
                return $this->sendError(trans('messages.one_time_pre_test_error'));
            }
            if($formData['may_i_start_now'] == "no" && isset($submit) && $submit == 'submit'){
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
                $formData['type']     = "pre_test";
                $formData['form']     = $selectedForm;
                $applicationValueObj  = Applicationvalue::where('application_id',$applicationObj->id)->where('type','pre_test')->first();
                unset($formData['_token']);
                unset($formData['submit']);

                unset($formData['code']);
                unset($formData['partner_id']);
                unset($formData['collector_id']);
                if(isset($applicationValueObj->application_id) && !empty($applicationValueObj->application_id)){
                    Applicationvalue::where('application_id',$applicationObj->id)->where('type','pre_test')->update($formData);
                }else{
                    Applicationvalue::create($formData);
                }

                $statusObj              = Status::where('name',"Pre Test No Permission")->first();
                $statusObj1             = Status::where('name',"Pre Test Completed")->first();
                if(!empty($statusObj)){
                    $statusId           = $statusObj->id;
                }else{
                    $statusId           = $statusObj1->id;
                }
                $applicationObj->status         = $statusId;
                $applicationObj->pre_test_date  = date('Y-m-d H:i:s');
                $applicationObj->post_test_date  = date('Y-m-d H:i:s');
                $applicationObj->save();
                $message = trans('messages.pre_test_no_permission');
                DB::table('application_log')->insert([
                    'application_id'    => $applicationObj->id,
                    'causer_id'         => $userObj->id,
                    'text'              => "Application Pre Test No Permission at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                ]);
                return $this->sendResponse($applicationObj->toArray(), $message);
            }else{
                $formData['application_id'] = $applicationObj->id;
                $applicationValueObj        = Applicationvalue::where('application_id',$applicationObj->id)->where('type','pre_test')->first();

                if(isset($submit) && $submit == 'submit'){
                    $scoreArray = $applicationObj->countScore($formData);
                    $naCount    = intval($scoreArray['na_count']);
                    $formData   = array_merge($formData,$scoreArray);
                    unset($formData['na_count']);
                }

                if(isset($applicationValueObj->application_id) && !empty($applicationValueObj->application_id)){
                    Applicationvalue::where('application_id',$applicationObj->id)->where('type','pre_test')->update($formData);
                }else{
                    Applicationvalue::create($formData);
                }
                $applicationValueObj         = Applicationvalue::where('application_id',$applicationObj->id)->where('type','pre_test')->first();
                if($naCount > 3){
                    $statusObj              = Status::where('name',"NA")->first();
                    $applicationObj->status = $statusObj->id;
                    $message = trans('messages.pre_test_draft_saved');
                    DB::table('application_log')->insert([
                        'application_id' => $applicationObj->id,
                        'causer_id' => $userObj->id,
                        'text' => "Application Pretest was NA at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                    ]);
                    $applicationObj->save();
                    return $this->sendResponse($applicationObj->toArray(), "Application submitted as NA");
                }elseif(isset($submit) && $submit == 'save'){
                    $statusObj              = Status::where('name',"Pre Test Pending")->first();
                    $statusObj1             = Status::where('name',"Pre Test")->first();
                    if(!empty($statusObj)){
                        $statusId           = $statusObj->id;
                    }else{
                        $statusId           = $statusObj1->id;
                    }
                    $applicationObj->status = $statusId;
                    $message = trans('messages.pre_test_draft_saved');
                    DB::table('application_log')->insert([
                        'application_id' => $applicationObj->id,
                        'causer_id' => $userObj->id,
                        'text' => "Application Pretest was saved at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                    ]);
                }else{
                    $formData['code'] = $code;
                    $validator = Validator::make($formData, $validationArray);
                    if(!$validator->fails()){
                        $statusObj              = Status::where('name',"Post Test")->first();
                        $statusObj1             = Status::where('name',"Pre Test Completed")->first();
                        if(!empty($statusObj)){
                            $statusId           = $statusObj->id;
                        }else{
                            $statusId           = $statusObj1->id;
                        }
                        $applicationObj->status         = $statusId;
                        $applicationObj->pre_test_date  = date('Y-m-d H:i:s');
                        $message = trans('messages.pre_test_submitted');
                        DB::table('application_log')->insert([
                            'application_id' => $applicationObj->id,
                            'causer_id' => $userObj->id,
                            'text' => "Application Pretest was Submitted succesfully at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                        ]);
                    }else{
                        return $this->sendError("Validation errors",$validator->errors());
                    }
                }
                $applicationObj->save();
                if(isset($submit) && $submit != 'save'){
                    $formData['code'] = $code;
                    $validator = Validator::make($formData, $validationArray);

                    if($validator->fails()){
                        return $this->sendError("Validation errors",$validator->errors());
                    }
                }
                $applicationValueObj1        = Applicationvalue::where('application_id',$applicationObj->id)->where('type','post_test')->first();

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
                unset($formData['emotional_scale']);
                unset($formData['conduct_scale']);
                unset($formData['hyper_activity_scale']);
                unset($formData['peer_problem_scale']);
                unset($formData['pro_social_scale']);
                unset($formData['score']);
                $formData['type']           = "post_test";
                $formData['form']           = $selectedForm;
                unset($formData['_token']);
                unset($formData['submit']);

                unset($formData['code']);
                unset($formData['partner_id']);
                unset($formData['collector_id']);
                if(isset($applicationValueObj1->application_id) && !empty($applicationValueObj1->application_id)){
                    Applicationvalue::where('application_id',$applicationObj->id)->where('type','post_test')->update($formData);
                    DB::table('application_log')->insert([
                        'application_id' => $applicationValueObj1->id,
                        'causer_id' => $userObj->id,
                        'text' => "Application Post-test was created on ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                    ]);
                }else{
                    // $application_id = Applicationvalue::create($formData)->lastInsertId();

                    $application = Applicationvalue::create($formData);

                    $application_id = $application->id;



                    DB::table('application_log')->insert([
                        'application_id' => $application_id,
                        'causer_id' => $userObj->id,
                        'text' => "Application Post-test was created on ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                    ]);
                }
            }
        }else{
            return $this->sendError(trans('messages.application_code_error'));
        }

        $applicationObj = Application::select('application.*','application_value.*','status.name as status_name')
            ->leftJoin('application_value','application_value.application_id','application.id')
            ->leftJoin('status','status.id','application.status')
            ->where('application.id',$applicationObj->id)
            ->first();

        if(isset($applicationObj->code) && !empty($applicationObj->code)){
            return $this->sendResponse($applicationObj->toArray(), $message);
        }else{
            return $this->sendError(trans('messages.something_went_wrong'));
        }
    }

    public function submitPostTest(Request $request){
        $formData = $request->all();

        $validationArray = [
            'code'                                                              => "required",
            'form'                                                              => "required",
            'agency_name'                                                       => 'required',
            'category'                                                          => 'required',
            'donor_name'                                                        => 'required',
            'interview_date' => 'required|before:'.date('Y-m-d',strtotime("+2 day")),
            'interviewers_name'                                                 => 'required',
            'age'                                                               => 'required',
            'gender'                                                            => 'required',
            'nationality'                                                       => 'required',
            'total_number_of_hours_in_your_program'                             => "required|gte:number_of_hours_that_the_child_attended",
            'number_of_hours_that_the_child_attended'                           => "required|lte:total_number_of_hours_in_your_program",
            'dropout_reason'                                                    => "required",
        ];
        $validationArray1 = [
            'considerate_of_other_peoples_feelings'                             => 'required',
            'restless_overactive_cannot_stay_still_for_long'                    => 'required',
            'often_complains_of_headaches_stomach_aches_or_sickness'            => 'required',
            'shares_readily_with_other_children_for_example_toys'               => 'required',
            'often_loses_temper'                                                => 'required',
            'rather_solitary_prefers_to_play_alone'                             => 'required',
            'generally_well_behaved_usually_does_what_adults_request'           => 'required',
            'many_worries_or_often_seems_worried'                               => 'required',
            'helpful_if_someone_is_hurt_upset_or_feeling_ill'                   => 'required',
            'constantly_fidgeting_or_squirming'                                 => 'required',
            'has_at_least_one_good_friend'                                      => 'required',
            'often_fights_with_other_hildren_or_bullies_them'                   => 'required',
            'often_unhappy_depressed_or_tearful'                                => 'required',
            'generally_liked_by_other_children'                                 => 'required',
            'easily_distracted_concentration_wanders'                           => 'required',
            'nervous_or_clingy_in_new_situations_easily_loses_confidence'       => 'required',
            'kind_to_younger_children'                                          => 'required',
            'often_lies_or_cheats'                                              => 'required',
            'picked_on_or_bullied_by_other_children'                            => 'required',
            'thinks_things_out_before_acting'                                   => 'required',
            'steals_from_home_school_or_elsewhere'                              => 'required',
            'gets_along_better_with_adults_than_with_other_children'            => 'required',
            'many_fears_easily_scared'                                          => 'required',
            'good_attention_span_sees_chores_or_homework_through_to_the_end'    => 'required',
            'often_offers_to_help_others'                                       => 'required',
        ];
        if(isset($formData['dropout_reason']) && $formData['dropout_reason'] == "Did Not Drop Out"){
            $validationArray['gouvarnate']                  = "required";
            $validationArray['caza']                        = "required";
            $validationArray['area']                        = "required";
            $validationArray['may_i_start_now']             = "required";
            $validationArray['gateway_type']                = "required";
            if($formData['form'] == "Form 6-11"){
                $validationArray['age'] = "required|integer|between:6,11";
            }else{
                $validationArray['age'] = "required|integer|between:12,17";
            }
            if($formData['nationality'] == "Other Nationality"){
                $validationArray['other_nationality'] = "required|string";
            }
            if(isset($formData['may_i_start_now']) && !empty($formData['may_i_start_now']) && $formData['may_i_start_now'] == "yes"){
                $validationArray = array_merge($validationArray,$validationArray1);
            }
        }else{
            $validationArray['justify_the_dropout_reason']  = "required";
        }

        if( isset($formData['do_the_child_receive_any_other_child_protection_services']) && count($formData['do_the_child_receive_any_other_child_protection_services']) > 0){
            $formData['do_the_child_receive_any_other_child_protection_services'] = implode(",", $formData['do_the_child_receive_any_other_child_protection_services']);
        }
        if(isset($formData['submit']) && $formData['submit'] != 'save'){
            $validator = Validator::make($formData, $validationArray);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
        }

        $userObj            = $this->getUser($formData['token']);
        if(empty($userObj)){
            return $this->sendError(trans('messages.invalid_token'));
        }
        if(intval($userObj->is_readonly) == 1){
            return $this->sendError("access blocked");
        }

        if($userObj->hasrole('partner')){
            $formData['partner_id'] = $userObj->id;
        }

        if($userObj->hasrole('collector')){
            $formData['collector_id'] = $userObj->id;
        }
        unset($formData['token']);
        unset($formData['language']);
        unset($formData['partner_id']);
        unset($formData['collector_id']);
        $formData['child_code'] = $formData['code'];
        $formData['type']           = "post_test";
        $applicationObj             = Application::where('code',$formData['code'])->first();
        if(isset($applicationObj->id) && !empty($applicationObj->id)){
            if($applicationObj->post_test_date != NULL || $applicationObj->post_test_date != null || $applicationObj->post_test_date != ""){
                return $this->sendError(trans('messages.one_time_post_test_error'));
            }
            if($formData['may_i_start_now'] == "no" && isset($formData['submit']) && $formData['submit'] == 'submit'){
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
                $formData['type']     = "post_test";
                $applicationValueObj  = Applicationvalue::where('application_id',$applicationObj->id)->where('type','post_test')->first();
                unset($formData['_token']);
                unset($formData['submit']);

                unset($formData['code']);
                unset($formData['partner_id']);
                unset($formData['collector_id']);
                if(isset($applicationValueObj->application_id) && !empty($applicationValueObj->application_id)){
                    Applicationvalue::where('application_id',$applicationObj->id)->where('type','pre_test')->update($formData);
                }else{
                    Applicationvalue::create($formData);
                }

                $statusObj              = Status::where('name',"Post Test No Permission")->first();
                $statusObj1             = Status::where('name',"Post Test Completed")->first();
                if(!empty($statusObj)){
                    $statusId           = $statusObj->id;
                }else{
                    $statusId           = $statusObj1->id;
                }
                $applicationObj->status         = $statusId;
                $applicationObj->post_test_date  = date('Y-m-d H:i:s');
                $applicationObj->save();
                $message = trans('messages.post_test_no_permission');
                DB::table('application_log')->insert([
                    'application_id'    => $applicationObj->id,
                    'causer_id'         => $userObj->id,
                    'text'              => "Application Post Test No Permission at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                ]);
                return $this->sendResponse($applicationObj->toArray(), $message);
            }else{
                $scoreArray = $applicationObj->countScore($formData);
                if(intval($scoreArray['na_count']) > 3){
                    $statusObj              = Status::where('name',"NA")->first();
                    $applicationObj->status = $statusObj->id;
                    $message = trans('messages.pre_test_draft_saved');
                    DB::table('application_log')->insert([
                        'application_id' => $applicationObj->id,
                        'causer_id' => $userObj->id,
                        'text' => "Application posttest was NA at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                    ]);
                    $applicationObj->save();
                    return $this->sendResponse($applicationObj->toArray(), "Application submitted as NA");
                }elseif(isset($formData['submit']) && $formData['submit'] == 'save'){
                    $statusObj              = Status::where('name',"Post Test Pending")->first();
                    $statusObj1             = Status::where('name',"Post Test")->first();
                    if(!empty($statusObj)){
                        $statusId           = $statusObj->id;
                    }else{
                        $statusId           = $statusObj1->id;
                    }
                    $applicationObj->status = $statusId;
                    $message = trans('messages.post_test_draft_saved');
                    DB::table('application_log')->insert([
                        'application_id' => $applicationObj->id,
                        'causer_id' => $userObj->id,
                        'text' => "Application posttest saved at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                    ]);
                }elseif($formData['dropout_reason'] != "Did Not Drop Out"){
                    $statusObj              = Status::where('name',"Dropout")->first();
                    $statusObj1             = Status::where('name',"Post Test Completed")->first();
                    if(!empty($statusObj)){
                        $statusId           = $statusObj->id;
                    }else{
                        $statusId           = $statusObj1->id;
                    }
                    $applicationObj->status = $statusId;
                    $message = trans('messages.application_dropout');
                    DB::table('application_log')->insert([
                        'application_id' => $applicationObj->id,
                        'causer_id' => $userObj->id,
                        'text' => "Application dropout at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                    ]);
                }else{
                    $statusObj              = Status::where('name',"Done")->first();
                    $statusObj1             = Status::where('name',"Post Test Pending")->first();
                    if(!empty($statusObj)){
                        $statusId           = $statusObj->id;
                    }else{
                        $statusId           = $statusObj1->id;
                    }
                    $applicationObj->status         = $statusId;
                    $applicationObj->post_test_date  = date('Y-m-d H:i:s');
                    $message = trans('messages.post_test_submitted');
                    DB::table('application_log')->insert([
                        'application_id' => $applicationObj->id,
                        'causer_id' => $userObj->id,
                        'text' => "Application Post-test was Submitted succesfully at ".date('d M Y')." by ".str_replace('["', "", str_replace('"]',"", $userObj->getRoleNames()))." ".$userObj->firstname." ".$userObj->firstname
                    ]);

                    if(isset($formData['submit']) && $formData['submit'] == 'submit'){
                        $scoreArray = $applicationObj->countScore($formData);
                        $formData   = array_merge($formData,$scoreArray);
                        unset($formData['na_count']);
                    }
                }

                if(!empty($statusObj)){
                    $statusId           = $statusObj->id;
                }else{
                    $statusId           = $statusObj1->id;
                }
                unset($formData['submit']);
                $formData['application_id']     = $applicationObj->id;
                $applicationObj->save();
                $applicationValueObj            = Applicationvalue::where('application_id',$applicationObj->id)->where('type','post_test')->first();
                if(isset($applicationValueObj->application_id) && !empty($applicationValueObj->application_id)){
                    unset($formData['code']);
                    $applicationValueObj         = Applicationvalue::where('application_id',$applicationObj->id)->where('type','post_test')->update($formData);
                }else{
                    $applicationValueObj         = Applicationvalue::create($formData);
                }
            }
        }else{
            return $this->sendError(trans('messages.something_went_wrong'));
        }

        $applicationObj = Application::select('application.*','application_value.*','status.name as status_name')
            ->leftJoin('application_value','application_value.application_id','application.id')
            ->leftJoin('status','status.id','application.status')
            ->where('application.id',$applicationObj->id)
            ->where('application_value.type',"post_test")
            ->first();

        if(isset($applicationObj->code) && !empty($applicationObj->code)){
            return $this->sendResponse($applicationObj->toArray(), $message);
        }else{
            return $this->sendError(trans('messages.application_code_error'));
        }
    }

    public function getApplication(Request $request){
        $formData = $request->all();
        $userObj  = $this->getUser($request['token']);
        if(empty($userObj)){
            return $this->sendError(trans('messages.invalid_token'));
        }
         $collectorObj       = Collector::where('user_id',$userObj->id)->first();
        if(empty($collectorObj)){
            return $this->sendError("Collector not found or unauthorized user");
        }
        $partnerObj = Partner::where('user_id',$collectorObj->partner_id)->first();
        if(!empty($partnerObj) && !empty($partnerObj->prefix)){
            $collectors = Collector::select('user_id')->where('partner_id',$partnerObj->user_id)->get()->toArray();

            $applicationCount = Application::whereIn('collector_id',$collectors)->count();
        }else{
            $applicationCount = Application::where('collector_id',$userObj->id)->count();
        }

        $applications = Application::select('application.*','status.name as status_name')
            ->leftJoin('status','status.id','application.status')
            ->whereNotIn('application.status',[11,12]);
        if($userObj->hasrole('partner')){
            $collectors = Collector::select('user_id')->where('partner_id',$userObj->id)->get()->toArray();
            $applications->where('partner_id',$userObj->id)->orWhereIn('collector_id',$collectors);
        }elseif($userObj->hasrole('collector')){
            $applications->where('collector_id',$userObj->id);
        }else{
            $applications->where('collector_id',$userObj->id);
        }
        if(isset($formData['status'])){
            $applications->where('application.status',$formData['status']);
        }
        $applications = $applications->get();
        $mainArray['application_count'] = $applicationCount;
        foreach ($applications as $app) {
            $pre_test = Applicationvalue::select('application_value.*','gouvernate.name as gouvername_name','caza.name as caza_name')
            ->leftJoin('gouvernate','gouvernate.id','application_value.gouvarnate')
            ->leftJoin('caza','caza.id','application_value.caza')
            ->where('application_value.application_id',$app->id)
            ->where('application_value.type',"pre_test")->first();
            $post_test = Applicationvalue::select('application_value.*','gouvernate.name as gouvername_name','caza.name as caza_name')
            ->leftJoin('gouvernate','gouvernate.id','application_value.gouvarnate')
            ->leftJoin('caza','caza.id','application_value.caza')
            ->where('application_value.application_id',$app->id)
            ->where('application_value.type',"post_test")->first();
            $app['form']                    = isset($pre_test->form) ? $pre_test->form : "";
            $app['gouvername_name']         = isset($pre_test->gouvername_name) ? $pre_test->gouvername_name : "";
            $app['caza_name']               = isset($pre_test->caza_name) ? $pre_test->caza_name : "";
            $app['pre_test']                = $pre_test;
            $app['post_test']               = $post_test;
            $mainArray['application'][]     = $app;
        }
        return $this->sendResponse($mainArray, "Application List Retrieved");
    }

    public function viewApplication(Request $request){
        $formData = $request->all();
        $userObj  = $this->getUser($request['token']);
        if(empty($userObj)){
            return $this->sendError(trans('messages.invalid_token'));
        }
        $validationArray = [
            'code' => "required"
        ];
        $validator = Validator::make($formData, $validationArray);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $applicationObj = Application::select('application.*','part.firstname as partner_name','col.firstname as collector_name','status.name as status_name')
            ->leftJoin('users as col','col.id','application.collector_id')
            ->leftJoin('users as part','part.id','application.partner_id')
            ->leftJoin('status','status.id','application.status')
            ->where('application.code',$formData['code'])->first();
        if(empty($applicationObj)){
            return $this->sendError('Application not found or invalid code');
        }
        $preTestData = Applicationvalue::select('application_value.*','gouvernate.name as gouvername_name','caza.name as caza_name','area.name as area_name')
            ->leftJoin('gouvernate','gouvernate.id','application_value.gouvarnate')
            ->leftJoin('caza','caza.id','application_value.caza')
            ->leftJoin('area','area.id','application_value.area')
            ->where('application_value.application_id',$applicationObj->id)
            ->where('application_value.type',"pre_test")->first();
        $postTestData = Applicationvalue::select('application_value.*','gouvernate.name as gouvername_name','caza.name as caza_name','area.name as area_name')
            ->leftJoin('gouvernate','gouvernate.id','application_value.gouvarnate')
            ->leftJoin('caza','caza.id','application_value.caza')
            ->leftJoin('area','area.id','application_value.area')
            ->where('application_value.application_id',$applicationObj->id)
            ->where('application_value.type',"post_test")->first();
        $data = [
            'application' => $applicationObj->toArray(),
            'pre_test' => !empty($preTestData) ? $preTestData->toArray() : [],
            'post_test' => !empty($postTestData) ? $postTestData->toArray() : []
        ];
        return $this->sendResponse($data, "Application Data Retrieved");
    }

    public function getPreTest(Request $request){
        $formData = $request->all();
        $userObj  = $this->getUser($request['token']);
        if(empty($userObj)){
            return $this->sendError(trans('messages.invalid_token'));
        }

        $validationArray = [
            'code' => "required"
        ];
        $validator = Validator::make($formData, $validationArray);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $applicationObj = Application::where('code',$formData['code'])->first();
        if(empty($applicationObj)){
            return $this->sendError(trans('messages.application_code_error'));
        }
        $preTestObj = Applicationvalue::select('application_value.*','application.*','gouvernate.name as gouvarnate_name','caza.name as caza_name','status.name as status_name')
            ->leftJoin('application','application.id','application_value.application_id')
            ->leftJoin('gouvernate','gouvernate.id','application_value.gouvarnate')
            ->leftJoin('caza','caza.id','application_value.caza')
            ->leftJoin('status','status.id','application.status')
            ->where('application_value.type','pre_test')
            ->where('application.code',$formData['code'])
            ->first();

        if(empty($preTestObj)){
            $applicationObj = Applicationvalue::create([
                'application_id' => $applicationObj->id,
                'type' => "pre_test"
            ]);

            $preTestObj = Applicationvalue::select('application_value.*','application.*','gouvernate.name as gouvarnate_name','caza.name as caza_name','status.name as status_name')
                ->leftJoin('application','application.id','application_value.application_id')
                ->leftJoin('gouvernate','gouvernate.id','application_value.gouvarnate')
                ->leftJoin('caza','caza.id','application_value.caza')
                ->leftJoin('status','status.id','application.status')
                ->where('application_value.type','pre_test')
                ->where('application.code',$formData['code'])
                ->first();
        }

        $forms = Form::get();
        $gouvernates = Gouvernate::all();
        $data = [
            'preTestObj' => $preTestObj->toArray(),
            'forms' => $forms->toArray(),
            'gouvernates' => $gouvernates->toArray()
        ];
        return $this->sendResponse($data, "Application Data Retrieved");
    }

    public function getPostTest(Request $request){
        $formData = $request->all();
        $userObj  = $this->getUser($request['token']);
        if(empty($userObj)){
            return $this->sendError(trans('messages.invalid_token'));
        }

        $validationArray = [
            'code' => "required"
        ];
        $validator = Validator::make($formData, $validationArray);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $applicationObj = Application::where('code',$formData['code'])->first();
        if(empty($applicationObj)){
            return $this->sendError(trans('messages.application_code_error'));
        }
        $preTestObj = Applicationvalue::select('application_value.*','application.*','gouvernate.name as gouvarnate_name','caza.name as caza_name','status.name as status_name')
            ->leftJoin('application','application.id','application_value.application_id')
            ->leftJoin('gouvernate','gouvernate.id','application_value.gouvarnate')
            ->leftJoin('caza','caza.id','application_value.caza')
            ->leftJoin('status','status.id','application.status')
            ->where('application_value.type','post_test')
            ->where('application.code',$formData['code'])
            ->first();

        if(empty($preTestObj)){
            $applicationObj = Applicationvalue::create([
                'application_id' => $applicationObj->id,
                'type' => "post_test"
            ]);

            $preTestObj = Applicationvalue::select('application_value.*','application.*','gouvernate.name as gouvarnate_name','caza.name as caza_name','status.name as status_name')
                ->leftJoin('application','application.id','application_value.application_id')
                ->leftJoin('gouvernate','gouvernate.id','application_value.gouvarnate')
                ->leftJoin('caza','caza.id','application_value.caza')
                ->leftJoin('status','status.id','application.status')
                ->where('application_value.type','post_test')
                ->where('application.code',$formData['code'])
                ->first();
        }
        $forms = Form::get();
        $gouvernates = Gouvernate::all();
        $data = [
            'preTestObj' => $preTestObj->toArray(),
            'forms' => $forms->toArray(),
            'gouvernates' => $gouvernates->toArray()
        ];
        return $this->sendResponse($data, "Application Data Retrieved");
    }
}
