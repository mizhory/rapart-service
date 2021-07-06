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
				<li style="margin-bottom: 10px;"><a href="javascript:void(0)" data-orderId='<?=$arItems['ID']?>' class="detail">Просмотреть</a></li>
				<?if($arParams['PRIZNAK'] == 'order'):?>
				<li style="margin-bottom: 10px;"><a href="javascript:void(0)" data-orderId='<?=$arItems['ID']?>' class="check-kp">Проверить КП</a></li>
				<li><a href="javascript:void(0)" data-orderId='<?=$arItems['ID']?>' class="check-order">Проверить Счет</a></li>
				<?endif;?>
			</ul>
			</td>
        </tr>
    <?endforeach;?>
	</tbody>
</table>
<script>
$(document).ready(function(){
	$('body').on('click', '.detail', function(){
		var order_id = $(this).attr('data-orderId');

		$.ajax({
			url: '/local/ajax/getcode/components/order.list.php?exec=true',
			method: 'POST',
			data: {
				act: 'getDetailOrder',
				oid: order_id
			},
			success: function(d_response){
					var addAnswer = new BX.PopupWindow("my_answer", null, {
						  content: d_response,
						  closeIcon: {right: "20px", top: "10px"},
						  titleBar: {content: BX.create("span", {html: '<b>Заказ детально</b>', 'props': {'className': 'access-title-bar'}})},
						  zIndex: 0,
						  offsetLeft: 0,
						  offsetTop: 0,
						  draggable: {restrict: false},
						  buttons: [
							 new BX.PopupWindowButton({
								text: "Закрыть",
								className: "webform-button-link-cancel",
								events: {click: function(){
								   this.popupWindow.close(); // закрытие окна
								}}
							 })
							 ]
					   });
					 addAnswer.setContent(d_response);
					 addAnswer.show();
			}
		});
	});
	$('body').on('click', '.check-kp', function(){
		var order_id = $(this).attr('data-orderId');
		$.ajax({
			url: '/local/ajax/getcode/components/order.list.php?exec=true',
			method: 'POST',
			data: {
				act: 'checkKP',
				oid: order_id
			},
			success: function(k_response){
					var addAnswer = new BX.PopupWindow("my_answer", null, {
						  content: k_response,
						  closeIcon: {right: "20px", top: "10px"},
						  titleBar: {content: BX.create("span", {html: '<b>Заказ детально</b>', 'props': {'className': 'access-title-bar'}})},
						  zIndex: 0,
						  offsetLeft: 0,
						  offsetTop: 0,
						  draggable: {restrict: false},
						  buttons: [
							 new BX.PopupWindowButton({
								text: "Закрыть",
								className: "webform-button-link-cancel",
								events: {click: function(){
								   this.popupWindow.close(); // закрытие окна
								}}
							 })
							 ]
					   });
					 addAnswer.setContent(k_response);
					 addAnswer.show();
			}
	});
	$('body').on('click', '.check-order', function(){
		var order_id = $(this).attr('data-orderId');
		$.ajax({
			url: '/local/ajax/getcode/components/order.list.php?exec=true',
			method: 'POST',
			data: {
				act: 'checkOrder',
				oid: order_id
			},
			success: function(o_response){
					var addAnswer = new BX.PopupWindow("my_answer", null, {
						  content: o_response,
						  closeIcon: {right: "20px", top: "10px"},
						  titleBar: {content: BX.create("span", {html: '<b>Заказ детально</b>', 'props': {'className': 'access-title-bar'}})},
						  zIndex: 0,
						  offsetLeft: 0,
						  offsetTop: 0,
						  draggable: {restrict: false},
						  buttons: [
							 new BX.PopupWindowButton({
								text: "Закрыть",
								className: "webform-button-link-cancel",
								events: {click: function(){
								   this.popupWindow.close(); // закрытие окна
								}}
							 })
							 ]
					   });
					 addAnswer.setContent(o_response);
					 addAnswer.show();
			}
	});
});
</script>