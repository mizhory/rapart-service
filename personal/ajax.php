<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require('cfg.php');

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

	// $onPage = $_GET['onPage'];

	// $curPage = '000-';
	// if ( $onPage < 100 ) { $curPage .= '0'; }
	// if ( $onPage < 10 ) { $curPage .= '0'; }
	// $curPage .= ( $onPage - 1 );
	if( $_GET['part'] ) { $curPage = $_GET['part']; }

	$method = 1;
	if( $_GET['method'] ) { $method = $_GET['method']; }

	$jsonInput = '[{"method": "' . $method . '",  "PART": "' . $curPage . '", "IDKP": "", "GUIDZayavka": "", "IDZayavka": "","StatusZayavka": "",
"Kontragent": "'.$nameKontr.'", "Partner": "","Organiz": "","Sdelka": "","BooleanActiv": "",
"Tovary": [{"IDNomenklature": "","Nomenklature": "" }]}]';
	// var_dump( $jsonInput );
	$result = $client->call('IntegrationZayInput',  array('NameKontr' => $jsonInput ) , '', '', false, null, 'rpc', 'literal');
	// var_dump( $client->debug_str );
	// var_dump( $result );
	// $json = json_decode($result['return']);
	// var_dump($json);
	echo $result['return'];
// 	$jsonInput = '[{"metod": "2", "IDKP": "00КА-002398","IDZayavka": "000003225","StatusZayavka": "Новая",
// "Kontragent": "'.$nameKontr.'", "Partner": "ВЫМПЕЛ ООО","Organiz": "РАпарт Сервисез ООО","Sdelka": "ВЫМПЕЛ ООО / - 000003225 - 09.11.2020 10:14:06","BooleanActiv": "",
// "Tovary": [{"IDNomenklature": "КА-00021233","Nomenklature": "03-06-1061",}]}]';

// 	$result = $client->call('IntegrationZayInput',   array('NameKontr' => $jsonInput ), '', '', false, null, 'rpc', 'literal');
// 	var_dump($result);
}
	
	