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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <?$APPLICATION->ShowHead();?>
</head>
<body>
<?$APPLICATION->ShowPanel();?>
  <div <?if ($APPLICATION->GetCurPage() == "/"):?>id="fullpage"<?endif;?>>
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
				        "PATH" => "/include/header/phone.php" 
				    )
				);?>
                <span>|</span>
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
				        "AREA_FILE_SHOW" => "file", 
				        "AREA_FILE_SUFFIX" => "inc",
				        "EDIT_TEMPLATE" => "",
				        "PATH" => "/include/header/email.php" 
				    )
				);?>
              </div>
              <div class="header-top__profile">
				  <?if ($USER->IsAuthorized()){?>
                <a class="header-top__user" href="/personal/"></a>
				  <?}else{?>
				  <a class="header-top__user popup" href="#popup-enter"></a>
				  <?}?>
				  <?if ($USER->IsAuthorized()){?>
                <a class="header-top__cart" href="/personal/cart/">
				  <?}else{?>
				  <a class="header-top__user popup" href="#popup-enter"></a>
				  <?}?>
                  <span class="header-top__cart_counter" id="chart-value">
					<!-- -->
                  </span>
                </a>
                <div class="header-language" id="languages">
                  <input type="checkbox" class="checkbox" onclick="javascript:document.location.href='/en/'">
                  <div class="knobs"><span>RU</span></div>
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
				        "PATH" => "/include/header/logo.php" 
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

<?if ($APPLICATION->GetCurPage() != "/" AND $APPLICATION->GetCurPage() != "/catalog/" AND $APPLICATION->GetCurPage() != "/about/"):?>
    <div class="<?if ($APPLICATION->GetCurPage() == "/contacts/"){echo "main main-page main-contacts";}elseif($APPLICATION->GetCurPage() == "/news/"){echo "main main-page main-news";}elseif($APPLICATION->GetCurPage() == "/about/sertifikaty/" OR $APPLICATION->GetCurPage() == "/about/gallery/"){echo "main main-page main-certificate";}elseif($APPLICATION->GetCurPage() == "/personal/cart/"){echo "cart main";}else{echo "cart main";}?>">
	 <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", Array(
		"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
			"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
			"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
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