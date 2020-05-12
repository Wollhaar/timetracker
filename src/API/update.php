<?php
require_once __DIR__ . '/../config.php';

$doc_control = new \DocumentCreator\Controller\Document\DocumentController();
$time_control = new \TrackerEngine\Controller\Time\TimeController();

$action = $_POST['action'];

switch ($action) {
    case 'months':
        $months = $doc_control->getTrackedMonths();
        if (is_string($months)) die($months);

        foreach ($months as $value => $month) {
            echo "<option value=\"$value\">$month</option>";
        }
        break;

    case 'display_timeBalance':
        $trackedTime = $doc_control->getTrackedTime();
        $time_control->permitTrackingTime($trackedTime);
        $plus_minus = $time_control->getWorkTimeBalance();

        echo $plus_minus;
        break;

    default:
        echo 'Error - 102: Something went wrong. Please contact Support.';
}