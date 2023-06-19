@extends('admin.layout.app')

@section('title',"Admin")

@section('breadcrumb')
	<a href="{{ url('/admin-list') }}">Admin</a>
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
						Admin List
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="{{ url('add-admin') }}" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>Add Admin</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th><input type="text" class="form-control m-input" id="firstname" name="firstname" placeholder="Firstname"></th>
						<th><input type="text" class="form-control m-input" id="lastname" name="lastname" placeholder="Lastname"></th>
						<th><input type="text" class="form-control m-input" id="email" name="email" placeholder="Email"></th>
						<th><input type="text" class="form-control m-input" id="phone" name="phone" placeholder="Phone"></th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Status</th>
						<th>Action</th>
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
		        ordering:true,
		        destroy: true,
		        searching:false,
		        ajax: {
		        	url: '{!! route('loadAdmin') !!}',
		        	method: 'post',
		        	data: {
				        "_token": "{{ csrf_token() }}",
				        "firstname": $('#firstname').val(),
				        "lastname": $('#lastname').val(),
				        "email": $('#email').val(),
				        "phone": $('#phone').val(),
			        }
		        },
		        columns: [
		            { data: 'firstname', name: 'firstname' },
		            { data: 'lastname', name: 'lastname' },
		            { data: 'email', name: 'email' },
		            { data: 'phone', name: 'phone' },
		            { data: 'status', name: 'status' },
		            { data: 'action', name: 'action' ,sortable : false,},
		        ]
		    });
		}
		function activateAdmin(id){
			var token = $('meta[name="csrf-token"]').attr('content');
			if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, Activate",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                    $.post('{{route('activate-admin')}}',{id:id,is_active:1,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Activated", "Admin successfully activated", "success");
							datatables();
						});
	                }
            	});
			}
		}
		function deactivateAdmin(id){
			var token = $('meta[name="csrf-token"]').attr('content');
			if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, In-activate",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                    $.post('{{route('activate-admin')}}',{id:id,is_active:0,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Deactivated", "Admin successfully deactivated", "success");
							datatables();
						});
	                }
            	});
			}
		}
	</script>
@endsection