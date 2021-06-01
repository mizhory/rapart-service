<?
require('nusoap.php');

$nUrl = 'https://erpdev.rapart.aero/rapart_ka_copy3/ws/crm_Integration?wsdl';
$nLogin = 'User6'; // 'ip_limonov';
$nPasswd = 'PJJ3midtq'; // '`e]Sy=7a';
$onPage = 30;
// $nameKontr = '856c7701-df5d-11e9-80e0-005056b633c3'; // '80e0005056b633c311e9df5d856c76ff'; // '821c00505691943c11e99662480c5168'; // 'ООО АВИАПРЕДПРИЯТИЕ "ГАЗПРОМ АВИА" '; // 'ВЫМПЕЛ ООО'; // 'AEROTECHNIC USA INC'; 
// nusoap_client::setGlobalDebugLevel(9);
global $USER;
Cmodule::IncludeModule('iblock');
$rsUsers = CUser::GetList(($by="ID"), ($order="ACS"), ["ID"=>$USER->GetID()],[]);
$arUser = $rsUsers->Fetch();
$nameKontr = $arUser['XML_ID'];
// var_dump($arUser['XML_ID']);