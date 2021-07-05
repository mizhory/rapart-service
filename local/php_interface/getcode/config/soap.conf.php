<?php
use GetCode\Manager\SoapConfigManager,
    GetCode\Helper\SoapConfigEntry;

define('SOAP_CONFIG_INCLUDED', TRUE);
define('SOAP_CONFIG_API_URI', 'https://erpdev.rapart.aero/rapart_ka_copy4/ws/crm_Integration?wsdl');//SoapConfigManager::getInstance()->getConfigSoap(SoapConfigEntry::URI));
define('SOAP_CONFIG_API_LOGIN', 'DevRapart4');//SoapConfigManager::getInstance()->getConfigSoap(SoapConfigEntry::LOGIN));
define('SOAP_CONFIG_API_PASS', '12345');//SoapConfigManager::getInstance()->getConfigSoap(SoapConfigEntry::PASS));

/*
 * $nUrl = 'https://erpdev.rapart.aero/rapart_ka_copy3/ws/crm_Integration?wsdl';
$nLogin = 'User6'; // 'ip_limonov';
$nPasswd = 'PJJ3midtq'; // '`e]Sy=7a';

 */
