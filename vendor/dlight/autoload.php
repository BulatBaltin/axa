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

function class_school_autoload($class_name)
{
	$root = MODELS . 'school/';
	$dirs = scandir_folders($root);

	$found = false;
	foreach($dirs as $folder) {
		$file = $root . $folder .'/'. strtolower($class_name) . '.php';
		if (file_exists($file) == true) {
			$found = true;
			break;
		}
	}
	if($found == false) 
		return false;
	require_once($file);
	return true;
}
function class_models_autoload($class_name)
{
	$model = MODELS; // . 'school/';
	$projects = scandir_folders($model);
	$found = false;
	foreach($projects as $project) {

		$root = MODELS . $project . '/';
		$dirs = scandir_folders($root);
	
		foreach($dirs as $folder) {
			$file = $root . $folder .'/'. strtolower($class_name) . '.php';
			if (file_exists($file) == true) {
				$found = true;
				break;
			}
		}
		if($found === true) break;
	}

	if($found == false) return false;

	require_once($file);
	return true;
}
function class_autoload($class_name)
{
	$file = DLIGHT . "auto/classes/" . ucfirst(strtolower($class_name)) . '.php';
	// echo '<br>' . $file;
	if (file_exists($file) == false)
		return false;
	require_once($file);
	return true;
}
function traits_autoload($class_name)
{
	// $file = APP . 'controllers/' . preg_replace('#controller$#i', 'Controller', ucfirst(strtolower($class_name))) . '.php';
	$file = DLIGHT . "auto/traits/" . ucfirst(strtolower($class_name)) . '.php';
	// echo '<br>' . $file;
	if (file_exists($file) == false)
		return false;
	require_once($file);
	return true;
}
// function model_autoload($class_name)
// {
// 	$file = APP . 'models/' . ucfirst(strtolower($class_name)) . '.php';
// 	echo '<br>' . $file;
// 	if (file_exists($file) == false)
// 		return false;
// 	require_once($file);
// 	return true;
// }

// spl_autoload_register('class_school_autoload');
spl_autoload_register('class_models_autoload');
spl_autoload_register('class_autoload');
spl_autoload_register('traits_autoload');
// spl_autoload_register('model_autoload');
