<?php
/*if($_SESSION['IsSupplier'] !== '1'){
  
    echo '<script>alert("只有商户才能访问");</script>';
    header("Refresh:0;url=/");
    exit;
}*/
$SupplierId = $_SESSION['member_MemberId'];
$act=(int)$_GET['act'];

$where = "SupplierId='$SupplierId' and Del=1";
$OId=$_GET['OId'];
$OId && $where.=" and OId like '%$OId%'";

$Email=$_GET['Email'];
$Email && $where.=" and Email like '%$Email%'";
$OrderStatus=(int)$_GET['OrderStatus'];
$OrderStatus && $where.=" and OrderStatus='$OrderStatus'";
$row_count=$db->get_row_count('orders', $where);
$total_pages=ceil($row_count/20);
$page=(int)$_GET['page'];
if($_POST['page_input']){
	$page_input = $_POST['page_input'];
	$page = $page_input;
	header("Location: /supplier_manage.php?module=order&page=$page");
	exit;
}
$page<1 && $page=1;
$page>$total_pages && $page=1;

$start_row=($page-1)*get_cfg('orders.page_count');
$order_row = $db->get_limit('orders',$where,'*',"OrderTime desc",$start_row,'20');


?>
<?php 
	echo '<link rel="stylesheet" href="/css/supplier_m/order'.$lang.'.css">'
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
			<div class="title1"><?=$website_language['supplier_m_order'.$lang]['ddgl']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
		<form method="get" action="/supplier_manage.php">
			<div class="yh_ac">
			
				<div class="yh_ac_1"><?=$website_language['supplier_m_order'.$lang]['ddh']?>：<input class="yh_input" type="text" name="OId" id="" value="<?=$OId?>"></div>
				<div class="yh_ac_1"><?=$website_language['supplier_m_order'.$lang]['khyx']?>：<input class="yh_input" type="text" name="Email" value="<?=$Email?>"></div>
				<div class="yh_ac_1"><?=$website_language['supplier_m_order'.$lang]['ddzt']?>：
					<select class="yh_ac_sl2" name="OrderStatus" id="">
					<option value="">选择</option>
					<?php foreach($order_status_ary as $key=>$value){?>
			            <?php 
			                if($key == '2'){
			                    $orders_table_row = $db->get_row_count('orders',"SupplierId='$SupplierId' and OrderStatus='2'")."条";
			                }elseif($key == '3'){
			                    $orders_table_row = $db->get_row_count('orders',"SupplierId='$SupplierId' and OrderStatus='3'")."条";
			                }elseif($key == '7'){
			                    $orders_table_row = $db->get_row_count('orders',"SupplierId='$SupplierId' and OrderStatus='7'")."条";
			                }else{
			                    $orders_table_row = '';
			                }

			            ?>

			            <option value="<?=$key;?>" style="color:;" <?=$OrderStatus == $key ? selected :'';?>><?=$value;?>&nbsp;<span style="color:red;"><?=$orders_table_row;?></option>
			        <?php }?>
					</select>
				</div>
				<input type="hidden" name="act" value="<?=$act?>">	
				
				<input type="hidden" name="module" value="<?=$_GET['module']?>">
				<div class="yh_ac_1"><input type="submit" class="yh_ac_sub" value="<?=$website_language['supplier_m_order'.$lang]['qd']?>"></div>
			</div>
			</form>
			<div class="product_yhh_t">
				<div class="product_yhh_t_1"><?=$website_language['supplier_m_order'.$lang]['xh']?></div>
				<div class="product_yhh_t_2"><?=$website_language['supplier_m_order'.$lang]['ddh']?></div>
				<div class="product_yhh_t_3"><?=$website_language['supplier_m_order'.$lang]['tp']?></div>
				<div class="product_yhh_t_9"><?=$website_language['supplier_m_order'.$lang]['khyx']?></div>
				<div class="product_yhh_t_6"><?=$website_language['supplier_m_order'.$lang]['zj']?></div>				
				<div class="product_yhh_t_6_es"><?=$website_language['supplier_m_order'.$lang]['ddzt']?></div>
				<div class="product_yhh_t_7"><?=$website_language['supplier_m_order'.$lang]['gjr']?></div>
				<div class="product_yhh_t_7"><?=$website_language['supplier_m_order'.$lang]['cjsj']?></div>
				<div class="product_yhh_t_8" style=''><?=$website_language['supplier_m_order'.$lang]['cz']?></div>
			</div>
			<?php
				for ($i=0; $i < count($order_row); $i++) { 

					$OrderId = $order_row[$i]['OrderId'];

					$product_name_1 = $db->get_one('orders_product_list',"OrderId='$OrderId'");
					$ProId = $product_name_1['ProId'];
					$product_name =$product_name_1['Name'.$lang];
					//var_dump($product_name_1);exit;
					
                    $MId = $order_row[$i]['MemberId'];

                    if($order_row[$i]['FollowStatus'] == '1'){
                        $FollowStatus_r = '已跟进';
                    }else{
                        $FollowStatus_r = '未跟进';
                    }


			?>
			<div class="product_yhh_t1">
			
				<div class="product_yhh_t_1"><?=$start_row+$i+1?></div>
				<div class="product_yhh_t_2_es"><?=$order_row[$i]['OId']?></div>
				<div class="product_yhh_t_3"><a href="/supplier/goods.php?ProId=<?=$ProId?>&SupplierId=<?=$SupplierId?>" target="_blank"><img style="width:30px;height:30px;padding:5px 0" src="<?=$product_name_1['PicPath']?>"></a></div>
				<div class="product_yhh_t_9_es"><?=$order_row[$i]['Email']?></div>
				<div class="product_yhh_t_6_ess">USD $<br><?=sprintf('%01.2f', ($order_row[$i]['TotalPrice']+$order_row[$i]['ShippingPrice'])*(1+$order_row[$i]['PayAdditionalFee']/100))?></div>				
				<div class="product_yhh_t_6_es"><?=$order_status_ary[$order_row[$i]['OrderStatus']];?></div>
				<div class="product_yhh_t_7"><?=$order_row[$i]['FollowUp']?></div>
				<div class="product_yhh_t_7"><?=date("Y-m-d H:i:s",$order_row[$i]['OrderTime']);?></div>
				<div class="product_yhh_t_8 operation">
					<a href="/supplier_manage.php?module=order_mod&OId=<?=$order_row[$i]['OId']?>"><?=$website_language['supplier_m_order'.$lang]['xg']?></a>
					<!-- <a href=""><?=$website_language['supplier_m_order'.$lang]['ck']?></a> -->
				</div>
			</div>
			<?php }?>
			<form method="post" action="/supplier_manage.php">
			<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "/supplier_manage.php?module=order&act=".$act."$query_string&page=", $row_count, '〈', '〉');?></div>
			<input type="hidden" name="module" value="<?=$_GET['module']?>">
			</form>
		</div>
	</div>
	</div>
</div>
