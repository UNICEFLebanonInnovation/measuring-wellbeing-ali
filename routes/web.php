<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('cache', function () {
	Artisan::call('cache:clear');
	Artisan::call('view:clear');
	Artisan::call('route:clear');
	Artisan::call('config:cache');
	Artisan::call('config:clear');
	echo "Cache is cleared";
	exit();
});

Route::get('/', 'Auth\LoginController@index');
Route::get('locale/{locale}', function ($locale) {
	/*Session::put('locale', $locale);
    App::setLocale($locale);*/
	App::setLocale($locale);
	session()->put('locale', $locale);
	return redirect()->back();
});

Route::get('save-filter/{year}', function ($year) {
	session()->put('year', $year);
	return redirect()->back();
});

Route::get('clear-filter', function () {
	session()->forget('from');
	session()->forget('to');
	return redirect()->back();
});

Route::any('filter', function () {
	$formData = Request::all();
	if(isset($formData['to'])){
		session()->put('to', $formData['to']);
	}
	if(isset($formData['from'])){
		session()->put('from', $formData['from']);
		$alertString = '<li>Number of Done applications per Governate from X number of selected application range:</li>';
		$Gouvernate = App\Gouvernate::all();
		foreach ($Gouvernate as $gov) {
			$data =  App\Application::select('application.id')
				->leftJoin('application_value', 'application_value.application_id', 'application.id')
				->where('application_value.type', "post_test")
				->distinct();
			if (Auth::user()->hasrole('partner')) {
				$data->where('application.partner_id', Auth::user()->id);
				$collectors = App\Collector::select('user_id')->where('partner_id', Auth::user()->id)->get()->toArray();
				$data->orWhereIn('application.collector_id', $collectors);
			}

			if (Auth::user()->hasrole('collector')) {
				$data->where('application.collector_id', Auth::user()->id);
			}
			$data = $data->take(session()->get('from'))->where('application_value.gouvarnate',$gov->id)->get()->count();

			$alertString .= '<li>'.$gov->name.' => '.$data.'</li>';
		}
	 	return redirect()->back()->with('filterrange',$alertString);
	}
	return redirect()->back();
 });

Route::get('/blank-page', 'DashboardController@blankPage');

/*Login Module*/
Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('login-post', 'Auth\LoginController@doLogin');
Route::any('setup-profile/{key}', 'ProfileController@index')->name('setup-profile');
/*Login Module*/

/*Forgot Password*/
Route::get('/forgot-password', 'Auth\ForgotPasswordController@index');
Route::post('/send-forgot-password-link', 'Auth\ForgotPasswordController@sendForgotPasswordLink');
Route::get('/reset-password/{key}', 'Auth\ForgotPasswordController@reset')->name('reset-password');
Route::post('/savePassword', 'Auth\ResetPasswordController@resetPassword')->name('savePassword');
/*Forgot Password*/

Route::group(['middleware' => ['auth', 'localization']], function () {
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
	Route::any('get-caza', 'CazaController@getAjazCaza')->name('getAjazCaza');
	Route::any('get-area', 'AreaController@getAjazArea')->name('getAjazArea');

	/*Application Module*/
	Route::get('application-list', 'ApplicationController@index');
	Route::any('view-application/{code}', 'ApplicationController@viewApplication')->name('view-application');
	Route::post('load-application-list', 'ApplicationController@loadApplication')->name('loadApplication');
	Route::group(['middleware' => ['role:partner|collector']], function () {
		Route::any('add-application', 'ApplicationController@add');
		Route::any('create-application', 'ApplicationController@generateApplication');
		Route::any('pre-test-application/{code}', 'ApplicationController@getPreTest')->name('pre-test-application');

		Route::any('ajax-message-change', 'ApplicationController@messageChange')->name('ajax-message-change');

		Route::any('save-pre-test-application', 'ApplicationController@savePreTest');
		Route::any('post-test-application/{code}', 'ApplicationController@getPostTest')->name('post-test-application');
		Route::any('save-post-test-application', 'ApplicationController@savePostTest');
		Route::post('delete-application', 'ApplicationController@delete')->name('delete-application');
	});
	/*Application Module*/

// Change Decrease   List
	Route::get('change-decrease-list', 'ChangeDecreaseController@index')->name('change-decrease-list');
	Route::post('load-change-decrease-list', 'ChangeDecreaseController@loadApplication')->name('loadChangeDecrease');
	Route::post('reason-from', 'ChangeDecreaseController@ReasonFrom')->name('reason-from');
// Change Decrease   List

	Route::group(['middleware' => ['role:admin']], function () {

		/*User Module*/
		Route::get('admin-list', 'UserController@index');
		Route::post('load-admin-list', 'UserController@loadAdmin')->name('loadAdmin');
		Route::any('add-admin', 'UserController@add');
		Route::any('edit-admin/{id}', 'UserController@edit')->name('edit-admin');
		Route::post('activate-admin', 'UserController@activate')->name('activate-admin');
		/*User Module*/

		/*Partner Module*/
		Route::get('partners-list', 'PartnersController@index');
		Route::post('load-partner-list', 'PartnersController@loadPartnter')->name('loadPartnter');
		Route::any('add-partners', 'PartnersController@add');
		Route::get('view-partners/{id}', 'PartnersController@view')->name('view-partners');
		Route::post('load-provider-collector-list', 'PartnersController@loadCollector')->name('loadProvidersCollector');
		Route::any('edit-partners/{id}', 'PartnersController@edit')->name('edit-partners');
		Route::post('activate-partner', 'PartnersController@activate')->name('activate-partner');
		Route::post('readonly-partner', 'PartnersController@readonly')->name('readonly-partner');
		Route::post('delete-partner', 'PartnersController@delete')->name('delete-partner');
		/*Partner Module*/

		/*Form Module*/
		Route::get('form-list', 'FormController@index');
		Route::get('form-edit/{form_name}', 'FormController@getForm');
		Route::post('load-form-list', 'FormController@loadForm')->name('loadForm');
		/*Form Module*/

		/*Gouvernate Module*/
		Route::get('gouvernate-list', 'GouvernateController@index');
		Route::any('add-gouvernate', 'GouvernateController@add');
		Route::post('load-gouvernate-list', 'GouvernateController@loadGouvernate')->name('loadGouvernate');
		Route::any('edit-gouvernate/{id}', 'GouvernateController@edit')->name('edit-gouvernate');
		Route::post('delete-gouvernate', 'GouvernateController@delete')->name('delete-gouvernate');
		/*Gouvernate Module*/

		/*Caza Module*/
		Route::get('caza-list', 'CazaController@index');
		Route::any('add-caza', 'CazaController@add');
		Route::post('load-caza-list', 'CazaController@loadCaza')->name('loadCaza');
		Route::any('edit-caza/{id}', 'CazaController@edit')->name('edit-caza');
		Route::post('delete-caza', 'CazaController@delete')->name('delete-caza');
		/*Caza Module*/

		/*Area Module*/
		Route::get('area-list', 'AreaController@index');
		Route::any('add-area', 'AreaController@add');
		Route::post('load-area-list', 'AreaController@loadArea')->name('loadArea');
		Route::any('edit-area/{id}', 'AreaController@edit')->name('edit-area');
		Route::post('delete-area', 'AreaController@delete')->name('delete-area');
		/*Area Module*/

		/*Status Module*/
		Route::get('status-list', 'StatusController@index');
		Route::any('add-status', 'StatusController@add');
		Route::post('load-status-list', 'StatusController@loadStatus')->name('loadStatus');
		Route::any('edit-status/{id}', 'StatusController@edit')->name('edit-status');
		Route::post('delete-status', 'StatusController@delete')->name('delete-status');
		/*Status Module*/

	});

	Route::group(['middleware' => ['role:admin|partner']], function () {
		/*Export Applications*/
		Route::get('export-applications', 'ApplicationController@export')->name('export-applications');

		Route::get('/dashboard', 'DashboardController@index');
		Route::any('load-dashboard', 'DashboardController@loadDashboard')->name('loadDashboard');
		Route::get('/reports', 'ReportController@index');
		Route::any('load-reports', 'ReportController@loadReports')->name('load-reports');
		Route::get('/analytics', 'ReportController@analytics');

		/*Collector Module*/
		Route::get('collector-list', 'CollectorsController@index');
		Route::post('load-collector-list', 'CollectorsController@loadCollector')->name('loadCollector');
		Route::any('add-collector', 'CollectorsController@add');
		Route::any('edit-collector/{id}', 'CollectorsController@edit')->name('edit-collector');
		Route::post('delete-collector', 'CollectorsController@delete')->name('delete-collector');
		Route::post('activate-collector', 'CollectorsController@activate')->name('activate-collector');
		Route::post('readonly-collector', 'CollectorsController@readonly')->name('readonly-collector');
		/*Collector Module*/
		Route::any('change-collector/{code}', 'ApplicationController@changeCollector')->name('change-collector');

		/*Grapha*/
		Route::any('reason-for-dropout', 'ReportController@reasonForDropout')->name('reason-for-dropout');
		Route::any('load-reason-for-dropout', 'ReportController@loadReasonForDropout')->name('load-reason-for-dropout');
		Route::any('load-partner-dropout', 'ReportController@loadPartnerDropout')->name('load-partner-dropout');

		Route::any('normal-conparison', 'ReportController@noramlComparison')->name('normal-conparison');
		Route::any('load-normal-conparison', 'ReportController@loadNoramlComparison')->name('load-normal-conparison');
		Route::any('6-11-comparision', 'ReportController@age_6_11')->name('6-11-comparision');
		Route::any('12-17-comparision', 'ReportController@age_12_17')->name('12-17-comparision');

		Route::any('partner-analysys', 'ReportController@partnerAnalysys')->name('partner-analysys');
		Route::any('load-partner-analysys', 'ReportController@loadPartnerAnalysys')->name('load-partner-analysys');
		Route::any('load-partner-analysys1', 'ReportController@loadPartnerAnalysys1')->name('load-partner-analysys1');

		Route::any('gov-analysys', 'ReportController@govAnalysys')->name('gov-analysys');
		Route::any('load-gov-analysys', 'ReportController@loadGovAnalysys')->name('load-gov-analysys');
		Route::any('load-gov-analysys1', 'ReportController@loadGovAnalysys1')->name('load-gov-analysys1');

		Route::any('increase-scale', 'ReportController@increaseScale')->name('increase-scale');
		Route::any('load-increase-scale', 'ReportController@loadIncreaseScale')->name('load-increase-scale');

		Route::any('uncompleted-per-ngo', 'ReportController@uncompletedPerNgo')->name('uncompleted-per-ngo');
		Route::any('load-uncompleted-per-ngo', 'ReportController@loaduncompletedPerNgo')->name('load-uncompleted-per-ngo');

		Route::get('sdq-analysis-data', 'ReportController@analysisData')->name('sdq-analysis-data');
		Route::any('load-sdq-analysis-data', 'ReportController@loadanalysisData')->name('load-sdq-analysis-data');

		Route::any('load-sdq-analysis-ajax', 'ReportController@loadSdqAnalysisAjax')->name('load-sdq-analysis-ajax');

		Route::get('analysis-change', 'ReportController@analysisChange')->name('analysis-change');
		Route::any('load-analysis-change', 'ReportController@loadanalysisChange')->name('load-analysis-change');
		Route::any('load-analysis-change1', 'ReportController@loadanalysisChange1')->name('load-analysis-change1');
	});

	Route::any('get-location', 'GouvernateController@getLocation')->name('getLocation');
});