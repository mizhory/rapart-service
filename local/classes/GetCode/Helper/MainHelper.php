<?
namespace GetCode\Helper;

use Bitrix\Main\Loader;

Class MainHelper {
	public static function getXMLIDUser() {
		global $USER;
		if(!Loader::IncludeModule('iblock')) return false;
		$rsUsers = \CUser::GetList(($by="ID"), ($order="ACS"), ["ID"=>$USER->GetID()],[]);
		$arUser = $rsUsers->Fetch();
		return $arUser['XML_ID'];
	}
}