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
<div class="partners">
    <span class="back-line"></span>
    <div class="partners__wrap">
      <div class="container">
        <h2 class="partners-title section-title">Partners</h2>
      </div>
    </div>
    <div class="container">

      <div class="partners-block">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
		<div class="partners-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" class="partners-img">
        </div>
<?endforeach;?>
      </div>
    </div>
  </div>

