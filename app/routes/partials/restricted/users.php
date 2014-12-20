<?php

Route::group(['prefix'=>'users'],function() {

    Route::get('/',[
        'as'=>'users',
        'uses'=>'UserController@getIndex'
    ]);

    Route::group(['prefix'=>'/add','as'=>'add user'],function() {

        Route::get('/',[
            'uses'=>'UserController@getAdd'
        ]);

        Route::post('/',[
            'uses'=>'UserController@postAdd'
        ]);

    });

    Route::group(['prefix'=>'/{user}'],function($user) {

        Route::get('/',[
            'as'=>'user',
            'uses'=>'UserController@getUser'
        ]);

        Route::group(['prefix'=>'/edit','as'=>'edit user'],function() {

            Route::get('/',[
                'uses'=>'UserController@getEdit'
            ]);

            Route::post('/',[
                'uses'=>'UserController@postEdit'
            ]);

        });

        Route::get('/login-as',[
            'as'=>'login as',
            'uses'=>'UserController@getLoginAs'
        ]);

        Route::post('/delete',[
            'as'=>'delete user',
            'uses'=>'UserController@postDelete'
        ]);

    });

});