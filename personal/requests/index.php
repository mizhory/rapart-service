<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявки");
?><BR><BR><BR><?
// require('../cfg.php');

// $client = new nusoap_client($nUrl, true,false,false,false,false,0,30);
// $client->debugLevel = 9;
// $client->debug = 1;
// $err = $client->getError();
// if ($err) {
	// $error = GetMessage('MEDSITE_SOAP_CONSTRUCT_ERROR').': '.CDataTools::trans($err, 'UTF-8', MY_SITE_CHARSET);
	// echo 'Error: ' . $error;
// }
// else {
	// $client->setCredentials($nLogin, $nPasswd);
	// $client->setEndpoint(substr($nUrl,0,strlen($nUrl)-5));
	// $client->soap_defencoding = 'UTF-8';
	// $client->decode_utf8 = false;
	// $client->response_timeout = 30;

	// $curPage = '000-';
	// if ( $onPage < 100 ) { $curPage .= '0'; }
	// if ( $onPage < 10 ) { $curPage .= '0'; }
	// $curPage .= ( $onPage - 1 );
	// if( $_GET['part'] ) { $curPage = $_GET['part']; }

	// $jsonInput = '[{"method": "3",  "PART": "' . $curPage . '", "IDKP": "", "GUIDZayavka": "", "IDZayavka": "","StatusZayavka": "",
// "Kontragent": "'.$nameKontr.'", "Partner": "","Organiz": "","Sdelka": "","BooleanActiv": "",
// "Tovary": [{"IDNomenklature": "","Nomenklature": "" }]}]';
	// var_dump( $jsonInput );
	// $result = $client->call('IntegrationZayInput',  array('NameKontr' => $jsonInput ) , '', '', false, null, 'rpc', 'literal');
	// var_dump( $client->debug_str );
	// var_dump( $result );
	// $json = json_decode($result['return']);
	// var_dump($json);
// 	$jsonInput = '[{"metod": "2", "IDKP": "00КА-002398","IDZayavka": "000003225","StatusZayavka": "Новая",
// "Kontragent": "'.$nameKontr.'", "Partner": "ВЫМПЕЛ ООО","Organiz": "РАпарт Сервисез ООО","Sdelka": "ВЫМПЕЛ ООО / - 000003225 - 09.11.2020 10:14:06","BooleanActiv": "",
// "Tovary": [{"IDNomenklature": "КА-00021233","Nomenklature": "03-06-1061",}]}]';

// 	$result = $client->call('IntegrationZayInput',   array('NameKontr' => $jsonInput ), '', '', false, null, 'rpc', 'literal');
// 	var_dump($result);
	
	
?>
<style>
	.products__block {
		width:1161px;
	}

	.shop-nav {
		float: right;
	}

	.shop-nav .active {
		font-weight: bold;
	}
</style>
<div class='shop'><center id='products'></center></div>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
	var onPage = 30;
	var curPage = 1;
	getData(0, onPage);
	

	function getData( leftPart, rightPart ) {
		if( leftPart < 100 ) { leftPart = '0' + leftPart; }
		if( leftPart < 10 ) { leftPart = '0' + leftPart; }
		if( rightPart < 100 ) { rightPart = '0' + rightPart; }
		if( rightPart < 10 ) { rightPart = '0' + rightPart; }
		$('#products').empty().append( $('<img>').attr('src', '../preloader.gif') );
		$.getJSON('../ajax.php', {'method' : '3', 'part' : leftPart + '-' + rightPart }).done(function(data){
			createDataTable(data);
		});	
	}

	function createDataTable(data) {
		var table = $('<table>').addClass('products__block');
		var headTr = $('<tr>').addClass('products__head').appendTo(table);
		headTr.append($('<td>').addClass('products__name').html('№'));
		headTr.append($('<td>').addClass('products__name').html('Дата'));
		headTr.append($('<td>').addClass('products__name').html('Приоритет'));
		headTr.append($('<td>').addClass('products__name').html('№ заказчика'));
		headTr.append($('<td>').addClass('products__name').html('Состояние'));
		headTr.append($('<td>').addClass('products__name').html('Действия'));
		$.each(data, function(i,line){
			var lineTr = $('<tr>').addClass('product__item').appendTo(table);
			lineTr.append($('<td>').addClass('product__info').html(line.IDZayavka));
			lineTr.append($('<td>').addClass('product__info').html(line.Date));
			lineTr.append($('<td>').addClass('product__info').html(line.Priority));
			lineTr.append($('<td>').addClass('product__info').html(line.NumberCustomer));
			lineTr.append($('<td>').addClass('product__info').html(line.StatusZayavka));
			var link = $('<a>').addClass('product__btn').attr('href', 'request/?id=' + line.IDZayavka + '&part=' + 0 ).html('Посмотреть');
			lineTr.append($('<td>').addClass('product__info').append(link));
		});
		$('#products').empty().append(table, $('<BR>'), $('<BR>'));
		var docsCount = data[0].AvailableDocumentsKol;
		var pages = docsCount / onPage;
		if(  pages > parseInt(pages) ) { pages++; }
		var pagesUL = $('<ul>').addClass('pagination__list'); 
		for ( var i = 1; i <= pages; i++ ) {
			var pagesLI = $('<li>').appendTo( pagesUL ).addClass('page');
			if ( curPage === i ) { pagesLI.addClass('pagination-active'); }
			var link = $('<A>');
			link.append( i ).appendTo( pagesLI );
			link.attr('href', '#');
			link.click( function() { 
				curPage = parseInt( $(this).html() );
				var leftPart = ( curPage-1 ) * onPage;
				var rightPart = curPage * onPage - 1;
				getData( leftPart, rightPart );
				return false;
			} );
		}
		pagesUL.wrap($('<div>').addClass('container')).parent().appendTo( $('#products') );
		$('#products').append( '<BR>', '<BR>' );
		var quaDiv = $('<div>').addClass('shop-nav__quantity shop-nav__item');
		quaDiv.append( 'Количество: ' );
		$.each( [ 30, 50, 100 ], function(){
			var onPageNum = parseInt( this );
			var link = $('<a>').attr('href', '#');
			console.log('this: ', onPageNum, onPage );
			if( onPageNum === onPage ) {
				link.addClass( 'active' );
			}
			link.html( onPageNum ).appendTo( quaDiv );
			quaDiv.append( '&nbsp;');
			link.click( function() { 
				onPage = parseInt( $(this).html() );
				getData(0, onPage);
				return false;
			} );
		} );
		quaDiv.wrap( $('<div>').addClass('shop-nav') ).parent().wrap($('<div>').addClass('container text-right')).parent().prependTo( $('#products') );
	}
</script>
<!-- <center>
	<table class="products__block shop">
		<tr class="products__head">
		<th class="products__name">№</th>
		<th class="products__name">Дата</th>
		<th class="products__name">Приоритет</th>
		<th class="products__name">№ заказчика</th>
		<th class="products__name">Состояние</th>
		<th class="products__name">Действия</th>
	</tr> -->
<?
	// foreach( $json as $line ) {

	// 	echo '<TR class="product__item">';
	// 	echo '<td class="product__info">' . $line->IDZayavka . '</td>';
	// 	echo '<td class="product__info">' . $line->Date . '</td>';
	// 	echo '<td class="product__info">' . $line->Priority . '</td>';
	// 	echo '<td class="product__info">' . $line->NumberCustomer . '</td>';
	// 	echo '<td class="product__info">' . $line->StatusZayavka . '</td>';
	// 	echo '<td class="product__info"><a href="request/?id=' . $line->IDZayavka . '&part=' . $curPage . '" class="product__btn">Посмотреть</a>';
	// 	echo "</TR>";


	// }
?>
	<!-- </table> -->
	<!-- <table class="paging"><tr> -->
<? 
	// $docs = $json[0]->AvailableDocumentsKol;
	// $pages = $docs / $onPage;
	// if ( intval($pages) > $pages ) { $pages++; }
	// for( $i = 1; $i <= $pages; $i++ ) {
	// 	echo "<td>";
	// 	$leftPart = ( $i-1 ) * $onPage;
	// 	if ( $leftPart < 100 ) { $leftPart = '0' . $leftPart; }
	// 	if ( $leftPart < 10 ) { $leftPart = '0' . $leftPart; }
	// 	$rightPart = $i * $onPage - 1;
	// 	if ( $rightPart < 100 ) { $rightPart = '0' . $rightPart; }
	// 	if ( $rightPart < 10 ) { $rightPart = '0' . $rightPart; }
	// 	$link = '?part=' . $leftPart . '-' . $rightPart;
	// 	if ( $leftPart . '-' . $rightPart == $curPage ) {
	// 		echo "<B>" . $i . "</B>";
	// 	} else {
	// 		echo "<a href='" . $link . "'>" . $i . "</a>";	
	// 	}
	// 	echo "</td>";
	// }
?>
	<!-- </tr></table> -->
<!-- </center> -->
<?
// }

?>
<BR><BR><BR>
<BR><BR><BR><BR><BR><BR>
<?

// LocalRedirect('/personal/');
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>