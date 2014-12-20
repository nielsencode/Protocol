@extends('layouts.master.centerpanelform')

@section('form')
	{{ Form::open(['route'=>'forgot password']) }}
@stop

@if (!$errors->all())
	@section('messages')
		@if (Session::get('message'))
			<div class="messages" style="text-align:left; margin-bottom:15px;">
	            <li class="message">{{ Session::get('message') }}</li>
	        </div>
		@else
			<div style="text-align:left; margin-bottom:15px;">
				Enter your email to send a reset password link.
			</div>
		@endif
	@stop
@endif

@section('form-fields')
	<tr>
        <td class="form-label-cell">{{ Form::label('email','email:',['class'=>'required-form-label']) }}</td>
        <td class="form-cell">{{ Form::text('email',null,['class'=>$errors->has('email') ? 'form-field-error form-text focus' : 'form-text']) }}</td>
    </tr>
@stop

@section('buttons')
	{{ Form::submit('Go',['class'=>'button']) }}
@stop