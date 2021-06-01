<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(57049762, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/57049762" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>
  <title><?$APPLICATION->ShowTitle()?></title>
  <?Asset::getInstance()->addString("<link rel='icon' href='/local/templates/rapart/img/favicon/favicon.ico'>");?>
  <?Asset::getInstance()->addString("<link rel='apple-touch-icon' sizes='180x180' href='/local/templates/rapart/img/favicon/apple-icon.png'>");?>
  <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/animate.css");?>
  <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/fullpage.css");?>
  <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/slick.css");?>
  <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/magnific-popup.css");?>
  <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.css");?>
  <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/styles-new.css");?>
  <?Asset::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=Montserrat:500,600,800&display=swap' rel='stylesheet'>");?>
  <?$APPLICATION->ShowHead();?>
</head>
<body>
<?$APPLICATION->ShowPanel();?>
  <div <?if ($APPLICATION->GetCurPage() == "/en/"):?>id="fullpage"<?endif;?>>
    <div class="section">

      <div class="header">
        <div class="header-top" <?if ($USER->IsAdmin()) echo "style='margin-top: 20px;'";?>>
          <div class="container">
            <div class="header-top__wrap">
              <div class="header-top__contacts">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
				        "AREA_FILE_SHOW" => "file", 
				        "AREA_FILE_SUFFIX" => "inc",
				        "EDIT_TEMPLATE" => "",
				        "PATH" => "/en/include/header/phone.php" 
				    )
				);?>
                <span>|</span>
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
				        "AREA_FILE_SHOW" => "file", 
				        "AREA_FILE_SUFFIX" => "inc",
				        "EDIT_TEMPLATE" => "",
				        "PATH" => "/en/include/header/email.php" 
				    )
				);?>
              </div>
              <div class="header-top__profile">
				  <?if ($USER->IsAuthorized()){?>
                <a class="header-top__user" href="/en/personal/"></a>
				  <?}else{?>
				  <a class="header-top__user popup" href="#popup-enter"></a>
				  <?}?>
                <a class="header-top__cart" href="/en/personal/cart/">
                  <span class="header-top__cart_counter" id="chart-value">
					<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line", 
	"main", 
	array(
		"HIDE_ON_BASKET_PAGES" => "N",
		"PATH_TO_AUTHORIZE" => "",
		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
		"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"PATH_TO_PROFILE" => SITE_DIR."personal/",
		"PATH_TO_REGISTER" => SITE_DIR."login/",
		"POSITION_FIXED" => "N",
		"SHOW_AUTHOR" => "N",
		"SHOW_EMPTY_VALUES" => "Y",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_PERSONAL_LINK" => "Y",
		"SHOW_PRODUCTS" => "N",
		"SHOW_REGISTRATION" => "Y",
		"SHOW_TOTAL_PRICE" => "Y",
		"COMPONENT_TEMPLATE" => "main"
	),
	false
);?>
                  </span>
                </a>
                <div class="header-language" id="languages">
                  <input type="checkbox" class="checkbox" onclick="javascript:document.location.href='/'">
                  <div class="knobs"><span>ENG</span></div>
                  <div class="layer"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="header-nav">
          <span class="back-line"></span>
          <div class="container">
            <div class="header-logo">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
				        "AREA_FILE_SHOW" => "file", 
				        "AREA_FILE_SUFFIX" => "inc",
				        "EDIT_TEMPLATE" => "",
				        "PATH" => "/en/include/header/logo.php" 
				    )
				);?>
            </div>
            <div class="toggle"><span></span></div>
            <?$APPLICATION->IncludeComponent("bitrix:menu", "main-header-menu", Array(
              "ROOT_MENU_TYPE" => "top",  // Тип меню для первого уровня
                "MAX_LEVEL" => "1", // Уровень вложенности меню
                "CHILD_MENU_TYPE" => "top", // Тип меню для остальных уровней
                "USE_EXT" => "N", // Подключать файлы с именами вида .тип_меню.menu_ext.php
                "DELAY" => "N", // Откладывать выполнение шаблона меню
                "ALLOW_MULTI_SELECT" => "N",  // Разрешить несколько активных пунктов одновременно
                "MENU_CACHE_TYPE" => "N", // Тип кеширования
                "MENU_CACHE_TIME" => "3600",  // Время кеширования (сек.)
                "MENU_CACHE_USE_GROUPS" => "Y", // Учитывать права доступа
                "MENU_CACHE_GET_VARS" => "",  // Значимые переменные запроса
                "COMPONENT_TEMPLATE" => ".default"
              ),
              false
            );?>
          </div>
        </div>
      </div>

<?if ($APPLICATION->GetCurPage() != "/en/" AND $APPLICATION->GetCurPage() != "/en/catalog/" AND $APPLICATION->GetCurPage() != "/en/about/"):?>
    <div class="<?if ($APPLICATION->GetCurPage() == "/en/contacts/"){echo "main main-page main-contacts";}elseif($APPLICATION->GetCurPage() == "/en/news/"){echo "main main-page main-news";}elseif($APPLICATION->GetCurPage() == "/en/about/sertifikaty/" OR $APPLICATION->GetCurPage() == "/en/about/gallery/"){echo "main main-page main-certificate";}elseif($APPLICATION->GetCurPage() == "/en/personal/cart/"){echo "cart main";}else{echo "main main-page main-news";}?>">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	"main", 
	array(
		"PATH" => "",
		"SITE_ID" => "s2",
		"START_FROM" => "0",
		"COMPONENT_TEMPLATE" => "main"
	),
	false
);?>
      <span class="back-line"></span>
      <div class="container">
        <div class="main-block">
          <div class="main__wrap">
            <div class="main-text">
              <h1 class="main-title">
                <?$APPLICATION->ShowTitle()?>
              </h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /section -->
<?endif;?>