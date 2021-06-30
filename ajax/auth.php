<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(CModule::IncludeModule("iblock"));
global $USER;
if (!is_object($USER)) 
   $USER = new CUser;
$arAuthResult = $USER->Login($_POST['login'], $_POST['password'], "Y");
if($arAuthResult == 1)
   echo "<div class='alert alert-mini alert-success margin-bottom-30'>Вы успешно авторизованны. <a href='/'>Перейти на главную</a></div>";LocalRedirect("/");

if (!empty($arAuthResult['MESSAGE']))
   echo "<div class='alert alert-mini alert-danger margin-bottom-30'>";
    echo $arAuthResult['MESSAGE'];
	echo "</div>";
?>