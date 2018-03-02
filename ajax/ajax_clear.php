<?php
	include("../inc/include.php");
	if($_GET['key'] == 'clear'){
		$kye = $_GET['key'];
		$SId = $_GET['SId'];
		$OrderId = $_GET['OrderId'];
		$trans_clear = $db->get_one("orders","OrderId='$OrderId'","Weight,Volume");
		$shipping = $db->get_one("shipping","SId='$SId'","Express,ShippingCharges,CustomsClearance");
		$Express = $shipping['Express'];
		$Weight = $trans_clear['Weight'];
		$Volume = $trans_clear['Volume'];
		$Weight_C= $shipping['ShippingCharges'];
		$Volume_C = $shipping['CustomsClearance'];
		$arr = array('Status'=>$Express,'Weight'=>$Weight,'Volume'=>$Volume,'Weight_C'=>$Weight_C,'Volume_C'=>$Volume_C);
		$json_encode = json_encode($arr);
		echo $json_encode;
		exit;

	}
?>