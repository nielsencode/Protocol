@extends('layouts.master.infotable')

@section('js')
    @parent
    <script>
        $(function() {
            $('.cancel-recurring-order-link').click(function() {
                var conf = confirm('Are you sure you want to cancel this recurring order?');
                if(conf) {
                    $(this).closest('form').submit();
                }
            });

            $('.cancel-order-link').click(function() {
                var conf = confirm('Are you sure you want to cancel this order?');
                if(conf) {
                    $(this).closest('form').submit();
                }
            });x
        });
    </script>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::make([
        'orders'=>route('orders'),
        "order #{$order->order_id}"=>''
    ]); }}
@stop

@section('content')
    @if (!$order->deleted_at && !$order->fulfilled_at)
        <form action="{{ route('delete order',[$order->id]) }}" method="post">
            <a style="float:right;" class="info-table-edit-link cancel-order-link" href="#">cancel order</a>
        </form>
    @endif
    @parent
@stop

@section('heading')
    Order {{ "#{$order->order_id}" }}
@stop

@section('info-table-links')
@stop

@section('info')
    <tbody>
        <tr>
            <td class="info-table-label-cell">supplement:</td>
            <td class="info-table-cell">
                <a href="{{ route('supplement',[$order->supplement->id]) }}">
                    {{ $order->supplement->name }}
                </a>
            </td>
        </tr>
        <tr>
            <td class="info-table-label-cell">price:</td>
            <td class="info-table-cell">${{ $order->supplement->price }}</td>
        </tr>
        <tr>
            <td class="info-table-label-cell">quantity:</td>
            <td class="info-table-cell">{{ $order->quantity }}</td>
        </tr>
        @if (Auth::user()->role->name!=='client')
            <tr>
                <td class="info-table-label-cell">client:</td>
                <td class="info-table-cell">
                    <a href="{{ route('client',[$order->client->id]) }}">
                        {{ $order->client->name() }}
                    </a>
                </td>
            </tr>
        @endif
        <tr>
            <td class="info-table-label-cell">date:</td>
            <td class="info-table-cell">{{ timeForHumans($order->date->setTimezone(Timezone::get())) }}</td>
        </tr>
        <tr>
            <td class="info-table-label-cell">fulfillment:</td>
            <td class="info-table-cell">
                @if ($order->deleted_at)
                    <b>cancelled</b>
                @else
                    <span class="{{ $order->fulfilled_at ? '' : 'warning-' }}messages-small">
                        {{ $order->fulfilled_at ? 'fulfilled' : 'not fulfilled' }}
                    </span>
                @endif
            </td>
        </tr>
    </tbody>
@stop

@section('buttons')
    <tbody>
        <tr height="30"></tr>
        <tr>
            <td class="info-table-label-cell"></td>
            <td class="info-table-cell">
                @if(!$order->fulfilled_at && Auth::user()->role->name!='client' && !$order->deleted_at)
                    <form action="{{ route('mark order as fulfilled',[$order->id]) }}" method="post">
                        <button class="button">mark as fulfilled</button>
                    </form>
                @endif
            </td>
        </tr>
    </tbody>
@stop

@section('content')
    @parent

    @if($order->autoship)
        <hr class="hr"/>

        <div>
            <span class="heading2">part of a recurring order</span>

            <div style="float:right;">
                <form action="{{ route('cancel recurring order',[$order->id]) }}" method="post">
                    <a class="info-table-edit-link cancel-recurring-order-link">cancel recurring order</a>
                </form>
            </div>
        </div>

        <br>

        <table style="margin-left:10px;" class="info-table" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td class="info-table-label-cell">next order:</td>
                    <td class="info-table-cell">
                        {{ timeForHumans($order->autoship->next_order->setTimezone(Timezone::get())) }}
                    </td>
                </tr>
                <tr>
                    <td class="info-table-label-cell">frequency:</td>
                    <td class="info-table-cell">every {{ $order->autoship->autoshipfrequency->name }}</td>
                </tr>
            </tbody>
        </table>

        <br><br>

        @include('orders.subviews.recurringordertable',array('orders'=>$order->autoship->orders()->withTrashed()->get()))
    @endif

    <hr class="hr"/>
    <div style="text-align:right;">
        <a href="{{ route('orders') }}">back</a>
    </div>
@stop