<?php
error_reporting(E_ALL);
$pwd = str_replace('\\', '/', getcwd());
include_once $pwd . '/config.php';


if (empty($_GET)) {
    include_once PWD . PRIVATE_PATH . 'tracking_view.php';
}