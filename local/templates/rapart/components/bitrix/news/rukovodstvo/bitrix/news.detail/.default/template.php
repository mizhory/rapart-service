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
<?/*
  <div class="news">
    <div class="container">
      <div class="news__wrap">
        <div class="news__item news__item_one">

          <div class="news__img">
			  <?if (!empty($arResult['DETAIL_PICTURE']['SRC'])){?>
            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="">
			  <?}else{?>
			<img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" alt="">
			  <?}?>
          </div>
          <div class="news__content">
            <div class="h5 news__content_title"><?=$arResult['NAME']?></div>

            <p class="news__content_text">
              <?=$arResult['DETAIL_TEXT']?>
            </p>
            <div class="content__btn news__content_btn">
				<a href="/rukovodstvo/">Назад</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
*/?>

<div class="direction-one">
    <div class="container">
      <div class="direction-one__body">
        <div class="direction-one__left">
          <div class="direction-one__img">
			  <?if (!empty($arResult['DETAIL_PICTURE']['SRC'])){?>
            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="">
			  <?}else{?>
			<img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" alt="">
			  <?}?>
          </div>
          <div class="direction-one__name">
              <?=$arResult['NAME']?>
          </div>
          <span class="direction-one__rank"><?=$arResult['PROPERTIES']['ATT_DOLJ']['VALUE']?></span>
			<?if (!empty($arResult['PROPERTIES']['ATT_NAP']['VALUE'])):?>
          <ul class="direction-one__list">
            <li>Направления деятельности:</li>
			<?foreach ($arResult['PROPERTIES']['ATT_NAP']['VALUE'] as $nap):?>
			  <li><?=$nap;?></li>
			<?endforeach;?>
          </ul>
			<?endif;?>
        </div>
        <div class="direction-one__descr">
			<?=$arResult['DETAIL_TEXT']?><br>
            <div class="content__btn news__content_btn">
				<a href="/rukovodstvo/">Назад</a>
            </div>
        </div>

      </div>

    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
$('.main-title').html('<?if (!empty($arResult['PROPERTIES']['ATT_SOVET']['VALUE'])){?>Совет директоров<?}else if (!empty($arResult['PROPERTIES']['ATT_GEN']['VALUE'])){?>Генеральный директор<?}else if (!empty($arResult['PROPERTIES']['ATT_ZAM']['VALUE'])){?>Заместитель генерального директора<?}?>');
});

$(document).ready(function(){
$('.bx-breadcrumb-item span').html('<?if (!empty($arResult['PROPERTIES']['ATT_SOVET']['VALUE'])){?>Совет директоров<?}else if (!empty($arResult['PROPERTIES']['ATT_GEN']['VALUE'])){?>Генеральный директор<?}else if (!empty($arResult['PROPERTIES']['ATT_ZAM']['VALUE'])){?>Заместитель генерального директора<?}?>');
});


</script>

