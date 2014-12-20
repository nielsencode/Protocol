@extends('layouts.master.addeditform')

@section('js')
    @parent
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    {{ HTML::script('/assets/js/supplements/order.js') }}
@stop

@section('css')
    @parent
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <style type="text/css">
        .ui-datepicker {
            font-family:inherit;
            font-size:inherit;
            margin-top:3px;
            margin-bottom:3px;
        }
        .ui-datepicker-header {
            background:#f0f0f0;
        }
        .ui-state-default {
            background:#f0f0f0 !important;
        }
    </style>
@stop

@section('breadcrumbs')
	{{ Breadcrumbs::make([
		'supplements'=>route('supplements'),
		$supplement->name=>route('supplement',[$supplement->id]),
		'order'=>''
	]); }}
@stop

@section('title')
    Order {{ $supplement->name }}
@stop

@if (Session::has('success'))
    @section('messages')
        <div class="messages">
            <li class="message">
                Success!&nbsp;&nbsp;Your order has been placed.&nbsp;&nbsp;&nbsp;<a href="{{ route('orders') }}">view your orders.</a>
            </li>
        </div>
    @stop
@else

    @section('form')
        {{ Form::open(['route'=>['order supplement',$supplement->id]]) }}
    @stop

    @section('form-fields')
        <tbody>
            <tr>
                <td class="form-label-cell">
                    price
                </td>
                <td class="form-cell">
                    {{ $supplement->price }}
                </td>
            </tr>
            <tr height="8"></tr>
            <tr>
                <td class="form-label-cell">
                    {{ Form::label('quantity','quantity',[
                        'class'=>'required-form-label'
                    ]) }}
                </td>
                <td class="form-cell">
                    {{ Form::text('quantity',1,[
                        'class'=>$errors->has('quantity') ? 'form-field-error price-form-text' : 'price-form-text'
                    ]) }}
                </td>
            </tr>
            <tr height="8"></tr>
            <tr>
                <td class="form-label-cell">
                    {{ Form::label('recurring_order','recurring order',[
                        'class'=>'form-label'
                    ]) }}
                </td>
                <td class="form-cell">
                    {{ Form::checkbox('recurring_order',1,null,[
                        'id'=>'recurring_order'
                    ]) }}
                </td>
            </tr>
        </tbody>

        <tbody class="frequency-section" style="display:none;">
            <tr height="5"></tr>
            <tr>
                <td class="form-label-cell">
                    {{ Form::label('autoshipfrequency_id','ship every',[
                        'class'=>'required-form-label'
                    ]) }}
                </td>
                <td class="form-cell">
                    {{ Form::select('autoshipfrequency_id',$frequencies,null,[
                        'class'=>$errors->has('autoshipfrequency_id') ? ' form-field-error form-select' : 'form-select',
                        'disabled'=>1
                    ]) }}
                </td>
            </tr>
            <!--
            <tr height="5"></tr>
            <tr>
                <td class="form-label-cell">
                    {{ Form::label('starting_at','starting',[
                        'class'=>'required-form-label'
                    ]) }}
                </td>
                <td class="form-cell">
                    {{ Form::text('starting_at',null,[
                        'class'=>$errors->has('starting_at') ? 'form-field-error short-form-text' : 'short-form-text',
                        'disabled'=>1,
                        'readonly'=>1
                    ]) }}
                </td>
            </tr>
            -->
        </tbody>
    @stop

    @section('buttons')
        <a class="cancel" href="{{ route('supplement',[$supplement->id]) }}">cancel</a>
        {{ str_repeat('&nbsp;',4) }}
        {{ Form::submit('Order',['class'=>'button']) }}
    @stop

@endif