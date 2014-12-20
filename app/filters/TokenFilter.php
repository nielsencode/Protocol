<?php

class TokenFilter {

    public function filter($route,$request) {
        if(!Token::getUser()) {
            App::abort(404);
        }
    }

}