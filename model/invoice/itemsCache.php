<?php
class itemsCache extends dmModel {
    function __construct()
    {
        parent::__construct();
        $this->_table_key = 'idcache';
    }
    static function GetTableName() {
        return 'items_cache';
    }
    static function deleteAll()
    {
        $qb = self::createQueryBuilder('i');
        $result = $qb->delete()
            // ->getQuery()
            ->getResult();
        return $result;
    }
    static function checkToRemove($invoice)
    {
        $items = self::findAll();
        if ($items && count($items) > 0 && $items[0]['invoice_id'] == $invoice['id']) {
            self::deleteAll();
        }
    }
    static function checkToPreserve($invoice = null)
    {
        $items = self::findAll();
        if ($items && count($items) > 0) {
            if ($items[0]['invoice_id'] !== $invoice['id']) {
                self::deleteAll();
            }
        }
    }
    static function findAllInit()
    {
        return self::createQueryBuilder('i')
            ->andWhere("NOT (i.level = '+' or i.score = '-')")
            ->getQuery()
            ->getResult()
        ;
    }




}



