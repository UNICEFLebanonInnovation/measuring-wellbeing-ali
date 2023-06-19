@extends('admin.layout.app')

@section('title',"Add Caza")

@section('breadcrumb')
	<a href="{{ url('caza-list') }}">Add Caza</a>
@endsection

@section('css')
<link href="{{ url('/public') }}/assets/vendors/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@include('admin.layout.flash')
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
							Add Caza
						</h3>
					</div>
				</div>
			</div>

			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="add_caza" action="{{ url('add-caza') }}" method="post">
				@csrf
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Gouvernate:</label>
							<select class="form-control m-input" id="gouvernate" name="gouvernate">
								<option>Select Gouvernate</option>
								@foreach($gouvernate as $gov)
									<option value="{{ $gov->id }}" {{ old('gouvernate') == $gov->id ? 'selected':'' }}>{{ ucfirst($gov->name) }}</option>
								@endforeach
							</select>
							@if ($errors->has('name'))
			                  	<span class="m-form__help">{{ $errors->first('name') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Caza Name:</label>
							<input type="text" class="form-control m-input" value="{{ old('name') }}" id="name" name="name" placeholder="Enter caza name">
							@if ($errors->has('name'))
			                  	<span class="m-form__help">{{ $errors->first('name') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Arabic Name:</label>
							<input type="text" class="form-control m-input" value="{{ old('arabic') }}" id="arabic" name="arabic" placeholder="Enter arabic value">
							@if ($errors->has('arabic'))
			                  	<span class="m-form__help">{{ $errors->first('arabic') }}</span>
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
      $("#add_caza").validate({
         rules:{
            name:{
         		required:true
         	},

         },
         messages:{
            name:{
         		required:"Please enter caza name"
         	}
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
                window.location.href = "{{ url('caza-list') }}"
            }
    	});
	}
</script>
@endsection