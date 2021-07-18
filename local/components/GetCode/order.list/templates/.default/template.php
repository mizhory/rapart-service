<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
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
<?#if($arParams['PRIZNAK'] == 'order'):?>
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
<?#endif;?>

<?if($arParams['PRIZNAK'] == 'order'):?>
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
			<tr>
					<td width="5%" style="padding-top:5px" class=""><?=$k?></td>
                    <td width="17%" style="padding-top:5px" class=""><?=date('d-m-Y', intval($arItems["UF_TIMESTAMP"]))?></td>
                    <td width="17%" style="padding-top:5px" class="">Приоритет</td>
                    <td width="17%" style="padding-top:5px" class=""><?=$arItems['UF_USER_ID']?></td>
                    <td width="17%" style="padding-top:5px" class="" style="text-align: center;font-size: 11px;">
                        <img src="<?=$arItems['UF_STATUS']['PICTURE']?>" alt="<?=$arItems['UF_STATUS']['NAME']?>" title="<?=$arItems['UF_STATUS']['NAME']?>" />
                        <br />
                        <span><?=$arItems['UF_STATUS']['NAME']?></span>
                    </td>
					<td width="26%" style="padding-top:5px;padding-left:10px;" class="">
                    <ul class="nav-menu">
                        <li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$k?>" class="detail">Просмотреть</a></li>
                        <li style="margin-bottom: 10px;"><a href="javacript:void(0);" data-kid="<?=$k?>" class="check-kp">КП</a></li>
                        <li style="margin-bottom: 10px;"><a href="javascript:void(0);" class="check-order" data-kid="<?=$k?>">Счет заказа</a></li>
                        <li><a href="javascript:void(0);" class="check-rtiu" data-kid="<?=$k?>">РТУ файлы</a></li>
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
        <tr>
            <td width="15%"><?=$arItems['UF_NAME']?></td>
            <td width="17%"><?=date('Y-m-d', intval($arItems['UF_TIMESTAMP']))?></td>
            <td width="17%">Приоритет</td>
            <td width="17%"><?=$arItems['UF_USER_ID']?></td>
            <td width="17%">
                <img src="<?=$arItems['UF_STATUS']['PICTURE']?>" alt="<?=$arItems['UF_STATUS']['NAME']?>" title="<?=$arItems['UF_STATUS']['NAME']?>" />
                <br />
                <span><?=$arItems['UF_STATUS']['NAME']?></span>
            </td>
            <td width="17%">
                <ul class="nav-menu">
                    <li style="margin-bottom: 10px;"><a href="javascript:void(0);" data-kid="<?=$k?>" class="detail">Просмотреть</a></li>
					<li style=""><a href="javascript:void(0);" data-kid="<?=$k?>" class="check-kp">КП детально</a></li>
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
<script>
    $(document).ready(function(){
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
document.addEventListener('DOMContentLoaded', () => {

    const getSort = ({ target }) => {
        const order = (target.dataset.order = -(target.dataset.order || -1));
        const index = [...target.parentNode.cells].indexOf(target);
        const collator = new Intl.Collator(['en', 'ru'], { numeric: true });
        const comparator = (index, order) => (a, b) => order * collator.compare(
            a.children[index].innerHTML,
            b.children[index].innerHTML
        );
        
        for(const tBody of target.closest('table').tBodies)
            tBody.append(...[...tBody.rows].sort(comparator(index, order)));

        for(const cell of target.parentNode.cells)
            cell.classList.toggle('sorted', cell === target);
    };
    
    document.querySelectorAll('.table_sort thead').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));
    
});
</script>