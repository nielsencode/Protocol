@if (Subscriber::current())
	<style type="text/css">
		.master-header {
			background-color:{{ Subscriber::current()->setting('theme color') }} !important;
		}
	</style>
@endif