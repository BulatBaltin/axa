<?php

class OpenTasksReportType extends dmForm
{
    static private $rules = 
        [
0 => '1. Task has a tag of Login, Idea, Documentation',
1 => '2. Task is in one of the lists Login information, Random Tasks, Tasks MJ, Internal Projects',
2 => '3. Task was updated in last two days, time has been written to task in last two days and task has low or NO priority',
3 => '4. Task is in task Archived',
4 => '5. Task has high priority and no update for less than one day',
5 => '6. Task has Waiting Approval tag and no update for less than one week'
        ];
        
    static function getRules() : array {
        return self::$rules;
    }   
    static function getRulesSQL( $ids ) : array {
        $rules = [];
        foreach($ids as $id) {
            switch ($id) {
                case '0': // '1. Task has a tag of Login, Idea, Documentation'
                    $rules[] = 
                        "NOT (
                            t.tags LIKE '%Login%'
                            OR t.tags LIKE '%Idea%'
                            OR t.tags LIKE '%Documentation%'
                        )"
                    ;
                    break;
                case '1': // '2. Task is in one of the lists Login information ...
                    $rules[] = 
                        "NOT (
                            t.projectname LIKE '%Login information%'
                            OR t.projectname LIKE '%Random Tasks%'
                            OR t.projectname LIKE '%Tasks MJ%'
                            OR t.projectname LIKE '%Internal%'
                        )"
                    ;
                    break;
                case '2': // '3. Task was updated in last two days...
                    // CURDATE() - INTERVAL 1 DAY
                    $rules[] = 
                        "NOT (
                        (t.priority = '' OR t.priority = 'low')
                         AND t.stop >= DATE_SUB(now(), INTERVAL 2 DAY)
                        )"
                    ;
                    break;
                case '3':
                    $rules[] = 
                        "NOT (
                        t.parenttaskcontent LIKE '%Archived%'
                        )"
                    ;
                    break;
                case '4':
                    // What about Waiting More info, Waiting
                    $rules[] = 
                        "NOT (
                        t.priority = 'high'
                        AND t.stop >= DATE_SUB(NOW(), INTERVAL 1 DAY)
                        )"
                    ;
                    break;
                case '5':
                    // What about Waiting More info, Waiting
                    $rules[] = 
                        "NOT (
                        t.tags LIKE '%Waiting Approval%'
                        AND t.stop >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                        )"
                    ;
                    break;
                default:
                    # code...
                    break;
            }
        }

        return $rules;
    }   
    static function getOrderBy( $order ) : array {
        switch ($order) {
            case 0:
                $cond = ['stop' => 'DESC'];
                break;
            case 1:
                $cond = ['stop' => 'ASC'];
                break;
            case 2:
                $cond = ['tags' => 'DESC'];
                break;
            case 3:
                $cond = ['priority' => 'DESC'];
                break;
            
            default:
                $cond = ['stop' => 'DESC']; //null;
                break;
        }
        return $cond;
    }   
    public function __construct(array $options = [])
    {
        $this
        ->add('xstart', [
            'type' => 'date',
            'label' => 'Last update date since',
            'value' => (new DateTime('first day of january'))->format('Y-m-d'),
        ])
        ->add('isrules', [
            'type'  => 'checkbox',
            'label' => 'Apply rules',
            'value' => true,
        ])
        ->add('limit', [
            'type'  => 'number',
            'label' => 'Max records',
            'value' => 256,
        ])
        ->add('user', [
            'type'      => 'combo',
            'source'    => 'user',
            'label'     => 'Developer',
            'first_rec' => '- All -',
            'placeholder' => 'All developers',
        ])
        ->add('adduser', [
            'type'      => 'combo',
            'source'    => 'user',
            'first_rec' => '- All -',
            'label'     => 'Send Email to Employee',
        ])
        ->add('orderby', [
            'label' => 'Sorting',
            'type'  => 'combo',
            'value' => 0,
            'source'  => [
                0 => 'Descending update date',
                1 => 'Ascending update date',
                2 => 'Tags',
                3 => 'Priority'
            ] 
        ])
        ->add('rules', [
            'type'          => 'combo',
            'label'         => 'Following rules to exclude open tasks',
            'placeholder'   => 'Select rule',
            'source'        => self::getRules()
        ])
        ->add('rulelist')
        ->add('emaillist')
    ;
    }

}
