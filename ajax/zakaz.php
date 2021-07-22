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
    \GetCode\Manager\OffersManager,
    \Bitrix\Main\Application,
    \Bitrix\Main\Context,
    \Bitrix\Main\Loader;

global $USER, $APPLICATION;
/*
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
*/
$basket = \Bitrix\Sale\Basket::loadItemsForFUser(
        $USER->getId(),
        \Bitrix\Main\Context::getCurrent()->getSite()
);

$request = Application::getInstance()->getContext()->getRequest();

$siteId = Context::getCurrent()->getSite();

$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());

$currency = \Bitrix\Currency\CurrencyManager::getBaseCurrency();



if(count($basket)<=0)

    $arErrors[]="Ваша корзина пуста";



$userId = $USER->getID();


$deliveryId = 1;
// ID службы доставки, можно также использовать \Bitrix\Sale\Delivery\Services\EmptyDeliveryService::getEmptyDeliveryServiceId()



    if($order = \Bitrix\Sale\Order::create($siteId,$userId,$currency))

    {

        $order->setPersonTypeId(1);



        $order->setBasket($basket);



        $basketSum = $order->getPrice();



        /* shipment */



        $shipmentCollection = $order->getShipmentCollection();

        $shipment = $shipmentCollection->createItem();

        $service = Bitrix\Sale\Delivery\Services\Manager::getById($deliveryId);

        $delivery = $service['NAME'];

        $shipment->setFields(array(

            'DELIVERY_ID' => $service['ID'],

            'DELIVERY_NAME' => $service['NAME'],

        ));

        $shipmentItemCollection = $shipment->getShipmentItemCollection();

        foreach ($basket as $item)

        {

            $shipmentItem = $shipmentItemCollection->createItem($item);

            $shipmentItem->setQuantity($item->getQuantity());

        }

        $propertyCollection = $order->getPropertyCollection();

        $propertyCodeToId = array();

        foreach($propertyCollection as $propertyValue)

            $propertyCodeToId[$propertyValue->getField('CODE')] = $propertyValue->getField('ORDER_PROPS_ID');



        $propertyValue=$propertyCollection->getItemByOrderPropertyId($propertyCodeToId['FIO']);

        $propertyValue->setValue($USER->GetFullName());



        $propertyValue=$propertyCollection->getItemByOrderPropertyId($propertyCodeToId['PHONE']);

        $propertyValue->setValue($USER->getParam('PERSONAL_PHONE'));



        $propertyValue=$propertyCollection->getItemByOrderPropertyId($propertyCodeToId['EMAIL']);

        $propertyValue->setValue($USER->getParam('EMAIL'));



        /* /order properties */



        $order->doFinalAction(true);

        $result = $order->save();

        if($result->isSuccess())

        {

            $orderId = $order->getId();



            //$order = Order::load($orderId);



            $accountNumber = $order->getField('ACCOUNT_NUMBER'); // генерируемый номер заказа

        }

        else

        {

            $arErrors[] = "Ошибка создания заказа: ".implode(", ",$result->getErrorMessages());

        }

    }

\CSaleBasket::DeleteAll(\CSaleBasket::GetBasketUserID());
?>
<script>window.location.href="/personal/";$(location).attr('href',"/personal/");</script>