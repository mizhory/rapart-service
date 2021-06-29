<?php
namespace GetCode\Manager;

use Bitrix\Main\Loader;

class OffersManager
{
    const IBLOCK_ID = 24;
    const CATALOG_GROUP_ID = 3;
    private static function init() {
        Loader::includeModule('iblock');
    }
    public static function getElementsByIblock($inner = false) {
        if(is_bool($inner)) return null;
        static::init();
        $arSelect = ['*', 'CATALOG_GROUP_ID_'.static::CATALOG_GROUP_ID];
        $arFilter = ['IBLOCK_ID' => static::IBLOCK_ID, 'ID' => $inner];
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
        $ret = null;
        while($r=$res->GetNextElement()){
            $f = $r->GetFields();
            $f['PROPERTIES'] = $r->GetProperties();
            $ret[$f['ID']] = $f;
        }
        return $ret;
    }
}