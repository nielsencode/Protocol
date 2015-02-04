@extends('layouts.master.master')

@section('css')
	{{ HTML::style('assets/css/clients/client.css') }}
@stop

@section('breadcrumbs')
	@if (
		Auth::user()
			->has('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client')
	)
		{{ Breadcrumbs::make([
			'Clients'=>route('clients'),
			$client->name()=>''
		]); }}
	@else
		{{ Breadcrumbs::make([
            'profile'=>''
        ]); }}
	@endif
@stop

@section('content')
	@include('clients.subviews.clientmenu')

	<div class="heading">
		{{ $client->name() }}&nbsp;&nbsp;
		@if(
			Auth::user()
				->has('edit')
				->ofScope('Client',$client->id)
				->orScope('Subscriber',Subscriber::current()->id)
				->orScope('Protocol')
				->over('Client',$client->id)
		)
			@if (Auth::user()->role->name=='client')
				<a class="info-table-edit-link" href="{{ route('edit my profile') }}">edit</a>
			@else
				<a class="info-table-edit-link" href="{{ route('edit client',[$client->id]) }}">edit</a>
			@endif
		@endif
	</div>

	<table class="info-table">
		<tbody>
			@foreach(array_intersect_key($client->toArray(),[
				'first_name'=>'','last_name'=>'','email'=>''
			]) as $k=>$v)
				<tr>
					<td class="info-table-label-cell">{{ str_replace('_',' ',$k) }}:</td>
					<td class="info-table-cell">{{ $v }}</td>
				</tr>
			@endforeach
			<tr height="15"></tr>
		</tbody>

		@foreach($client->addresses as $address)
			<thead>
				<tr>
					<th class="info-table-section-label">{{ $address->addresstype->name }} info:</th>
					<th class="info-table-section-cell">
						@if (
							Auth::user()
								->has('edit')
								->ofScope('Subscriber',Subscriber::current()->id)
								->orScope('Client',$client->id)
								->orScope('Protocol')
								->over('Client',$client->id)
						)
							<a class="info-table-edit-link" href="{{ route('edit client',[$client->id]) }}">edit</a>
						@endif
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="info-table-label-cell">phone:</td>
					<td class="info-table-cell">{{ $address->phone }}</td>
				</tr>
				<tr>
					<td class="info-table-label-cell">address:</td>
					<td class="info-table-cell">{{ $address->formatAddress() }}</td>
				</tr>
				<tr height="15"></tr>
			</tbody>
		@endforeach
	</table>

	<hr class="hr"/>

	@if (
		Auth::user()
			->has('read')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Protocol')
	)

		<a name="protocols"></a>
		<table class="client-protocols-header" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<span class="heading2">protocols</span>
					@if ($client->protocols->count())
						&nbsp;&nbsp;
						@if(Auth::user()->role->name=='client')
							<a class="client-print-protocols-link" href="{{ route('print my protocols') }}" target="_blank">print</a>
						@else
							<a class="client-print-protocols-link" href="{{ route('client print protocols',[$client->id]) }}" target="_blank">print</a>
						@endif
					@endif
				</td>
				<td style="text-align:right;">
					@if (
						Auth::user()
							->has('add')
							->ofScope('Subscriber',Subscriber::current()->id)
							->orScope('Protocol')
							->over('Protocol')
					)
						<a class="button" href="{{ route('client add protocol',[$client->id]) }}">Add</a>
					@endif
				</td>
			</tr>
		</table>

		@if ($client->protocols->count())
			@include("clients.subviews.protocoltable_".Subscriber::current()->setting('protocol table orientation'))
		@else
			<div style="margin-top:20px; color:#737373;">
				@if (Auth::user()->role->name=='client')
					You have no protocols.
				@else
					This client has no protocols.
				@endif
			</div>
		@endif

	@endif
@stop