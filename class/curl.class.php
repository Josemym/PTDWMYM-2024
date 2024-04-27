<?php

class curl{
    private $url;
    private $option;
    private $handler;
    private $response;

    public function __construct($url, $option = null)
    {
        $this->url = $url;
        $this->option = is_null($option) ? CURLOPT_URL : $option;
    }

    public function init()
    {
        $this->handler = curl_init();
        return $this;
    }

    public function setOption($option = null, $value)
    {
        curl_setopt($this->handler, is_null($option) ? $this->option : $option, is_null($value) ? $this->url : $value);
        return $this;
    }

    public function execute()
    {
        return curl_exec($this->handler);
    }

    public function buildQuery(array $array)
    {
        curl_setopt($this->handler, CURLOPT_POSTFIELDS, json_encode($array));
        return $this;
    }

    public function decode()
    {
        $this->response = json_decode($this->execute(), true);
        return $this;
    }

    public function fecth()
    {
        return json_decode(json_encode($this->response));
    }

    public function close()
    {
        curl_close($this->handler);
        return $this;
    }
}
?>