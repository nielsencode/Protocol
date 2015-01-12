@extends('layouts.master.master')

@section('breadcrumbs')
	{{ Breadcrumbs::make([
		'supplements'=>route('supplements'),
		$supplement->name=>''
	]) }}
@stop

@section('content')
	<div class="heading">
		{{ $supplement->name }}&nbsp;&nbsp;
		@if (
			Auth::user()
				->has('edit')
				->ofScope('Subscriber',Subscriber::current()->id)
				->orScope('Protocol')
				->over('Supplement',$supplement->id)
		)
			<a href="{{ route('edit supplement',[$supplement->id]) }}" class="info-table-edit-link">edit</a>
		@endif
	</div>

	<table class="info-table" cellpadding="0">
		<tr>
			<td class="info-table-label-cell">price:</td>
			<td class="info-table-cell">${{ $supplement->price }}</td>
		</tr>
		<tr>
			<td class="info-table-label-cell">short description:</td>
			<td class="info-table-cell">{{ $supplement->short_description }}</td>
		</tr>
		<tr>
			<td class="info-table-label-cell">description:</td>
			<td class="info-table-cell">{{ $supplement->description }}</td>
		</tr>
	</table>

	<hr class="hr"/>

	<div style="text-align:right;">
		<a href="{{ URL::previous() }}">back</a>
		@if (Auth::user()->role->name=='client')
			{{ str_repeat('&nbsp;',4) }}
			<a href="{{ route('order supplement',[$supplement->id]) }}">
				<button name="order button" class="button">Order</button>
			</a>
		@endif
	</div>
@stop