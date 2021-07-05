<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(!$_REQUEST['exec'] || $_REQUEST['exec'] != 'true') die;

use \Bitrix\Main\Loader,
	\GetCode\Entity\CustomerOrderTable,
	\GetCode\Entity\CustomerOfferTable,
	\GetCode\Entity\OrderTypesTable,
	\GetCode\Entity\StatusesTable,
    \GetCode\Manager\OffersManager;
$httpApp = \Bitrix\Main\Application::getInstance();
$context = $httpApp->getContext();
$request = $context->getRequest();

$action = $request->getPost('act');

if($action == 'getDetailOrder'){
	$order_id = $request->getPost('oid');
	
	$e = CustomerOrderTable::getList(['select' => ['*'], 'filter'=> ['ID' => $order_id]]);
	if($a = $e->fetch()){
		if(!is_array($a['UF_OFFERS'])){
			$a['UF_OFFERS'] = unserialize($a['UF_OFFERS']);
		}
		$a['ELEMENTS'] = OffersManager::getElementsByIblock($a);

		$p = 0.0;
		foreach($a['ELEMENTS'] as $e=>$arElements) {
			$p = $p+$arElements['PRICE']['PRICE'];
			$currency = $arElements['PRICE']['CURRENCY'];
		}

		echo '
			<div class="">
				<h3>Заказ: '.$a['UF_NAME'].'</h3>
				<div>Кол-во товаров:'.count($a['UF_OFFERS']).'</div>
				<div>Сумма заказа: '.$p.' '.$currency.'</div></div>
			</div>';
		die;
	}

} elseif($action == ''){
} else die;