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
      </div><!---->
    </nav>
    <table class="table_sort" width="100%" style="text-align:center;">
        <thead>
        <tr>
			<th class="products__name">№</th>
			<th class="products__name">Дата</th>
            <th class="products__name">№ Клиента</th>
            <th class="products__name">Дата клиента</th>
            <th class="products__name">Сумма</th>
            <th class="products__name">Состояние</th>
            <th class="products__name">% Оплаты</th>
            <th class="products__name">% Отгрузки</th>
            <th class="products__name">Действия</th>
        </tr>
        </thead>
		<tbody>
		<?foreach($arResult['ITEMS'] as $k=>$arItems):?>
			<tr style="border-bottom: 1px solid #EEE;" class="product__item">
                <td class="product__info"><?=$arItems['UF_NAME']?></td>
                <td class="product__info"><?=$arItems["UF_DATE"]?></td>
                <td class="product__info"><?=$arItems['UF_NUMBER_CUSTOMER']?></td>
                <td class="product__info">Дата клиента</td>
                <td class="product__info"><?=$arItems['UF_SUMM']?></td>
                <td class="product__info" style="text-align: center;font-size: 11px;">
                        <img src="<?=$arItems['UF_STATUS']['PICTURE']?>" alt="<?=$arItems['UF_STATUS']['NAME']?>" title="<?=$arItems['UF_STATUS']['NAME']?>" style="position: relative;top: 15px;" />
                </td>
                <td class="product__info"><?=$arItems['UF_PERC_PAYMENT']?></td>
                <td class="product__info"><?=$arItems['UF_PERC_SHIPMENT']?></td>
                <td class="product__info">
                        <ul class="nav-menu">
                            <li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$k?>" class="detail product__btn">Посмотреть</a></li>
                            <?if(isset($arItems['INVOICE']) && count($arItems['INVOICE'])>0):?><li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$k?>" class="check-order product__btn">Счет</a></li><?endif;?>
                            <?if(isset($arItems['RTIU']) && count($arItems['RTIU'])>0):?><li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$k?>" class="check_rtiu product__btn">Реализация</a></li><?endif;?>
                            <!--<li style="margin-bottom: 10px;"><a href="javascript:void(0);" class="check-order product__btn" data-kid="<?=$k?>">Счет заказа</a></li>
                            <li><a href="javascript:void(0);" class="check-rtiu product__btn" data-kid="<?=$k?>">РТУ файлы</a></li>-->
                        </ul>
                    </td>
                </tr>
				<tr>
				<td colspan="9">
					<table class="not-show detail-<?=$k?>" width="100%" style="text-align:center;border-bottom:1px solid #000;">
					<thead>
					 <tr>
						<td colspan="11"><b>Детально Заказ - <?=$arItems['UF_NAME']?></b></td>
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
						<th class="products__name">В заказ</th>
					</tr>
					</thead>
					<tbody>
				<?$z=0;foreach($arItems['ELEMENTS'] as $e=>$arElements):$z++;?>
					<tr>
						<td><?=$z?></td>
						<td><?=$arElements["NAME"]?></td>
						<td><?=$arElements['COUNT']?></td>
						<td><?=$arElements["PRICE"]?></td>
						<td><?=$arElements["SUMM"]?></td>
						<td><?=$arElements["STAVKA_NDS"]?></td>
						<td><?=$arElements["SUMM_S_NDS"]?></td>
						<td><?=$arElements["DateShipment"]?></td>
						<td><?=$arItems["UF_NAME"]?></td>
						<td><input type="checkbox" name="detail[<?=$k?>]" /></td>
					</tr>
				<?endforeach;?>
				</tbody>
				</table>
				<table class="not-show order-<?=$k?>" width="100%" style="text-align:center;border-bottom:1px solid #000;margin-bottom: 1rem;">
				<thead>
					<tr>
						<th colspan="7"><b>Cчета Заказа - <?=$arItems['UF_NAME']?></b></th>
					</tr>
					<tr>
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
				<?foreach($arItems['INVOICE'] as $e=>$arElements):
                    $_files = unserialize($arElements['UF_FILES']);
                    $arFiles = [];
                    if(count($_files)>0) {
                    foreach($_files as $k=>$_file_id){
                    $arFiles[$k] = \CFile::GetFileArray($_file_id);
                    }
                    }
                    ?>
                    <tr class="product__item">
                        <td class="product__info"><?=$arElements['UF_NAME']?></td>
                        <td class="product__info"><?=$arElements['UF_DATE']?></td>
                        <td class="product__info"><?=$arElements['UF_SUMM']?></td>
                        <td class="product__info"><img src="<?=$file_status['SRC']?>"></td>
                        <td class="product__info"><?=$order['UF_NAME']?></td>
                        <td class="product__info"><?if($arElements['UF_NULLED_INVOICE']=='1'):?>Да<?else:?>Нет<?endif?></td>
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
                    <table class="not-show order-<?=$k?>" width="100%" style="text-align:center;border-bottom:1px solid #000;">
                        <thead>
                        <tr>
                            <th colspan="11"><b>Файлы реализации заказа - <?=$arItems['UF_NAME']?></b></th>
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

                        <?endforeach;?>
                        </tbody>
                    </table>
					</td>
				</tr>
			<?endforeach;?>
			</tbody>
		</table>

<?else:?>

    <nav class="shop-nav" style="margin-top:20px; margin-bottom: 20px;">
        <div class="sort shop-nav__item"><span class="sort-label">Сортировать по:</span>
            <select name="sort" class="sort-btn popup">
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
    <table class="table_sort" width="100%" style="text-align:center;border-bottom:1px solid #000;">
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
		<?foreach($arResult['ITEMS'] as $k=>$arItems):
        ?>
        <tr style="border-bottom:1px solid;" class="product__item">
            <td class="product__info"><?=$arItems['UF_NAME']?></td>
            <td class="product__info"><?=$arItems['UF_DATE']?></td>
            <td class="product__info"><?=$arItems['UF_PRIORITY']?></td>
            <td class="product__info"><?=$arItems['UF_NUMBER_CUSTOMER']?></td>
            <td class="product__info">
                <img src="<?=$arItems['UF_STATUS']['PICTURE']?>" alt="<?=$arItems['UF_STATUS']['NAME']?>" title="<?=$arItems['UF_STATUS']['NAME']?>" />
                <br />
                <span><?=$arItems['UF_STATUS']['NAME']?></span>
            </td>
            <td class="product__info" style="padding-top:5px;padding-left:10px;padding-bottom: 15px;">
                <ul class="nav-menu">
                    <li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$k?>" class="detail product__btn">Просмотреть</a></li>
                </ul>
            </td>
        </tr>
		<tr>
			<td colspan="6">
				<table class="not-show detail-<?=$k?>" width="100%" style="border-bottom:1px solid #000;text-align:center;margin-bottom:1rem!important;">
					<thead>
                        <tr><th colspan="5"><b>Детализация заявки <?=$arItems["UF_NUMBER_CUSTOMER"]?></b></th></tr>
                        <tr>
                            <th class="products__name">№</th>
                            <th class="products__name">Обозначение заказчика</th>
                            <th class="products__name">P/N</th>
                            <th class="products__name">Количество</th>
                            <th class="products__name">КП</th>
                        </tr>
					</thead>
					<tbody>
					<?$z=0;foreach($arItems['ELEMENTS'] as $e=>$arElements):$z++;?>
                        <tr class="product__item">
                            <td class="product__info"><?=$z?></td>
                            <td class="product__info"><?=$arElements['NAME']?></td>
                            <td class="product__info"><?=$arElements["PN"]?></td>
                            <td class="product__info"><?=$arElements['COUNT']?></td>
                            <td class="product__info"><?if(\GetCode\Manager\OffersManager::checkKP($arItems['ID'], $arElements['ID'])):?><a href="/personal/kp/detail/?BY=ELEMENT&ID=<?=$arElements['ID']?>" class="product__btn">КП</a><?else:?>Нет<?endif;?></td>
						</tr>
					<?endforeach;?>
					</tbody>
				</table>
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