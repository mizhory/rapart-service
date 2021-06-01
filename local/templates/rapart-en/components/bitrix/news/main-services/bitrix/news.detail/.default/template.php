<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
  <div class="service">
    <div class="container">
      <div class="service__wrap">

        <div class="service__item service-active">
          <a href="#">
            <div class="advantages__img">
				<img src="<?=cfile::getpath($arResult['PROPERTIES']['ATT_SVG']['VALUE']);?>" alt="">
            </div>
          </a>
        </div>
        <div class="service__content">
          <h4 class="service__title advantages__title"><?=$arResult['NAME']?></h4>
          <p class="service__content_text">
            <?=$arResult['DETAIL_TEXT']?>
          </p>
          <div class="content__btn">
			  <a href="/en/services/">Back</a>
          </div>
          <div class="content__btn">
			  <a href="/">Main</a>
          </div>
        </div>
      </div>

    </div>
  </div>
