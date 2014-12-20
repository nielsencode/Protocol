<?php

Route::group(['prefix'=>'protocols'],function() {

    Route::get('/supplements',[
        'as'=>'protocol supplements',
        'uses'=>'ProtocolController@getSupplements'
    ]);

    Route::group(['prefix'=>'/{protocol}'],function($protocol) {

        Route::group(['prefix'=>'/edit','as'=>'edit protocol'],function() {

            Route::get('/',[
                'uses'=>'ProtocolController@getEdit'
            ]);

            Route::post('/',[
                'uses'=>'ProtocolController@postEdit'
            ]);

        });

        Route::post('/delete',[
            'as'=>'delete protocol',
            'uses'=>'ProtocolController@postDelete'
        ]);

    });

    if(Auth::user() && Auth::user()->role->name=='client') {

        Route::get('/print',['as'=>'print my protocols',function() {

            return (new ClientController)->getPrintProtocols(Auth::user()->client);

        }]);

    }

});