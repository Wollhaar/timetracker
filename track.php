<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 14.03.2019
 * Time: 16:40
 */

if(empty($_GET)){
    $start_time = time();
    $work_time = array('time' => $start_time, 'work:start');
}
else {
    if(isset($_GET['q'])){
        $doBreak = $_GET['q'];

        $work_time = array( 'time' => time(), 'break:' . $doBreak);
        echo '<span class="time-text">' . date('d M Y H:i P e', $work_time['time']) . '</span>';
    }

    if(isset($_GET['f'])) {
        $finish = $_GET['f'];
        $work_time = array( 'time' => time(), 'work:' . $finish );
//        closing page
    }
}

$path = 'tracked/' . date('Y', $work_time['time']) . DIRECTORY_SEPARATOR . date('m_M', $work_time['time']);

$pathPpd = is_dir($path);
if(!$pathPpd)$pathPpd = mkdir($path, 0777, TRUE);

if($pathPpd){
    $file = fopen($path . '/track_' . date('Y-m-d', $work_time['time']) . '.txt', 'a');
    fputcsv($file, $work_time, ',', '"', '\\');
    fclose($file);
}
else {

    try {
        throw new Exception('There is something went wrong. Please try again or contact Support.');
    }
    catch(Exception $e) {
        echo 'ERROR: ' , $e->getMessage(), '\n';
    }
}

