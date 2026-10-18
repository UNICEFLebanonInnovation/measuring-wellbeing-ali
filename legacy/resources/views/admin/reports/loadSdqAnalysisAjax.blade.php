<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					SDQ Analysis Data
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
			<thead>
				<tr>
					<th>Prog. Hrs Range</th>
					<th>Average rate of attendance %</th>
					<th>No. of children addressed</th>
					<th>Increase</th>
					<th>% children showing improvement in wellbeing</th>
				</tr>
			</thead>
			<tbody>
				@if(count($data) > 0)
				@for($i =0; $i < count($data); $i++)
				<tr>
					<td>{{ $data[$i]['hours'] }}</td>
					<td>{{ number_format($data[$i]['attended'],2) }}</td>
					<td>{{ $data[$i]['children'] }}</td>
					<td>{{ $data[$i]['increase'] }}</td>
					<td>{{ number_format($data[$i]['welbeing'],2) }} %</td>
				</tr>
				@endfor
				@endif
			</tbody>
		</table>
	</div>
</div>

<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					SDQ Analysis Data
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">

		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
			<thead>
				<tr>
					<th>Governorate</th>
					<th>Average rate of attendance %</th>
					<th>No. of children addressed</th>
					<th>Increase</th>
					<th>% children showing improvement in wellbeing</th>
				</tr>
			</thead>
			<tbody>
				@if(count($govArray) > 0)
				@for($i =0; $i < count($govArray); $i++)
				<tr>
					<td>{{ $govArray[$i]['gov'] }}</td>
					<td>{{ number_format($govArray[$i]['attended'],2) }}</td>
					<td>{{ $govArray[$i]['children'] }}</td>
					<td>{{ $govArray[$i]['increase'] }}</td>
					<td>{{ number_format($govArray[$i]['welbeing'],2) }} %</td>
				</tr>
				@endfor
				@endif
			</tbody>
		</table>
	</div>
</div>