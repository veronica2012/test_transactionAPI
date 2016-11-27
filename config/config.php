<?php
return [

    'components' => [
        'db' => [
            'class' => 'components/DbConnection',
            'dataSourceName' => 'mysql:host=localhost:8889;dbname=transaction_db',
            'user' => 'root',
            'password' => 'root',
        ],
        'urlManager' => [
            'class' => 'components/UrlManager',
            'rules' => [
                ['controller' => 'transaction', 'allowedMethods' => ['POST']]
            ]
        ],
        'request' => [
            'class' => 'components/Request'
        ],
        'response' => [
            'class' => 'components/Response'
        ],
        'errorHandler' => [
            'class' => 'components/ErrorHandler'
        ],
    ]

];