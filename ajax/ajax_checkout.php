<?php
	include("../inc/include.php");
	if($_GET['act'] == 'goods'){
		$AId = $_GET['val'];
		$address_row = $db->get_one("address","AId='$AId'");
		$SName =$address_row['SName'];
		$SEmail =$address_row['SEmail'];
		$SMobile =$address_row['SMobile'];
		$SArea =$address_row['SArea'];
		$arr = array('SName'=>$SName,'SEmail'=>$SEmail,'SMobile'=>$SMobile,'SArea'=>$SArea,'status'=>'1');
			$json_encode = json_encode($arr);
			echo $json_encode;
			exit;
	}else{
		$arr = array('status'=>'0');
		$json_encode = json_encode($arr);
		echo $json_encode;
		exit;
	}
?>