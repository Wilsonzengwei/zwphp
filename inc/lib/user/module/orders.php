<?php 

$MemberId = $_SESSION['member_MemberId'];

if($_POST['page_input']){
	$act = $_GET['act'];
	$page_input = $_POST['page_input'];
	$page = $page_input;
	header("Location: /user.php?module=orders&page=$page&act=".$act);
	exit;
}
$where = "MemberId='$MemberId' and Del=1";
$all = $_GET['mode'];
if($all == 'all'){

}elseif ($all == 'wait') {
	$where .= " and OrderStatus=1";
}elseif ($all == 'already') {
	$where .= " and OrderStatus > 1 and OrderStatus < 7";
}elseif ($all == 'over') {
	$where .= " and OrderStatus > 6";
}
$row_count=$db->get_row_count('orders', $where);
$total_pages=ceil($row_count/10);
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*10;
if($_GET['OId_s']){
	$OId_s = $_GET['OId_s'];
	$where .=" and OId like '%$OId_s%'";
}

$order_row = $db->get_limit("orders",$where,'*',"OrderTime desc",$start_row,'10');
?>
<?php
	echo '<link rel="stylesheet" href="/css/user/orders'.$lang.'.css">'
?>

<link href="../css/lyz.calendar.css" rel="stylesheet" type="text/css" />
<script src="http://www.jq22.com/jquery/1.4.4/jquery.min.js"></script>
<script src="../js/lyz.calendar.min.js" type="text/javascript"></script>

<?php if($_GET['act'] == '1'){?>
<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['user_index'.$lang]['grzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
		<?php if($IsSupplier != '1'){?>
			<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s2'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s1'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s1'><?=$website_language['user_index'.$lang]['shdz']?></a></li>
		<?php }?>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['user_index'.$lang]['wddd']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<div class="dianji_list">
				<a data='1' class="dianji_c dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=1&mode=all"><?=$website_language['user_orders'.$lang]['qbdd']?></a>
				<a data='2' class="dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=2&mode=wait"><?=$website_language['user_orders'.$lang]['dfk']?></a>
				<a data='3' class="dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=3&mode=already"><?=$website_language['user_orders'.$lang]['yfk']?></a>
				<a data='4' class="dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=4&mode=over"><?=$website_language['user_orders'.$lang]['ywc']?></a>
			</div>
		<form method="get" action="">
			<div class="dianji_list2">
				<input type="text" class="yct" placeholder="<?=$website_language['user_orders'.$lang]['qsrddh']?>" name="OId_s" value="<?=$OId_s?>">
				<input type="hidden" name="act" value="1">
				<input type="hidden" name="module" value="orders">
				<input type="submit" class="ycb" value="<?=$website_language['user_orders'.$lang]['ss']?>">
			</div>
		</form>
		<form method="post" action="">
			<div class="ds_list ds_list_b" data='1'>
				<div class="bbg1">
					<div class="content_title">				
						<div class="a_380"><?=$website_language['user_orders'.$lang]['cpxx']?></div>
						<div class="a_100"><?=$website_language['user_orders'.$lang]['dj']?></div>
						<div class="a_80"><?=$website_language['user_orders'.$lang]['sl']?></div>
						<div class="a_100"><?=$website_language['user_orders'.$lang]['zj']?></div>
						<div class="a_100_es"><?=$website_language['user_orders'.$lang]['jyzt']?></div>
						<div class="a_100"><?=$website_language['user_orders'.$lang]['cz']?></div>
					</div>
					<?php 
						for ($i=0; $i < count($order_row); $i++) { 
							$OrderId = $order_row[$i]['OrderId'];
							$order_product_row = $db->get_one('orders_product_list',"OrderId='$OrderId'");

							$PaymentStatus = $order_row[$i]['PaymentStatus'];
							if($order_row[$i]['OrderStatus'] == '2'){
								$status_price = $website_language['user_orders'.$lang]['yfk'];
							}elseif($order_row[$i]['OrderStatus'] == '1'){
								$status_price = $website_language['user_orders'.$lang]['dfk'];
							}elseif($order_row[$i]['OrderStatus'] > '2' && $order_row[$i]['OrderStatus'] < '8'){
								$status_price = $website_language['supplier_m_order'.$lang]['ysz'];
							}elseif( $order_row[$i]['OrderStatus'] == '8'){
								$status_price = $website_language['user_orders'.$lang]['ywc'];
							}

					?>
						<div class="content_waiwei">
							<div class="content_title">
								<span><?=$website_language['user_orders'.$lang]['ddh']?>：</span>
								<span><?=$order_row[$i]['OId']?></span>&nbsp;&nbsp;
								<span><?=date("Y-m-d H:i:s",$order_row[$i]['OrderTime'])?></span>
							</div>
							<div class="b_380"><a href="/supplier/goods.php?ProId=<?=$order_product_row['ProId']?>&SupplierId=<?=$order_product_row['SupplierId']?>">	
								<div class="b_img">
									<img src="<?=$order_product_row['PicPath']?>" alt="">
								</div>								
								<div class="b_txt_mask">
									<div class="b_txt" title="<?=$order_product_row['Name'.$lang]?>"><?=$order_product_row['Name'.$lang]?></div>
								</div>
								</a>
							</div>
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div class="b_txt_sm" title="">USD $<?=$order_product_row['Price']?></div>
								</div>
							</div>
							<div class="b_100_es">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm"><?=$order_row[$i]['Qty']?></div>
								</div>
							</div>
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm_red">USD $<?=$order_row[$i]['TotalPrice']?></div>
								</div>
							</div>
							<div class="b_100_eq">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm"><?=$status_price?></div>
								</div>
							</div>
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div class="b_txt_sm1">
										
									<?php if($order_row[$i]['OrderStatus'] == '1'){ ?>
										<div><a href="/user.php?module=order_list&OId=<?=$order_row[$i]['OId']?>&act=payment&OrderId=<?=$order_row[$i]['OrderId']?>"><?=$website_language['user_orders'.$lang]['ljfk']?></a></div>
									<?php }elseif($order_row[$i]['OrderStatus'] > '1' && $order_row[$i]['OrderStatus'] < '7'){?>

										<div><a href="/supplier/clear.php?OrderId=<?=$order_row[$i]['OrderId']?>&MemberId=<?=$MemberId?>"><?=$website_language['user_orders'.$lang]['ljys']?></a></div>
									<?php }elseif($order_row[$i]['OrderStatus'] > '6'){?>
										<div><a href=""><?=$website_language['user_orders'.$lang]['ljpl']?></a></div>
									<?php }?>
										<br>
										<div><a href="/user.php?module=orders_date&OId=<?=$order_row[$i]['OId']?>"><?=$website_language['user_orders'.$lang]['ddxq']?></a></div>
									</div>
								</div>
							</div>
						</div>	
					<?php }?>
				</div>
				<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "/user.php?module=orders&act=1&page=", $row_count, '〈', '〉');?></div>
				<input type="submit" name="" style="display: none;" value="">
			</div>
			</form>
			
	</div>

	</div>
</div> 
</div>
<?php }elseif($_GET['act'] == '2'){ ?>
<div class="mask">
	<div class="box">
	<div  class="header"><?=$website_language['user_index'.$lang]['grzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
		<?php if($IsSupplier != '1'){?>
			<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s2'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s1'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s1'><?=$website_language['user_index'.$lang]['shdz']?></a></li>
		<?php }?>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['user_index'.$lang]['wddd']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<div class="dianji_list">
				<a data='1' class=" dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=1&mode=all"><?=$website_language['user_orders'.$lang]['qbdd']?></a>
				<a data='2' class="dianji dianji_c" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=2&mode=wait"><?=$website_language['user_orders'.$lang]['dfk']?></a>
				<a data='3' class="dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=3&mode=already"><?=$website_language['user_orders'.$lang]['yfk']?></a>
				<a data='4' class="dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=4&mode=over"><?=$website_language['user_orders'.$lang]['ywc']?></a>
			</div>
			<div class="dianji_list2">
				<input type="text" class="yct" placeholder="<?=$website_language['user_orders'.$lang]['qsrddh']?>">
				<input type="button" class="ycb"  value="<?=$website_language['user_orders'.$lang]['ss']?>">
			</div>
			<div class="ds_list ds_list_b" data='1'>
				<div class="bbg1">
					<div class="content_title">				
						<div class="a_380"><?=$website_language['user_orders'.$lang]['cpxx']?></div>
						<div class="a_100"><?=$website_language['user_orders'.$lang]['dj']?></div>
						<div class="a_80"><?=$website_language['user_orders'.$lang]['sl']?></div>
						<div class="a_100"><?=$website_language['user_orders'.$lang]['zj']?></div>
						<div class="a_100_es"><?=$website_language['user_orders'.$lang]['jyzt']?></div>
						<div class="a_100"><?=$website_language['user_orders'.$lang]['cz']?></div>
					</div>
					<?php 
						for ($i=0; $i < count($order_row); $i++) { 
							$OrderId = $order_row[$i]['OrderId'];
							$order_product_row = $db->get_one('orders_product_list',"OrderId='$OrderId'");
							$PaymentStatus = $order_row[$i]['PaymentStatus'];
							if($order_row[$i]['OrderStatus'] == '2'){
								$status_price = $website_language['user_orders'.$lang]['yfk'];
							}elseif($order_row[$i]['OrderStatus'] == '1'){
								$status_price = $website_language['user_orders'.$lang]['dfk'];
							}elseif($order_row[$i]['OrderStatus'] > '2' && $order_row[$i]['OrderStatus'] < '8'){
								$status_price = $website_language['supplier_m_order'.$lang]['ysz'];
							}elseif( $order_row[$i]['OrderStatus'] == '8'){
								$status_price = $website_language['user_orders'.$lang]['ywc'];
							}


					?>
						<div class="content_waiwei">
							<div class="content_title">
								<span><?=$website_language['user_orders'.$lang]['ddh']?>：</span>
								<span><?=$order_row[$i]['OId']?></span>&nbsp;&nbsp;
								<span><?=date("Y-m-d H:i:s",$order_row[$i]['OrderTime'])?></span>
							</div>
							<div class="b_380">
								<a href="/supplier/goods.php?ProId=<?=$order_product_row['ProId']?>&SupplierId=<?=$order_product_row['SupplierId']?>">
								<div class="b_img">
										<img src="<?=$order_product_row['PicPath']?>" alt="">
								</div>
								<div class="b_txt_mask">
									<div class="b_txt" title="<?=$order_product_row['Name'.$lang]?>"><?=$order_product_row['Name'.$lang]?></div>
								</div>
								</a>
							</div>
							
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div class="b_txt_sm" title="">USD $<?=$order_product_row['Price']?></div>
								</div>
							</div>
							<div class="b_100_es">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm"><?=$order_row[$i]['Qty']?></div>
								</div>
							</div>
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm_red">USD $<?=$order_row[$i]['TotalPrice']?></div>
								</div>
							</div>
							<div class="b_100_eq">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm"><?=$status_price?></div>
								</div>
							</div>
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div class="b_txt_sm1">
										<div><a href="/user.php?module=order_list&OId=<?=$order_row[$i]['OId']?>&act=payment&OrderId=<?=$order_row[$i]['OrderId']?>"><?=$website_language['user_orders'.$lang]['ljfk']?></a></div><br>
										<div><a href="/user.php?module=orders_date&OId=<?=$order_row[$i]['OId']?>"><?=$website_language['user_orders'.$lang]['ddxq']?></a></div>
									</div>
								</div>
							</div>
						</div>	
					<?php }?>
				</div>
				
			</div>
			<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "/user.php?module=orders&act=2&page=", $row_count, '〈', '〉');?></div>
			<input type="submit" name="" style="display: none;" value="">
			</form>
			
	</div>

	</div>

</div>

</div>

<?php }elseif($_GET['act'] == '3'){ ?>
<div class="mask">
	<div class="box">
	<div  class="header"><?=$website_language['user_index'.$lang]['grzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
		<?php if($IsSupplier != '1'){?>
			<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s2'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s1'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s1'><?=$website_language['user_index'.$lang]['shdz']?></a></li>
		<?php }?>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['user_index'.$lang]['wddd']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<div class="dianji_list">
				<a data='1' class=" dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=1&mode=all"><?=$website_language['user_orders'.$lang]['qbdd']?></a>
				<a data='2' class="dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=2&mode=wait"><?=$website_language['user_orders'.$lang]['dfk']?></a>
				<a data='3' class="dianji dianji_c" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=3&mode=already"><?=$website_language['user_orders'.$lang]['yfk']?></a>
				<a data='4' class="dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=4&mode=over"><?=$website_language['user_orders'.$lang]['ywc']?></a>
			</div>
			<div class="dianji_list2">
				<input type="text" class="yct" placeholder="<?=$website_language['user_orders'.$lang]['qsrddh']?>">
				<input type="button" class="ycb" value="<?=$website_language['user_orders'.$lang]['ss']?>">
			</div>
			<div class="ds_list ds_list_b" data='1'>
				<div class="bbg1">
					<div class="content_title">				
						<div class="a_380"><?=$website_language['user_orders'.$lang]['cpxx']?></div>
						<div class="a_100"><?=$website_language['user_orders'.$lang]['dj']?></div>
						<div class="a_80"><?=$website_language['user_orders'.$lang]['sl']?></div>
						<div class="a_100"><?=$website_language['user_orders'.$lang]['zj']?></div>
						<div class="a_100_es"><?=$website_language['user_orders'.$lang]['jyzt']?></div>
						<div class="a_100"><?=$website_language['user_orders'.$lang]['cz']?></div>
					</div>
					<?php 
						for ($i=0; $i < count($order_row); $i++) { 
							$OrderId = $order_row[$i]['OrderId'];
							$order_product_row = $db->get_one('orders_product_list',"OrderId='$OrderId'");
							$PaymentStatus = $order_row[$i]['PaymentStatus'];
							if($order_row[$i]['OrderStatus'] == '2'){
								$status_price = $website_language['user_orders'.$lang]['yfk'];
							}elseif($order_row[$i]['OrderStatus'] == '1'){
								$status_price = $website_language['user_orders'.$lang]['dfk'];
							}elseif($order_row[$i]['OrderStatus'] > '2' && $order_row[$i]['OrderStatus'] < '8'){
								$status_price = $website_language['supplier_m_order'.$lang]['ysz'];
							}elseif( $order_row[$i]['OrderStatus'] == '8'){
								$status_price = $website_language['user_orders'.$lang]['ywc'];
							}

					?>
						<div class="content_waiwei">
							<div class="content_title">
								<span><?=$website_language['user_orders'.$lang]['ddh']?>：</span>
								<span><?=$order_row[$i]['OId']?></span>&nbsp;&nbsp;
								<span><?=date("Y-m-d H:i:s",$order_row[$i]['OrderTime'])?></span>
							</div>
							<div class="b_380"><a href="/supplier/goods.php?ProId=<?=$order_product_row['ProId']?>&SupplierId=<?=$order_product_row['SupplierId']?>">
								<div class="b_img">
										<img src="<?=$order_product_row['PicPath']?>" alt="">
								</div>
								<div class="b_txt_mask">
									<div class="b_txt" title="<?=$order_product_row['Name'.$lang]?>"><?=$order_product_row['Name'.$lang]?></div>
								</div>
								</a>
							</div>
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div class="b_txt_sm" title="">USD $<?=$order_product_row['Price']?></div>
								</div>
							</div>
							<div class="b_100_es">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm"><?=$order_row[$i]['Qty']?></div>
								</div>
							</div>
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm_red">USD $<?=$order_row[$i]['TotalPrice']?></div>
								</div>
							</div>
							<div class="b_100_eq">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm"><?=$status_price?></div>
								</div>
							</div>
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div class="b_txt_sm1">
										<div><a href="/supplier/clear.php?OrderId=<?=$order_row[$i]['OrderId']?>&MemberId=<?=$MemberId?>"><?=$website_language['user_orders'.$lang]['ljys']?></a></div><br>
										<div><a href="/user.php?module=orders_date&OId=<?=$order_row[$i]['OId']?>"><?=$website_language['user_orders'.$lang]['ddxq']?></a></div>
									</div>
								</div>
							</div>
						</div>	
					<?php }?>
				</div>
				<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "/user.php?module=orders&act=3&page=", $row_count, '〈', '〉');?></div>
				<input type="submit" name="" style="display: none;" value="">
			</div>
			</form>
			
	</div>

	</div>
</div> 
</div>
<?php }elseif($_GET['act'] == '4'){ ?>
<div class="mask">
	<div class="box">
		<div  class="header"><?=$website_language['user_index'.$lang]['grzx']?></div>
		<ul class="y_list">
			<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
			<?php if($IsSupplier != '1'){?>
				<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s2'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
				<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s1'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
				<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
				<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
				<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s1'><?=$website_language['user_index'.$lang]['shdz']?></a></li>
			<?php }?>
		</ul>
		<div class="yx">
			<div class="title">
				<div class="title1"><?=$website_language['user_index'.$lang]['wddd']?></div>
				<div class="title2"></div>
				<div class="title3"></div>
			</div>
			<div class="yhh">
				<div class="dianji_list">
					<a data='1' class=" dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=1&mode=all"><?=$website_language['user_orders'.$lang]['qbdd']?></a>
					<a data='2' class="dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=2&mode=wait"><?=$website_language['user_orders'.$lang]['dfk']?></a>
					<a data='3' class="dianji" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=3&mode=already"><?=$website_language['user_orders'.$lang]['yfk']?></a>
					<a data='4' class="dianji dianji_c" style="display: block;float: left;text-decoration:none;color:#303030;" href="/user.php?module=orders&act=4&mode=over"><?=$website_language['user_orders'.$lang]['ywc']?></a>
				</div>
				<div class="dianji_list2">
					<input type="text" class="yct" placeholder="<?=$website_language['user_orders'.$lang]['qsrddh']?>">
					<input type="button" class="ycb" value="<?=$website_language['user_orders'.$lang]['ss']?>">
				</div>
				<div class="ds_list ds_list_b" data='1'>
					<div class="bbg1">
						<div class="content_title">				
							<div class="a_380"><?=$website_language['user_orders'.$lang]['cpxx']?></div>
							<div class="a_100"><?=$website_language['user_orders'.$lang]['dj']?></div>
							<div class="a_80"><?=$website_language['user_orders'.$lang]['sl']?></div>
							<div class="a_100"><?=$website_language['user_orders'.$lang]['zj']?></div>
							<div class="a_100_es"><?=$website_language['user_orders'.$lang]['jyzt']?></div>
							<div class="a_100"><?=$website_language['user_orders'.$lang]['cz']?></div>
						</div>
						<?php 
							for ($i=0; $i < count($order_row); $i++) { 
								$OrderId = $order_row[$i]['OrderId'];
								$order_product_row = $db->get_one('orders_product_list',"OrderId='$OrderId'");
								$PaymentStatus = $order_row[$i]['PaymentStatus'];
							if($order_row[$i]['OrderStatus'] == '2'){
								$status_price = $website_language['user_orders'.$lang]['yfk'];
							}elseif($order_row[$i]['OrderStatus'] == '1'){
								$status_price = $website_language['user_orders'.$lang]['dfk'];
							}elseif($order_row[$i]['OrderStatus'] > '2' && $order_row[$i]['OrderStatus'] < '8'){
								$status_price = $website_language['supplier_m_order'.$lang]['ysz'];
							}elseif( $order_row[$i]['OrderStatus'] == '8'){
								$status_price = $website_language['user_orders'.$lang]['ywc'];
							}

						?>
							<div class="content_waiwei">
								<div class="content_title">
									<span><?=$website_language['user_orders'.$lang]['ddh']?>：</span>
									<span><?=$order_row[$i]['OId']?></span>&nbsp;&nbsp;
									<span><?=date("Y-m-d H:i:s",$order_row[$i]['OrderTime'])?></span>
								</div>
								<div class="b_380"><a href="/supplier/goods.php?ProId=<?=$order_product_row['ProId']?>&SupplierId=<?=$order_product_row['SupplierId']?>">
									<div class="b_img">
											<img src="<?=$order_product_row['PicPath']?>" alt="">
									</div>
									<div class="b_txt_mask">
										<div class="b_txt" title="<?=$order_product_row['Name'.$lang]?>"><?=$order_product_row['Name'.$lang]?></div>
									</div></a>
								</div>
								<div class="b_100">
									<div class="b_txt_sm_mask">
										<div class="b_txt_sm" title="">USD $<?=$order_product_row['Price']?></div>
									</div>
								</div>
								<div class="b_100_es">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm"><?=$order_row[$i]['Qty']?></div>
								</div>
							</div>
							<div class="b_100">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm_red">USD $<?=$order_row[$i]['TotalPrice']?></div>
								</div>
							</div>
							<div class="b_100_eq">
								<div class="b_txt_sm_mask">
									<div title="" class="b_txt_sm"><?=$status_price?></div>
								</div>
							</div>
								<div class="b_100">
									<div class="b_txt_sm_mask">
										<div class="b_txt_sm1">
											<div><a href=""><?=$website_language['user_orders'.$lang]['ljpl']?></a></div><br>
											<div><a href="/user.php?module=orders_date&OId=<?=$order_row[$i]['OId']?>"><?=$website_language['user_orders'.$lang]['ddxq']?></a></div>
										</div>
									</div>
								</div>
							</div>	
						<?php }?>
					</div>
					<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "/user.php?module=orders&act=4&page=", $row_count, '〈', '〉');?></div>
					<input type="submit" name="" style="display: none;" value="">
				</div>
				</form>
			</div>
		</div>
	</div> 
</div>
<?php }?>

<script>
	$('.dianji_list').find('a').click(function(){
			var ds=$(this).attr('data');
			$('.yhh').find('.ds_list').removeClass('ds_list_b');
			$('.yhh').find('.ds_list').each(function(){
				var dsa=$(this).attr('data');
				if(dsa==ds){
					$(this).addClass('ds_list_b');
				}else{
					$(this).addClass('ds_list_n');
				}
			})
			$('.dianji_list').find('a').removeClass('dianji_c');
			$(this).addClass('dianji_c');

		})
</script>

<script>
	$('.y').click(function(){
			$('.title1').text(''+$(this).find('.s1').text()+'');
			$('.title2').text('');
			$('.title3').text('');
		})
</script>
