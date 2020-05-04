<?php

define('PWD', str_replace('\\', '/', getcwd()));
define('PUBLIC_PATH','/resources/public/');
define('PRIVATE_PATH','/resources/private/');
include_once 'userprofile.php';


// --- DocumentCreator ---
// Classes
include_once PWD . '/DocumentCreator/Model/Classes/Document.php';
include_once PWD . '/DocumentCreator/Model/Classes/PDF.php';

// functionality
include_once PWD . '/DocumentCreator/Controller/Document.php';


// --- extensions ---
include_once PWD . '/TCPDF/TCPDF-master/tcpdf.php';

// --- TrackerEngine ---
// Classes
include_once PWD . '/TrackerEngine/Model/Classes/Time.php';

// functionality
include_once PWD . '/TrackerEngine/track.php';









