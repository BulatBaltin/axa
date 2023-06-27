<?
APP::addPlugin("dlseomainpage");
  
class dlseomainpage extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id",
            "seo_title_ru",
            "seo_keywords_ru",
            "seo_discription_ru",
            "seo_h1_ru",
            "brands_on_main",
            "seo_text_ru",
            "seo_footerlinks_ru"
            ),"dlseomainpage","id");
        $this->setTableRus("SEO Главной страницы",array("ID",
            "SEO TITLE",
            "SEO KEYWORDS",
            "SEO DISCRIPTION",
            "H1 на главной",
            "Фото брендов (1180х159)",
            "Текст на главной",
            "Текст в футере"
            ));
        $this->NOTDeletable();
        $this->NOTAddable();            
        $this->AddFieldType(new ID());
        $this->AddFieldType(new MultiText("",NOT_STRONG,100,2));
        
        $this->AddFieldType(new MultiText("",NOT_STRONG,100,2));
        
        $this->AddFieldType(new MultiText("",NOT_STRONG,100,2));
        
        $this->AddFieldType(new MultiText("",NOT_STRONG,100,2));
        
        //$this->AddFieldType(new PhotoField(NOT_STRONG,"uploads/images/category_photos/",array(array(1180,159)),array(""),30000,true,false));
        $this->AddFieldType(new MultiPhotoField(NOT_STRONG,"uploads/images/category_photos/",array(array(1180, 159)),array(""),"",true,true));
        
        $this->AddFieldType(new RedactorField("",NOT_STRONG));
        
        $this->AddFieldType(new MultiText("",NOT_STRONG,100,3));
        
            
    }
    
    public static function getData($fields = false, $filter = false, $page_num = false, $recs_per_page = false, $sort_cond = false, $all_num_rows = false)
    {
        $dlseomainpage_gateway=new dlseomainpage();
        if(is_array($fields))
            return $dlseomainpage_gateway->getRecFieldsById(1,$fields);
        else
            return $dlseomainpage_gateway->getRecFieldsById(1,array($fields));
    }
    
}
?>