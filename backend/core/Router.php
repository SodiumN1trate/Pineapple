<?php

class Router
{
    private $uri = array();
    private $controller = array();
    private $method = array();
    public function add($uri, $controller = null, $method = 'GET')
    {
        $this->uri[] = $uri;
        if($controller != null)
        {
            $this->controller[] = $controller;
        }
        $this->method[] = $method;
    }

    public function submit()
    {
        $uriParameter = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
     
        foreach ($this->uri as $uriKey => $uriValue)
        {
            if($uriValue ==  $uriParameter)
            {
                if(strpos($this->controller[$uriKey], '::'))
                {
                    if($this->method[$uriKey] == 'POST'){
                        call_user_func($this->controller[$uriKey], $_POST);
                    }
                    else
                    {
                        call_user_func($this->controller[$uriKey]);
                    }
                }
                else
                {
                    new $this->controller[$uriKey];
                }
            }
        }

    }
}