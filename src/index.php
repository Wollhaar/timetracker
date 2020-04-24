<?php

define('PWD', str_replace('\\', '/', getcwd()));
define('PUBLIC','/resources/public/');
define('PRIVATE','/resources/private/');

//$pwd_view = '/timetracker/';


include_once PWD . 'config.php';



if (empty($_GET)) {
    include_once PWD . '/resources/private/tracking_view.php';
}