<?php
$query_string=query_string(array('page', 'do'));

$act=$_GET['act'];

$status=abs((int)$_GET['status']);
($status && !array_key_exists($status, $order_status_ary)) && $status=$order_default_status;
$act_ary=array('list', 'detail', 'cancel','payment');
!in_array($act, $act_ary) && $act=$act_ary[0];
?>

<div id="lib_member_orders">
	<?php
	if($act=='list'){
		!$_SESSION['member_MemberId'] && js_location("{$_SERVER['PHP_SELF']}?module=login&jump_url=".urlencode($_SERVER['PHP_SELF'].'?'.query_string()));
		$page_count=20;
		$where = 'MemberId ='.(int)$_SESSION['member_MemberId'];
		$row_count=$db->get_row_count('orders', $where);
		$total_pages=ceil($row_count/$page_count);
		$page=(int)$_GET['page'];
		$page<1 && $page=1;
		$page>$total_pages && $page=1;
		$start_row=($page-1)*$page_count;
		$order_row=$db->get_limit('orders', $where, '*', 'OrderStatus asc ,OrderTime desc', $start_row, $page_count);
	?>
		<div class="lib_member_title"><a href="<?=$member_url;?>?module=orders&act=list"><?=$website_language['member']['order']['list']; ?></a></div>
		<table width="100%" border="0" cellpadding="0" cellspacing="1" class="item_list">
			<tr class="tb_title">
				<td width="170px;" nowrap><?=$website_language['member']['order']['number']; ?></td>
				<td width="200px;" nowrap><?=$website_language['member']['order']['cus_name']; ?></td>
				<?php /*<td width="12%" nowrap><?=$website_language['member']['order']['supplier']; ?></td>*/ ?>
				<!-- <td width="7%" nowrap><?//=$website_language['member']['order']['o_products']; ?></td> 
				<td><?=$website_language['member']['order']['order_shipping']; ?></td>
				-->
				
				<td width="100px;" nowrap><?=$website_language['member']['order']['order_shipping']; ?></td>
				<td width="150px" nowrap><?=$website_language['member']['order']['order_time']; ?></td>
				<td width="100px;" nowrap><?=$website_language['member']['order']['order_status']; ?></td>
			</tr>
			<?php
			for($i=0; $i<count($order_row); $i++){
			?>
			<tr class="item_list item_list_out" onmouseover="this.className='item_list item_list_over';" onmouseout="this.className='item_list item_list_out';" align="center">
				<td nowrap><a href="<?=$member_url;?>?module=orders&OId=<?=$order_row[$i]['OId'];?>&act=detail" class="detail_link"><?=$order_row[$i]['OId'];?></a></td>
				<td nowrap><?=$order_row[$i]['ShippingFirstName'].' '.$order_row[$i]['ShippingLastName'];?></td>
				<?php /*<td nowrap><a href="/supplier/?SupplierId=<?=$order_row[$i]['SupplierId']; ?>"><?=$db->get_value('member','MemberId='.(int)$order_row[$i]['SupplierId'],'Email');?></a></td>*/ ?>
				<td><?=$order_row[$i]['Express'];?></td>
				
				<!--<td><?=$order_row[$i]['PaymentMethod']; ?></td> <td nowrap><?//=$db->get_value('product','ProId='.$order_row[$i]['ProId'],'Name');?></td> -->
				<td nowrap><?=date('d/m-Y H:i:s', $order_row[$i]['OrderTime']);?></td>
				<?php 
					if($order_row[$i]['OrderStatus'] == '1'){
						$PaymentStatus = '<font style="color:#ec6400;">'.$website_language['member']['order']['Unpaid'].'</font>';
					}elseif($order_row[$i]['OrderStatus'] > '1' && $order_row[$i]['OrderStatus'] !== '8'){
						$PaymentStatus = '<font style="color:blue;">'.$website_language['member']['order']['processing'].'</font>';
					}elseif($order_row[$i]['OrderStatus'] == '8'){
						$PaymentStatus = '<font style="color:;">'.$website_language['member']['order']['completed'].'</font>';
					}

				?>
				<td><?php if($order_row[$i]['OrderStatus'] == '1'){?><a href="/account.php?module=orders&OId=<?=$order_row[$i]['OId'];?>&act=payment&OrderId=<?=$order_row[$i]['OrderId']?>"><?=$PaymentStatus;?></a><?php }else{?><?=$PaymentStatus;?><?php }?></td>
			</tr>
			<?php }?>
			<?php if(!count($order_row)){?>
			<tr>
				<td align="center" height="150" colspan="8" bgcolor="#ffffff"><?=$website_language['member']['order']['no_order']; ?></td>
			</tr>
			<?php }?>
		</table>
		<div class="blank20"></div>
        <div id="turn_page"><?=turn_page_html($row_count, $page, $total_pages, "?$query_string&page=", 'Previous', 'Next');?></div>
    <?php }elseif($act == "payment"){

    		$OId_r = $_GET['OId'];
    		$OId = explode(",",$OId_r);
    		
    		$ordeId_r = $_GET['OrderId'];
    		$OrderId = explode(",",$ordeId_r);
    		//var_dump($OId);exit;
    		$TotalPrice = array();
    		$order_list_row = array();
    		for($i=0;$i<count($OId);$i++){
    			$order_list_row[] = $db->get_one('orders_product_list',"OrderId='$OrderId[$i]'");
    			$order_rows[] = $db->get_one('orders',"OrderId='$OrderId[$i]'");
    			$TotalPrice[] = $db->get_one('orders',"OId='$OId[$i]'");
    			$SupplierIds[] = $order_list_row[$i]['SupplierId'];
    			$SupplierIdss[] =  $db->get_one('member',"MemberId='$SupplierIds[$i]'");
    			//var_dump($SupplierIds);exit;
    		}
    		//var_dump($order_list_row);exit;
    	?>

<?php
	echo '<link rel="stylesheet" href="/css/user/order_list'.$lang.'.css">'
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
	<?php for($i=0;$i<count($OId);$i++){
		$TotalPrice_r[$i] = $TotalPrice[$i]['TotalPrice'];

	?>
		<div class="b1">
			<div class="b2" style="5">
				<img class="b2_img" src="<?=$order_list_row[$i]['PicPath']?>">
			</div>
			<div class="b3">
				<div class="he_mask"><span class='span_title'><?=$website_language['user_ol'.$lang]['spmc']?></span><span class='he1'>：</span><div class="hhe"><?=$order_list_row[$i]['Name'.$lang.'']?></div>
				</div>
				<div class="he_mask"><span class='span_title'><?=$website_language['user_ol'.$lang]['mjmc']?></span><span class='he1'>：</span><div class="hhe"><?=$SupplierIdss[$i]['Supplier_Name'];?></div>
				</div>
				<div class="he_mask"><span class='span_title'><?=$website_language['user_ol'.$lang]['jyje']?></span><span class='he1'>：</span><div class="ca_b2">USD $<?=$TotalPrice[$i]['TotalPrice'];?></div>
				</div>
				<div class="he_mask"><span class='span_title'><?=$website_language['user_ol'.$lang]['gmsj']?></span><span class='he1'>：</span><div class="hhe"><?php //var_dump($order_rows[$i]);exit; ?><?=date("Y-m-d H:i:s",$order_rows[$i]['OrderTime']);?></div>
				</div>				
				<div class="he_mask"><span class='span_title'><?=$website_language['user_ol'.$lang]['ddh']?></span><span class='he1'>：</span><div class="hhe"><?=$OId[$i]?></div>
				</div>
			</div>		
		</div>

		<?php } ?>
	</div>
</div>
<div class="mask">
	<div class="bbg2">
		<div class="c1">
			<div class="y_check"><span class="yc_title"><?=$website_language['user_ol'.$lang]['zffs']?>：</span>
					<!-- <a class="y_input"><input class="input_r" type="radio" value="1" name="Status" checked><span class='input_s'><?=$website_language['user_ol'.$lang]['xszf']?></span></a> -->
					<a class="y_input"><input class="input_r" type="radio" value="0" name="Status" id="" checked><span class='input_s'><?=$website_language['user_ol'.$lang]['xxzf']?></span></a>
           	</div>	
           	<div class="clear"></div>	         
           	<div class="d1">
           		<div  style="" class="pay_list">
           			<li data='1' class="li_list li_list2"><?=$website_language['user_ol'.$lang]['bmdzf']?></li>
           			<li data='2' class="li_list"><?=$website_language['user_ol'.$lang]['gjhk']?></li>
           			<li data='3' class="li_list"><?=$website_language['user_ol'.$lang]['zggnfk']?></li>
           			<li data='4' class="li_list"><?=$website_language['user_ol'.$lang]['xlhk']?></li>
           		</div>
           		<div class="clear"></div>
           		<div class="e1">
           			<div data='1' class="pay_li">
           				<div class="he_mask"><span>MATRIZ </span><span class='h23'>：</span><span>TECHNOPARK REPUBLICA DE 	URUGUAY 48-9 COLONIA CENTRO CP.06000 MEXICO CITY </span>
						</div>
						<div class="he_mask"><span>TEL</span><span class='h23'>：</span><span>0155-50864939</span>
						</div>
						<div class="he_mask"><span>SUCURSAL TERESA  </span><span class='h23'>：</span><span>AV.EJE CENTRAL LAZARO CARDENAS 109 LOC. 184 COLONIA CENTRO CP.06070 MEXICO CITY </span>
						</div>
						<div class="he_mask"><span>SUCURSAL URUGUAY</span><span class='h23'>：</span><span>REPUBLICA DE URUGUAY 12 LOCAL 5 Y 6 COLONIA CENTRO CP.06000 MEXICO CITY </span>
						</div>						
           			</div>
           			<div data='2' class="pay_li pay_li2">
           				<div class="he_mask"><span class='w_140'><?=$website_language['user_ol'.$lang]['yygjskzh']?></span><span class='h23'>：</span><span>6232 6320 0010 0279 008 </span>
						</div>
						<div class="he_mask"><span class='w_140'><?=$website_language['user_ol'.$lang]['skr']?></span><span class='h23'>：</span><span><?=$website_language['user_ol'.$lang]['zjgs']?>-50864939</span>
						</div>	
						<div class="h12"><?=$website_language['user_ol'.$lang]['zt']?></div>
						<div class="h13"><?=$website_language['user_ol'.$lang]['zf']?></div>					
           			</div>
           			<div data='3' class="pay_li pay_li2">
           				<div class="he_mask"><span class='w_270'><?=$website_language['user_ol'.$lang]['zggnfkzh']?></span><span class='h23'>：</span><span>6217 9311 0023 0483</span>
						</div>
						<div class="he_mask"><span class='w_270'><?=$website_language['user_ol'.$lang]['skr']?></span><span class='h23'>：</span><span>颜国飘</span>
						</div>	
						<div class="h12"><?=$website_language['user_ol'.$lang]['zt']?></div>
						<div class="h13"><?=$website_language['user_ol'.$lang]['zf']?></div>				
           			</div>
           			<div data='4' class="pay_li pay_li2">
           				<div class="he_mask"><span class='w_170'><?=$website_language['user_ol'.$lang]['xlhkyhm']?></span><span class='h23'>：</span><span>YAN GUOPIAO 1984/07/02</span>
						</div>
						<div class="he_mask"><span class='w_170'><?=$website_language['user_ol'.$lang]['sjhm']?></span><span class='h23'>：</span><span>13922882034</span>
						</div>	
						<div class="he_mask"><span class='w_170'><?=$website_language['user_ol'.$lang]['xlhkyhm']?></span><span class='h23'>：</span><span>ZHEN YUNLEI 1986/09/05</span>
						</div>
						<div class="he_mask"><span class='w_170'><?=$website_language['user_ol'.$lang]['sjhm']?></span><span class='h23'>：</span><span>15976408881</span>
						</div>											
           			</div>
           		</div>
           	</div>
		</div>
	</div>
</div>
<script>
	$('.input_r').click(function(){
			$('.y_input').css('color','#666');
			$(this).parent('.y_input').css('color','#006ac3');
		})

	$('.li_list').click(function(){
		var da=$(this).attr('data');
		$('.pay_li').each(function(){
			if($(this).attr('data')==da){
				$(this).css('display','block');
			}else{
				$(this).css('display','none');
			}
		})
		$('.pay_list').find('.li_list').css('border','1px solid #ccc');
		$('.pay_list').find('.li_list').css('background','none');
		$(this).css('border','1px solid #2962ff');
		$(this).css('background','url(/images/payment/queding.png) no-repeat bottom right');
	})
</script>

	<?php }else{
		$OId=$_GET['OId'];
		$order_row=$db->get_one('orders', "OId='$OId'");
		$OrderId = $order_row['OrderId'];
		!$order_row && js_location("$member_url?module=orders&act=list");
		$products_row=$db->get_one('product', "ProId='{$order_row['ProId']}'");
	?>
		<div class="lib_member_title"><a href="<?=$member_url;?>?module=orders&act=list"><?=$website_language['member']['order']['detail']; ?></a></div>
		<div class="order_index"><?=$website_language['member']['order']['number']; ?>#<?=$OId;?>&nbsp;&nbsp;<em></em></div>
		<div class="blank12"></div>
		<div class="detail">
			<div><?=$website_language['member']['order']['detail']; ?></div>
		</div>
		<div class="detail_card">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_info">
			  <tr>
				<td width="110"><?=$website_language['member']['order']['number']; ?>:</td>
				<td><?=$order_row['OId'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member']['order']['order_time']; ?>:</td>
				<td><?=date('d/m-Y H:i:s', $order_row['OrderTime']);?></td>
			  </tr>
			  <?php if($order_row['TrackingNumber']){ ?>
				  	<tr>
						<td><?=$website_language['member']['order']['track']; ?>:</td>
						<td><?=$order_row['TrackingNumber'];?></td>
				  	</tr>
			  <?php } ?>
			  <?php if(get_cfg('order.order_payment')){?>
			  <tr>
				<td><?=$website_language['member']['order']['order_payment']; ?>:</td>
				<td><?=$order_row['PaymentMethod'];?></td>
			  </tr>
			  <?php } ?>
			  <tr>
				<td><?=$website_language['member']['order']['order_shipping']; ?>:</td>
				<td><?=$order_row['Express'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member']['order']['customs_clearance']; ?>:</td>
				<td><?=$order_row['AgentMode'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member']['order']['address']; ?>:</td>
				<td><?=$order_row['ShippingAddressLine1'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member']['order']['order_code']; ?>:</td>
				<td><?=$order_row['ShippingPostalCode'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member']['order']['order_phone']; ?>:</td>
				<td><?=$order_row['ShippingPhone'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member']['other']['pay_number']; ?>:</td>
				<td><?=$mCfg['Pay_Number'];?></td>
			  </tr>
			</table>

			<div class="blank20"></div>
			<div class="item_info"><?=$website_language['member']['order']['message']; ?>:</div>
			<div class="flh_180"><?=format_text($order_row['Comments']);?></div>
			<div class="blank20"></div>
			<div class="item_info"><?=$website_language['member']['order']['o_products']; ?>:</div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="detail_item_list">
				<tr class="tb_title">
					<td width="14%"><?=$website_language['member']['order']['img']; ?></td>
					<td width="50%"><?=$website_language['member']['order']['pro']; ?></td>
					<td width="12%"><?=$website_language['member']['order']['price']; ?></td>
					<td width="12%"><?=$website_language['member']['order']['qty']; ?></td>
					<td width="12%" class="last"><?=$website_language['member']['order']['total']; ?></td>
				</tr>
				<?php
				$pro_count=0;
				$item_row=$db->get_all('orders_product_list', "OrderId='{$order_row['OrderId']}'", '*', 'ProId desc, LId desc');
				for($i=0; $i<count($item_row); $i++){
					$pro_count+=$item_row[$i]['Qty'];
				?>
				<tr class="item_list item_list_out" onmouseover="this.className='item_list item_list_over';" onmouseout="this.className='item_list item_list_out';" align="center">
					<td valign="top"><table width="92" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td height="92" align="center" class="item_img"><a href="<?=$item_row[$i]['Url'];?>" target="_blank"><img src="<?=$item_row[$i]['PicPath'];?>" /></a></td></tr></table></td>
					<td align="left" class="flh_150">
						<a href="<?=$item_row[$i]['Url'];?>" target="_blank" class="proname"><?=$item_row[$i]['Name'];?></a><br />
						Item No.: <a href="<?=$item_row[$i]['Url'];?>" target="_blank" class="proname"><?=$item_row[$i]['ItemNumber'];?></a><br />
						<?php if($item_row[$i]['Color']){?>Color: <?=$item_row[$i]['Color'];?><br /><?php }?>
						<?php if($item_row[$i]['Size']){?>Size: <?=$item_row[$i]['Size'];?><br /><?php }?>
						<?php if($order_product_weight==1){?>Weight: <?=$item_row[$i]['Weight'];?> KG<br /><?php }?>
						Purchasing Remark: <?=htmlspecialchars($item_row[$i]['Remark']);?>
					</td>
					<td><?=iconv_price($item_row[$i]['Price']);?></td>
					<td><?=$item_row[$i]['Qty'];?></td>
					<td><?=iconv_price($item_row[$i]['Price']*$item_row[$i]['Qty']);?></td>
				</tr>
				<?php }?>
				<tr class="total">
					<td colspan="3">&nbsp;</td>
					<td></td>
					<td><?=iconv_price($order_row['TotalPrice']);?></td>
				</tr>

			</table>
			<?php if($order_row['PaymentStatus'] !== '2'){?>
				<div style="float:right;width: 80px;height: 30px;margin-right:10px; "><a href="/account.php?module=orders&OId=<?=$OId?>&act=payment&OrderId=<?=$OrderId?>"><img style="max-width: 100%;max-height: 100%;" src="/images/jiesuan002.png"></a></div><br/>
			<?php }?>
			<div class="titleState">
				<span class="titleInfo"><?=$website_language['member']['order']['logistics']; ?></span>
			</div>
			<?php 
				$ExpressCompany = $order_row['ExpressCompany'];
				$Orders_Express = $order_row['Express'];
				$AgentMode = $order_row['AgentMode'];
				$freight_row=$db->get_one('shipping_freight',"FreightModes='$ExpressCompany'");
				$shipping_row=$db->get_one('shipping',"Express='$Orders_Express'");
				$FreightCost = $freight_row['FreightCost'];
				$CustomsClearance = $shipping_row['CustomsClearance'];
			?>
			<table border="0" cellspacing="0" cellpadding="0" class="cost">
				<tr>
					<td class="tips-cost"><?=$website_language['member']['order']['costAcquisition']; ?></td>
					<td class="num-cost"><?=$website_language['member']['order']['transport']; ?>:<label class="lab-cost"><?=iconv_price($order_row['ShippingCharges']); ?></label></td>
				</tr>
				<tr>
					<td class="tips-cost"><?=$website_language['member']['order']['serviceCharge']; ?></td>
					
					<td class="num-cost"><?=$website_language['member']['order']['clearance']; ?>:<label class="lab-cost">
										<?php if($AgentMode == $website_language['goods']['voluntarily']){?>
											- - - -
										<?php }else{?>
											<?=iconv_price($order_row['CustomsClearance']);?>
										<?php }?>
										</label>
					</td>
					
				</tr>
				<tr>
					<td class="tips-cost"></td>

					<td class="num-cost" style="font-weight: bold;"><?=$website_language['member']['order']['sum']; ?>:<label class="lab-cost"> 
					<?php if($AgentMode == $website_language['goods']['voluntarily']){?>
						<?=iconv_price($order_row['ShippingCharges']); ?>
					<?php }else{?>
						<?=iconv_price($order_row['CustomsClearance']+$order_row['ShippingCharges']); ?>
					<?php }?>
					</label></td>
				</tr>
			</table>
				<div style="float:right;width: 80px;height: 30px;margin-right:10px; "><a href="/account.php?module=orders&OId=<?=$OId?>&act=payment&OrderId=<?=$OrderId?>"><img style="max-width: 100%;max-height: 100%;" src="/images/jiesuan002.png"></a></div><br/>
			<?php 
				$order_row_2=$db->get_one('orders', "OId='$OId'");
				$OrderId = $order_row_2['OrderId'];
				$stutas = $db->get_all('freight_stutas',"OrderId='$OrderId'");
				$stutas_count = count($stutas);
				$stutas_ros = $stutas[$stutas_count-1];

			?>
			<div class="titleState">
				<span class="titleInfo"><?=$website_language['member']['order']['waybillNumber']; ?>:<?=$stutas_ros['TrackingNumber']?></span>
				<span class="titleInfo mid"><?=$website_language['member']['order']['company']; ?>:<?=$ExpressCompany?></span>
				<span class="titleInfo right"><?=$website_language['member']['order']['telephone']; ?>:0755-33119835</span>
			</div>
			<table class="table-state">
				<tr>
					<td class="time-state"><?=$website_language['member']['order']['time']; ?></td>
					<td class="sign-state"></td>
					<td class="content-state"><?=$website_language['member']['order']['progress']; ?></td>
				</tr>
				
				<?php for($i=0; $i<$stutas_count; $i++){?>
				<tr>
					<td class="timeInfo">
					<?=date('Y-m-d H:i:s',$stutas[$i]['StutasTime']);?>
					</td>
					<td class="signImg"></td>
					<td><?=$stutas[$i]['ProductStutas'];?></td>
				</tr>
				<?php }?>
				
			</table>
			<div class="tips-state"><?=$website_language['member']['order']['Cre_1']?></div>
		</div>
	<?php }?>
</div>
<!-- Live800在线客服图标:默认图标[浮动图标]开始-->
<div style='display:none;'>< a href=' '>网页聊天</ a></div><script language="javascript" src="http://chat.live800.com/live800/chatClient/floatButton.js?jid=5513164191&companyID=846315&configID=126818&codeType=custom"></script><div style='display:none;'>< a href='http://en.live800.com'>live chat</ a></div>
<!-- 在线客服图标:默认图标结束-->
<div style='display:none;'><a href='http://www.live800.com'>客服系统</a></div>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-40714410-22']);
 _gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();
</script>
<div style='display:none;'><a href='http://en.live800.com'>live chat</a></div>
<script type="text/javascript">
	$(document).ready(function(){
		if($(".signImg").length >1){
			$(".signImg:first").css("background","url(/images/sign-y.png) no-repeat center");
		}
		$(".signImg:last").css("background","url(/images/sign-c.png) no-repeat center");
		$(".table-state tr:last").css("color","#ec680c");
	})
</script>