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


<div class="main">
        <span class="back-line"></span>
        <div class="container">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
          <div class="main-block" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="main__wrap">
              <div class="main-text">
                <h1 class="main-title">
                  <?=$arItem['NAME']?>
                </h1>
                <ul class="main-list">
                  <?=$arItem['PREVIEW_TEXT']?>
                </ul>
              </div>
              <div class="main-img wow lightSpeedOut" data-wow-duration="2s" data-wow-delay="0.5s">
                <img src="<?=SITE_TEMPLATE_PATH?>/img/main/main-img.png" alt="Alt">
              </div>
            </div>
          </div>
          <div class="main-btn">
            <a href="<?=$arItem['PROPERTIES']['ATT_HREF']['VALUE']?>" class="btn-link">
              <span>Подробнее</span>
            </a>
          </div>
<?endforeach;?>
        </div>
      </div>