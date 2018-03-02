<?php
$query_string=query_string('act');

if($_POST['data']=='cart_list'){
	for($i=0; $i<count($_POST['CId']); $i++){
		$_CId=(int)$_POST['CId'][$i];
		$_ProId=(int)$_POST['ProId'][$i];
		$_Qty=abs((int)$_POST['Qty'][$i]);
		$_Qty<=0 && $_Qty=1;
		$_S_Qty=abs((int)$_POST['S_Qty'][$i]);
		$_Remark=$_POST['Remark'][$i];
		$_S_Remark=$_POST['S_Remark'][$i];
		
		if($_Qty!=$_S_Qty || $_Remark!=$_S_Remark){
			$product_row=$db->get_one('product', "ProId='$_ProId'");
			$db->update('shopping_cart', "$where and CId='$_CId'", array(
					'Qty'	=>	$_Qty,
					'Remark'=>	$_Remark,
					'Price'	=>	pro_add_to_cart_price($product_row, $_Qty, $order_product_price_field)
				)
			);
		}
	}
	js_location("$cart_url?module=checkout");
}

if($_GET['act']=='remove' || $_GET['act']=='later'){
	$query_string=query_string(array('act', 'CId'));
	$CId=(int)$_GET['CId'];
	$db->delete('shopping_cart', "$where and CId='$CId'");
	
	if($_GET['act']=='later' && (int)$_SESSION['member_MemberId']){
		$ProId=(int)$_GET['ProId'];
		if(!$db->get_row_count('wish_lists', "$where and ProId='$ProId'")){
			$db->insert('wish_lists', array(
					'MemberId'	=>	(int)$_SESSION['member_MemberId'],
					'ProId'		=>	$ProId
				)
			);
		}
	}
	js_location("$cart_url?$query_string");
}

$cart_row=$db->get_all('shopping_cart', $where, '*', 'ProId desc, CId desc');
?>
<div id="lib_cart_station"><a href="/"><?=$website_language['cart'.$lang]['home']; ?></a> &gt; <?=$website_language['cart'.$lang]['cart']; ?></div>
<div id="lib_cart_list">
	<?php if(!$cart_row){?>
		<div class="empty_cart">
			<img src="/images/lib/cart/no_items.gif" align="left" />
			<?=$website_language['cart'.$lang]['tips']; ?>
		</div>
	<?php
	}else{
		$total_price=$db->get_sum('shopping_cart', $where, 'Qty*Price');
	?>
		<div class="cart_info">
			<div class="fl"><?=$website_language['cart'.$lang]['lang_0']; ?>: <span id="total_item"><?=(int)$db->get_sum('shopping_cart', $where, 'Qty');?></span> <?=$website_language['cart'.$lang]['lang_1']; ?>, <?php /*if($order_product_weight==1){?>Weight: <span id="total_weight"><?=$db->get_sum('shopping_cart', $where, 'Qty*Weight');?></span> KG, <?php }?>Subtotal: <span id="total_price_0"><?=iconv_price($total_price);?></span><?php if($order_discount>0){?>, Discount: <span><?=$order_discount*100;?>%</span>, Save: <span id="discount_save"><?=iconv_price($total_price*$order_discount);?></span><?php }*/ ?></div>
			<?php /*
			<div class="fr"><a href="/">Continue Shopping</a><a href="javascript://;" onclick="$_('cart_list_form').submit();">Proceed to Checkout</a></div>*/ ?>
		</div>
		<form action="<?=$cart_url.'?'.$query_string;?>" method="post" name="cart_list_form" id="cart_list_form" OnSubmit="return checkForm(this);">
			<div class="cart">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="item_list_table">
					<tr class="tb_title">
						<td width="<?=$phone_client_agent ? '25%' : '20%'; ?>"><?=$website_language['cart'.$lang]['lang_2']; ?></td>
						<!-- <td width="12%" nowrap>Item No.</td> -->
						<td width="<?=$phone_client_agent ? '35%' : '32%'; ?>" nowrap><?=$website_language['cart'.$lang]['lang_3']; ?></td>
						<td width="<?=$phone_client_agent ? '20%' : ''; ?>"><?=$website_language['cart'.$lang]['lang_4']; ?></td>
						<?php if(!$phone_client_agent){ ?><td width=""><?=$website_language['cart'.$lang]['lang_5']; ?></td><?php } ?>
						<td width=""><?=$website_language['cart'.$lang]['lang_6']; ?></td>
						<td width="" class="last">&nbsp;</td>
					</tr>
					<?php
					for($i=0; $i<count($cart_row); $i++){
						$pro_row=$db->get_one('product',"ProId = '{$cart_row[$i]['ProId']}'",'Stock,ExtAttr');
					?>
					<tr class="item_list item_list_out" onmouseover="this.className='item_list item_list_over';" onmouseout="this.className='item_list item_list_out';">
						<td valign="top"><table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td align="center" class="item_img"><a href="<?=$cart_row[$i]['Url'];?>" target="_blank"><img src="<?=$cart_row[$i]['PicPath'];?>" /></a></td></tr></table></td>
						<?php /*<td valign="top"><a href="<?=$cart_row[$i]['Url'];?>" target="_blank" class="proname"><?=$cart_row[$i]['ItemNumber'];?></a><?php if($order_product_weight==1){?><br />Weight: <?=$cart_row[$i]['Weight'];?> KG<?php }?></td>*/ ?>
						<td valign="top">
							<a href="<?=$cart_row[$i]['Url'];?>" target="_blank" class="proname"><?=$cart_row[$i]['Name'];?></a><br />
                            <?php if($cart_row[$i]['Property']!='""'){
								$Property='';
                             	$Property=str::json_data(htmlspecialchars_decode($cart_row[$i]['Property']), 'decode');
								$ParameterPrice_row=str::json_data(htmlspecialchars_decode($pro_row['ExtAttr']), 'decode');
								$pro_row['Stock']=$ParameterPrice_row[$cart_row[$i]['Attr_key']][1];
								foreach((array)$Property as $k=>$v){
							?>
                            	<?=$k?>: <?=$v;?><br />
                            <?php }}?>
							<span class="remark"><?=$website_language['cart'.$lang]['lang_7']; ?>:</span><br /><input name="Remark[]" value="<?=addslashes($cart_row[$i]['Remark']);?>" type="text" size="70" maxlength="100" class="form_input" /><input type="hidden" name="S_Remark[]" value="<?=addslashes($cart_row[$i]['Remark']);?>" />
						</td>
						<td align="center" class="c_red" id="price_<?=$i;?>">
							<?=iconv_price($cart_row[$i]['Price']);?> <br />
							<?php if($phone_client_agent){ ?>
								Qty : <?=$cart_row[$i]['Qty'];?>
							<?php } ?>
						</td>
						<?php if(!$phone_client_agent){ ?>
							<td align="center" nowrap>
								<?=$cart_row[$i]['Qty'];?>
								<?php /*<a href="javascript://" onclick="cart_add_cut_qty(-1, <?=$i;?>, <?=$cart_row[$i]['StartFrom'];?>, <?=$cart_row[$i]['CId'];?>, <?=$cart_row[$i]['ProId'];?>, '<?=$cart_url;?>','<?=$pro_row['Stock']?>'); this.blur();"><img src="/images/lib/cart/cut.jpg" align="absbottom" /></a>
								<input type="text" name="Qty[]" id="Qty_<?=$i;?>" value="<?=$cart_row[$i]['Qty'];?>" class="form_input qty" onkeyup="set_number(this, 0); cart_add_cut_qty(0, <?=$i;?>, <?=$cart_row[$i]['StartFrom'];?>, <?=$cart_row[$i]['CId'];?>, <?=$cart_row[$i]['ProId'];?>, '<?=$cart_url;?>','<?=$pro_row['Stock']?>');" onpaste="set_number(this, 0); cart_add_cut_qty(0, <?=$i;?>, <?=$cart_row[$i]['StartFrom'];?>, <?=$cart_row[$i]['CId'];?>, <?=$cart_row[$i]['ProId'];?>, '<?=$cart_url;?>','<?=$pro_row['Stock']?>');" size="4" maxlength="5" />
								<a href="javascript://" onclick="cart_add_cut_qty(1, <?=$i;?>, <?=$cart_row[$i]['StartFrom'];?>, <?=$cart_row[$i]['CId'];?>, <?=$cart_row[$i]['ProId'];?>, '<?=$cart_url;?>','<?=$pro_row['Stock']?>'); this.blur();"><img src="/images/lib/cart/add.jpg" align="absbottom" /></a>
								<?php if($order_product_start_from==1){?><br />start from: <?=$cart_row[$i]['StartFrom'];?> pieces<?php }?>
								<input type="hidden" name="S_Qty[]" value="<?=$cart_row[$i]['Qty'];?>" />
								<input type="hidden" name="CId[]" value="<?=$cart_row[$i]['CId'];?>" />
								<input type="hidden" name="ProId[]" value="<?=$cart_row[$i]['ProId'];?>" />*/ ?>
							</td>
						<?php } ?>
						<td align="center" class="c_red" id="sub_total_<?=$i;?>"><?=iconv_price($cart_row[$i]['Price']*$cart_row[$i]['Qty']);?></td>
						<td align="center" nowrap>
							<a href="<?=$cart_url.'?'.$query_string;?>&act=remove&CId=<?=$cart_row[$i]['CId'];?>" title="Remove this item from shopping cart" class="opt"><?=$website_language['cart'.$lang]['lang_8']; ?></a>
							<?php /*if((int)$_SESSION['member_MemberId']){?><a href="<?=$cart_url.'?'.$query_string;?>&act=later&CId=<?=$cart_row[$i]['CId'];?>&ProId=<?=$cart_row[$i]['ProId'];?>" title="Remove this item from shopping cart and save this item to you wish list!" class="opt"><?=$website_language['cart'.$lang]['lang_9']; ?></a><?php }*/ ?></td>
					</tr>
					<?php }?>
					<tr class="total">
						<td colspan="<?=$phone_client_agent ? '3' : '4'; ?>"></td>
						<td colspan="2" id="total_price_1"><?=iconv_price($total_price);?></td>
					</tr>
				</table>
			</div>
			<div class="checkout"><input type="image" name="imageField" src="/images/lib/cart/btn_cheakout.png" /></div>
			<input type="hidden" name="data" value="cart_list" />
		</form>
	<?php }?>
</div>