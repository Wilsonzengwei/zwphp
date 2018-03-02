<div style="border:1px solid #ddd; background:#f7f7f7; border-bottom:none; width:130px; height:26px; line-height:26px; text-align:center; font-size:12px; font-family:Arial;"><strong>Order Details</strong></div>
<div style="border:1px solid #ddd; padding:10px; font-size:12px; font-family:Arial;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="110" style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">订单号:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_row['OId'];?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">下单时间:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=date('d/m-Y H:i:s', $order_row['OrderTime']);?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">订单状态:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_status_ary[$order_row['OrderStatus']];?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">付款方法:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_row['PaymentMethod'];?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">快递方式:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_row['Express'];?></td>
	  </tr>
	  <?php if($order_row['OrderStatus']==5 || $order_row['OrderStatus']==6){?>
		  <tr>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Tracking Number:</td>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$order_row['TrackingNumber'];?> (<?=date('m/d-Y', $order_row['ShippingTime']);?>)</td>
		  </tr>
	  <?php }?>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">产品价格:</td>
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
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">运费:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=iconv_price($order_row['ShippingPrice']);?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">清关费用:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?php if($order_row['PayAdditionalFee']!=0){?><?=iconv_price((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice']);?> * <?=$order_row['PayAdditionalFee'];?>% = <?=$order_row['PayAdditionalFee']<0?'-':'';?><?=iconv_price(((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice'])*(abs($order_row['PayAdditionalFee'])/100));?><?php }else{?><?=iconv_price(0);?><?php }?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">总价格:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=iconv_price(((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice'])*(1+$order_row['PayAdditionalFee']/100));?></td>
	  </tr>
	</table>
	