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
<table>
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
            <td class="products__name"><?=$k?></td>
            <td class="products__name"><?=date('d-m-Y')?></td>
			<td class="products__name">Приоритет</td>
            <td class="products__name"><?=$arItems['UF_USER_ID']?></td>
			<td class="products__name" style="text-align: center;"><img src="<?=$arItems['UF_STATUS']['PICTURE']?>" alt="<?=$arItems['UF_STATUS']['NAME']?>" title="<?=$arItems['UF_STATUS']['NAME']?>" /><br /><?=$arItems['UF_STATUS']['NAME']?></td>
            <td class="products__name">
			<!--<a href="#order/?id=' . $line->ID . '&part=' . $curPage . '" class="product__btn">Посмотреть</a>-->
			<ul class="nav-menu">
				<!--#?ORDER_ID=<?=$arItems['ID']?>&DETAIL=Y-->
				<li style="margin-bottom: 10px;"><a href="javascript:void();" data-kid="<?=$k?>" class="detail">Просмотреть</a></li>
				<?if($arParams['PRIZNAK'] == 'order')
				:?>
				<li style="margin-bottom: 10px;"><a href="?ORDER_ID=<?=$arItems['ID']?>&VIEW_KP=Y" class="check-kp">КП</a></li>
				<li><a href="?ORDER_ID=<?=$arItems['ID']?>&VIEW_ORDER=Y" class="check-order">Счет заказа</a></li>
				<?endif;?>
			</ul>
			</td>
        </tr>
		<tr style="diplay:none;" class="detail-<?=$k?>">
			<td>№</td>
			<td>P/N</td>
			<td>Кол-во ЕИ</td>
			<td>Цена</td>
			<td>Сумма</td>
			<td>Ставка НДС</td>
			<td>Сумма с НДС</td>
			<td>Срок поставки</td>
			<td>Заявка</td>
			<td>Состояние</td>
			<td>В заказ</td>
		</tr>
		<?foreach($arItems['ELEMENTS'] as $e=>$arElements):?>
		<?var_dump($arElements);?>
			<tr style="diplay:none;" class="detail-<?=$k?>">
				<td>№</td>
				<td>P/N</td>
				<td>Кол-во ЕИ</td>
				<td>Цена</td>
				<td>Сумма</td>
				<td>Ставка НДС</td>
				<td>Сумма с НДС</td>
				<td>Срок поставки</td>
				<td>Заявка</td>
				<td>Состояние</td>
				<td>В заказ</td>
			</tr>
		<?endforeach;?>
    <?endforeach;?>
	</tbody>
</table>
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
</style>