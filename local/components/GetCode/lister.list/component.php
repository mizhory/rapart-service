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
	\GetCode\Entity\CustomerInvoiceTable,
	\GetCode\Entity\OrderTypesTable,
	\GetCode\Entity\StatusesTable,
    \GetCode\Manager\OffersManager;
use GetCode\Helper\StepingHelper;


global $USER, $APPLICATION;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
  die();

Loader::includeModule('iblock');

Loc::loadMessages(__FILE__);

$httpApp = \Bitrix\Main\Application::getInstance();
$context = $httpApp->getContext();
$request = $context->getRequest();

if($arParams['PRIZNAK'] == 'KP'){
    $e = CustomerOfferTable::getList(['select' => ['*'], 'filter' => ['UF_USER_ID' => $USER->getID()], 'order' => ['ID' => 'DESC']]);
    while($a = $e->fetch()){
        if(intval($a["UF_ITEM_ID"])){
            $arResult['ITEMS'][$a['UF_CO_ID']]['CO_SUMM'] = $a['UF_CO_SUMM'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['CO_DATE'] = $a['UF_CO_DATE'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['STATUS'] =  OffersManager::getStatus($a['UF_STATUS']);
            $arResult['ITEMS'][$a['UF_CO_ID']]['VALIDATY'] = $a['UF_VALIDATY'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]] = CIBlockElement::GetByID($a["UF_ITEM_ID"])->fetch();
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['SUMM'] = $a['UF_SUMM'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['STAVKA_NDS'] = $a['UF_STAVKA_NDS'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['SUMM_NDS'] = $a['UF_SUMM_NDS'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['SUMM_SNDS'] = $a['UF_SUMM_SNDS'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['STATUS'] = \GetCode\Manager\StatusManager::getFileByStatusID($a['UF_E_STATUS']);
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['PRICE'] = $a['UF_PRICE'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['DELIVERY_TIME'] = $a['UF_DELIVERY_TIME'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['COUNT'] = $a['UF_COUNT'];
        }

    }
} elseif($arParams['PRIZNAK'] == 'INVOICE'){
    $e = CustomerInvoiceTable::getList(['select' => ['*'], 'filter' => ['UF_USER_ID' => $USER->getID()], 'order' => ['ID' => 'DESC']]);
    while($a = $e->fetch()){
        $arResult['ITEMS'][$a['ID']] = $a;
    }
}

$this->IncludeComponentTemplate();
if($arParams['TITLE']) {
    $title = $arParams['TITLE'];
} else {
    $title = getMessage('TITLE');
}
$APPLICATION->SetTitle($title);
