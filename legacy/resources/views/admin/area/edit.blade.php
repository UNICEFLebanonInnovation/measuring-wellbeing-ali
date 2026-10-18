@extends('admin.layout.app')

@section('title',"Edit Area")

@section('breadcrumb')
	<a href="{{ url('area-list') }}">Edit Area</a>
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
							Edit Area
						</h3>
					</div>
				</div>
			</div>

			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="edit_caza" action="{{ route('edit-area',$areaObj->id) }}" method="post">
				@csrf
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Gouvernate:</label>
							<select class="form-control m-input" id="gouvernate" name="gouvernate">
								<option>Select Gouvernate</option>
								@foreach($gouvernate as $gov)
									<option value="{{ $gov->id }}" {{ $areaObj->gouvernate_id == $gov->id ? 'selected':'' }}>{{ ucfirst($gov->name) }}</option>
								@endforeach
							</select>
							@if ($errors->has('name'))
			                  	<span class="m-form__help">{{ $errors->first('name') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>caza:</label>
							<select class="form-control m-input" id="caza" name="caza">
								<option>Select Caza</option>
								@foreach($caza as $gov)
									<option value="{{ $gov->id }}" {{ $areaObj->caza_id == $gov->id ? 'selected':'' }}>{{ ucfirst($gov->name) }}</option>
								@endforeach
							</select>
							@if ($errors->has('name'))
			                  	<span class="m-form__help">{{ $errors->first('name') }}</span>
			              	@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label>Area Name:</label>
							<input type="text" class="form-control m-input" id="name" name="name" value="{{ $areaObj->name }}" placeholder="Enter area name">
							@if ($errors->has('name'))
			                  	<span class="m-form__help">{{ $errors->first('name') }}</span>
			              	@endif
						</div>
						<div class="col-lg-6">
							<label>Arabic Name:</label>
							<input type="text" class="form-control m-input" id="arabic" name="arabic" value="{{ $areaObj->arabic }}" placeholder="Enter Arabic">
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
   		var gov_id1 = "{{ $areaObj->gouvernate_id }}";
   		if(gov_id1 != "" || gov_id1 != null){
   			getCaza(gov_id1);
   		}
   		$('#gouvernate').change(function(e){
   			e.preventDefault();
   			var gov_id = $(this).val();
   			getCaza(gov_id);
   		})
      $("#edit_caza").validate({
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
   function getCaza(gov_id){
   		var app_locale = "{{ app()->getLocale() }}";
		var selected_caza = "{{ $areaObj->caza_id }}";
		$.post('{{ url("get-caza") }}',{gov_id:gov_id,_token:"{{ csrf_token() }}"},function(response){
			var optionHtml       = "<option value=''>{{ trans('messages.select_caza') }}</option>"
			for(var i=0;i<response.response.length;i++){
				var selected = "";
				if(response.response[i]['id'] == selected_caza){
					selected = "selected";
				}
				var caza_name = response.response[i]['name'];
				if(app_locale == "ar"){
					if(response.response[i]['arabic'] != ""){
						caza_name = response.response[i]['arabic'];
					}else{
						caza_name = response.response[i]['name'];
					}
				}
				optionHtml += '<option value="'+response.response[i]['id']+'" '+selected+'>'+ caza_name+'</option>';
            }
        	$('#caza').html(optionHtml);
     	});
   	}
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
                window.location.href = "{{ url('area-list') }}"
            }
    	});
	}
</script>
@endsection