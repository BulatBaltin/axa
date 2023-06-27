<?php
$page = REQUEST::getParam('page', 1);
$default_limit = 10000;
$form = new OpenTasksReportType;

include_once( ROUTER::ModulePath().'include/rules-emails.html.php');

$object         = ['id'=> 1, 'name'=> 'Not mapped tasks report'];
$title          = 'Not mapped tasks report';
$vis_workers    = $workers;
$vis_rules      = $rules;
$Items          = [];
$titleplus      = '';
$isnew          = false;
$root = 'qv.task';
$rootpages = 'qv.task.index';
$rootindex = 'qv.task.index';

// return $this->render('tasks/index-not-mapped.html.twig', $parms);
