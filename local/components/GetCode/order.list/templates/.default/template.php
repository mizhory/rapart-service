<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<table>
	<thead>
		<tr>
			<th class="products__name">№</th>
			<th class="products__name">Дата</th>
			<th class="products__name">№ клиента</th>
			<th class="products__name">Дата клиента</th>
			<th class="products__name">Сумма</th>
			<th class="products__name">Состояние</th>
			<th class="products__name">% оплаты</th>
			<th class="products__name">% отгрузки</th>
			<th class="products__name">Действия</th>
		</tr>
	</thead>
	<tbody>
    <?foreach($arResult['ITEMS'] as $k=>$arItems):?>
        <tr>
            <td class="products__name"><?=$k?></td>
            <td class="products__name"><?=date('d-m-Y|T+3|H:i:s')?></td>
            <td class="products__name"><?=$arItems['UF_USER_ID']?></td>
            <td class="products__name"><?=date('d-m-Y|T+3|H:i:s')?></td>
            <td class="products__name"><?=$arItems['PRICE']?></td>
			<td class="products__name" style="text-align: center;"><img src="<?=$arItems['UF_STATUS']['PICTURE']?>" alt="<?=$arItems['UF_STATUS']['NAME']?>" title="<?=$arItems['UF_STATUS']['NAME']?>" /><br /><?=$arItems['UF_STATUS']['NAME']?></td>
            <td class="products__name"><?=$arItems['UF_PERC_PAYMENT']?></td>
            <td class="products__name"><?=$arItems['UF_PERC_SHIPMENT']?></td>
            <td class="products__name">
			<!--<a href="#order/?id=' . $line->ID . '&part=' . $curPage . '" class="product__btn">Посмотреть</a>-->
			<ul>
				<li><a href="javascript:void(0)" class="detail">Просмотреть</a></li>
				<?if($arParams['PRIZNAK'] == 'order'):?>
				<li><a href="javascript:void(0)" class="check-kp">Проверить КП</a></li>
				<li><a href="javascript:void(0)" class="check-order">Проверить Счет</a></li>
				<?endif;?>
			</ul>
			</td>
        </tr>
    <?endforeach;?>
	</tbody>
</table>