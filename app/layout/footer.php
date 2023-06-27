<?
$folder = ROUTER::ProjectPath() .'footer/';
if(is_dir($folder)) {
    FILE_SYSTEM::includeDir( $folder );
} else {
    include (CheckIfExistsInModule('footer.php', LAYOUT.'footer.view.php'));
}
