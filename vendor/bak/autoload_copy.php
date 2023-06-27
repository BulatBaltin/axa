<?
function scandir_folders($d) {
	$folder = array_filter(scandir($d), function ($f) use($d) {
		return is_dir($d . DIRECTORY_SEPARATOR . $f);
	});
	return array_diff($folder, array('..', '.'));
}
function scandir_files($d) {
	$folder = array_filter(scandir($d), function ($f) use($d) {
		return !is_dir($d . DIRECTORY_SEPARATOR . $f);
	});
	return $folder;
}
// -----------------
function stack_load($class_name)
{
	$folder = DMIGHT . "stack/";
    return class_folder_load($folder, $class_name);
}
function model_load($class_name)
{
	$folder = ROOT . "model/";
    return class_folder_load($folder, $class_name);
}
function class_load($class_name)
{
	$folder = DMIGHT . "class/";
    return class_folder_load($folder, $class_name);
}
function namespace_load($class_name)
{
    $file = ROOT . strtolower($class_name) . '.php';
    if(file_exists($file)) {
        require_once($file);
        return true;
    }
    
}
// function namespace_load($class_name)
// {
// 	$folder = DMIGHT . "namespace/" . $class_name;
//     return class_namespace_load($folder);
// }

function class_folder_load($folder, $class_name)
{
    $folder = chop($folder,'/');
    $file = $folder. '/' . strtolower($class_name) . '.php';
    if (file_exists($file) == true) {
        require_once($file);
        return true;
    } 
    $folders = scandir_folders($folder);
    if (!empty($folders)) {
        foreach($folders as $dir) {
            if (class_folder_load($folder.'/'.$dir, $class_name)) return true;
        }
    }
    return false;
}
function class_namespace_load($class_name)
{
    $class = chop($class_name,'/');
	// $class = new \ReflectionClass($class_name);
	$file = str_replace('\\', '/', $class .'.php');

    if (file_exists($file) == true) {
        require_once($file);
        return true;
    } 
	// else {
	// 	echo "<br>Not found:" . $file;
	// }
    return false;
}

spl_autoload_register('namespace_test');
spl_autoload_register('class_load');
spl_autoload_register('model_load');
spl_autoload_register('stack_load'); // all other heap of entities
spl_autoload_register('namespace_load');
