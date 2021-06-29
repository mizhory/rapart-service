<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<?
//var_dump($arResult);
if(empty($arResult)) return;
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
            <td class="products__name"><?=date('d-m-Y H:i:s', $arItems['UF_TIMESTAMP'])?></td>
            <td class="products__name"><?=$arItems['UF_USER_ID']?></td>
            <td class="products__name"><?=date('d-m-Y H:i:s', $arItems['UF_TIMESTAMP'])?></td>
            <td class="products__name">Сумма</td>
            <td class="products__name">Состояние</td>
            <td class="products__name">% оплаты</td>
            <td class="products__name">% отгрузки</td>
            <td class="products__name">Действия</td>
        </tr>
    <?endforeach;?>
	<!--	<tr>
			<td class="products__name">№</td>
			<td class="products__name">Дата</td>
			<td class="products__name">№ клиента</td>
			<td class="products__name">Дата клиента</td>
			<td class="products__name">Сумма</td>
			<td class="products__name">Состояние</td>
			<td class="products__name">% оплаты</td>
			<td class="products__name">% отгрузки</td>
			<td class="products__name">Действия</td>
		</tr>-->
	</tbody>
</table>