<?php
$AutoUpdateShippingPrice=(int)$_GET['AutoUpdateShippingPrice'];
$TotalWeight=(float)$_GET['TotalWeight'];
$OrderStatus=(int)$_GET['OrderStatus'];

$db->update('orders', $where, array(
		'TotalWeight'	=>	$TotalWeight
	)
);

update_orders_shipping_info($OrderId, '', $AutoUpdateShippingPrice);

save_manage_log('修改订单重量');
?>