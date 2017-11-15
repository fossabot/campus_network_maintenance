<?php

namespace App\School\Api;

class WebGetUserInfo extends Request
{
    protected $name = 'webGetUserInfo';

    protected $params = [
        'username' => '',
    ];
}
