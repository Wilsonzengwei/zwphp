<?php
$OrderStatus=(int)$_POST['OrderStatus'];
$FollowUp = $_POST['FollowUp'];
if($OrderStatus==5 || $OrderStatus==6){
	$TrackingNumber=$_POST['TrackingNumber'];
	$ShippingTime=@strtotime($_POST['ShippingTime']);
}else{
	$TrackingNumber='';
	$ShippingTime=0;
}

$db->update('orders', $where, array(
		'OrderStatus'	=>	$OrderStatus,
		'TrackingNumber'=>	$TrackingNumber,
		'FollowUp'=>	$FollowUp,
		'ShippingTime'	=>	$ShippingTime
	)
);
if($OrderStatus==5){
	$order_row=$db->get_one('orders', $where);
	$TotalPrice= $order_row['TotalPrice']+$order_row['ShippingPrice'];
	$db->query("update member set MemberMoney=MemberMoney-$TotalPrice where MemberId='{$order_row['MemberId']}'");
	//echo "update member set MemberMoney=MemberMoney-$TotalPrice where MemberId='{$order_row['MemberId']}'";
}

/*if(($OrderStatus==5 || $OrderStatus==6) && $db->get_value('orders', $where, 'CutStock')==0){
	$ProId='0,';
	$item_row=$db->get_all('orders_product_list', $where, '*', 'ProId desc, LId desc');
	for($i=0; $i<count($item_row); $i++){
		$ProId.=$item_row[$i]['ProId'].',';
		$db->query("update product set Stock=Stock-{$item_row[$i]['Qty']} where ProId='{$item_row[$i]['ProId']}'");
	}
	$ProId.='0';
	$db->update('product', "ProId in($ProId) and Stock<0", array(
			'Stock'	=>	0
		)
	);
	
	$db->update('orders', $where, array(
			'CutStock'	=>	1
		)
	);
}*/

if($OrderStatus==7 && $db->get_value('orders', $where, 'CutStock')==0){
	$ProId='0,';
	$item_row=$db->get_all('orders_product_list', $where, '*', 'ProId desc, LId desc');
	for($i=0; $i<count($item_row); $i++){
		$ProId.=$item_row[$i]['ProId'].',';
		$db->query("update product set Stock=Stock+{$item_row[$i]['Qty']} where ProId='{$item_row[$i]['ProId']}'");
	}
	$ProId.='0';
	$db->update('product', "ProId in($ProId) and Stock<0", array(
			'Stock'	=>	0
		)
	);
	
	$db->update('orders', $where, array(
			'CutStock'	=>	1
		)
	);
}

save_manage_log('修改订单状态');
?>