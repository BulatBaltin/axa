<?

$proj_id        = REQUEST::getParam('id');
$point_name     = REQUEST::getParam('name');
$point_value    = REQUEST::getParam('point');

try {

    $point['id'] = 0; // add
    $point['projecten_id'] = $proj_id;
    $point['name'] = $point_name;
    $point['point'] = (int)$point_value;
    $point['date'] = date("Y-m-d H:i:s"); //new DateTime();

    ProjectenPoint::Commit($point);
    
    $projecten = Project::find($proj_id);
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
