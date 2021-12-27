<?php

include 'backend/autoload.php';
include 'backend/core/Helper.php';
include 'config.php';


$router = new Router;

$router->add('/', 'Page::client');
$router->add('/email_list', 'Page::client');


$router->add('/add_email', 'Email::addEmail');
$router->add('/get_email_list', 'Email::getEmails');
$router->add('/get_host_list', 'Email::getHosts');
$router->add('/sorted_by_name', 'Email::getEmailsSortedByName', 'POST');
$router->add('/sorted_by_host', 'Email::getEmailsSortedByHost', 'POST');
$router->add('/sorted_by_date', 'Email::getEmailsSortedByDate', 'POST');
$router->add('/search_email', 'Email::searchEmail', 'POST');
$router->add('/delete_email', 'Email::deleteEmail', 'POST');

$router->submit();

