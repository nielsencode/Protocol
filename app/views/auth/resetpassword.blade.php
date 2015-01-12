@extends('auth.setpassword')

@section('form')
    {{ Form::open(['route'=>['reset password','token'=>$token->token]]) }}
@stop

@section('instructions')
    Enter a new password for your account.
@stop