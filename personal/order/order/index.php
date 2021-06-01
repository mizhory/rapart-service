<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказ № " . $_GET['id']);
?><BR><BR><BR><?
require('../../cfg.php');

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
		$zayavka = '';
		foreach( $json as $z ) {
			if( $z->ID == $_GET['id'] ) {
				$zayavka = $z;
			}
		}

		if( ! $zayavka ) {
			echo "Ошибка, номер коммерческого предложения не найден";
		} else {
			echo "<form method='POST'>";
			echo "<input type='hidden' name='IDKP' value='" . $zayavka->Tovary[0]->ArrayKP[0]->IDKP . "'>";
			echo "<input type='hidden' name='IDZayavka' value='" . $zayavka->IDZayavka . "'>";
			echo "<input type='hidden' name='StatusZayavka' value='" . $zayavka->StatusZayavka . "'>";
			echo "<input type='hidden' name='Kontragent' value='" . $zayavka->Kontragent . "'>";
			echo "<input type='hidden' name='Partner' value='" . $zayavka->Partner . "'>";
			echo "<input type='hidden' name='Organiz' value='" . $zayavka->Organiz . "'>";
			echo "<input type='hidden' name='Sdelka' value='" . $zayavka->Sdelka . "'>";
			echo "<input type='hidden' name='BooleanActiv' value='" . $zayavka->Tovary[0]->ArrayKP[0]->BooleanActiv . "'>";
			
			?>
<style>
	.products__block {
		width:1161px;
		max-width:1161px;
	}

	.product__info {
		padding: 30px 0px;
	}
</style>
<center>
	<table class="products__block">
		<tr class="products__head">
			<th class="products__name">№</th>
			<th class="products__name">Дата</th>
			<th class="products__name">№ клиента</th>
			<th class="products__name">Дата клиента</th>
			<th class="products__name">Сумма</th>
			<th class="products__name">Состояние</th>
			<th class="products__name">% оплаты</th>
			<th class="products__name">% отгрузки</th>
		</tr>
		<tr class="product__item">
			<td class="product__info"><?= $zayavka->ID ?></td>
			<td class="product__info"><?= $zayavka->Data ?></td>
			<td class="product__info"><?= $zayavka->NumberKontr ?></td>
			<td class="product__info"><?= $zayavka->Shipment ?></td>
			<td class="product__info"><?= $zayavka->Summ ?></td>
			<td class="product__info"><?= $zayavka->Status ?></td>
			<td class="product__info"><?= $zayavka->PercPayment ?></td>
			<td class="product__info"><?= $zayavka->PercShipment ?></td>
		</tr>
	</table>
	<BR><BR><BR>
	<table class="products__block">
		<tr class="products__head">
			<th class="products__name">№</th>
			<th class="products__name">P/N</th>
			<th class="products__name">Кол-во, ЕИ</th>
			<th class="products__name">Цена</th>
			<th class="products__name">Сумма</th>
			<th class="products__name">Ставка НДС</th>
			<th class="products__name">Сумма с НДС</th>
			<th class="products__name">Дата отгрузки</th>
			<th class="products__name">Дата РО</th>
			<th class="products__name">Состояние</th>
		</tr>
<?
		foreach ( $zayavka->Tovary as $tovar ) {
			echo '<tr class="product__item">';
			echo '<td class="product__info">' . $tovar->IDNomenklature . '</td>';
			echo '<td class="product__info">' . $tovar->PartyNumber . '</td>';
			echo '<td class="product__info">' . $tovar->KolVo . '</td>';
			echo '<td class="product__info">' . $tovar->Cena . '</td>';
			echo '<td class="product__info">' . $tovar->Summ . '</td>';
			echo '<td class="product__info">' . $tovar->StavkaNDS . '</td>';
			echo '<td class="product__info">' . $tovar->SummSNDS . '</td>';
			echo '<td class="product__info">' . $tovar->DateShipment . '</td>';
			echo '<td class="product__info">' . $tovar->DateRO . '</td>';
			echo '<td class="product__info">' . $tovar->State . '</td>';
			echo '</tr>';
			// echo "<input type='checkbox' name='IDNomenklature' value='" . $tovar->IDNomenklature . "'> " .
			// 		"<input type='hidden' name='" . $tovar->IDNomenklature . "' value='" . $tovar->Nomenklature . "'>" ;
		}

		// echo '<center><input type=submit name="save" value="Принять"></center>';
		echo '</table></form>';
	}
}

?>
<BR><BR><BR>
<BR><BR><BR><BR><BR><BR>
<?

// LocalRedirect('/personal/');
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>