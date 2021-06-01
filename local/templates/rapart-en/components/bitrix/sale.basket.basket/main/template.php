<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

\Bitrix\Main\UI\Extension::load("ui.fonts.ruble");

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var string $templateName
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $giftParameters
 */

$documentRoot = Main\Application::getDocumentRoot();

if (empty($arParams['TEMPLATE_THEME']))
{
	$arParams['TEMPLATE_THEME'] = Main\ModuleManager::isModuleInstalled('bitrix.eshop') ? 'site' : 'blue';
}

if ($arParams['TEMPLATE_THEME'] === 'site')
{
	$templateId = Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', $component->getSiteId());
	$templateId = preg_match('/^eshop_adapt/', $templateId) ? 'eshop_adapt' : $templateId;
	$arParams['TEMPLATE_THEME'] = Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', $component->getSiteId());
}

if (!empty($arParams['TEMPLATE_THEME']))
{
	if (!is_file($documentRoot.'/bitrix/css/main/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
	{
		$arParams['TEMPLATE_THEME'] = 'blue';
	}
}

if (!isset($arParams['DISPLAY_MODE']) || !in_array($arParams['DISPLAY_MODE'], array('extended', 'compact')))
{
	$arParams['DISPLAY_MODE'] = 'extended';
}

$arParams['USE_DYNAMIC_SCROLL'] = isset($arParams['USE_DYNAMIC_SCROLL']) && $arParams['USE_DYNAMIC_SCROLL'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_FILTER'] = isset($arParams['SHOW_FILTER']) && $arParams['SHOW_FILTER'] === 'N' ? 'N' : 'Y';

$arParams['PRICE_DISPLAY_MODE'] = isset($arParams['PRICE_DISPLAY_MODE']) && $arParams['PRICE_DISPLAY_MODE'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['TOTAL_BLOCK_DISPLAY']) || !is_array($arParams['TOTAL_BLOCK_DISPLAY']))
{
	$arParams['TOTAL_BLOCK_DISPLAY'] = array('top');
}

if (empty($arParams['PRODUCT_BLOCKS_ORDER']))
{
	$arParams['PRODUCT_BLOCKS_ORDER'] = 'props,sku,columns';
}

if (is_string($arParams['PRODUCT_BLOCKS_ORDER']))
{
	$arParams['PRODUCT_BLOCKS_ORDER'] = explode(',', $arParams['PRODUCT_BLOCKS_ORDER']);
}

$arParams['USE_PRICE_ANIMATION'] = isset($arParams['USE_PRICE_ANIMATION']) && $arParams['USE_PRICE_ANIMATION'] === 'N' ? 'N' : 'Y';
$arParams['EMPTY_BASKET_HINT_PATH'] = isset($arParams['EMPTY_BASKET_HINT_PATH']) ? (string)$arParams['EMPTY_BASKET_HINT_PATH'] : '/';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

if ($arParams['USE_GIFTS'] === 'Y')
{
	$arParams['GIFTS_BLOCK_TITLE'] = isset($arParams['GIFTS_BLOCK_TITLE']) ? trim((string)$arParams['GIFTS_BLOCK_TITLE']) : Loc::getMessage('SBB_GIFTS_BLOCK_TITLE');

	CBitrixComponent::includeComponentClass('bitrix:sale.products.gift.basket');

	$giftParameters = array(
		'SHOW_PRICE_COUNT' => 1,
		'PRODUCT_SUBSCRIPTION' => 'N',
		'PRODUCT_ID_VARIABLE' => 'id',
		'USE_PRODUCT_QUANTITY' => 'N',
		'ACTION_VARIABLE' => 'actionGift',
		'ADD_PROPERTIES_TO_BASKET' => 'Y',
		'PARTIAL_PRODUCT_PROPERTIES' => 'Y',

		'BASKET_URL' => $APPLICATION->GetCurPage(),
		'APPLIED_DISCOUNT_LIST' => $arResult['APPLIED_DISCOUNT_LIST'],
		'FULL_DISCOUNT_LIST' => $arResult['FULL_DISCOUNT_LIST'],

		'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
		'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_SHOW_VALUE'],
		'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],

		'BLOCK_TITLE' => $arParams['GIFTS_BLOCK_TITLE'],
		'HIDE_BLOCK_TITLE' => $arParams['GIFTS_HIDE_BLOCK_TITLE'],
		'TEXT_LABEL_GIFT' => $arParams['GIFTS_TEXT_LABEL_GIFT'],

		'DETAIL_URL' => isset($arParams['GIFTS_DETAIL_URL']) ? $arParams['GIFTS_DETAIL_URL'] : null,
		'PRODUCT_QUANTITY_VARIABLE' => $arParams['GIFTS_PRODUCT_QUANTITY_VARIABLE'],
		'PRODUCT_PROPS_VARIABLE' => $arParams['GIFTS_PRODUCT_PROPS_VARIABLE'],
		'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
		'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
		'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
		'MESS_BTN_BUY' => $arParams['GIFTS_MESS_BTN_BUY'],
		'MESS_BTN_DETAIL' => $arParams['GIFTS_MESS_BTN_DETAIL'],
		'CONVERT_CURRENCY' => $arParams['GIFTS_CONVERT_CURRENCY'],
		'HIDE_NOT_AVAILABLE' => $arParams['GIFTS_HIDE_NOT_AVAILABLE'],

		'PRODUCT_ROW_VARIANTS' => '',
		'PAGE_ELEMENT_COUNT' => 0,
		'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
			SaleProductsGiftBasketComponent::predictRowVariants(
				$arParams['GIFTS_PAGE_ELEMENT_COUNT'],
				$arParams['GIFTS_PAGE_ELEMENT_COUNT']
			)
		),
		'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],

		'ADD_TO_BASKET_ACTION' => 'BUY',
		'PRODUCT_DISPLAY_MODE' => 'Y',
		'PRODUCT_BLOCKS_ORDER' => isset($arParams['GIFTS_PRODUCT_BLOCKS_ORDER']) ? $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'] : '',
		'SHOW_SLIDER' => isset($arParams['GIFTS_SHOW_SLIDER']) ? $arParams['GIFTS_SHOW_SLIDER'] : '',
		'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
		'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',
		'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

		'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
		'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
		'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
	);
}

\CJSCore::Init(array('fx', 'popup', 'ajax'));

//$this->addExternalCss('/bitrix/css/main/bootstrap.css');
$this->addExternalCss($templateFolder.'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css');

$this->addExternalJs($templateFolder.'/js/mustache.js');
$this->addExternalJs($templateFolder.'/js/action-pool.js');
$this->addExternalJs($templateFolder.'/js/filter.js');
$this->addExternalJs($templateFolder.'/js/component.js');
?>
<?//debug($arResult['ITEMS']['AnDelCanBuy']);?>
<div class="cart-root">
  <div class="container">
    <div class="products">
		<?if (!empty($arResult['ITEMS']['AnDelCanBuy'])){?>
      <table class="products__block">
        <tbody>
          <tr class="products__head">
            <th class="products__name"><b>Part number </b></th>
            <th class="products__name"><b>Description</b></th>
            <th class="products__name"><b>QTY</b></th>
            <th class="products__name"><b>Lead time</b></th>
            <th class="products__name"><b>Price</b></th>
            <th class="products__name"><b>Shopping cart</b></th>
          </tr>
        </tbody>
        <colgroup class="table-colgroup">
          <col width="300" valign="top">
          <col width="300" valign="top">
          <col width="80" valign="top">
          <col width="100" valign="top">
          <col width="100" valign="top">
          <col width="200" valign="top">
        </colgroup>

        <tbody>

<?foreach($arResult['ITEMS']['AnDelCanBuy'] as $items):?>


<?
$arFilter = Array("IBLOCK_ID"=>24, "ID"=>$items['PRODUCT_ID']);
$res = CIBlockElement::GetList(Array(), $arFilter);
if ($ob = $res->GetNextElement()){;
    $arFields = $ob->GetFields(); // поля элемента
								  //print_r($arFields);
    $arProps = $ob->GetProperties(); // свойства элемента
    $srok = $arProps['SROK_POSTAVKI']['VALUE'];

	if ($srok == "-1"){
	$srok = "On request";
	}else{
	$srok = $arFields['PROPERTY_SROK_POSTAVKI_VALUE'];
	}


   }
?>

<?
$elementID = $items['PRODUCT_ID'];
 
$storeRes = CCatalogStoreProduct::GetList(
                array("SORT" => "ASC"), # сортировка
                array("PRODUCT_ID" => $elementID), # отбор по фильтру
                false, # группировка по полям
                false, # параметры выборки
                array("*") # поля для выборки
            );
while($arStoreParam = $storeRes->Fetch()){




	if ($arStoreParam['STORE_ID'] == 20){// склад РАпарт ШРМ
		if ($arStoreParam['AMOUNT'] > 0){
			$stock1 = true;
			$srok2 = "In stock";
		}
	}
	if ($arStoreParam['STORE_ID'] == 21){// склад ОХ ШРМ
		if ($arStoreParam['AMOUNT'] > 0){
			if (!isset($stock1)){
			$srok2 = "Request";
	}
		}
	}


	if ($arStoreParam['STORE_ID'] == 20 AND $stock1 == true){

			$count_new = $arStoreParam['AMOUNT'];
			$srok2 = "In stock";


	}

}



?>


          <tr class="product__item">
            <td class="product__info"><a href="shop-card.php"><?=$items['NAME']?></a></td>
            <td class="product__info"><a href="shop-card.php"><?=$items['NAME']?></a></td>
			<?if ($items['QUANTITY'] == 0){?>
			<td class="product__info">Request</td>
			<?}else{?>
			<td class="product__info quant"><?if (!empty($count_new)){?><?=$count_new;?><?}else{?> <?=$items['AVAILABLE_QUANTITY'];?><?}?></td>
			<?}?>
			<?if ($items['QUANTITY'] == 0){?>
			<td class="product__info"><span class="product__info_instock"></span> <?if (!empty($srok)){?><?=$srok;?><?}else{?> Out of stock<?}?></td>
			<?}else{?>
			<td class="product__info"><span class="product__info_instock"></span> <?if (!empty($srok2)){?><?=$srok2;?><?}else{?> In stock<?}?></td>
			<?}?>
            <td class="product__info"><?if ($items['SUM_VALUE'] > 0){?><?=$items['PRICE_FORMATED']?><?}else{?>Request<?}?></td>
            <td class="product__info">
              <div class="product__quantity">
                <div class="product__value">
                  <button class="product__value_minus" type="button" onclick="this.nextElementSibling.stepDown()">-</button>
                  <input type="number" min="0" max="100" value="<?=$items['QUANTITY']?>" class="product__value_num">
                  <button class="product__value_plus" type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                </div>
                <span class="product__delete" data-id="<?=$items["ID"]?>">&#10006;</span>
              </div>
            </td>
          </tr>

<?endforeach;?>
        </tbody>
      </table>
    </div>
    <div class="cart-checkout">
      <div class="cart-checkout__wrap">
        <div class="cart-checkout__block">
          <div class="cart-checkout__quantity">
            QTY: <span> <?=count($arResult['ITEMS']['AnDelCanBuy']);?> </span>
          </div>
          <div class="cart-checkout__total">
            For total amount <span> <?=$arResult['allSum_FORMATED'];?> </span>
          </div>
        </div>
        <div class="cart-checkout__btn">
          <a class="checkout__btn popup" href="#order">Place your order</a>
        </div>
      </div>
		<?}else{?>
<div class="bx-sbb-empty-cart-container">
	<div class="bx-sbb-empty-cart-image">
		<img src="" alt="">
	</div>
	<div class="bx-sbb-empty-cart-text">Your basket is empty</div>
		<div class="bx-sbb-empty-cart-desc">
			<a href="/en/catalog/">Click here</a>, to continue shopping		</div>
	</div>
		<?}?>
    </div>
  </div>
</div>

<?if (isset($_GET['order'])):?>
<div id="order2" class="zoom-anim-dialog">
	<div class="success" style="display:flex;z-index:0;">
    <div class="success-text">
      Your items have been successfully shipped.
		<a href="/en/personal/cart/">Ok</a>
    </div>
  </div>
</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	"template1", 
	array(
		"PAY_FROM_ACCOUNT" => "Y",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"ALLOW_AUTO_REGISTER" => "Y",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "N",
		"TEMPLATE_LOCATION" => "popup",
		"PROP_1" => "",
		"PATH_TO_BASKET" => "/en/personal/cart/",
		"PATH_TO_PERSONAL" => "/en/personal/order/",
		"PATH_TO_PAYMENT" => "/en/personal/order/payment/",
		"PATH_TO_ORDER" => "/en/personal/order/make/",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"DELIVERY_NO_SESSION" => "Y",
		"COMPATIBLE_MODE" => "N",
		"BASKET_POSITION" => "before",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"SERVICES_IMAGES_SCALING" => "adaptive",
		"USER_CONSENT" => "Y",
		"USER_CONSENT_ID" => "1",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "Y",
		"COMPONENT_TEMPLATE" => "template1",
		"ALLOW_APPEND_ORDER" => "Y",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",
		"SPOT_LOCATION_BY_GEOIP" => "Y",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"SHOW_VAT_PRICE" => "Y",
		"USE_PREPAYMENT" => "N",
		"USE_PRELOAD" => "Y",
		"ALLOW_USER_PROFILES" => "N",
		"ALLOW_NEW_PROFILE" => "N",
		"TEMPLATE_THEME" => "site",
		"SHOW_ORDER_BUTTON" => "final_step",
		"SHOW_TOTAL_ORDER_BUTTON" => "N",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "Y",
		"SKIP_USELESS_BLOCK" => "Y",
		"SHOW_BASKET_HEADERS" => "N",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"SHOW_NEAREST_PICKUP" => "N",
		"DELIVERIES_PER_PAGE" => "9",
		"PAY_SYSTEMS_PER_PAGE" => "9",
		"PICKUPS_PER_PAGE" => "5",
		"SHOW_PICKUP_MAP" => "Y",
		"SHOW_MAP_IN_PROPS" => "N",
		"PICKUP_MAP_TYPE" => "yandex",
		"SHOW_COUPONS" => "Y",
		"SHOW_COUPONS_BASKET" => "Y",
		"SHOW_COUPONS_DELIVERY" => "Y",
		"SHOW_COUPONS_PAY_SYSTEM" => "Y",
		"PROPS_FADE_LIST_2" => array(
		),
		"ACTION_VARIABLE" => "soa-action",
		"PATH_TO_AUTH" => "/en/auth/",
		"DISABLE_BASKET_REDIRECT" => "N",
		"EMPTY_BASKET_HINT_PATH" => "/en/",
		"USE_PHONE_NORMALIZATION" => "Y",
		"PRODUCT_COLUMNS_VISIBLE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "PROPS",
		),
		"ADDITIONAL_PICT_PROP_24" => "-",
		"PRODUCT_COLUMNS_HIDDEN" => array(
		),
		"HIDE_ORDER_DESCRIPTION" => "N",
		"USE_YM_GOALS" => "N",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N"
	),
	false
);

?>

<?endif;?>



<div id="order" class="zoom-anim-dialog mfp-hide order-form">
  <div class="success">
    <div class="success-text">
      Your request has been sent
		<a href="/en/personal/cart/">ok</a>
    </div>
  </div>
  <div class="order__item" style="display:none;">
	  <div class="order__block order__name">
      <div class="product__info order-request"><a href="#"></a>Запрос</div>
      <div class="product__info order-product"><a href="#">Наименование товарв</a></div>
    </div>
    <div class="order__block  order__value">
      <div class="product__info">
        <div class="product__quantity">
          <div class="product__value">
            <button class="product__value_minus" type="button" onclick="this.nextElementSibling.stepDown()">-</button>
            <input type="number" min="0" max="100" value="1" class="product__value_num">
            <button class="product__value_plus" type="button" onclick="this.previousElementSibling.stepUp()">+</button>
          </div>
          <span class="product__delete">&#10006;</span>
        </div>
      </div>
    </div>
  </div>


	<?if ($USER->IsAuthorized()){?>

  <p class="form-subtitle">После отправки запроса менеджер свяжется <br> с Вами в ближайшее время</p>
<div id="results">
<form class="form" method="POST" id="formx" action="javascript:void(null);" onsubmit="call()">
    <input type="text" name="FIO" placeholder="Ваше ФИО" value="<?=$USER->GetFullName();?>"></p>
    <input type="email" name="EMAIL" placeholder="E-mail" value="<?=$USER->GetEmail();?>"></p>
    <?/*<input type="tel" name="PHONE" placeholder="Контактный номер +7 ХХХ ХХХ ХХХХ"></p>*/?>
	<?/*<textarea name="message" id="" cols="30" rows="10" placeholder="Комментарий"></textarea>*/?>
	<?foreach($arResult['ITEMS']['AnDelCanBuy'] as $items):?>
		<input type="hidden" name="tovars[]" value="<?=$items['PRODUCT_ID']?>">
	<?endforeach;?>
	<?foreach($arResult['ITEMS']['AnDelCanBuy'] as $items):?>
		<input type="hidden" name="quant[]" value="<?=$items['QUANTITY']?>">
		<input type="hidden" name="id_user" value="<?=$USER->GetID();?>">
	<?endforeach;?>
    <button type="submit" class="form-button">Send</button>
  </form>
<?}else{?>
<p class="form-subtitle">You need to <a class="popup" href="#popup-enter">authorize</a>.</p>
<?}?>
</div>
</div>

<script type="text/javascript" language="javascript">
 	function call() {
 	  var msg   = $('#formx').serialize();
        $.ajax({
          type: 'POST',
			url: '/en/ajax/zakaz.php',
          data: msg,
          success: function(data) {
            $('#results').html(data);
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка1: ' + xhr.responseCode);
          }
        });
 
    }
</script>