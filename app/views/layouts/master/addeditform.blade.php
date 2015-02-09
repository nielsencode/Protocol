@extends('layouts.master.master')

@section('css')
	@parent
	{{ HTML::style('assets/css/layouts/master/addeditform.css') }}
@stop

@section('content')
	<table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:25px;">
		<tr>
			<td>
				<div class="heading" style="margin-bottom:0;">
                    @yield('title')
                </div>
			</td>
			<td style="text-align:right;">
				@yield('delete-link')
			</td>
		</tr>
		<tr>
			<td colspan="2">
				@yield('description')
			</td>
		</tr>
	</table>

	@yield('form')

	<table>
		<tbody>
			<tr>
				<td colspan="2">
					@section('messages')
						@if ($errors->all())
							<div class="error-messages">
								@foreach ($errors->all() as $error)
									<li class="error-message">{{ $error }}</li>
								@endforeach
							</div>
						@endif
					@show
				</td>
			</tr>
		</tbody>

		@yield('form-fields')

	</table>

	<hr class="hr"/>

	<div style="text-align:right;">
		@yield('buttons')
	</div>

	{{ Form::close() }}
@stop