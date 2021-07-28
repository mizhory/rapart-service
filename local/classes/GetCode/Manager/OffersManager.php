<?php
namespace GetCode\Manager;

use Bitrix\Main\Loader,
	GetCode\Entity\StatusesTable;
use GetCode\Entity\CustomerOfferTable;

class OffersManager
{
    const IBLOCK_ID = 24;
    const CATALOG_GROUP_ID = 3;
    private static function init() {
        Loader::includeModule('iblock');
        Loader::includeModule('catalog');
    }
    public static function checkKP($order_id=false, $element_id=false) {
        if(is_bool($order_id) || is_bool($element_id)) return null;

        $arFilter = ['UF_ORDER_ID' => $order_id, 'UF_ITEM_ID' => $element_id];
        $e = CustomerOfferTable::getList(['select' => ['ID'], 'order'=>['ID' => 'ASC'], 'filter' => $arFilter]);

        if($d = $e->fetch())
            return isset($d['ID']);

        return false;
    }
    public static function getElementsByIblock($inner = false) {
        if(is_bool($inner)) return null;
        static::init();
        foreach($inner as $k=>$r){
            $_inner[] = $r['ID'];
        }
        $arSelect = ['*'];
        $arFilter = ['IBLOCK_ID' => static::IBLOCK_ID, 'ID' => $_inner];
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
        $ret = null;
        while($r=$res->GetNextElement()){
            $f = $r->GetFields();
            $f['PROPERTIES'] = $r->GetProperties();
            $db_res = \CPrice::GetList(
                [],
                array(
                    "PRODUCT_ID" => $f['ID'],
                    "CATALOG_GROUP_ID" => static::CATALOG_GROUP_ID
                )
            );
            if ($ar_res = $db_res->Fetch())
            {
                $f['PRICE'] = $ar_res;
                $f['PRICE']['CURRENCY_VALUE'] = CurrencyFormat($ar_res["PRICE"], $ar_res["CURRENCY"]);
            }
            $ret[$f['ID']] = $f;
        }
        foreach($ret as $k=>$r) {
            foreach($inner as $d=>$a) {
                if($r['ID'] == $a['ID']){
                    $ret[$k] = array_merge($ret[$k], $a);
                }
            }
        }
        return $ret;
    }
	public static function getStatus($status_id = false) {
		if(is_bool($status_id)) return null;
		$status_id = intVal($status_id);
		
		$r = StatusesTable::getList([
			'select' => ['*'],
			'order' => ['ID' => 'ASC'],
			'filter' => ['ID' => $status_id]
			]);
		if($e=$r->fetch()) {
			return [
				'NAME' => $e['UF_NAME'],
				'PICTURE' => \CFile::GetPath($e['UF_STATUS_IMG'])
			];
		}
		return null;
	}
}