<?
function class_folder_load($folder, $class_name)
{
    $folder = chop($folder,'/');
    $file = $folder. '/' . strtolower($class_name) . '.php';
    if (file_exists($file) == true) {
        require_once($file);
        return true;
    } 
    // $folders = scandir_folders($folder);
	$flds = array_filter(scandir($folder), function ($f) use($folder) {
		return is_dir($folder . DIRECTORY_SEPARATOR . $f);
	});
	$folders = array_diff($flds, ['..', '.']);

    if (!empty($folders)) {
        foreach($folders as $dir) {
            if (class_folder_load($folder.'/'.$dir, $class_name)) return true;
        }
    }
    return false;
}
// -----------------
function space_load($class_name)
{
    // namespace_load
    $file = ROOT . strtolower($class_name) . '.php';
    if(file_exists($file)) {
        // dlLog::Write('FOUND:'.$file.'  CLASS:'.$class_name );
        require_once($file);
        return true;
    } 
    // else {
    //     dlLog::Write('SPACE:'.$file.'  CLASS:'.$class_name );
    // }
    // class_load model_load stack_load
    // $roots = [DMIGHT.'class', ROOT.'model', DMIGHT.'stack', ROOT.'form' ];
    $roots = [DMIGHT.'class', ROOT.'model', ROOT.'form' ];
    foreach($roots as $root) {
        $folder = $root . DIRECTORY_SEPARATOR;
        if(class_folder_load($folder, $class_name)) return true;
    }
    return false;
}

// -------------------------- ]

spl_autoload_register('space_load');
// spl_autoload_register('entity_load');
// spl_autoload_register('class_load');
// spl_autoload_register('model_load');
// spl_autoload_register('stack_load'); // all other heap of entities
// spl_autoload_register('namespace_load');

/*
function entity_load($class_name)
{
    // class/ model/ stack/ -> load
    $roots = [DMIGHT.'class', ROOT.'model', DMIGHT.'stack'];
    foreach($roots as $root) {
        $folder = $root . DIRECTORY_SEPARATOR;
        if(class_folder_load($folder, $class_name)) return true;
    }
    return false;
}
function scandir_folders($d) {

	$folder = array_filter(scandir($d), function ($f) use($d) {
		return is_dir($d . DIRECTORY_SEPARATOR . $f);
	});
	return array_diff($folder, ['..', '.']);
}
*/