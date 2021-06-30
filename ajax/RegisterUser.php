<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$NAME = htmlspecialchars(strip_tags($_REQUEST['name']));
$EMAIL = htmlspecialchars(strip_tags($_REQUEST['email']));
$ORG = htmlspecialchars(strip_tags($_REQUEST['org']));
$INN = htmlspecialchars(strip_tags($_REQUEST['inn']));
$PASSWORD = htmlspecialchars(strip_tags($_REQUEST['password']));

if (empty($NAME)){
	$errors[] = 'Введите ФИО';
}

if (empty($EMAIL)){
	$errors[] = 'Введите E-mail';
}

if (empty($ORG)){
	$errors[] = 'Введите организацию';
}

if (empty($INN)){
	$errors[] = 'Введите инн';
}

if (empty($PASSWORD)){
	$errors[] = 'Введите пароль';
}

if (empty($PASSWORD)){
	$errors[] = 'Повторите пароль';
}

if(empty($errors)){


// создадим массив описывающий изображение 
// находящееся в файле на сервере


$user = new CUser;
$arFields = Array(
  "NAME"              => $NAME,
  "LAST_NAME"         => "",
  "EMAIL"             => $EMAIL,
  "LOGIN"             => $EMAIL,
  "LID"               => "ru",
  "ACTIVE"            => "Y",
  "GROUP_ID"          => array(10,11),
  "PASSWORD"          => $PASSWORD,
  "CONFIRM_PASSWORD"  => $PASSWORD2
);

$ID = $user->Add($arFields);
if (intval($ID) > 0)
    echo "Пользователь успешно добавлен.";
else
    echo $user->LAST_ERROR;



}else{
	echo '<div class="alert alert-danger" role="alert" style="text-align: center;width: 90%;margin-left: 25px;">'.current($errors).'</div>';
}
?>