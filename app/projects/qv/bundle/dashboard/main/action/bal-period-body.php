<?php

// public function periodBalancetBody(
//     Request $request, 
//     InvoiceGoodsRepository $itemsGoods, 
//     ClientRepository $customers
// ) 
// {
    $boss       = User::getUser();
    $company    = User::getCompany($boss);
    if (!$company) {
        if (!$company) throw new \Exception('Define company!');
    }

    $period = REQUEST::getParam('period');

    list($startDay, $endDay, $say_period) = ToolKit::getPeriodParams($period);
    if($period == 'this-month') {
        $period = (new DateTime())->format('Y-m');
    } else {
        $period = (new DateTime('first day of previous month'))->format('Y-m');
    }
    $disbalance = InvoiceGood::doTimeInvoiceMatch($company, $period);

    $params = [
    'disbalance' => $disbalance 
    ];
    $t_body = module_partial('main/include/dash-disbalance-body.html.php', $params, true);
    $contents = ['t_body' => $t_body, 'say_period' => $say_period ];

    Json_Response($contents);
