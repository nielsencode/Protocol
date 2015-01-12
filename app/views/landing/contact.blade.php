@extends('layouts.landing.landing')

@section('css')
    @parent

    <style type="text/css">

    </style>
@stop

@section('content')

    <div style="width:500px; margin:auto;">

        <div class="heading">
            Contact Us
        </div>

        @if ($errors->all())
            <div class="error-messages">
                @foreach ($errors->all() as $error)
                    <li class="error-message">{{ $error }}</li>
                @endforeach
            </div>
        @endif

        @if (Session::has('success'))
            <div class="messages">
                <li class="message">Thanks. Your message has been sent.</li>
            </div>
        @endif

        @if (!Session::has('success'))

            {{ Form::open(['route'=>'contact']) }}

                <div style="font-size:14px; line-height:2.25em; margin:10px 0;">
                    name

                    {{ Form::text('name',null,['class'=>'form-text','style'=>'width:97.5%;']) }}
                </div>

                <div style="font-size:14px; line-height:2.25em; margin:10px 0;">
                    email

                    {{ Form::text('email',null,['class'=>'form-text','style'=>'width:97.5%;']) }}
                </div>

                <div style="font-size:14px; line-height:2.25em; margin:10px 0;">
                    subject

                    {{ Form::text('subject',null,['class'=>'form-text','style'=>'width:97.5%;']) }}
                </div>

                <div style="font-size:14px; line-height:2.25em; margin:10px 0;">
                    message

                    {{ Form::textarea('message',null,['class'=>'form-text','style'=>'width:97.5%; max-width:97.5%;']) }}
                </div>

                <hr class="hr"/>

                <div style="font-size:14px; line-height:2.25em; margin:20px 0; text-align:right;">
                    <button class="button">send</button>
                </div>

            {{ Form::close() }}

        @endif

    </div>

@stop