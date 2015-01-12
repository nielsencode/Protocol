@extends('layouts.master.master')

@section('content')
	<div class="heading">
		@yield('heading')

		<div class="info-table-links">
			@section('info-table-links')
				<a class="info-table-edit-link" href="#">edit</a>
			@show
		</div>
	</div>

	@yield('messages')

	<table class="info-table" cellpadding="0" cellspacing="0">
		@section('info')
			<thead>
                <tr>
                    <th class="info-table-section-label">info:</th>
                    <th class="info-table-section-cell"></th>
                </tr>
            </thead>
            <tbody>
				<tr>
		            <td class="info-table-label-cell">label:</td>
		            <td class="info-table-cell">value</td>
		        </tr>
				<tr>
		            <td class="info-table-label-cell">label:</td>
		            <td class="info-table-cell">value</td>
		        </tr>
				<tr>
		            <td class="info-table-label-cell">label:</td>
		            <td class="info-table-cell">value</td>
		        </tr>
            </tbody>
		@show

		@yield('buttons')
	</table>
@stop