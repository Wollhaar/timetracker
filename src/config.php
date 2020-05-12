<?php
//error_reporting(E_ALL);
//ini_set('display_errors', true);

define('PWD', __DIR__);
define('PUBLIC_PATH','/resources/public/');
define('PRIVATE_PATH','/resources/private/');
include_once 'userprofile.php';

date_default_timezone_set('Europe/Berlin');



// --- TrackerEngine ---
// Classes
include_once PWD . '/TrackerEngine/Model/Classes/Time.php';

// functionality
include_once PWD . '/TrackerEngine/Controller/Time.php';


// --- DocumentCreator ---
// Classes
include_once PWD . '/DocumentCreator/Model/Classes/Document.php';
include_once PWD . '/DocumentCreator/Model/Classes/PDF.php';

// functionality
include_once PWD . '/DocumentCreator/Controller/Document.php';


// --- extensions ---
include_once PWD . '/TCPDF/TCPDF-master/tcpdf.php';




// helper functions

// checking if timestamp for date is valid
function valid_date($timestamp)
{
    $date = date('Y-m-d', intval($timestamp));
    if ($date == '1970-01-01') return false;

    return true;
}

// clear array for valid dates
function giveValidDateArrayBack($arr)
{
    for ($i = 0; $i <= count($arr); $i++) {
        $value = $arr[$i];

        if (empty($value) || !valid_date($value))
            unset($arr[$i]);
    }
    return $arr;
}

// giving sorted date array back
function sortingDate($timestamp, $type = null)
{
    return array(
        date('\Y_Y', $timestamp) => array(
            date('m_M', $timestamp) => array(
                date('d_D', $timestamp) => array(
                    $type => $timestamp
                )
            )
        )
    );

}