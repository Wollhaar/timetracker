<?php
require_once __DIR__ . '/../config.php';

use TrackerEngine\Controller\Time\TimeController as TimeController;
use DocumentCreator\Controller\Document\DocumentController as DocController;

$doc_control = new DocController();


$action = $_POST['action'];

switch ($action) {
    case 'collectTracks':
        $post_months = $_POST['months'];
        $months = array();

        foreach ($post_months as $data) {
            $data = explode('_', $data);
            $months = array_merge_recursive($months, array('Y_' . $data[0] => array('M_' . $data[1] . '_' . $data[2] => '')));
        }
        $trackedTime = $doc_control->getTrackedTime();
        $orderedTime = $doc_control->filterTracks($months);

        $time_control = new TimeController();
        $time_control->build_worktimeArray($orderedTime);
        break;

    default:
        echo 'Error - 103: Something went wrong. Please contact support.';
}
