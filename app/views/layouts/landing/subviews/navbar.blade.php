<div style="float:left;">

    <li class="master-navbar-item">
        <a class="master-navbar-link">PROTOCOL</a>
    </li>

</div>

<div style="float:right;">

    <!--

    <li class="master-navbar-item">
        <a class="master-small-navbar-link" href="">Features</a>
    </li>

    <li class="master-navbar-item">
        <a class="master-small-navbar-link" href="">Pricing</a>
    </li>

    <li class="master-navbar-item">
        <a class="master-small-navbar-link" href="">Sign Up</a>
    </li>

    -->

    <li class="master-navbar-item">
        <a class="master-small-navbar-link {{ Route::currentRouteName()=='contact' ? 'is-selected' : '' }}" href="{{ route('contact') }}">Contact</a>
    </li>

</div>