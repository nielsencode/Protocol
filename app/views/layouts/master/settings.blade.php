<?php
	/*if(Auth::guest()) {
		return;
	}*/
?>

<style type="text/css">
	.master-header {
		background-color:{{ Settingname::where('name','theme color')->first()->subscriberValue }} !important;
	}
</style>