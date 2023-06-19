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
			<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="add_application" method="post" action="{{ route('change-collector',$applicationObj->code) }}">
				@csrf
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Collector:</label>
							<select class="form-control m-input" id="collector" name="collector">
								<option value="">Select Collector</option>
								@foreach($collectors as $col)
									<option value="{{ $col->user_id }}" {{ $applicationObj->collector_id == $col->user_id ? 'selected':'' }}>{{ ucfirst($col->name) }}</option>
								@endforeach
							</select>
							@if ($errors->has('collector'))
			                  	<span class="m-form__help">{{ $errors->first('collector') }}</span>
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
      	$("#add_application").validate({
         	rules:{
	         	category:{
	         		required:true
	         	}

         	},
         	messages:{
	            category:{
	         		required:"Please select category"
	         	}
         	}
      	})
   });
</script>
@endsection