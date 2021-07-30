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
						<td colspan="9"><b>Детально КП <?=$k?></b></td>
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
				<?$f=0;foreach($arItems['ELEMENTS'] as $e=>$arElements):$f++;?>
				<?
					/*
					 * $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['SUMM'] = $a['UF_SUMM'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['STAVKA_NDS'] = $a['UF_STAVKA_NDS'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['SUMM_NDS'] = $a['UF_SUMM_NDS'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['SUMM_SNDS'] = $a['UF_SUMM_SNDS'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['STATUS'] = \GetCode\Manager\StatusManager::getFileByStatusID($a['UF_E_STATUS']);
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['PRICE'] = $a['UF_PRICE'];
            $arResult['ITEMS'][$a['UF_CO_ID']]['ELEMENTS'][$a["UF_ITEM_ID"]]['DELIVERY_TIME'] = $a['UF_DELIVERY_TIME'];
					 */
				?>
                    <tr class="product__item">
                        <td class="product__info"><?=$f?></td>
                        <td class="product__info"><?=$arElements["NAME"]?></td>
                        <td class="product__info"><?=$arElements['COUNT']?></td>
                        <td class="product__info"><?=$arElements['PRICE']?></td>
                        <td class="product__info"><?=$arElements['SUMM']?></td>
                        <td class="product__info"><?=$arElements['STAVKA_NDS']?></td>
                        <td class="product__info"><?=$arElements['SUMM_SNDS']?></td>
                        <td class="product__info"><?=$arElements["DELIVERY_TIME"]?></td>
                        <td class="product__info"><?=$arElements["ORDER_ID"]?></td>
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
        $_files = unserialize($arItems['UF_FILES']);
        $arFiles = [];
        if(count($_files)>0) {
            foreach($_files as $k=>$_file_id){
                $arFiles[$k] = \CFile::GetFileArray($_file_id);
            }
        }
        ?>
        <tr class="product__item">
            <td class="product__info"><?=$arItems['UF_NAME']?></td>
            <td class="product__info"><?=$arItems['UF_DATE']?></td>
            <td class="product__info"><?=$arItems['UF_SUMM']?></td>
            <td class="product__info"><img src="<?=$file_status['SRC']?>"></td>
            <td class="product__info"><?=$order['UF_NAME']?></td>
            <td class="product__info"><?if($arItems['UF_NULLED_INVOICE']=='1'):?>Да<?else:?>Нет<?endif?></td>
            <td class="product__info">
                <?if(count($arFiles)>=1):?><?foreach($arFiles as $k=>$f_item):?>
                <a href="<?=$f_item['SRC']?>" download="download" title="Скачать"><?=$f_item['FILE_NAME']?></a>
                <?endforeach;?><?else:?>
                Нет
                <?endif;?>
            </td>
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
