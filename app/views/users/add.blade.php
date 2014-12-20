@extends('layouts.master.addeditform')

@section('breadcrumbs')
    {{ Breadcrumbs::make(array(
        'users'=>route('users'),
        'add'=>''
    )) }}
@stop

@section('title')
    Add New User
@stop

@section('form')
    {{ Form::open(['route'=>['add user']]) }}
@stop

@if (!$errors->all())
    @section('messages')
        <div class="messages">
            <li class="message">User will be sent an email invitation to create a password and confirm their account.</li>
        </div>
    @stop
@endif

@section('form-fields')
    <tr>
        <td class="form-label-cell">
            {{ Form::label('user type','user type',['class'=>'required-form-label']) }}
        </td>
        <td class="form-cell">
            {{ Form::select('role',$roles,null,['class'=>'form-select']) }}
        </td>
    </tr>

    <tr>
        <td class="form-label-cell">
            {{ Form::label('email','email (username)',['class'=>'required-form-label']) }}
        </td>
        <td class="form-cell">
            {{ Form::text('email',null,[
                'class'=>$errors->has('email') ? 'form-field-error long-form-text' : 'long-form-text'
            ]) }}
        </td>
    </tr>

    <tr>
        <td class="form-label-cell">
            {{ Form::label('first_name','first name',['class'=>'required-form-label']) }}
        </td>
        <td class="form-cell">
            {{ Form::text('first_name',null,[
                'class'=>$errors->has('first_name') ? 'form-field-error long-form-text' : 'long-form-text'
            ]) }}
        </td>
    </tr>

    <tr>
        <td class="form-label-cell">
            {{ Form::label('last_name','last name',['class'=>'required-form-label']) }}
        </td>
        <td class="form-cell">
            {{ Form::text('last_name',null,[
                'class'=>$errors->has('last_name') ? 'form-field-error long-form-text' : 'long-form-text'
            ]) }}
        </td>
    </tr>
@stop

@section('buttons')
    <a href="{{ route('users') }}">cancel</a>
    &nbsp;&nbsp;
    <input type="submit" class="button" value="Save"/>
@stop