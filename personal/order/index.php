<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>
<center>
    <?$APPLICATION->IncludeComponent(
        "GetCode:order.list",
        "",
        Array(
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "PRIZNAK" => "order"
        )
    );?>
</center>

<?
/*require('../cfg.php');

$client = new nusoap_client($nUrl, true,false,false,false,false,0,30);
// $client->debugLevel = 9;
// $client->debug = 1;
$err = $client->getError();
if ($err) {
	$error = GetMessage('MEDSITE_SOAP_CONSTRUCT_ERROR').': '.CDataTools::trans($err, 'UTF-8', MY_SITE_CHARSET);
	echo 'Error: ' . $error;
}
else {
	$client->setCredentials($nLogin, $nPasswd);
	$client->setEndpoint(substr($nUrl,0,strlen($nUrl)-5));
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;
	$client->response_timeout = 30;

	$curPage = '000-';
	if ( $onPage < 100 ) { $curPage .= '0'; }
	if ( $onPage < 10 ) { $curPage .= '0'; }
	$curPage .= ( $onPage - 1 );
	if( $_GET['part'] ) { $curPage = $_GET['part']; }

	$jsonInput = '[{"method": "5", "PART": "' . $curPage . '", "IDKP": "","IDZayavka": "","StatusZayavka": "",
"Kontragent": "'.$nameKontr.'", "Partner": "","Organiz": "","Sdelka": "","BooleanActiv": "",
"Tovary": [{"IDNomenklature": "","Nomenklature": "",}]}]';
	// var_dump( $jsonInput );
	$result = $client->call('IntegrationZayInput',  array('NameKontr' => $jsonInput ) , '', '', false, null, 'rpc', 'literal');
	// var_dump( $client->debug_str );
	// var_dump( $result );
	$json = json_decode($result['return']);
	// var_dump($json);
// 	$jsonInput = '[{"metod": "2", "IDKP": "00КА-002398","IDZayavka": "000003225","StatusZayavka": "Новая",
// "Kontragent": "'.$nameKontr.'", "Partner": "ВЫМПЕЛ ООО","Organiz": "РАпарт Сервисез ООО","Sdelka": "ВЫМПЕЛ ООО / - 000003225 - 09.11.2020 10:14:06","BooleanActiv": "",
// "Tovary": [{"IDNomenklature": "КА-00021233","Nomenklature": "03-06-1061",}]}]';

// 	$result = $client->call('IntegrationZayInput',   array('NameKontr' => $jsonInput ), '', '', false, null, 'rpc', 'literal');
// 	var_dump($result);
	
	/*
?>
<style>
	.products__block {
		width:1161px;
	}

	.paging td {
		padding: 5px;
		margin: 5px;
	}
</style>
<center>
	<table class="products__block shop">
		<tr class="products__head">
		<th class="products__name">№</th>
		<th class="products__name">Дата</th>
		<th class="products__name">№ клиента</th>
		<th class="products__name">Дата клиента</th>
		<th class="products__name">Сумма</th>
		<th class="products__name">Состояние</th>
		<th class="products__name">% оплаты</th>
		<th class="products__name">% отгрузки</th>
		<th class="products__name">Действия</th>
	</tr>
<?
	foreach( $json as $line ) {

		echo '<TR class="product__item">';
		echo '<td class="product__info">' . $line->ID . '</td>';
		echo '<td class="product__info">' . $line->Data . '</td>';
		echo '<td class="product__info">' . $line->NumberKontr . '</td>';
		echo '<td class="product__info">' . $line->Shipment . '</td>';
		echo '<td class="product__info">' . $line->Summ . '</td>';
		echo '<td class="product__info">' . $line->Status . '</td>';
		echo '<td class="product__info">' . $line->PercPayment . '</td>';
		echo '<td class="product__info">' . $line->PercShipment . '</td>';
		echo '<td class="product__info"><a href="order/?id=' . $line->ID . '&part=' . $curPage . '" class="product__btn">Посмотреть</a>';
		echo "</TR>";


	}
?>
	</table>
	<table class="paging"><tr>
<? 
	$docs = $json[0]->AvailableDocumentsKol;
	$pages = $docs / $onPage;
	if ( intval($pages) > $pages ) { $pages++; }
	for( $i = 1; $i <= $pages; $i++ ) {
		echo "<td>";
		$leftPart = ( $i-1 ) * $onPage;
		if ( $leftPart < 100 ) { $leftPart = '0' . $leftPart; }
		if ( $leftPart < 10 ) { $leftPart = '0' . $leftPart; }
		$rightPart = $i * $onPage - 1;
		if ( $rightPart < 100 ) { $rightPart = '0' . $rightPart; }
		if ( $rightPart < 10 ) { $rightPart = '0' . $rightPart; }
		$link = '?part=' . $leftPart . '-' . $rightPart;
		if ( $leftPart . '-' . $rightPart == $curPage ) {
			echo "<B>" . $i . "</B>";
		} else {
			echo "<a href='" . $link . "'>" . $i . "</a>";	
		}
		echo "</td>";
	}
?>
	</tr></table>
</center>
<?
}

?>
<BR><BR><BR>
<BR><BR><BR><BR><BR><BR>
<?
*/
// LocalRedirect('/personal/');
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>