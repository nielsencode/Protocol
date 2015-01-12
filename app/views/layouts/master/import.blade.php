<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />

	{{ HTML::script('assets/js/jquery.min.js') }}
	{{ HTML::script('/assets/js/layouts/master/import.js') }}

	{{ HTML::style('assets/css/layouts/master/import.css') }}

</head>
<body>

	<div class="import-content-outer">

		<div class="import-content">

			@if (Session::get('errors'))
				<div class="error-messages" style="display:inline-block;">
					@foreach (Session::get('errors') as $error)
						<li class="error-message">{{ $error }}</li>
					@endforeach
				</div>
			@endif

			@if (Session::get('success'))
				<div class="messages" style="display:inline-block;">
					<li class="message">{{ Session::get('success') }}</li>
				</div>

				<br>

				<button class="ok-button">OK</button>
			@else
				<form action="" method="post" enctype="multipart/form-data">
					<input type="file" name="data" style="position:absolute; left:-9999px;"/>
				</form>

				<button class="button">Choose File</button>

				<div style="color:#787878; margin-top:10px; line-height:1.5em;">
					file must be a .csv&nbsp;
					<a style="color:#787878;" href="@yield('template route')" target="_blank">download template</a>
				</div>
			@endif

		</div>

	</div>

</body>
</html>