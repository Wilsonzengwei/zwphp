<?php
include('../inc/include.php');
$act=$_POST['act'];
if($act=='get_price'){
	$PId=$_POST['PId'];
	$AtrrId=$_POST['AtrrId'];
	$ProId = (int)$_POST['ProId'];
	$product_row=$db->get_one('product',"ProId = '$ProId'");
	$ParameterPrice_row=str::json_data(htmlspecialchars_decode($product_row['ExtAttr']), 'decode');
	$reprice='';
	for($i=0;$i<count($PId);$i++){
		if($i==0){
			$attr_key.=$PId[$i].$AtrrId[$i];
		}else{
			$attr_key.='_'.$PId[$i].$AtrrId[$i];
		}
	}
	$reprice=$ParameterPrice_row[$attr_key][0];
	$Stock=$ParameterPrice_row[$attr_key][1];
	$price_ary=range_price_ext($product_row,$_SESSION['member_Level'],$reprice);
	echo json_data(array(iconv_price($price_ary[0]),iconv_price($price_ary[1]-$price_ary[0]),iconv_price($price_ary[1]),$Stock));
}
exit;
?>