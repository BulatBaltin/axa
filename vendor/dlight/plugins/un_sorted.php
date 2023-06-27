<?
//часто используемые таблицы
class user_stat extends dlModel
{
function __construct()
{
parent::__construct(array("id","user_id","date","unique_num","loaded_pages_num"),"user_stat","id");
$this->setTableRus("Статистика пользователей",array("ID","ID Позователя отправителя","Дата","Число уникальных посетителей","Число загруженных страниц"));

$this->SetAddText("Добавить элемент");

$this->AddFieldType(new ID());
$this->AddFieldType(new UserID());
$this->AddFieldType(new DateField(NowDate(),STRONG));
$this->AddFieldType(new Text("",STRONG,10));
$this->AddFieldType(new Text("",STRONG,10));
}
}

class day_ips extends dlModel
{
function __construct()
{
parent::__construct(array("id","ip","user_id","date"),"day_ips","id");
$this->setTableRus("IP посетителей сайтов",array("ID","ID Позователя отправителя","Дата","Число уникальных посетителей","Число загруженных страниц"));

$this->SetAddText("Добавить элемент");

$this->AddFieldType(new ID());
$this->AddFieldType(new Text("",STRONG,20));
$this->AddFieldType(new UserID());
$this->AddFieldType(new DateField(NowDate(),STRONG));
}
}



class texts extends dlModel
{
    
    function __construct()
    {
        parent::__construct(array("id","label","disc","text"),"texts","id");
        $this->setTableRus("Тексты",array("ID","Метка","Описание","Текст"));

        //$this->NOTAddable();
        //$this->NOTDeletable();
        $this->SetAddText("Добавить элемент");

        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new Text("",STRONG,60));
        $this->AddFieldType(new RedactorField("",STRONG));
    }
}

class phones extends dlModel
{
function __construct()
{
parent::__construct(array("id","user_id","ccode","code","number","name","otdel"),"phones","id");
$this->setTableRus("Товары",array("ID","ID Пользователя","Код страны","Код оператора","Номер","Имя","Отдел"));

$this->SetAddText("Добавить телефон");

$this->AddFieldType(new ID());
$this->AddFieldType(new UserID("",STRONG));
$this->AddFieldType(new Text("",STRONG,10));
$this->AddFieldType(new Text("",STRONG,10));
$this->AddFieldType(new Text("",STRONG,10));
$this->AddFieldType(new Text("",STRONG,20));
$this->AddFieldType(new Text("",STRONG,20));
}

function getUserPhones($user_id)
{
    return $this->getWhere("user_id",$user_id,"id","ASC");
}

function getPhonesForGroup($ids)
{
if(is_array($ids)&&count($ids)>0)
{
    $ids=array_unique($ids);
    $ids_str=implode(",",$ids);

$sql="
  SELECT 
    *
  FROM 
    `phones`
  WHERE 
    `user_id` IN ({$ids_str})";
    
  //echo $sql;
    
$result=DataBase::ExecuteQuery($sql);
if($result)
    return $result;
{
    $this->setError("Ошибка в запросе к базе данных! Возможно неверный формат параметров! Ошибка:".Database::get_error());
    return false;
}
}
else
    return false;

}
}

/*

class photos_in_text extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id","path"),"photos_in_text","id");
        $this->setTableRus("Фото в тексте",array("ID","Изображение"));    
        $this->SetAddText("Добавить фото");

        $this->AddFieldType(new ID());
        $photo=new PhotoField(NOT_STRONG,"uploads/images/photos_in_text/",array(array(1000,1000),array(200,200)),array("","_small"),30000,true,true);
        $photo->SetOnViewFunction(array("photos_in_text","OnViewPhotosInText"));
        $this->AddFieldType($photo);
    }
    
    public static function OnViewPhotosInText($value)
    {
        //return "123";
        $ar=explode(";",$value);
        if($ar[0]!=""&&$ar[0]!="NOT_SET")
            {
                $res="";
                $ar1=split("[.]",$ar[0]);
                if(file_exists(getDocumentRoot()."uploads/images/photos_in_text/{$ar1[0]}_small.{$ar1[1]}"))
                 $res.="<a href='/uploads/images/photos_in_text/{$ar1[0]}.{$ar1[1]}'><img src='/uploads/images/photos_in_text/{$ar1[0]}_small.{$ar1[1]}'></a><br>";
                 
                 $res.="Cсылка на картинку 200x200: ".UrlHelper::getHttpHostUrl()."/uploads/images/photos_in_text/{$ar1[0]}_small.{$ar1[1]}<br>";
                 $res.="Cсылка на картинку-оригинал: ".UrlHelper::getHttpHostUrl()."/uploads/images/photos_in_text/{$ar1[0]}.{$ar1[1]}<br>";   
                 return $res;
            }
            else
            {return "";}
    }
}
             


class params extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id","portal_email","contacts_phones","contacts_address","contacts_map",
        "contacts_email","file_dogovor","stat_code",
        "seo_title","seo_keywords","seo_discription","seo_link"
        ),"params","id");
        $this->setTableRus("Параметры",array("ID","Email сайта","Контакты (Телефоны)",
        "Контакты (Адрес)","Контакты (Карта)","Контакты (Email)","Файл договора",
        "Код статистики Google",
        "SEO Title","SEO Keywords","SEO Discription","SEO Ссылки"));
        $this->NOTAddable();
        $this->NOTDeletable();
        
        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new MultiText("",STRONG,40,3));
        $this->AddFieldType(new MultiText("",STRONG,40,3));
        $this->AddFieldType(new MapField("",NOT_STRONG,500,500));
        $this->AddFieldType(new Text("",NOT_STRONG,40));
        $this->AddFieldType(new FileField(NOT_STRONG,"uploads/files/dogovor/",""));
        $this->AddFieldType(new MultiText("",NOT_STRONG,40,5));
        $this->AddFieldType(new Text("",NOT_STRONG,60));
        $this->AddFieldType(new Text("",NOT_STRONG,60));
        $this->AddFieldType(new MultiText("",NOT_STRONG,40,3));
        $this->AddFieldType(new Text("",NOT_STRONG,90));
    }
}

            */

//КОНЕЦ часто используемые таблицы

   





?>
