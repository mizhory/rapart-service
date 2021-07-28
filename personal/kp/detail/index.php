<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Коммерческие предложения");
?>
    <div class="container" style="margin-bottom: 10em;">
        <?$APPLICATION->IncludeComponent(
            "GetCode:element.detail",
            "",
            Array(
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "PRIZNAK" => "KP",
                //'TITLE' => 'Клиентские предложения'
            )
        );?>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>