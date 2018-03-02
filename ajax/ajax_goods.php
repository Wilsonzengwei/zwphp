<?php
include("../inc/include.php");
	if($_POST['act'] == 'goods'){
		$dc = $_POST['dc'];
echo $_POST['Color'];exit;
		$ProId = $_POST['ProId'];
		$MemberId = $_POST['MemberId'];
		if(!$db->get_one("shopping_cart","MemberId='$MemberId' and ProId='$ProId'")){
			echo "2";
			exit;
		}else{
			$db->update("shopping_cart","MemberId='$MemberId' and ProId='$ProId'",array(
				'Color'	=>	$dc,
				));
			echo "1";
			exit;
		}
	}else{
		echo "3";
		exit;
	}
?>