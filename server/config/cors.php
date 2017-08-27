<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => false,
    'allowedOrigins' => ['http://localhost:8000', 'http://localhost:8080'], //'*' allow any
    'allowedHeaders' => ['Origin', 'Content-Type', 'Authorization'], //'*' allow any
    'allowedMethods' => ['GET', 'PUT', 'POST', 'DELETE', 'HEAD'], //'*' allow any
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => [],
];

