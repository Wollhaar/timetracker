<?php


namespace DocumentCreator\Controller\Document;


use DocumentCreator\Model\Classes\Document;
use DocumentCreator\Model\Classes\PDF;

class DocumentController
{
    public function listingDoc($doc_stamp)
    {
        $path = PWD . DIRECTORY_SEPARATOR . 'tracked' . DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        file_put_contents($path . 'tracking.txt', $doc_stamp . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $doc_stamp
     * @param string $path
     * @return false|mixed|string|string[]|null
     */
    public function getDoc($doc_stamp = 'actual', $path = '/tracked/')
    {
        if ($doc_stamp == 'actual') {
            $filename = 'tracking.txt';

            $files = file_get_contents(PWD . $path . $filename);
            if (!is_array($files)) $files = explode(PHP_EOL, $files);

            for ($i = 0; $i < count($files); $i++) {
                $value = array_pop($files);

                if (empty($value))
                    continue;

                if (valid_date($value)) {
                    $doc_stamp = $value;
                    break;
                }
            }
        }
        elseif (valid_date($doc_stamp)) {
            $doc = new Document($doc_stamp, null, 'txt', 'user');
            $data = $doc->getData();

            $data =  giveValidDateArrayBack(explode(PHP_EOL, $data));
            return $data;
        }
        else $doc_stamp = null;

        return $doc_stamp;
    }

    /** getting all filenames out of the tracking
     * @return array|string
     */
    public function getAllDocs()
    {
        $files = file_get_contents(PWD . '/tracked/tracking.txt');

        if (isset($files)) {
            if (!is_array($files)) $files = explode(PHP_EOL, $files);
            return giveValidDateArrayBack($files);
        }
        return 'No files';
    }

    /** building and return an Array of all Tracked months
     * @return string
     */
    public function getTrackedMonths()
    {
        $files = $this->getAllDocs();
        if (is_string($files)) return $files;

        foreach ($files as $timestamp) {
            $months[date('Y_m_M', $timestamp)] = date('M', $timestamp);
        }

        return $months;
    }

    /** get all the tracked time that´ve been ordered in the datearea variable
     * @return mixed|string
     */
    public function getTrackedTime()
    {
        $trackedTime = $this->getAllDocs();
        if (is_string($trackedTime)) return $trackedTime;

        if (is_array($trackedTime)) {
            $sortedTime = array();

            // Building an Array of all Tracked time sorted in years, months and days
            foreach ($trackedTime as $daytime) {
                $sortedTime = array_merge_recursive($sortedTime,
                    sortingDate($daytime, 'doc_stamp')
                );

                // getting the tracked time from the docs
                foreach ($this->getDoc($daytime) as $data) {
                    if(empty($data)) continue;

                    $timeData = explode(',', $data);
                    $timestamp = $timeData[0];
                    $timeType = $timeData[1];

                    // Adding the TrackedTime to the sorted Array
                    $sortedTime = array_merge_recursive($sortedTime,
                        sortingDate($timestamp, $timeType)
                    );
                }
            }
            return $sortedTime;
        }

        return null;
    }


    /**
     * @param $datearea
     * return Array
     */
    public function filterTracks($datearea)
    {
        $trackedTime = $this->getTrackedTime();

        // Selecting the Tracked months out of the sorted TrackedTimeArray
        if (is_string($datearea)) {
            $datearea = explode(',', $datearea);
        }
        foreach ($datearea as $year => $months) { // TODO: COMMENTS!!!!

            // getting the right year
            if (is_array($trackedTime[$year])) {
                foreach ($months as $month => $empty) {

                    // getting the right month
                    $orderIndexMonth = ltrim(strstr($month, '_'), '_');
                    echo 'Month: ' . $orderIndexMonth;
                    if (is_array($trackedTime[$year][$orderIndexMonth])) {

                        // save the ordered month with the days
                        // in the right year and in the right month
                        $orderedTrackedTime[$year][$orderIndexMonth] =
                            $trackedTime[$year][$orderIndexMonth];
                    }
                }
            }
        }

        return $orderedTrackedTime;
    }


    public function buildPDF()
    {
        $pdf = new PDF('LOREM IPSUM DOLORES', 'pdf', '2020-02-01:2020-03-30', 'boss');
        $pdf->testPDF();
    }
}