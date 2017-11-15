<?php

namespace App\School\Api;

use App\School\Curl\Curl;

class Request
{
    protected $name;

    protected $params = [];

    public function __construct($params)
    {
        $this->params = array_merge(['appid' => env('SCHOOL_APPID')], $params);
    }

    /**
     * 发送 GET 请求
     *
     * @return array
     */
    public function execute()
    {
        $params = $this->composeParams();

        $sign = $this->generateSign($params);

        $url = env('SCHOOL_URL') . '/' . $this->name . '/sign/' . $sign . '/' . $params;

        $result = Curl::get($url);

        return array_merge(['url' => $url], $result);
    }

    /**
     * 拼接参数
     *
     * @return string
     */
    private function composeParams()
    {
        $params = '';

        foreach ($this->params as $key => $param) {
            $params .= $key . '/' . $param . '/';
        }

        return substr($params, 0, -1);
    }

    /**
     * 生成 Sign
     *
     * @param $params
     *
     * @return string
     */
    private function generateSign($params)
    {
        return strtoupper(md5(env('SCHOOL_SECRET') . $params . env('SCHOOL_SECRET')));
    }
}
