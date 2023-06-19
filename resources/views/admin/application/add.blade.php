@extends('admin.layout.app')

@section('title',"Add Application")

@section('breadcrumb')
	<a href="{{ url('/application-list') }}">Application List</a>
@endsection

@section('css')

	<link href="{{ url('/public') }}/assets/vendors/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
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
							Add Application
						</h3>
					</div>
				</div>
			</div>

			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="add_application" method="post" action="{{ url('add-application') }}">
				@csrf
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Category:</label>
							<select class="form-control m-input" id="category" name="category">
								<option value="">Select Category</option>
								@foreach($forms as $form)
									<option value="{{ $form->id }}" {{ old('category') == $form->id ? 'selected':'' }}>{{ ucfirst($form->name) }}</option>
								@endforeach
							</select>
							@if ($errors->has('category'))
			                  	<span class="m-form__help">{{ $errors->first('category') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Pre Test Date:</label>
							<input type="text" class="form-control m-input" value="{{ old('pre_test_date') }}" id="pre_test_date" name="pre_test_date" readonly placeholder="Select date" />
							@if ($errors->has('pre_test_date'))
			                  	<span class="m-form__help">{{ $errors->first('pre_test_date') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Post Test Date:</label>
							<input type="text" class="form-control m-input" value="{{ old('post_test_date') }}" id="post_test_date" name="post_test_date" readonly placeholder="Select date" />
							@if ($errors->has('post_test_date'))
			                  	<span class="m-form__help">{{ $errors->first('post_test_date') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Gouvarnate:</label>
							<select class="form-control m-input" id="gouvarnate" name="gouvarnate">
								<option value="">Select Gouvarnate</option>
								@foreach($forms as $form)
									<option value="{{ $form->name }}" {{ old('gouvarnate') == $form->id ? 'selected':'' }}>{{ ucfirst($form->name) }}</option>
								@endforeach
							</select>
							@if ($errors->has('gouvarnate'))
			                  	<span class="m-form__help">{{ $errors->first('gouvarnate') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Caza:</label>
							<select class="form-control m-input" id="caza" name="caza">
								<option value="">Select Caza</option>
								@foreach($forms as $form)
									<option value="{{ $form->name }}" {{ old('caza') == $form->id ? 'selected':'' }}>{{ ucfirst($form->name) }}</option>
								@endforeach
							</select>
							@if ($errors->has('caza'))
			                  	<span class="m-form__help">{{ $errors->first('caza') }}</span>
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

@section('js')
<script src="{{ url('/public') }}/assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function(){
   		var arrows;
	    if (mUtil.isRTL()) {
	        arrows = {
	            leftArrow: '<i class="la la-angle-right"></i>',
	            rightArrow: '<i class="la la-angle-left"></i>'
	        }
	    } else {
	        arrows = {
	            leftArrow: '<i class="la la-angle-left"></i>',
	            rightArrow: '<i class="la la-angle-right"></i>'
	        }
	    }
	    $('#pre_test_date, #post_test_date').datepicker({
            rtl: mUtil.isRTL(),
            format: 'yyyy/mm/dd',
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows
        });
      	$("#add_application").validate({
         	rules:{
	         	category:{
	         		required:true
	         	},
	            pre_test_date:{
	         		required:true
	         	},
	         	post_test_date:{
	         		required:true
	         	},
	         	gouvarnate:{
	         		required:true
	         	},
	         	caza:{
	         		required:true
	         	}

         	},
         	messages:{
	            category:{
	         		required:"Please select category"
	         	},
	            pre_test_date:{
	         		required:"Please select pre-test date"
	         	},
	         	post_test_date:{
	         		required:"Please select post-test date"
	         	},
	         	gouvarnate:{
	         		required:"Please select gouvarnate"
	         	},
	         	caza:{
	         		required:"Please select caza"
	         	}
         	}
      	})
   });
</script>
@endsection