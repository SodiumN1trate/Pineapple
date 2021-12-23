<?php

class Router
{
    private $uri = array();
    private $controller = array();

    public function add($uri, $controller = null)
    {
        array_push($this->uri, $uri);
        if($controller != null)
        {
            array_push($this->controller, $controller);
        }
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
                    call_user_func($this->controller[$uriKey]);
                }
                else {
                    new $this->controller[$uriKey];
                }
            }
        }

    }
}