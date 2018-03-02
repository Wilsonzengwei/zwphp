<?php
include("../../../include.php");
$mysubmit = '0';
if($_POST['mysubmit'] == '1'){
	$mysubmit = '1';
}

$where.=" and Mysubmit='$mysubmit'";
$query_string=query_string('ProId');
if(!(int)$_SESSION['member_MemberId']){
	js_location('/account.php','','.top');
	exit;
}
if($_POST[''])
$member_supplierid = $_POST['member_supplierid'];
//echo "<script>alert(".$member_supplierid.");</script>";exit;
if($_POST){
	$ProId=(int)$_POST['ProId'];
	$Qty=abs((int)$_POST['Qty']);
	$Color=(int)$_POST['Color'];
	$SizeId=(int)$_POST['SizeId'];
	$JumpUrl=$_POST['JumpUrl'];
	$PId = $_POST['PId'];
	$SupplierId = $_POST['SupplierId'];

}else{
	$ProId=(int)$_GET['ProId'];
	$Qty=abs((int)$_GET['Qty']);
	$Color=(int)$_GET['Color'];
	$SizeId=(int)$_GET['SizeId'];
	$JumpUrl=$_GET['JumpUrl'];
	$PId = $_GET['PId'];
	$SupplierId = $_GET['SupplierId'];
}
//$ColorId && $Color=addslashes($db->get_value('product_color', "CId='$ColorId'", 'Color'));
//$SizeId && $Size=addslashes($db->get_value('product_size', "SId='$SizeId'", 'Size'));
($JumpUrl=='' || substr($JumpUrl, 0, 1)!='/') && $JumpUrl="$cart_url?module=list";
$product_row=$db->get_one('product', "ProId='$ProId'");

//!$product_row && js_location("$cart_url?module=list");

$where.=" and ProId='$ProId'";
if($mysubmit == '1'){
	$JumpUrl = "/cart.php?module=checkout&member_supplierid=$member_supplierid&mysubmit=$mysubmit&act=1&ProId=$ProId";
}
// $Qty<=0 && $Qty=1;
// $product_row['Stock']<=0 && js_location("/goods.php?ProId=".$ProId,'No Stock');
// $product_row['Stock']<$Qty && $Qty=$product_row['Stock'];
// $price_ary=range_price_ext($product_row,$_SESSION['member_Level'],$reprice);
$price_ary[0] = $product_row['Price_1'];

$data = array(
		'MemberId'	=>	(int)$_SESSION['member_MemberId'],
		'SessionId'	=>	$cart_SessionId,
		'ProId'		=>	$ProId,
		'SupplierId'		=>	$SupplierId,
		'CateId'	=>	(int)$product_row['CateId'],
		'StartFrom'	=>	(int)$product_row['StartFrom'],
		'Color'		=>	$Color,
		'Size'		=>	$Size,
		'Name'		=>	addslashes($product_row['Name']),
		'ItemNumber'=>	addslashes($product_row['ItemNumber']),
		'Weight'	=>	(float)$product_row['Weight'],
		'PicPath'	=>	str_replace('s_', '90X90_', $product_row['PicPath_0']),
		//'Price'		=>	pro_add_to_cart_price_ext($product_row, $Qty),
		'Price'		=>	$price_ary[0],
		'Qty'		=>	$Qty,
		'Url'		=>	addslashes(get_url('product', $product_row)),
		'AddTime'	=>	$service_time,
		'Attr_key'	=>	$attr_key,
		'Mysubmit ' =>  $mysubmit,

	);
//var_dump($where);exit;
if(!$db->get_row_count('shopping_cart', $where)){
	$db->insert('shopping_cart', array(
			'MemberId'	=>	(int)$_SESSION['member_MemberId'],
			'SessionId'	=>	$cart_SessionId,
			'ProId'		=>	$ProId,
			'SupplierId'=>	$SupplierId,
			'CateId'	=>	(int)$product_row['CateId'],
			'StartFrom'	=>	(int)$product_row['StartFrom'],
			'Color'		=>	$Color,
			'Size'		=>	$Size,
			'Name'		=>	addslashes($product_row['Name']),
			'Name_lang_1'=>	addslashes($product_row['Name_lang_1']),
			'ItemNumber'=>	addslashes($product_row['ItemNumber']),
			'Weight'	=>	(float)$product_row['Weight'],
			'PicPath'	=>	str_replace('s_', '90X90_', $product_row['PicPath_0']),
			//'Price'		=>	pro_add_to_cart_price_ext($product_row, $Qty),
			'Price'		=>	$price_ary[0],
			'Qty'		=>	$Qty,
			'Url'		=>	addslashes(get_url('product', $product_row)),
			'AddTime'	=>	$service_time,
			'Attr_key'	=>	$attr_key,
			'Mysubmit ' =>  $mysubmit,
			
		)
	);
}else{
	if($mysubmit != '1'){
		$Qty=$db->get_value('shopping_cart', $where, 'Qty')+$Qty;
	}
	$db->update('shopping_cart', $where, array(
			'Qty'	=>	$Qty,
			'Price'	=>	pro_add_to_cart_price($product_row, $Qty, $order_product_price_field)
		)
	);
}
if($mysubmit == '0'){
	echo '<script>alert("'.$website_language['cart_lang_1']['lang_15'].'")</script>';
	header("Refresh:0; url=/supplier/goods.php?ProId=$ProId&SupplierId=$SupplierId"); 
	exit;
}

	js_location($JumpUrl);

?>