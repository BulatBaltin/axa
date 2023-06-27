<?php

class TimeEntryRepository {
    static function GetTableName() {
        return 'time_entry';
    }

    static function getDeveloperDaily($startDate, $company, $developer, $span = null)
    {
        $params = [
            'company' => $company['id'],
            'developer' => $developer['id'],
            'oneday' => $startDate->format('Y-m-d'),
        ];

        $sql = "SELECT
t.tid as tid,
t.description as task,
t.start as dstart,
k.startdate as startdate,
k.duedate as duedate,
SUM(t.duration) as total
FROM time_entry AS t
LEFT JOIN tasks AS k ON k.tid = t.tid
WHERE t.company_id = :company AND t.user_id = :developer AND t.period = :oneday
GROUP BY tid with ROLLUP
                ";
        $data = DataBase::ExecuteQuery($sql, 'array', $params);

        usort($data, function ($a, $b) {
            if ($a['task'] == null) return -1;

            if ($a['total'] > $b['total']) return -1;
            if ($a['total'] < $b['total']) return 1;

            if ($a['task'] > $b['task']) return 1;
            return 0;
        });

        $data = self::turnIntoHours($data, ['total']);

        self::formatDueDate($data);
// 
        $dueDate = clone $startDate;
        $dueDate = ($dueDate->modify('+1 day'))->format('Ymd');

        $today = date('Ymd');
        if($dueDate > $today) $dueDate = $today;
        
        $params['oneday'] = $dueDate;
        $sql = "SELECT
t.tid as tid,
t.description as task,
t.start as dstart,
k.startdate as startdate,
k.duedate as duedate
FROM time_entry AS t
LEFT JOIN tasks AS k ON k.tid = t.tid
WHERE t.company_id = :company AND t.user_id = :developer AND k.duedate = :oneday
GROUP BY task
                ";

        $duedata = DataBase::ExecuteQuery($sql,'array', $params);
        self::formatDueDate($duedata);

        return [$data, $duedata];
    }
    static function formatDueDate(&$data) {
        $len = count($data);
        for ($i = 0; $i < $len; $i++) {
            if($data[$i]['startdate']) {
                $data[$i]['startdate'] = (DateTime::createFromFormat('Ymd',$data[$i]['startdate']))->format('d/m/Y');
            }
            if($data[$i]['duedate']) {
                $data[$i]['duedate'] = (DateTime::createFromFormat('Ymd',$data[$i]['duedate']))->format('d/m/Y');
            }
        }
    }

    static function getDeveloperWeekly(DateTime $startDate, array $company, array $developer, $span = null)
    {
        $fstDay = ToolKit::firstDayOfWeek($startDate)->format('Y-m-d');
        $lstDay = ToolKit::lastDayOfWeek($startDate)->format('Y-m-d');

        $params = [
            'company' => $company['id'],
            'developer' => $developer['id'],
            'fstDay' => $fstDay,
            'lstDay' => $lstDay
        ];

        $sql = "SELECT
            t.period as period,
            SUM(t.duration) as total
            FROM time_entry AS t
            WHERE t.company_id = :company AND t.user_id = :developer AND t.period >= :fstDay AND t.period <= :lstDay
            GROUP BY period with ROLLUP
            ";

        $data = DataBase::ExecuteQuery($sql, 'array', $params);

        usort($data, function ($a, $b) {
            if ($a['period'] == null) return -1;
            if ($a['period'] > $b['period']) return 1;
            return 0;
        });

        $data = self::turnIntoHours($data, ['total']);

        $sql = "SELECT
            t.tid as tid,
            t.description as task,
            SUM(t.duration) as total
            FROM time_entry AS t
            WHERE t.company_id = :company AND t.user_id = :developer AND t.period >= :fstDay AND t.period <= :lstDay
            GROUP BY tid with ROLLUP
            ";

        $data2 = DataBase::ExecuteQuery($sql, 'array', $params);

        usort($data2, function ($a, $b) {
            if ($a['task'] == null) return -1;
            if ($a['total'] > $b['total']) return -1;
            if ($a['total'] < $b['total']) return 1;
            if ($a['task'] > $b['task']) return 1;
        });

        $data2 = self::turnIntoHours($data2, ['total']);
// dd($data,$data2);
        return [ $data, $data2 ];
    }

    static function getDeveloperMonthly($startDate, $company, $developer, $span = null)
    {
        $fstDay = ToolKit::firstDayOfMonth($startDate)->format('Y-m-d');
        $lstDay = ToolKit::lastDayOfMonth($startDate)->format('Y-m-d');

        $params = [
            'company' => $company['id'],
            'developer' => $developer['id'],
            'fstDay' => $fstDay,
            'lstDay' => $lstDay
        ];

        $sql = "SELECT
                t.tid as tid,
                t.description as task,
                SUM(t.duration) as total
                FROM time_entry AS t
                WHERE t.company_id = :company AND t.user_id = :developer AND t.period >= :fstDay AND t.period <= :lstDay
                GROUP BY tid with ROLLUP
                ";

        $data = DataBase::ExecuteQuery($sql, 'array', $params);

        usort($data, function ($a, $b) {
            if ($a['task'] == null) return -1;
            if ($a['total'] > $b['total']) return -1;
            if ($a['total'] < $b['total']) return 1;
            if ($a['task'] > $b['task']) return 1;
        });

        $data = self::turnIntoHours($data, ['total']);
        return $data;
    }

    static function turnIntoHours($data, $fields = null)
    {
        if(empty($fields)) $fields = ['total', 'sum_TD', 'sum_TW', 'sum_TM', 'sum_LM', 'sum_LM2', 'sum_Rest'];

        for ($i = 0; $i < count($data); $i++) {
            foreach ($fields as $fld) {
                $value = $data[$i][$fld] / 3600;
                $data[$i][$fld] = number_format(round($value, 2), 2);
            }
        }
        return $data;
    }

    static function fetchDailyReport( DateTime $reportday, array $company, array $developer) {

        $rgoal = $developer['dailygoal'];  
        $goal = self::getGoalForDay($developer, $reportday);
        [$dailyReport, $dueReport] = self::getDeveloperDaily($reportday, $company, $developer);
        // dump($dailyReport);
        self::prepareDailyReport($dailyReport, $goal, $rgoal);
        // dd($dailyReport);
        return [$dailyReport, $dueReport];
    }

    static function fetchMonthlyReport( DateTime $reportday, array $company, array $developer) {

        $goal = $developer['dailygoal']; 
        $globgoal = self::getWorkDaysForMonth($reportday) * $goal;
        $globgoal_now = self::getWorkDaysForThisPeriod($reportday) * $goal;
        $monthly = $reportday->format('F Y');
        $monthlyReport = TimeEntryRepository::getDeveloperMonthly($reportday, $company, $developer);

        if(!empty($monthlyReport) and count($monthlyReport)) {
            $monthlyReport[0]['goal'] = $globgoal;
            $monthlyReport[0]['goal_now'] = $globgoal_now;
            if ($globgoal_now) {
                $result = round($monthlyReport[0]['total'] / $globgoal_now * 100, 2);
            } else {
                $result = 0;
            }
            $monthlyReport[0]['result'] = $result;
            $monthlyReport[0]['smile'] = self::getSmile($result);
            $monthlyReport[0]['month'] = $monthly;
            $monthlyReport[0]['cheers'] = self::getCheers($monthlyReport[0]['smile'], $goal);

        }
        return $monthlyReport;
    }

    static function fetchWeeklyReport( DateTime $reportday, array $company, array $developer) {

        list($weeklyReport, $taskReport) = self::getDeveloperWeekly($reportday, $company, $developer);
        $t_goal = 0;
        $g_total = 0;
        $goal = $developer['dailygoal'];
        $goal = $goal ? $goal : 4;  
        $monthly = $reportday->format('F Y');

        $globgoal = 5 * $goal;
        $globgoal_now = 5 * $goal;

        $weekDay = new DateTime($reportday->format('c')); // new DateTime('monday this week');
        $monday = new DateTime($reportday->format('c'));
        $monday->modify('monday this week');
        $nextday = $monday;
        $nextperiod = $monday->format('Y-m-d');
        $dayOfWeek = 1;
        $nowDayOfWeek = self::getDayOfWeek($weekDay);

        if(!empty($weeklyReport) and count($weeklyReport)) {

            $wReport[0] = $weeklyReport[0];

            foreach($weeklyReport as $work_day) {
                $period = $work_day['period'];
                if(empty($period)) continue; // total entry

                if($period > $nextperiod) {
                    while($period > $nextperiod) {

                        $day_goal = self::getGoalForWeekDay( $goal, $nextday);
                        $t_goal     += $day_goal;
                        $smile = $dayOfWeek > 5 ? '' :'smile_bad';
                        $wReport[$dayOfWeek] = [
                            // 'date' => $nextday->format('d/m/Y'),
                            'date' => $nextday->format('Y-m-d'),
                            'day' => $nextday->format('l d/m/y'),
                            'period' => $nextday->format('Y-m-d'),
                            'total' => 0,
                            'goal' => $day_goal,
                            'smile' => $smile,
                            'result' => '0.00'
                        ];
                        // - - - - - - - Footer 
                        $nextday->modify('+1 day');
                        $nextperiod = $nextday->format('Y-m-d');                
                        $dayOfWeek = self::getDayOfWeek($nextday);
                    }
                }

                $day_goal   = self::getGoalForWeekDay( $goal, $nextday);
                $g_total    += $work_day['total'];
                $t_goal     += $day_goal;
                $work_day['goal'] = $day_goal;
                $result = self::calcResult($day_goal, $work_day['total']);
                $work_day['result']   = number_format($result, 2);
                $work_day['smile']    = self::getSmile($result);
                $work_day['day']    = $nextday->format('l d/m/y');
                // $work_day['date']    = $nextday->format('d/m/Y');
                $work_day['date']    = $nextday->format('Y-m-d');

                $wReport[$dayOfWeek] = $work_day;
                // - - - - - - - Footer 
                $nextday->modify('+1 day');
                $nextperiod = $nextday->format('Y-m-d');                
                $dayOfWeek++; // = self::getDayOfWeek($nextday);

            }

            if($dayOfWeek < 8) {

                for($day = $dayOfWeek; $day < 8; $day++) {

                    $day_goal   = self::getGoalForWeekDay( $goal, $nextday);
                    if($dayOfWeek > $nowDayOfWeek) {
                        $wReport[$day] = [
                            // 'date' => $nextday->format('d/m/Y'),
                            'date' => $nextday->format('Y-m-d'),
                            'day' => $nextday->format('l d/m/y'),
                            'period' => $nextday->format('Y-m-d'),
                            'total' => 0,
                            'goal' => $day_goal,
                            'smile' => '',
                            'result' => ''
                        ];
                    } else {
                        $smile = $dayOfWeek > 5 ? '' :'smile_bad';
                        $t_goal += $day_goal;
                        $wReport[$day] = [
                            // 'date' => $nextday->format('d/m/Y'),
                            'date' => $nextday->format('Y-m-d'),
                            'day' => $nextday->format('l d/m/y'),
                            'period' => $nextday->format('Y-m-d'),
                            'total' => 0,
                            'goal' => $day_goal,
                            'smile' => $smile,
                            'result' => '0.00'
                        ];
                    }
                    // - - - - - - - Footer 
                    $nextday->modify('+1 day');
                    $nextperiod = $nextday->format('Y-m-d');                
                    $dayOfWeek = self::getDayOfWeek($nextday);
                }
            }

            $wReport[0]['date'] = '';
            $wReport[0]['goal'] = $t_goal;
            $result = self::calcResult($t_goal, $wReport[0]['total']);
            $wReport[0]['result'] = number_format($result, 2);
            $wReport[0]['smile'] = self::getSmile($result);

            $weeklyReport = $wReport;

            if(!empty($taskReport) and count($taskReport)) {
                $taskReport[0]['goal'] = $globgoal;
                $taskReport[0]['goal_now'] = $globgoal_now;
                if ($globgoal_now) {
                    $result = round($taskReport[0]['total'] / $globgoal_now * 100, 2);
                } else {
                    $result = 0;
                }
                $taskReport[0]['result'] = $result;
                $taskReport[0]['smile'] = self::getSmile($result);
                $taskReport[0]['month'] = $monthly;
                $taskReport[0]['cheers'] = self::getCheers($taskReport[0]['smile'], $goal);
            }
        }
        
        return [$weeklyReport, $taskReport];
    }

    static function calcResult( $goal, $total ) {

        if($goal > 0) {
            $result = round($total / $goal * 100, 2);  
        } elseif($total) {
            $result = 100;  
        } else {
            $result = 0;  
        }
        return $result;
    }

    static function getDayOfWeek(DateTime $date) {
        $DayOfWeek = $date->format('w');
        $DayOfWeek = $DayOfWeek > 0 ? $DayOfWeek : 7;
        return $DayOfWeek;
    }
    static function getGoalForDay( $developer, DateTime $date) {

        $goal = $developer['dailygoal']; 
        $goal = self::getGoalForWeekDay( $goal, $date);  

        return $goal;
    }
    static function getGoalForWeekDay( $goal, DateTime $date) {

        $goal = $goal ? $goal : 4;  
        $dayOfWeek = $date->format('w');
        $dayOfWeek = $dayOfWeek > 0 ? $dayOfWeek : 7;
        $goal = $dayOfWeek > 5 ? 0 : $goal;  

        return $goal;
    }

    static function prepareDailyReport( &$dailyReport, $goal, $day_goal) {
        if(!empty($dailyReport) and count($dailyReport)) {
            $dailyReport[0]['goal']     = $goal;  
            if($goal > 0) {
                $result = round($dailyReport[0]['total'] / $goal * 100, 2);  
            } else {
                $result = 100;  
            }
            $dailyReport[0]['result']   = $result;
            $smile = self::getSmile($result);
            $dailyReport[0]['smile'] = $smile;
            $dailyReport[0]['cheers'] = self::getCheers($smile, $day_goal);
        } else {
            $smile = self::getSmile(0);
            $dailyReport[0]['smile'] = $goal > 0 ? $smile : '';
            $dailyReport[0]['goal'] = $goal;
            $dailyReport[0]['result'] = '';
            $dailyReport[0]['total'] = 0;
            $dailyReport[0]['cheers'] = self::getCheers($smile, $day_goal);
        }
    }

    static function getWorkDaysForMonth(DateTime $startDate) {
        $date = $startDate->format('Y-m-01 00:00:00');
        $thisDay = new DateTime($date);
        $thistMon = $thisDay->format('m');
        $month = $thistMon;
        $workDays = 0;
        while($month == $thistMon) {
            $dayOfWeek = $thisDay->format('w');
            if($dayOfWeek > 0 and $dayOfWeek < 6) {
                $workDays++;
            }            
            $thisDay->modify('+1 day');
            $month = $thisDay->format('m');
        }
        return $workDays;
    }
    static function getWorkDaysForThisPeriod($endDate) {
        $date = $endDate->format('Y-m-01 00:00:00');
        $thisDay = new DateTime($date);
        
        $mon_now = (new DateTime())->format('m');
        $mon_report = $endDate->format('m');
        $date2 = clone($endDate);
        if($mon_now <> $mon_report) {
            $date2->modify('last day of this month');
        } else {
            $date2 = new DateTime(); // today is taken irespective of $endDate
        }
        $date2 = $date2->format('Y-m-d 00:00:00');
        $date2 = new DateTime($date2);
        Messager::log($date2->format('c'), true);
        $workDays = 0;
        while($thisDay <= $date2) {
            $dayOfWeek = $thisDay->format('w');
            if($dayOfWeek > 0 and $dayOfWeek < 6) {
                $workDays++;
            }            
            $thisDay->modify('+1 day');
        }
        return $workDays;
    }
    private static function getSmile($result) {
        if($result >= 100) {
            $smile = 'smile_good';
        } elseif($result < 85) {
            $smile = 'smile_bad';
        } else {
            $smile = 'smile_wait';
        }
        return $smile;
    }
    private static function getCheers($smile, $goal) {
        $cheers = [
            'smile_good' =>
            [
                'Well done! Good work!',
                'Keep going like this!',
            ],

            'smile_bad' =>
            [
                'Please, increase your hours!',
                "Please, don't forget, your daily hour plan is: " . $goal ."h/day"
            ],
            'smile_wait' =>
            [
                'Hey, you were almost there!',
                "Please, try to reach your daily plan next time"
            ]
            ];

        return $cheers[$smile];
    }    
}