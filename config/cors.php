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
    'allowedOrigins' => ['http://localhost:3000', 'chrome-extension://fhbjgbiflinjbdggehcddcbncdddomop'],  //chrome-extension para usar o postman, que e uma app do chrome
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],  // quais os metodos são permitidos, por exemplo [GET POST] apenas
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => [],
];

