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
    <div class="section advantages">
      <div class="container">
        <h2 class="section-title">
          Our advantage
        </h2>
        <div class="advantages__slide">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
          <div class="advantages__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="advantages__img">
              <img src="<?=cfile::getpath($arItem['PROPERTIES']['ATT_SVG']['VALUE']);?>" alt="">
            </div>
            <h4 class="advantages__title"><?=$arItem['NAME']?></h4>
            <p class="advantages__descr"><?=$arItem['PREVIEW_TEXT']?></p>
          </div>
<?endforeach;?>
        </div>
      </div>
    </div><!-- /section -->
