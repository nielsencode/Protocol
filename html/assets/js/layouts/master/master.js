require.config({
	baseUrl: '/assets/js/layouts/master'
});

var loadingAssets = $.Deferred();

require([
	'/assets/js/timezone.js',
	'/assets/js/bootstrap-tour-standalone.min.js'
],function() {
	loadingAssets.resolve();
});

loadingAssets.done(function() {
	require([
		'partials/forms',
		'subviews/navbar',
		'tour/tour'
	]);
});