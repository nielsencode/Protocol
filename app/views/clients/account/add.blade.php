@extends('layouts.master.addeditform')

@section('breadcrumbs')
	{{ Breadcrumbs::make(array(
		'clients'=>url('/clients'),
		$client->name()=>route('client',[$client->id]),
		'account'=>route('client account',[$client->id]),
		'add'=>''
	)) }}
@stop

@section('title')
	Add Account for {{ $client->name() }}
@stop

@section('form')
	{{ Form::open(['route'=>['client add account',$client->id]]) }}
@stop

@if (!$errors->all())
	@section('messages')
		<div class="messages">
            <li class="message">Client will be sent an email invitation to create a password and confirm their account.</li>
        </div>
	@stop
@endif

@section('form-fields')
	<tr>
		<td class="form-label-cell">
			{{ Form::label('email','email (username)',['class'=>'required-form-label']) }}
		</td>
		<td class="form-cell">
			{{ Form::text('email',Input::has('email') ? null : $client->email,[
				'class'=>$errors->has('email') ? 'form-field-error long-form-text' : 'long-form-text'
			]) }}
		</td>
	</tr>
	<tr>
		<td class="form-label-cell">
			{{ Form::label('first_name','first name',['class'=>'required-form-label']) }}
		</td>
		<td>
			{{ Form::text('first_name',Input::has('first_name') ? null : $client->first_name,[
				'class'=>$errors->has('first_name') ? 'form-field-error long-form-text' : 'long-form-text'
			]) }}
		</td>
	</tr>
	<tr>
        <td class="form-label-cell">
            {{ Form::label('last_name','last name',['class'=>'required-form-label']) }}
        </td>
        <td>
            {{ Form::text('last_name',Input::has('last_name') ? null : $client->last_name,[
                'class'=>$errors->has('last_name') ? 'form-field-error long-form-text' : 'long-form-text'
            ]) }}
        </td>
    </tr>
@stop

@section('buttons')
	<a href="{{ route('client account',[$client->id]) }}">cancel</a>
	&nbsp;&nbsp;
	<input type="submit" class="button" value="Save"/>
@stop