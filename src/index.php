<?php

$pwd = str_replace('\\', '/', getcwd());
$pwd_view = '/timetracker/';
$public = 'resources/public/';
$private = 'resources/private/';




include_once $pwd . '/bin/track.php';

if (empty($_GET)) {
    include_once $pwd . '/resources/private/tracking_view.php';
}