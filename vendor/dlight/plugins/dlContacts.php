<?

APP::addPlugin("dlcontacts");
  
class dlcontacts extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id",
            "country_ru",
            "city_ru",
            "address_ru",
            "email","system_email",
            "map","phones",
            "skype","fb","vk","tw"
            ),"dlcontacts","id");
        $this->setTableRus("Контакты",array("ID",
            "Страна (рус.)",
            "Город (рус.)",
            "Адрес (рус.)",
            "Email","Системный email",
            "Карта","Телефоны",
            "Skype","Facebook","VKontakte","Twitter"
            ));
            
        $this->NOTDeletable();
        $this->NOTAddable();  
        
                  
        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",NOT_STRONG,50));
        $this->AddFieldType(new Text("",NOT_STRONG,50));
        $this->AddFieldType(new Text("",NOT_STRONG,50));
        $this->AddFieldType(new Text("",NOT_STRONG,50));
        $this->AddFieldType(new Text("",NOT_STRONG,50));
        $this->AddFieldType(new MapField("",NOT_STRONG,500,500));
        $this->AddFieldType(new MultiText("",NOT_STRONG,50,3));
        $this->AddFieldType(new Text("",NOT_STRONG,50));
        $this->AddFieldType(new Text("",NOT_STRONG,50));
        $this->AddFieldType(new Text("",NOT_STRONG,50));
        $this->AddFieldType(new Text("",NOT_STRONG,50));
    }
    
    public static function getData($fields = false, $filter = false, $page_num = false, $recs_per_page = false, $sort_cond = false, $all_num_rows = false)
    {
        $gateway=dlModel::Create("dlcontacts");
        if(is_array($fields))
            return $gateway->getRecFieldsById(1,$fields);
        else
            return $gateway->getRecFieldsById(1,array($fields));
    }
    
}
?>