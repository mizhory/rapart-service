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
<div class="certificate">
    <div class="container">
      <div class="certificate__wrap">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
		<div class="certificate__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
          <div class="certificate__img">
            <a class="image-popup-vertical-fit" href="<?=$arItem['DETAIL_PICTURE']['SRC']?>">
              <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="Alt">
            </a>
			</div>
			<div class="certificate__text">
            <h5 class="certificate__title"><?=$arItem['NAME']?></h5>
            <p class="certificate__descr"><?=$arItem['PREVIEW_TEXT']?></p>
          </div>
		</div>

<?endforeach;?>




      </div>
    </div>
    <div class="products__result">
      <div class="container">
        <div class="products__result_wrap">
          <div class="products__result_block">
            <span class="products__result_text">Результатов на страницу</span>
            <a class="products__result_link <?if($_GET['result']==50){echo 'result-active';}?>" href="?result=50">50</a>
            <a class="products__result_link <?if($_GET['result']==100){echo 'result-active';}?>" href="?result=100">100</a>
            <a class="products__result_link <?if($_GET['result']==200){echo 'result-active';}?>" href="?result=200">200</a>
          </div>
        </div>
      </div>
    </div>


<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
<br /><br /><br />