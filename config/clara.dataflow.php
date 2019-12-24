<?php

return [
    
    'path' => storage_path('dataflow/exports'),
    
    'route' => [
        
        'web' => [
            'prefix'    => 'admin',
            'middleware' => ['web', \CeddyG\ClaraSentinel\Http\Middleware\SentinelAccessMiddleware::class]
        ],
        'api' => [
            'prefix'    => 'api',
            'middleware' => ['api']
        ],
        'api-admin' => [
            'prefix'    => 'api/admin',
            'middleware' => ['api', \CeddyG\ClaraSentinel\Http\Middleware\SentinelAccessMiddleware::class.':api']
        ]
    ],
    
    'controller'        => 'CeddyG\ClaraDataflow\Http\Controllers\DataflowController',
    'controller-admin'  => 'CeddyG\ClaraDataflow\Http\Controllers\Admin\DataflowController',
    'repository'        => 'CeddyG\ClaraDataflow\Repositories\DataflowRepository',
    'formrequest'       => 'CeddyG\ClaraDataflow\Http\Requests\DataflowRequest',
];

