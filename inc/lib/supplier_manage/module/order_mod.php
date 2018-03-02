<?php
/*if($_SESSION['IsSupplier'] !== '1'){
  
    echo '<script>alert("只有商户才能访问");</script>';
    header("Refresh:0;url=/");
    exit;
}*/
$OId = $_GET['OId'];
$SupplierId = $_SESSION['member_MemberId'];


if($_POST['SMApply_1'] == '1'){
	$OId = $_POST['OId'];
	$SupplierId = $_POST['SupplierId'];
	$SMApply_1 = $_POST['SMApply_1'];
	$color = '1';
	$db->insert('supplire_manage_orders',array(
			'SMOrders'        =>  $OId,
			'SMApply_1'		  =>  $SMApply_1
		));
	$db->update('orders',"OId='$OId'",array(
			'Color'        =>  $color,
			'SMApply'	   =>	'2'
		));
	echo '<script>alert("申请成功")</script>';
	include($site_root_path.'/inc/lib/mail/template.php');
	include($site_root_path.'/inc/lib/mail/order_member_email.php');
	sendmail("coconut@eaglesell.com", "张雅玉", "{$Supplier_Name}申请25%预付款进行生产#{$OId}", $mail_contents);
	header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
	exit;
}else if($_POST['SMApply_2'] == '1'){
	$OId = $_POST['OId'];
	$SupplierId = $_POST['SupplierId'];
	$SMApply_2 = $_POST['SMApply_2'];
	$color = '1';
	$db->update('orders',"OId='$OId'",array(
			'Color'        =>  $color
		));
	$where = "SMOrders='".$OId."'";
	$color = '1';
	$db->update('supplire_manage_orders',$where,array(
			//'SMOrders'        =>  $OId,
			//'SMPach'		  =>  '',
			//'SMApply_1'		  =>  $SMApply_1
			'SMApply_2'		  =>  $SMApply_2
			//'SMApply_3'		  =>  '',
			//'SMApply_submit_1'=>  '',
			///'SMApply_submit_2'=>  '',
			//'SMApply_submit_3'=>  ''
		));
	echo '<script>alert("申请成功")</script>';
	include($site_root_path.'/inc/lib/mail/template.php');
	include($site_root_path.'/inc/lib/mail/order_member_email.php');
	sendmail("coconut@eaglesell.com", "张雅玉", "{$Supplier_Name}申请50%生产款进行生产#{$OId}", $mail_contents);
	header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
	exit;
}else if($_POST['SMApply_3'] == '1'){
	$OId = $_POST['OId'];
	$SupplierId = $_POST['SupplierId'];
	$SMApply_3 = $_POST['SMApply_3'];
	$where = "SMOrders='".$OId."'";
	$db->update('supplire_manage_orders',$where,array(
			//'SMOrders'        =>  $OId,
			//'SMPach'		  =>  '',
			//'SMApply_1'		  =>  $SMApply_1
			//'SMApply_2'		  =>  $SMApply_2,
			'SMApply_3'		  =>  $SMApply_3
			//'SMApply_submit_1'=>  '',
			///'SMApply_submit_2'=>  '',
			//'SMApply_submit_3'=>  ''
		));
	$color = '1';
	$db->update('orders',"OId='$OId'",array(
			'Color'        =>  $color
		));
	echo '<script>alert("申请成功")</script>';
	include($site_root_path.'/inc/lib/mail/template.php');
	include($site_root_path.'/inc/lib/mail/order_member_email.php');
	sendmail("coconut@eaglesell.com", "张雅玉", "{$Supplier_Name}申请尾款#{$OId}", $mail_contents);
	header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
	exit;
}

if($_POST['Over'] == '1'){
	$OId = $_POST['OId'];
	$SupplierId = $_POST['SupplierId'];
	$Over = $_POST['Over'];
	$where = "SMOrders='".$OId."'";
	$db->update('supplire_manage_orders',$where,array(
			'Over' =>$Over
		));
	header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
	exit;
}
if($_POST['Shopping']){
	$OId = $_POST['OId'];
	$SupplierId = $_POST['SupplierId'];
	$Shoppling = $_POST['Shopping'];
	$where = "SMOrders='".$OId."'";
	$db->update('supplire_manage_orders',$where,array(
			'Shopping' =>$Shoppling
		));
	//var_dump($Shoppling);exit;
	if($_POST['Shopping'] == '1'){
		if(!$_POST['Stowage']){
			echo '<script>alert("仓库地址待确认中")</script>';
			header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
			exit;
		}
		$order_status = "5";
		$db->update('orders',"OId='$OId'",array(
			'OrderStatus' => $order_status
		));
	}
	header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
	exit;

}
if($_POST['Production']){
	$OId = $_POST['OId'];
	$SupplierId = $_POST['SupplierId'];
	$Production = $_POST['Production'];
	$where = "SMOrders='".$OId."'";
	$db->update('supplire_manage_orders',$where,array(
			'Production' =>$Production
		));
	$order_status = "5";
	$db->update('orders',"OId='$OId'",array(
		'OrderStatus' => $order_status
	));
	header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
	exit;
}
if($_FILES){
	$file_name = $_FILES["file"]["name"]; //- 被上传文件的名称
	$file_type = $_FILES["file"]["type"]; //- 被上传文件的类型
	$file_size = $_FILES["file"]["size"]; //- 被上传文件的大小，以字节计
	$file_tmp_name = $_FILES["file"]["tmp_name"];//存储在服务器的文件的临时副本的名称
	$file_error = $_FILES["file"]["error"]; //- 由文件上传导致的错误代码
	if($_POST['SMApply_submit_1'] == '1'){
		$OId = $_POST['OId'];
		$SupplierId = $_POST['SupplierId'];
		$SMTrans_submit_1 = $_POST['SMApply_submit_1'];
		if($file_name){

			if($file_size > '2000000'){
				$til = "上传的图片不能大于2M";
				echo '<script>alert("'.$til.'")</script>';
				header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
				exit;
			}else{
				$SMPach_1 ="/images/order/".$file_name;
				move_uploaded_file($file_tmp_name,$site_root_path.$SMPach_1);
				
		        //echo "Stored in: supplier_manage/images/order/".$_FILES["file"]["name"];exit;
		      	$where = "SMOrders='".$OId."'";
				$db->update('supplire_manage_orders',$where,array(
						//'SMOrders'        =>  $OId,
						//'SMPach'		  =>  '',
						//'SMApply_1'		  =>  $SMApply_1
						//'SMApply_2'		  =>  $SMApply_2,
						//'SMApply_3'		  =>  $SMApply_3
						  'SMApply_submit_1'=>  $SMTrans_submit_1,
						  'SMPach_1'		=>  $SMPach_1
						///'SMApply_submit_2'=>  '',
						//'SMApply_submit_3'=>  ''
				));
			}
			$color = '3';
			$db->update('orders',"OId='$OId'",array(
					'Color'        =>  $color
				));
			include($site_root_path.'/inc/lib/mail/template.php');
			include($site_root_path.'/inc/lib/mail/order_member_email.php');
			sendmail("coconut@eaglesell.com", "张雅玉", "{$Supplier_Name}上传25%预付款的订单#{$OId}", $mail_contents);

			$pace_sj = '上传收据成功';
			echo '<script>alert("'.$pace_sj.'")</script>';
			
			header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
			exit;
		}else{
			$pace = '图片不能为空';
			echo '<script>alert("'.$pace.'")</script>';
			header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
			exit;
		}
		//js_location("mod.php?OId=$OId");
	}else if($_POST['SMApply_submit_2'] == '1'){
		$OId = $_POST['OId'];
		$SupplierId = $_POST['SupplierId'];
		if($file_name){
			$SMTrans_submit_2 = $_POST['SMApply_submit_2'];
			if($file_size > '2000000'){
				$til = "上传的图片不能大于2M";
				echo '<script>alert("'.$til.'")</script>';
				header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
				exit;
			}else{
				$SMPach_2 ="/images/order/".$file_name;
				move_uploaded_file($file_tmp_name,$site_root_path.$SMPach_2);
				//echo '<script>alert("上传收据成功")</script>';
		        //echo "Stored in: supplier_manage/images/order/".$_FILES["file"]["name"];exit;
		      	$where = "SMOrders='".$OId."'";
				$db->update('supplire_manage_orders',$where,array(
						//'SMOrders'        =>  $OId,
						//'SMPach'		  =>  '',
						//'SMApply_1'		  =>  $SMApply_1
						//'SMApply_2'		  =>  $SMApply_2,
						//'SMApply_3'		  =>  $SMApply_3
						  'SMApply_submit_2'=>  $SMTrans_submit_2,
						  'SMPach_2'		=>  $SMPach_2
						///'SMApply_submit_2'=>  '',
						//'SMApply_submit_3'=>  ''
				));
				$color = '3';
				$db->update('orders',"OId='$OId'",array(
						'Color'        =>  $color
					));
				include($site_root_path.'/inc/lib/mail/template.php');
				include($site_root_path.'/inc/lib/mail/order_member_email.php');
				sendmail("coconut@eaglesell.com", "张雅玉", "{$Supplier_Name}上传申请50%生产金额的收据#{$OId}", $mail_contents);
			}
			$pace_sj = '上传收据成功';
			echo '<script>alert("'.$pace_sj.'")</script>';
			header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
			exit;
		}else{
			$pace = '图片不能为空';
			echo '<script>alert("'.$pace.'")</script>';
			header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
			exit;
		}
		//js_location("mod.php?OId=$OId");
	}else{
		$OId = $_POST['OId'];
		$SupplierId = $_POST['SupplierId'];
		if($file_name){
			$SMTrans_submit_3 = $_POST['SMApply_submit_3'];
			if($file_size > '2000000'){
				$til = "上传的图片不能大于2M";
				echo '<script>alert("'.$til.'")</script>';
				header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
				exit;
			}else{
				if($_POST['SMApply_submit_3'] == '1'){
					$SMPach_3 = "/images/order/".$file_name;
					move_uploaded_file($file_tmp_name,$site_root_path.$SMPach_3);
					//echo '<script>alert("上传收据成功")</script>';
			        //echo "Stored in: supplier_manage/images/order/".$_FILES["file"]["name"];exit;
			      	$where = "SMOrders='".$OId."'";
					$db->update('supplire_manage_orders',$where,array(
							//'SMOrders'        =>  $OId,
							//'SMPach'		  =>  '',
							//'SMApply_1'		  =>  $SMApply_1
							//'SMApply_2'		  =>  $SMApply_2,
							//'SMApply_3'		  =>  $SMApply_3
							  'SMApply_submit_3'=>  $SMTrans_submit_3,
							  'SMPach_3'		=>  $SMPach_3
							///'SMApply_submit_2'=>  '',
							//'SMApply_submit_3'=>  ''
					));
					$color = '3';
					$db->update('orders',"OId='$OId'",array(
							'Color'        =>  $color
						));
					include($site_root_path.'/inc/lib/mail/template.php');
					include($site_root_path.'/inc/lib/mail/order_member_email.php');
					sendmail("coconut@eaglesell.com", "张雅玉", "{$Supplier_Name}上传申请尾款收据#{$OId}", $mail_contents);

				}
				
			}
			$pace_sj = '上传收据成功';
			echo '<script>alert("'.$pace_sj.'")</script>';
			header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
			exit;
		}else{
			$OId = $_POST['OId'];
			$SupplierId = $_POST['SupplierId'];
			$pace = '图片不能为空';
			echo '<script>alert("'.$pace.'")</script>';
			header('Refresh:0;url=/supplier_manage.php?module=order_mod&OId='.$OId.'&SupplierId='.$SupplierId);
			exit;
		}
	}
}


$sm_orders_row = $db->get_one('supplire_manage_orders',"SMOrders='$OId'");
$orders_row = $db->get_one('orders',"OId='$OId'");
//var_dump($orders_row['Signfor']);exit;
?>
<?php
	echo '<link rel="stylesheet" href="/css/supplier_m/order_mod'.$lang.'.css">'
?>

<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['header'.$lang]['mjzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/supplier_manage.php?module=index&act=1" class='s1'><?=$website_language['supplier_m_index'.$lang]['dpgl']?></a>						
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=index&act=2" class='s1'><?=$website_language['supplier_m_index'.$lang]['gggl']?></a>			
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=product&act=3" class='s1'><?=$website_language['supplier_m_index'.$lang]['cpgl']?></a>			
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=order&act=4" class='s2'><?=$website_language['supplier_m_index'.$lang]['ddgl']?></a>		
		</li>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['supplier_m_index'.$lang]['ddgl']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<div class="yh_ac">
			<style>
				
			</style>
				<div class="state1" style=''><span><?=$website_language['supplier_m_order'.$lang]['ddh']?>：</span><span><?=$orders_row['OId']?></span></div>
				<div  class="state2" style=''><span>客服电话：</span><span>0755-33119801   0755-33119835</span></div>
				<div  class="state3">
					<div class="state_img">
						<div style="width:80px;height:80px;background:url(/images/order/order01.png);float:left"></div>
						<?php if($sm_orders_row['SMApply_submit_1'] =='2'){?>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac03.png) no-repeat center center;float:left"></div>
						<?php }else{?>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac02.gif) no-repeat center center;float:left"></div>
						<?php }?>
						
						<?php if($sm_orders_row['SMApply_submit_1'] =='2' && $sm_orders_row['Over'] !=='1'){?>
							<div style="width:80px;height:80px;background:url(/images/order/orders02.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac02.gif) no-repeat center center;float:left"></div>
						<?php }else if($sm_orders_row['SMApply_submit_1'] =='2' && $sm_orders_row['Over'] =='1'){?>
							<div style="width:80px;height:80px;background:url(/images/order/orders02.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac03.png) no-repeat center center;float:left"></div>

						<?php }else{?>
							<div style="width:80px;height:80px;background:url(/images/order/order02.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac01.png) no-repeat center center;float:left"></div>

						<?php }?>


						<?php if($sm_orders_row['Over'] =='1' && $sm_orders_row['Shopping'] !=='1'){?>
							<div style="width:80px;height:80px;background:url(/images/order/orders03.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac02.gif) no-repeat center center;float:left"></div>
						<?php }else if($sm_orders_row['Shopping'] =='1' && $sm_orders_row['Over'] =='1'){?>
							<div style="width:80px;height:80px;background:url(/images/order/orders03.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac03.png) no-repeat center center;float:left"></div>
						<?php }else{?>
							<div style="width:80px;height:80px;background:url(/images/order/order03.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac01.png) no-repeat center center;float:left"></div>

						<?php }?>

						<?php if($sm_orders_row['Shopping'] == '1' && $orders_row['Signfor'] !== '2'){?>
							<div style="width:80px;height:80px;background:url(/images/order/orders04.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac02.gif) no-repeat center center;float:left"></div>
						<?php }else if($sm_orders_row['Shopping'] == '1' && $orders_row['Signfor'] == '2'){?>
							<div style="width:80px;height:80px;background:url(/images/order/orders04.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac03.png) no-repeat center center;float:left"></div>

						<?php }else{?>
							<div style="width:80px;height:80px;background:url(/images/order/order04.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac01.png) no-repeat center center;float:left"></div>

						<?php }?>


						<?php if($orders_row['Signfor'] == '2' && $sm_orders_row['SMApply_submit_3'] !== '2'){?>
							<div style="width:80px;height:80px;background:url(/images/order/orders05.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac02.gif) no-repeat center center;float:left"></div>
						<?php }else if($orders_row['Signfor'] == '2' && $sm_orders_row['SMApply_submit_3'] == '2'){?>
							<div style="width:80px;height:80px;background:url(/images/order/orders05.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac03.png) no-repeat center center;float:left"></div>
						<?php }else{?>
							<div style="width:80px;height:80px;background:url(/images/order/order05.png) no-repeat center center;float:left"></div>
							<div style="width:80px;height:80px;background:url(/images/order/order_ac01.png) no-repeat center center;float:left"></div>
						<?php }?>

						<?php if($sm_orders_row['SMApply_submit_3'] == '2'){?>
							<div style="width:80px;height:80px;background:url(/images/order/orders06.png) no-repeat center center;float:left"></div>
						<?php }else{?>
							<div style="width:80px;height:80px;background:url(/images/order/order06.png) no-repeat center center;float:left"></div>
						<?php }?>
					</div>		
					<div class="state_img">
					<?php if($sm_orders_row['SMApply_submit_1'] !=='2' ){?>
						<div class="state_state1"><?=$website_language['supplier_m_order'.$lang]['scdd']?></div>
					<?php }else{?>
						<div class="state_state"><?=$website_language['supplier_m_order'.$lang]['scdd']?></div>
					<?php }?>

						<div class="state_state"></div>

					<?php if($sm_orders_row['SMApply_submit_1'] =='2' && $sm_orders_row['Over'] !=='1'){?>
						<div class="state_state1"><?=$website_language['supplier_m_order'.$lang]['kssc']?></div>
					<?php }else{?>
						<div class="state_state"><?=$website_language['supplier_m_order'.$lang]['kssc']?></div>
					<?php }?>

						<div class="state_state"></div>
					<?php if($sm_orders_row['Over'] =='1' && $sm_orders_row['Shopping'] !=='1'){?>
						<div class="state_state1"><?=$website_language['supplier_m_order'.$lang]['scwc']?></div>
					<?php }else{?>
						<div class="state_state"><?=$website_language['supplier_m_order'.$lang]['scwc']?></div>
					<?php }?>

						<div class="state_state"></div>
					<?php if($sm_orders_row['Shopping'] == '1' && $orders_row['Signfor'] !== '2'){?>
						<div class="state_state1"><?=$website_language['supplier_m_order'.$lang]['ysz']?></div>
					<?php }else{?>
						<div class="state_state"><?=$website_language['supplier_m_order'.$lang]['ysz']?></div>
					<?php }?>

						<div class="state_state"></div>
					<?php if($orders_row['Signfor'] == '2' && $sm_orders_row['SMApply_submit_3'] !== '2'){?>
						<div class="state_state1"><?=$website_language['supplier_m_order'.$lang]['khyqs']?></div>
					<?php }else{?>
						<div class="state_state"><?=$website_language['supplier_m_order'.$lang]['khyqs']?></div>
					<?php }?>
					
						<div class="state_state"></div>
					<?php if($sm_orders_row['SMApply_submit_3'] == '2'){?>
						<div class="state_state1"><?=$website_language['supplier_m_order'.$lang]['ddwc']?></div>
					<?php }else{?>
						<div class="state_state"><?=$website_language['supplier_m_order'.$lang]['ddwc']?></div>
					<?php }?>
					</div>			
				</div>				
			</div>
			<div  class="state4"><?=$website_language['supplier_m_order'.$lang]['wxts']?>！</div>
			<div class="clear"></div>
			<div class="mask_state">
			<?php if($sm_orders_row['SMApply_submit_1'] !=='2'){?>
				
				<div class="state_mask">
					<div class="state_txt"><?=$website_language['supplier_m_order'.$lang]['dyb']?></div>
					<div>
						<form name="mod_form_1" id="mod_form" class="mod_form" method="post" action="" enctype="multipart/form-data">
							<input type="hidden" name="SMApply_1" value="1">
							<input type="hidden" name="OId" value="<?=$OId?>">
							<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
							<?php if($sm_orders_row['SMApply_1'] !== null){?>
								<input class="sub1" disabled="disabled" type="submit"  type="submit" value="<?=$website_language['supplier_m_order'.$lang]['sq']?>">
							<?php }else{?>
								<input class="sub"  type="submit" value="<?=$website_language['supplier_m_order'.$lang]['sq']?>">
							<?php }?>
						</form>
					</div>
					<div class="state_txt"><?=$website_language['supplier_m_order'.$lang]['deb1']?></div>
					<form action="" method="post" enctype="multipart/form-data">
						<div class="state_txt"><?=$website_language['supplier_m_order'.$lang]['skfp']?>：
							<input  id='11' onchange="preImg(this.id,'aa1');" type="file" name="file" id="">
							<?php if($sm_orders_row['SMPach_1']){ $SMPach_1_k = str_replace("/images/order/","",$sm_orders_row['SMPach_1']); }else{ $SMPach_1_k = '' ;}; ?>
							<input type="button" class="y_button" id='a11' value="<?=$website_language['ylfy'.$lang]['xzwj']?>"><input placeholder='<?=$website_language['ylfy'.$lang]['wxzwj']?>' id='aa1' type="text" class="y_text" name="" id="" value="<?=$SMPach_1_k?>">
							<input type="hidden" name="SMApply_submit_1" value="1">
							<input type="hidden" name="OId" value="<?=$OId?>">
							<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
							
						</div>
						<div><input class="sub"  type="submit" value="<?=$website_language['supplier_m_order'.$lang]['tj']?>"></div>
					</form>
				</div>
				
			<?php }elseif($sm_orders_row['SMApply_submit_1'] =='2' && $sm_orders_row['Over'] !=='1'){?>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="state_mask">
					
						<div class="state_txt"><?=$website_language['supplier_m_order'.$lang]['dyb3']?></div>
						<input type="hidden" name="Over" value="1">
						<input type="hidden" name="OId" value="<?=$OId?>">
						<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
						<div><input class="sub" type="submit" value="<?=$website_language['supplier_m_order'.$lang]['qd']?>"></div>
					</div>
				</form>
			<?php }elseif($sm_orders_row['Over'] =='1' && $sm_orders_row['Shopping'] !='1'){?>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="state_mask">
						<div class="state_txt1"><?=$website_language['supplier_m_order'.$lang]['dyb4']?></div>
							<input type="hidden" name="OId" value="<?=$OId?>">
							<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
	                        <a class="y_input"><input class="input_r" type="radio" value="0" name="Shopping"  <?=$sm_orders_row['Shopping'] == '1' ?  :'checked';?>><span class='input_s'><?=$website_language['supplier_m_order'.$lang]['bs']?></span></a>
							<a class="y_input"><input class="input_r" type="radio" value="1" name="Shopping" id="" <?=$sm_orders_row['Shopping'] == '1' ? checked :'';?>><span class='input_s'><?=$website_language['supplier_m_order'.$lang]['shi']?></span></a><br>
							<span style="margin-left: 20px;">仓库地址:<?=$orders_row['Stowage']?></span>
						<div><input class="sub" type="submit" value="<?=$website_language['supplier_m_order'.$lang]['qd']?>"><input type="hidden" name="Stowage" value="<?=$orders_row['Stowage']?>"></div>
					</div>
				</form>
			<?php }elseif($sm_orders_row['Shopping'] =='1' && $orders_row['Signfor'] !=='2'){?>
				<div class="state_mask">
					<div class="state_txt"><?=$website_language['supplier_m_order'.$lang]['dyb5']?></div>
					<form action="" method="post" enctype="multipart/form-data">
						<div>
							<input type="hidden" name="SMApply_2" value="1">
							<input type="hidden" name="OId" value="<?=$OId?>">
							<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
							<?php if($sm_orders_row['SMApply_2'] !== null){?>
								<input class="sub1"  type="submit" disabled="disabled" value="<?=$website_language['supplier_m_order'.$lang]['sq']?>">
							<?php }else{?>
								<input class="sub"  type="submit" value="<?=$website_language['supplier_m_order'.$lang]['sq']?>">
							<?php }?>
						</div>
					</form>
					<div class="state_txt"><?=$website_language['supplier_m_order'.$lang]['deb2']?></div>
					<form action="" method="post" enctype="multipart/form-data">
					<?php if($sm_orders_row['SMPach_2']){ $SMPach_2_k = str_replace("/images/order/","",$sm_orders_row['SMPach_2']); }else{ $SMPach_2_k = '' ;}; ?>
						<div class="state_txt"><?=$website_language['supplier_m_order'.$lang]['skfp']?>：
						<input  id='11' onchange="preImg(this.id,'aa1');" type="file" name="file" id="">
						<input type="button" class="y_button" id='a11' value="<?=$website_language['ylfy'.$lang]['xzwj']?>">
						<input placeholder='<?=$website_language['ylfy'.$lang]['wxzwj']?>' id='aa1' type="text" class="y_text" name="" id="" value="<?=$SMPach_2_k?>"></div>
						<input type="hidden" name="SMApply_submit_2" value="1">
						<input type="hidden" name="OId" value="<?=$OId?>">
						<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
						<div><input class="sub"  type="submit" value="<?=$website_language['supplier_m_order'.$lang]['tj']?>"></div>
					</form>
				</div>


			<?php }elseif($orders_row['Signfor'] =='2' && $sm_orders_row['SMApply_submit_3'] != '2' ){?>
				
				<div class="state_mask">
					<!-- <div class="state_txt">第一步：申请尾款结算（客户已签收）</div>
					<form action="" method="post" enctype="multipart/form-data">
						<div>
							<input type="hidden" name="SMApply_3" value="1">
							<input type="hidden" name="OId" value="<?=$OId?>">
							<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
							<?php if($sm_orders_row['SMApply_3'] !== null){?>
								<input class="sub1"  type="submit" value="申    请">
							<?php }else{?>
								<input class="sub"  type="submit" value="申    请">
							<?php }?>
						</div>
					</form> -->

					<div class="state_txt"><?=$website_language['supplier_m_order'.$lang]['deb3']?></div>
					<form action="" method="post" enctype="multipart/form-data">
					<?php if($sm_orders_row['SMPach_3']){ $SMPach_3_k = str_replace("/images/order/","",$sm_orders_row['SMPach_3']); }else{ $SMPach_3_k = '' ;}; ?>
					<div class="state_txt"><?=$website_language['supplier_m_order'.$lang]['skfp']?>：
						<input  id='11' onchange="preImg(this.id,'aa1');" type="file" name="file" id="">
						<input type="button" class="y_button" id='a11' value="<?=$website_language['ylfy'.$lang]['xzwj']?>">
						<input placeholder='<?=$website_language['ylfy'.$lang]['wxzwj']?>' id='aa1' type="text" class="y_text" name="" id="" value="<?=$SMPach_3_k?>">
					</div>
					<input type="hidden" name="SMApply_submit_3" value="1">
					<input type="hidden" name="OId" value="<?=$OId?>">
					<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
					<div><input class="sub"  type="submit" value="<?=$website_language['supplier_m_order'.$lang]['tj']?>"></div>
					</form>
				</div>
			<?php }elseif($sm_orders_row['SMApply_submit_3'] == '2'){?>
				<div class="state_mask">
					<div style='width:60px;height:60px;background:url(/images/order/chenggong.png);margin:auto'></div>
					<div class="state_txt2"><?=$website_language['supplier_m_order'.$lang]['gxn']?>！</div>
					<!-- <div><input class="sub"  type="submit" value="返    回"></div> -->
				</div>
			<?php }?>
			
			</div>
		</div>
	</div>
	</div>
</div>
<script>
	$('.state_txt').each(function(){
		var ah=$(this).css('height');
		if(ah=='72px'){
			$(this).css('line-height','18px');
		}
	})
	function getFileUrl(sourceId) {  
                var url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));    
                return url;  
            }  
            function preImg(sourceId,id){   
                var url = getFileUrl(sourceId);                   
                document.getElementById(id).value=document.getElementById(sourceId).value; 
              
            } 
            $(function(){
            	$('#a11').click(function(){
            		$('#11').click();
            	})
            })
        $('.input_r').click(function(){
			$('.y_input').css('color','#666');
			$(this).parent('.y_input').css('color','#006ac3');
		})
</script>
