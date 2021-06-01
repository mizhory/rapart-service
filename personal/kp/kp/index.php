<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Коммерческое предложение № " . $_GET['id']);
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

	$jsonInput = '[{"method": "4", "PART": "' . $curPage . '", "GUIDKP":"", "IDKP": "","IDZayavka": "","StatusZayavka": "",
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
			if( $z->IDKP == $_GET['id'] ) {
				$zayavka = $z;
			}
		}

		if( ! $zayavka ) {
			echo "Ошибка, номер коммерческого предложения не найден";
		} else if( $_POST['save'] ) {
			$jsonInput = '[{"method":"2", ';
			$jsonInput .= '"PART": "' . $curPage . '", ';
			$jsonInput .= '"IDKP":"' . $zayavka->IDKP . '", ';
			$jsonInput .= '"GUIDKP":"' . $zayavka->GUIDKP . '", ';
			$jsonInput .= '"GUIDZayavka":"' . $zayavka->GUIDZayavka . '", ';
			$jsonInput .= '"IDZayavka":"' . $zayavka->IDZayavka . '", ';
			$jsonInput .= '"StatusZayavka":"' . $zayavka->StatusKP . '", ';
			$jsonInput .= '"Kontragent":"' . $nameKontr . '", ';
			$jsonInput .= '"Partner":"", ';
			// $jsonInput .= '"Partner":"' . $zayavka->Partner . '", ';
			$jsonInput .= '"Organiz":"", ';
			// $jsonInput .= '"Organiz":"' . $zayavka->Organiz . '", ';
			$sdelka = str_replace( '"', '\\"', $zayavka->SdelkaKP );

			$jsonInput .= '"Sdelka":"' . $sdelka . '", ';
			$jsonInput .= '"BooleanActiv":"' . $zayavka->BooleanActiv . '", ';
			$jsonInput .= '"Tovary":[';
			$sep = '';
			foreach ( $zayavka->Tovary as $tovar ) {
				if( $zayavka->BooleanActiv == 'Да' || $_POST[ $tovar->IDNomenklature ] ) {
					$jsonInput .= $sep . '{'; 
					$jsonInput .= '"IDNomenklature": "' . $tovar->IDNomenklature . '",';
					$jsonInput .= '"Nomenklature": "' . $tovar->Nomenklature . '"';
					$jsonInput .= '}';
					$sep = ',';
				} 
			}
			$jsonInput .= ']}]';
			// echo $jsonInput . '<BR><BR>';
			$result = $client->call('IntegrationZayInput',   array('NameKontr' => $jsonInput ), '', '', false, null, 'rpc', 'literal');
			// var_dump($result);
			// echo '<BR><BR>';
			?>
			<center>Ваш заказ направлен</center>
<script>
	window.location.href = 'kps.php';
</script>
			<?
		} else {

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
			<th class="products__name">Сумма</th>
			<th class="products__name">Срок действия</th>
			<th class="products__name">Состояние</th>
		</tr>
		<tr class="product__item">
			<td class="product__info"><?= $zayavka->IDKP ?></td>
			<td class="product__info"><?= $zayavka->DataKP ?></td>
			<td class="product__info"><?= $zayavka->SummKP ?></td>
			<td class="product__info"><?= $zayavka->Validity ?></td>
			<td class="product__info"><?= $zayavka->StatusKP ?></td>
		</tr>
	</table>
	<BR><BR><BR>
	<form method="post" action="?id=<?= $_GET['id'] ?>&part=<?= $curPage ?>">
	<table class="products__block">
		<tr class="products__head">
			<th class="products__name">№</th>
			<th class="products__name">P/N</th>
			<th class="products__name">Кол-во, ЕИ</th>
			<th class="products__name">Цена</th>
			<th class="products__name">Сумма</th>
			<th class="products__name">Ставка НДС</th>
			<th class="products__name">Сумма с НДС</th>
			<th class="products__name">Срок поставки</th>
			<th class="products__name">Заявка</th>
			<th class="products__name">Состояние</th>
			<th class="products__name">В заказ</th>
		</tr>
<?
		foreach ( $zayavka->Tovary as $tovar ) {
			echo '<tr class="product__item">';
			echo '<td class="product__info">' . $tovar->IDNomenklature . '</td>';
			echo '<td class="product__info">' . $tovar->PartyNumber . '</td>';
			echo '<td class="product__info">' . $tovar->KolVo . '</td>';
			echo '<td class="product__info">' . $tovar->Cena . '</td>';
			echo '<td class="product__info">' . $tovar->Summ . '</td>';
			echo '<td class="product__info">' . $tovar->SummNDS . '</td>';
			echo '<td class="product__info">' . $tovar->SummSNDS . '</td>';
			echo '<td class="product__info">' . $tovar->DeliveryTime . '</td>';
			echo '<td class="product__info">' . $tovar->Request . '</td>';
			echo '<td class="product__info">' . $tovar->Status . '</td>';
			$disabled = '';
			if( $zayavka->BooleanActiv == 'Да' ) { $disabled = 'disabled'; }
			echo '<td class="product__info"><input type="checkbox" name="' . $tovar->IDNomenklature . '" value="1" ' . $disabled . ' checked></td>';
			echo '</tr>';
		}
		?>
		</table>
		<BR><BR><BR>
		<p style="text-align:right;">
			<input type="submit" name="save" value="Отправить заказ" style='margin-right: 40px; padding:20px; font-size:15px; background-color:#232257; border-radius: 27.0px;font-size: 20px;font-weight: 600;color: #ffffff;border: none;'>
		</p>
	</form>
</center>		
		<?
	}
}

?>

	

<BR><BR><BR>
<BR><BR><BR><BR><BR><BR>
<?

// LocalRedirect('/personal/');
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>