<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<?if($arParams['PRIZNAK'] == 'order'):?>
<form action="?" method="POST">
<?=bitrix_sessid_post()?>
<table>
	<tbody>
		<tr>
			<td>Поиск по названию</td>
			<td><input type="text" name="QUERY" value="<?=$arResult['F_QUERY']?>"/></td>
		</tr>
		<tr>
			<td>Поиск по статусу</td>
			<td>
				<select name="STATUSES">
					<option value="null">---</option>
				<?foreach($arResult['FILTER']['STATUSES'] as $k=>$r):?>
					<option value="<?=$r['ID']?>"<?if($r['selected']=='true'):?> selected="selected"<?endif;?>><?=$r['NAME']?></option>
				<?endforeach;?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Поиск по типу</td>
			<td>
				<select name="TYPES">
					<option value="null">---</option>
				<?foreach($arResult['FILTER']['TYPES'] as $k=>$r):?>
					<option value="<?=$r['ID']?>"<?if($r['selected']=='true'):?> selected="selected"<?endif;?>><?=$r['NAME']?></option>
				<?endforeach;?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="Поиск">
			</td>
		</tr>
	</tbody>
</table>
</form>
<?endif;?>
 <table width="100%" style="text-align:center;">
	<thead>
		<tr>
			<th class="products__name">№</th>
			<th class="products__name">Дата</th>
			<th class="products__name">Приоритет</th>
			<th class="products__name">№ Заказчика</th>
			<th class="products__name">Состояние</th>
			<th class="products__name">Действия</th>
		</tr>
	</thead>
	<tbody>
    <?foreach($arResult['ITEMS'] as $k=>$arItems):?>
		<tr>
            <td class=""><?=$k?></td>
            <td class=""><?=date('d-m-Y')?></td>
			<td class="">Приоритет</td>
            <td class=""><?=$arItems['UF_USER_ID']?></td>
			<td class="" style="text-align: center;font-size: 11px;">
				<img src="<?=$arItems['UF_STATUS']['PICTURE']?>" alt="<?=$arItems['UF_STATUS']['NAME']?>" title="<?=$arItems['UF_STATUS']['NAME']?>" />
				<br />
				<span><?=$arItems['UF_STATUS']['NAME']?></span>
			</td>
            <td class="">
			<ul class="nav-menu">
				<li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$k?>" class="detail">Просмотреть</a></li>
				<?if($arParams['PRIZNAK'] == 'order'):?>
				<li style="margin-bottom: 10px;"><a href="javacript:void(0);" data-kid="<?=$k?>" class="check-kp">КП</a></li>
				<li><a href="javascript:void(0);" class="check-order" data-kid="<?=$k?>">Счет заказа</a></li>
				<?endif;?>
			</ul>
			</td>
        </tr>
<?endforeach;?>

		</tbody>
		</table>

    <?foreach($arResult['ITEMS'] as $k=>$arItems):?>
		<table class="not-show detail-<?=$k?>" width="100%" style="text-align:center;">
		<thead>
		<tr>
			<th cols="11"><b>Детально Заказ <?=$arItems['UF_NAME']?></b></th>
		</tr>
		<tr>
			<th class="products__name">№</td>
			<th class="products__name">Товарная позиция</td>
			<th class="products__name">Кол-во ЕИ</td>
			<th class="products__name">Цена</td>
			<th class="products__name">Сумма</td>
			<th class="products__name">Ставка НДС</td>
			<th class="products__name">Сумма с НДС</td>
			<th class="products__name">Срок поставки</td>
			<th class="products__name">Заявка</td>
			<th class="products__name">Состояние</td>
			<th class="products__name">В заказ</td>
		</tr>
		</thead><tbody>
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
			<th cols="4"><b>КП Заказ <?=$arItems['UF_NAME']?></b></th>
		</tr>
			<tr>
				<th class="products__name">№</td>
				<th class="products__name">Товарная позиция</th>
				<th class="products__name">Скачать</th>
				<th class="products__name">Статус</th>
			</tr>
		</thead>
		<tbody>
		<?foreach($arItems['KP'] as $e=>$arKP):?>
		<?foreach($arItems['ELEMENTS'] as $z=>$m):?>
		<?if($m['ID'] == $arKP['UF_ITEM_ID']):?>
		<?$item = $m;break;?>
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
			<th cols="11"><b>Cчета Заказ <?=$arItems['UF_NAME']?></b></th>
		</tr>
			<tr>
				<th class="products__name">№</td>
				<th class="products__name">P/N</td>
				<th class="products__name">Кол-во ЕИ</td>
				<th class="products__name">Цена</td>
				<th class="products__name">Сумма</td>
				<th class="products__name">Ставка НДС</td>
				<th class="products__name">Сумма с НДС</td>
				<th class="products__name">Срок поставки</td>
				<th class="products__name">Заявка</td>
				<th class="products__name">Состояние</td>
				<th class="products__name">В заказ</td>
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
    <?endforeach;?>
	</tbody>
</table>
<script>
$(document).ready(function(){
	$('body').on('click', '.detail', function (){
		var did = $(this).attr('data-kid');
		var marker = '.detail-'+did;
		$('body').find(marker).slideToggle('slow');
	});
	$('body').on('click', '.check-kp', function (){
		var did = $(this).attr('data-kid');
		var marker = '.kp-'+did;
		$('body').find(marker).slideToggle('slow');
	});
	$('body').on('click', '.check-order', function (){
		var did = $(this).attr('data-kid');
		var marker = '.order-'+did;
		$('body').find(marker).slideToggle('slow');
	});
});
</script>
<style>
.nav-menu li a {
	background: #306AA8;
	height: 35px;
	display: block;
	padding-top: 8px;
	width: 157px;
	border-radius: 25px;
	padding-left: 32px;
	color: white;
	font-size: 11pt;
}
.products__name {
background:linear-gradient(#DDD, #BBB);
}
.not-show {
	display: none;
}
</style>