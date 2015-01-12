<?php

foreach(File::files(__DIR__) as $partial) {
	require_once $partial;
}