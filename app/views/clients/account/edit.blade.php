@extends('users.edit')

@section('breadcrumbs')
	@if (
		Auth::user()
			->has('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User')
	)
		{{ Breadcrumbs::make(array(
			'clients'=>url('/clients'),
			$client->name()=>route('client',[$client->id]),
			'account'=>route('client account',[$client->id]),
			'edit'=>''
		)) }}
	@else
		{{ Breadcrumbs::make(array(
            'account'=>route('my account'),
            'edit'=>''
        )) }}
	@endif
@stop

@section('title')
	@if (Auth::user()->role->name=='client')
        Edit Account
    @else
        Edit Account for {{ $client->name() }}
    @endif
@stop

@section('form')
	{{ Form::model($user->toArray(),[
		'route'=>Auth::user()->role->name=='client' ? 'edit my account' :
			[
				'client edit account',
				$client->id
			]
		]
	)}}
	@if (Input::has('token'))
		{{ Form::hidden('token',Input::get('token')) }}
	@endif
@stop

@section('buttons')
	@if (Auth::user())
		<a href="{{ URL::previous() }}">cancel</a>
		&nbsp;&nbsp;
	@endif
	<button class="button">Save</button>
@stop