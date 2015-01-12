<?php

Route::group(['prefix'=>'orders'],function() {

    Route::get('/',[
        'as'=>'orders',
        'uses'=>'OrderController@getIndex'
    ]);

    Route::post('/bulk-edit',[
        'as'=>'bulk edit orders',
        'uses'=>'OrderController@postBulkEdit'
    ]);

    Route::group(['prefix'=>'/{cancelledOrder}'],function($order) {

        Route::get('/',[
            'as'=>'order',
            'uses'=>'OrderController@getOrder'
        ]);

        Route::post('/cancel-recurring',[
            'as'=>'cancel recurring order',
            'uses'=>'OrderController@postCancelRecurring'
        ]);

        Route::post('/delete',[
            'as'=>'delete order',
            'uses'=>'OrderController@postDelete'
        ]);

        Route::group(['prefix'=>'/edit','as'=>'edit order'],function() {

            Route::get('/',[
                'uses'=>'OrderController@getEdit'
            ]);

        });

        Route::post('/fulfill',[
            'as'=>'mark order as fulfilled',
            'uses'=>'OrderController@postFulfill'
        ]);

    });

    Route::group(['prefix'=>'/cancelled'],function() {

        Route::group(['prefix'=>'/{cancelledOrder}'],function($order) {

            Route::get('/',[
                'as'=>'cancelled order',
                'uses'=>'OrderController@getOrder'
            ]);

        });

    });

});