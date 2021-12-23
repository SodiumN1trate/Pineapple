<?php

function autoload($classname)
{
    include_once 'core/' . $classname . '.php';
}

spl_autoload_register('autoload');