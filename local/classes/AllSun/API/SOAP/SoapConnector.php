<?php
namespace AllSun\API\SOAP;

if(!defined("SOAP_CONFIG_INCLUDED") || SOAP_CONFIG_INCLUDED !== TRUE)
    trowExpection('No loaded soap configuration');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc/nusoap.php';



class SoapConnector
{
    public static function CheckConfig() {
        if(!defined('SOAP_CONFIG_API_URI') || !defined('SOAP_CONFIG_API_LOGIN') || !defined('SOAP_CONFIG_API_PASS')) return false;
        elseif(!SOAP_CONFIG_API_URI || !SOAP_CONFIG_API_LOGIN || !SOAP_CONFIG_API_PASS) return false;
        else return true;
    }


}