<?php
namespace GetCode\Manager;

use GetCode\Entity\CustomerInvoiceTable;
use GetCode\Entity\CustomerOrderTable,
    GetCode\Entity\CustomerOfferTable;

class OrderManager
{
    public static function getOrderIDbyKPID($kp_id = false) {
        if(is_bool($kp_id)) return null;

        $e = CustomerOfferTable::getList(['select' => ['UF_ORDER_ID'], 'filter' => ['ID' => $kp_id], 'order' => ['ID' => "ASC"]]);
        if($d=$e->fetch()){
            if(isset($d['UF_ORDER_ID'])){
                $l = CustomerOrderTable::getList(['select' => ['*'], 'filter' => ['ID' => $d['UF_ORDER_ID']], 'order' => ['ID' => 'ASC']]);
                if($a=$l->fetch())
                    return $a;
            }
        }
        return null;
    }
    public static function getInvoiceIDbyORDERID($oid = false) {
        if(is_bool($oid)) return null;

        $e = CustomerOfferTable::getList(['select' => ['ID'], 'filter' => ['UF_ORDER_ID' => $oid], 'order' => ['ID' => "ASC"]]);
        if($d=$e->fetch()){
            if(isset($d['ID'])){
                $l = CustomerInvoiceTable::getList(['select' => ['*'], 'filter' => ['UF_KP_ID' => $d['ID']], 'order' => ['ID' => 'ASC']]);
                while($s=$l->fetch()){
                    $a[] = $s;
                }
                    return $a;
            }
        }
        return null;
    }
}