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
<?if($arParams['PRIZNAK'] == 'KP'):?>
<table class="products__block shop">
	<thead>
	<tr class="products__head">
		<th class="products__name">№</th>
		<th class="products__name">Дата</th>
		<th class="products__name">Сумма</th>
		<th class="products__name">Срок действия</th>
		<th class="products__name">Состояние</th>
		<th class="products__name">Действия</th>
	</tr>
	</thead>
	<tbody>
	<?$i=0;?>
	<?foreach($arResult['ITEMS'] as $k=>$arItems):?>
        <tr class="product__item">
            <td class="product__info"><?=$k?></td>
            <td class="product__info"><?=$arItems['CO_DATE']?></td>
            <td class="product__info"><?=$arItems['CO_SUMM']?></td>
            <td class="product__info"><?=$arItems['VALIDATY']?></td>
            <td class="product__info"> <img src="<?=$arItems['STATUS']['PICTURE']?>" alt="<?=$arItems['STATUS']['NAME']?>" title="<?=$arItems['STATUS']['NAME']?>" style="position: relative;top: 15px;" /></td>
            <td class="product__info"><ul class="nav-menu">
                        <li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$i?>" class="detail product__btn">Детально</a></li>
                    </ul></td>
        </tr>
        <tr class="not-show detail-<?=$i?>">
            <td colspan="6">
            <table>
                <thead>
					 <tr class="products__head">
						<td colspan="11"><b>Детально КП <?=$k?></b></td>
					</tr>
                    <tr class="products__head">
                        <th class="products__name">№</th>
						<th class="products__name">Товарная позиция</th>
						<th class="products__name">Кол-во ЕИ</th>
						<th class="products__name">Цена</th>
						<th class="products__name">Сумма</th>
						<th class="products__name">Ставка НДС</th>
						<th class="products__name">Сумма с НДС</th>
						<th class="products__name">Срок поставки</th>
						<th class="products__name">Заявка</th>
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
					</tr>
				<?endforeach;?>
				</tbody>
                </tbody>
            </table>
            </td>
            <td colspan="0"></td>
            <td colspan="0"></td>
            <td colspan="0"></td>
            <td colspan="0"></td>
            <td colspan="0"></td>
        </tr>
        <?$i++?>
	<?endforeach;?>
	</tbody>
</table>
<?elseif($arParams['PRIZNAK'] == 'INVOICE'):?>
<table class="products__block shop">
    <thead>
    <tr class="products__head">
        <th class="products__name">№</th>
        <th class="products__name">Дата</th>
        <th class="products__name">Сумма</th>
        <th class="products__name">Состояние</th>
        <th class="products__name">Заказ</th>
        <th class="products__name">Отменен</th>
        <th class="products__name">Файл</th>
    </tr>
    </thead>
    <tbody>
    <?$i=0;?>
    <?foreach($arResult["ITEMS"] as $invoice_id=>$arItems):
        $file_status = \GetCode\Manager\StatusManager::getFileByStatusID($arItems['UF_STATUS']);
        $order = \GetCode\Manager\OrderManager::getOrderIDbyKPID($arItems['UF_KP_ID']);
        ?>
        <tr class="product__item">
            <td class="product__info"><?=$arItems['UF_NAME']?></td>
            <td class="product__info"><?=$arItems['UF_DATE']?></td>
            <td class="product__info"><?=$arItems['UF_SUMM']?></td>
            <td class="product__info"><img src="<?=$file_status['SRC']?>"></td>
            <td class="product__info"><?=$order['UF_NAME']?></td>
            <td class="product__info"><?if($arItems['UF_NULLED_INVOICE']=='1'):?>Да<?else:?>Нет<?endif?></td>
            <td class="product__info"><a href="#">Скачать</a></td>
        </tr>
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
