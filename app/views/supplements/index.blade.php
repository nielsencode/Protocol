@extends('layouts.master.indextable')

@section('js')
	@parent
	<script>
		$(function() {
            $('.import-supplements').click(function() {
                $('.modal-dialog').css('left',0);
            });
        });
	</script>
@stop

@section('breadcrumbs')
	{{ Breadcrumbs::make([
		'supplements'=>''
	]) }}
@stop

@section('content')
	@include('layouts.master.subviews.modaldialog',['title'=>'import supplements','url'=>route('import supplements')])
	@parent
@stop

@section('index-tools-left')
	@if (
		Auth::user()
			->has('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement')
	)
		<a class="button" href="{{ route('add supplement') }}">Add Supplement</a>
		{{ str_repeat('&nbsp;',6) }}
		<a class="index-tools-link import-supplements">import supplements</a>
		{{ str_repeat('&nbsp;',3).'&rsaquo;'.str_repeat('&nbsp;',3) }}
		<a class="index-tools-link" href="{{ route('export supplements') }}" target="_blank">export supplements</a>
	@endif
@stop

@section('index-table-header')
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('name',$sortorder) }}">
			Name
		</a>
	</th>
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('price',$sortorder) }}">
			Price
		</a>
	</th>
	<th class="index-table-column">
		<a class="index-table-column-link" href="{{ sortby('short_description',$sortorder) }}">
			Description
		</a>
	</th>
@stop

@section('index-table-rows')
	@if (!count($supplements))
		<tr class="index-table-row">
			<td class="index-table-cell" colspan="3">
				<a>no supplements.</a>
			</td>
		</tr>
	@else
		@foreach ($supplements as $supplement)
			<tr class="index-table-row" supplement-id="{{ $supplement->id }}">
				<td class="index-table-cell">
					<a href="{{ route('supplement',[$supplement->id]) }}">{{ str_limit($supplement->name,50) }}</a>
				</td>
				<td class="index-table-cell">
					<a href="{{ route('supplement',[$supplement->id]) }}">${{ $supplement->price }}</a>
				</td>
				<td class="index-table-cell">
					<a href="{{ route('supplement',[$supplement->id]) }}">{{ str_limit($supplement->short_description,75) }}</a>
				</td>
			</tr>
		@endforeach
	@endif
@stop

@section('index-table-pagination')
	{{ pageLinks($supplements) }}
@stop