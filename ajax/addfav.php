<?php
include('../inc/include.php');
if($_SESSION['member_MemberId']){
	$where="MemberId = '{$_SESSION['member_MemberId']}'";
	$ProId=(int)$_GET['ProId'];
	!$ProId && $ProId=(int)$_POST['ProId'];
	if($db->get_row_count('product', "ProId='$ProId'") && !$db->get_row_count('wish_lists', "$where and ProId='$ProId'")){
		$db->insert('wish_lists', array(
				'MemberId'	=>	(int)$_SESSION['member_MemberId'],
				'ProId'		=>	$ProId,
				'WishTime'	=>	$service_time
			));
		$db->query("update product set FavoriteCount+1 where ProId ='$ProId'");
		echo 1;
	}else{
		echo 2;
	}
}else{
	echo 3;
}
exit;
?>