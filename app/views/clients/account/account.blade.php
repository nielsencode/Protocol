@extends('layouts.master.infotable')

@section('css')
	{{ HTML::style('assets/css/clients/account/account.css') }}
@stop

@section('breadcrumbs')
	@if (Auth::user()->role->name=='client')
		{{ Breadcrumbs::make(array(
            'account'=>''
        )) }}
	@else
		{{ Breadcrumbs::make(array(
	        'clients'=>route('clients'),
	        $client->name()=>route('client',[$client->id]),
	        'account'=>''
	    )) }}
	@endif
@stop

@section('heading')
	@if (Auth::user()->role->name=='client')
		Account&nbsp;&nbsp;
	@else
		{{ $client->name() }}'s Account&nbsp;&nbsp;
	@endif
@stop

@section('info-table-links')
	@if(
		Auth::user()
			->has('edit')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User')

		&& $client->user
	)
		@if (Auth::user()->role->name=='client')
			<a class="info-table-edit-link" href="{{ route('edit my account') }}">edit</a>
		@else
			<a class="info-table-edit-link" href="{{ route('client edit account',[$client->id]) }}">edit</a>
		@endif
	@endif

	@if (
		Auth::user()
			->has('login')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User')

		&& $client->user
	)
		{{ str_repeat('&nbsp;',2).'&rsaquo;'.str_repeat('&nbsp;',2) }}
        <a name="login as client" href="{{ route('login as',[$client->user->id]) }}">login as {{ $client->first_name }}</a>
	@endif
@stop

@if (isset($client->user) && !isset($client->user->password) && Auth::user()->role->name!='client')
	@section('messages')
		<div class="warning-messages" style="display:inline-block;">
	        <li class="warning-message">
	            {{ $client->first_name }} needs to verify their account.
	            An invitation was sent:
	            <i>
	                {{ $client->user->emails()->where('message','auth.emails.new_account')->orderBy('created_at','desc')->first()->created_at->diffForHumans() }}
	            </i>
				&nbsp;&nbsp;&ndash;&nbsp;&nbsp;
	            <a href="{{ route('client new account invitation',[$client->id]) }}">resend invitation</a>
	        </li>
	    </div>
	 @stop
@endif

@section('content')
	@include('clients.subviews.clientmenu')

	@parent

	@if ($client->user)
    	@section('info')
    		<tr>
                <td class="info-table-label-cell">name:</td>
                <td class="info-table-cell">{{ $client->user->name() }}</td>
            </tr>
    		<tr>
    			<td class="info-table-label-cell">account type:</td>
    			<td class="info-table-cell">{{ ucfirst($client->user->role->name) }}</td>
    		</tr>
    		<tr>
    			<td class="info-table-label-cell"><label>username:</label></td>
    			<td class="info-table-cell">{{ $client->user->email }}</td>
    		</tr>
    	@stop
    @else
        @section('messages')
    	    <div style="margin-top:20px; color:#737373;">This client does not have an account.</div>
        @stop

        @section('info')
        @stop

    	@if (
    		Auth::user()
    			->has('add')
    			->ofScope('Subscriber',Subscriber::current()->id)
				->orScope('Protocol')
    			->over('User')
    	)
    		@section('buttons')
    		    <br>
    		    <a class="button" name="create account button" href="{{ route('client add account',[$client->id]) }}">Create Account</a>
    	    @stop
    	@endif
    @endif
@stop

