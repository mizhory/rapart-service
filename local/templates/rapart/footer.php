<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
?>
<footer class="footer section fp-auto-height">
  <div class="container">
    <div class="footer-top">
      <div class="footer__company">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
				        "AREA_FILE_SHOW" => "file", 
				        "AREA_FILE_SUFFIX" => "inc",
				        "EDIT_TEMPLATE" => "",
				        "PATH" => "/include/footer/copy.php" 
				    )
				);?></div>
      <div class="footer__politic">
        <a href="/polzovatelskoe-soglashenie/">Пользовательское соглашение</a></div>
    </div>
  </div>

  <div class="footer-nav">
    <span class="black-line"></span>
    <div class="container">
      <div class="footer-nav__wrap">
        <div class="footer-img">
          <a href="https://rostec.ru/anticorruption/feedback">
<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
				        "AREA_FILE_SHOW" => "file", 
				        "AREA_FILE_SUFFIX" => "inc",
				        "EDIT_TEMPLATE" => "",
				        "PATH" => "/include/footer/img.php" 
				    )
				);?>

</a>
        </div>
            <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"main-footer-menu", 
	array(
		"ROOT_MENU_TYPE" => "bottom",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "bottom",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "main-footer-menu"
	),
	false
);?>
      </div>
    </div>
</footer><!-- /section -->

<div id="popup-enter" class="zoom-anim-dialog mfp-hide">
  <div class="form-reg">
     <?/*<a class="active" href="#">Войти</a>*/?>
	  <?/*<a class="popup" href="#register">Зарегистрироваться</a>*/?>
  </div>
  <p class="form-subtitle">Войдите в личный кабинет,
    чтобы не потерять
    понравившиеся товары</p>
	<form class="form" method="POST"action="/ajax/auth.php">
	<div id="resultauth" align="center"></div>
    <input type="text" name="login" placeholder="введите логин">
    <input type="password" name="password" placeholder="введите пароль">
    <button type="submit" class="form-button">Войти</button>
    <span class="password-restore"><a class="" href="/personal/reset/">восстановить пароль</a></span>
  </form>
</div>

<div id="register" class="zoom-anim-dialog mfp-hide">
  <div class="success">
    <div class="success-text">
      Спасибо! Данные успешно отправлены.
    </div>
  </div>
  <h4 class="form-title">Регистрация</h4>
  <form class="form">

    <input type="text" name="company" placeholder="Компания"></p>
    <input type="text" name="name" placeholder="Имя"></p>
    <input type="text" name="surname" placeholder="Фамилия"></p>
    <input type="text" name="otch" placeholder="Отчество"></p>
    <input type="tel" name="rank" placeholder="Должность"></p>
    <input type="text" name="login" placeholder="Логин"></p>
    <input type="password" name="password" placeholder="Пароль"></p>
    <input type="password" name="cpassword" placeholder="Подтверждения пароля"></p>
    <input type="email" name="email" placeholder="E-mail"></p>

    <button type="submit" class="form-button">Зарегистрироваться</button>
  </form>
</div>



<div id="toCart" class="zoom-anim-dialog mfp-hide">
	
  Товар добавлен в корзину
	<a href="">ВЕРНУТЬСЯ В КАТАЛОГ</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/fullpage.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/wow.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/slick.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.magnific-popup.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/main.js"></script>
</body>
</html>