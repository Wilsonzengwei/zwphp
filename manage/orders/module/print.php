<?php
save_manage_log('打印订单');
include('../../inc/manage/header.php');
?>
<div id="orders_print">
	<div class="print_header"><img src="<?=$mCfg['OrdersPrint']['LogoPath'];?>"></div>
	<table width="100%" border="1" align="center" cellpadding="6" cellspacing="0">
	  <tr>
		<td width="70%"><strong class="times_new_roman fz_24px"><?=htmlspecialchars($mCfg['OrdersPrint']['Company']);?></strong></td>
		<td width="30%" align="right"><strong class="fz_24px fc_zhu">Invoice</strong></td>
	  </tr>
	  <tr>
		<td><?=htmlspecialchars($mCfg['OrdersPrint']['Address']);?></td>
		<td align="right" class="times_new_roman fz_20px">No.<?=substr($order_row['OId'], 4);?></td>
	  </tr>
	  <tr>
		<td colspan="2">Phone: <?=htmlspecialchars($mCfg['OrdersPrint']['Phone']);?></td>
	  </tr>
	  <tr>
		<td colspan="2">Fax: <?=htmlspecialchars($mCfg['OrdersPrint']['Fax']);?></td>
	  </tr>
	</table>
	<br>
	<table width="100%" border="1" align="center" cellpadding="6" cellspacing="0">
	  <tr>
		<td width="33%"><strong>Clinet Number:</strong> <?=($order_row['MemberId']+100000);?></td>
		<td width="33%"><strong>Phone:</strong> <?=htmlspecialchars($order_row['ShippingPhone']);?></td>
		<td width="33%"><strong>Date:</strong> <?=date('m/d/Y', $service_time);?></td>
	  </tr>
	</table>
	<br>
	<table width="100%" border="1" align="center" cellpadding="6" cellspacing="0">
	  <tr>
		<td width="50%" align="center"><strong class="times_new_roman">Ship to</strong></td>
		<td width="50%" align="center"><strong class="times_new_roman">Bill to</strong></td>
	  </tr>
	  <tr>
		<td valign="top" class="flh_150" align="center">
		  <?=htmlspecialchars($order_row['ShippingFirstName'].' '.$order_row['ShippingLastName']);?><br />
		  <?=htmlspecialchars($order_row['ShippingAddressLine1']);?><br />
		  <?php if($order_row['ShippingAddressLine2']!=''){?>
		  	<?=htmlspecialchars($order_row['ShippingAddressLine2']);?><br />
		  <?php }?>
		  <?=htmlspecialchars($order_row['ShippingCity']);?><br />
		  <?=htmlspecialchars($order_row['ShippingState']);?>(Postal Code: <strong><?=htmlspecialchars($order_row['ShippingPostalCode']);?></strong>)<br />
		  <?=htmlspecialchars($order_row['ShippingCountry']);?>
		</td>
		<td valign="top" class="flh_150" align="center">
		  <?=htmlspecialchars($order_row['BillingFirstName'].' '.$order_row['BillingLastName']);?><br />
		  <?=htmlspecialchars($order_row['BillingAddressLine1']);?><br />
		  <?php if($order_row['BillingAddressLine2']!=''){?>
		  	<?=htmlspecialchars($order_row['BillingAddressLine2']);?><br />
		  <?php }?>
		  <?=htmlspecialchars($order_row['BillingCity']);?><br />
		  <?=htmlspecialchars($order_row['BillingState']);?>(Postal Code: <strong><?=htmlspecialchars($order_row['BillingPostalCode']);?></strong>)<br />
		  <?=htmlspecialchars($order_row['BillingCountry']);?>
		</td>
	  </tr>
	</table>
	<br>
	<table width="100%" border="1" align="center" cellpadding="6" cellspacing="0">
	  <tr>
		<td width="33%" class="flh_150"><strong>Ship via:</strong><br /><?=htmlspecialchars($order_row['Express']);?></td>
		<td width="33%" class="flh_150"><strong>Order DT:</strong><br /><?=date('m/d/Y H:i:s', $order_row['OrderTime']);?></td>
		<td width="33%" class="flh_150"><strong>Contact person:</strong><br /><?=htmlspecialchars($order_row['ShippingFirstName'].' '.$order_row['ShippingLastName']);?></td>
	  </tr>
	</table>
	<br>
	<table width="100%" border="1" align="center" cellpadding="6" cellspacing="0">
	  <tr align="center" class="item_list_title">
		<td width="15%"><strong>Item No.</strong></td>
		<td width="50%"><strong>Product</strong></td>
		<td width="12%"><strong>Price</strong></td>
		<td width="11%"><strong>Quantity</strong></td>
		<td width="12%"><strong>Total</strong></td>
	  </tr>
	  <?php
	  $item_row=$db->get_all('orders_product_list', $where, '*', 'ProId desc, LId desc');
	  for($i=0; $i<count($item_row); $i++){
	  ?>
	  <tr align="center">
		<td><?=$item_row[$i]['ItemNumber'];?>&nbsp;</td>
		<td align="left" class="flh_150">
			<span class="proname"><?=$item_row[$i]['Name'];?></span><br>
			<?=$item_row[$i]['Size']?"Size: {$item_row[$i]['Size']}<br>":'';?>
			<?=$item_row[$i]['Color']?"Color: {$item_row[$i]['Color']}<br>":'';?>
		</td>				
		<td><?=get_lang('ly200.price_symbols').sprintf('%01.2f', $item_row[$i]['Price']);?></td>
		<td><?=$item_row[$i]['Qty'];?></td>
		<td><?=get_lang('ly200.price_symbols').sprintf('%01.2f', $item_row[$i]['Price']*$item_row[$i]['Qty']);?></td>
	  </tr>
	  <?php }?>
	</table>
	<br>
	<table width="100%" border="1" align="center" cellpadding="6" cellspacing="0">
	  <tr>
		<td><strong>Item Costs:</strong> <font class="fc_red"><?=get_lang('ly200.price_symbols').sprintf('%01.2f', $order_row['TotalPrice']);?></font></td>
	  </tr>
	  <?php if($order_row['Discount']>0){?>
		  <tr>
			<td><strong>Discount:</strong> <font class="fc_red"><?=$order_row['Discount']*100;?>%</font></td>
		  </tr>
		  <tr>
			<td><strong>Save:</strong> <font class="fc_red"><?=get_lang('ly200.price_symbols').sprintf('%01.2f', $order_row['Discount']*$order_row['TotalPrice']);?></font></td>
		  </tr>
	  <?php }?>
	  <tr>
		<td><strong>Shipping Charges:</strong> <font class="fc_red"><?=get_lang('ly200.price_symbols').sprintf('%01.2f', $order_row['ShippingPrice']);?></font></td>
	  </tr>
	  <tr>
		<td><strong>Pay Additional Fee:</strong> <font class="fc_red"><?php if($order_row['PayAdditionalFee']!=0){?><?=get_lang('ly200.price_symbols').sprintf('%01.2f', (1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice']);?> * <?=$order_row['PayAdditionalFee'];?>% = <?=$order_row['PayAdditionalFee']<0?'-':'';?><?=get_lang('ly200.price_symbols').sprintf('%01.2f', ((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice'])*(abs($order_row['PayAdditionalFee'])/100));?><?php }else{?><?=get_lang('ly200.price_symbols');?>0.00<?php }?></font></td>
	  </tr>
	  <tr>
		<td><strong>Grand Total:</strong> <font class="fc_red"><?=get_lang('ly200.price_symbols').sprintf('%01.2f', ((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice'])*(1+$order_row['PayAdditionalFee']/100));?></font></td>
	  </tr>
	</table>
</div>
<script language="javascript">window.print();</script>
</body>
</html>
<?php exit;?>