@extends('clients.add')

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
	@if (Auth::user()->role->name=='client')
		{{ Breadcrumbs::make(array(
            'profile'=>route('my profile'),
            'edit'=>''
        )); }}
	@else
		{{ Breadcrumbs::make(array(
			'clients'=>route('clients'),
			$client->name()=>route('client',[$client->id]),
			'edit'=>''
		)); }}
	@endif
@stop

@section('title')
	@if (Auth::user()->role->name=='client')
		Edit My Info
	@else
		Edit {{ $client->name() }}'s Info
	@endif
@stop

@section('delete-link')
	@if (
		Auth::user()
			->has('delete')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client',$client->id)
	)
		<form action="{{ route('delete client',[$client->id]) }}" method="post">
			<a class="addedit-delete-link" name="{{ $client->name() }}" href="#">delete client</a>
		</form>
	@endif
@stop

@section('form')
	{{ Form::model($clientData,[
		'route'=>Auth::user()->role->name=='client' ? 'edit my profile' : [
			'edit client',
			$client->id
		],
		'name'=>'edit client'
	]) }}
@stop

@section('buttons')
	<a class="cancel" href="{{ URL::previous() }}">cancel</a>
    {{ str_repeat('&nbsp;',4) }}
    {{ Form::submit('Save',['class'=>'button']) }}
@stop