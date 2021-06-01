<?php
use AllSun\Manager\SoapConfigManager,
    AllSun\Helper\SoapConfigEntry;
define('SOAP_CONFIG_INCLUDED', TRUE);
define('SOAP_CONFIG_API_URI', SoapConfigManager::getInstance()->getConfigSoap(SoapConfigEntry::URI));
define('SOAP_CONFIG_API_LOGIN', SoapConfigManager::getInstance()->getConfigSoap(SoapConfigEntry::LOGIN));
define('SOAP_CONFIG_API_PASS', SoapConfigManager::getInstance()->getConfigSoap(SoapConfigEntry::PASS));

