<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявка № " . $_GET['id']);
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

	$jsonInput = '[{"method": "3", "PART": "' . $curPage . '", "GUIDZayavka": "", "IDKP": "","IDZayavka": "","StatusZayavka": "",
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
			if( $z->IDZayavka == $_GET['id'] ) {
				$zayavka = $z;
			}
		}

		if( ! $zayavka ) {
			echo "Ошибка, номер заявки не найден";
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
	}
</style>
<center>
	<table class="products__block">
		<tr class="products__head">
			<th class="products__name">№</th>
			<th class="products__name">Дата</th>
			<th class="products__name">Приоритет</th>
			<th class="products__name">№ заказчика</th>
			<th class="products__name">Состояние</th>
		</tr>
		<tr class="product__item">
			<td class="product__info"><?= $zayavka->IDZayavka ?></td>
			<td class="product__info"><?= $zayavka->Date ?></td>
			<td class="product__info"><?= $line->Priority ?></td>
			<td class="product__info"><?= $zayavka->NumberCustomer ?></td>
			<td class="product__info"><?= $zayavka->StatusZayavka ?></td>
		</tr>
	</table>
	<BR><BR><BR>
	<table class="products__block">
		<tr class="products__head">
			<th class="products__name">№</th>
			<th class="products__name">Обозначение заказчика</th>
			<th class="products__name">P/N</th>
			<th class="products__name">Количество</th>
			<th class="products__name">Состояние</th>
		</tr>
<?
		foreach ( $zayavka->Tovary as $tovar ) {
			echo '<tr class="product__item">';
			echo '<td class="product__info">' . $tovar->IDNomenklature . '</td>';
			echo '<td class="product__info">' . $tovar->DesignationNomenklature . '</td>';
			echo '<td class="product__info">' . $tovar->PartyNumber . '</td>';
			echo '<td class="product__info">' . $tovar->KolVo . '</td>';
			echo '<td class="product__info">' . $tovar->Status . '</td>';
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