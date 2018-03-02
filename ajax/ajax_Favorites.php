<?php
	include("../inc/include.php");
	if($_GET['act']=='coll'){

		$SupplierId = $_GET['SupplierId'];
		$ProId = $_GET['ProId'];
		$MemberId = $_GET['MemberId'];
		
		if($db->get_one('coll',"MemberId='$MemberId' and ProId='$ProId'")){
			$db->delete('coll',"MemberId='$MemberId' and ProId='$ProId'");
			$coll_row = $db->get_row_count('coll',"ProId='$ProId'");
			$arr = array('count'=>$coll_row,'status'=>'3');
			$json_encode = json_encode($arr);
			echo $json_encode;
			exit;
		}else{
		
			$product_row = $db->get_one("product","SupplierId='$SupplierId' and ProId='$ProId'");

			$name = $db->get_one("member","MemberId='$SupplierId'");
			$PName = $product_row['Name_lang_1'];
			$SupplierName =$name['Supplier_Name'];
			$Price = $product_row['Price_1'];
			$Moq = $product_row['StartFrom'];
			$PicPath = $product_row['PicPath_0'];
			$coll_arr = array(
				'MemberId'		=>	$MemberId,
				'SupplierId'	=>	$SupplierId,
				'ProId'			=>	$ProId,
				'PName'			=>	$PName,
				'Price'			=>	$Price,
				'Color'			=>	$Color,
				'Moq'			=>	$Moq,
				'SupplierName'	=>	$SupplierName,
				'PicPath'		=>	$PicPath,
				'AccTime'		=>	time(),


				);
			$db->insert("coll",$coll_arr);
			$status=$db->get_insert_id();
			if($status != ''){
				$coll_row = $db->get_row_count('coll',"ProId='$ProId'");
				$arr = array('count'=>$coll_row,'status'=>'1');
				$json_encode = json_encode($arr);
				echo $json_encode;
				exit;
			}else{
				$arr = array('count'=>'','status'=>'1');
				$json_encode = json_encode($arr);
				echo $json_encode;
				exit;
			}
		}
	}
?>