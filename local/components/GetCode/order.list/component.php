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
	\GetCode\Entity\StatusesTable,
    \GetCode\Manager\OffersManager;


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

$userID = intval($USER->getID());

if(!$arParams['CACHE_TIME'] || !isset($arParams['CACHE_TIME']))
	$arParams['CACHE_TIME'] = 36000000;

if($this->startResultCache()) {
    if(isset($arParams['PRIZNAK'])){
        $priznak = 1;
        if($arParams['PRIZNAK'] == 'order')
            $priznak = 0;
    }
	$r = CustomerOrderTable::getList([
			'select' => ['*'],
			'order'  => ['ID' => 'ASC'],
			'filter' => ['UF_USER_ID' => $userID, 'UF_OFFER' => $priznak]
		]);
	while($s = $r->fetch()){
		$arResult['ITEMS'][$s['ID']] = $s;
	}
	$offers = false;
	foreach($arResult['ITEMS'] as $k=>$r) {
	    if(is_array(unserialize($r['UF_OFFERS']))&&count(unserialize($r['UF_OFFERS']))>0){
	        $offers[$r['ID']] = unserialize($r['UF_OFFERS']);
        }
    }
	if(is_array($offers)) {
	    foreach($offers as $k=>$r) {
	        $arResult['ITEMS'][$k]['ELEMENTS'] = OffersManager::getElementsByIblock($r);
        }
    }
	foreach($arResult['ITEMS'] as $k=>$arItems) {
	    $p = 0.0;
	    foreach($arItems['ELEMENTS'] as $e=>$arElements) {
	        $p = $p+$arElements['PRICE']['PRICE'];
	        $currency = $arElements['PRICE']['CURRENCY'];
        }
		$arResult['ITEMS'][$k]['UF_STATUS'] = OffersManager::getStatus($arResult['ITEMS'][$k]['UF_STATUS']['VALUE']);
        $arResult['ITEMS'][$k]['PRICE'] = $p . ' ' . $currency;
    }
} else {
	$this->AbortResultCache();
}

$this->IncludeComponentTemplate();
if($arParams['TITLE']) {
    $title = $arParams['TITLE'];
} else {
    $title = getMessage('TITLE');
}
$APPLICATION->SetTitle($title);