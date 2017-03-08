<?php

namespace Draguo\Ip;

class Ip
{
    protected $url = 'http://ip.taobao.com/service/getIpInfo.php?ip=';
    protected $result = '';

    public function location($arguments)
    {
        $ip = $arguments[0];
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

    public function __call($name, $arguments)
    {
        $map = ['getLocation' => 'location'];
        if (is_array($arguments)){
            $arguments = $arguments[0];
        }
        return $this->$map[$name]($arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        $ip = new static();
        return $ip->$name($arguments);
    }
}
