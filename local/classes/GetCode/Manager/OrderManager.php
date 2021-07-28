<?php
namespace GetCode\Manager;

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
}