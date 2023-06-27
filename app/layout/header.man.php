<?
// include_once('header.man.php');

$langs = Language::findAll();
// dd($langs);
$session = new DataLinkSession();
$lang = $session->get('lang') ?? 'ENG';

$border = "style='border-bottom: 5px solid #009DFF;'";
$is_blog = '';
$is_contact = '';
$is_project = '';
$is_home = '';
$uri = REQUEST::getUri();
if(containExt($uri,'/blog')) {
    $is_blog = $border;
} elseif(containExt($uri,'/contact')) {
    $is_contact = $border;
} elseif(containExt($uri,['/css','/admin','/shop','/rehab'])) {
    $is_project = $border;
} else {
    $is_home = $border;
}

