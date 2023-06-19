@extends('admin.layout.app')

@section('title',"Partners")

@section('breadcrumb')
	<a href="{{ url('/partners-list') }}">Partners</a>
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
						Partners List
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="{{ url('add-partners') }}" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>Add Partner</span>
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
						<th><input type="text" class="form-control m-input" id="partner_id" name="partner_id" placeholder="Partner ID"></th>
						<th><input type="text" class="form-control m-input" id="name" name="name" placeholder="Name"></th>
						<th><input type="text" class="form-control m-input" id="firstname" name="firstname" placeholder="Firstname"></th>
						<th><input type="text" class="form-control m-input" id="lastname" name="lastname" placeholder="Lastname"></th>
						<th><input type="text" class="form-control m-input" id="email" name="email" placeholder="Email"></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th>Partner ID</th>
						<th>Name</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Email</th>
						<th>Readonly</th>
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
		        searching:false,
		        destroy: true,
		        ajax: {
		        	url: '{!! route('loadPartnter') !!}',
		        	method: 'post',
		        	data: {
				        "_token": "{{ csrf_token() }}",
				        "partner_id": $('#partner_id').val(),
				        "name": $('#name').val(),
				        "firstname": $('#firstname').val(),
				        "lastname": $('#lastname').val(),
				        "email": $('#email').val(),
			        }
		        },
		        columns: [
		            { data: 'partner_id', name: 'partner_id' },
		            { data: 'name', name: 'name' },
		            { data: 'firstname', name: 'firstname' },
		            { data: 'lastname', name: 'lastname' },
		            { data: 'email', name: 'email' },
		            { data: 'active', name: 'active' },
		            { data: 'status', name: 'status' },
		            { data: 'action', name: 'action' ,sortable : false,},
		        ]
		    });
		}
		function activatePartner(id,checked_or_not){
			var token = $('meta[name="csrf-token"]').attr('content');
			if (checked_or_not == 0) {
		    	var value = 1;
		    }else {
		    	var value = 0;
		    }
            $.post('{{route('activate-partner')}}',{id:id,value:value,_token:"{{ csrf_token() }}"},function(response){
            	swal(response.status, response.response, "success");
				datatables();
			});
		}
		function deactivatePartner(id){
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
	                    $.post('{{route('activate-partner')}}',{id:id,is_active:0,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Deactivated", "Partner successfully deactivated", "success");
							datatables();
						});
	                }
            	});
			}
		}

		function deleteCollector(id){
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
	                    $.post('{{route('delete-partner')}}',{id:id,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Deleted", "Partner successfully deleted", "success");
							datatables();
						});
	                }
            	});
			}
		}

		function readonlyPartner(id,checked_or_not){
			if (checked_or_not == 0) {
		    	var value = 1;
		    }else {
		    	var value = 0;
		    }
			var token = $('meta[name="csrf-token"]').attr('content');
            $.post('{{route('readonly-partner')}}',{id:id,value:value,_token:"{{ csrf_token() }}"},function(response){
            	//var output = JSON.parse(response);
            	swal(response.status, response.response, "success");
				datatables();
			});
			/*if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, readonly",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                }
            	});
			}*/
		}
		function unloackPartner(id){
			var token = $('meta[name="csrf-token"]').attr('content');
			if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, make functional",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                    $.post('{{route('readonly-partner')}}',{id:id,readonly:0,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Deactivated", "Partner successfully moved to functional", "success");
							datatables();
						});
	                }
            	});
			}
		}
	</script>
@endsection