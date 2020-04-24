<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 14.03.2019
 * Time: 16:40
 */


if(empty($_GET)) {
    $start_time = time();
    $work_time = new Time($start_time, 'work:start');
}
else {
    if(isset($_GET['q'])){
        $doBreak = $_GET['q'];

        $work_time = array( 'time' => time(), 'break:' . $doBreak);
        echo '<span class="time-text">' . date('d M Y H:i P e', $work_time['time']) . '</span>';
    }

    if(isset($_GET['f'])) {
        $finish = $_GET['f'];
        $work_time = new Time(time(),'work:' . $finish);
//        closing page
    }
}


$work_time->saveTime();