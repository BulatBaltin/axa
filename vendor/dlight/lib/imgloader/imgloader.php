<?
include("../core/database.php");
include("../core/functions.php");
include("../core/main_functions.php");
include("../config.php");  
include("../const.php");

  
  $db=new Database();
  
  //mysql_query("INSERT INTO `admin_users` (`id`, `name`, `pass`, `status`) VALUES (NULL, '".DataBase::real_escape_string($_FILES['Filedata']['tmp_name'])."', 't', '1')");
  
if(isset($_GET['album_id'])&&is_numeric($_GET['album_id']))
{
$db=new Database();
  
$photos_gateway=new pictures();

$album_id=StringBeforeDB($_GET['album_id']);
  
 
  

  



$ar1=explode("\"",$_FILES['Filedata']['name']);
$ar=split("[.]",$ar1[0]);

$ar[1]=stripslashes($ar[1]);

if($ar[1]=="jpg"||$ar[1]=="png"||$ar[1]=="gif")
{

$newtempname=tempvalue();
$small_name=$newtempname."_small.".$ar[1];
$big_name=$newtempname.".".$ar[1];

ScaleImageExt($small_name,$_FILES['Filedata']['tmp_name'],120,120,"../images/albums_pictures/",$ar[1]);

move_uploaded_file($_FILES['Filedata']['tmp_name'], "../images/albums_pictures/".$big_name);
$photos_gateway->AddDirect(array("NULL","{$big_name};{$small_name}",$album_id));

}
}          
  
echo "ok";
  
  

?>