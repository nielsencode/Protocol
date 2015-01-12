@extends('...layouts.master.infotable')

@section('css')
	{{ HTML::style('assets/css/clients/protocols/protocol.css') }}
@stop

@section('breadcrumbs')
	{{ Breadcrumbs::make([
		'profile'=>route('protocol',[$protocol->id]),
		$protocol->supplement->name=>''
	]) }}
@stop

@section('heading')
	{{ $protocol->supplement->name }}
@stop

@section('info')
	<tr>
		<td class="info-table-label-cell">short description:</td>
		<td class="info-table-cell">{{ $protocol->supplement->short_description }}</td>
	</tr>
	<tr>
		<td class="info-table-label-cell">full description:</td>
		<td class="info-table-cell">{{ $protocol->supplement->description }}</td>
	</tr>
@stop

@section('buttons')
	<hr class="hr"/>
	<div style="text-align:right;">
		<a href="{{ url("clients/{$protocol->client->id}") }}"><button class="button">Back</button></a>
	</div>
@stop