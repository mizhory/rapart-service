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
        static::$request = null;

        $result = static::$soap_client->call('IntegrationZayInput',  array('NameKontr' => $query) , '', '', false, null, 'rpc', 'literal');

		return json_decode($result['return'], 1);
    }
    public static function initRequest(array $params) {
		$jsonInput = '[{"method": "'.intval($params['METHOD_STEP']).'", "PART": "000-029", "IDKP": "","IDZayavka": "","StatusZayavka": "",
"Kontragent": "'.$params['XML_ID'].'", "Partner": "","Organiz": "","Sdelka": "","BooleanActiv": "",
"Tovary": [{"IDNomenklature": "","Nomenklature": "",}]}]';
		static::$request = $jsonInput;
		return static::getResponse();
    }
}