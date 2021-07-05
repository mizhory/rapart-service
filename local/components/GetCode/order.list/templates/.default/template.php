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
      titleBar: {content: BX.create("span", {html: '<b>Обратная связь</b>', 'props': {'className': 'access-title-bar'}})},
      zIndex: 0,
      offsetLeft: 0,
      offsetTop: 0,
      draggable: {restrict: false},
      buttons: [
         new BX.PopupWindowButton({
            text: "Отправить",
            className: "popup-window-button-accept",
            events: {click: function(){
               BX.ajax.submit(BX("myForm"), function(data){ // отправка данных из формы с id="myForm" в файл из action="..."
                  BX( 'ajax-add-answer').innerHTML = data;
                });
            }}
         }),
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
	});
	$('body').on('click', '.check-order', function(){
		var order_id = $(this).attr('data-orderId');
	});
});
</script>