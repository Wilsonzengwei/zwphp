<a href="<?=get_domain().$member_url;?>?module=orders&OId=<?=$order_row['OId'];?>&act=detail" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;">Check the Order Details here.</a><br /><br />

<div style="border:1px solid #ddd; background:#f7f7f7; border-bottom:none; width:130px; height:26px; line-height:26px; text-align:center; font-size:12px; font-family:Arial;"><strong>Order Details</strong></div>
<div style="border:1px solid #ddd; padding:10px; font-size:12px; font-family:Arial;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="110" style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Order Number:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_row['OId'];?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Order DT:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=date('d/m-Y H:i:s', $order_row['OrderTime']);?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Order Status:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_status_ary[$order_row['OrderStatus']];?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Payment Method:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_row['PaymentMethod'];?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Shipping Method:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_row['Express'];?></td>
	  </tr>
	  <?php if($order_row['OrderStatus']==5 || $order_row['OrderStatus']==6){?>
		  <tr>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Tracking Number:</td>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_row['TrackingNumber'];?> (<?=date('m/d-Y', $order_row['ShippingTime']);?>)</td>
		  </tr>
	  <?php }?>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Item Costs:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=iconv_price($order_row['TotalPrice']);?></td>
	  </tr>
	  <?php if($order_row['Discount']>0){?>
		  <tr>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Discount:</td>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_row['Discount']*100;?>%</td>
		  </tr>
		  <tr>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Save:</td>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=iconv_price($order_row['Discount']*$order_row['TotalPrice']);?></td>
		  </tr>
	  <?php }?>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Shipping Charges:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=iconv_price($order_row['ShippingPrice']);?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Pay Additional Fee:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?php if($order_row['PayAdditionalFee']!=0){?><?=iconv_price((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice']);?> * <?=$order_row['PayAdditionalFee'];?>% = <?=$order_row['PayAdditionalFee']<0?'-':'';?><?=iconv_price(((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice'])*(abs($order_row['PayAdditionalFee'])/100));?><?php }else{?><?=iconv_price(0);?><?php }?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Grand Total:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=iconv_price(((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice'])*(1+$order_row['PayAdditionalFee']/100));?></td>
	  </tr>
	</table>
	<div style="margin:0px auto; clear:both; height:20px; font-size:1px; overflow:hidden;"></div>
	<div style="clear:both; zoom:1;">
		<div style="width:45%; float:left;">
			<div style="font-weight:bold; height:22px; line-height:22px; font-size:12px; font-family:Arial;">Your Shipping Address:</div>
			<div style="border:1px solid #ddd; background:#fdfdfd; padding:8px; line-height:160%; font-size:10px; font-family:Arial; font-size:12px;">
				<strong style="font-size:10px; font-family:Arial;"><?=htmlspecialchars($order_row['ShippingTitle'].' '.$order_row['ShippingFirstName'].' '.$order_row['ShippingLastName']);?></strong><br />
				<?=htmlspecialchars($order_row['ShippingAddressLine1']);?><br />
				<?=htmlspecialchars($order_row['ShippingCity']);?><br />
				<?=htmlspecialchars($order_row['ShippingState']);?> (Postal Code: <strong style="font-size:10px; font-family:Arial;"><?=htmlspecialchars($order_row['ShippingPostalCode']);?></strong>)<br />
				<?=htmlspecialchars($order_row['ShippingCountry']);?><br />
				<strong style="font-size:10px; font-family:Arial;">Phone: </strong><?=htmlspecialchars($order_row['ShippingPhone']);?>
			</div>
		</div>
		<div style="width:45%; float:left; margin-left:10px;">
			<div style="font-weight:bold; height:22px; line-height:22px; font-size:12px; font-family:Arial;">Your Billing Address:</div>
			<div style="border:1px solid #ddd; background:#fdfdfd; padding:8px; line-height:160%; font-size:10px; font-family:Arial; font-size:12px;">
				<strong style="font-size:10px; font-family:Arial;"><?=htmlspecialchars($order_row['BillingTitle'].' '.$order_row['BillingFirstName'].' '.$order_row['BillingLastName']);?></strong><br />
				<?=htmlspecialchars($order_row['BillingAddressLine1']);?><br />
				<?=htmlspecialchars($order_row['BillingCity']);?><br />
				<?=htmlspecialchars($order_row['BillingState']);?> (Postal Code: <strong style="font-size:10px; font-family:Arial;"><?=htmlspecialchars($order_row['BillingPostalCode']);?></strong>)<br />
				<?=htmlspecialchars($order_row['BillingCountry']);?><br />
				<strong style="font-size:10px; font-family:Arial;">Phone: </strong><?=htmlspecialchars($order_row['BillingPhone']);?>
			</div>
		</div>
		<div style="margin:0px auto; clear:both; height:0px; font-size:0px; overflow:hidden;"></div>
	</div>
	<div style="margin:0px auto; clear:both; height:20px; font-size:1px; overflow:hidden;"></div>
	<div style="border-bottom:2px solid #ddd; height:24px; line-height:24px; font-weight:bold; font-family:Arial; font-size:12px;">Shipping Method:</div>
	<div style="line-height:150%; margin-top:5px; font-family:Arial;"><strong style="font-family:Arial; font-size:12px;"><?=htmlspecialchars($order_row['Express']);?></strong> ( <?php if($order_product_weight==1){?>Parcel Weight: <?=$order_row['TotalWeight'];?> KG, <?php }?>Shipping Charges: <?=iconv_price($order_row['ShippingPrice']);?> )<?php if($order_product_weight==1){?><br /><div class="shipping_price">( Shipping Price: First <?=$order_row['FirstWeight'];?> KG : <?=iconv_price($order_row['FirstPrice']);?> / <?=$order_row['ExtWeight'];?> KG : <?=iconv_price($order_row['ExtPrice'])?> )</div><?php }?></div>
	<div style="margin:0px auto; clear:both; height:20px; font-size:1px; overflow:hidden;"></div>
	<div style="border-bottom:2px solid #ddd; height:24px; line-height:24px; font-weight:bold; font-family:Arial; font-size:12px;">Special Instructions or Comments:</div>
	<div style="line-height:180%; font-family:Arial; font-size:12px;"><?=format_text($order_row['Comments']);?></div>
	<div style="margin:0px auto; clear:both; height:20px; font-size:1px; overflow:hidden;"></div>
	<div style="border-bottom:2px solid #ddd; height:24px; line-height:24px; font-weight:bold; font-family:Arial; font-size:12px;">Order Items:</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ddd; margin:8px 0;">
		<tr>
			<td width="14%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:url(<?=get_domain();?>/images/lib/cart/tb_bg.gif); font-family:Arial; font-size:12px;">Pictures</td>
			<td width="50%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:url(<?=get_domain();?>/images/lib/cart/tb_bg.gif); font-family:Arial; font-size:12px;">Product</td>
			<td width="12%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:url(<?=get_domain();?>/images/lib/cart/tb_bg.gif); font-family:Arial; font-size:12px;">Price</td>
			<td width="12%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:url(<?=get_domain();?>/images/lib/cart/tb_bg.gif); font-family:Arial; font-size:12px;">Quantity</td>
			<td width="12%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:url(<?=get_domain();?>/images/lib/cart/tb_bg.gif); font-family:Arial; font-size:12px; border-right:none;">Total</td>
		</tr>
		<?php
		$pro_count=0;
		$item_row=$db->get_all('orders_product_list', "OrderId='{$order_row['OrderId']}'", '*', 'ProId desc, LId desc');
		for($i=0; $i<count($item_row); $i++){
			$pro_count+=$item_row[$i]['Qty'];
		?>
		<tr align="center">
			<td valign="top" style="padding:7px 5px; border-top:1px solid #ddd;"><table width="92" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td height="92" align="center" style="border:1px solid #ccc; padding:0; background:#fff;"><a href="<?=get_domain().$item_row[$i]['Url'];?>" target="_blank"><img src="<?=get_domain().$item_row[$i]['PicPath'];?>" /></a></td></tr></table></td>
			<td align="left" style="line-height:150%; font-size:10px; font-family:Arial; padding:7px 5px; border-top:1px solid #ddd;">
				<a href="<?=get_domain().$item_row[$i]['Url'];?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:10px;"><?=$item_row[$i]['Name'];?></a><br />
				Item No.: <a href="<?=get_domain().$item_row[$i]['Url'];?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:10px;"><?=$item_row[$i]['ItemNumber'];?></a><br />
				<?php if($item_row[$i]['Property']){
					$Property='';
					$Property=str::json_data(htmlspecialchars_decode($item_row[$i]['Property']), 'decode');
					foreach((array)$Property as $k=>$v){
				?>
					<?=$k?>: <?=$v;?><br />
				<?php }}?>
				<?php if($order_product_weight==1){?>Weight: <?=$item_row[$i]['Weight'];?> KG<br /><?php }?>
				Purchasing Remark: <?=htmlspecialchars($item_row[$i]['Remark']);?>
			</td>
			<td style="font-family:Arial; font-size:10px; padding:7px 5px; border-top:1px solid #ddd;"><?=iconv_price($item_row[$i]['Price']);?></td>
			<td style="font-family:Arial; font-size:10px; padding:7px 5px; border-top:1px solid #ddd;"><?=$item_row[$i]['Qty'];?></td>
			<td style="font-family:Arial; font-size:10px; padding:7px 5px; border-top:1px solid #ddd;"><?=iconv_price($item_row[$i]['Price']*$item_row[$i]['Qty']);?></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="3" style="height:26px; background:#efefef; text-align:center; color:#B50C08; font-size:11px; font-weight:bold; font-family:Arial;">&nbsp;</td>
			<td style="height:26px; background:#efefef; text-align:center; color:#B50C08; font-size:11px; font-weight:bold; font-family:Arial;"><?=$pro_count;?></td>
			<td style="height:26px; background:#efefef; text-align:center; color:#B50C08; font-size:11px; font-weight:bold; font-family:Arial;"><?=iconv_price($order_row['TotalPrice']);?></td>
		</tr>
	</table>
</div><br /><br />