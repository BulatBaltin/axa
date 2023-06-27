<?
// $class_name = 'VendorPlus';
// $object = Factory::Create($class_name);

class Factory {
    static $namespace = 'dmight/vendor/'; //DMIGHT . "namespace/";
    function __construct($nameSpace = null)
    {
        if($nameSpace) self::$namespace = $nameSpace;
        spl_autoload_register('require_script');
    }
    function Create($class_name, $params = null)
    {
        if($params)
            return new $class_name($params);
        else
            return new $class_name();
    }
    // 
    static function scandir_folders($d) {
        $folder = array_filter(scandir($d), function ($f) use($d) {
            return is_dir($d . DIRECTORY_SEPARATOR . $f);
        });
        return array_diff($folder, ['..', '.']);
    }
    // 
    static function class_folder_load($folder, $class_name)
    {
        $folder = chop($folder,'/');
        $file = $folder. '/' . strtolower($class_name) . '.php';
 
        if (file_exists($file) == true) {
            require_once($file);
            return true;
        } 
        $folders = Factory::scandir_folders($folder);
        if (!empty($folders)) {
            foreach($folders as $dir) {
                if (Factory::class_folder_load($folder.'/'.$dir, $class_name)) return true;
            }
        }
        return false;
    }
    
}

function require_script($class_name)
{
    $folder = ROOT . Factory::$namespace;
	$file =  $folder . $class_name;
    $file = chop($file,'/');
	$file = str_replace('\\', '/', $file .'.php');

    if (file_exists($file) == true) {
        require_once($file);
        return true;
    } 

    if(Factory::class_folder_load($folder, $class_name)) return true;

    return false;
}
