<?php

return [
    
    'path' => storage_path('dataflow/exports'),
    
    'route' => [
        
        'web' => [
            'prefix'    => '',
            'middleware' => 'web'
        ],
        'api' => [
            'prefix'    => '',
            'middleware' => 'api'
        ]
    ],
    
    
];

