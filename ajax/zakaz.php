<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

\Bitrix\Main\Loader::IncludeModule("iblock");
\Bitrix\Main\Loader::IncludeModule("sale");
\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('catalog');

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
    $items[] = $ret["PRODUCT_ID"];
}

$e = CustomerOrderTable::add([
    'UF_USER_ID' => $USER->getID(),
    'UF_TIMESTAMP'  => time(),
    'UF_OFFERS' => serialize($items),
    'UF_OFFER' => 0,
]);

?>
<script>window.location.href="/personal/cart/?order=yes";$(location).attr('href',"/personal/cart/?order=yes");</script>