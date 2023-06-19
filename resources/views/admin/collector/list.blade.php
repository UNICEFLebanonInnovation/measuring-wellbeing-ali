@extends('admin.layout.app')

@section('title',"Collectors")

@section('breadcrumb')
	<a href="{{ url('/collector-list') }}">Collectors</a>
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
						Collector List
					</h3>
				</div>
			</div>
			@if(!intval(Auth::user()->is_readonly))
			@hasrole('partner')
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="{{ url('add-collector') }}" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>Add Collector</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
			@endhasrole
			@endif
		</div>
		<div class="m-portlet__body">
			@php
				$partner = "";
				if(isset($_GET['partner']) && !empty($_GET['partner'])){
					$partner = $_GET['partner'];
				}
			@endphp
			<input type="hidden" name="partner" id="partner" value="{{ $partner }}">
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th><input type="text" class="form-control m-input" id="collector_id" name="collector_id" placeholder="ID"></th>
						<th><input type="text" class="form-control m-input" id="collector_name" name="collector_name" placeholder="Name"></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						{{-- <th></th> --}}
					</tr>
					<tr>
						<th>Collector ID</th>
						<th>Collector Name</th>
						<th>Partner</th>
						<th>Email</th>
						<th>#Pre-Test</th>
						<th>#Post-Test</th>
						<th>Readonly</th>
						<th>Status</th>
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
		        ordering:true,
		        searching:false,
		        destroy: true,
		        ajax: {
		        	url: '{!! route('loadCollector') !!}',
		        	method: 'post',
		        	data: {
				        "_token": "{{ csrf_token() }}",
				        "collector_id": $('#collector_id').val(),
				        "collector_name": $('#collector_name').val(),
				        "partner_id": $('#partner').val()
			        }
		        },
		        columns: [
		            { data: 'collector_id', name: 'collector_id' },
		            { data: 'collector_name', name: 'collector_name' },
		            { data: 'partner_name', name: 'partner_name' },
		            { data: 'email', name: 'email' },
		            { data: 'pre_test', name: 'pre_test' ,sortable : false,},
		            { data: 'post_test', name: 'post_test' ,sortable : false,},
		            { data: 'active', name: 'active' ,sortable : false,},
		            { data: 'status', name: 'status' ,sortable : false,},
		            { data: 'action', name: 'action' ,sortable : false,}
		        ]
		    });
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
	                    $.post('{{route('delete-collector')}}',{id:id,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Deleted", "Collector successfully deleted", "success");
							datatables();
						});
	                }
            	});
			}
		}
		function activateCollector(id,checked_or_not){
			var token = $('meta[name="csrf-token"]').attr('content');
			if (checked_or_not == 0) {
		    	var value = 1;
		    }else {
		    	var value = 0;
		    }
            $.post('{{route('activate-collector')}}',{id:id,value:value,_token:"{{ csrf_token() }}"},function(response){
            	swal(response.status, response.response, "success");
				datatables();
			});
			/*if(id != ''){
				swal({
	                title: "Are you sure?",
	                type: 'question',
	                showCancelButton: true,
	                confirmButtonText: "Yes, Activate",
	                cancelButtonText: "Cancel",
	                reverseButtons: true
	            }).then(function(result){
	                if (result.value) {
	                    $.post('{{route('activate-collector')}}',{id:id,is_active:1,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Activated", "Collector successfully activated", "success");
							datatables();
						});
	                }
            	});
			}*/
		}
		function deactivateCollector(id){
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
	                    $.post('{{route('activate-collector')}}',{id:id,is_active:0,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Deactivated", "Collector successfully deactivated", "success");
							datatables();
						});
	                }
            	});
			}
		}

		function readonlyCollector(id,checked_or_not){
			var token = $('meta[name="csrf-token"]').attr('content');
			if (checked_or_not == 0) {
		    	var value = 1;
		    }else {
		    	var value = 0;
		    }
            $.post('{{route('readonly-collector')}}',{id:id,value:value,_token:"{{ csrf_token() }}"},function(response){
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
		function unloackCollector(id){
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
	                    $.post('{{route('readonly-collector')}}',{id:id,readonly:0,_token:"{{ csrf_token() }}"},function(response){
			            	swal("Deactivated", "Collector successfully moved to functional", "success");
							datatables();
						});
	                }
            	});
			}
		}
	</script>
@endsection