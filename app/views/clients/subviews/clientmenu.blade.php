<div class="client-menu">
	@if (Auth::user()->role->name=='client')
		<a class="client-{{ Route::currentRouteName()=='my profile' ? 'current-' : '' }}menu-item" href="{{ route('my profile') }}">Profile</a>

		@if (
			Auth::user()
				->has('read')
				->ofScope('Client',$client->id)
				->orScope('Subscriber',Subscriber::current()->id)
				->orScope('Protocol')
				->over('User')
		)
			<a class="client-{{ Route::currentRouteName()=='my account' ? 'current-' : '' }}menu-item" href="{{ route('my account') }}">Account</a>
		@endif
	@else
		<a class="client-{{ Route::currentRouteName()=='client' ? 'current-' : '' }}menu-item" href="{{ route('client',[$client->id]) }}">Profile</a>

		@if (
			Auth::user()
				->has('read')
				->ofScope('Client',$client->id)
				->orScope('Subscriber',Subscriber::current()->id)
				->orScope('Protocol')
				->over('User')
		)
			<a class="client-{{ Route::currentRouteName()=='client account' ? 'current-' : '' }}menu-item" href="{{ route('client account',[$client->id]) }}">Account</a>
		@endif
	@endif
</div>