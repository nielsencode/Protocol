@extends('supplements.add')

@section('js')
	@parent
	<script>
        $(function() {
            $('.addedit-delete-link').click(function() {
                if(confirm('Are you sure you want to delete "'+$(this).attr('name')+'"')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@stop

@section('breadcrumbs')
	{{ Breadcrumbs::make([
		'supplements'=>route('supplements'),
		$supplement['name']=>route('supplement',[$supplement['id']]),
		'edit'=>''
	]); }}
@stop

@section('title')
	Edit {{ $supplement['name'] }}
@stop

@section('delete-link')
	@if (
		Auth::user()
			->has('delete')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement',$supplement['id'])
	)
		<form action="{{ route('delete supplement',[$supplement['id']]) }}" method="post">
			<a class="addedit-delete-link" name="{{ $supplement['name'] }}" href="#">delete supplement</a>
		</form>
	@endif
@stop

@section('form')
	{{ Form::model($supplement,['route'=>['edit supplement',$supplement['id']]]) }}
@stop