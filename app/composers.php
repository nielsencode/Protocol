<?php

View::composers([
    '\Clients\AddComposer'=>[
        'clients.add',
        'clients.edit'
    ],
    '\Clients\Account\AddComposer'=>[
        'clients.account.add'
    ],
    '\Layouts\Master\IndextableComposer'=>[
        'clients.index',
        'supplements.index',
        'orders.index',
        'users.index'
    ],
    '\Supplements\OrderComposer'=>[
        'supplements.order'
    ],
    '\myUsers\AddComposer'=>[
        'users.add',
        'users.edit'
    ]
]);