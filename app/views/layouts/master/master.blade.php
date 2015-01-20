<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{{ Subscriber::current() ? Subscriber::current()->name : 'Protocol' }}</title>

	@section('js')
		{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js') }}
		{{-- {{ HTML::script('assets/js/jquery.min.js') }} --}}
		{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js') }}
		{{ HTML::script('assets/js/timezone.js') }}
		{{ HTML::script('assets/js/layouts/master/master.js') }}
	@show

	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

	@section('css')
		{{ HTML::style('assets/css/layouts/master/master.css') }}
	@show

	@include('layouts.master.settings')
</head>
<body>

	<div class="master-main-wrapper">

		<!-- Begin Header -->
		<div class="master-header">

			<div class="master-inner-header">
				@section('navbar')
					@include('layouts.master.subviews.navbar')
				@show
			</div>

		</div>
		<!-- End Header -->

		<div class="breadcrumbs">
			<div class="breadcrumbs-inner">
				@yield('breadcrumbs')
			</div>
		</div>

		<!-- Begin Content -->
		<div class="master-content">
			@yield('content')
		</div>
		<!-- End Content -->

		<div class="master-footer-space"></div>

	</div>

	<!-- Begin Footer -->
	<div class="master-footer">

		<div class="master-inner-content">

			@section('footer')
				<div class="master-footer-credit">
					powered by <span class="protocol">protocol</span>.
				</div>
			@show

		</div>

	</div>
	<!-- End Footer -->

</body>
</html>