<?php

$title = "Rehab translation";
$tabs  = [];

include_once('include/fill-from-tables.php');

$form = new AForm($str_keys, $str_phrases, count($keys));
$form->rows = [];
foreach ($config as $table => $options) {
    $form->rows[] = new rowForm($table, $options);
}
// ----------------
// dd($htmls);
// ----------------
$description = <<< DATA
<p><span style="font-family: Arial;">Hej</span><font style="vertical-align: inherit;">&nbsp;, (#namn)</font></p><p><span style="font-size: 1rem;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Din terapeut (#terapeut) bokade en utbildning åt dig.&nbsp;</font></font><span style="font-weight: bolder;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Ditt personliga träningsprogram börjar den</font></font></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">&nbsp;(#date).</font></font></span><br></p><p><span style="font-size: 1rem;">För att starta ditt program, ladda ner Rehab Care&nbsp;</span><a href="https://apps.apple.com/us/app/rehab-care/id6446091506"><font style="vertical-align: inherit;">klicka här och ladda ner från Apple Store&nbsp;</font></a><font style="vertical-align: inherit;"><span style="font-size: 1rem;"><a href="https://apps.apple.com/us/app/rehab-care/id6446091506" target="_blank"><font style="vertical-align: inherit;">iOS</font></a></span><span style="font-size: 1rem;"><font style="vertical-align: inherit;">&nbsp;eller&nbsp;</font></span><span style="font-size: 1rem;"><a href="https://play.google.com/store/apps/details?id=com.rehabcare"><font style="vertical-align: inherit;">klicka här och ladda ner från google playstore&nbsp;</font></a></span><span style="font-size: 1rem;"><a href="https://play.google.com/store/apps/details?id=com.rehabcare" target="_blank"><font style="vertical-align: inherit;">Android</font></a></span><span style="font-size: 1rem;"><font style="vertical-align: inherit;">&nbsp;eller Se ditt program på (#website_url) &amp;&nbsp;</font></span><a href="https://rehabcare.nl/?login=1" target="_blank"><font style="vertical-align: inherit;">Är du patient?&nbsp;</font></a><a href="https://rehabcare.nl/?login=1" target="_blank"><font style="vertical-align: inherit;">Klicka här.</font></a></font><span style="font-size: 1rem;">&nbsp;<a href="https://apps.apple.com/us/app/rehab-care/id6446091506" target="_blank"><font style="vertical-align: inherit;"></font></a><font style="vertical-align: inherit;"></font><a href="https://play.google.com/store/apps/details?id=com.rehabcare"><font style="vertical-align: inherit;"></font></a>&nbsp;<a href="https://play.google.com/store/apps/details?id=com.rehabcare" target="_blank"><font style="vertical-align: inherit;"></font></a><font style="vertical-align: inherit;"></font></span><a href="https://rehabcare.nl/?login=1" target="_blank"><font style="vertical-align: inherit;"></font></a><span style="font-size: 1rem;"><br></span></p><p><span style="font-size: 1rem;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Din personliga åtkomstkod är (#program_kod).&nbsp;</font></font><span style="font-weight: bolder;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Dela det inte med någon.</font></font></span></span></p><h3 style="color: rgb(80, 0, 80); font-family: Arial, Helvetica, sans-serif; text-align: center; background-color: rgb(243, 243, 243);"><span style="font-weight: bolder; font-size: 1rem;">Rörelse är medicinen!</span></h3><hr><div style="text-align: center;"><font style="vertical-align: inherit;">&nbsp;Med vänliga hälsningar,</font></div><p></p><p style="margin-top: 7px; margin-bottom: 0px; color: rgb(80, 0, 80); text-align: center; background-color: rgb(243, 243, 243); font-family: Poppins, sans-serif; font-weight: 900;"><font style="vertical-align: inherit;">Rehab Lab Support</font></p><p><span style="font-weight: bolder; font-size: 1rem;"><span style="color: rgb(80, 0, 80); font-family: Poppins, sans-serif; font-size: 12px; text-align: center; background-color: rgb(243, 243, 243);"></span></span></p><p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; color: rgb(80, 0, 80); font-size: 13px; text-align: center; background-color: rgb(243, 243, 243); font-family: Poppins, sans-serif; line-height: 27px;"><a href="mailto:support@rehablab.nl" target="_blank" style="box-sizing: border-box; margin: 0px; padding: 0px; background-color: inherit; color: rgb(17, 85, 204); text-decoration: inherit; font-size: 16px; transition: all 0.2s linear 0s; font-family: inherit; font-weight: inherit;"><font style="box-sizing: border-box; margin: 0px; padding: 0px; vertical-align: inherit;"><font style="box-sizing: border-box; margin: 0px; padding: 0px; vertical-align: inherit;">support@rehablab.nl</font></font></a></p>
DATA;

// ----------------
// 
class AForm extends dmForm {
    public $rows;
    function __construct( $keys, $phrases, $len)
    {
        $len = max(20, $len);
        $this
->add('check_all',   [
    'type'  => 'checkbox', 
    'id'    => 'check-all', 
    'label' => 'check/uncheck all', 
    'value' =>true]
    )
->add('lang',   [
    'value'=> 'nl', 
    'type'=> 'combo', 
    'source' => [
    'nl' => 'Dutch',
    'de' => 'German',
    'en' => 'English',
    'fi' => 'Finnish',
    'fr' => 'French',
    'id' => 'Indonesian',
    'it' => 'Italian',
    'ko' => 'Korean',
    'pl' => 'Polish',
    'pt' => 'Portuguese',
    'es' => 'Spanish',
    'tr' => 'Turkish',
    'sv' => 'Swedish'
    ]
])
->add('keys',   ['rows'=> $len,'type' => 'textarea', 'value' => $keys ])
->add('phrases',['rows'=> $len,'type' => 'textarea', 'value' => $phrases ])
->add('trans',  ['rows'=> $len,'type' => 'textarea', 'value' => ''])

->add('fill_data', [
    'type'  => 'button', 
    'label' => 'Fill phrases', 
    'id'    => 'fill-data'
])
->add('translate_data', ['type' => 'button', 'label' => 'Translate phrases', 'id' => 'translate-data'])
->add('update', ['type' => 'button', 'label' => 'Save translation', 'id' => 'update'])
        ;
    }
}

class rowForm extends dmForm {
    function __construct($table, $data_row) {
        $this
        ->add('check',[
            'type'  =>'checkbox',
            'class' =>'check-item',
            'value' => true
        ])
        ->add('table',[
            'value' => $table
        ])
        ->add('field',[
            'value' => $data_row['field']
        ])
        ;
    }
}