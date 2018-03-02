<?php
$TotalPrice=(float)$_POST['TotalPrice'];
$Discount=1-(float)$_POST['Discount'];
$ShippingPrice=(float)$_POST['ShippingPrice'];
$PayAdditionalFee=(float)$_POST['PayAdditionalFee'];

$db->update('orders', $where, array(
		'TotalPrice'		=>	$TotalPrice,
		'Discount'			=>	$Discount,
		'ShippingPrice'		=>	$ShippingPrice,
		'PayAdditionalFee'	=>	$PayAdditionalFee
	)
);

save_manage_log('修改订单基本信息');
?>