@if (Auth::check())
	<div class="master-left-header-navbar">

		<li class="master-navbar-item">
			<a class="master-navbar-home-link" href="{{ route('home') }}">
				@if(App::environment()=='development')
					<span style="font-size:1.5em;">dev</span>
				@elseif (Subscriber::current()->setting('logo'))
					<img class="subscriber-logo" src="{{ Subscriber::current()->setting('logo') }}"/>
				@else
					<div class="master-navbar-home-link-icon"></div>
				@endif

			</a>
		</li>

		@if (Auth::user()->role->name=='client')
			<li class="master-navbar-item"><a class="master-navbar-link {{ Route::currentRouteName()=='my profile' ? 'is-selected' : '' }}" href="{{ route('my profile') }}">Profile</a></li>
		@endif

		@if (
			Auth::user()
				->has('read')
				->ofScope('Client')
				->orScope('Subscriber',Subscriber::current()->id)
				->orScope('Protocol')
				->over('Order')

			&&

			Subscriber::current()->setting('enable orders')
		)
			<li class="master-navbar-item"><a class="master-navbar-link {{ Route::currentRouteName()=='orders' ? 'is-selected' : '' }}" href="{{ route('orders') }}">Orders</a></li>
		@endif

		@if (
			Auth::user()
				->has('read')
				->ofScope('Subscriber',Subscriber::current()->id)
				->orScope('Protocol')
				->over('Client')
		)
			<li class="master-navbar-item"><a class="master-navbar-link {{ Route::currentRouteName()=='clients' ? 'is-selected' : '' }}" href="{{ route('clients') }}">Clients</a></li>
		@endif

		@if (
			Auth::user()
				->has('read')
				->ofScope('Subscriber',Subscriber::current()->id)
				->orScope('Protocol')
				->over('Supplement')
		)
			<li class="master-navbar-item"><a class="master-navbar-link {{ Route::currentRouteName()=='supplements' ? 'is-selected' : '' }}" href="{{ route('supplements') }}">Supplements</a></li>
		@endif

		@if (
			Auth::user()
				->has('read')
				->ofScope('Subscriber',Subscriber::current()->id)
				->orScope('Protocol')
				->over('User')
		)
			<li class="master-navbar-item"><a class="master-navbar-link {{ Route::currentRouteName()=='users' ? 'is-selected' : '' }}" href="{{ route('users') }}">Users</a></li>
		@endif
	</div>
@endif

<div class="master-right-header-navbar">

	<li class="master-navbar-item">
		<a class="master-small-navbar-link {{ Route::currentRouteName()=='help' ? 'is-selected' : '' }}" href="{{ route('help') }}" target="_blank">help</a>
	</li>

	@if (Auth::check())
		<li class="master-dropdown-navbar-item master-navbar-account-dropdown">

			<a class="master-small-navbar-link" href="#">
				{{ Auth::user()->name() }} <span class="master-navbar-account-link-icon"></span>
			</a>

			<div class="master-navbar-dropdown-menu">

				<div class="master-navbar-dropdown-menu-triangle"></div>

				<div class="master-navbar-dropdown-menu-header">{{ Auth::user()->email }}</div>

				<div class="master-navbar-dropdown-menu-body">

					<a class="master-navbar-dropdown-menu-item" href="{{ route('my account') }}">Account</a>

					@if (
						Auth::user()
							->has('edit')
							->ofScope('Subscriber')
							->orScope('Protocol')
							->over('Setting')
					)
						<a class="master-navbar-dropdown-menu-item" href="{{ route('settings') }}">Settings</a>
					@endif

					<a class="master-navbar-dropdown-menu-item" href="{{ route('logout') }}">Logout</a>

				</div>

			</div>

		</li>
	@endif

	@if (!Auth::check() && Subscriber::current())
		<li class="master-navbar-item">
			<a href="{{ route('login') }}" class="master-small-navbar-link">login</a>
		</li>
	@endif

</div>