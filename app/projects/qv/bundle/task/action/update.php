<?php
// get form and data
$task   = REQUEST::getForm();
$task['company_id'] = $company['id'];

// dd($task);
// validation 
$validate = validateForm($task);
if(! ($validate === true) ) Json_Response($validate);

// Save data
Task::Commit( $task );

Json_Response([
    'return'    => 'success',
    'mssg'      => Messager::renderSuccess('Updated'),
]);

// how to validate
function validateForm($task) {
    
    if(empty($task['task'])) {
        $return = 'error';
        $mssg   = Messager::renderError("Error: task name should not be empty");
        return ['return' => $return, 'mssg' => $mssg]; 
    }

    return true;
}
