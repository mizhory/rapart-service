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


Loc::loadMessages(__FILE__);

$httpApp = \Bitrix\Main\Application::getInstance();
$context = $httpApp->getContext();
$request = $context->getRequest();

$arResult['ORDER_ID']	= $ORDER_ID		= $request->getQuery('ORDER_ID');
$arResult['DETAIL']		= $DETAIL		= $request->getQuery('DETAIL');
$arResult['VIEW_KP']	= $VIEW_KP		= $request->getQuery('VIEW_KP');
$arResult['VIEW_ORDER'] = $VIEW_ORDER	= $request->getQuery('VIEW_ORDER');


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

if(isset($arParams['PRIZNAK'])){
	$priznak = 1;
	if($arParams['PRIZNAK'] == 'order')
		$priznak = 0;
}

$arFilter = ['UF_USER_ID' => $userID, 'UF_OFFER' => $priznak];
if($request->isPost()){
	$p_query = $request->getPost('QUERY');
	$p_status = $request->getPost('STATUSES');
	$p_type = $request->getPost('TYPES');

	$arResult['F_QUERY'] = $p_query;
	$arrFilter = [];

	if($p_query && strlen($p_query)>0){
		$arrFilter['UF_NAME'] = "%" . $p_query . "%";
	}
	if($p_status && intval($p_status)){
		$arrFilter['UF_STATUS'] = $p_status;
	}
	if($p_type && intval($p_type)){
		$arrFilter['UF_ORDER_TYPES'] = $p_type;
	}
        
	$arFilter = array_merge($arFilter, $arrFilter);
}
if(intVal($ORDER_ID)){
	$arFilter['ID'] = $ORDER_ID;
}

$sort = $request->getQuery('SORT');
$col = $request->getQuery('COL');
$search_string = $request->getQuery('q');

if((isset($sort) && strlen($sort)>0) && (isset($col) && strlen($col)>0)) {
    if($col == '1') {
        if($arParams['PRIZNAK'] == 'order')
            $s_col = 'UF_NAME';
        else
            $s_col = 'UF_NAME';
    } elseif($col == '2') {
        if($arParams['PRIZNAK'] == 'order')
            $s_col = 'UF_TIMESTAMP';
        else
            $s_col = 'UF_TIMESTAMP';
    } elseif($col == '3') {
        if($arParams['PRIZNAK'] == 'order')
            $s_col = 'UF_PRIORITY';
        else
            $s_col = 'UF_PRIORITY';
    } elseif($col == '4') {
        if($arParams['PRIZNAK'] == 'order')
            $s_col = 'UF_USER_ID';
        else
            $s_col = 'UF_USER_ID';
    } elseif($col == '5') {
        if($arParams['PRIZNAK'] == 'order')
            $s_col = 'UF_STATUS';
        else
            $s_col = 'UF_STATUS';
    } else {
        $s_col = 'ID';
    }
    $arOrder = [$s_col => ($sort=='asc')?'ASC':'DESC'];
} else {
    $arOrder = ['ID' => 'ASC'];
}
if($sort == 'asc') {
    $arResult['SORT_NAME'] = 'Убыванию';
    $arResult['SORT_METHOD'] = 'desc';
} else {
    $arResult['SORT_NAME'] = 'Возрастанию';
    $arResult['SORT_METHOD'] = 'asc';
}

$arResult['COL_SORT'] = $col;

$nav = new \Bitrix\Main\UI\PageNavigation("nav-order-list-component");
$nav->allowAllRecords(true)
    ->setPageSize(30)
    ->initFromUri();
$arResult['NAV_OBJECT'] = $nav;

if(strlen($search_string)>=1) {
    $arFilter = array_merge($arFilter, ['UF_NAME' => '%'.$search_string.'%', ]);
}

$r = CustomerOrderTable::getList([
			'select' => ['*'],
			'order'  => $arOrder,
			'filter' => $arFilter,
            "offset" => $nav->getOffset(),
            "limit" => $nav->getLimit(),
]);

	while($s = $r->fetch()){
		$arResult['ITEMS'][$s['ID']] = $s;
		$arResult['ITEMS'][$s['ID']]['UF_OFFERS'] = unserialize($s['UF_OFFERS']);
	}


	foreach($arResult['ITEMS'] as $k=>$r) {
	    if(is_array(unserialize($r['UF_OFFERS']))&&count(unserialize($r['UF_OFFERS']))>0){
	        $arResult['ITEMS'][$k] = unserialize($r['UF_OFFERS']);
        }
    }
		
		foreach($arResult['ITEMS'] as $k=>$e){
			$arResult['ITEMS'][$k]['ELEMENTS'] = OffersManager::getElementsByIblock($e['UF_OFFERS']);
			foreach($arResult['ITEMS'][$k]['ELEMENTS'] as $r){
				$arResult['ITEMS'][$k]['ELEMENTS'][$r['ID']] = $r;
				$arResult['ITEMS'][$k]['ELEMENTS'][$r['ID']]['COUNT'] = $counts[$r[$k]['ID']];
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
	$arFilter = [];
#UF_CO_ID
	$e = CustomerOfferTable::getList(['select' => ['*'], 'filter' => $arFilter, 'order' => ['ID'=>'ASC']]);
	while($s = $e->fetch()){
		$s['STATUS'] = OffersManager::getStatus($s['UF_STATUS']);
		$arOffers[$s['UF_ORDER_ID']][] = $s;
	}
/*	foreach($arResult['ITEMS'] as $k=>$r){
		$arResult['ITEMS'][$k]['KP'] = $_[$r['ID']];
	}
*/
    foreach($arResult['ITEMS'] as $z=>$arItems){
        foreach($arOffers as $k=>$arOffer){
            if($arItems['ID'] == $arOffer['UF_ORDER_ID']) {
                $arResult['ITEMS'][$z]['KP'][] = $arOffer;
            }
        }
    }

	if($arParams['PRIZNAK'] == 'order'){
		$z = StatusesTable::getList(['select' => ['ID', 'UF_NAME'], 'order' => ['ID' => 'ASC']]);
		while($k=$z->fetch()){
			$arResult['FILTER']['STATUSES'][$k['ID']] = [
				'ID' => $k['ID'],
				'NAME' => $k['UF_NAME']
				];
			if($p_status == $k['ID'])
				$arResult['FILTER']['STATUSES'][$k['ID']]['selected'] = 'true';
		}
		$z = OrderTypesTable::getList(['select' => ['ID', 'UF_NAME'], 'order' => ['ID' => 'ASC']]);
		while($k=$z->fetch()){
			$arResult['FILTER']['TYPES'][$k['ID']] = [
				'ID' => $k['ID'],
				'NAME' => $k['UF_NAME']
				];
			if($p_type == $k['ID'])
				$arResult['FILTER']['TYPES'][$k['ID']]['selected'] = 'true';
		}
	}

	$this->IncludeComponentTemplate();
if($arParams['TITLE']) {
    $title = $arParams['TITLE'];
} else {
    $title = getMessage('TITLE');
}
$APPLICATION->SetTitle($title);
