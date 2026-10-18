@extends('admin.layout.app')

@section('title',"Edit Collector")

@section('breadcrumb')
	<a href="{{ url('/collector-list') }}">Collector</a>
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
							Edit Collector
						</h3>
					</div>
				</div>
			</div>

			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="edit_collector" method="post" action="{{ route('edit-collector',$collectorObj->id) }}">
				@csrf
				<div class="m-portlet__body">
					{{-- <div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Collector Name:</label>
							<input type="text" class="form-control m-input" id="name" value="{{ $collectorObj->name }}" name="name" placeholder="Enter first name">
							@if ($errors->has('name'))
			                  	<span class="m-form__help">{{ $errors->first('name') }}</span>
			              	@endif
						</div>
					</div> --}}
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>First Name:</label>
							<input type="text" class="form-control m-input" id="firstname" value="{{ $collectorObj->firstname }}" name="firstname" placeholder="Enter first name">
							@if ($errors->has('firstname'))
			                  	<span class="m-form__help">{{ $errors->first('firstname') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Last Name:</label>
							<input type="text" class="form-control m-input" id="lastname" value="{{ $collectorObj->lastname }}" name="lastname" placeholder="Enter last name">
							@if ($errors->has('lastname'))
			                  	<span class="m-form__help">{{ $errors->first('lastname') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Collector Prefix:</label>
							<input type="text" class="form-control m-input" value="{{ $collectorObj->prefix }}" id="prefix" name="prefix" placeholder="Enter partner prefix">
							@if ($errors->has('prefix'))
			                  	<span class="m-form__help">{{ $errors->first('prefix') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Email:</label>
							<input type="email" class="form-control m-input" id="email" value="{{ $collectorObj->email }}" name="email" placeholder="Enter an email address">
							@if ($errors->has('email'))
			                  	<span class="m-form__help">{{ $errors->first('email') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>City:</label>
							<input type="text" class="form-control m-input" id="city" value="{{ $collectorObj->city }}" name="city" placeholder="Enter City">
							@if ($errors->has('city'))
			                  	<span class="m-form__help">{{ $errors->first('city') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Phone:</label>
							<input type="text" class="form-control m-input" id="phone" value="{{ $collectorObj->phone }}" name="phone" placeholder="Enter Phone">
							@if ($errors->has('phone'))
			                  	<span class="m-form__help">{{ $errors->first('phone') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						{{-- <div class="col-lg-6">
							<label>Zone:</label>
							<select class="form-control m-input" id="zone" name="zone">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
							@if ($errors->has('zone'))
			                  	<span class="m-form__help">{{ $errors->first('zone') }}</span>
			              	@endif
						</div> --}}
						<div class="col-lg-6">
							<label>Address:</label>
							<textarea class="form-control m-input" id="address" name="address" placeholder="Enter address">{{ $collectorObj->address }}</textarea>
							@if ($errors->has('address'))
			                  	<span class="m-form__help">{{ $errors->first('address') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Is Subpartner</label>
							<div class="row">
								<div class="col-lg-4">
									<div class="m-checkbox-list">
										<label class="m-checkbox m-checkbox--state-primary">
											<input type="checkbox" {{ $collectorObj->is_subpartner == 1 ? 'checked':"" }} name="is_sub" value="1"> Is Subpartner
											<span></span>
										</label>
									</div>
								</div>
								<div class="col-lg-8">
									<input type="text" class="form-control m-input" id="sub_partner" value="{{ $collectorObj->sub_partner }}" name="sub_partner" placeholder="Sub-Partner name">
								</div>
							</div>
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
      $("#edit_collector").validate({
         rules:{
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
         	city:{
         		required:true
         	},
         	zone:{
         		required:true
         	},

         },
         messages:{
            email:{
               required:"Please enter your email",
               email:"Please enter your valid email",
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
         	city:{
         		required:"Please enter city name"
         	},
         	zone:{
         		required:"Please select Zone"
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
                window.location.href = "{{ url('collector-list') }}"
            }
    	});
	}
</script>
@endsection