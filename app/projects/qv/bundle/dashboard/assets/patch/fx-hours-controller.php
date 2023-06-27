<?php
$customer_id = $customer_id ?? null;
$completed = $completed ?? 'not-completed';
[$fixedTasksData, $fixedtotal] = Task::fetchEstimatedTasks($company, $customer_id, $completed);

$fixedtasks = [];
foreach($fixedTasksData as $fixedTask) {
    $fixedtasks[] = 
        ['id' => $fixedTask['id'], 'task' => $fixedTask['task'],
        'start'=>(new DateTime($fixedTask['planstart']))->format('d/m/Y'), 
        'due'=>(new DateTime($fixedTask['planstop']))->format('d/m/Y'), 
        'hours' => round($fixedTask['planhours'],2), 'completed'=>$fixedTask['completed'] ];
}
