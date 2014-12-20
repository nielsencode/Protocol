@section('js')
	@parent

	{{ HTML::script('assets/js/layouts/master/subviews/modaldialog.js') }}
@stop

<div class="modal-dialog">

	<div class="modal-dialog-box">

		<div class="modal-dialog-box-inner">

			<div class="modal-dialog-box-header">
				<div class="modal-dialog-box-close">&times;</div>
				<span class="modal-dialog-box-title">{{ ucwords($title) }}</span>
			</div>

			<div class="modal-dialog-box-frame-outer">
				<iframe src="{{ $url }}" class="modal-dialog-box-frame"></iframe>
			</div>

		</div>

	</div>

</div>