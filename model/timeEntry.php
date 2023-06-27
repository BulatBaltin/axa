<?php

class TimeEntry extends dmModel {

    static function GetTableName() {
        return 'time_entry';
    }

    static function getPeriodReportCustomer($startDate, $endDate, $company, $customer, $lingo = 'en')
    {
        $params = [
            'company' => $company['id'],
            'customer' => $customer['id']
        ];

        if($startDate) {
            $where_start = 't.period >= :fstday AND ';
            $params['fstday'] = $startDate->format('Y-m-d');
        } else {
            $where_start = '';
        }
        if($endDate) {
            $where_end = 't.period <= :lstday AND ';
            $params['lstday'] = $endDate->format('Y-m-d');
        } else {
            $where_end = '';
        }

        // to show only rounded data
        $sql = "SELECT
                t.task as task,
                t.tasknl as tasknl,
                t.period as period,
                SUM(t.quantity) as total
                FROM invoice_goods AS t
                WHERE t.company_id = :company AND 
                    t.customer_id = :customer AND 
                    $where_start 
                    $where_end
                    (t.level <> '+' or t.level IS NULL)
                GROUP BY task with ROLLUP
                ";

        // $conn = $this->getEntityManager()->getConnection();
        // $DBSQL = $conn->prepare($sql);
        // $DBSQL->execute($params);
        // $data = $DBSQL->fetchAll();

        $data = Database::ExecuteQuery($sql, 'array', $params);

        usort($data, function ($a, $b) {
            if ($a['task'] == null) return -1;

            if ($a['total'] > $b['total']) return -1;
            if ($a['total'] < $b['total']) return 1;

            if ($a['task'] > $b['task']) return 1;
            return 0;
        });

        // $data = $this->turnIntoHours($data, ['total']);
        return $data;
    }


    static function getEmployeeTimeData($startDate, $company, $span = null) {

        $date0 = self::startOfThisDay($startDate);
        $dateTD_0 = $date0;
        $dateTD_1 = self::endOfThisDay($date0);
        $dateTW_0 = self::firstDayOfWeek($date0);
        $dateTW_1 = self::lastDayOfWeek($date0);

        $dateTM_0 = self::firstDayOfMonth($date0);
        $dateTM_1 = self::lastDayOfMonth($date0);

        $date0 = self::startOfThisDay($startDate);
        // dump($date0);
        $date0->modify('-1 month');
        // dump($date0);

        $dateLM_0 = self::firstDayOfMonth($date0);
        $dateLM_1 = self::lastDayOfMonth($date0);

        $date0->modify('-1 month');
        $dateLM2_0 = self::firstDayOfMonth($date0);
        $dateLM2_1 = self::lastDayOfMonth($date0);

        $periods = [
            'this_day' => $dateTD_1->format('d/m/Y'),
            'this_week' => $dateTW_0->format('d M') . "-" . $dateTW_1->format('d M-y'),
            'this_month' => $dateTM_0->format('d') . "-" . $dateTM_1->format('d M-y'),
            'last_month' => $dateLM_0->format('d') . "-" . $dateLM_1->format('d M-y'),
            'last2_month' => $dateLM2_0->format('d') . "-" . $dateLM2_1->format('d M-y'),
            // 'last2_month' => $dateLM2_0->format('d/m') . "-" . $dateLM2_1->format('d/m/y'),
        ];

        // dd($periods);
        // These modes dropped, not used
        $where = "";
        if ($span == 'total-all') {
            $where = "AND t.period <= :dateTM_1";
        } elseif ($span == 'total-day') {
            $where = "AND t.period >= :dateTD_0 AND t.period <= :dateTD_1";
        } elseif ($span == 'total-week') {
            $where = "AND t.period >= :dateTW_0 AND t.period <= :dateTW_1";
        } elseif ($span == 'total-month') {
            $where = "AND t.period >= :dateTM_0 AND t.period <= :dateTM_1";
        } elseif ($span == 'total-month-last') {
            $where = "AND t.period >= :dateLM_0 AND t.period <= :dateLM_1";
        } elseif ($span == 'total-month-last2') {
            $where = "AND t.period >= :dateLM2_0 AND t.period <= :dateLM2_1";
        } elseif ($span == 'total-year') {
            $where = "AND t.period >= :dateTY_0 AND t.period <= :dateTY_1";
        }

        $sql = "SELECT
                t.user_id as employee,
                user.hash as hash,
                user.name as person,
                t.period as dperiod,
                SUM(IF(t.period >= :dateTD_0 AND t.period <= :dateTD_1, t.duration, 0)) as sum_TD,
                SUM(IF(t.period >= :dateTW_0 AND t.period <= :dateTW_1, t.duration, 0)) as sum_TW,
                SUM(IF(t.period >= :dateTM_0 AND t.period <= :dateTM_1, t.duration, 0)) as sum_TM,
                SUM(IF(t.period >= :dateLM_0 AND t.period <= :dateLM_1, t.duration, 0)) as sum_LM,
                SUM(IF(t.period >= :dateLM2_0 AND t.period <= :dateLM2_1, t.duration, 0)) as sum_LM2,
                SUM(IF(t.period <= :dateLM_0, t.duration, 0)) as sum_Rest,
                SUM(t.duration) as total
                FROM time_entry AS t
                    LEFT JOIN user ON t.user_id = user.id
                WHERE t.company_id = :company {$where}
                GROUP BY employee with ROLLUP
                ";

        $frmt = 'Y-m-d';
        $params = [
            'company' => $company['id'],
            'dateTD_0' => $dateTD_0->format($frmt),
            'dateTD_1' => $dateTD_1->format($frmt),
            'dateTW_0' => $dateTW_0->format($frmt),
            'dateTW_1' => $dateTW_1->format($frmt),
            'dateTM_0' => $dateTM_0->format($frmt),
            'dateTM_1' => $dateTM_1->format($frmt),
            'dateLM_0' => $dateLM_0->format($frmt),
            'dateLM_1' => $dateLM_1->format($frmt),
            'dateLM2_0' => $dateLM2_0->format($frmt),
            'dateLM2_1' => $dateLM2_1->format($frmt)
        ];

        $data = Database::ExecuteQuery($sql, 'array', $params); //$DBSQL->fetchAll();

        usort($data, function ($a, $b) {
            if ($a['employee'] == null) return -1;

            if ($a['total'] > $b['total']) return -1;
            if ($a['total'] < $b['total']) return 1;

            if ($a['task'] > $b['task']) return 1;
            return 0;
        });

        $data = self::turnIntoHours($data);

        return [$data, $periods];
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

    static function startOfThisDay($date = null)
    {
        $now = $date ? $date : new DateTime();
        $date = $now->format('Y-m-d 00:00:00');
        return new DateTime($date);
    }
    static function endOfThisDay($date = null)
    {
        $now = $date ? $date : new DateTime();
        $date = $now->format('Y-m-d 23:59:59');
        return new DateTime($date);
    }
    static function firstDayOfWeek(DateTime $day)
    {
        $date = new DateTime;
        $date->setISODate((int) $day->format('Y'), (int) $day->format('W'), 1);
        $s_date = $date->format('Y-m-d 00:00:00');
        return new DateTime($s_date);
    }
    static function lastDayOfWeek(DateTime $day)
    {
        $date = new DateTime;
        $date->setISODate((int) $day->format('Y'), (int) $day->format('W'), 7);
        $s_date = $date->format('Y-m-d 23:59:59');
        return new DateTime($s_date);
    }

    static function firstDayOfMonth(DateTime $day)
    {
        $date = $day->format('Y-m-01 00:00:00');
        return new DateTime($date);
    }
    static function lastDayOfMonth(DateTime $day)
    {
        $date = $day->format('Y-m-t 23:59:59');
        return new DateTime($date);
    }
    static function firstDayOfYear(DateTime $day)
    {
        $date = $day->format('Y-01-01 00:00:00');
        return new DateTime($date);
    }
    static function lastDayOfYear(DateTime $day)
    {
        $date = $day->format('Y-12-31 23:59:59');
        return new DateTime($date);
    }

}