<?
define('DB_MODELS', $doc_root."app/backend/model/db-builder/");
define('DMIGHT', $doc_root."vendor/dmight/");

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

function class_models_autoload($class_name)
{
	$model = DB_MODELS; 
	$projects = scandir_folders($model);
	$found = false;
	foreach($projects as $project) {

		$root = $model . $project . '/';
		$dirs = scandir_folders($root);

		// echo $root, '= ';		
	
		foreach($dirs as $folder) {
			$file = $root . $folder .'/'. strtolower($class_name) . '.php';
			if (file_exists($file) == true) {
				$found = true;
				break;
			}
		}
		if($found === true) break;
	}
// echo $found, '***', $file;
// die;
	if($found == false) return false;

	require_once($file);
	return true;
}
function class_autoload($class_name)
{
	$file = DMIGHT . "classes/" . ucfirst(strtolower($class_name)) . '.php';

	if (file_exists($file) == false)
		return false;
	require_once($file);
	return true;
}
function traits_autoload($class_name)
{
	$file = DMIGHT . "traits/" . ucfirst(strtolower($class_name)) . '.php';

	if (file_exists($file) == false)
		return false;
	require_once($file);
	return true;
}

FILE_SYSTEM::includeDir( DMIGHT . "core/");

spl_autoload_register('class_models_autoload');
spl_autoload_register('class_autoload');
spl_autoload_register('traits_autoload');
