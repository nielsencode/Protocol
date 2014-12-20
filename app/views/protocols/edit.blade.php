@extends('...clients.protocols.add')

@section('js')
	@parent
	<script>
		$(function() {
			$('.addedit-delete-link').click(function() {
                var conf = confirm('Are you sure you want to delete this protocol?');
                if(conf) {
                    $(this).closest('form').submit();
                }
            });
		});
	</script>
@stop

@section('breadcrumbs')
	{{ Breadcrumbs::make([
        'clients'=>route('clients'),
        $client->name()=>route('client',[$client->id]),
        'edit protocol'=>''
    ]) }}
@stop

@section('title')
	Edit Protocol for {{ $client->name() }}
@stop

@section('delete-link')
	@if (
		Auth::user()
			->has('delete')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Protocol',$protocol->id)
	)
		<form action="{{ route('delete protocol',[$protocol->id]) }}" method="post">
			<a class="addedit-delete-link" href="#">delete protocol</a>
		</form>
	@endif
@stop

@section('form')
	{{ Form::model($schedules,['route'=>['edit protocol',$protocol->id]]) }}
@stop

@section('supplement')
	{{ $protocol->supplement->name }}&nbsp;&nbsp;&nbsp;
@stop

@section('buttons')
	<a class="cancel" href="{{ route('client',[$client->id]) }}">cancel</a>
    {{ str_repeat('&nbsp;',4) }}
    <input type="submit" class="button" value="Save"/>
@stop