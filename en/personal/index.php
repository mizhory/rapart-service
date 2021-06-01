<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Personal");
?>
<style>
.form-group {
    display: block;
    width: 100%;
}
.form-control{
    margin-bottom: 15px;
    padding: 5px 20px;
    color: #858585;
	font-size: 18px;
	font-weight: 500;
	line-height: 32px;
	border-radius: 30px;
	border: 2px solid #dadada;
}

.btn-md {

    padding: 10px 40px;
    margin: 5px auto 0;
    color: 

#ffffff;

font-family: Montserrat;

font-size: 18px;

font-weight: 500;

line-height: 32px;

border: none;

border-radius: 30px;

background-color:

    #1550a2;

}
</style>
<div class="container">
<?$APPLICATION->IncludeComponent("bitrix:sale.personal.section", "template1", Array(
	"ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array(
			0 => "0",
		),
		"ACCOUNT_PAYMENT_PERSON_TYPE" => "1",
		"ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "Y",
		"ACCOUNT_PAYMENT_SELL_TOTAL" => array(
			0 => "100",
			1 => "200",
			2 => "500",
			3 => "1000",
			4 => "5000",
			5 => "",
		),
		"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "Y",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_GROUPS" => "Y",	// Respect access permission
		"CACHE_TIME" => "3600",	// Cache time (sec.)
		"CACHE_TYPE" => "A",	// Cache type
		"CHECK_RIGHTS_PRIVATE" => "N",	// Check access permissions
		"COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
		"CUSTOM_PAGES" => "",	// Preferences for section custom pages
		"CUSTOM_SELECT_PROPS" => "",
		"NAV_TEMPLATE" => "",
		"ORDER_HISTORIC_STATUSES" => array(
			0 => "F",
		),
		"PATH_TO_BASKET" => "/en/personal/cart",	// Shopping cart path
		"PATH_TO_CATALOG" => "/en/catalog/",	// Catalog path
		"PATH_TO_CONTACT" => "/en/about/contacts",	// Contact information page
		"PATH_TO_PAYMENT" => "/en/personal/order/payment",	// Payment page path
		"PER_PAGE" => "20",
		"PROP_1" => "",
		"PROP_2" => "",
		"SAVE_IN_SESSION" => "Y",
		"SEF_FOLDER" => "/en/personal/",	// Folder for SEF (site-root-relative)
		"SEF_MODE" => "Y",	// Enable SEF (Search Engine Friendly Urls) support
		"SEND_INFO_PRIVATE" => "N",	// Generate e-mail event
		"SET_TITLE" => "Y",	// Set page title
		"SHOW_ACCOUNT_COMPONENT" => "Y",
		"SHOW_ACCOUNT_PAGE" => "N",	// Show customer account page
		"SHOW_ACCOUNT_PAY_COMPONENT" => "Y",
		"SHOW_BASKET_PAGE" => "N",	// Show shopping cart link
		"SHOW_CONTACT_PAGE" => "N",	// Show contacts page link
		"SHOW_ORDER_PAGE" => "N",	// Show customer orders page
		"SHOW_PRIVATE_PAGE" => "Y",	// Show customer information page
		"SHOW_PROFILE_PAGE" => "N",	// Show customer profiles page
		"ALLOW_INNER" => "N",
		"ONLY_INNER_FULL" => "N",
		"SHOW_SUBSCRIBE_PAGE" => "N",	// Show subscriptions page
		"USER_PROPERTY_PRIVATE" => "",
		"USE_AJAX_LOCATIONS_PROFILE" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"MAIN_CHAIN_NAME" => "My account",	// Section name in breadcrumbs
		"SEF_URL_TEMPLATES" => array(
			"index" => "index.php",
			"orders" => "orders/",
			"account" => "account/",
			"subscribe" => "subscribe/",
			"profile" => "profiles/",
			"profile_detail" => "profiles/#ID#",
			"private" => "private/",
			"order_detail" => "orders/#ID#",
			"order_cancel" => "cancel/#ID#",
		)
	),
	false
);?>
</div>
<br><br><br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>