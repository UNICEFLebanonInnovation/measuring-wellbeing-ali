@extends('admin.layout.app')

@section('title',"Reports")

@section('breadcrumb')
	<a href="{{ url('/reports') }}">Reports</a>
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
					Reports
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Application</th>
						<th>User</th>
						<th>Log</th>
						<th>Date</th>
					</tr>
				</thead>
			</table>
	</div>
</div>

@endsection

@section('js')
	<script src="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			datatables();
		});
		function datatables(){
		    $('#m_table_1').DataTable({
		        processing: true,
		        serverSide: true,
		        searching:false,
		        ordering:true,
		        destroy: true,
		        ajax: {
		        	url: '{!! route('load-reports') !!}',
		        	method: 'post',
		        	data: {
				        "_token": "{{ csrf_token() }}",
				        'id': $('#id').val(),
				        'name': $('#name').val()
			        }
		        },
		        columns: [
		            { data: 'code', name: 'code' },
		            { data: 'firstname', name: 'firstname' },
		            { data: 'text', name: 'text' },
		            { data: 'created_at', name: 'created_at' }
		        ]
		    });
		}
	</script>

@endsection