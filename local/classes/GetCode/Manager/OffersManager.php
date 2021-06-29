<?php
namespace GetCode\Manager;

use Bitrix\Main\Loader;

class OffersManager
{
    const IBLOCK_ID = 24;
    private static function init() {
        Loader::includeModule('iblock');
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
            $ret[$f['ID']] = $f;
        }
        return $ret;
    }
}