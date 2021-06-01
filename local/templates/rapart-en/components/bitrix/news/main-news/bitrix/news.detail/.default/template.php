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
  <div class="news">
    <div class="container">
      <div class="news__wrap">
        <div class="news__item news__item_one">

          <div class="news__img">
            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="">
          </div>
          <div class="news__content">
            <div class="h5 news__content_title"><?=$arResult['NAME']?></div>

            <p class="news__content_text">
              <?=$arResult['DETAIL_TEXT']?>
            </p>
            <div class="content__btn news__content_btn">
				<a href="/en/news/">Back to news</a>
            </div>
            <div class="content__btn">
				<a href="/en/">On the main</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>