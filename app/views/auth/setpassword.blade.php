@extends('layouts.master.centerpanelform')

@section('form')
    {{ Form::open(['route'=>['set password','token'=>$token->token]]) }}
@stop

@if (!$errors->all())
    @section('messages')
        @if (Session::get('message'))
            <div class="messages" style="text-align:left; margin-bottom:15px;">
                <li class="message">{{ Session::get('message') }}</li>
            </div>
        @else
            <div style="text-align:left; margin-bottom:15px;">
                @section('instructions')
                    Enter a password for your account.
                @show
            </div>
        @endif
    @stop
@endif

@section('form-fields')
    <tr>
        <td class="form-label-cell">
            {{ Form::label('password','password:',['class'=>'required-form-label focus']) }}
        </td>
        <td class="form-cell">
            {{ Form::password('password',['class'=>'form-text']) }}
        </td>
    </tr>
    <tr>
        <td class="form-label-cell">
            {{ Form::label('retype password','retype password:',['class'=>'required-form-label']) }}
        </td>
        <td class="form-cell">
            {{ Form::password('retype password',['class'=>'form-text']) }}
        </td>
    </tr>
@stop

@section('buttons')
    {{ Form::submit('Save',['class'=>'button']) }}
@stop