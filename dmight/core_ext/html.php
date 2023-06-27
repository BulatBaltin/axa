<?php
class HTML
{
    public static $_js_files = array();
    public static $_css_files = array();
    public static $_js_files_config;
    public static $_css_files_config;
    public static $_canonical_url = "";

public static function LinkJSAuto()
{
    FILE_SYSTEM::provideDirFiles(JS_CODE . 'auto', 
    new class {
        function handle($file) {
            echo "
    <script type=\"text/javascript\" src=\"/js/auto/{$file}\"></script>";
        }
    }, 'js');
    echo "\n";
}
public static function LinkCSSAuto()
{
    $folder = 'auto';
    self::LinkCSSFolder($folder);
}
public static function LinkCSSFolder($folder)
{
    $path = CSS . $folder;
    if(is_dir($path)) {
        FILE_SYSTEM::provideDirFiles(
        CSS . $folder, 
        new class ($folder) {
            private $folder;
            function __construct($folder)
            {
                $this->folder = $folder;
            }
            function handle($file) {
                echo "
        <link href=\"/css/{$this->folder}/{$file}\" rel=\"stylesheet\">";
            }
        }, 'css');
        echo "\n";
    }
}

public static function GetAllIncludeFiles($folder)
{
    $path = CSS . $folder;
    if(is_dir($path)) {
        FILE_SYSTEM::provideDirFiles(
        CSS . $folder, 
        new class ($folder) {
            private $folder;
            function __construct($folder)
            {
                $this->folder = $folder;
            }
            function handle($file) {
                echo "
        <link href=\"/css/{$this->folder}/{$file}\" rel=\"stylesheet\">";
            }
        }, 'css');
        echo "\n";
    }
}

public static function LinkCSSProject()
{
    $folder = ROUTER::ProjectName();
    self::LinkCSSFolder($folder);
}
public static function LinkMetaData()
{
    $the_file = ROUTER::ProjectPath() . ROUTER::ModuleName(). '/meta.link';
    file_exists($the_file) and include($the_file);
}

public static function LinkLocalJS( $file_js = false)
{
    if($file_js == false) {
        if(count(HTML::$_js_files)) {
            foreach (HTML::$_js_files as $file)
                echo "
    <script type=\"text/javascript\" src=\"/js/{$file}\"></script>";
        }
    } else {
        HTML::$_js_files[] = $file_js;
    }
}
public static function LinkDefaultJS()
{

    $action = ROUTER::ActionName();
    $module = ROUTER::ModuleName();
    $file = $module . '/'. $action . '.js';
    $the_file = '/js/'. $file;
    if(file_exists($the_file)) {
        echo "
    <script type=\"text/javascript\" src=\"{$the_file}\"></script>";
    }
}

public static function canonicalUrl($url = null)
    {
        if ($url === null) {
            return HTML::$_canonical_url;
        } else {
            HTML::$_canonical_url = $url;
        }
    }

    public static function getProductSnippet(
        $product_name,
        $product_image,
        $product_short_desc,
        $product_price,
        $in_stock,
        $product_currency_label = "RUB",
        $product_currency = "руб."
    ) {

        return "";

        $product_image = UrlHelper::Protocol() . "://" . APP::Config("DOMAIN") . $product_image;

        $name_html = '<div class="micro-product" itemscope itemtype="https://schema.org/Product">
<span itemprop="name">' . $product_name . '</span>
<img src="' . $product_image . '" alt="' . $product_name . '"/>';

        /*$rating_html = '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
Рейтинг <span itemprop="ratingValue">4</span>/5
основан на <span itemprop="reviewCount">'.$rating_review_number.'</span> оценках
</div>*/


        if ($in_stock) {
            $in_stock_text = "В наличии";
        } else {
            $in_stock_text = "Нет в наличии";
        }

        if (!$product_short_desc) {
            $product_short_desc = $product_name;
        } else {
            $product_short_desc = str_replace("\n", "", substr(strip_tags($product_short_desc), 0, 10000));
        }


        $price_html = '<div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
    <span itemprop="priceCurrency" content="' . $product_currency_label . '">руб.</span> 
    <span itemprop="price" content="' . $product_price . '">' . $product_price . '</span> 
    <link itemprop="availability" href="https://schema.org/InStock" />' . $in_stock_text . '
</div>
<span itemprop="description">' . $product_short_desc . '</span>';

        /*
<div itemprop="review" itemscope itemtype="http://schema.org/Review">
    <span itemprop="name">Заголовок отзыва</span>
    от <span itemprop="author">Имя пользователя</span>,
    <meta itemprop="datePublished" content="2017-03-21">Март 21, 2017
        
    <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
        <meta itemprop="worstRating" content = "1"> // Минимальная оценка
        <span itemprop="ratingValue">4</span>/ // Оценка пользователя
        <span itemprop="bestRating">5</span>звезд.  // Максимальная оценка оценка
    </div>
    <span itemprop="description">Текст отзыва</span>
</div>*/

        return $name_html . $price_html . '</div>';
    }

    public static function Out($str, $nl2br = false)
    {
        $res = htmlspecialchars(strip_tags($str));
        if ($nl2br)
            $res = nl2br($res);
        return $res;
    }

    public static function addJS($js_file_array)
    {
        if (is_array($js_file_array)) {
            foreach ($js_file_array as $file)
                HTML::$_js_files_config[] = $file;
        } else {
            HTML::$_js_files_config[] = $js_file_array;
        }
    }

    public static function addCSS($css_file_array)
    {
        if (is_array($css_file_array)) {
            foreach ($css_file_array as $file)
                HTML::$_css_files_config[] = $file;
        } else {
            HTML::$_css_files_config[] = $css_file_array;
        }
    }

    public static function RenderFavIcon()
    {
        $icon_path = APP::Config("FAV_ICON");
        echo "
    <link rel=\"icon\" type=\"image/x-icon\" href=\"{$icon_path}\">
    <link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"{$icon_path}\">\n";
    }

    public static function RenderHEAD($js_in_head = false, $css_in_head = true)
    {

        $charset=APP::Config("CHARSET");
        if(!$charset)
            $charset="utf-8";
   
        $title = SEO::Title();
        if(SEO::AddProjectNameToTitle()){
            $title .= " | ".APP::Config("PROJECT_NAME");
        }
        echo "
    <title>".$title."</title>
    <meta charset=\"".$charset."\">
    <meta name=\"Description\" content=\"".htmlspecialchars( SEO::Discription() )."\">
    <meta name=\"Keywords\" content=\"".SEO::Keywords()."\">";
        
        if(SEO::NoRobotsForPage()){
            echo "
    <meta name='robots' content='noindex, nofollow'>";
        }

        if(HTML::canonicalUrl()){
            $canonical_url = HTML::canonicalUrl();
            echo "
    <link rel='canonical' href='".$canonical_url."'/>";
        }
        
        HTML::RenderFavIcon();
        if($js_in_head){
            HTML::RenderJS();
        }
           
        SocialButtons::RenderHead();
        
        if($css_in_head){
            HTML::RenderCSS();
        }
        echo "
";
    
    }

    public static function RenderJS()
    {

        foreach (HTML::$_js_files_config as $file)
            echo "<script type=\"text/javascript\" src=\"{$file}\"></script>\n";

        foreach (HTML::$_js_files as $file)
            echo "<script type=\"text/javascript\" src=\"{$file}\"></script>\n";

        $action_name = ROUTER::ActionName();
        $module_name = ROUTER::ModuleName();

        $action_js = "/js/" . APP::Name() . "/" . $module_name . "/" . $action_name . ".js";
        if (file_exists(getDocumentRoot(false) . $action_js))
            echo "<script type=\"text/javascript\" src=\"" . $action_js . APP::getStaticContentCacheParam() . "\"></script>\n";

        if (APP::Config("MultiLang")) {
            $lang = Local::getLang();
            $lang_js = "/langs/" . $lang . '.js';
            if (file_exists(getDocumentRoot(false) . $lang_js))
                echo "<script type=\"text/javascript\" src=\"" . $lang_js . APP::getStaticContentCacheParam() . "\"></script>\n";
        }
    }

    public static function RenderJSFile($files)
    {
        $files_temp = getArray($files);
        foreach ($files_temp as $file)
            if (file_exists(getDocumentRoot(false) . $file))
                echo "<script type=\"text/javascript\" src=\"{$file}\"></script>\n";
    }

    public static function RenderCSSFile($files)
    {
        $files_temp = getArray($files);
        foreach ($files_temp as $file)
            if (file_exists(getDocumentRoot(false) . $file))
                echo "<link rel=\"stylesheet\" href=\"{$file}\">\n";
    }

    public static function RenderCSS()
    {
        if(is_array(HTML::$_css_files_config))
            foreach (HTML::$_css_files_config as $file)
                echo "<link rel=\"stylesheet\" href=\"{$file}\">\n";

        if(is_array(HTML::$_css_files))
            foreach (HTML::$_css_files as $file)
                echo "<link rel=\"stylesheet\" href=\"{$file}\">\n";
    }
}



class SEO
{
    public static $_seo_title;
    public static $_seo_keywords;
    public static $_seo_discription;
    public static $_seo_h1;
    public static $_add_project_name_to_title = true;
    public static $_seo_links;
    public static $_no_robots_for_page = false;
    public static $_stat_code;


    public static function AddProjectNameToTitle($value = null)
    {
        if ($value !== null)
            SEO::$_add_project_name_to_title = $value;
        else
            return SEO::$_add_project_name_to_title;
    }

    public static function NoRobotsForPage($value = false)
    {
        if ($value !== false)
            SEO::$_no_robots_for_page = $value;
        else
            return SEO::$_no_robots_for_page;
    }

    public static function setSEOHead($seo_title, $seo_keywords, $seo_description, $use_recommended_values = false, $htmlspecialchars = false)
    {

        $seo_description = strip_tags($seo_description);

        if ($htmlspecialchars) {
            $seo_title = TextHelper::Out($seo_title);
            $seo_keywords = TextHelper::Out($seo_keywords);
            $seo_description = TextHelper::Out($seo_description);
        }


        if (!$use_recommended_values)
            SEO::$_seo_title = $seo_title;
        else
            SEO::$_seo_title = mb_substr($seo_title, 0, 200);
        if (trim($seo_keywords))
            SEO::$_seo_keywords = $seo_keywords;
        else
            SEO::$_seo_keywords = SEO::$_seo_title;

        $seo_description = mb_substr($seo_description, 0, 200, "utf-8");

        if (trim($seo_description))
            SEO::$_seo_discription = $seo_description;
        else
            SEO::$_seo_discription = SEO::$_seo_title;
    }

    public static function Title($value = false)
    {
        if ($value)
            SEO::$_seo_title = $value;
        else
            return SEO::$_seo_title;
    }

    public static function Keywords($value = false)
    {
        if ($value)
            SEO::$_seo_keywords = $value;
        else
            return SEO::$_seo_keywords;
    }

    public static function Discription($value = false)
    {
        if ($value)
            SEO::$_seo_discription = $value;
        else
            return SEO::$_seo_discription;
    }

    public static function H1($value = false, $htmlspecialchars = false)
    {
        if ($value)
            if ($htmlspecialchars)
                SEO::$_seo_h1 = TextHelper::Out($value);
            else
                SEO::$_seo_h1 = $value;
        else
            return SEO::$_seo_h1;
    }

    public static function Links($value = false)
    {

        if ($value)
            SEO::$_seo_links = $value;
        else
            return SEO::$_seo_links;
    }

    public static function StatCode($value = false)
    {
        if ($value)
            SEO::$_stat_code = $value;
        else
            return SEO::$_stat_code;
    }
}


class Captcha
{

    public static function render()
    {
        echo "<img src='/dlight/tasks/captcha.php?" . session_name() . "=" . session_id() . "'>";
    }

    public static function getCode()
    {
        return $_SESSION['register_code'];
    }

    public static function checkCaptcha($form_captcha)
    {
        if ($form_captcha == Captcha::getCode())
            return true;
        else
            return false;
    }
}
