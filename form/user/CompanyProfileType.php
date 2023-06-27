<?php
// namespace form\user;
// use dmForm;

class CompanyProfileType extends dmForm
{
    function __construct( $company = null )
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id]);
        $this->fields = [
'business'  => ['label' => 'Business Name'],
'address'   => ['label' => 'Address'],
'postcode'  => ['label' => 'Post code'],
'city'      => ['label' => 'City'],
'telephone' => ['label' => 'Phone'],
'mobilephone'=>['label' => 'Mobile Phone'],
'email'     => ['label' => 'E-Mail'],
'url'       => ['label' => 'URL'],
'cid'       => ['label' => 'Time Tracking App ID'],
'trackingapp'=> [
    'name' => 'trackingapp',
    'type' => 'combo',
    'label' => 'Time Tracking App',
    'source'=> 'Trackingapp',
],
'accountapp'=> [
    'name'  => 'accountapp',
    'label' => 'Accounting software',
    'type'  => 'combo',
    'source'=> 'Accounting',
],
'accountlogin'  => ['label' => '(Accounting) Login'],
'accountpass'   => ['label' => '(Accounting) Password'],
'accountkey1'   => ['label' => '(Accounting) Security key-1'],
'accountkey2'   => ['label' => '(Accounting) Security key-2'],
'accountparm1'  => ['label' => '(Accounting) Parameter-1'],
'accountparm2'  => ['label' => '(Accounting) Parameter-2'],
'isrounded'     => ['label' => 'Round hours'],
'removehtml'    => ['label' => 'Remove URLs/HTML from Tasks'],
'startdate'     => ['label' => 'Start Time Tracking Import'],
'cronon'        => ['label' => 'Cron ON/OFF', 'name'=>'cronon', 'type'=>'checkbox'],
// ->add('cronstart')
'cronline'      => ['label' => 'Cron command line'],
'cronmin'       => ['label' => 'Minutes (0-59)'],
'cronhour'      => ['label' => 'Hour (0-23)', 'type' => 'number'],
'cronday'       => ['label' => 'Day (1-31)'],
'cronmon'   => ['label' => 'Month (1-12)'],
'crondow'   => ['label' => 'Day of the week (0-6)'],
'croncmd'   => ['label' => 'Command (fetchdata)'],
'vatcoeff'  => ['label' => 'VAT %','type'=>'number'],
'logoimage' => [
    'name' => 'logoimage',
    'label' => 'Company logo file (png,jpg file)',
    'type' => 'file',
    'file_type' => ".jpg, .jpeg, .png", 
    'data' => 'empty.png', 
    'value' => 'more_files.png'],
];

        $this->SetData($company);
    }
}