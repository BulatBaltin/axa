<?
 try
 {    
     $the_file = BUNDLE.ROUTER::ModuleName()."/".ROUTER::ActionName().".view.php";
     file_exists($the_file) and include($the_file);
 }
 catch(Exception $e)
 {
    echo $e->getMessage();
 }
                       
//  include_dlight_partial("dev_env_panel");
?>