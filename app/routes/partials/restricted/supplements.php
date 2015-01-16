<?php

Route::group(['prefix'=>'supplements'],function() {

    Route::get('/',[
        'as'=>'supplements',
        'uses'=>'SupplementController@getIndex'
    ]);

    Route::group(['prefix'=>'/add','as'=>'add supplement'],function() {

        Route::get('/',[
            'uses'=>'SupplementController@getAdd'
        ]);

        Route::post('/',[
            'uses'=>'SupplementController@postAdd'
        ]);

    });

    Route::get('/export',[
        'as'=>'export supplements',
        'uses'=>'SupplementController@getExport'
    ]);

    Route::group(['prefix'=>'/import'],function() {

        Route::group(['as'=>'import supplements'],function() {

            Route::get('/',[
                'uses'=>'SupplementController@getImport'
            ]);

            Route::post('/',[
                'uses'=>'SupplementController@postImport'
            ]);

        });

        Route::get('/template',[
            'as'=>'import supplements template',
            'uses'=>'SupplementController@getImportTemplate'
        ]);

    });

    Route::group(['prefix'=>'/{supplement}'],function($supplement) {

        Route::get('/',[
            'as'=>'supplement',
            'uses'=>'SupplementController@getSupplement'
        ]);

        Route::group(['prefix'=>'/edit','as'=>'edit supplement'],function() {

            Route::get('/',[
                'uses'=>'SupplementController@getEdit'
            ]);

            Route::post('/',[
                'uses'=>'SupplementController@postEdit'
            ]);

        });

        Route::post('/delete',[
            'as'=>'delete supplement',
            'uses'=>'SupplementController@postDelete'
        ]);

        Route::group(['prefix'=>'/order','as'=>'order supplement','before'=>'enable orders'],function() {

            Route::get('/',[
                'uses'=>'SupplementController@getOrder'
            ]);

            Route::post('/',[
                'uses'=>'SupplementController@postOrder'
            ]);

        });

    });

});