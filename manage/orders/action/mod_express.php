<?php
$AutoUpdateShippingPrice=(int)$_GET['AutoUpdateShippingPrice'];
$Express=$_GET['Express'];

update_orders_shipping_info($OrderId, $Express, $AutoUpdateShippingPrice);

save_manage_log('修改订单送货方式');
?>