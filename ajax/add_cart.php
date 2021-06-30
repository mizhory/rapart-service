<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ID_ELEMENT = $_REQUEST['id'];
$QUANTITY = preg_replace("/[^0-9]/", '', $_REQUEST['quantity']);
?>

<?if (isset($ID_ELEMENT) AND isset($QUANTITY)):?>
<?
if (CModule::IncludeModule("catalog") && CModule::IncludeModule("sale")) {

	// ADD TO CART
		$propArr = array();
		$count = ($QUANTITY) ? $QUANTITY : 1;

		Add2BasketByProductID(
			$ID_ELEMENT,
			$count,
			$propArr
		);
echo "ok";
print_r($_POST);
}
?>
<?endif;?>