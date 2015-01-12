@extends('layouts.master.centerpanelform')

@section('form')
	{{ Form::open(['route'=>'login','name'=>'login']) }}
@stop

@section('form-fields')
	<tr>
		<td class="form-label-cell">{{ Form::label('email','email:',['class'=>'required-form-label']) }}</td>
		<td class="form-cell">{{ Form::text('email',null,['class'=>$errors->has('email') ? 'form-field-error form-text focus' : 'form-text']) }}</td>
	</tr>
	<tr>
		<td class="form-label-cell">{{ Form::label('password','password:',['class'=>'required-form-label']) }}</td>
		<td class="form-cell">{{ Form::password('password',['class'=>$errors->has('password') ? 'form-field-error form-text focus' : 'form-text']) }}</td>
	</tr>
@stop

@section('buttons')
	<a href="{{ route('forgot password') }}">forgot password</a>
	&nbsp;&nbsp;
	{{ Form::submit('Login',['class'=>'button']) }}
@stop