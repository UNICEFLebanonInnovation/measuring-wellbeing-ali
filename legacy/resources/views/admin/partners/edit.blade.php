@extends('admin.layout.app')

@section('title',"Edit Partner")

@section('breadcrumb')
	<a href="{{ url('/partners-list') }}">Partners List</a>
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
							Edit Partner
						</h3>
					</div>
				</div>
			</div>

			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="add_partner" method="post" action="{{ route('edit-partners',$partnerObj->id) }}" enctype="multipart/form-data">
				@csrf
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Partner Name:</label>
							<input type="text" class="form-control m-input" value="{{ $partnerObj->name }}" id="partner_name" name="partner_name" placeholder="Enter partner name">
							@if ($errors->has('partner_name'))
			                  	<span class="m-form__help">{{ $errors->first('partner_name') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Partner Prefix:</label>
							<input type="text" class="form-control m-input" value="{{ $partnerObj->prefix }}" id="prefix" name="prefix" placeholder="Enter partner prefix">
							@if ($errors->has('prefix'))
			                  	<span class="m-form__help">{{ $errors->first('prefix') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>First Name:</label>
							<input type="text" class="form-control m-input" value="{{ $partnerObj->firstname }}" id="firstname" name="firstname" placeholder="Enter first name">
							@if ($errors->has('firstname'))
			                  	<span class="m-form__help">{{ $errors->first('firstname') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Last Name:</label>
							<input type="text" class="form-control m-input" value="{{ $partnerObj->lastname }}" id="lastname" name="lastname" placeholder="Enter last name">
							@if ($errors->has('lastname'))
			                  	<span class="m-form__help">{{ $errors->first('lastname') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Email:</label>
							<input type="email" class="form-control m-input" value="{{ $partnerObj->email }}" id="email" name="email" placeholder="Enter an email address">
							@if ($errors->has('email'))
			                  	<span class="m-form__help">{{ $errors->first('email') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Address:</label>
							<textarea class="form-control m-input" id="address" name="address" placeholder="Enter address">{{ $partnerObj->address }}</textarea>
							@if ($errors->has('address'))
			                  	<span class="m-form__help">{{ $errors->first('address') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Max no. of codes:</label>
							<input type="number" class="form-control m-input" value="{{ $partnerObj->max_app_per_year }}" id="max_code" name="max_code" placeholder="Enter max no. of codes">
							@if ($errors->has('max_code'))
			                  	<span class="m-form__help">{{ $errors->first('max_code') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Phone:</label>
							<input type="text" class="form-control m-input" value="{{ $partnerObj->phone }}" id="phone" name="phone" placeholder="Enter Phone">
							@if ($errors->has('phone'))
			                  	<span class="m-form__help">{{ $errors->first('phone') }}</span>
			              	@endif
						</div>
					</div>
					{{-- <div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Fax:</label>
							<input type="text" class="form-control m-input" value="{{ $partnerObj->fax }}" id="fax" name="fax" placeholder="Enter Fax">
							@if ($errors->has('fax'))
			                  	<span class="m-form__help">{{ $errors->first('fax') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Zone:</label>
							<input type="text" class="form-control m-input" value="{{ $partnerObj->zone }}" id="zone" name="zone" placeholder="Enter zone">
							@if ($errors->has('zone'))
			                  	<span class="m-form__help">{{ $errors->first('zone') }}</span>
			              	@endif
						</div>
					</div> --}}
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label class="">Partner Logo:</label>
							<div class="row">
								<div class="col-lg-8">
									<input type="file" class="form-control m-input" id="partner_logo" name="partner_logo" placeholder="Select partner logo">
								</div>
								@if(!empty($partnerObj->logo))
									<div class="col-lg-4">
										<img src="{{ url('/public') }}/images/partner_logo/{{ $partnerObj->logo }}" alt="" height="150px;" width="200px;">
									</div>
				              	@endif
							</div>
							@if ($errors->has('partner_logo'))
			                  	<span class="m-form__help">{{ $errors->first('partner_logo') }}</span>
			              	@endif
						</div>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions--solid">
						<div class="row">
							<div class="col-lg-10"></div>
							<div class="col-lg-2">
								<button type="submit" class="btn btn-info">Save</button>
								<a href="javascript:void(0)" onclick="back()" class="btn btn-secondary">Back</a>
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

@section('js')
<script type="text/javascript">
   $(document).ready(function(){
      $("#add_partner").validate({
         rules:{
         	partner_name:{
         		required:true
         	},
         	prefix:{
         		required:true
         	},
            email:{
               required:true,
               email:true,
            },
            firstname:{
         		required:true
         	},
         	lastname:{
         		required:true
         	},
         	address:{
         		required:true
         	},
         	phone:{
         		required:true
         	},
         	max_code:{
         		required:true
         	},

         },
         messages:{
            email:{
               required:"Please enter your email",
               email:"Please enter your valid email",
            },
            partner_name:{
         		required:"Please enter partner name"
         	},
         	prefix:{
         		required:"Please enter prefix"
         	},
            firstname:{
         		required:"Please enter firstname"
         	},
         	lastname:{
         		required:"Please enter lastname"
         	},
         	address:{
         		required:"Please enter address"
         	},
         	phone:{
         		required:"Please enter phone"
         	},
         	max_code:{
         		required:"Please enter max no. of codes"
         	},
         }
      })
   });
   function back(){
		swal({
            title: "There are unsaved content, are you sure you want to leave?",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then(function(result){
            if (result.value) {
                window.location.href = "{{ url('partners-list') }}"
            }
    	});
	}
</script>
@endsection