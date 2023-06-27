<?
// dump('header ModulePath: tagline ? ' . isset($tagline));
// die;

if(strpos(REQUEST::getUri(), 'dash-dev') > 0) { // developer

    $folder = ROUTER::ModulePath() . 'user/header/';
    $files_php = FILE_SYSTEM::getDirFiles( $folder, 'php' );
    if($files_php) {
        foreach ($files_php as $file) {
            include_once($file);
        }
    }
    $files_php = FILE_SYSTEM::getDirFiles( $folder, 'view.php' );
    if($files_php) {
        foreach ($files_php as $file) {
            include_once($file);
        }
    }
} else { // main qv project

    $folder = ROUTER::ProjectPath() . 'header/';
    $files_php = FILE_SYSTEM::getDirFiles( $folder, 'php' );
    if($files_php) {
        foreach ($files_php as $file) {
            include_once($file);
        }
    }
    $files_php = FILE_SYSTEM::getDirFiles( $folder, 'view.php' );
    if($files_php) {
        foreach ($files_php as $file) {
            include_once($file);
        }
    }
}
