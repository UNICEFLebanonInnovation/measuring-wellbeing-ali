@extends('admin.layout.app')

@section('title',"Add Partner")

@section('breadcrumb')
	<a href="{{ url('form-list') }}">Add Partner</a>
@endsection

@section('css')
<link href="{{ url('/public') }}/assets/vendors/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">

		<!--begin::Portlet-->
		<div class="m-portlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
							<i class="la la-gear"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Add Partner
						</h3>
					</div>
				</div>
			</div>

			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Partner Name:</label>
							<input type="text" class="form-control m-input" id="partner_name" name="partner_name" placeholder="Enter partner name">
							{{-- <span class="m-form__help">Please enter your full name</span> --}}
						</div>
						<div class="col-lg-6">
							<label class="">Partner Logo:</label>
							<input type="file" class="form-control m-input" id="partner_logo" name="partner_logo" placeholder="Select partner logo">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>First Name:</label>
							<input type="text" class="form-control m-input" id="firstname" name="firstname" placeholder="Enter first name">
							{{-- <span class="m-form__help">Please enter your full name</span> --}}
						</div>
						<div class="col-lg-6">
							<label>Last Name:</label>
							<input type="text" class="form-control m-input" id="lastname" name="lastname" placeholder="Enter last name">
							{{-- <span class="m-form__help">Please enter your full name</span> --}}
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Email:</label>
							<input type="email" class="form-control m-input" id="email" name="email" placeholder="Enter an email address">
							{{-- <span class="m-form__help">Please enter your full name</span> --}}
						</div>
						<div class="col-lg-6">
							<label>Address:</label>
							<textarea class="form-control m-input" id="address" name="address" placeholder="Enter address"></textarea>
							{{-- <span class="m-form__help">Please enter your full name</span> --}}
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Max no. of codes:</label>
							<input type="number" class="form-control m-input" id="max_code" name="max_code" placeholder="Enter max no. od codes">
							{{-- <span class="m-form__help">Please enter your full name</span> --}}
						</div>
						<div class="col-lg-6">
							<label>Phone:</label>
							<input type="text" class="form-control m-input" id="phone" name="phone" placeholder="Enter last name">
							{{-- <span class="m-form__help">Please enter your full name</span> --}}
						</div>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions--solid">
						<div class="row">
							<div class="col-lg-10"></div>
							<div class="col-lg-2">
								<button type="submit" class="btn btn-info">Save</button>
								<button type="reset" class="btn btn-secondary">Reset</button>
							</div>
						</div>
					</div>
				</div>
			</form>

			<!--end::Form-->
		</div>

		<!--end::Portlet-->
	</div>
</div>
@endsection