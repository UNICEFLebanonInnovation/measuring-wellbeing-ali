@extends('admin.layout.app')

@section('title',"Status List")

@section('breadcrumb')
	<a href="{{ url('/status-list') }}">Status List</a>
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
						Status List
					</h3>
				</div>
			</div>
			@hasrole("admin")
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="{{ url('add-status') }}" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>Add Status</span>
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
					</tr>
					<tr>
						<th>ID</th>
						<th>Name</th>
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

			$('.m-input').keyup(function(){
				datatables();
				$(this).focus();
			})
		});

		function datatables(){
		    $('#m_table_1').DataTable({
		        processing: true,
		        serverSide: true,
		        searching:false,
		        ordering:true,
		        destroy: true,
		        ajax: {
		        	url: '{!! route('loadStatus') !!}',
		        	method: 'post',
		        	data: {
				        "_token": "{{ csrf_token() }}",
				        'id': $('#id').val(),
				        'name': $('#name').val()
			        }
		        },
		        columns: [
		            { data: 'id', name: 'id' },
		            { data: 'name', name: 'name' },
		            { data: 'action', name: 'action',sortable : false, }
		        ]
		    });
		}

		function deleteGov(id){
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
	                    $.post('{{route('delete-status')}}',{id:id,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Deleted", "Status successfully deleted", "success");
							datatables();
						});
	                }
            	});
			}
		}
	</script>
@endsection