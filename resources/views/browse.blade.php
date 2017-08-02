@extends('voyager::master')

@section('content')

<div id="app">
	<div class="col-md-12">
	<h1 class="page-title">
		<i class="voyager-external"></i> Redirects
		<a href="{{ route('voyager.redirects.add') }}" class="btn btn-success">
			<i class="voyager-plus"></i> Add New
		</a>
	</h1>
	<div id="voyager_redirects">
		<div class="container-fluid">
				<div class="panel panel-bordered">
					<div class="panel-heading">
						<h3 class="panel-title">Redirects</h3>
					</div>
					<div class="panel-body">
						<table id="dataTable" class="table table-hover dataTable no-footer" role="grid" aria-describedby="dataTable_info">
							<thead>
							<tr role="row">
								<th class="@if($filter == 'from' && $sorting == 'desc'){{ 'sorting_desc' }}@elseif($filter == 'from'){{ 'sorting_asc' }}@else{{ 'sorting' }}@endif" onClick="filter_click('{{ $filter }}', '{{ $sorting }}', 'from')">Redirect from</th>
								<th class="@if($filter == 'to' && $sorting == 'desc'){{ 'sorting_desc' }}@elseif($filter == 'to'){{ 'sorting_asc' }}@else{{ 'sorting' }}@endif" onClick="filter_click('{{ $filter }}', '{{ $sorting }}', 'to')">To</th>
								<th class="@if($filter == 'type' && $sorting == 'desc'){{ 'sorting_desc' }}@elseif($filter == 'type'){{ 'sorting_asc' }}@else{{ 'sorting' }}@endif" onClick="filter_click('{{ $filter }}', '{{ $sorting }}', 'type')">Type</th>
								<th class="@if($filter == 'created_at' && $sorting == 'desc'){{ 'sorting_desc' }}@elseif($filter == 'created_at'){{ 'sorting_asc' }}@else{{ 'sorting' }}@endif" onClick="filter_click('{{ $filter }}', '{{ $sorting }}', 'created_at')">Created</th>
								<th class="@if($filter == 'updated_at' && $sorting == 'desc'){{ 'sorting_desc' }}@elseif($filter == 'updated_at'){{ 'sorting_asc' }}@else{{ 'sorting' }}@endif" onClick="filter_click('{{ $filter }}', '{{ $sorting }}', 'updated_at')">Updated</th>
								<th class="actions">Actions</th></tr>
							</thead>
							<tbody>
								@foreach($redirects as $redirect)
								<tr role="row" class="odd">
									<td><a href="{{ $redirect->from }}" target="_blank">{{ $redirect->from }}</a></td>
									<td><a href="{{ $redirect->to }}" target="_blank">{{ $redirect->to }}</a></td>
									<td>{{ $redirect->type }}</td>
									<td>{{ Carbon\Carbon::parse($redirect->created_at)->toDayDateTimeString() }}</td>
									<td>{{ Carbon\Carbon::parse($redirect->updated_at)->toDayDateTimeString() }}</td>
									<td>
										<div class="btn-sm btn-danger pull-right delete" data-id="{{ $redirect->id }}" id="delete-1">
											<i class="voyager-trash"></i> Delete
										</div>
										<a href="{{ route('voyager.redirects.edit', $redirect->id) }}" class="btn-sm btn-primary pull-right edit">
											<i class="voyager-edit"></i> Edit
										</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@if(count($redirects) < 1)
							<p style="padding: 10px 5px;">No Redirects to display.</p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection


@section('javascript')
<script>
	function filter_click(filter, sorting, filter_by){
		if(filter == filter_by){
			if(sorting.toLowerCase() == 'desc'){
				window.location = window.location.pathname + '?filter=' + filter_by + '&sorting=asc';
			} else {
				window.location = window.location.pathname + '?filter=' + filter_by + '&sorting=desc';
			}
		} else {
			window.location = window.location.pathname + '?filter=' + filter_by;
		}
	}	
</script>

@endsection