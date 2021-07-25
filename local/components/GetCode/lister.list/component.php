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
        $res = CIBlockElement::GetByID($a["UF_ITEM_ID"]);
        
        $arResult['ITEMS'][$a['UF_CO_ID']]['CO_SUMM'] = $a['UF_CO_SUMM'];
        $arResult['ITEMS'][$a['UF_CO_ID']]['CO_DATE'] = $a['UF_CO_DATE'];
        $arResult['ITEMS'][$a['UF_CO_ID']]['STATUS'] =  = OffersManager::getStatus($a['UF_STATUS']); 
        $arResult['ITEMS'][$a['UF_CO_ID']]['VALIDATY'] = $a['UF_VALIDATY'];
        $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][] = $res->GetNext();
        //UF_ITEM_ID
        //if($ar_res = $res->GetNext())

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
