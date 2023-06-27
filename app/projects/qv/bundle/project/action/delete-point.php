<?
$proj_id    = REQUEST::getParam('id');
$pid        = REQUEST::getParam('pid');

try {

    ProjectenPoint::Delete($pid);
    
    $projecten  = Project::find( $proj_id );
    $htmlPoints = module_partial('include/_checkpoints-table', [
        'project' => $projecten
    ], true);

    $contents = [
        'return' => 'success', 
        'htmlPoints' => $htmlPoints
    ];

} catch(Exception $e) {
    $contents = ['return' => 'error', 'mssg' => $e->getMessage()];
}

Json_Response($contents);
