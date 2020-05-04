<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 14.03.2019
 * Time: 16:40
 */
use TrackerEngine\Model\Classes\Time as Time;
use DocumentCreator\Controller\Document\DocumentController as DocController;

$doc_control = new DocController();

if(empty($_GET)) {
    $start_time = time();
    $work_time = new Time($start_time, 'work:start');
}
else {
    $doc_stamp = $doc_control->getDoc();

    if(isset($_GET['q'])) {
        $doBreak = $_GET['q'];

        $work_time = new Time( time(), 'break:' . $doBreak );
        echo '<span class="time-text">' . $work_time->getTime() . '</span>';
    }

    if(isset($_GET['f'])) {
        $finish = $_GET['f'];
        $work_time = new Time(time(),'work:' . $finish);
        echo 'BYE';
//        closing page
    }
}


$doc_stamp = $work_time->saveTime($doc_stamp);
$doc_control->listingDoc($doc_stamp);