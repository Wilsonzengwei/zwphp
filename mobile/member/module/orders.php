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
		$order_row=$db->get_limit('orders', $where, '*', 'OrderId desc', $start_row, $page_count);
	?>
		<div class="lib_member_title"><a href="<?=$member_url;?>?module=orders&act=list"><?=$website_language['member'.$lang]['order']['list']; ?></a></div>
		<table width="100%" border="0" cellpadding="0" cellspacing="1" class="item_list">
			<tr class="tb_title">
				<td width="" nowrap><?=$website_language['member'.$lang]['order']['number']; ?></td>
				<td width="" nowrap><?=$website_language['member'.$lang]['order']['cus_name']; ?></td>
				<?php /*<td width="12%" nowrap><?=$website_language['member'.$lang]['order']['supplier']; ?></td>*/ ?>
				<!-- <td width="7%" nowrap><?//=$website_language['member'.$lang]['order']['o_products']; ?></td> -->
				<td><?=$website_language['member'.$lang]['order']['order_shipping']; ?></td>
				<td><?=$website_language['member'.$lang]['order']['order_payment']; ?></td>
				<td width="10%" nowrap><?=$website_language['member'.$lang]['order']['order_time']; ?></td>
			</tr>
			<?php
			for($i=0; $i<count($order_row); $i++){
			?>
			<tr class="item_list item_list_out" onmouseover="this.className='item_list item_list_over';" onmouseout="this.className='item_list item_list_out';" align="center">
				<td nowrap><a href="<?=$member_url;?>?module=orders&OId=<?=$order_row[$i]['OId'];?>&act=detail" class="detail_link"><?=$order_row[$i]['OId'];?></a></td>
				<td nowrap><?=$order_row[$i]['ShippingFirstName'].' '.$order_row[$i]['ShippingLastName'];?></td>
				<?php /*<td nowrap><a href="/supplier/?SupplierId=<?=$order_row[$i]['SupplierId']; ?>"><?=$db->get_value('member','MemberId='.(int)$order_row[$i]['SupplierId'],'Email');?></a></td>*/ ?>
				<td><?=$order_row[$i]['Express']; ?></td>
				<td><?=$order_row[$i]['PaymentMethod']; ?></td>
				<!-- <td nowrap><?//=$db->get_value('product','ProId='.$order_row[$i]['ProId'],'Name'.$lang);?></td> -->
				<td nowrap><?=date('d/m-Y', $order_row[$i]['OrderTime']);?></td>
			</tr>
			<?php }?>
			<?php if(!count($order_row)){?>
			<tr>
				<td align="center" height="150" colspan="8" bgcolor="#ffffff"><?=$website_language['member'.$lang]['order']['no_order']; ?></td>
			</tr>
			<?php }?>
		</table>
		<div class="blank20"></div>
        <div id="turn_page"><?=turn_page_html($row_count, $page, $total_pages, "?$query_string&page=", 'Previous', 'Next');?></div>
	<?php }elseif($act=='payment'){ 
			$OId_r = $_GET['OId'];
    		$OId = explode(",",$OId_r);
    		
    		$ordeId_r = $_GET['OrderId'];
    		$OrderId = explode(",",$ordeId_r);
    		//var_dump($OId);exit;
    		$TotalPrice = array();
    		$order_list_row = array();
    		for($i=0;$i<count($OId);$i++){
    			$order_list_row[$i] = $db->get_one('orders_product_list',"OrderId='$OrderId[$i]'");
    			$TotalPrice[$i] = $db->get_one('orders',"OId='$OId[$i]'");
    		}

		?>
			
 <link href="/css/orders.css" rel="stylesheet" type="text/css" />

		<div id="pay1" class="pay1" style="width:100%;padding: 0px;margin:0px;margin-top:5px;min-height: 600px; background: #ffeded;">

			<div style="width: 760px;height: 40px;background: #ffd2d2;">
				<div style="float: left;margin-left:10px;margin-top:10px;width: 20px;"><img src="/images/pay/pay.png"/></div>
				<div style="float: left;line-height: 40px;margin-left:2px;width: 100px;"><?=$website_language['member'.$lang]['order']['pay_for_the_order']; ?></div>
				
				<!-- <div style="float: right;line-height: 40px;width: 100px;margin-right: 10px;"><a href="account.php?module=orders&OId=<?=$OId?>&act=detail"><font style="color: #ec6400;">返回订单详情</font></a></div> -->
			</div>
			<div style="width: 100%;height: 25px;">

				<table class="orders_class" style="width: 100%;height: 25px;background: #fff6f6;">
				
					<tr>
						<td style="display:inline-block;width: 24%;text-align: center;"><?=$website_language['member'.$lang]['wishlists']['img']; ?></td>
						<td style="display:inline-block;width: 24%;text-align: center;"><?=$website_language['member'.$lang]['wishlists']['name']; ?></td>
						<td style="display:inline-block;width: 24%;text-align: center;"><?=$website_language['member'.$lang]['order']['pro_qty']; ?></td>
						<td style="display:inline-block;width: 20%;text-align: center;"><?=$website_language['member'.$lang]['order']['pro_total']; ?></td>
					</tr>
					
				</table>
			</div>
<?php for($i=0;$i<count($OId);$i++){
	$TotalPrice_r[$i] = $TotalPrice[$i]['TotalPrice'];
	?>
			<div style="width: 100%;margin-top:1%">

				<table class="orders_class" style="width:100%;background: #fff6f6;">
				
					<tr>
						<td style="display:inline-block;width: 24%;text-align: center;word-break:break-all;padding-right:4px;height:80%;"><img style="height:100%;border:1px solid #ccc;width:80%; 
						" src="<?=$order_list_row[$i]['PicPath']?>"></td>
						<td style="display:inline-block;width: 24%;padding-top:2%;text-align: center;word-break:break-all;padding-right:4px"><?=$order_list_row[$i]['Name'.$lang];?></td>
						<td style="display:inline-block;width: 24%;text-align: center;word-break:break-all;padding-right:4px"><?=$order_list_row[$i]['Qty'];?>&nbsp;<?=$ContactUs_language['Mer_Info'.$lang]['piece']?></td>
						<td style="display:inline-block;width: 20%;text-align: center;word-break:break-all;padding-right:4px"><font style="color: #cc0d0d;">USD $<?=$TotalPrice[$i]['TotalPrice'];?></font></td>

					</tr>
					
				</table>
			</div>
				<style>
				.modeUl li{
					margin-top:0;
					border-radius:0;
					margin-top:10px;
				}
				#payUlLi{
					border:0px;
				}
				
			</style>
			<?php }
			$TotalPrice_parice_r = array_sum($TotalPrice_r);
			?>
			<!-- <div style="width: 100%;height: 30px;border-top: 1px solid #ddd;">
				<div style="width:189px;float: left;margin-left:30px;text-align: left;font-size:15px;line-height:30px;"><?=$website_language['member'.$lang]['order']['Settle_accounts']; ?></div>
				<div style="width:220px;float: right;text-align: center;color: red;"><font style="color: #000;line-height:30px;"><?=$website_language['member'.$lang]['order']['Order_total_price']; ?>：</font>USD <?=iconv_price($TotalPrice_parice_r);?></div>
			</div> -->
			<div class="bgBlx">
				<img src="/images/pay/blx.png"/>
			</div>
			<div class="mode" style="background: #ffeded;width:100%">
				<div style="width:100%" class="over-flow modePay">
					<p class="modeTitle"><?=$website_language['member'.$lang]['order']['mode_of_payment']; ?>：</p>
			
					<ul class="modeUl" style="width:100%">
						<li style="display:inline-block;min-width:94%;max-width:94%;" id="payUl">
							<?=$website_language['member'.$lang]['order']['Local_store_payment']; ?>
							<div class="payClick"><img src="/images/pay/payClick.png"/></div>							
						</li>

						<li id="payUlLi" style="min-width:94%;max-width:94%;margin-top:0;border-radius:0px;display:block;">
							<div  style="width:100%" class="payCon">
							<ul style="width:100%;margin:-5% auto -15%" class="payUl over-flow" id="payUlDiv">
						
							<div>
								<div style="width:20%;margin-left:2%" class="addressTitle">MATRIZ</div>
								<span style="float:left;margin-left:3%;margin-right:0%">:</span>
								<div style="width:70%;line-height:15px" class="address1">TECHNOPARK REPUBLICA DE URUGUAY 48-9
								COLONIA CENTRO CP.06000 MEXICO CITY
								</div>
							</div>
								<div style="clear:both"></div>
							<div style="margin-top:2%">
								<div style="width:20%;margin-left:2%" class="phoneTitle">TEL</div>
								<span style="float:left;margin-left:3%;margin-right:0%">:</span>
								<div style="width:70%;line-height:15px" class="phone">0155-50864939</div>
							</div>
					
						<div style="clear:both"></div>
							<div style="margin-top: 6%">
								<div style="width:20%;margin-left:2%" class="addressTitle">SUCURSAL TERESA</div>
								<span style="float:left;margin-left:3%;margin-right:0%">:</span>
								<div style="width:70%;float:left;margin-left:3%;" class="address1">AV.EJE CENTRAL LAZARO CARDENAS 109 LOC. 184
								COLONIA CENTRO CP.06070 MEXICO CITY
								</div>
							</div>
							<div style="clear:both"></div>
							<div style="margin-top:2%">
								<div style="width:20%;margin-left:2%" class="phoneTitle">TEL</div>
								<span style="float:left;margin-left:3%;margin-right:0%">:</span>
								<div style="width:70%;float:left;margin-left:3%;" class="phone">0155-57093616</div>
							</div>
					
						
						<div style="clear:both"></div>
							<div style="margin-top: 6%">
								<div style="width:20%;margin-left:2%" class="addressTitle">SUCURSAL URUGUAY</div>
								<span style="float:left;margin-left:3%;margin-right:0%">:</span>
								<div style="width:70%;float:left;margin-left:3%;" class="address1">REPUBLICA DE URUGUAY 12 LOCAL 5 Y 6
								COLONIA CENTRO CP.06000 MEXICO CITY
								</div>
							</div>							
						
					</ul>
					</div>
					</li>
						<li style="display:inline-block;min-width:94%;max-width:94%;" id="international"><?=$website_language['member'.$lang]['order']['international_remittance']; ?></li>
						<!-- <li id="wechat"><?=$website_language['member'.$lang]['order']['WeChat_Pay']; ?></li>
						<li id="payBao"><?=$website_language['member'.$lang]['order']['pay_by_Alipay']; ?></li> -->
						
						<li id="internationalLi" style="padding:5% 5% 5% 0;min-width:94%;max-width:94%;margin-top:0;border:1px solid #ddd;border-radius:0px;display:none">
							<div>
								<div style="width:40%;margin-left:2%" class="addressTitle"><?=$website_language['member'.$lang]['order']['Receipt_account']; ?></div>
								<span style="float:left;margin-left:3%;margin-right:0%">:</span>
								<div style="width:50%;line-height:15px" class="address1">6232 6320 0010 0279 008
								</div>
							</div>
								<div style="clear:both"></div>
							<div style="margin-top:1%">
								<div style="width:40%;margin-left:2%" class="phoneTitle"><?=$website_language['member'.$lang]['order']['Payee']; ?></div>
								<span style="float:left;margin-left:3%;margin-right:0%">:</span>
								<div style="width:50%;line-height:15px" class="phone">深圳市前海鹰洋国际贸易有限公司</div>
							</div>							
							</li>					
					
						</li>
						<li style="display:inline-block;min-width:94%;max-width:94%;" id="domestic"><?=$website_language['member'.$lang]['order']['Domestic_remittance']; ?>
							<div></div>
						</li>
						<li id="domesticLi" style="padding:5% 5% 5% 0;min-width:94%;max-width:94%;margin-top:0;border:1px solid #ddd;border-radius:0px;display:none">
							<div>
								<div style="width:40%;margin-left:2%" class="addressTitle"><?=$website_language['member'.$lang]['order']['Domestic_remittance']; ?></div>
								<span style="float:left;margin-left:3%;margin-right:0%">:</span>
								<div style="width:50%;line-height:15px" class="address1">6217 9311 0023 0483
								</div>
							</div>
								<div style="clear:both"></div>
							<div style="margin-top:1%">
								<div style="width:40%;margin-left:2%" class="phoneTitle"><?=$website_language['member'.$lang]['order']['Payee']; ?></div>
								<span style="float:left;margin-left:3%;margin-right:0%">:</span>
								<div style="width:50%;line-height:15px" class="phone"> 颜国飘</div>
							</div>								
							</li>	
						<li style="display:inline-block;min-width:94%;max-width:94%;" id="union"><?=$website_language['member'.$lang]['order']['Western_Union']; ?></li>
						<li id="unionLi" style="padding:5% 5% 5% 0;min-width:94%;max-width:94%;margin-top:0;border:1px solid #ddd;border-radius:0px;display:none">
							
								<div>
									<div style="width:35%;margin-left:2%" class="addressTitle"><?=$website_language['member'.$lang]['order']['Western_Union']?></div>
									<span style="float:left;margin-left:3%;margin-right:0%">:</span>
									<div style="width:45%;line-height:15px" class="address1">YAN GUOPIAO 1984/07/02
									</div>
								</div>
									<div style="clear:both"></div>
								<div style="margin-top:3%">
									<div style="width:35%;margin-left:2%" class="phoneTitle"><?=$website_language['manage'.$lang]['tra_slat6']?></div>
									<span style="float:left;margin-left:3%;margin-right:0%">:</span>
									<div style="width:45%;line-height:15px" class="phone"> 13922882034</div>
								</div>	
								<div class="clear"></div>
							
								<div style="margin-top: 6%;">
									<div style="width:35%;margin-left:2%" class="addressTitle"><?=$website_language['member'.$lang]['order']['Western_Union']?></div>
									<span style="float:left;margin-left:3%;margin-right:0%">:</span>
									<div style="width:35%;line-height:15px" class="address1">ZHEN YUNLEI 1986/09/05
									</div>
								</div>
									<div style="clear:both"></div>
								<div style="margin-top:3%">
									<div style="width:35%;margin-left:2%" class="phoneTitle"><?=$website_language['manage'.$lang]['tra_slat6']?></div>
									<span style="float:left;margin-left:3%;margin-right:0%">:</span>
									<div style="width:45%;line-height:15px" class="phone">15976408881</div>
								</div>							
						</li>

						<div style="width:100%;margin-top:10%">
							&nbsp;
								<div style="width:90%;padding-top:30%;padding-bottom:10%" class="tips">
							<?=$website_language['member'.$lang]['order']['zhushi']; ?>
						</div>
						</div>
					</ul>
				</div>			
				
				

					
	
					<div class="wechat" id="wechatDiv">
						<div class="wechatDiv">
							<div class="qrcode">
								<img src="/images/pay/qrCode.png"/>
							</div>
							<div class="wechatIcon">
								<div class="icon">
									<img src="/images/pay/sao.png"/>
								</div>
								<span class="iconFont">
									<?=$website_language['member'.$lang]['order']['Sweep_WeChat_code']; ?><br />
									<?=$website_language['member'.$lang]['order']['Complete_payment']; ?>
								</span>
							</div>
							<div class="price">
								USD <?=iconv_price($TotalPrice_parice_r);?>
							</div>
						</div>
					</div>
					<div class="payBao" id="payBaoDiv">
						<div class="wechatDiv">
							<div class="qrcode">
								<img src="/images/pay/qrCode.png"/>
							</div>
							<div class="payIcon">
								<div class="icon">
									<img src="/images/pay/sao.png"/>
								</div>
								<span class="iconFont">
									<?=$website_language['member'.$lang]['order']['Sweep_code']; ?><br />
									<?=$website_language['member'.$lang]['order']['Complete_payment']; ?>
								</span>
							</div>
							<div class="price">
								USD <?=iconv_price($TotalPrice_parice_r);?>
							</div>
						</div>
					</div>
					
					
					</div>
				</div>
			</div>
		</div>

		<script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){			
				var flag1=false;
				var flag2=true;
				var flag3=true;
				var flag4=true;
				$("#payUl").click(function(){
					flag2=true;		
					flag3=true;	
					flag4=true;	
					if(flag1){
						$("#payUlDiv").css("display","block");
						$("#payUlLi").css("display","block");
						$("#payUlLi").css("border","0px");
						$("#internationalDiv").css("display","none");
						$("#internationalLi").css("display","none");
						$("#domesticLi").css("display","none");	
						$("#internationalDiv").css("display","none");
						$("#wechatDiv").css("display","none");
						$("#payBaoDiv").css("display","none");
						$("#domesticDiv").css("display","none");
						$("#unionDiv").css("display","none");
						$(".payClick").remove();
						$(".modeUl li").css("border-color","#D2D2D2");
						$(this).css("border-color","#f2761c");
						$(this).append('<div class="payClick"><img src="/images/pay/payClick.png"/></div>');
						flag1=false;
					}else{
						$("#payUlLi").css("display","none");
						flag1=true;
					}					
					console.log(flag1);
				});
				
				$("#international").click(function(){
					flag1=true;		
					flag3=true;	
					flag4=true;	
					if(flag2){
						$("#internationalDiv").css("display","block");
						$("#internationalLi").css("display","block");
						$("#internationalLi").css("border","0px");
						$("#domesticLi").css("display","none");
						$("#unionLi").css("display","none");					
						$("#payUlLi").css("display","none");
						$("#payUlDiv").css("display","none");
						$("#wechatDiv").css("display","none");
						$("#payBaoDiv").css("display","none");
						$("#domesticDiv").css("display","none");
						$("#unionDiv").css("display","none");
						$(".payClick").remove();
						$(".modeUl li").css("border-color","#D2D2D2");
						$(this).css("border-color","#f2761c");
						$(this).append('<div class="payClick"><img src="/images/pay/payClick.png"/></div>');
						flag2=false;
					}else{
						$("#internationalLi").css("display","none");
						flag2=true;
					}
						console.log(flag2);
				});
				
				$("#wechat").click(function(){
					$("#wechatDiv").css("display","block");
					$("#payUlDiv").css("display","none");
					$("#internationalDiv").css("display","none");
					$("#payBaoDiv").css("display","none");
					$("#domesticDiv").css("display","none");
					$("#unionDiv").css("display","none");				
				});
				
				$("#payBao").click(function(){
					$("#payBaoDiv").css("display","block");
					$("#internationalDiv").css("display","none");
					$("#wechatDiv").css("display","none");
					$("#payUlDiv").css("display","none");
					$("#domesticDiv").css("display","none");
					$("#unionDiv").css("display","none");
				});
				$("#domestic").click(function(){
					flag1=true;		
					flag2=true;	
					flag4=true;	
					if(flag3){
						$("#domesticDiv").css("display","block");
						$("#domesticLi").css("display","block");
						$("#domesticLi").css("border","0px");
						$("#internationalLi").css("display","none");
						$("#unionLi").css("display","none");					
						$("#payUlLi").css("display","none");
						$("#payUlDiv").css("display","none");
						$("#internationalDiv").css("display","none");
						$("#wechatDiv").css("display","none");
						$("#payBaoDiv").css("display","none");
						$("#unionDiv").css("display","none");
						$(".payClick").remove();
						$(".modeUl li").css("border-color","#D2D2D2");
						$(this).css("border-color","#f2761c");
						$(this).append('<div class="payClick"><img src="/images/pay/payClick.png"/></div>');
						flag3=false;
				}else{
						$("#domesticLi").css("display","none");
						flag3=true;
					}				
						console.log(flag3);		
				});
				$("#union").click(function(){
					flag1=true;		
					flag2=true;	
					flag3=true;	
					if(flag4){
						$("#unionDiv").css("display","block");
						$("#unionLi").css("display","block");
						$("#unionLi").css("border","0px");
						$("#internationalLi").css("display","none");
						$("#domesticLi").css("display","none");					
						$("#payUlLi").css("display","none");
						$("#payUlDiv").css("display","none");
						$("#internationalDiv").css("display","none");
						$("#wechatDiv").css("display","none");
						$("#payBaoDiv").css("display","none");
						$("#domesticDiv").css("display","none");
						$(".payClick").remove();
						$(".modeUl li").css("border-color","#D2D2D2");
						$(this).css("border-color","#f2761c");
						$(this).append('<div class="payClick"><img src="/images/pay/payClick.png"/></div>');
						flag4=false;
					}else{
						$("#unionLi").css("display","none");
						flag4=true;
					}
						console.log(flag4);
						
				});				
			});
		</script>


	<?php }else{
		$OId=$_GET['OId'];
		$order_row=$db->get_one('orders', "OId='$OId'");
		!$order_row && js_location("$member_url?module=orders&act=list");
		$products_row=$db->get_one('product', "ProId='{$order_row['ProId']}'");
	?>
		<div class="lib_member_title"><a href="<?=$member_url;?>?module=orders&act=list"><?=$website_language['member'.$lang]['order']['detail']; ?></a></div>
		<div class="order_index"><?=$website_language['member'.$lang]['order']['number']; ?>#<?=$OId;?>&nbsp;&nbsp;<em></em></div>
		<div class="blank12"></div>
		<div class="detail">
			<div><?=$website_language['member'.$lang]['order']['detail']; ?></div>
		</div>
		<div class="detail_card">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_info">
			  <tr>
				<td width="110"><?=$website_language['member'.$lang]['order']['number']; ?>:</td>
				<td><?=$order_row['OId'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member'.$lang]['order']['order_time']; ?>:</td>
				<td><?=date('d/m-Y H:i:s', $order_row['OrderTime']);?></td>
			  </tr>
			  <?php if($order_row['TrackingNumber']){ ?>
				  	<tr>
						<td><?=$website_language['member'.$lang]['order']['track']; ?>:</td>
						<td><?=$order_row['TrackingNumber'];?></td>
				  	</tr>
			  <?php } ?>
			  <tr>
				<td><?=$website_language['member'.$lang]['order']['order_payment']; ?>:</td>
				<td><?=$order_row['PaymentMethod'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member'.$lang]['order']['order_shipping']; ?>:</td>
				<td><?=$order_row['Express'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member'.$lang]['order']['address']; ?>:</td>
				<td><?=$order_row['ShippingAddressLine1'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member'.$lang]['order']['order_code']; ?>:</td>
				<td><?=$order_row['ShippingPostalCode'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member'.$lang]['order']['order_phone']; ?>:</td>
				<td><?=$order_row['ShippingPhone'];?></td>
			  </tr>
			  <tr>
				<td><?=$website_language['member'.$lang]['other']['pay_number']; ?>:</td>
				<td><?=$mCfg['Pay_Number'];?></td>
			  </tr>
			</table>

			<div class="blank20"></div>
			<div class="item_info"><?=$website_language['member'.$lang]['order']['message']; ?>:</div>
			<div class="flh_180"><?=format_text($order_row['Comments']);?></div>
			<div class="blank20"></div>
			<div class="item_info"><?=$website_language['member'.$lang]['order']['o_products']; ?>:</div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="detail_item_list">
				<tr class="tb_title">
					<td width="14%"><?=$website_language['member'.$lang]['order']['img']; ?></td>
					<td width="50%"><?=$website_language['member'.$lang]['order']['pro']; ?></td>
					<td width="12%"><?=$website_language['member'.$lang]['order']['price']; ?></td>
					<td width="12%"><?=$website_language['member'.$lang]['order']['qty']; ?></td>
					<td width="12%" class="last"><?=$website_language['member'.$lang]['order']['total']; ?></td>
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

		</div>
		<div style="text-align:right;height:30px;line-height:30px;margin-top:2%;margin-right:1%">
			<a href="/account.php?module=orders&act=payment&OrderId=<?=$order_row['OrderId']?>&OId=<?=$order_row['OId']?>"><input type="button" style="height:30px;min-width:80px;line-height:30px;margin-right:0%;background:#ec6400;border:0px;border-radius:4px;color:#fff;text-align:center;padding-left:10px;padding-right:10px;cursor:pointer" value="<?=$website_language['manage'.$lang]['go_on']?>"></a>
		</div>
		<div>
			<div style="font-size:14px;font-weight:bold;text-indent:0px">物流及清关</div>
			
		
		
			<div style="margin-top:7px">
				<div style="width:100%;height:30px;background:#ffd4d4;line-height:30px;padding-left:5px;padding-right:5px"><?=$website_language['member'.$lang]['order']['costAcquisition']; ?></div>
				<div style="width:100%;text-align:right;height:30px;line-height:30px;"><?=$website_language['member'.$lang]['order']['transport']; ?>：<label style="color:#B50C08" class="lab-cost"><?=iconv_price($order_row['ShippingCharges']); ?>&nbsp;&nbsp;</label></div>
			</div>
			<div>
				<div style="width:100%;background:#ffd4d4;line-height:16px;padding-top:8px;padding-bottom:8px;padding-left:5px;padding-right:5px"><?=$website_language['member'.$lang]['order']['serviceCharge']; ?></div>
				<div style="width:100%;text-align:right;height:30px;line-height:30px;"><?=$website_language['member'.$lang]['order']['clearance']; ?>：<label style="color:#B50C08" class="lab-cost">
										<?php if($AgentMode == $website_language['goods'.$lang]['voluntarily']){?>
											- - - -
										<?php }else{?>
											<?=iconv_price($order_row['CustomsClearance']);?>
										<?php }?>
										</label>&nbsp;</div>
			</div>
			<div>
				<div style="width:100%;background:#ffd4d4;line-height:16px;padding-top:8px;padding-bottom:8px;text-align:right;font-weight:bold"><?=$website_language['member'.$lang]['order']['sum']; ?>：<label style="color:#B50C08" class="lab-cost"> 
					<?php if($AgentMode == $website_language['goods'.$lang]['voluntarily']){?>
						<?=iconv_price($order_row['ShippingCharges']); ?>
					<?php }else{?>
						<?=iconv_price($order_row['CustomsClearance']+$order_row['ShippingCharges']); ?>
					<?php }?>
					</label>&nbsp;
				</div>
			</div>
			<div style="text-align:right;height:30px;line-height:30px;margin-top:2%;margin-right:1%">
				<a href="/account.php?module=orders&act=payment&OrderId=<?=$order_row['OrderId']?>&OId=<?=$order_row['OId']?>"><input type="button" style="height:30px;min-width:80px;line-height:30px;margin-right:0%;background:#ec6400;border:0px;border-radius:4px;color:#fff;text-align:center;padding-left:10px;padding-right:10px;cursor:pointer" value="<?=$website_language['manage'.$lang]['go_on']?>"></a>
			</div>
		</div>
	<?php }?>	
</div>
 <div style="width:100%;height:45px;border:1px solid #e6e6e6">
                <div style="margin-left:0;width:30%;text-align:center;line-height:45px;font-size:18px;color:#333333"><?=$Title; ?></div>                
            </div>
            
            <div class="titleState" style="margin-top:25px">                
                <span style="display: block;width:100%" class="titleInfo"><?=$website_language['member'.$lang]['order']['waybillNumber']; ?>:<span style="display:inline-block;color:#ec6400;width:50%;"><strong>&nbsp;<?=$transport_row['TOId']?></strong></span></span>
                <br>
                <span style="display: block;width:100%" class="titleCompany"><?=$website_language['member'.$lang]['order']['company']; ?>:<span style="display:inline-block;color:#ec6400;width:50%;"><strong>&nbsp;<?=$transport_row['Company']?></strong></span></span>
                <br>
                <span style="display: block;width:100%" class="titlePhone"><?=$website_language['member'.$lang]['order']['telephone']; ?>:<span style="display:inline-block;color:#ec6400;width:50%;"><strong>&nbsp;0755-33119835</strong></span></span>
               
            </div>
            <hr style="width:100%;margin-left:20px">
             <div style="width:100%;position:relative">
                <span style="position:absolute;top:0;left:0;display:inline-block;width:20%;color:#333;margin-left:5%;"><?=$website_language['member'.$lang]['order']['time']; ?></span>    
                <span style="position:absolute;top:0;left:20%;display:inline-block;width:20%;"></span>
                <span style="position:absolute;top:0;right:0;display:inline-block;width:50%;color:#333;margin-left:0%;word-break:break-all"><?=$website_language['member'.$lang]['order']['progress']; ?></span>
            </div>


            <div id="cc">
	            <?php 
            		$OId =$_GET['OId'];
                	$order_row_2=$db->get_one('orders', "OId='$OId'");
					$OrderId = $order_row_2['OrderId'];
					$stutas = $db->get_all('freight_stutas',"OrderId='$OrderId'");
					
					$stutas_count = count($stutas);
					$stutas_ros = $stutas[$stutas_count-1];
                    for($i=0;$i< $stutas_count;$i++){
	            ?>     
	            <br><br><br>
	            
	            <div style="width:100%;position:relative;">
	                <span style="position:absolute;top:0;left:0;display:inline-block;width:30%;color:#333;margin-left:5%;"><?=date('Y-m-d H:i:s',$stutas[$i]['StutasTime']);?></span>    
	                <span style="position:absolute;top:0;left:36%;display:inline-block;width:20%;background:url(../../images/atricle/gfd01.png) no-repeat;height: 16px;">&nbsp;</span>
	                <span style="position:absolute;top:0;right:0;display:inline-block;width:50%;color:#333;margin-left:0%;word-break:break-all"><?=$stutas[$i]['ProductStutas'];?></span>
	            </div>
            <?php }?>
            </div>





            
            <div style="margin-top:15%;color:#333" class="tips-state">

            <?=$website_language['member'.$lang]['order']['Cre_1']?></div>
<div style="height:50px"></div>
<script>
    
    
    // $("table tr:not(:first):not(:last)").sublings("tr td:eq(1)").each(function(){
    //     $(this).css('background',"url(/images/atricle/gfd03.png) no-repeat")
    // })
     $(".table-state tr:eq(0)").siblings("tr").each(function(){        
           $(this).children("td:eq(1)").each(function(){
               $(this).css("background","url(../../images/atricle/gfd03.png) no-repeat");
           })
        })
         $(".table-state tr:last").each(function(){
                 $(this).children("td").css("color","#ec6400");
         })
       
        $(".table-state tr:last td:eq(1)").each(function(){

            $(this).css("background","url(../../images/atricle/gfd04.png) no-repeat")
        })
</script>
<script>
    $("#cc div:first").each(function(){
        $(this).children("span :eq(1)").css("background","url(/images/atricle/gfd01.png) no-repeat")
    })
    $("#cc div:first").siblings("div").each(function(){
        $(this).children("span :eq(1)").css("background","url(/images/atricle/gfd03.png) no-repeat");
    })
    $("#cc div:last").each(function(){
        $(this).children("span :eq(1)").css("background","url(/images/atricle/gfd05.png) no-repeat")
     })
</script>
