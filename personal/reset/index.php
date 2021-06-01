<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");
?>
<div class="contacts">
	<div class="container">
		<div class="contacts__wrap">
			<div class="contacts-content">
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.auth.forgotpasswd",
					"",
				Array()
				);?>
			</div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>