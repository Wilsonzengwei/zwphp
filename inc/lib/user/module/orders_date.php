<?php 
$OId=$_GET['OId'];
$SupplierId = $_SESSION['member_MemberId'];


$order_row = $db->get_one('orders',"OId='$OId'");
if($order_row['OrderStatus'] == '2'){
	$status_price = $website_language['user_orders'.$lang]['yfk'];
}elseif($order_row['OrderStatus'] == '1'){
	$status_price = $website_language['user_orders'.$lang]['dfk'];
}elseif($order_row['OrderStatus'] > '2' && $order_row['OrderStatus'] < '8'){
	$status_price = $website_language['supplier_m_order'.$lang]['ysz'];
}elseif( $order_row['OrderStatus'] == '8'){
	$status_price = $website_language['user_orders'.$lang]['ywc'];
}
$OrderId = $order_row['OrderId'];
$order_product_row = $db->get_one('orders_product_list',"OrderId='$OrderId'");
$ProId = $order_product_row['ProId'];
$name = $db->get_one("product","ProId='$ProId'","Name,Name_lang_1,Name_lang_2");
if($lang == '_en'){
	$orders_name = $name['Name_lang_2'];
	
}else{
	$orders_name = $name['Name'.$lang];
}
$freight_stutas_row = $db->get_all('freight_stutas',"OrderId='$OrderId'");
$stutas_count = count($freight_stutas_row);
$stutas_ros = $freight_stutas_row[$stutas_count-1];
$trans_one_row = $db->get_one('trans_clear',"MemberId='$SupplierId' and OrderId='$OrderId'");
if($trans_one_row['Transport'] == '0'){
	$Transport_one = $website_language['supplier_clear'.$lang]['zxys'];
}elseif($trans_one_row['Transport'] == '1'){
	$Transport_one = $website_language['supplier_clear'.$lang]['yydlky'];
}elseif($trans_one_row['Transport'] == '2'){
	$Transport_one =  $website_language['supplier_clear'.$lang]['yydlhy'];
}
if($trans_one_row['Clearance'] == '0'){
	$Clearance_one =  $website_language['supplier_clear'.$lang]['zxqg'];
	$QPrice = '0.00';
}elseif($trans_one_row['Clearance'] == '1'){
	$Clearance_one =  $website_language['supplier_clear'.$lang]['yygjdlqg'];
	$QPrice = $trans_one_row['QPrice'];
}
$trans_name = $trans_one_row['XSId'];
$XName = $db->get_one("Shipping","SId='$trans_name'","FirmName");

?>
<?php
	echo '<link rel="stylesheet" href="/css/user/orders_date'.$lang.'.css">'
?>

<div class="index_box">
	<div class="index_logo"></div>
	<div class="index_search">
	<form action="">
		<input class="search_input" placeholder='<?=$website_language['header'.$lang]['qsrspmc']?>' style="" type="text">	
		<input class="search_submit" type="button"  value="<?=$website_language['header'.$lang]['ss']?>">
	</form>		
	</div>		
</div>
<div class="mask">
	<div class="bbg">
		<div class="b1">
			<div class="b2" style="">
				<img class="b2_img" src="<?=$order_product_row['PicPath']?>">
			</div>
			<div class="b3">
				<div class="he_mask"><span class='span_title'><?=$website_language['user_orderd'.$lang]['spmc']?>：</span><span class='he1'></span><div class="hhe"><?=$orders_name?></div>
				</div>
				<div class="he_mask">
					<div class="he_sm">
						<span class='span_title'><?=$website_language['user_orderd'.$lang]['ddhm']?>：</span>
						<div class="hhe2"><?=$OId?></div>
					</div>
					<div class="he_sm">
						<span class='span_title'><?=$website_language['user_orderd'.$lang]['xdsj']?>：</span>
						<div class="hhe2"><?=date("Y-m-d H:i:s",$order_row['OrderTime'])?></div>
					</div>
					<div class="he_sm">
						<span class='span_title'><?=$website_language['user_orderd'.$lang]['ddzt']?>：</span>
						<div class="hhe2"><?=$status_price?></div>
					</div>					
				</div>
				<div class="he_mask">
					<div class="he_sm">
						<span class='span_title'><?=$website_language['user_orderd'.$lang]['zffs']?>：</span>
						<div class="hhe2"><?=$website_language['user_orderd'.$lang]['xs']?></div>
					</div>
					<div class="he_sm">
						<span class='span_title'><?=$website_language['user_orderd'.$lang]['fksj']?>：</span>
						<div class="hhe2"><?=date("Y-m-d H:i:s",$order_row['PaymentTime']);?></div>
					</div>
					<div class="he_sm">
						<span class='span_title'><?=$website_language['user_orderd'.$lang]['fkje']?>：</span>
						<div class="hhe2">USD $<?=$order_row['TotalPrice'];?></div>
					</div>
				</div>
				<div class="he_mask2">
					<span style='float:left' class='span_title'><?=$website_language['user_orderd'.$lang]['cpys']?>：</span>
					<div class="pt">
					<?php 
						$color_row = $order_row['COId'];
						$colorid_row = $db->get_all("orders_color","OrderId='$OrderId'");
						for ($j=0; $j < count($colorid_row); $j++) { 
							$colors_row = $db->get_one('product_color',"CId=".$colorid_row[$j]['CId'],"Color_lang_1");
							$color_name = $colors_row['Color'.$lang];
							$colors_qty_row = $colorid_row[$j]['Qty'];
						
					?>
						<span class='sr'><?=$color_name?><span class='ss'><?=$colors_qty_row?></span><?=$website_language['user_orderd'.$lang]['jian']?></span>	
					<?php }?>					
					</div>
				</div>
			</div>		
		</div>
	</div>
	<div class="bbg2">
		<div class="bg_title1"><?=$website_language['user_orderd'.$lang]['wlxx']?></div>
		<div class="b3">
			<div class="he_mask">
				<div class="he_big">
					<span class='span_title3'><?=$website_language['user_orderd'.$lang]['shdz']?>：</span>
					<div class="hhe2"><?=$order_row['ShippingAddressLine1']?></div>
				</div>
				<div class="he_big">
					<span class='span_title3'><?=$website_language['user_orderd'.$lang]['ysgs']?>：</span>
					<div class="hhe2"><?=$XName['FirmName']?></div>
				</div>
			</div>
			<div class="he_mask">
				<div class="he_big">
					<span class='span_title3'><?=$website_language['user_orderd'.$lang]['ysfs']?>：</span>
					<div class="hhe2"><?=$Transport_one?></div>
				</div>
				<div class="he_big">
					<span class='span_title3'><?=$website_language['user_orderd'.$lang]['ydh']?>：</span>
					<div class="hhe2"><?=$trans_one_row['TOrderId']?></div>
				</div>
			</div>
			<br>
			<?php 
				for ($i=0; $i < count($freight_stutas_row); $i++) { 
			?>
			<div class="he_mask">
				<span class='span_title3'><?=date("Y-m-d H:i:s",$freight_stutas_row[$i]['StutasTime'])?></span>
				<input style="margin-left:100px;width:400px;height:28px;border:1px solid #ccc" type="text" value="<?=$freight_stutas_row[$i]['ProductStutas']?>">
			</div>
			<br>
			<?php }?>
		</div>

	</div>
</div>
