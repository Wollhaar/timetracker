<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 14.03.2019
 * Time: 16:40
 */
require_once __DIR__ . '/../config.php';
use TrackerEngine\Model\Classes\Time as Time;
use DocumentCreator\Controller\Document\DocumentController as DocController;

$doc_control = new DocController();




switch ($_POST['action']) {
    case 'start':
        $work_time = new Time(time(), 'work:start');
        $doc_stamp = $work_time->saveTime();
        $doc_control->listingDoc($doc_stamp);

        echo '<option value="work:start">Arbeitsbeginn: ' . $work_time->getTime() . '</option>';
        break;

    case 'finish':
        $work_time = new Time(time(), 'work:end');
        $work_time->saveTime($doc_control->getDoc());

        echo '<option value="work:end">Arbeitsende: ' . $work_time->getTime() . '</option>';
        break;

    case 'break':
        if ($_POST['type'] == 'break:begin') {
            $break_time = new Time(time(), 'break:begin');
            $break_time->saveTime($doc_control->getDoc());

            echo '<option value="break:begin">Pause: ' . $break_time->getTime() . '</option>';
        }
        elseif ($_POST['type'] == 'break:end') {
            $break_time = new Time(time(), 'break:end');
            $break_time->saveTime($doc_control->getDoc());

            echo '<option value="break:end">Pausenende: ' . $break_time->getTime() . '</option>';
        }
        break;

    default:
        echo 'Error - 101: Something went wrong. Please contact support.';
}
