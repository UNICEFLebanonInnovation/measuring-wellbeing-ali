<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Application;

use App\Partner;

use App\Status;

use App\Collector;

use Auth;

use Session;

class DashboardController extends Controller

{

    public function index(Request $request){

    	if(Auth::user()->hasRole('collector')){

            $partners 		= Partner::all();

	    	$collectors 	= Collector::all();

	    	return view('admin.application.list',compact('partners','collectors'));

        }

    	return view('admin.dashboard');

    }



    public function loadDashboard(Request $request){

		$formData 	= $request->all();

		if(Auth::user()->hasRole('admin')){

    		$data 		= Partner::select('partners.*','users.firstname','users.lastname')

    			->leftJoin('users','users.id','partners.user_id');

    		return datatables()->of($data)

	    		->addColumn('name',function($data){

	               	return ucfirst($data->name);

	            })

	            ->addColumn('month',function($data){

	               	return "April";

	            })

	            ->addColumn('pre_test_pending',function($data){

	            	$collectors = Collector::select('user_id')->where('partner_id',$data->user_id)->get()->toArray();

	               	$applicationCount = Application::orWhereIn('collector_id',$collectors)->where('status',3);

		    		if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?partner='.$data->user_id."&status=3").'" >'.$applicationCount.'</a>';

	            })

	            ->addColumn('pending',function($data){

	               	$collectors = Collector::select('user_id')->where('partner_id',$data->user_id)->get()->toArray();

	               	$applicationCount = Application::orWhereIn('collector_id',$collectors)->where('status',5);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?partner='.$data->user_id."&status=5").'" >'.$applicationCount.'</a>';

	            })

	            ->addColumn('in_prgress',function($data){

	               	$collectors = Collector::select('user_id')->where('partner_id',$data->user_id)->get()->toArray();

	               	$applicationCount = Application::orWhereIn('collector_id',$collectors)->where('status',6);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?partner='.$data->user_id."&status=6").'" >'.$applicationCount.'</a>';

	            })

	            ->addColumn('na',function($data){

	               	$collectors = Collector::select('user_id')->where('partner_id',$data->user_id)->get()->toArray();

	               	$applicationCount = Application::orWhereIn('collector_id',$collectors)->where('status',12);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?partner='.$data->user_id."&status=12").'" >'.$applicationCount.'</a>';

	            })
	            ->addColumn('dropout',function($data){

	               	$collectors = Collector::select('user_id')->where('partner_id',$data->user_id)->get()->toArray();

	               	$applicationCount = Application::orWhereIn('collector_id',$collectors)->where('status',9);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?partner='.$data->user_id."&status=9").'" >'.$applicationCount.'</a>';

	            })
	            ->addColumn('pre_np',function($data){

	               	$collectors = Collector::select('user_id')->where('partner_id',$data->user_id)->get()->toArray();

	               	$applicationCount = Application::orWhereIn('collector_id',$collectors)->where('status',10);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?partner='.$data->user_id."&status=10").'" >'.$applicationCount.'</a>';

	            })
	            ->addColumn('post_np',function($data){

	               	$collectors = Collector::select('user_id')->where('partner_id',$data->user_id)->get()->toArray();

	               	$applicationCount = Application::orWhereIn('collector_id',$collectors)->where('status',11);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?partner='.$data->user_id."&status=11").'" >'.$applicationCount.'</a>';

	            })

	            ->addColumn('completed',function($data){

	               	$collectors = Collector::select('user_id')->where('partner_id',$data->user_id)->get()->toArray();

	               	$applicationCount = Application::orWhereIn('collector_id',$collectors)->where('status',8);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?partner='.$data->user_id."&status=8").'" >'.$applicationCount.'</a>';

	            })

	            ->addColumn('remaining',function($data){

	               	$applicationCount 		= $data->max_app_per_year;

	               	$collectors 			= Collector::select('user_id')->where('partner_id',$data->user_id)->get()->toArray();

	               	$existingApplications 	= Application::orWhereIn('collector_id',$collectors);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$existingApplications->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            $existingApplications = $existingApplications->get()->count();

	               	return intval(intval($applicationCount) - intval($existingApplications));

	            })

	            ->addColumn('total',function($data){

	               	$applicationCount = $data->max_app_per_year;

	               	return $applicationCount;

	            })

	            ->rawColumns(['dropout','pre_test_pending','pending','in_prgress','completed','na','post_np','pre_np'])->make(true);

		}



		if(Auth::user()->hasRole('partner')){

    		$data 	= Collector::select('collectors.*','users.firstname','users.lastname')

    			->leftJoin('users','users.id','collectors.user_id')

    			->where('collectors.partner_id',Auth::user()->id);

    			if(isset($formData['order'][0])){

	                if(isset($formData['order'][0]['column']) == 1){

	                    $data->orderBy('name',$formData['order'][0]['dir']);

	                }else{

	                    $data->orderBy('id','desc');

	                }

            	}

    		return datatables()->of($data)

	    		->addColumn('name',function($data){

	               	return ucfirst($data->name);

	            })

	            ->addColumn('month',function($data){

	               	return "April";

	            })

	            ->addColumn('pre_test_pending',function($data){

	               	$applicationCount = Application::where('collector_id',$data->user_id)->where('status',3);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?collector='.$data->user_id."&status=3").'" >'.$applicationCount.'</a>';

	               	return $applicationCount;

	            })

	            ->addColumn('pending',function($data){

	               	$applicationCount = Application::where('collector_id',$data->user_id)->where('status',5);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?collector='.$data->user_id."&status=5").'" >'.$applicationCount.'</a>';

	            })

	            ->addColumn('in_prgress',function($data){

	               	$applicationCount = Application::where('collector_id',$data->user_id)->where('status',6);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?collector='.$data->user_id."&status=6").'" >'.$applicationCount.'</a>';

	            })
	            ->addColumn('na',function($data){

	               	$applicationCount = Application::where('collector_id',$data->user_id)->where('status',12);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?collector='.$data->user_id."&status=12").'" >'.$applicationCount.'</a>';

	            })
	            ->addColumn('dropout',function($data){

	               	$applicationCount = Application::where('collector_id',$data->user_id)->where('status',9);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?collector='.$data->user_id."&status=9").'" >'.$applicationCount.'</a>';

	            })
	            ->addColumn('pre_np',function($data){

	               	$applicationCount = Application::where('collector_id',$data->user_id)->where('status',10);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?collector='.$data->user_id."&status=10").'" >'.$applicationCount.'</a>';

	            })
	            ->addColumn('post_np',function($data){

	               	$applicationCount = Application::where('collector_id',$data->user_id)->where('status',11);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?collector='.$data->user_id."&status=11").'" >'.$applicationCount.'</a>';

	            })
	            ->addColumn('completed',function($data){

	               	$applicationCount = Application::where('collector_id',$data->user_id)->where('status',8);

	               	if(Session::has('year') && !empty(Session::get('year'))){

		    			$applicationCount->whereDate('application.pre_test_date','LIKE',Session::get('year')."%");

		            }

		            if((Session::has('from') && !empty(Session::get('from')))){

						$applicationCount->limit(Session::get('from'))->where('status',8);

						/*$applicationCount->where('application.id',"<=",Session::get('to'));*/

			        }

		            $applicationCount = $applicationCount->get()->count();

	               	return $filter = '<a href="'.url('application-list?collector='.$data->user_id."&status=8").'" >'.$applicationCount.'</a>';

	            })

	            ->addColumn('remaining',function($data){

	            	$partnerObj = Partner::select('partners.*')->where('user_id',Auth::user()->id)->first();

	            	$applicationCount = Application::where('collector_id',$data->user_id)->get()->count();

	            	if(isset($partnerObj->max_app_per_year) && intval($partnerObj->max_app_per_year) > 0){

	            		return $applicationCount."/".$partnerObj->max_app_per_year;

	            	}else{

	            		return $applicationCount;

	            	}

	            })

	            ->addColumn('total',function($data){

	               	$applicationCount = Application::where('collector_id',$data->user_id)->get()->count();

	               	return $applicationCount;

	            })

	            ->rawColumns(['dropout','pre_test_pending','pending','in_prgress','completed','na','pre_np','post_np'])->make(true);

		}
    	if(request()->ajax()){


    	}

    }



    public function blankPage(Request $request){

    	return view('admin.blank');

    }

}

