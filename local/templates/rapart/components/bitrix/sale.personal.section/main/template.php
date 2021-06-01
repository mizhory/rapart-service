<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;


// if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0)
// {
// 	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
// }

$theme = Bitrix\Main\Config\Option::get("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);

$availablePages = array();

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'],
		"name" => Loc::getMessage("SPS_ORDER_PAGE_NAME"),
		"icon" => '<i class="fa fa-calculator"></i>'
	);
}

if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ACCOUNT'],
		"name" => Loc::getMessage("SPS_ACCOUNT_PAGE_NAME"),
		"icon" => '<i class="fa fa-credit-card"></i>'
	);
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PRIVATE'],
		"name" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
		"icon" => '<i class="fa fa-user-secret"></i>'
	);
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{

	$delimeter = ($arParams['SEF_MODE'] === 'Y') ? "?" : "&";
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'].$delimeter."filter_history=Y",
		"name" => Loc::getMessage("SPS_ORDER_PAGE_HISTORY"),
		"icon" => '<i class="fa fa-list-alt"></i>'
	);
}

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PROFILE'],
		"name" => Loc::getMessage("SPS_PROFILE_PAGE_NAME"),
		"icon" => '<i class="fa fa-list-ol"></i>'
	);
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_BASKET'],
		"name" => Loc::getMessage("SPS_BASKET_PAGE_NAME"),
		"icon" => '<i class="fa fa-shopping-cart"></i>'
	);
}

if ($arParams['SHOW_SUBSCRIBE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_SUBSCRIBE'],
		"name" => Loc::getMessage("SPS_SUBSCRIBE_PAGE_NAME"),
		"icon" => '<i class="fa fa-envelope"></i>'
	);
}

if ($arParams['SHOW_CONTACT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_CONTACT'],
		"name" => Loc::getMessage("SPS_CONTACT_PAGE_NAME"),
		"icon" => '<i class="fa fa-info-circle"></i>'
	);
}

$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList)
{
	foreach ($customPagesList as $page)
	{
		$availablePages[] = array(
			"path" => $page[0],
			"name" => $page[1],
			"icon" => (strlen($page[2])) ? '<i class="fa '.htmlspecialcharsbx($page[2]).'"></i>' : ""
		);
	}
}

if (empty($availablePages))
{
	ShowError(Loc::getMessage("SPS_ERROR_NOT_CHOSEN_ELEMENT"));
}
else
{
	?>
<?/*
	<div class="row">
		<div class="col-md-12 sale-personal-section-index">
			<div class="row sale-personal-section-row-flex">
				<?
				foreach ($availablePages as $blockElement)
				{
					?>
					<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
						<div class="sale-personal-section-index-block bx-theme-<?=$theme?>">
							<a class="sale-personal-section-index-block-link" href="<?=htmlspecialcharsbx($blockElement['path'])?>">
								<span class="sale-personal-section-index-block-ico">
									<?=$blockElement['icon']?>
								</span>
								<h2 class="sale-personal-section-index-block-name">
									<?=htmlspecialcharsbx($blockElement['name'])?>
								</h2>
							</a>
						</div>
					</div>
					<?
				}
				?>
			</div>
		</div>
	</div>
*/?>

  <div class="account">
    <div class="container">
      <div class="account__body">
        <div class="account__item">
          <a href="/personal/private/" class="account__link">
            <div class="account__img">
              <i class="account-data"></i>
            </div>
            <h3 class="account__name">Личные данные</h3>
          </a>
        </div>
        
		  	<div class="account__item">
          <a href="/personal/requests/" class="account__link">
            <div class="account__img">
              <i class=" account-order"></i>
            </div>
            <h3 class="account__name">Заявки</h3>
          </a>
		  	</div>
		  	<div class="account__item">
          <a href="/personal/kp/" class="account__link">
            <div class="account__img">
              <i class=" account-order"></i>
            </div>
            <h3 class="account__name">КП</h3>
          </a>
		 		</div>
		  	<div class="account__item">
          <a href="/personal/order/" class="account__link">
            <div class="account__img">
              <i class=" account-order"></i>
            </div>
            <h3 class="account__name">Заказы</h3>
          </a>
		 	 	</div>
		 	 	<div class="account__item">
          <a href="/personal/bill/" class="account__link">
            <div class="account__img">
              <i class=" account-order"></i>
            </div>
            <h3 class="account__name">Счета</h3>
          </a>
		 	 	</div>
		  <?/*
        <div class="account__item">
          <a href="#" class="account__link">
            <div class="account__img">
              <i class=" account-tasks"></i>
            </div>
            <h3 class="account__name">Текущие задачи</h3>
          </a>
        </div>
        <div class="account__item">
          <a href="/personal/subscribe/" class="account__link">
            <div class="account__img">
              <i class=" account-subscr"></i>
            </div>
            <h3 class="account__name">Подписки</h3>           
          </a>
</div>*/?>
      </div>
    </div>
  </div>

	<?
}
?>
