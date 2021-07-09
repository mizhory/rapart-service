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

$httpApp = \Bitrix\Main\Application::getInstance();
$context = $httpApp->getContext();
$request = $context->getRequest();

if(!Loader::includeModule('iblock')) {
  ShowError(getMessage('TITLE'));
  return;
}

if(!$USER->isAuthorized()) {
  ShowError(getMessage('NOT_AUTH'));
  return;
}

$userID = intval($USER->getID());

if(!$arParams['CACHE_TIME'] || $arParams['CACHE_TIME']>3600 || !isset($arParams['CACHE_TIME']))
	$arParams['CACHE_TIME'] = 3600;

if($this->startResultCache()) {
    $order_id = $request->getQuery('ORDER_ID');

	
	$this->IncludeComponentTemplate();
} else {
	$this->AbortResultCache();
}

if($arParams['TITLE']) {
    $title = $arParams['TITLE'];
} else {
    $title = getMessage('TITLE');
}
$APPLICATION->SetTitle($title);