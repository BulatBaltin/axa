<?php

class Invoice extends dmModel {

    // removeInvoice
    static function toString( $invoice ) {

        if(!$invoice['id']) return 'New Invoice';
        return $invoice['doc_number'] . " /" . date('d.m.Y',strtotime($invoice['doc_date']));
    }    


    static function deleteInvoice( $invoice, $delStatus = 'removed')
    {
        $id = is_array($invoice) ? $invoice['id'] : $invoice;

        $items = InvoiceGood::findBy([ 'invoice_id' => $id ]);

        // self::removeCache($invoice);

        foreach ($items as $item) {
            if(InvoiceGood::IsInitEntry($item)) {
                $item['invoice_id'] = null;
                $item['quantity'] = $item['quantityplan'];
                $item['quantitylost'] = 0;
                $item['status'] = $delStatus;

                InvoiceGood::Commit($item);
            } else {
                InvoiceGood::Delete($item);
            }
        } 

        Invoice::Delete( $id );
        return;
    }

    static function removeCache(&$invoice)
    {
        // /** @var ItemsCacheRepository */
        // $repo = $em->getRepository(ItemsCache::class);
        ItemsCache::checkToRemove($invoice);
    }
    static function addInvoiceitems( &$invoice, &$invoiceitem)
    {
        if(empty($invoice['rows'])) {
            $invoice['rows'] = []; //new ArrayCollection();    
        }
        $invoiceitem['invoice_id'] = $invoice['id'];
        $invoice['rows'][] = $invoiceitem; //new ArrayCollection();    

        return;
    }

    static function getTime(array $list)
    {
        if(count($list) > 0) {
            $df = date('d/m/Y H:i:s', strtotime($list[0]['doc_date']));
        } else {
            $df = '01/01/2022';
        }
        return $df;
    }


}