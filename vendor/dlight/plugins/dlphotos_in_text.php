<?php
APP::addPlugin("dlphotos_in_text");
  
class dlphotos_in_text extends dlModel
{
    function __construct()
    {
        parent::__construct();
        $this->setTableName("dlphotos_in_text","Фото в статьях");
        $this->SetAddText("Добавить фото");
        
        $photo_field=new PhotoField(NOT_STRONG,"uploads/images/post_photos/",array(array(1100,6000)),array(""),30000,true,true);
        $photo_field->SetOnViewFunction(array("dlphotos_in_text","OnViewPic"));
        
        $this->AddFields(array(
            array($photo_field,"photo","Фото")
            ));
    }
    
    public static function OnViewPic($value)
    {
        $img=get_img("dlphotos_in_text","photo",$value,0,"");
        return "<img src='{$img}'>
        <p>Путь к картинке: ".UrlHelper::Protocol()."://".APP::Config("DOMAIN")."{$img}</p>";
    }
} 
?>