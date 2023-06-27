<?php
$page = REQUEST::getParam('page', 1);

$default_limit = 10000;

$form = new OpenTasksReportType;

include_once( ROUTER::ModulePath().'include/rules-emails.html.php');
// $rules = [];
// $workers = [];
// $rules_ids      = [];
// $email_to_ids   = [];

// $tag_name = 'open tasks';
// $rule_list = 'rule-list';
// $rule_list = Rulestw::findOneBy([
//     'company'   => $company,
//     'name'      => $tag_name, 
//     'field'     => $rule_list]);

// $email_list = 'email-list';
// $email_list = Rulestw::findOneBy([
//     'company'   => $company,
//     'name'      => $tag_name, 
//     'field'     => $email_list
// ]);

// if($rule_list) {
//     $rules_ids = explode(',', $rule_list['value']);
// }
// if($email_list) {
//     $email_to_ids = explode(',', $email_list['value']);
// }
// if($rules_ids) {
//     // $form_data = $form->getData();
//     $options = OpenTasksReportType::getRules();
//     // $options = array_flip($options);
//     foreach ($rules_ids as $rule_id) {
//         if (isset($options[$rule_id])) {
//             $rules[] = ['id'=>$rule_id, 'name'=>$options[$rule_id]];
//         }
//     }
// }
// if($rules_ids) {
//     foreach ($email_to_ids as $worker_id) {
//         $worker = User::find($worker_id);
//         if ($worker) {
//             $workers[] = $worker;
//         }
//     }
// }

$object         = ['id'=> 1, 'name'=> 'Open tasks report'];
$title          = 'Open tasks report';
$vis_workers    = $workers;
$vis_rules      = $rules;
$Items          = [];
$titleplus      = '';
$isnew          = false;
$root = 'qv.task';
$rootpages = 'qv.task.index';
$rootindex = 'qv.task.index';

// return $render('tasks/index-opened.html.twig', $parms);
