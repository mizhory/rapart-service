<?
use Bitrix\Sale;
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
$productID = intval($_REQUEST["id"]);
if ($productID > 0)
{
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("catalog");
    CModule::IncludeModule("sale");
    CSaleBasket::Delete($productID);
}
?>