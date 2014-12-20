<?php

View::composers(array(
    '\Clients\AddComposer'=>array('clients.add','clients.edit'),
    '\Clients\Account\AddComposer'=>array('clients.account.add'),
    '\Layouts\Master\IndextableComposer'=>array(
        'clients.index',
        'supplements.index',
        'orders.index',
        'users.index'
    ),
    '\Supplements\OrderComposer'=>array('supplements.order'),
    '\myUsers\AddComposer'=>array(
        'users.add'
    )
));