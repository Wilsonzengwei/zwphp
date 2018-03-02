<?php
	include("inc/include.php");
	
	$shopId=$_GET['getProId'];
	$email=$_GET['email'];

	$act = $_GET['act'];


	if($act == "index"){
		if($db->get_one('goods_Browser',"shopId='$shopId'")){
		$proid_cishu = $db->get_one('goods_Browser',"shopId='$shopId'",'Browser');
		$aaa=$proid_cishu['Browser'];	
		$aaa++;
		$db->update('goods_Browser',"shopId='$shopId'",array(
			'Browser' =>$aaa,		
			));
		}else{
			$cishu = $_GET['cishu'];
			$db->insert('goods_Browser',array(
			'Browser' =>$cishu,
			'ShopId' =>$shopId
			));
		}


		$cateid = $db->get_one('product',"ProId='$shopId'","CateId");
		$cateid_1 = $cateid['CateId'];
		if($db->get_one('like_brower',"Email='$email' and CateId='$cateid_1'")){
			$onlick = $db->get_one('like_brower',"Email='$email' and CateId='$cateid_1'",'Onlike');
			$onlick_1 = $onlick['Onlike'];
			echo $onlick_1;
			$onlick_1++;
			$db->update('like_brower',"Email='$email' and CateId='$cateid_1'",array(
			'Onlike' =>$onlick_1,		
			));
		}else{
			$onlick = '1';
			$db->insert('like_brower',array(
				'Email' =>$email,
				'CateId' =>$cateid_1,
				'Onlike' => $onlick
				));
		}
		

	}
	
?>
