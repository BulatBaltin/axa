<?
// array_map( function ($a) { return include($a); }, array('xx.php','yy.php','zz.php'));
// eval();

$folder = ROUTER::ModulePath() .'header/';
if(is_dir($folder)) { // module
    
    $controllers    = FILE_SYSTEM::getDirFiles( $folder, 'php', 'view.php' );
    $views          = FILE_SYSTEM::getDirFiles( $folder, 'view.php' );

    if($controllers)    foreach ($controllers as $file) include_once($file);
    if($views)          foreach ($views as $file)       include_once($file);

} else { // project
    $folder = ROUTER::ProjectPath() .'header/';
    if(is_dir($folder)) {
        $controllers    = FILE_SYSTEM::getDirFiles( $folder, 'php', 'view.php' );
        $views          = FILE_SYSTEM::getDirFiles( $folder, 'view.php' );
        
        if($controllers)    foreach ($controllers as $file) include_once($file);
        if($views)          foreach ($views as $file)       include_once($file);

    } else { // application
        include_once(CheckIfExistsInModule('header.php', LAYOUT.'header.view.php'));
    }
}
// die;
?>
