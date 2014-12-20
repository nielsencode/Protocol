@extends('layouts.master.indextable')

@section('js')
	@parent
	{{ HTML::script('assets/js/clients/index.js') }}
@stop

@section('breadcrumbs')
	{{ Breadcrumbs::make([
		'clients'=>''
	]) }}
@stop

@section('content')
	@include('layouts.master.subviews.modaldialog',['title'=>'import clients','url'=>route('import clients')])
	@parent
@stop

@section('index-tools-left')
	@if (
		Auth::user()
			->has('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client')
	)

		<a class="button" name="add client" href="{{ route('add client') }}">Add Client</a>
		{{ str_repeat('&nbsp;',6) }}
		<a class="import-clients index-tools-link">import clients</a>
		{{ str_repeat('&nbsp;',3).'&rsaquo;'.str_repeat('&nbsp;',3) }}
		<a href="{{ route('export clients') }}" target="_blank" class="index-tools-link">export clients</a>

	@endif
@stop

@section('index-table-header')
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('first_name',$sortorder) }}">
			First name
		</a>
	</th>
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('last_name',$sortorder) }}">
			Last name
		</a>
	</th>
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('email',$sortorder) }}">
			Email
		</a>
	</th>
	<th class="index-table-column">Billing phone</th>
@stop

@section('index-table-rows')
	@if (!count($clients))
		<tr class="index-table-row">
			<td class="index-table-cell" colspan="4">
				<a>no clients.</a>
			</td>
		</tr>
	@else
		@foreach ($clients as $client)
			<tr class="index-table-row" client-id="{{ $client->id }}">
				<td class="index-table-cell">
					<a href="{{ route('client',[$client->id]) }}">{{ $client->first_name }}</a>
				</td>
				<td class="index-table-cell">
					<a href="{{ route('client',[$client->id]) }}">{{ $client->last_name }}</a>
				</td>
				<td class="index-table-cell">
					<a href="{{ route('client',[$client->id]) }}">{{ $client->email }}</a>
				</td>
				<td class="index-table-cell">
					<a href="{{ route('client',[$client->id]) }}">{{ $client->addresses()->ofType('billing')->first()->phone }}</a>
				</td>
			</tr>
		@endforeach
	@endif
@stop

@section('index-table-pagination')
	{{ pageLinks($clients) }}
@stop