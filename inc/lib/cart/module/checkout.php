<?php
$ProId = $_GET['ProId'];
/*if($_POST['data'] == 'cart_list'){
	$mysubmit = '0';
	$ProId = $_POST['ProId'];
	$where .= " and Mysubmit='$mysubmit' and ProId='$ProId'";
}*/
if($_GET['data'] == "cart_list"){
	$mysubmit = $_GET['mysubmit'];
	$where .= " and Mysubmit='$mysubmit' and ProId='$ProId'";
}
//var_dump($where);exit;
$query_string=query_string('act');
$shipping_row=$db->get_all('shipping_freight','SFID=1');
$shipping_row_2=$db->get_all('shipping_freight','SFID=2');
$cart_row=$db->get_all('shopping_cart', $where, '*', 'ProId desc, CId desc');
!$cart_row && js_location("$cart_url?module=list");

$total_price=$db->get_sum('shopping_cart', $where, 'Qty*Price');	//商品总价格
$order_product_weight==1 && $total_weight=$db->get_sum('shopping_cart', $where, 'Qty*Weight');	//商品总重量

$MemberId=(int)$_SESSION['member_MemberId'];
$member_row=$db->get_one('member',"MemberId='{$MemberId}'");
$order_discount=0; //订单折扣归0
/*$member_discount=$db->get_all('member_level',1,'LId, Discount','LId asc');
if($MemberId){
	for($i=0,$len=count($member_discount); $i<$len; $i++){
		if((int)$_SESSION['member_Level']==$member_discount[$i]['LId']){
			$order_discount=$member_discount[$i]['Discount'];
		}
	}
}*/
$memb_supplierid = $_SESSION['member_MemberId'];
if($_POST['data']=='cart_checkout'){

	$shipping_address['Title']=stripslashes($_POST['ShippingTitle']);
	$shipping_address['Email']=stripslashes($_POST['Email']);
	$shipping_address['FirstName']=stripslashes($_POST['FirstName']);

	$shipping_address['AddressLine1']=stripslashes($_POST['ShippingAddressLine1']);
	$shipping_address['AddressLine2']=stripslashes($_POST['ShippingAddressLine2']);
	$shipping_address['City']=stripslashes($_POST['ShippingCity']);
	$shipping_address['State']=stripslashes($_POST['ShippingState']);
	$shipping_address['Country']=stripslashes($_POST['ShippingCountry']);
	$shipping_address['PostalCode']=stripslashes($_POST['ShippingPostalCode']);
	$shipping_address['Phone']=stripslashes($_POST['Supplier_Mobile']);
	$billing_address['Title']=stripslashes($_POST['BillingTitle']);
	$billing_address['FirstName']=stripslashes($_POST['BillingFirstName']);
	$billing_address['LastName']=stripslashes($_POST['BillingLastName']);
	$billing_address['AddressLine1']=stripslashes($_POST['BillingAddressLine1']);
	$billing_address['AddressLine2']=stripslashes($_POST['BillingAddressLine2']);
	$billing_address['City']=stripslashes($_POST['BillingCity']);
	$billing_address['State']=stripslashes($_POST['BillingState']);
	$billing_address['Country']=stripslashes($_POST['BillingCountry']);
	$billing_address['PostalCode']=stripslashes($_POST['BillingPostalCode']);
	$billing_address['Phone']=stripslashes($_POST['BillingPhone']);
	$SupplierId = $memb_supplierid;
	if(!$shipping_address['AddressLine1'] || !$shipping_address['FirstName'] || !$shipping_address['Phone'] || !$shipping_address['Email'] || !$shipping_address['PostalCode']){
		echo '<script>alert("收货信息不完整");history.go(-1);</script>';
		exit;
	}
	$SId=(int)$_POST['SId'];	//送货方式
	$Comments=$_POST['Comments'];	//订单留言

	$agent_mode = $_POST['agent_radio'];	//清关方式
	if($SId == '1'){						//快递公司	
		$express_company = $_POST['transport_radio'];
	}else{
		$express_company = $_POST['airlift_radio'];
	}
	(!$shipping_address || !$billing_address) && js_location("$cart_url?module=checkout");	//提交数据不完整.....
	
	$Coupon=$_POST['Coupon'];
	$CouponMoney=0;
	$coupon_row=$db->get_one('coupon',"CNumber='$Coupon' and Deadline>=$service_time and CanUsedTimes>0");
	if($coupon_row && $total_price>=$coupon_row['UseCondition']){
		if($coupon_row['CType']==1 && $coupon_row['Discount']>0){
			$order_discount=($order_discount==0?1:$order_discount)*$coupon_row['Discount'];
		}else $CouponMoney=$coupon_row['Money'];
		$db->query("update coupon set CanUsedTimes=CanUsedTimes-1, UseTime=$service_time where CNumber='$Coupon'");
	}
	$_SESSION['coupon_cost']=$_SESSION['order_discounts']='';
	unset($_SESSION['coupon_cost'],$_SESSION['order_discounts']);
	
	//---------------------------------------------------------------------------------------生成订单号------------------------------------------------------------------------
	/*while(1){
		$OId=MX.date('YmdHis', $service_time).rand(10, 99);
		if(!$db->get_row_count('orders', "OId='$OId'")){
			break;
		}
	}*/
	//---------------------------------------------------------------------------------------生成订单号------------------------------------------------------------------------

	/*$payment_method_row=$db->get_one('payment_method', 'PId='.(int)$_POST['PId'], '*', 'MyOrder desc, PId asc');*/
	$OId = array();
	$product_id = array();
	$product_num = array();
	$OrderId = array();
	$countorders = count($cart_row);
	for($i=0; $i<$countorders; $i++){
		$product_id[$i]= $cart_row[$i]['ProId'];
		$product_num[$i] = $db->get_one('product',"ProId='$product_id[$i]'",'ProductCodeId');
		foreach ($product_num as $key => $value) {
			foreach ($value as $key_1 => $value_1) {
				$OId[$i]=MX.date('mdHis', $service_time).$value_1.$countorders;
			}
			
		}
		
	//var_dump($value);exit;
	}
	
	//var_dump($product_num);exit;
	for($i=0; $i<count($cart_row); $i++){
	//var_dump($OId[$i]);exit;
	$price_qty = $cart_row[$i]['Price']*$cart_row[$i]['Qty'];
	$db->insert('orders', array(
			'OId'					=>	$OId[$i],
			'MemberId'				=>	$_SESSION['member_MemberId'],
			'SessionId'				=>	$cart_SessionId,
			'Discount'				=>	$order_discount,
			'Email'					=>	$member_row['Email'],
			'TotalPrice'			=>	(float)$price_qty,
			//'PayAdditionalFee'		=>	(float)$payment_method_row['AdditionalFee'],
			'ShippingTitle'			=>	addslashes($shipping_address['Title']),
			'ShippingFirstName'		=>	addslashes($shipping_address['FirstName']),
			'ShippingLastName'		=>	addslashes($shipping_address['LastName']),
			'ShippingAddressLine1'	=>	addslashes($shipping_address['AddressLine1']),
			'ShippingAddressLine2'	=>	addslashes($shipping_address['AddressLine2']),
			'ShippingCity'			=>	addslashes($shipping_address['City']),
			'ShippingState'			=>	addslashes($shipping_address['State']),
			'ShippingCountry'		=>	addslashes($shipping_address['Country']),
			'ShippingPostalCode'	=>	addslashes($shipping_address['PostalCode']),
			'ShippingPhone'			=>	addslashes($shipping_address['Supplier_Mobile']),
			/*'BillingTitle'			=>	addslashes($billing_address['Title']),
			'BillingFirstName'		=>	addslashes($billing_address['FirstName']),
			'BillingLastName'		=>	addslashes($billing_address['LastName']),
			'BillingAddressLine1'	=>	addslashes($billing_address['AddressLine1']),
			'BillingAddressLine2'	=>	addslashes($billing_address['AddressLine2']),
			'BillingCity'			=>	addslashes($billing_address['City']),
			'BillingState'			=>	addslashes($billing_address['State']),
			'BillingCountry'		=>	addslashes($billing_address['Country']),
			'BillingPostalCode'		=>	addslashes($billing_address['PostalCode']),
			'BillingPhone'			=>	addslashes($billing_address['Phone']),*/
			'Express'				=>	addslashes($db->get_value('shipping', "SId='$SId'", 'Express')),
			'TotalWeight'			=>	(float)$total_weight,
			'Comments'				=>	$Comments,
			//'PaymentMethod'			=>	addslashes($payment_method_row['Name_lang_1']),
			'OrderTime'				=>	$service_time,
			'OrderStatus'			=>	(int)$order_default_status,
			'Coupon'				=>	$CouponMoney,
			'AgentMode'				=>	$agent_mode,
			'ExpressCompany'		=>	$express_company,
			'PaymentStatus'			=>	'1',
			'SupplierId'			=>  $cart_row[$i]['SupplierId'],
			//'PicPath'				=>	addslashes($img_path),
			'Qty'					=>	(int)$cart_row[$i]['Qty'],
			'Name'					=>	addslashes($cart_row[$i]['Name']),
			'Conter'				=>	$_POST['Conter'],
			'CId'					=>	$cart_row[$i]['CId'],
			'COId'					=>	$cart_row[$i]['Color'],
			'Del'					=>	1,
			
		)
	);
	
	//保存另外的语言版本的数据
	if(count(get_cfg('ly200.lang_array'))>1){
		add_lang_field('orders', array('ExpressCompany_lang_1', ));
		
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$ExpressExt=$_POST['Express'.$field_ext];
			$ExplanationExt=$_POST['Explanation'.$field_ext];
			$db->update('shipping', "SId='$SId'", array(
					'ExpressCompany'.$field_ext		=>	$express_company,
					
				)
			);
		}
	}
	
	$img_dir=mk_dir('/images/orders/'.date('Y_m/', $service_time).$OId[$i].'/');
	$OrderId[$i]=$db->get_insert_id();
	
	update_orders_shipping_info($OrderId[$i], '', 1);
	

	
		$img_path=$img_dir.basename($cart_row[$i]['PicPath']);
		@copy($site_root_path.$cart_row[$i]['PicPath'], $site_root_path.$img_path);
		
		$db->insert('orders_product_list', array(
				'OrderId'	=>	$OrderId[$i],
				'ProId'		=>	(int)$cart_row[$i]['ProId'],
				'CateId'	=>	(int)$cart_row[$i]['CateId'],
				'SupplierId'=>	(int)$cart_row[$i]['SupplierId'],
				'Color'		=>	addslashes($cart_row[$i]['Color']),
				'Size'		=>	addslashes($cart_row[$i]['Size']),
				'Name'		=>	addslashes($cart_row[$i]['Name']),
				'Name_lang_1'=>	addslashes($cart_row[$i]['Name_lang_1']),
				'ItemNumber'=>	addslashes($cart_row[$i]['ItemNumber']),
				'Weight'	=>	(float)$cart_row[$i]['Weight'],
				'PicPath'	=>	addslashes($img_path),
				'Price'		=>	(float)$cart_row[$i]['Price'],
				'Qty'		=>	(int)$cart_row[$i]['Qty'],
				'Url'		=>	addslashes($cart_row[$i]['Url']),
				'Remark'	=>	addslashes($cart_row[$i]['Remark']),
				'Property'	=>	$cart_row[$i]['Property']
				
			)
		);
		$cart_color_row = $db->get_all("cart_color","CId=".$cart_row[$i]['CId']);
		for ($k=0; $k < count($cart_color_row); $k++) { 
			$colorid = $cart_color_row[$k]['COId'];
			$colorqty = $cart_color_row[$k]['CQty'];
			$db->insert("orders_color",array(
				'OrderId'	=>	$OrderId[$i],
				'CId'		=>	$colorid,
				'Qty'		=>	$colorqty,
				));

		}
	}

	$db->delete('shopping_cart', "MemberId='{$_SESSION['member_MemberId']}' and ProId = '$ProId' and Mysubmit='$mysubmit'" );	
	$db->delete('cart_color', "ProId = '$ProId' and MemberId='{$_SESSION['member_MemberId']}' and Mysubmit='$mysubmit'");
	//删除购物车的物品
	include($site_root_path.'/inc/lib/mail/order_create.php');
	include($site_root_path.'/inc/lib/mail/template.php');
	//smtp_mail((int)$_SESSION['member_MemberId']?$_SESSION['member_Email']:$_POST['Email'],"Thanks for your order#{$OId[$i]}",$mail_contents,"", "", "");

	sendmail((int)$_SESSION['member_MemberId']?$_SESSION['Email']:$_POST['Email'], $shipping_address['FirstName'].' '.$shipping_address['LastName'], "Thanks for your order#{$OId[$i]}", $mail_contents);

	include($site_root_path.'/inc/lib/mail/template.php');
	include($site_root_path.'/inc/lib/mail/order_service.php');
	/*$order_row[$i]=$db->get_one('orders', "OId='$OId[$i]'");
	var_dump($order_row[$i]);exit;*/
	
	
	$Email_1 = "coconut@eaglesell.com";
	//smtp_mail($Email_1, "Thanks for your order#{$OId['$i']}",$mail_contents,"", "", "");  
	sendmail($Email_1, '鹰洋客服', "Thanks for your order#{$OId}", $mail_contents);


 	$orders_tips = '订单提交成功! 我们24小时内会联系你.';
	$string = implode(",",$OId);
	$string_orid = implode(",",$OrderId);
	// /var_dump($string);exit;
	js_location("/user.php?module=order_list&OId=$string&act=payment&OrderId=$string_orid",$orders_tips);
}

if($_POST['act']=='Coupon'){
	$CNumber=$_POST['CNumber'];
	$coupon_row=$db->get_one('coupon',"CNumber='$CNumber' and Deadline>=$service_time and CanUsedTimes>0");
	$result=0;
	if($coupon_row){
		if($coupon_row['Deadline']>$service_time){
			if($total_price>=$coupon_row['UseCondition']){
				$_SESSION['coupon_cost']=$coupon_row;
				$_SESSION['coupon_tips']='Coupon is used successfully.';
			}else{
				$_SESSION['coupon_tips']='Coupon use failure.Shopping less than '.iconv_price($coupon_row['UseCondition']).' yuan can not use this coupon';
			}
		}else{
			$_SESSION['coupon_tips']='This coupon has expired.Expiration Date:'.date('d/m/Y',$coupon_row['Deadline']);
		}
	}else $_SESSION['coupon_tips']='This coupon has expired. Does not have a use coupons';
}

if(is_array($_SESSION['coupon_cost'])){
	if($_SESSION['coupon_cost']['CType']==1 && $_SESSION['coupon_cost']['Discount']>0){
		$order_discount=($order_discount==0?1:$order_discount)*(float)$_SESSION['coupon_cost']['Discount'];
	}else $coupon_money=(float)$_SESSION['coupon_cost']['Money'];	
}

$subtotal=$total_price*(1-$order_discount/100)-$coupon_money;
$save=$total_price-$subtotal;
$address_row = $db->get_all("address","SMemberId='$MemberId'",'*',"Model desc,AId desc");
?>
<?php
	echo '<link rel="stylesheet" href="/css/cart'.$lang.'.css">'
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
<form action="<?=$cart_url.'?'.$query_string;?>" method="post">
<div class="mask">

	<div class="bbg">
		<div class="bg_title1" style=""><?=$website_language['user_checkout'.$lang]['shrxx']?></div>
		<div class="he_mask"><span class='span_title' style=""><?=$website_language['user_checkout'.$lang]['shdz']?></span>：<!-- <input class="hhe" type="text" name="ShippingAddressLine1" value="<?=$member_row['Supplier_Address_lang_1']?>"> -->
		<select class="hhe shouhuodizhi" name="ShippingAddressLine1">
		<?php 
			for ($i=0; $i < count($address_row); $i++) { 
		?>
			<option value="<?=$address_row[$i]['AId']?>"><?=$address_row[$i]['SAddress']?></option>
		<?php }?>
		</select><a href="/user.php?module=address&act=1&ProId=<?=$ProId?>&mode_tz=return&mysubmit=1&data=cart_list"><input class="input_he" type="button" value="<?=$website_language['user_checkout'.$lang]['gl']?>"></a></div>
		<div class="he_mask"><span class='span_title' style="" >收货人姓名</span>：<input class="hhe" id="SName" type="text" name="FirstName" value="<?=$address_row[0]['SName']?>"></div>
		<?php //var_dump($member_row);exit; ?>
		<div class="he_mask"><span class='span_title' style=""><?=$website_language['user_checkout'.$lang]['shryx']?></span>：<input class="hhe" type="text" name="Email" id="SEmail" value="<?=$address_row[0]['SEmail']?>"></div>
		<div class="he_mask"><span class='span_title' style=""><?=$website_language['user_checkout'.$lang]['lxsj']?></span>：<input class="hhe" type="text" name="Supplier_Mobile" id="SMobile" value="<?=$address_row[0]['SMobile']?>"></div>
		<div class="he_mask"><span class='span_title' style=""><?=$website_language['user_checkout'.$lang]['yzbm']?></span>：<input class="hhe" type="text" name="ShippingPostalCode" id="SArea" value="<?=$address_row[0]['SArea']?>"></div>
	
		<div class="he_mask">
            <span class="span_title1"><?=$website_language['user_checkout'.$lang]['gmjly']?></span><span class='fuhao'>：</span><textarea class="tx" type="text" name="Conter"></textarea>
        </div>
	</div>
</div>
<div class="mask">
	<div class="Prompt">* <?=$website_language['user_checkout'.$lang]['gzr']?></div>
</div>
<div class="mask">
	<div class="bbg1">

		<div class="bg_title1"><?=$website_language['user_checkout'.$lang]['cpdd']?></div>
		<div class="title_a">
			<div class="a_150"><?=$website_language['user_checkout'.$lang]['cptp']?></div>
			<div class="a_250"><?=$website_language['user_orders'.$lang]['cpxx']?></div>
			<div class="a_150"><?=$website_language['user_checkout'.$lang]['dj']?></div>
			<div class="a_150"><?=$website_language['user_checkout'.$lang]['sl']?></div>
			<div class="a_150"><?=$website_language['user_checkout'.$lang]['zj']?></div>
		</div>
		<?php

			$pro_count=0;
			for($i=0; $i<count($cart_row); $i++){
				$pro_count+=$cart_row[$i]['Qty'];
				$color_row = $cart_row[$i]["Color"];
				$colorid_row = $db->get_all("product_color","CId in($color_row)","Color".$lang);
				for ($j=0; $j < count($colorid_row); $j++) { 
					$colors_row[] = $colorid_row[$j]['Color'.$lang];
				}
				$color_name = implode(",",$colors_row);
				
		?>
			<div class="content_a">
				<div class="content_t">
					<div class="content_a_150"><a href="<?=$cart_row[$i]['Url'];?>"><img class="content_a_img" src="<?=$cart_row[$i]['PicPath'];?>" alt=""></a></div>
					<div class="content_a_250"><div class="p_name"><a title='<?=$cart_row[$i]['Name'.$lang.''];?>' href="<?=$cart_row[$i]['Url'];?>"><?=$cart_row[$i]['Name'.$lang.''];?></a><i class='slh'></i></div><div title='<?=$color_name?>' class="p_name2"><i class='slh'></i><font><?=$color_name?></font></div></div>
					<div class="content_b_150"><div class="b_a">USD $<?=$cart_row[$i]['Price'];?></div></div>
					<div class="content_b_150"><div class="b_b"><?=$cart_row[$i]['Qty'];?></div></div>
					<div class="content_b_150"><div class="b_c">USD <?=iconv_price($cart_row[$i]['Price']*$cart_row[$i]['Qty']);?></div></div>
				</div>			
			</div>	
		<?php }?>
		<div class="ca_a">
			<div class="ca_b">
				<span class="ca_b1"><?=$website_language['user_checkout'.$lang]['sjfk']?></span>：<span class="ca_b2">USD $<?=iconv_price($subtotal+$default_shipping_price, 2);?></span>
				<div><input class="ca_b3" value="<?=$website_language['user_checkout'.$lang]['tjdd']?>" type="submit"></div>
				<div class="ca_b4">*<?=$website_language['user_checkout'.$lang]['bcjs']?></div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="CId" class="CId" id="shiping_method_CId" value="<?=$_SESSION['order_CId'];?>" />
		<input type="hidden" name="AId" value="<?=$shipping_address['AId'];?>" />
		<input type="hidden" name="data" value="cart_checkout" />
        <input type="hidden" name="coupon_money" value="<?=(float)$coupon_money;?>" id="coupon_money" />
		<input type="hidden" name="Coupon" value="<?=$_SESSION['coupon_cost']['CNumber']?>"/>
</form>
<script>
	$(function(){
		$('.p_name').each(function(){
			var ah=$(this).find('a').css('height');
			if(ah>'80px'){
				$(this).find('.slh').css('display','block');
			}else{
				$(this).find('.slh').css('display','none');
			}
		})
		$('.p_name2').each(function(){
			var ah=$(this).find('font').css('height');		
			if(ah>'80px'){
				$(this).find('.slh').css('display','block');
			}else{
				$(this).find('.slh').css('display','none');
			}
		})
		$('.shouhuodizhi').change(function(){
			var val=$(this).val();
				$.ajax({
					type:"GET",
					url:"/ajax/ajax_checkout.php",
					data:{
						act:"goods",
						val:val,
						},
					// dataType:"json", 
					success:function(data){	
						var data = eval('(' +data+ ')');
						if(data.status == '1'){
							$("#SName").val(data.SName);
							$("#SEmail").val(data.SEmail);
							$("#SMobile").val(data.SMobile);
							$("#SArea").val(data.SArea);
						}							
					},
					error:function(){
					}
				})
			})
		})
</script>