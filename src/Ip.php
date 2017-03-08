<?php

namespace Draguo\Ip;

class Ip
{
    protected $url = 'http://ip.taobao.com/service/getIpInfo.php?ip=';
    protected $result = '';

    public function getLocation($ip)
    {
        $data = $this->curl($ip);
        $this->format($data);
        return $this->result;
    }

    public function curl($ip)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.$ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        return $response;
        curl_close($ch);
    }

    public function format($response)
    {
        $data = json_decode($response)->data;
        $result = $data->region.$data->city.$data->county;
        return $this->result = $result;
    }
}
