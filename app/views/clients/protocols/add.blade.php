@extends('layouts.master.addeditform')

@section('js')
	@parent
	{{ HTML::script('assets/js/clients/protocols/add.js') }}
@stop

@section('content')
    @include('layouts.master.subviews.modaldialog',['title'=>'choose supplement','url'=>route('protocol supplements')])
    @parent
@stop

@section('breadcrumbs')
	{{ Breadcrumbs::make(array(
		'clients'=>route('clients'),
		$client->name()=>route('client',[$client->id]),
		'add protocol'=>''
	)) }}
@stop

@section('title')
	Add Protocol for {{ $client->name() }}
@stop

@section('description')
    <div class="add-edit-form-description">
        Choose a supplement. Then enter instructions to let {{ $client->first_name }} know how to take it.
    </div>
@stop

@section('form')
	{{ Form::open(['route'=>['client add protocol',$client->id]]) }}
@stop

@section('form-fields')
	{{ Form::hidden('supplement') }}
	<tr>
        <td class="form-label-cell">
            <label class="required-form-label">supplement</label>
        </td>
        <td colspan="3" class="form-checkbox-cell">
            <span class="supplement">@yield('supplement')</span>
            <a class="choose-supplement" href="#">choose supplement</a>
        </td>
    </tr>
    <tr height="10"></tr>
    @foreach (Scheduletime::all() as $index=>$scheduletime)
        <tr class="form-row">
            <td class="form-label-cell">
                @if($index==0)
                    <label class="required-form-label">schedule</label>
                @endif
            </td>
            <td class="form-checkbox-cell">
                {{ Form::checkbox("schedules=>$index=>scheduletime_id",$scheduletime->id,false,[
                    'id'=>"scheduletime_$index"
                ]) }}
            </td>
            <td class="form-checkbox-cell">
                {{ Form::label("scheduletime_$index",Subscriber::current()->setting('schedule times')[$index],[
                    'class'=>'alternate-form-label'
                ]) }}
            </td>
            <td class="form-cell">
                {{ Form::text("schedules=>$index=>prescription",null,[
                    'class'=>'long-form-text'
                ]) }}
            </td>
        </tr>
    @endforeach
@stop

@section('buttons')
	<a class="cancel" href="{{ route('client',[$client->id]) }}">cancel</a>
    {{ str_repeat('&nbsp;',4) }}
    <input type="submit" class="disabled-button" disabled="disabled" value="Save"/>
@stop