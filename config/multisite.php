<?php

return [

    'host' => env('MULTISITE_HOST', 'localhost.dev'),

    'views' => [

        'overwrite' => true,

        'overwrite_path' => 'partials.*',

        'sites_path' => 'sites'

    ],

];