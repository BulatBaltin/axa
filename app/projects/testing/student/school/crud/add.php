<?

// echo 'START', '<br>';

try {

    $student_name = "Mary Jones Smart";
    $student_url = ROUTER::get_url('stydentik.add');
    $scolar_url = ROUTER::get_url('scolar.add');

    $path_test = ROUTER::get_url('test.unit-10-1'); //, [], false, true); // path('test.unit10-1');
    $path_project = ROUTER::get_url('qv.dashboard.index'); //, [], false, true); // path('test.unit10-1');
    $path_project2 = ROUTER::get_url('qv.dashboard'); //, [], false, true); // path('test.unit10-1');

} catch(Exception $e) {
    echo $e->getMessage();
    die;
}

// echo '$student_url=', $student_url, '<br>';
// echo '$path_test=', $path_test;
// die;