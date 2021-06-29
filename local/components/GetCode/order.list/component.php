<?
/**
 * Bitrix vars
 *
 * @var CBitrixComponent $this
 * @var array            $arParams
 * @var array            $arResult
 *
 * @var CDatabase        $DB
 * @var CUser            $USER
 * @var CMain            $APPLICATION
 */

use \Bitrix\Main,
	\Bitrix\Main\Web,
	\Bitrix\Main\Loader,
	\Bitrix\Main\Application,
	\Bitrix\Main\Localization\Loc,
	\GetCode\Entity\CustomerOrderTable,
	\GetCode\Entity\CustomerOfferTable,
	\GetCode\Entity\OrderTypesTable,
	\GetCode\Entity\StatusesTable;


global $USER, $APPLICATION;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
  die();

//ID компонента
//$cpId = $this->getEditAreaId($this->__currentCounter);
//Объект родительского компонента
//$parent = $this->getParent();
//$parentPath = $parent->getPath();

Loc::loadMessages(__FILE__);

if(!Loader::includeModule('iblock')) {
  ShowError(getMessage('TITLE'));
  return;
}

if(!$USER->isAuthorized()) {
  ShowError(getMessage('NOT_AUTH'));
  return;
}

$userID = $USER->getID();

if(!$arParams['CACHE_TIME'] || !isset($arParams['CACHE_TIME']))
	$arParams['CACHE_TIME'] = 36000000;

if($this->startResultCache()) {
	$r = CustomerOrderTable::getList([
			'select' => ['*'],
			'order'  => false,
			'filter' => ['UF_USER_ID' => "".$userID.""]
		]);
	while($s = $r->fetch()){
		$arResult['ITEMS'][] = $s;
	}
} else {
	$this->AbortResultCache();
}

$this->IncludeComponentTemplate();

$APPLICATION->SetTitle(getMessage('TITLE')); 