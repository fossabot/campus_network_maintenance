<?php

namespace App\School\Api;

class WebAuthenticate extends Request
{
    protected $name = 'webAuthenticate';

    protected $params = [
        'username' => '',
        'password' => '',
    ];
}
