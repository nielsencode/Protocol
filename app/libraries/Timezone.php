<?php

class Timezone {

    public static function user() {
        return self::get('user');
    }

    public static function get($type='user') {
        return Session::get("timezone_$type");
    }

    public static function set($type='user',$name) {
        Session::put("timezone_$type",$name);
    }

}