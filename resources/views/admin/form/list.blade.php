@extends('admin.layout.app')

@section('title',"Form List")

@section('breadcrumb')
	<a href="{{ url('/form-list') }}">Form List</a>
@endsection

@section('css')
	<link href="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Form List
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th><input type="text" class="form-control m-input" id="form_id" name="form_id" placeholder="ID"></th>
						<th><input type="text" class="form-control m-input" id="form_name" name="form_name" placeholder="Name"></th>
						<th></th>
					</tr>
					<tr>
						<th>ID</th>
						<th>Form Name</th>
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
		        	url: '{!! route('loadForm') !!}',
		        	method: 'post',
		        	data: {
				        "_token": "{{ csrf_token() }}",
				        'form_id': $('#form_id').val(),
				        'form_name': $('#form_name').val()
			        }
		        },
		        columns: [
		            { data: 'id', name: 'id' },
		            { data: 'name', name: 'name' },
		            { data: 'action', name: 'action' ,sortable : false,}
		        ]
		    });
		}
	</script>
@endsection