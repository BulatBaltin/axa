<?
// $table_name = REQUEST::getParam('table_name');
// $data = REQUEST::getParam('data');

// $db_admin = new AdminDB;
// $refs = $db_admin->

$catalogue = class_school('catalogue');
$document = class_school('document');
$register = class_school('register');
$doxpart = class_school('doxpart');
$schedule = class_school('schedule');
$tables = array_merge($catalogue, $document, $register, $doxpart, $schedule);

$time = (new DateTime())->format('c');

function class_school( $folder = 'catalogue' )
{
    $folder = strtolower($folder);
	$root = DB_MODELS . 'school/' . $folder;
	$classes = scandir_files($root);
    // dd($classes);
    $dbts = [];
    // var_dump($classes);
    foreach($classes as $file) {
        $file = basename($file, '.php');
        if(strtolower($file) == $folder ) continue;           
        // dd($file);
        /** @var dmModel  */ 
        $class = new $file;
        $dbts[] = $class->CreateTable(true);
        $dbts[] = $class->ModifyTable();
        $dbts[] = $class->SimulateData();
    }
    return $dbts;
}

?>

