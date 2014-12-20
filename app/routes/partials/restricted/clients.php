<?php

Route::group(['prefix'=>'clients'],function() {

    Route::get('/',[
        'as'=>'clients',
        'uses'=>'ClientController@getIndex'
    ]);

    Route::group(['prefix'=>'/add','as'=>'add client'],function() {

        Route::get('/',[
            'uses'=>'ClientController@getAdd'
        ]);

        Route::post('/',[
            'uses'=>'ClientController@postAdd'
        ]);

    });

    Route::group(['prefix'=>'/import'],function() {

        Route::group(['as'=>'import clients'],function() {

            Route::get('/',[
                'uses'=>'ClientController@getImport'
            ]);

            Route::post('/',[
                'uses'=>'ClientController@postImport'
            ]);

        });

        Route::group(['prefix'=>'/template','as'=>'import clients template'],function() {

            Route::get('/',[
                'uses'=>'ClientController@getImportTemplate'
            ]);

        });

    });

    Route::get('/export',[
        'as'=>'export clients',
        'uses'=>'ClientController@getExport'
    ]);

    Route::group(['prefix'=>'/{client}'],function($client) {

        Route::get('/',[
            'as'=>'client',
            'uses'=>'ClientController@getClient'
        ]);

        Route::group(['prefix'=>'/account'],function() {

            Route::get('/',[
                'as'=>'client account',
                'uses'=>'ClientController@getAccount'
            ]);

            Route::group(['prefix'=>'/add','as'=>'client add account'],function() {

                Route::get('/',[
                    'uses'=>'ClientController@getAddAccount'
                ]);

                Route::post('/',[
                    'uses'=>'ClientController@postAddAccount'
                ]);

            });

            Route::group(['prefix'=>'/edit','as'=>'client edit account'],function() {

                Route::get('/',[
                    'uses'=>'ClientController@getEditAccount'
                ]);

                Route::post('/',[
                    'uses'=>'ClientController@postEditAccount'
                ]);

            });

        });

        Route::group(['prefix'=>'/edit','as'=>'edit client'],function() {

            Route::get('/',[
                'uses'=>'ClientController@getEdit'
            ]);

            Route::post('/',[
                'uses'=>'ClientController@postEdit'
            ]);

        });

        Route::post('/delete',[
            'as'=>'delete client',
            'uses'=>'ClientController@postDelete'
        ]);

        Route::get('/new-account-invitation',[
            'as'=>'client new account invitation',
            'uses'=>'ClientController@getNewAccountInvitation'
        ]);

        Route::get('/orders',[
            'as'=>'client orders',
            'uses'=>'ClientController@getOrders'
        ]);

        Route::group(['prefix'=>'/protocols'],function() {

            Route::group(['prefix'=>'/add','as'=>'client add protocol'],function() {

                Route::get('/',[
                    'uses'=>'ClientController@getAddProtocol'
                ]);

                Route::post('/',[
                    'uses'=>'ClientController@postAddProtocol'
                ]);

            });

            Route::get('/print',[
                'as'=>'client print protocols',
                'uses'=>'ClientController@getPrintProtocols'
            ]);

        });

    });

});