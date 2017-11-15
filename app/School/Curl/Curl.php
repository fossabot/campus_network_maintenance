<?php

namespace App\School\Curl;

class Curl
{
    /**
     * @param $url
     *
     * @return array
     */
    public static function get($url)
    {
        $cl = curl_init();

        curl_setopt($cl, CURLOPT_URL, $url);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($cl);
        $status = curl_getinfo($cl);
        curl_close($cl);

        return [
            'code'    => $status['http_code'] ?? 0,
            'content' => json_decode($content, true) ?: $content,
        ];
    }
}
