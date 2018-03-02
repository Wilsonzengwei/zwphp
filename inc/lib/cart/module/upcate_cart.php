<?php
ob_end_clean();

$obj=(int)$_GET['obj'];
$CId=(int)$_GET['CId'];
$ProId=(int)$_GET['ProId'];
$Qty=(int)$_GET['Qty'];

$product_row=$db->get_one('product', "ProId='$ProId'");
$cart_row=$db->get_one('shopping_cart',"CId = '$CId'");

$Attr_key=$cart_row['Attr_key'];
if($Attr_key){
	$ParameterPrice_row=str::json_data(htmlspecialchars_decode($product_row['ExtAttr']), 'decode');
	$reprice=$ParameterPrice_row[$Attr_key][0];
	$product_row['Stock']=$ParameterPrice_row[$Attr_key][1];
}

$product_row['Stock']<$Qty && $Qty=$product_row['Stock'];

$price_ary=range_price_ext($product_row,$_SESSION['member_Level'],$reprice);
$item_price=$price_ary[0];

$db->update('shopping_cart', "$where and CId='$CId'", array(
		'Qty'	=>	$Qty,
		'Price'	=>	$item_price
	)
);

$total_price=$db->get_sum('shopping_cart', $where, 'Qty*Price');

echo iconv_price($item_price).'|'.iconv_price($Qty*$item_price).'|'.iconv_price($total_price).'|'.$db->get_sum('shopping_cart', $where, 'Qty*Weight').'|'.(int)$db->get_sum('shopping_cart', $where, 'Qty').'|'.iconv_price($order_discount*$total_price);
exit;
?>