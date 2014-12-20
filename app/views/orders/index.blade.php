@extends('layouts.master.indextable')

@section('breadcrumbs')
	{{ Breadcrumbs::make([
		'orders'=>''
	]) }}
@stop

@section('index-tools-left')

@stop

@section('index-table-header')
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('orders.order_id',$sortorder) }}">
			Order
		</a>
	</th>
	<th class="index-table-column">
        <a class="index-table-column-link" href="{{ sortby('orders.quantity',$sortorder) }}">
            Quantity
        </a>
    </th>
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('supplements.name',$sortorder) }}">
			Supplement
		</a>
	</th>
	@if (Auth::user()->role->name!='client')
		<th class="index-table-column">
			<a class="index-table-column-link" href="{{ sortby('clients.last_name',$sortorder) }}">
				Client
			</a>
		</th>
	@endif
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('orders.created_at',$sortorder) }}">
			Date
		</a>
	</th>
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('orders.fulfilled_at',$sortorder) }}">
			Fulfillment status
		</a>
	</th>
@stop

@section('index-table-rows')
	@if (!count($orders))
		<tr class="index-table-row">
            <td class="index-table-cell" colspan="{{ Auth::user()->role->name!='client' ? 6 : 5 }}">
                <a>no orders.</a>
            </td>
        </tr>
    @else
		@foreach ($orders as $order)
			<tr class="index-table-row" supplement-id="{{ $order->id }}">
				<td class="index-table-cell">
					<a href="{{ route('order',[$order->id]) }}">#{{ $order->order_id }}</a>
				</td>
				<td class="index-table-cell">
					<a href="{{ route('order',[$order->id]) }}">{{ $order->quantity }}</a>
				</td>
				<td class="index-table-cell">
					<a href="{{ route('order',[$order->id]) }}">{{ str_limit($order->supplement->name,50) }}</a>
				</td>
		        @if (Auth::user()->role->name!='client')
		            <td class="index-table-cell">
		                <a href="{{ route('order',[$order->id]) }}">{{ $order->client->name() }}</a>
		            </td>
		        @endif
				<td class="index-table-cell">
		            <a href="{{ route('order',[$order->id]) }}">{{ timeForHumans($order->date) }}</a>
		        </td>
		        <td class="index-table-cell">
		            <a href="{{ route('order',[$order->id]) }}">
		                @if ($order->deleted_at)
		                    <b>canceled</b>
		                @else
		                    <span class="{{ $order->fulfilled_at ? '' : 'warning-' }}messages-small">{{ $order->fulfilled_at ? 'fulfilled' : 'not fulfilled' }}</span>
		                @endif
		            </a>
		        </td>
			</tr>
		@endforeach
	@endif
@stop

@section('index-table-pagination')
	{{ pageLinks($orders) }}
@stop