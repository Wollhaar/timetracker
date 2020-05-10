<?php


namespace TrackerEngine\Controller\Time;

use DateTime;
use TrackerEngine\Model\Classes\Time;

class TimeController
{
    const workWeekHours = 40;

    public $workTimeBalance = 0;
    public $workDays = array();
    public $currentWeek;
    public $currentDayOfYear;

    public $debit;
    public $trackedTime;

    public function __construct()
    {
        $this->workDays['2020'] = 230;
        $this->currentWeek = date('W');
        $dayInTheWeek = date('w');
        $this->currentDayOfYear = date('z');

        $this->debit = (self::workWeekHours * ($this->currentWeek - 1)) + $dayInTheWeek;
        $workYearPercentage = $this->currentDayOfYear / $this->workDays[date('Y')];
        $this->workTimeBalance -= $this->debit * $workYearPercentage;
    }


    public function permitTrackingTime($time)
    {
        $this->trackedTime = $time;
    }

    public function getWorktimeBalance()
    {
        $this->calculate_workTimeBalance();
        return $this->workTimeBalance;
    }

    public function calculate_workTimeBalance()
    {
        //        TODO: Kallkulation von Plus-/Minusstunden
        $this->build_workTimeArray();
        foreach ($this->trackedTime as $months) {
            foreach ($months as $days) {
                foreach ($days as $key => $worktime) {
                    if ($key == 'worktime')
                        $this->workTimeBalance += $worktime;
                }
            }
        }
    }


    /** calculate timeDifference
     * @param $start
     * @param $end
     * @return float|int
     */
    public function timeToDiffConvertation($start, $end)
    {
        $startObj = new DateTime();
        $endObj = new DateTime();

        $startObj->setTimestamp($start->getTimestamp());
        $endObj->setTimestamp($end->getTimestamp());


        return (($startObj->diff($endObj)->h * 60 * 60) +
                ($startObj->diff($endObj)->i * 60) +
                $startObj->diff($endObj)->h) / 60 / 60;
    }


    public function build_workTimeArray($trackedTime = null)
    {
        if (!empty($trackedTime))
            $this->trackedTimeArray = $trackedTime;

        foreach ($this->trackedTime as $year => $months) {
            foreach ($months as $month => $days) {
                foreach ($days as $day => $times) {

                    $this->trackedTime[$year][$month][$day]['worktime'] = 0;
                    if (!is_array($times['doc_stamp'])) {
                        $this->trackedTime[$year][$month][$day]['worktime'] +=
                            $this->workDay_calculation($times);
                    }
                    else {
                        $this->trackedTime[$year][$month][$day]['worktime'] +=
                            $this->workDay_ArrayCalculation($times);
                    }
                }
            }
        }
    }



    public function workDay_calculation($day)
    {
        foreach ($day as $type => $time) {
            if (is_array($time)) return 'time is array';
            if ($type == 'doc_stamp') continue;

            $types = explode(':', $type);

            if ($types[0] == 'work')
                $workTime[$types[0]][$types[1]] = new Time($time, $type);

            if ($types[0] == 'break')
                $breakTime[$types[0]][$types[1]] = new Time($time, $type);
        }

        if (is_array($workTime) && is_array($breakTime)) {
            $workTime = $this->timeToDiffConvertation(
                $workTime['work']['start'],
                $workTime['work']['end']
            );

            $breakTime = $this->timeToDiffConvertation(
                $breakTime['break']['begin'],
                $breakTime['break']['end']
            );

            return $workTime - $breakTime;
        }
    }


    public function workDay_ArrayCalculation($day)
    {
        $worked = 0;
        if (is_array($day['doc_stamp'])) {
            foreach ($day as $type => $arr) {
                if (empty($arr) || $type == 'doc_stamp') continue;
                if (!is_array($arr)) $arr = array($arr);

                $types = explode(':', $type);

                foreach ($arr as $key => $time) {
                    if (valid_date($time)) {
                        if ($types[0] == 'work')
                        {
                            $workTime[$key][$types[0]][$types[1]] = new Time($time, $type);
                        }

                        if ($types[0] == 'break') {
                            $breakTime[$key][$types[0]][$types[1]] = new Time($time, $type);
                        }
                    }
                }

            }
            foreach ($workTime as $key => $timeArr) {
                if (is_array($workTime) && is_array($breakTime)) {
                    $workTime[$key]['timeDiff'] = 0;
                    $breakTime[$key]['timeDiff'] = 0;


                    if (is_a($workTime[$key]['work']['start'], '\TrackerEngine\Model\Classes\Time') &&
                        is_a($workTime[$key]['work']['end'], '\TrackerEngine\Model\Classes\Time')) {

                        $workTime[$key]['timeDiff'] += $this->timeToDiffConvertation(
                            $workTime[$key]['work']['start'],
                            $workTime[$key]['work']['end']
                        );
                    }

                    if (is_a($breakTime[$key]['break']['begin'], '\TrackerEngine\Model\Classes\Time') &&
                        is_a($breakTime[$key]['break']['end'], '\TrackerEngine\Model\Classes\Time')) {

                        $breakTime[$key]['timeDiff'] += $this->timeToDiffConvertation(
                            $breakTime[$key]['break']['begin'],
                            $breakTime[$key]['break']['end']
                        );
                    }

                    if (key_exists('timeDiff', $workTime[$key]) && key_exists('timeDiff', $breakTime[$key])) {
                        $worked += $workTime[$key]['timeDiff'] - $breakTime[$key]['timeDiff'];
                    }
                }
            }
        }

        return $worked;
    }
}