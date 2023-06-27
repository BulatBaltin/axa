<?php

// $county = Country::GetDefault();
// $county['name'] = 'Spain';
// $county['code'] = 'SP';
// Country::Commit($county);
// $ret = Country::GetLastID();
// var_dump($ret);
// die;

$boss = User::GetUser();
$company = User::GetCompany($boss);
// throw new Exception('Test from general');
$root = 'qv.company.general';

$form   = new CompanyGeneralType($company);
$form2  = new CompanyUnmappedType;

$importRows = Transactions::getImportLayout($company);
// dd($importRows);

$title = 'Settings';
$subtitle = 'Change some general settings like rounding hours below';
$subtitle2  = 'General settings';
$object  = $company;
$company_tag = true;

// die;
// return $this->render('company/general.html.twig', $parms);
