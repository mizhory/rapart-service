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
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
        <div class="news__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
          <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
            <div class="news__img">
			<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
            </div>
            <div class="news__content">
              <div class="h5 news__content_title"><?=$arItem['NAME']?></div>

              <p class="news__content_text">
                <?=$arItem['PREVIEW_TEXT']?>
              </p>
            </div>
          </a>
        </div>

<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
    </div>
  </div>

