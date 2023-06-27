<?php
    $company   = Repository::GetCompany();
    $keys = Trackingmap::findCredentials('company', $company, 'Teamwork', $company['id']);
    if($keys) {
        $site_root = $keys['key1']; //'ibl82';
    } else {
        $site_root = '';
    }

    if(! $invoice) { // new invoice
        $invoice = Invoice::GetDefault();
    }
    $Items = InvoiceGoodRepository::getInvoiceItems($invoice);
    $count = count($Items);
    $invoice['rows'] = $Items;

    $aproj = Tasklist::findBy(['customer_id' => $invoice['customer_id']]);
    $projs = [];

    // #Bulat 2021-05-03
    if (empty($aproj)) { // in case of isMultyCustomer
        foreach ($Items as $key => $value) {
            $proj = Tasklist::find($value['project_id']);
            $projs[$proj['id']] = $proj['name'];
        }
    } else {

        foreach ($aproj as $key => $value) {
            $projs[$value['id']] = $value['name'];
        }
    }

    $form = new InvoiceType( $invoice, [ 'proj_choices' => $projs ]);
