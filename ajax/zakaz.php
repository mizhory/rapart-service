<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(!\Bitrix\Main\Loader::IncludeModule("iblock"))   exit;
if(!\Bitrix\Main\Loader::IncludeModule("sale"))     exit;
if(!\Bitrix\Main\Loader::includeModule('sale'))     exit;
if(!\Bitrix\Main\Loader::includeModule('catalog'))  exit;

use \GetCode\Entity\CustomerOrderTable,
	\GetCode\Entity\CustomerOfferTable,
	\GetCode\Entity\OrderTypesTable,
	\GetCode\Entity\StatusesTable,
    \GetCode\Manager\OffersManager;

global $USER, $APPLICATION;

$res = \CSaleBasket::GetList(
    array(
        "NAME" => "ASC",
        "ID" => "ASC"
    ),
    array(
        "FUSER_ID" => \CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL"
    ),
    false,
    false,
    array("ID",
        "CALLBACK_FUNC",
        "MODULE",
        "PRODUCT_ID",
        "QUANTITY",
        "DELAY",
        "CAN_BUY",
        "PRICE",
        "WEIGHT")
);
$items = false;
while($ret = $res->fetch()){
    $items[] = [$ret["PRODUCT_ID"], $ret['QUANTITY']];
}

$e = CustomerOrderTable::add([
    'UF_USER_ID' => $USER->getID(),
    'UF_TIMESTAMP'  => time(),
    'UF_OFFERS' => serialize($items),
    'UF_OFFER' => 1,
    'UF_NAME' => 'К'.time().'-'.date('m').'/'.date('y')
]);

\CSaleBasket::DeleteAll(\CSaleBasket::GetBasketUserID());
?>
<script>window.location.href="/personal/";$(location).attr('href',"/personal/");</script>