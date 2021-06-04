<?
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket.line",
    "main",
    array(
        "HIDE_ON_BASKET_PAGES" => "N",
        "PATH_TO_AUTHORIZE" => "",
        "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
        "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
        "PATH_TO_PERSONAL" => SITE_DIR."personal/",
        "PATH_TO_PROFILE" => SITE_DIR."personal/",
        "PATH_TO_REGISTER" => SITE_DIR."login/",
        "POSITION_FIXED" => "N",
        "SHOW_AUTHOR" => "N",
        "SHOW_EMPTY_VALUES" => "Y",
        "SHOW_NUM_PRODUCTS" => "Y",
        "SHOW_PERSONAL_LINK" => "Y",
        "SHOW_PRODUCTS" => "N",
        "SHOW_REGISTRATION" => "Y",
        "SHOW_TOTAL_PRICE" => "Y",
        "COMPONENT_TEMPLATE" => "main"
    ),
    false
);?>