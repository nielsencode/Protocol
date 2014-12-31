@extends('...layouts.master.infotable')

@section('breadcrumbs')
	@if (
		Auth::user()
			->has('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User',$user->id)
	)
		{{ Breadcrumbs::make(array(
		    'users'=>url('users'),
		    $user->name()=>''
		)) }}
	@else
		{{ Breadcrumbs::make(array(
			'home'=>route('home'),
			$user->name()=>''
		)) }}
	@endif
@stop

@section('heading')
	{{ $user->name() }}'s Account&nbsp;&nbsp;
@stop

@section('info-table-links')
	@if (
		Auth::user()
			->has('edit')
			->ofScope('User',$user->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User',$user->id)
	)
        <a class="info-table-edit-link" href="{{ route('edit user',[$user->id]) }}">edit</a>
    @endif

	@if (
		Auth::user()
			->has('login')
			->ofScope('Protocol')
			->over('User')
		&&
		!Auth::user()->is($user->id)
	)
		{{ str_repeat('&nbsp;',2).'&rsaquo;'.str_repeat('&nbsp;',2) }}
		<a href="{{ route('login as',[$user->id]) }}">login as {{ $user->first_name }}</a>
	@endif
@stop

@if (
	!isset($user->password) &&
	Auth::user()
		->has('edit')
		->ofScope('Subscriber',Subscriber::current()->id)
		->orScope('Protocol')
		->over('User')
)
	@section('messages')
		<div class="warning-messages" style="display:inline-block;">
			<li class="warning-message">
				{{ $user->first_name }} needs to verify their account.

				@if (
					$user->emails()->where('message','auth.emails.new_account')->count()
				)
					An invitation was sent:
					<i>
						{{
							$user->emails()->where('message','auth.emails.new_account')
								->orderBy('created_at','desc')
								->first()
								->created_at
								->diffForHumans()
						}}
					</i>

					&nbsp;&nbsp;&ndash;&nbsp;&nbsp;

					<a href="{{ route('new account invitation',[$user->id]) }}">resend invitation</a>
				@else
					&nbsp;&nbsp;&ndash;&nbsp;&nbsp;

					<a href="{{ route('new account invitation',[$user->id]) }}">send invitation</a>
				@endif
			</li>
		</div>
	@stop
@endif

@section('info')
	<tr>
        <td class="info-table-label-cell">name:</td>
        <td class="info-table-cell">{{ $user->name() }}</td>
    </tr>
	<tr>
		<td class="info-table-label-cell">account type:</td>
		<td class="info-table-cell">{{ ucfirst($user->role->name) }}</td>
	</tr>
	<tr>
		<td class="info-table-label-cell"><label>username:</label></td>
		<td class="info-table-cell">{{ $user->email }}</td>
	</tr>
@stop