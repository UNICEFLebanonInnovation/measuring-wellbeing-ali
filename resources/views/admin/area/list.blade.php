@extends('admin.layout.app')

@section('title',"Area List")

@section('breadcrumb')
	<a href="{{ url('/area-list') }}">Area List</a>
@endsection

@section('css')
	<link href="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@include('admin.layout.flash')
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Area List
					</h3>
				</div>
			</div>
			@hasrole("admin")
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="{{ url('add-area') }}" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>Add area</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
			@endhasrole
		</div>
		<div class="m-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th><input type="text" class="form-control m-input" id="id" name="id" placeholder="ID"></th>
						<th><input type="text" class="form-control m-input" id="name" name="name" placeholder="Name"></th>
						<th></th>
						<th>
							<select name="gouvernate" id="gouvernate" class="form-control m-input">
								<option value="">Select gouvernate</option>
								@foreach($gouvernate as $gov)
									<option value="{{ $gov->id }}">{{ ucfirst($gov->name) }}</option>
								@endforeach
							</select>
						</th>
						<th>
							<select name="caza" id="caza" class="form-control m-input">
								<option value="">Select caza</option>
								@foreach($caza as $gov)
									<option value="{{ $gov->id }}">{{ ucfirst($gov->name) }}</option>
								@endforeach
							</select>
						</th>
						<th></th>
					</tr>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Arabic</th>
						<th>Gouvernate</th>
						<th>Caza</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
@endsection

@section('js')
	<script src="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
	<script>
		$(function() {
			datatables();

			$('.m-input').on('keyup change',function(){
				if($(this).attr('id') == "gouvernate"){
					getCaza($(this).val());
				}
				datatables();
				$(this).focus();
			})
		});

		function datatables(){
		    $('#m_table_1').DataTable({
		        processing: true,
		        serverSide: true,
		        ordering:true,
		        destroy: true,
		        searching:false,
		        ajax: {
		        	url: '{!! route('loadArea') !!}',
		        	method: 'post',
		        	data: {
				        "_token": "{{ csrf_token() }}",
				        'id': $('#id').val(),
				        'name': $('#name').val(),
				        'caza': $('#caza').val(),
				        'gouvernate': $('#gouvernate').val(),
			        }
		        },
		        columns: [
		            { data: 'id', name: 'id' },
		            { data: 'name', name: 'name' },
		            { data: 'arabic', name: 'arabic' },
		            { data: 'gouvernate_name', name: 'gouvernate_name' },
		            { data: 'caza_name', name: 'caza_name' },
		            { data: 'action', name: 'action',sortable : false, }
		        ]
		    });
		}

		function getCaza(gov_id){
	   		var app_locale = "{{ app()->getLocale() }}";
			$.post('{{ url("get-caza") }}',{gov_id:gov_id,_token:"{{ csrf_token() }}"},function(response){
				var optionHtml       = "<option value='' selected>{{ trans('messages.select_caza') }}</option>"
				for(var i=0;i<response.response.length;i++){
					var caza_name = response.response[i]['name'];
					if(app_locale == "ar"){
						if(response.response[i]['arabic'] != ""){
							caza_name = response.response[i]['arabic'];
						}else{
							caza_name = response.response[i]['name'];
						}
					}
					optionHtml += '<option value="'+response.response[i]['id']+'" >'+ caza_name+'</option>';
	            }
	        	$('#caza').html(optionHtml);
	     	});
	   	}

		function deleteArea(id){
			var token = $('meta[name="csrf-token"]').attr('content');
			if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, Delete",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                    $.post('{{route('delete-area')}}',{id:id,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Deleted", "Area successfully deleted", "success");
							datatables();
						});
	                }
            	});
			}
		}
	</script>
@endsection