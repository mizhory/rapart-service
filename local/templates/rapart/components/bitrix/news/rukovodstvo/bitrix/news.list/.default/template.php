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
<div class="direction">
  <div class="container">

    <div class="direction__body">
      <h2 class="direction__title section-title">Совет директоров</h2>
      <div class="direction__list">
		<?foreach ($arResult['ITEMS'] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		  <?if ($arItem['PROPERTIES']['ATT_SOVET']['VALUE'] == "Y"):?>
        <div class="direction__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
          <div class="direction__img">
			  <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" /></a>
          </div>
          <div class="direction__text">
            <span class="direction__text_name">
              <?=$arItem['NAME']?>
            </span>
            <span class="direction__text_rank"><?=$arItem['PROPERTIES']['ATT_DOLJ']['VALUE']?></span>
          </div>
        </div>
		<?endif;?>
		<?endforeach;?>
      </div>
      <!-- /.direction__list/ -->
		<?foreach ($arResult['ITEMS'] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		  <?if ($arItem['PROPERTIES']['ATT_GEN']['VALUE'] == "Y"):?>
      <div class="direction__general general" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="general__body">
          <div class="general__img">
			  <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" /></a>
          </div>
          <div class="general__block">
            <div class="general__text">
              <span class="general__text_name"><?=$arItem['NAME']?></span>
              <span class="general__text_rank"><?=$arItem['PROPERTIES']['ATT_DOLJ']['VALUE']?></span>
            </div>
            <div class="general__quote">
              <p>
                <?=$arItem['PREVIEW_TEXT']?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- /.direction__general/ -->
		<?endif;?>
		<?endforeach;?>
      <h2 class="direction__title deputy__title section-title">Заместители генерального директора</h2>
      <div class="direction__deputy deputy">
        <div class="deputy__wrap">
		<?foreach ($arResult['ITEMS'] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		  <?if ($arItem['PROPERTIES']['ATT_ZAM']['VALUE'] == "Y"):?>
          <div class="deputy__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="deputy__img direction__img">
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" /></a>
            </div>
            <div class="deputy__block"> 
              <div class="deputy__text">
                <span class="deputy__text_name"><?=$arItem['NAME']?></span>
                <span class="deputy__text_rank"><?=$arItem['PROPERTIES']['ATT_DOLJ']['VALUE']?></span>
              </div>             
            </div>
          </div>
		<?endif;?>
		<?endforeach;?>
        </div>
      </div>
      <!-- /.direction__deputy/ -->
    </div>
  </div>
  <!-- container -->
</div>