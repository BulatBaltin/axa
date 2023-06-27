<?

class ToolKit
{
    static function getTimeStart( $code, $company)
    {
        // $logRepo = $em->getRepository(Transactions::class);
        $results = Transactions::findOneBy(
            ['code' => $code, 'company_id' => $company['id']],
            ['eventtime' => 'DESC']
        );
        if ($results) {
            $timeS = (new DateTime($results['eventtime']))->getTimestamp();
            $timeS++;
        } else {
            $timeS = (new DateTime($company['startdate']));
            if (!$timeS) {
                $timeS = strtotime('2022-07-01');
            } else {
                $timeS = $timeS->getTimestamp();
            }
        }
        return $timeS;
    }

    static function fillByName(&$target, $source, array $listNames)
    {
        foreach ($listNames as $root) {
            $setMethod = 'set' . ucfirst($root);
            if(isset($source[$root])) {
                $target->$setMethod($source[$root]);
            } else {
                $target->$setMethod(null);
            }
        }
    }

    static function startOfThisDay($date = null)
    {
        $now = $date ? $date : new DateTime();
        $date = $now->format('Y-m-d 0:0:0');
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
        $s_date = $date->format('Y-m-d 0:0:0');
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
        $date = $day->format('Y-m-01 0:0:0');
        return new DateTime($date);
    }
    static function lastDayOfMonth(DateTime $day)
    {
        $date = $day->format('Y-m-t 23:59:59');
        return new DateTime($date);
    }
    static function firstDayOfYear(DateTime $day)
    {
        $date = $day->format('Y-01-01 0:0:0');
        return new DateTime($date);
    }
    static function lastDayOfYear(DateTime $day)
    {
        $date = $day->format('Y-12-31 23:59:59');
        return new DateTime($date);
    }
    static function getPeriodParams( $period_name ) {
        switch($period_name) {
            case 'yesterday':
                $startDay = new DateTime('yesterday');
                $endDay = new DateTime('yesterday');
                $say_period = $startDay->format('d/m/Y');
            break;
            case 'this-week':
                $startDay = new DateTime('monday this week');
                $endDay = new DateTime('sunday this week');
                $say_period = $startDay->format('d/m/Y') . ' - ' . $endDay->format('d/m/Y');
                break;
            case 'last-week':
                $startDay = new DateTime('monday this week');
                $startDay->modify('-7 days');
                $endDay = new DateTime('sunday this week');
                $endDay->modify('-7 days');
                $say_period = $startDay->format('d/m/Y') . ' - ' . $endDay->format('d/m/Y');
            break;
            case 'this-month':
                $startDay = new DateTime('first day of this month');
                $endDay = new DateTime();
                $say_period = $startDay->format('d/m/Y') . ' - ' . $endDay->format('d/m/Y');
            break;
            case 'last-month':
                $startDay = new DateTime('first day of previous month');
                $endDay = new DateTime('last day of previous month');
                $say_period = $startDay->format('d/m/Y') . ' - ' . $endDay->format('d/m/Y');
            break;
            case '3-months':
                $startDay = new DateTime('first day of -2 month');
                $endDay = new DateTime();
                $say_period = $startDay->format('d/m/Y') . ' - ' . $endDay->format('d/m/Y');
            break;
            case 'this-year':
                $startDay = new DateTime('first day of january this year');
                $endDay = new DateTime();
                $say_period = $startDay->format('d/m/Y') . ' - ' . $endDay->format('d/m/Y');
            break;
            case 'all-data':
                $startDay = null;
                $endDay = null;
                $say_period = 'All period';
            break;
            default:
                $startDay = new DateTime();
                $endDay = new DateTime();
                $say_period = $startDay->format('d/m/Y');
        }

        return [$startDay, $endDay, $say_period];
    }
// [ ======== PAGINATION ========]

static function makeParamsAnd(array $fields)
{
    $params = [];
    $where = '';

    // $where .= " AND ";
    $operation = $fields['operation'];
    $data = $fields['fields'];

    if ($operation == 'LIKE') {

        foreach ($data as $key => $value) {

            $where .= "u.{$key} LIKE :{$key} OR ";
            $params = array_merge($params, [$key => '%' . $value . '%']);
        }
        $where = substr($where, 0, -4);
    } elseif($operation == 'BETWEEN') { // =
        foreach ($data as $key => $value) {
            $where .= "(u.{$key} BETWEEN :{$key}1 AND :{$key}2) OR ";
            $params = array_merge($params, [$key.'1' => $value[0], $key.'2' => $value[1]]);
        }
        $where = substr($where, 0, -4);
    } elseif($operation == 'IN') { // =
        foreach ($data as $key => $value) {
            $list = '';
            $para = [];
            for($j=0; $j < count($value); ++$j) {
                $list .= ":{$key}{$j},";
                $para["{$key}{$j}"] = $value[$j];  
            }
            $list = chop($list, ',');
            $where .= "u.{$key} IN ({$list}) OR ";
            $params = array_merge($params, $para);
        }
        $where = substr($where, 0, -4);
    } elseif($operation == '>=') { // =
        foreach ($data as $key => $value) {

            $where .= "u.{$key} >= :{$key} OR ";
            $params = array_merge($params, [$key => $value]);
        }
        $where = substr($where, 0, -4);
    } else { // =
        foreach ($data as $key => $value) {

            $where .= "u.{$key} = :{$key} OR ";
            $params = array_merge($params, [$key => $value]);
        }
        $where = substr($where, 0, -4);
    }

    return [$where, $params];
}

static function makeParams(array $fields, string $needle, $company, $operation = 'LIKE')
{
    if (is_array($company) and isset($company['where'])) {
        $where  = $company['where'];
        $params = $company['params'];
    } else {

        $where  = "u.company_id = :company_id";
        $params = ['company_id' => $company['id']];
    }
    if (count($fields) > 0) {

        $where .= " AND ";
        if ($operation == 'LIKE') {

            for ($i = 0; $i < count($fields); $i++) {
                $where .= 'u.' . $fields[$i] . ' LIKE :needle OR ';
            }
            $where = substr($where, 0, -4);
            $params = array_merge($params, ['needle' => '%' . $needle . '%']);

        } elseif($operation == 'BETWEEN') { // =
            for ($i = 0; $i < count($fields); $i++) {

                $where .= '(u.' . $fields[$i] . ' BETWEEN :betw1 AND betw2) OR ';
            }
            $where = substr($where, 0, -4);
            $params = array_merge($params, ['betw1' => $needle]);

        } else { // =
            for ($i = 0; $i < count($fields); $i++) {
                $where .= 'u.' . $fields[$i] . ' = :needle OR ';
            }
            $where = substr($where, 0, -4);
            $params = array_merge($params, ['needle' => $needle]);
        }
    }

    return [$where, $params];
}
    static function paginateExt(
        $entityName,
        $company,
        $search = null,
        int $limit = 20,
        int $page = 1,
        $orderBy = 'ASC' // 'DESC'
        // $special = false
    ) {

        // $repoData = $em->getRepository($entityName);
    $table_name = $entityName::repository()->GetDbTableName(); //_table_name;

    $leftJoin = null;
    $nativeJoin = '';
    $sql_select = '';

    if (is_array($company) and isset($company['where'])) {
        $where = $company['where'];
        $params = $company['params'];
        $where .= ' AND';

        if(isset($company['join'])) {
            $leftJoin = $company['join'];
            // always double array ?? [[]]
            if(is_array($leftJoin)) {
                $nativeJoin = '';
                foreach($leftJoin as $join) {
                    $nativeJoin .= " LEFT JOIN {$join['table']} AS {$join['alias']} ON {$join['on']} ";

                    if(isset($join['select'])) {
                        $sql_select .= ','.$join['select'];
                    }
                }
            } else {

                $nativeJoin = "LEFT JOIN {$leftJoin['table']} AS {$leftJoin['alias']} ON {$leftJoin['on']} ";
            }
        }
    } 

    if (is_array($search) and isset($search['and'])) {
        
        $and_block = $search['and'];
        // dd($and_block);
        foreach ($and_block as $block) {
            if(!empty($block)) {

                list($wh, $par) = self::makeParamsAnd($block);
                $params = array_merge($params, $par);
                $where .= '(' . $wh . ') AND';
            }
        }
        $where = chop($where, 'AND');
    } else {

        if ($search == null) $search = ['fields' => [], 'needle' => '', 'operation' => '='];
        if (!isset($search['operation'])) $search['operation'] = 'LIKE';

// dump($company,$search);

        list($where, $params) = self::makeParams(
            $search['fields'],
            $search['needle'],
            $company,
            $search['operation']
        );
    }

    $sql = "SELECT COUNT(u.id) AS len FROM {$table_name} AS u {$nativeJoin} WHERE {$where}";
    $result = DataBase::ExecuteQuery($sql, 'array', $params);
    $lastrec = $result[0]['len'];

    // dump($lastrec);
    $pages = ceil($lastrec / $limit);
    $pagination = $pages > 1;

    $sorting = "";
    if (!is_array($orderBy)) {
        $orderBy = ['id' => $orderBy];
        $sorting = "ORDER BY u.id";
    } else {
        $sorting .= 'ORDER BY ';
        foreach ($orderBy as $key => $value) {
            // $qb->orderBy("u." . $key, $value);
            $sorting .= "$key $value,";
        }
        $sorting = chop($sorting,',');
    }

    $sql_limit = '';
    if ($pagination == false) {
        $page = 1;
    } elseif($page == 202020) {
        $pagination = 2;
        $page = 1;
    } else {
        
        $pagination = 1;
        $offset = $limit * ($page - 1);
        if ($offset > $lastrec) {
            $offset = $lastrec;
            $page = $pages;
        }
        $sql_limit = "LIMIT {$offset},{$limit}";
    }

    if($where) $where = 'WHERE ' . $where; 
    $sql = "SELECT u.* $sql_select FROM $table_name AS u $nativeJoin $where $sorting $sql_limit";

    $pageItems = DataBase::ExecuteQuery($sql, 'array', $params);

    $return = [
        'pagination' => $pagination,
        'pageItems' => $pageItems,
        'page' => $page,
        'pages' => $pages,
    ];
    return $return;
}





}
