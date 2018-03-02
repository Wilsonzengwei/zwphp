<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='orders';
check_permit('orders');

include('../../inc/fun/ip_to_area.php');
$OrderId=(int)$_GET['OrderId'];
!$OrderId && $OrderId=(int)$_POST['OrderId'];
$tmpOrderStatus=(int)$_GET['tmpOrderStatus'];
$module=$_GET['module']?$_GET['module']:$_POST['module'];
$where="OrderId='$OrderId'";
$order_row=$db->get_one('orders', $where);
$order_product_row = $db->get_one('orders_product_list',$where);
$proid_r = $order_product_row['ProId'];
$StartFromorder = $db->get_one('product',"ProId='$proid_r'",'StartFrom');
if($order_product_row['Name_lang_1']){
	$order_product_name = $order_product_row['Name_lang_1'];
}else{
	$order_product_name = $order_product_row['Name'];
}
$MIdd = $db->get_one('product',"ProId='$proid_r'",'SupplierId');
$MId = $MIdd['SupplierId'];
$moblie = $db->get_one('member',"MemberId='$MId'","Supplier_Mobile");
$factory_order_oid = $order_row['OId'];
//订单是否付款
if($_POST['payment_status']){
	$payment_status = $_POST['payment_status'];
	$OrderId = $_POST['OrderId'];
	$PaymentTime = time();
	//var_dump($payment_status);exit;
	//$order_status = "2";
	$db->update('orders',"OrderId='$OrderId'",array(
			'OrderStatus'   => $payment_status,
			'PaymentStatus' => $payment_status,
			'PaymentTime'	=> $PaymentTime
			
			
		));
	
	if($_POST['payment_status'] == "2"){
		//$order_status = "2";
		$merchant_orders = $db->get_one('orders',"OrderId='$OrderId'");
		$merchant_supplier = $merchant_orders['SupplierId'];
		$merchant_member = $db->get_one('member',"MemberId='$merchant_supplier'");
		$merchant_member_email = $merchant_member['Email'];
		$OId = $merchant_orders['OId'];
		$merchant_member_name = $merchant_member['Supplier_Name2'];
		$db->update('orders',"OrderId='$OrderId'",array(
			'SMApply' => '1',
		));
		//$Email_1 = "coconut@eaglesell.com";	
		include($site_root_path.'/inc/lib/mail/template.php');
		include($site_root_path.'/inc/lib/mail/order_member_email.php');
		sendmail($merchant_member_email, $merchant_member_name, "您有一条新订单#{$OId}", $mail_contents);

	}
	
}
//获取物流追踪信息
if($_POST['product_status_time']){
	$product_status_time = $_POST['product_status_time'];
	$product_tutas = $_POST['product_tutas'];
	$tracking_number = $_POST['tracking_number_1'];

	$db->insert('freight_stutas',array(
			'OrderId'         => $OrderId,
			'StutasTime'      => $product_status_time,
			'ProductStutas'   => $product_tutas,
			'TrackingNumber'  => $tracking_number
		)
	);
}
//修改物流追踪信息
if($_POST['shipping_val'] == "shipping_status"){
	$shipping_time = $_POST['StutasTime'];
	$shipping = $_POST['shipping_status'];
	$db->update('freight_stutas',"OrderId='$OrderId' and StutasTime='$shipping_time'",array(
			'ProductStutas' => $shipping
		));
	
	echo "<script>alert('修改成功！')</script>";
}
//确认账单
if($_POST['SMApply_submit1'] == 'SMApply_submit1'){
	if($_POST['Payment_1']){
		$Payment = $_POST['Payment_1'];
		$SMApply = "SMApply_1";
		$Advance_name = "Advance_1";
		$Advance = $_POST["Advance_1"];
		$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
			$SMApply => $Payment,
			$Advance_name => $Advance
		));
	}

	if($_POST['SMApply_submit_1']){
		if($_POST['SMApply_submit_1'] == "2"){
			$factory_SMApply_name = "SMApply_submit_1";
			$factory_SMApply_value = $_POST['SMApply_submit_1'];
			$order_status = "3";
			$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
				$factory_SMApply_name => $factory_SMApply_value
			
			));
			$db->update('orders',"OId='$factory_order_oid'",array(
				'OrderStatus' => $order_status,
			));
		}elseif($_POST['SMApply_submit_1'] == "1"){
			$factory_SMApply_name = "SMApply_submit_1";
			$factory_SMApply_value = $_POST['SMApply_submit_1'];
			$factory_SMApply_name = "SMApply_submit_1";
			$factory_SMApply_value = $_POST['SMApply_submit_1'];
			$invalidcause = $_POST["invalidcause_1"];
			$invalidcause_val = "Invalidcause_1";

			$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
				$factory_SMApply_name => $factory_SMApply_value,
				$invalidcause_val     =>  $invalidcause
			));
		}




	}
}

if($_POST['SMApply_submit2'] == 'SMApply_submit2'){
	if($_POST['Payment_2']){
		$Payment = $_POST['Payment_2'];
		$SMApply = "SMApply_2";
		$Advance_name = "Advance_2";
		$Advance = $_POST["Advance_2"];
		$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
			$SMApply => $Payment,
			$Advance_name => $Advance
		));
	}

	if($_POST['SMApply_submit_2']){
		if($_POST['SMApply_submit_2'] == "2"){
			$factory_SMApply_name = "SMApply_submit_2";
			$factory_SMApply_value = $_POST['SMApply_submit_2'];
			$order_status = "6";
			$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
				$factory_SMApply_name => $factory_SMApply_value
			
			));
			$db->update('orders',"OId='$factory_order_oid'",array(
				'OrderStatus' => $order_status,
			));
		}elseif($_POST['SMApply_submit_2'] == "1"){
			$factory_SMApply_name = "SMApply_submit_2";
			$factory_SMApply_value = $_POST['SMApply_submit_2'];
			$factory_SMApply_name = "SMApply_submit_2";
			$factory_SMApply_value = $_POST['SMApply_submit_2'];
			$invalidcause = $_POST["invalidcause_2"];
			$invalidcause_val = "Invalidcause_2";

			$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
				$factory_SMApply_name => $factory_SMApply_value,
				$invalidcause_val     =>  $invalidcause
			));
		}




	}
}

if($_POST['SMApply_submit3'] == 'SMApply_submit3'){
	if($_POST['Payment_3']){
		$Payment = $_POST['Payment_3'];
		$SMApply = "SMApply_3";
		$Advance_name = "Advance_3";
		$Advance = $_POST["Advance_3"];
		$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
			$SMApply => $Payment,
			$Advance_name => $Advance
		));
	}

	if($_POST['SMApply_submit_3']){
		if($_POST['SMApply_submit_3'] == "2"){
			$factory_SMApply_name = "SMApply_submit_3";
			$factory_SMApply_value = $_POST['SMApply_submit_3'];
			$order_status = "8";
			$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
				$factory_SMApply_name => $factory_SMApply_value
			
			));
			$db->update('orders',"OId='$factory_order_oid'",array(
				'OrderStatus' => $order_status,
			));
		}elseif($_POST['SMApply_submit_3'] == "1"){
			$factory_SMApply_name = "SMApply_submit_3";
			$factory_SMApply_value = $_POST['SMApply_submit_3'];
			$factory_SMApply_name = "SMApply_submit_3";
			$factory_SMApply_value = $_POST['SMApply_submit_3'];
			$invalidcause = $_POST["invalidcause_3"];
			$invalidcause_val = "Invalidcause_3";

			$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
				$factory_SMApply_name => $factory_SMApply_value,
				$invalidcause_val     =>  $invalidcause
			));
		}




	}
}

if($_POST['LTX']){
	$LTX = $_POST['LTX'];
	$order_row=$db->get_one('orders', $where);
	$factory_order_oid = $order_row['OId'];
	$db->update('orders',"OId='$factory_order_oid'",array(
		'Stowage' => $LTX
		));
}
//运输及清关费用
if($_POST['shippingcharges_r'] == "shippingcharges_r"){
	$FollowUp = $_POST['FollowUp'];
	$shippingcharges = $_POST['shippingcharges'];
	$CustomsClearance = $_POST['CustomsClearance'];
	$order_row=$db->get_one('orders', $where);
	$factory_order_oid = $order_row['OId'];
	$Weight	=$_POST['Weight'];
	$Volume	=$_POST['Volume'];
	$QPrice=$_POST['QPrice'];
	$db->update('orders',"OId='$factory_order_oid'",array(
		'FollowUp' 		  => $_SESSION['ly200_AdminSalesmanName'],
		'ShippingCharges' => $shippingcharges,
		'CustomsClearance'=> $CustomsClearance,
		'Weight'		  =>	$Weight,
		'Volume'		  =>	$Volume,
		'QPrice'		  => $QPrice,
		));
	$YEmail = $db->get_one("orders","OrderId='$OrderId'","Email,MemberId");

	include($site_root_path.'/inc/lib/mail/template.php');
	include($site_root_path.'/inc/lib/mail/order_member_email.php');
	$mail_contents = '<a href="'.get_domain().'/supplier/clear.php?OrderId='.$OrderId.'258&MemberId='.$YEmail['Email'].'">'.$website_language['member'.$lang]['login']['tips10'].'</a>';
	sendmail($YEmail['Email'], $merchant_member_name, "您有一条新订单#{$OId}", $mail_contents);
		//var_dump($_POST);exit;
}
if($_POST['Trans_Clert']=='Trans_Clert'){
	$KPrice=$_POST['KPrice'];
	$HPrice=$_POST['HPrice'];
	$QPrice=$_POST['QPrice'];
	$order_row=$db->get_one('orders', $where);
	$factory_order_oid = $order_row['OId'];
	$db->update('orders',"OId='$factory_order_oid'",array(
		'KPrice'	=> $KPrice,
		'HPrice'	=> $HPrice,
		'QPrice'	=> $QPrice,
		));

}

if($_POST['FollowUp_status'] == 'FollowUp_status'){
	$FollowUp = $_POST['FollowUp'];
	$db->update('orders',"OId='$factory_order_oid'",array(
		'FollowUp' 		  => $_SESSION['ly200_AdminSalesmanName']
		));
}
//我方是否付款
if($_POST['Payment']){
	$Payment = $_POST['Payment'];
	$db->update('orders',"OId='$factory_order_oid'",array(
		'Payment' => $Payment,
		
		));
}

//客户是否签收Signfor
if($_POST['Signfor']){
	$Signfor = $_POST['Signfor'];
	$db->update('orders',"OId='$factory_order_oid'",array(
		'Signfor' => $Signfor,
		
		));
	if($Signfor == "2"){
		$order_status = "7";
		$db->update('orders',"OId='$factory_order_oid'",array(
				'OrderStatus' => $order_status
			));
	}
}
if($_POST['arrive_warehouse']){
		$arrive_warehouse = $_POST['arrive_warehouse'];
		$order_status = "6";
		$db->update('supplire_manage_orders',"SMOrders='$factory_order_oid'",array(
			'SMAffirm' => $arrive_warehouse
			));
		$db->update('orders',"OId='$factory_order_oid'",array(
				'OrderStatus' => $order_status
			));
	}

//-----------------------------------------------------------------------------------提交数据(Start Here)-----------------------------------------------------------------------
$act_ary=array('mod_express', 'mod_total_weight', 'mod_order_price', 'mod_order_status', 'mod_shipping_address', 'mod_billing_address', 'mod_product', 'del_product', 'add_product');

$module_ary=array('base', 'address', 'status', 'product_list', 'product_add', 'print', 'export','orders_trace','orders_status','tranp');	//模块列表
!in_array($module, $module_ary) && $module=$module_ary[0];

$order_row=$db->get_one('orders', $where);
!$order_row && js_location('index.php');
$stutas = $db->get_all('freight_stutas',"OrderId='$OrderId'");
$stutas_count = count($stutas);
$stutas_ros = $stutas[$stutas_count-1];
$factory_order_row = $db->get_one('supplire_manage_orders',"SMOrders='$factory_order_oid'");
$freight_stutas_row = $db->get_all('freight_stutas',"OrderId='$OrderId'");
$trans_one_row = $db->get_one('trans_clear',"OrderId='$OrderId'");
if($trans_one_row['Transport'] == '0'){
	$Transport_one = '自行运输';
}elseif($trans_one_row['Transport'] == '1'){
	$Transport_one = '鹰洋代理空运';
}elseif($trans_one_row['Transport'] == '2'){
	$Transport_one = '鹰洋代理海运';
}

$trans_one_row = $db->get_one('trans_clear',"OrderId='$OrderId'");
//var_dump($trans_one_row);exit;
if($trans_one_row){
	$shipping_row = $db->get_one('shipping',"SId=".$trans_one_row['XSId'],"FirmName");
}else{
	$shipping_row['FirstName']='';
}
if($trans_one_row['Clearance'] == '0'){
	$Clearance_one = '自行清关';
	$QPrice = '0.00';
}elseif($trans_one_row['Clearance'] == '1'){
	$Clearance_one = '鹰洋代理清关';
	$QPrice = $trans_one_row['QPrice'];
}
$address_id = $order_row['ShippingAddressLine1'];
if($address_id){
	$address_row = $db->get_one("address","AId=".$address_id);
}
//var_dump($factory_order_row['SMApply_1']);exit;
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

ob_start();
if($module=='base' || $module=='order_status'){	//加载“基本信息”和“订单状态”共用的模块
	include('include/payment_info_detail.php');
	include('include/mod_express_link.php');
	include('include/mod_weight_link.php');
}
include("module/$module.php");
$html_contents=ob_get_contents();
ob_end_clean();

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

include('../../inc/manage/header.php');
?>
<div class="div_con">
<?php /*?><div class="header"><?=get_lang('ly200.current_location');?>:<a href="index.php"><?=get_lang('orders.orders_manage');?></a>&nbsp;-&gt;&nbsp;<a href="view.php?OrderId=<?=$OrderId;?>"><?=$order_row['OId'];?></a>&nbsp;-&gt;&nbsp;<?=get_lang('ly200.view');?></div><?php */?>
<?php include('include/menu.php');?>
<?=$html_contents;?>
</div>
<?php include('../../inc/manage/footer.php');?>