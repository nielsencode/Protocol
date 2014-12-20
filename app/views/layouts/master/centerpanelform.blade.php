@extends('layouts.master.master')

@section('css')
	@parent
	{{ HTML::style('assets/css/layouts/master/centerpanelform.css') }}
@stop

@section('content')
	<div class="center-panel">
		<div class="inner-center-panel">

			@section('messages')
                @if ($errors->all())
                    <div class="error-messages">
                        @foreach ($errors->all() as $error)
                            <li class="error-message">{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
            @show

			@yield('form')

			<table class="center-panel-form-table" cellpadding="0" cellspacing="0">

				@yield('form-fields')

			</table>

			<div style="text-align:right; margin-top:15px;">
                @yield('buttons')
            </div>

			{{ Form::close() }}

		</div>
	</div>
@stop