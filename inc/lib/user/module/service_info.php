<?php 

$MemberId = $_SESSION['member_MemberId'];

$where = "MemberId='$MemberId'";

if($_GET['service']){
	$service = $_GET['service'];
	$where .= " and TOrderId like '%$service%'";
}
if($_POST['page_input']){
	$act = $_GET['act'];
	$page_input = $_POST['page_input'];
	$page = $page_input;
	header("Location: /user.php?module=service_info&page=$page&act=".$act);
	exit;
}
$row_count=$db->get_row_count('trans_clear', $where);
$total_pages=ceil($row_count/10);
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*10;
$trans_clear_row = $db->get_limit("trans_clear", $where,'*',"AccTime desc",$start_row,10);
if($_GET['act'] == '2'){
	$TOrderId=$_GET['TOrderId'];
	$trans_one_row = $db->get_one("trans_clear","TOrderId='$TOrderId'");
	$OrderId =$trans_one_row['OrderId'];
	$order_row = $db->get_one("orders","OrderId='$OrderId'");
	$order_list_row = $db->get_one("orders_product_list","OrderId='$OrderId'");
	$ProId = $order_list_row['ProId'];
	$product_row = $db->get_one("product","ProId='$ProId'","ProductCodeId");
	$stutas = $db->get_all('freight_stutas',"OrderId='$OrderId'");
	$stutas_count = count($stutas);
	$stutas_ros = $stutas[$stutas_count-1];
	if($trans_one_row['Transport'] == '0'){
		$Transport_one = $website_language['supplier_clear'.$lang]['zxys'];
	}elseif($trans_one_row['Transport'] == '1'){
		$Transport_one = $website_language['supplier_clear'.$lang]['yydlky'];
	}elseif($trans_one_row['Transport'] == '2'){
		$Transport_one =  $website_language['supplier_clear'.$lang]['yydlhy'];
	}
	if($trans_one_row['Clearance'] == '0'){
		$Clearance_one =  $website_language['supplier_clear'.$lang]['zxqg'];
		$QPrice = '0.00';
	}elseif($trans_one_row['Clearance'] == '1'){
		$Clearance_one =  $website_language['supplier_clear'.$lang]['yygjdlqg'];
		$QPrice = $trans_one_row['QPrice'];
	}
}
?>
<?php
	echo '<link rel="stylesheet" href="/css/user/service_info'.$lang.'.css">'
?>
<?php if($_GET['act'] == '1'){?>
	<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['user_index'.$lang]['grzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
		<?php if($IsSupplier != '1'){?>
			<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s1'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s2'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s1'><?=$website_language['user_index'.$lang]['shdz']?></a></li>
		<?php }?>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['user_service_info'.$lang]['ddfw']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">				
			<div class="dianji_list2">
			<form method="get">
				<input type="hidden" name="module" value="service_info"> 
				<input type="text" placeholder='<?=$website_language['user_service_info'.$lang]['qsrfwdh']?>' class="yct" style="" name="service" value='<?=$service?>'>
				<input type="submit" class="ycb" style="" value="<?=$website_language['user_service_info'.$lang]['ss']?>">
				<input type="hidden" name="act" value="1">
			</form>
			</div>		
			<div class="bbg1">		
				<div class="content_title">
					<div class="a_1201"><?=$website_language['user_service_info'.$lang]['fwdh']?></div>
					<div class="a_120"><?=$website_language['user_service_info'.$lang]['ddh']?></div>
					<div class="a_180"><?=$website_language['user_service_info'.$lang]['cpmc']?></div>
					<div class="a_120"><?=$website_language['user_service_info'.$lang]['ysfs']?></div>
					<div class="a_80"><?=$website_language['user_service_info'.$lang]['qgfs']?></div>
					<div class="a_90"><?=$website_language['user_service_info'.$lang]['ysfy']?></div>
					<div class="a_902"><?=$website_language['user_service_info'.$lang]['qgfy']?></div>
					<div class="a_60"><?=$website_language['user_service_info'.$lang]['cz']?></div>
				</div>
				<?php 
					for ($i=0; $i < count($trans_clear_row); $i++) { 
						$OrderId=$trans_clear_row[$i]['OrderId'];
						$OId = $db->get_one("orders","OrderId='$OrderId'","OId");
						if($trans_clear_row[$i]['Transport'] == '0'){
							$Transport = '自行运输';
						}elseif($trans_clear_row[$i]['Transport'] == '1'){
							$Transport = '鹰洋代理空运';
						}elseif($trans_clear_row[$i]['Transport'] == '2'){
							$Transport = '鹰洋代理海运';
						}

						if($trans_clear_row[$i]['Clearance'] == '0'){
							$Clearance = '自行清关';
						}elseif($trans_clear_row[$i]['Clearance'] == '1'){
							$Clearance = '鹰洋代理清关';
						}

				?>
				<div class="content_titleb">
					<div class="product_yhh_t1_1201">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$trans_clear_row[$i]['TOrderId']?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_120">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$OId['OId']?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_180">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$trans_clear_row[$i]['PName']?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_120">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$Transport?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_80">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$Clearance?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_90">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       USD $<?=$trans_clear_row[$i]['TotalPrice']?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_902">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       USD $<?=$trans_clear_row[$i]['QPrice']?>
						   </div>
						</div>
					</div>
					<div class="b_60"><a href="/user.php?module=service_info&act=2&TOrderId=<?=$trans_clear_row[$i]['TOrderId']?>"><?=$website_language['user_service_info'.$lang]['xq']?></a></div>
				</div>
				<?php }?>
			</div>	
		</div>
	</div>
	</div>
</div>
<?php }elseif($_GET['act'] == '2'){?>

<div class="mask">
	<div class="box">
	<div  class="header"><?=$website_language['user_index'.$lang]['grzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
		<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s1'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
		<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s2'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
		<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
		<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
		<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s1'><?=$website_language['user_index'.$lang]['shdz']?></a></li>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['user_index'.$lang]['ddfw']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<div class="weight">
				<?=$website_language['ylfy'.$lang]['fwxq']?>
			</div>
			<div class="y_form1"><span class="span_title"><?=$website_language['user_service_info'.$lang]['cpmc']?></span>：<span title='<?=$order_list_row['Name_lang_1'] ? $order_list_row['Name_lang_1'] : $order_list_row['Name'];?>'><?=$order_list_row['Name_lang_1'] ? $order_list_row['Name_lang_1'] : $order_list_row['Name'];?></span></div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['user_service_info'.$lang]['fwdh']?></span><span class='hi2'>：</span><span class='w_320'><?=$trans_one_row['TOrderId']?></span>
			</div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['user_service_info'.$lang]['ddh']?></span><span class='hi2'>：</span><span class='w_320'><?=$order_row['OId']?></span>
			</div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['ylfy'.$lang]['hh']?></span><span class='hi2'>：</span><span class='w_320'><?=$product_row['ProductCodeId']?></span>
			</div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['user_orderd'.$lang]['ydh']?></span><span class='hi2'>：</span><span class='w_320'><?=$stutas_ros['TrackingNumber'];?></span>
			</div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['user_service_info'.$lang]['ysfs']?></span><span class='hi2'>：</span><span class='w_320'><?=$Transport_one?></span>
			</div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['user_service_info'.$lang]['ysfy']?></span><span class='hi2'>：</span><span class='w_320'>USD $<?=$trans_one_row['TotalPrice']?></span>
			</div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['user_service_info'.$lang]['qgfs']?></span><span class='hi2'>：</span><span class='w_320'><?=$Clearance_one?></span>
			</div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['user_service_info'.$lang]['qgfy']?></span><span class='hi2'>：</span><span class='w_320'>USD $<?=$QPrice?></span>
			</div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['supplier_m_order'.$lang]['gjr']?></span><span class='hi2'>：</span><span class='w_320'><?=$order_row['FollowUp']?></span>
			</div>
			<div class="y_form">
				<span class="span_title"><?=$website_language['user_orderd'.$lang]['fksj']?></span><span class='hi2'>：</span><span class='w_320'><?=date("Y-m-d H:i:s",$trans_one_row['AccTime'])?></span>
			</div>		
		</div>
	</div>
	</div>
</div>
<?php }?>