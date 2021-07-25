<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<?global $APPLICATION, $USER;?>
<style>

    .product__btn {
        display: inline-block;
        padding: 10px 30px;
        border: none;
        border-radius: 27px;
        background-color: #232257;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
    }
    .products__name {
        background:linear-gradient(#DDD, #BBB);
    }
    .not-show {
        display: none;
    }
.table_sort table {
    border-collapse: collapse;
}


th.sorted[data-order="1"],
th.sorted[data-order="-1"] {
    position: relative;
}

th.sorted[data-order="1"]::after,
th.sorted[data-order="-1"]::after {
    right: 8px;
    position: absolute;
}

th.sorted[data-order="-1"]::after {
	content: "▼"
}

th.sorted[data-order="1"]::after {
	content: "▲"
}
</style>
<?if($arParams['PRIZNAK'] == 'order'):?>
<nav class="shop-nav" style="margin-top:20px; margin-bottom: 20px;">
	<div class="sort shop-nav__item"><span class="sort-label">Сортировать по:</span>
	<select name="sort" class="popup">
		<option<?if($arResult['COL_SORT']==1):?> selected<?endif;?> value="1">Номер</option>
		<option<?if($arResult['COL_SORT']==2):?> selected<?endif;?> value="2">Дата</option>
		<option<?if($arResult['COL_SORT']==3):?> selected<?endif;?> value="3">Приоритет</option>
		<option<?if($arResult['COL_SORT']==4):?> selected<?endif;?> value="4">Номер Заказчика</option>
		<option<?if($arResult['COL_SORT']==5):?> selected<?endif;?> value="5">Состояние</option>
		</select>
		<button data-asc="<?=isset($arResult['SORT_METHOD'])?$arResult['SORT_METHOD']:'asc'?>" class="sort-btn<?if($arResult['SORT_ACT'] == 'Y'):?> activee<?endif;?>">
			<?=!isset($arResult['SORT_NAME'])?"Возрастанию":$arResult['SORT_NAME']?>
		</button>
	</div>



      <div class="search shop-nav__item">
          <form method="get" action="?SEARCH=Y">
              <input type="text" class="search__input" name="q" placeholder="Поиск" value="" required="">
              <input type="submit" class="search__button">
          </form>
      </div>
      <div class="shop-nav__quantity shop-nav__item">
		Количество:
		<a href="?" class="actives">30</a>
		<a href="?с=50" class="">50</a>
		<a href="?с=100" class="">100</a>
      </div><!--
    </nav>-->
    <table class="table_sort" width="100%" style="text-align:center;">
        <thead>
        <tr>
			<th width="5%" class="products__name">№</th>
			<th width="17%" class="products__name">Дата</th>
            <th width="17%" class="products__name">Приоритет</th>
            <th width="17%" class="products__name">№ Заказчика</th>
            <th width="17%" class="products__name">Состояние</th>
            <th width="26%" class="products__name">Действия</th>
        </tr>
        </thead>
		<tbody>
		<?foreach($arResult['ITEMS'] as $k=>$arItems):?>
			<tr style="border-bottom: 1px solid #000;">
					<td width="5%" style="padding-top:5px" class=""><?=$k?></td>
                    <td width="17%" style="padding-top:5px" class=""><?=$arItems["UF_DATE"]?></td>
                    <td width="17%" style="padding-top:5px" class=""><?=$arItems['UF_PRIORITY']?></td>
                    <td width="17%" style="padding-top:5px" class=""><?=$arItems['UF_USER_ID']?></td>
                    <td width="17%" style="padding-top:5px" class="" style="text-align: center;font-size: 11px;">
                        <img src="<?=$arItems['UF_STATUS']['PICTURE']?>" alt="<?=$arItems['UF_STATUS']['NAME']?>" title="<?=$arItems['UF_STATUS']['NAME']?>" />
                        <br />
                        <span><?=$arItems['UF_STATUS']['NAME']?></span>
                    </td>
					<td width="26%" style="padding-top:5px;padding-left:10px;padding-bottom: 15px;" class="">
                    <ul class="nav-menu">
                        <li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$k?>" class="detail product__btn">Просмотреть</a></li>
                        <li style="margin-bottom: 10px;"><a href="javacript:void(0);" data-kid="<?=$k?>" class="check-kp product__btn">КП</a></li>
                        <li style="margin-bottom: 10px;"><a href="javascript:void(0);" class="check-order product__btn" data-kid="<?=$k?>">Счет заказа</a></li>
                        <li><a href="javascript:void(0);" class="check-rtiu product__btn" data-kid="<?=$k?>">РТУ файлы</a></li>
                    </ul>
                    </td>
                </tr>
				<tr>
				<td colspan="6">
					<table class="not-show detail-<?=$k?>" width="100%" style="text-align:center;">
					<thead>
					 <tr>
						<td colspan="11"><b>Детально Заказ <?=$arItems['UF_NAME']?></b></td>
					</tr>
					<tr>
						<th class="products__name">№</th>
						<th class="products__name">Товарная позиция</th>
						<th class="products__name">Кол-во ЕИ</th>
						<th class="products__name">Цена</th>
						<th class="products__name">Сумма</th>
						<th class="products__name">Ставка НДС</th>
						<th class="products__name">Сумма с НДС</th>
						<th class="products__name">Срок поставки</th>
						<th class="products__name">Заявка</th>
						<th class="products__name">Состояние</th>
						<th class="products__name">В заказ</th>
					</tr>
					</thead>
					<tbody>
				<?foreach($arItems['ELEMENTS'] as $e=>$arElements):?>
				<?
					$nds = ($arElements["PROPERTIES"]['PRICE']["PRICE"]*0.2)*intval($arElements['COUNT']);
					$currency_with_nds = ($arElements["PROPERTIES"]['PRICE']["PRICE"]+$nds) . $arElements["PROPERTIES"]['PRICE']['CURRENCY'];
					$summ = $arElements["PROPERTIES"]['PRICE']["PRICE"]*intval($arElements['COUNT']);
				?>
					<tr>
						<td><?=$arElements['ID']?></td>
						<td><?=$arElements["NAME"]?></td>
						<td><?=$arElements['COUNT']?></td>
						<td><?=$arElements["PROPERTIES"]['PRICE']['PRICE']?></td>
						<td><?=$summ?></td>
						<td>20%</td>
						<td><?=$currency_with_nds?></td>
						<td><?=$arElements["PROPERTIES"]['SROK_POSTAVKI']['VALUE']?></td>
						<td><?=$arElements["ID"]?></td>
						<td>Состояние</td>
						<td><input type="checkbox" name="detail[<?=$k?>]" /></td>
					</tr>
				<?endforeach;?>
				</tbody>
				</table>
				<table class="not-show kp-<?=$k?>" width="100%" style="text-align:center;">
				<thead>
					<tr>
						<th colspan="4"><b>КП Заказ <?=$arItems['UF_NAME']?></b></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
					</tr>
					<tr>
						<th class="products__name">№</th>
						<th class="products__name">Товарная позиция</th>
						<th class="products__name">Скачать</th>
						<th class="products__name">Статус</th>
					</tr>
				</thead>
				<tbody>
				<?foreach($arItems['KP'] as $e=>$arKP):?>
					<?foreach($arItems['ELEMENTS'] as $z=>$m):?>
						<?if($m['ID'] == $arKP['UF_ITEM_ID']):?>
							<?$item = $m;break;
$arKP['UF_CO_FILE'] = CFile::GetFileArray($arKP['UF_CO_FILE']);
?>
						<?endif;?>
					<?endforeach;?>
					<tr>
						<td><?=$arKP['UF_CO_ID']?></td>
						<td><?=$item['NAME']?></td>
						<td><a href="<?=$arKP['UF_CO_FILE']["SRC"]?>" download>Скачать</a></td>
						<td class="" style="text-align: center;font-size: 11px;">
							<img src="<?=$arKP['STATUS']['PICTURE']?>" alt="<?=$arItems['STATUS']['NAME']?>" title="<?=$arKP['STATUS']['NAME']?>" />
							<br />
							<span><?=$arKP['STATUS']['NAME']?></span>
						</td>
					</tr>
				<?endforeach;?>
				</tbody>
				</table>
				<table class="not-show order-<?=$k?>" width="100%" style="text-align:center;">
				<thead>
					<tr>
						<th colspan="11"><b>Cчета Заказ <?=$arItems['UF_NAME']?></b></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
					</tr>
					<tr>
						<th class="products__name">№</th>
						<th class="products__name">P/N</th>
						<th class="products__name">Кол-во ЕИ</th>
						<th class="products__name">Цена</th>
						<th class="products__name">Сумма</th>
						<th class="products__name">Ставка НДС</th>
						<th class="products__name">Сумма с НДС</th>
						<th class="products__name">Срок поставки</th>
						<th class="products__name">Заявка</th>
						<th class="products__name">Состояние</th>
						<th class="products__name">В заказ</th>
					</tr>
				</thead>
				<tbody>
				<?foreach($arItems['INVOICE'] as $e=>$arElements):?>
					<?
					$nds = ($arElements["PROPERTIES"]['PRICE']["PRICE"]*0.2)*intval($arElements['COUNT']);
					$currency_with_nds = ($arElements["PROPERTIES"]['PRICE']["PRICE"]+$nds) . $arElements["PROPERTIES"]['PRICE']['CURRENCY'];
					$summ = $arElements["PROPERTIES"]['PRICE']["PRICE"]*intval($arElements['COUNT']);
					?>
					<tr>
						<td><?=$arElements['ID']?></td>
						<td><?=$arElements["PROPERTIES"]['PN']['VALUE']?></td>
						<td><?=$arElements['COUNT']?></td>
						<td><?=$arElements["PROPERTIES"]['PRICE']['PRICE']?></td>
						<td><?=$summ?></td>
						<td>20%</td>
						<td><?=$currency_with_nds?></td>
						<td><?=$arElements["PROPERTIES"]['SROK_POSTAVKI']['VALUE']?></td>
						<td><?=$arElements["ID"]?></td>
						<td>Состояние</td>
						<td><input type="checkbox" name="detail[<?=$k?>]" /></td>
					</tr>
				<?endforeach;?>
				</tbody>
				</table>
					</td>
						<td colspan="0"></td>
						<td colspan="0"></td>
						<td colspan="0"></td>
						<td colspan="0"></td>
						<td colspan="0"></td>
				</tr>
			<?endforeach;?>
			</tbody>
		</table>

<?else:?>

    <nav class="shop-nav" style="margin-top:20px; margin-bottom: 20px;">
        <div class="sort shop-nav__item"><span class="sort-label">Сортировать по:</span>
            <select name="sort" class="product__btn popup">
                <option<?if($arResult['COL_SORT']==1):?> selected<?endif;?> value="1">Номер</option>
                <option<?if($arResult['COL_SORT']==2):?> selected<?endif;?> value="2">Дата </option>
                <option<?if($arResult['COL_SORT']==3):?> selected<?endif;?> value="3">Приоритет</option>
                <option<?if($arResult['COL_SORT']==4):?> selected<?endif;?> value="4">Номер Заказчика</option>
                <option<?if($arResult['COL_SORT']==5):?> selected<?endif;?> value="5">Состояние</option>
            </select>
            <button data-asc="<?=isset($arResult['SORT_METHOD'])?$arResult['SORT_METHOD']:'asc'?>" class="sort-btn<?if($arResult['SORT_ACT'] == 'Y'):?> activee<?endif;?>">
                <?=!isset($arResult['SORT_NAME'])?"Возрастанию":$arResult['SORT_NAME']?>
            </button>
        </div>



        <div class="search shop-nav__item">
            <form method="get" action="?SEARCH=Y">
                <input type="text" class="search__input" name="q" placeholder="Поиск" value="" required="">
                <input type="submit" class="search__button">
            </form>
        </div>
        <div class="shop-nav__quantity shop-nav__item">
            Количество:
            <a href="?" class="actives">30</a>
            <a href="?с=50" class="">50</a>
            <a href="?с=100" class="">100</a>
        </div>
    </nav>
    <table class="table_sort" width="100%" style="text-align:center;">
        <thead>
        <tr>
            <th width="15%" class="products__name">№</th>
            <th width="17%" class="products__name">Дата</th>
            <th width="17%" class="products__name">Приоритет</th>
            <th width="17%" class="products__name">№ Заказчика</th>
            <th width="17%" class="products__name">Состояние</th>
            <th width="17%" class="products__name">Действия</th>
        </tr>
        </thead>
		<tbody>
		<?foreach($arResult['ITEMS'] as $k=>$arItems):?>
        <tr style="border-bottom:1px solid;">
            <td width="15%"><?=$arItems['UF_NAME']?></td>
            <td width="17%"><?=$arItems['UF_DATE']?></td>
            <td width="17%"><?=$arItems['UF_PRIORITY']?></td>
            <td width="17%"><?=$arItems['UF_USER_ID']?></td>
            <td width="17%">
                <img src="<?=$arItems['UF_STATUS']['PICTURE']?>" alt="<?=$arItems['UF_STATUS']['NAME']?>" title="<?=$arItems['UF_STATUS']['NAME']?>" />
                <br />
                <span><?=$arItems['UF_STATUS']['NAME']?></span>
            </td>
            <td width="17%" style="padding-top:5px;padding-left:10px;padding-bottom: 15px;">
                <ul class="nav-menu">
                    <li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$k?>" class="detail product__btn">Просмотреть</a></li>
					<li style=""><a href="javascript:void(0);" data-kid="<?=$k?>" class="check-kp product__btn">КП детально</a></li>
                </ul>
            </td>
        </tr>
		<tr>
			<td colspan="6">
				<table class="not-show kp-<?=$k?>" width="100%" style="text-align:center;">
				<thead>
					<tr>
						<th colspan="4"><b>КП Детально <?=$arItems['UF_NAME']?></b></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
						<th colspan="0"></th>
					</tr>
					<tr>
						<th class="products__name">№</th>
						<th class="products__name">Товарная позиция</th>
						<th class="products__name">Скачать</th>
						<th class="products__name">Статус</th>
					</tr>
				</thead>
				<tbody>
				<?foreach($arItems['KP'] as $e=>$arKP):?>
					<?foreach($arItems['ELEMENTS'] as $z=>$m):?>
						<?if($m['ID'] == $arKP['UF_ITEM_ID']):?>
							<?$item = $m;break;
$arKP['UF_CO_FILE'] = CFile::GetFileArray($arKP['UF_CO_FILE']);
							?>
						<?endif;?>
					<?endforeach;?>
					<tr>
						<td><?=$arKP['UF_CO_ID']?></td>
						<td><?=$item['NAME']?></td>
						<td><a href="<?=$arKP['UF_CO_FILE']["SRC"]?>" download>Скачать</a></td>
						<td class="" style="text-align: center;font-size: 11px;">
							<img src="<?=$arKP['STATUS']['PICTURE']?>" alt="<?=$arItems['STATUS']['NAME']?>" title="<?=$arKP['STATUS']['NAME']?>" />
							<br />
							<span><?=$arKP['STATUS']['NAME']?></span>
						</td>
					</tr>
				<?endforeach;?>
				</tbody>
				</table>
				<table class="not-show detail-<?=$k?>" width="100%" style="text-align:center;">
					<thead>
					<tr>
						<th colspan="5"><b>Детализация заявки <?=$arItems['UF_NAME']?></b></th>
					</tr>
					<tr>
						<th class="products__name">№</th>
						<th class="products__name">Обозначение заказчика</th>
						<th class="products__name">P/N</th>
						<th class="products__name">Количество</th>
						<th class="products__name">Состояние</th>
					</tr>
					</thead>
					<tbody>
					<?foreach($arItems['ELEMENTS'] as $e=>$arElements):?>
						<?
						$nds = ($arElements["PROPERTIES"]['PRICE']["PRICE"]*0.2)*intval($arElements['COUNT']);
						$currency_with_nds = ($arElements["PROPERTIES"]['PRICE']["PRICE"]+$nds) . $arElements["PROPERTIES"]['PRICE']['CURRENCY'];
						$summ = $arElements["PROPERTIES"]['PRICE']["PRICE"]*intval($arElements['COUNT']);
						?>
						<tr>
							<td><?=$arElements['ID']?></td>
							<td><?=$arElements['NAME']?></td>
							<td><?=$arElements["PROPERTIES"]['PN']['VALUE']?></td>
							<td><?=$arElements['COUNT']?></td>
							<td>Состояние</td>
						</tr>
					<?endforeach;?>
					</tbody>
				</table>
			</td>

				<th colspan="0"></th>
				<th colspan="0"></th>
				<th colspan="0"></th>
				<th colspan="0"></th>
				<th colspan="0"></th>
		<?endforeach;?>
		</tbody>
    </table>
<?endif;?>
<?
$APPLICATION->IncludeComponent(
    "bitrix:main.pagenavigation",
    "",
    array(
        "NAV_OBJECT" => $arResult['NAV_OBJECT'],
    ),
    false
);
?>
<script>
    $(document).ready(function(){
		$('body').on('click', '.sort-btn', function(){
			var col = $('body').find('select[name="sort"] option:selected').val();
			var asc = $(this).attr('data-asc');
			location.href = '?SORT='+asc+'&COL='+col;
		});
		$('body').on('click', ".detail", function (){
            var did = $(this).data('kid');
            var marker = '.detail-'+did;
            $('body').find(marker).slideToggle('slow');
        });
        $('body').on('click', ".check-kp", function (){
            var did = $(this).data('kid');
            var marker = '.kp-'+did;
            $('body').find(marker).slideToggle('slow');
        });
        $('body').on('click', ".check-order", function (){
            var did = $(this).data('kid');
            var marker = '.order-'+did;
            $('body').find(marker).slideToggle('slow');
        });
    });
</script>
