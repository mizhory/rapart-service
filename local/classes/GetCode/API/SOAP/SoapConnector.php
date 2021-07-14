<?php
namespace GetCode\API\SOAP;

if(!defined("SOAP_CONFIG_INCLUDED") || SOAP_CONFIG_INCLUDED !== TRUE)
    trowExpection('No loaded soap configuration');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc/nusoap.php';


class SoapConnector
{
    private static $soap_client = false;
    private static $request;

    const ON_PAGE = 30;
    const SOAP_ENCODING_CHARSET = 'UTF-8';
    const SOAP_DECODE = false;
    const RESPONSE_TIMEOUT = 30;

    public static function CheckConfig() {
        if(!defined('SOAP_CONFIG_API_URI') || !defined('SOAP_CONFIG_API_LOGIN') || !defined('SOAP_CONFIG_API_PASS')) return false;
        elseif(!SOAP_CONFIG_API_URI || !SOAP_CONFIG_API_LOGIN || !SOAP_CONFIG_API_PASS) return false;
        else return true;
    }
    public static function initConnect() {
        global $APPLICATION;

        if(static::CheckConfig())
            $APPLICATION->ThrowException('Soap configuration on connect undefinde');

        $nUrl = SOAP_CONFIG_API_URI;

        static::$soap_client = new nusoap_client($nUrl, true,false,false,false,false,0,30);

        $err = static::$soap_client->getError();
        if ($err) {
            $APPLICATION->ThrowException('Soap Client crash by Error in connection service  ');
        }
        $onPage = static::ON_PAGE;
        $nLogin = SOAP_CONFIG_API_LOGIN;
        $nPasswd = SOAP_CONFIG_API_PASS;

        static::$soap_client->setCredentials($nLogin, $nPasswd);
        static::$soap_client->setEndpoint(substr($nUrl,0,strlen($nUrl)-5));

        static::$soap_client->soap_defencoding = static::SOAP_ENCODING_CHARSET;
        static::$soap_client->decode_utf8 = static::SOAP_DECODE;
        static::$soap_client->response_timeout = static::RESPONSE_TIMEOUT;

    }

    public static function getResponse() {
        $query = static::$request;
        static::$requst = null;

        $result = static::$soap_client->call('IntegrationZayInput',  array('NameKontr' => $query) , '', '', false, null, 'rpc', 'literal');
        return json_decode($result['return']);
    }
    public static function initRequest(array $params) {
        /*
         * sample

        $jsonInput = '[{"method": "6", "PART": "000-00", "IDKP": "","IDZayavka": "","StatusZayavka": "",
"Kontragent": "'.$nameKontr.'", "Partner": "","Organiz": "","Sdelka": "","BooleanActiv": "",
"Tovary": [{"IDNomenklature": "","Nomenklature": "",}]}]';
        */
        $arParams = [
            'method'=> $params['STEP_METHOD'],
            'PART' => '000-029',
            'IDKP' => '',
            'IDZayavka' => '',
            'StatusZayavka' => '',
            'Kontragent' => $params['XML_ID'],
            'Partner' => '',
            'Organiz' => '',
            'Sdelka' => '',
            'BooleanActiv' => '',
        ];
        $arTovary = [
            'IDNomenklature' => '',
            'Nomenklature' => ''
        ];
        $arParams['TOVARY'] = '[' . json_encode($arTovary) . ']';
        $jj = json_encode($arParams);
        static::$request = '[' . $jj . ']';
        return static::getResponse();
    }

	/**
    public static function test() {
		if(!static::$soap_client)
			static::initConnect();
		$client = static::$soap_client;//new nusoap_client(SOAP_CONFIG_API_URI, true,false,false,false,false,0,30);
		$nameKontr = '';
		$client->setCredentials(SOAP_CONFIG_API_LOGIN, SOAP_CONFIG_API_PASS);
			$client->setEndpoint(substr(SOAP_CONFIG_API_URI,0,strlen(SOAP_CONFIG_API_URI)-5)); 
			$client->soap_defencoding = 'UTF-8';
			$client->decode_utf8 = false;
			$client->response_timeout = 30;

			$curPage = '000-029';
			$curPage .= ( $onPage - 1 );
			$nameKontr = 'cbbe79e9-eff7-11e9-80e2-005056b633c';

			$jsonInput = '[{"method": "4", "PART": "' . $curPage . '", "GUIDKP":"", "IDKP": "","IDZayavka": "","StatusZayavka": "",
		"Kontragent": "'.$nameKontr.'", "Partner": "","Organiz": "","Sdelka": "","BooleanActiv": "",
		"Tovary": [{"IDNomenklature": "","Nomenklature": "",}]}]';
			// var_dump( $jsonInput );
			// echo "<BR><BR>";
			$result = $client->call('IntegrationZayInput',  array('NameKontr' => $jsonInput ) , '', '', false, null, 'rpc', 'literal');
	}
     */
}