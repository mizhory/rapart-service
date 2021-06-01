<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
?>
<footer class="footer section fp-auto-height">
  <div class="container">
    <div class="footer-top">
      <div class="footer__company"><?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
				        "AREA_FILE_SHOW" => "file", 
				        "AREA_FILE_SUFFIX" => "inc",
				        "EDIT_TEMPLATE" => "",
	"PATH" => "/en/include/footer/copy.php" 
				    )
				);?></div>
      <div class="footer__politic">
		  <a href="/en/polzovatelskoe-soglashenie/">User agreement</a></div>
    </div>
  </div>

  <div class="footer-nav">
    <span class="black-line"></span>
    <div class="container">
      <div class="footer-nav__wrap">
        <div class="footer-img">
          <a href="#">
<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
				        "AREA_FILE_SHOW" => "file", 
				        "AREA_FILE_SUFFIX" => "inc",
				        "EDIT_TEMPLATE" => "",
	"PATH" => "/en/include/footer/img.php" 
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
     <?/*<a class="active" href="#">Enter</a>*/?>
	  <?/*<a class="popup" href="#register">Register</a>*/?>
  </div>
  <p class="form-subtitle">Log in to your account,
 in order not to lose
 favorite products</p>
	<form class="form" method="POST"action="/ajax/auth.php">
	<div id="resultauth" align="center"></div>
    <input type="text" name="login" placeholder="введите логин">
    <input type="password" name="password" placeholder="введите пароль">
    <button type="submit" class="form-button">Enter</button>
		<span class="password-restore"><a class="" href="/en/personal/reset/">recover the password</a></span>
  </form>
</div>

<div id="register" class="zoom-anim-dialog mfp-hide">
  <div class="success">
    <div class="success-text">
      Thanks! The data has been sent.
    </div>
  </div>
  <h4 class="form-title">Register</h4>
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

<div id="order" class="zoom-anim-dialog mfp-hide order-form">
  <div class="success">
    <div class="success-text">
      Your request has been sent
      <a href="">ok</a>
    </div>
  </div>
  <div class="order__item" style="display:none;">
	  <div class="order__block order__name">
      <div class="product__info order-request"><a href="#"></a>Запрос</div>
      <div class="product__info order-product"><a href="#">Наименование товарв</a></div>
    </div>
    <div class="order__block  order__value">
      <div class="product__info">
        <div class="product__quantity">
          <div class="product__value">
            <button class="product__value_minus" type="button" onclick="this.nextElementSibling.stepDown()">-</button>
            <input type="number" min="0" max="100" value="1" class="product__value_num">
            <button class="product__value_plus" type="button" onclick="this.previousElementSibling.stepUp()">+</button>
          </div>
          <span class="product__delete">&#10006;</span>
        </div>
      </div>
    </div>
  </div>
  
  <p class="form-subtitle">После отправки запроса менеджер свяжется <br> с Вами в ближайшее время</p>
  <form class="form">
    <input type="text" name="name" placeholder="Ваше имя"></p>
    <input type="email" name="email" placeholder="E-mail"></p>
    <input type="tel" name="phone" placeholder="Контактный номер +7 ХХХ ХХХ ХХХХ"></p>
    <textarea name="message" id="" cols="30" rows="10" placeholder="Комментарий"></textarea>
    <button type="submit" class="form-button">ОТПРАВИТЬ</button>
  </form>
</div>

<div id="toCart" class="zoom-anim-dialog mfp-hide">
	
  The item is added to cart
	<a href="/en/catalog/">BACK TO CATALOG</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/fullpage.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/wow.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/slick.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.magnific-popup.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/main.js"></script>
</body>
</html>