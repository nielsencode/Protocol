@extends('layouts.master.master')

@section('content')
	<table class="index-table-tools">
		<tr>
			<td>
				@yield('index-tools-left')
			</td>
			<td style="text-align:right;">
				<form style="display:inline-block;" name="search form" action="" method="get">
					search
					&nbsp;&nbsp;
					<input type="text" name="q" value="{{ Input::get('q') }}" class="form-text"/>
					@if (Input::get('q'))
						&nbsp;&nbsp;
						<a href="{{ Request::path() }}">clear</a>
					@endif
				</form>
			</td>
		</tr>
	</table>

	<table class="index-table" cellpadding="0" cellspacing="0">
		<thead class="index-table-head">
			<tr>
				@yield('index-table-header')
			</tr>
		</thead>
		<tbody>
			@yield('index-table-rows')
		</tbody>
	</table>

	@yield('index-table-pagination')
@stop