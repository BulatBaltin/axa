<?php
  

APP::addPlugin("dltexts");
  
class dltexts extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id",
            "slug",
            "disc",
            "text_ru"
            ),"dltexts","id");
        $this->setTableRus("Тексты",array("ID",
            "Метка (не изменять)",
            "Описание",
            "Текст (рус.)"
            ));
        $this->NOTDeletable();
        $this->NOTAddable();            
        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",NOT_STRONG,50));
        
        //$mt1=;
        //$mt1->XEdit(true);
        $this->AddFieldType(new MultiText("",NOT_STRONG,50,10));
        $this->AddFieldType(new MultiText("",NOT_STRONG,50,10));
        
        
    }
    
    public static function getTexts($labels,$htmlspecialchars=true,$nl2br=true,$lang=false)
    {
        if(!$lang)
            $lang=getLang();
        $gateway=new dltexts();
        
        if(!is_array($labels))
            $labels=array($labels);
        
        $result=array();
        for($i=0;$i<count($labels);$i++)
            $labels[$i]="'".$labels[$i]."'";
        $labels_cond=implode(", ",$labels);
        $gateway->ReturnIterator();
        $texts=$gateway->getWhereExt("slug IN ({$labels_cond})",array("slug","text_".$lang));
        while($text=$texts->NextElem())
            if($htmlspecialchars)
                $result[$text['slug']]=HTML::Out($text['text_'.$lang],$nl2br);
              else    
                $result[$text['slug']]=$text['text_'.$lang];
        
        return $result;
        
        
    }
    
}

?>