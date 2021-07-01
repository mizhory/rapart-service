<?php
namespace GetCode\Manager;

use Bitrix\Main\Loader,
	GetCode\Entity\StatusesTable;

class OffersManager
{
    const IBLOCK_ID = 24;
    const CATALOG_GROUP_ID = 3;
    private static function init() {
        Loader::includeModule('iblock');
        Loader::includeModule('catalog');
    }
    public static function getElementsByIblock($inner = false) {
        if(is_bool($inner)) return null;
        static::init();
        $arSelect = ['*'];
        $arFilter = ['IBLOCK_ID' => static::IBLOCK_ID, 'ID' => $inner];
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
				'NAME' => 'UF_NAME',
				'PICTURE' => 'UF_STATUS_IMG'
			];
		}
		return null;
	}
}