<?php
$mysubmit = '0';
if($_POST['mysubmit'] == '1'){
	$mysubmit = '1';
	
}
$where.=" and Mysubmit=$mysubmit";
$query_string=query_string('ProId');
if(!(int)$_SESSION['member_MemberId']){
	js_location('/account.php','','.top');
	exit;
}

//echo "<script>alert(".$member_supplierid.");</script>";exit;
if($_POST){
	$ProId=(int)$_POST['ProId'];
	$Qty=abs((int)$_POST['Qty']);
	
	for ($i=0; $i <count($_POST['Order_Color']) ; $i++) { 
		$Order_Color = $_POST['Order_Color'][$i];
		$Color_Qty = $_POST['Color_Qty'][$i];
		if($Order_Color && $Color_Qty){
			$ColorId[] = $Order_Color;
		}
	}
	if($ColorId){
		$Color = implode(',',$ColorId);
	}
	$SizeId=(int)$_POST['SizeId'];
	$JumpUrl=$_POST['JumpUrl'];
	$PId = $_POST['PId'];
	$SupplierId = $_POST['SupplierId'];

}else{
	$ProId=(int)$_GET['ProId'];
	$Qty=abs((int)$_GET['Qty']);
	$ColorId=(int)$_GET['ColorId'];
	$SizeId=(int)$_GET['SizeId'];
	$JumpUrl=$_GET['JumpUrl'];
	$PId = $_GET['PId'];
	$SupplierId = $_GET['SupplierId'];
}
//$ColorId && $Color=addslashes($db->get_value('product_color', "CId='$ColorId'", 'Color'));
//$SizeId && $Size=addslashes($db->get_value('product_size', "SId='$SizeId'", 'Size'));
($JumpUrl=='' || substr($JumpUrl, 0, 1)!='/') && $JumpUrl="$cart_url?module=list";
$product_row=$db->get_one('product', "ProId='$ProId'");
$StartFrom = $product_row['StartFrom'];
if($Qty < $StartFrom){
	echo '<script>alert("总数不能低于起订量");history.go(-1);</script>';
	header("Refresh:0; url=/supplier/goods.php?ProId=$ProId&SupplierId=$SupplierId"); 
	exit;
}
//!$product_row && js_location("$cart_url?module=list");
$where.=" and ProId='$ProId'";
if($mysubmit == '1'){
	$JumpUrl = "/cart.php?module=checkout&mysubmit=$mysubmit&act=1&ProId=$ProId&data=cart_list";
}
// $Qty<=0 && $Qty=1;
// $product_row['Stock']<=0 && js_location("/goods.php?ProId=".$ProId,'No Stock');
// $product_row['Stock']<$Qty && $Qty=$product_row['Stock'];
// $price_ary=range_price_ext($product_row,$_SESSION['member_Level'],$reprice);
// 
$product_wholesale_price = $db->get_one("product_wholesale_price","PId=(select MAX(PId) from product_wholesale_price where ProId='$ProId')");

if($db->get_all('product_wholesale_price', "ProId='$ProId'")){
	if($Qty > $product_wholesale_price['Qty2']){
		$price_ary[0] = $product_wholesale_price['Price'];
	}else{
		$wholesale_row=$db->get_one('product_wholesale_price', "ProId='$ProId' and Qty2>='$Qty'", '*', 'Qty2 desc');
		if($wholesale_row){
			$price_ary[0] = $wholesale_row['Price'];
		}
	}
}else{

$price_ary[0] = $product_row['Price_1'];
}
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

	$CId = $db->get_insert_id();
	
	for($i=0;$i<count($_POST['Order_Color']);$i++){
		$Order_Color = $_POST['Order_Color'][$i];
		$Color_Qty = $_POST['Color_Qty'][$i];
		if($Order_Color && $Color_Qty){
			$db->insert('cart_color',array(
					'CId'		=>	$CId,
					'ProId'		=>	$ProId,
					'MemberId'	=>	$_SESSION['member_MemberId'],
					'COId'		=>	$Order_Color,
					'CQty'		=>	$Color_Qty,
					'Mysubmit ' =>  $mysubmit,
				)
			);
		}
	}
}else{
	if($mysubmit != '1'){
		$Qty=$db->get_value('shopping_cart', $where, 'Qty')+$Qty;
		if($db->get_all('product_wholesale_price', "ProId='$ProId'")){
			if($Qty > $product_wholesale_price['Qty2']){
						$price_ary[0] = $product_wholesale_price['Price'];
					}else{
						$wholesale_row=$db->get_one('product_wholesale_price', "ProId='$ProId' and Qty2>='$Qty'", '*', 'Qty2 desc');
						if($wholesale_row){
							$price_ary[0] = $wholesale_row['Price'];
						}
					}
			}else{

				$price_ary[0] = $product_row['Price_1'];
			}
		}
	$db->update('shopping_cart', $where, array(
			'Qty'	=>	$Qty,
			'Color'	=>	$Color,
			'Price'	=>	$price_ary[0],
		)
	);
	
	for($i=0;$i<count($_POST['Order_Color']);$i++){
		$Order_Color = $_POST['Order_Color'][$i];
		$Color_Qty = $_POST['Color_Qty'][$i];
		if($Order_Color && $Color_Qty){
			$Color_Qty=$db->get_value('orders_color', $where." and COId='$Order_Color'", 'CQty')+$Color_Qty;
			$db->update('cart_color',$where." and COId='$Order_Color'",array(
					'CId'		=>	$CId,
					'ProId'		=>	$ProId,
					'MemberId'	=>	$_SESSION['member_MemberId'],
					'COId'		=>	$Order_Color,
					'CQty'		=>	$Color_Qty,
					'Mysubmit ' =>  $mysubmit,
				)
			);
		}
	}

}
if($mysubmit == '0'){
	echo '<script>alert("'.$website_language['cart_lang_1']['lang_15'].'")</script>';
	header("Refresh:0; url=/supplier/goods.php?ProId=$ProId&SupplierId=$SupplierId"); 
	exit;
}

	js_location($JumpUrl);

?>