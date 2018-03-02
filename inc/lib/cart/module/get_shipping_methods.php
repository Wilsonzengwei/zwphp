<div id="shipping_method_list">
	<?php
	$Country=$_GET['Country'];
	$CId=$db->get_value('country', "Country='$Country'", 'CId');
	if($CId){
		$order_product_weight==1 && $total_weight=$db->get_sum('shopping_cart', $where, 'Qty*Weight');	//商品总重量
		$shipping_method_row=$db->get_all('shipping', '1', '*', 'MyOrder desc, SId asc');
		
		for($i=0; $i<count($shipping_method_row); $i++){
			if($shipping_method_row[$i]['FreeShippingInvocation']==1 && $total_price>=$shipping_method_row[$i]['FreeShippingPrice']){
				$shipping_price=0;
			}else{
				$shipping_price_row=$db->get_one('shipping_price', "SId='{$shipping_method_row[$i]['SId']}' and CId='$CId'");
				if($order_product_weight==1){
					$ExtWeight=$total_weight>$shipping_price_row['FirstWeight']?$total_weight-$shipping_price_row['FirstWeight']:0;	//超出的重量
					$shipping_price=(float)(@ceil($ExtWeight/$shipping_price_row['ExtWeight'])*$shipping_price_row['ExtPrice']+$shipping_price_row['FirstPrice']);
				}else{
					$shipping_price=$shipping_price_row['FirstPrice'];
				}
			}
			if($i==0){
				$SId=$shipping_method_row[$i]['SId'];
				$default_shipping_price=$shipping_price;
			}
		?>
			<div class="shipping">
				<div class="ft">
					<div class="radio"><input type="radio" name="_SId" value="<?=$shipping_method_row[$i]['SId'];?>" <?=$i==0?'checked':'';?> onclick="cart_change_shipping_method(<?=iconv_price($shipping_price, 2);?>, this.value);" /></div>
					<div class="txt"><?=$shipping_method_row[$i]['Express'];?> / <?=$shipping_price?iconv_price($shipping_price):'<font class="free_shipping">Free Shipping</font>';?><?php if($order_product_weight==1){?>&nbsp;&nbsp;&nbsp;( Parcel Weight: <?=$total_weight;?> KG )<?php }?></div>
					<div class="clear"></div>
				</div>
				<div class="explanation"><?=$shipping_method_row[$i]['Explanation'];?><?php if($order_product_weight==1 && $shipping_price){?>&nbsp;&nbsp;&nbsp;( <strong>Shipping Price:</strong> First <?=$shipping_price_row['FirstWeight'];?> KG : <?=iconv_price($shipping_price_row['FirstPrice']);?> / <?=$shipping_price_row['ExtWeight'];?> KG : <?=iconv_price($shipping_price_row['ExtPrice'])?> )<?php }?></div>
			</div>
		<?php }?>
	<?php }else{?>
		<div class="blank6"></div>
		Please select shipping country first! 
	<?php }?>
</div>
<script language="javascript">shipping_method_init(<?=iconv_price($default_shipping_price, 2);?>, <?=(int)$SId;?>);</script>