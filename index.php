<?php

include 'backend/autoload.php';
include 'backend/core/Helper.php';

$router = new Router;

$router->add('/', 'Home::index');
$router->add('/add_email', 'Email::add_email');

$router->submit();