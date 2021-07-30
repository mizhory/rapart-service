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

$ID = $request->getQuery('ID');
$BY = $request->getQuery('BY');
$template = 'template';
if($arParams['PRIZNAK'] == 'KP'){
    if($BY == 'ELEMENT'){
        $arFilter = [
            'UF_ITEM_ID' => $ID
        ];
    } else {
        $arFilter = [
            'UF_ORDER_ID' => $ID
        ];
    }
    $res = CustomerOfferTable::getList([
        'select' => ['*'],
        'order' => ['ID' => 'ASC'],
        'filter' => $arFilter
    ]);
    while($arRet = $res->fetch()){
        if($BY == 'ELEMENT'){
            $arResult['ELEMENT'] = $arRet;
        } else {
            $arResult['ITEMS'][$arRet['UF_CO_ID']][] = $arRet;
        }
    }
    $template = 'kp_tpl';
} elseif($arParams['PRIZNAK'] == 'INVOICE'){
    $res = CustomerOfferTable::getList([
        'select' => ['*'],
        'order' => ['ID' => 'ASC'],
        'filter' => ['UF_ORDER_ID' => $ID]
    ]);
    while($arRet = $res->fetch()){
        $arKPID[] = $arRet['ID'];
    }

    $res = CustomerInvoiceTable::getList(['select' => ['*'], 'order' => ['ID' => 'ASC'], 'filter' => ['UF_KP_ID' => $arKPID]]);

    while($arRet = $res->fetch()){
        $arResult['ITEMS'][$arRet['UF_KP_ID']][] = $arRet;
    }
    $template = 'invoice_tpl';
}

$this->IncludeComponentTemplate($template);