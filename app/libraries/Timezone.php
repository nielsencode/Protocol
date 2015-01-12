<?php

class Timezone {

    public static function user() {
        return self::get('user');
    }

    public static function get($type) {
        return Session::get("timezone_$type");
    }

    public static function set($type,$name) {
        Session::put("timezone_user",$name);
    }

}