@extends('admin.layout.app')

@section('title',"Partner Detail")

@section('breadcrumb')
	<a href="{{ url('/partners-list') }}">Partners</a>
@endsection

@section('css')
	<link href="{{ url('public/') }}/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

	<div class="row">
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								{{ ucfirst($partnerObj->name) }} Detail
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget13">
						@if(isset($partnerObj->firstname) && !empty($partnerObj->firstname))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Name
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ ucfirst($partnerObj->firstname." ".$partnerObj->lastname) }}
							</span>
						</div>
						@endif
						@if(isset($partnerObj->zone) && !empty($partnerObj->zone))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Zone:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $partnerObj->zone }}
							</span>
						</div>
						@endif
						@if(isset($partnerObj->phone) && !empty($partnerObj->phone))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Phone:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $partnerObj->phone }}
							</span>
						</div>
						@endif
						@if(isset($partnerObj->fax) && !empty($partnerObj->fax))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Fax:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $partnerObj->fax }}
							</span>
						</div>
						@endif
						@if(isset($partnerObj->address) && !empty($partnerObj->address))
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-left">
								Address:
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $partnerObj->address }}
							</span>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Programs
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget13">
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-right">
								No of collectors
							</span>
							<span class="m-widget13__text m-widget13__text-bolder">
								{{ $collectorCount }}
							</span>
						</div>
						<div class="m-widget13__item">
							<span class="m-widget13__desc m--align-center">
								<a href="{{ url('collector-list') }}?partner={{ $partnerObj->id }}" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">View Collectors</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Logo
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget13">
						<div class="m-widget13__item">
							@if(!empty($partnerObj->logo))
							<img src="{{ url('/public') }}/images/partner_logo/{{ $partnerObj->logo }}" alt="">
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="m-portlet m-portlet--mobile">
		{{-- <div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Advanced Search Form
					</h3>
				</div>
			</div>
		</div> --}}
		<div class="m-portlet__body">
			<div class="m-separator m-separator--md m-separator--dashed"></div>
			<input type="hidden" name="partner" id="partner" value="{{ $partnerObj->id }}">
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th><input type="text" class="form-control text-filter m-input filter" id="code" name="code" placeholder="Code"></th>
						<th><input type="text" class="form-control text-filter m-input filter" id="pre_test_date" name="pre_test_date" placeholder="Pre Test Date"></th>
						<th><input type="text" class="form-control text-filter m-input filter" id="post_test_date" name="post_test_date" placeholder="Post Test Date"></th>
						<th></th>
						<th>
							@hasanyrole('admin|partner')
							<select name="status" id="status" class="form-control select-filter m-input filter">
								<option value="">Select status</option>
								@foreach($status as $st)
									<option value="{{ $st->id }}">{{ ucfirst($st->name) }}</option>
								@endforeach
							</select>
							@endhasanyrole
						</th>
					</tr>
					<tr>
						<th>Code</th>
						<th>Pre-Test Date</th>
						<th>Post-Test Date</th>
						<th>Score</th>
						<th>Status</th>
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

			$('.filter').on('keyup change',function(){
				datatables();
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
		        	url: '{!! route('loadProvidersCollector') !!}',
		        	method: 'post',
		        	data: {
				        "_token": "{{ csrf_token() }}",
				        "code": $('#code').val(),
				        "pre_test_date": $('#pre_test_date').val(),
				        "post_test_date": $('#post_test_date').val(),
				        "partner": $('#partner').val(),
				        "status": $('#status').val(),
			        }
		        },
		        columns: [
		            { data: 'code', name: 'code' },
		            { data: 'pre_test_date', name: 'pre_test_date' },
		            { data: 'post_test_date', name: 'post_test_date' },
		            { data: 'score', name: 'score',sortable : false, },
		            { data: 'status_name', name: 'status_name' },
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
	</script>
@endsection