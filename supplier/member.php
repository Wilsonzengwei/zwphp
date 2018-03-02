<?php
include('../inc/include.php');
$supplierid = $_SESSION['member_MemberId'];
$IsSupplier = $_SESSION['IsSupplier'];
//if($supplierid){
	$member_row = $db->get_one("member","MemberId='$supplierid'");
	$ad_row = $db->get_one("ad","Num=1 and SupplierId='$supplierid'");
	$product_time_row = $db->get_limit("product","SupplierId='$supplierid'",'*',"AccTime desc",'0','4');
	$product_new_row = $db->get_limit("product","SupplierId='$supplierid'",'*',"AccTime desc",'0','20');
	//var_dump($product_new_row);exit;
if($_GET['Num'] ){
	$Num = $_GET['Num']; 
	//var_dump($Num);exit;
	$member_related = $ad_row = $db->get_one("article","SupplierId='$supplierid' and Num='$Num' ");
}
	
	//var_dump($ad_row);exit;
	include('../inc/common/header.php');

?>
<script>
	$(function(){
		$('.selling_bg').each(function(){
			$(this).children("div:eq(4)").css('margin-right','0px');
			$(this).children("div:eq(9)").css('margin-right','0px');
			$(this).children("div:eq(14)").css('margin-right','0px');
			$(this).children("div:eq(19)").css('margin-right','0px');
			$(this).children("div:eq(24)").css('margin-right','0px');
		})
	})	
</script>
<link rel="stylesheet" href="/css/supplier/member.css">
<div class="index_box">
	<div class="index_logo"></div>
	<div class="index_search">
	<form action="">
		<input class="search_input" placeholder='请输入商品品名称' style="" type="text">	
		<input class="search_submit" type="button"  value="搜索">
	</form>		
	</div>		
</div>
<?php if($_GET['act'] == '1'){?>
<div class="tt">
	<div class="ttt" style="">
		<div class="tesh">
			<a class="test" href="/supplier/index.php?act=1">首页</a>
		</div>		
		<div class="tes">
			<a class="test" href="/supplier/index.php?act=2">所有产品</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier/index.php?act=3&Num=1">关于我们</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier/index.php?act=4&Num=2">联系我们</a>
		</div>
	</div>  
</div>

<script src='../js/businessaction.js'></script>
<div class="mask">
	<div class="content-top">
	<div class="content-center">
		<div class="center-center">
			<div id="center-img" class="center-img">
				<span class="center_prev" id="center_prev"></span>
				<span class="center_next" id="center_next"></span>
				<div class="center-li" id="center-li">
				<?php 
					for ($i=0; $i < count($ad_row); $i++) { 
						if(!is_file($site_root_path.$ad_row['PicPath_'.$i]))continue;
				?>								
					<li data="<?=$i?>"></li>	
				<?php }?>									
				</div>	
				<?php 
					for ($i=0; $i < count($ad_row); $i++) { 
						if(!is_file($site_root_path.$ad_row['PicPath_'.$i]))continue;
				?>			
				<a href="<?=$ad_row['Url_'.$i] ? $ad_row['Url_'.$i] : 'javascript:;'; ?>" target="_blank">
					<img src="<?=$ad_row['PicPath_'.$i]?>" data="<?=$i?>">
				</a>
				<?php }?>
			</div>		
			<div class="tss">
				<div class="ts1">优惠活动</div>
				<?php 
					for ($i=0; $i < count($product_time_row); $i++) { 
						$name = $product_time_row[$i]['Name_lang_1'];
						$desc = $product_time_row[$i]['BriefDescription'.$lang];
						$url = get_url('product',$product_time_row[$i]);
						$img = $product_time_row[$i]['PicPath_0'];
						$price = $product_time_row[$i]['Price_1'];
						$ProId = $product_time_row[$i]['ProId'];
				?>
				<div class="ts2">
				
					<div class="ts2_1">
						<a href="<?=$url?>"><img class="ts2_img" src="<?=$img?>" alt=""></a>
					</div>
					<div class="ts3">
					
						<div class="ts3_1" title='<?=$name?>' style=""><a href="<?=$url?>"><?=$name?></a></div>
						<div class="ts3_2" title='US $42.00'><a href="<?=$url?>">USD <?=$price?></a></div>
				
					</div>
				</div>
				<?php }?>
								
			</div>
		</div>		
	</div>		
</div>
</div>

<div class="mask">
	<div class="sm_img"><img src="/images/index/xiaotu.jpg" alt=""></div>
</div>

<div class="mask">
	<div class="selling">	
		<div class="selling_bg">
		<?php 
		for ($i=0; $i < count($product_new_row); $i++) {

			$name = $product_new_row[$i]['Name_lang_1'];
			$desc = $product_new_row[$i]['BriefDescription'.$lang];
			$url = get_url('product',$product_new_row[$i]);
			$img = $product_new_row[$i]['PicPath_0'];
			$price = $product_new_row[$i]['Price_1'];
			$ProId = $product_new_row[$i]['ProId'];
		?>	
			<div class="selling_content">
				<div class="selling_center">
					<a href='<?=$url?>' class="selling_img">
						<img src="<?=$img?>" alt="">
					</a>
					<div class="Commodity_price"><a href="<?=$url?>"><?=$price?></a></div>
					<div class="Commodity_name"><a href="<?=$url?>"><?=$name?></a></div>
				</div>				
			</div>	
		<?php }?>
		</div>
	</div>
	<form action="products.php?CateId=<?=$CateId?>" method="post">
		<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "products.php?CateId=".$CateId."&page=", $row_count, '〈', '〉');?></div>
	</form>
</div>

<?php }elseif($_GET['act'] == '2'){?>
<div class="tt">
	<div class="ttt" style="">
		<div class="tes">
			<a class="test" href="/supplier/index.php?act=1">首页</a>
		</div>		
		<div class="tesh">
			<a class="test" href="/supplier/index.php?act=2">所有产品</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier/index.php?act=3&Num=1">关于我们</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier/index.php?act=4&Num=2">联系我们</a>
		</div>
	</div>  
</div>
	<div class="mask">
		<div class="gable">
			<div class="gable1_1">
				<form action="/supplier/index.php?act=2" method="post">
					<div class="gable1_2">价格区间：</div>
					<div class="gable1_3">
						<input class="gable1_4" type="text" placeholder="min" name="min_price">
						<span>-</span>
						<input class="gable1_5" type="text" placeholder="max" name="max_price">
						<input class="gable1_6" type="submit" value="确定">
					</div>
				</form>												
			</div>
			<div style="width:1200px;height:40px;position:relative;margin-left:30px">
				<div style="font-size:14px">
					<form action="">
						<div class="gable1_2">派序方式：</div>
						<div class="gable1_3_1">
							<a class="gbs" href="products.php?CateId=<?=$CateId?>&act=new">最新</a>
							<a class="gbs" href="products.php?CateId=<?=$CateId?>&act=Selling">最热</a>
							<a class="gbs" href="products.php?CateId=<?=$CateId?>&act=Price_desc"><span>价格<img class="gbs_img" alt=""></span></a>
						</div>
					</form>
				</div>							
			</div>


				<div class="mask">
				
						<div class="selling">	
							<div class="selling_bg">
							<?php
								$where = "SupplierId=$supplierid";
								if($_POST['min_price'] && $_POST['max_price']){

									$min = $_POST['min_price'];
									$max = $_POST['max_price'];
									
									$where .= " and Price_1 BETWEEN '$min' and '$max'";
									 
								}
								//var_dump($max);exit;
								$page_count = 25; //显示数量
								$row_count=$db->get_row_count('product', $where);
								$total_pages=ceil($row_count/$page_count);
								$page=(int)$_GET['page'];
								$page<1 && $page=1;
								$page>$total_pages && $page=1;
								$start_row=($page-1)*$page_count;
								$product_num_row = $db->get_limit("product",$where,'*',"AccTime desc",'0',$page_count);
								for ($i=0; $i < count($product_num_row); $i++) { 
									$name = $product_num_row[$i]['Name_lang_1'];
									$desc = $product_num_row[$i]['BriefDescription'.$lang];
									$url = get_url('product',$product_num_row[$i]);
									$img = $product_num_row[$i]['PicPath_0'];
									$price = $product_num_row[$i]['Price_1'];
									$ProId = $product_num_row[$i]['ProId'];
							?>
								<div class="selling_content">
									<div class="selling_center">
										<a href='<?=$url?>' class="selling_img">
											<img src="<?=$img?>" alt="">
										</a>
										<div class="Commodity_price"><a href="<?=$url?>"><?=$price?></a></div>
										<div class="Commodity_name"><a href="<?=$url?>"><?=$name?></a></div>
									</div>				
								</div>	
								<?php }?>
							</div>
						</div>
					

				</div>
			


		</div>		
		<form action="products.php?CateId=<?=$CateId?>" method="post">
			<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "products.php?CateId=".$CateId."&page=", $row_count, '〈', '〉');?></div>
		</form>
	</div>
<?php }elseif($_GET['act'] == '3'){?>

<div class="tt">
	<div class="ttt" style="">
		<div class="tes">
			<a class="test" href="/supplier/index.php?act=1">首页</a>
		</div>		
		<div class="tes">
			<a class="test" href="/supplier/index.php?act=2">所有产品</a>
		</div>
		<div class="tesh">
			<a class="test"  href="/supplier/index.php?act=3&Num=1">关于我们</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier/index.php?act=4&Num=2">联系我们</a>
		</div>
	</div>  
</div>
<div class="mask" style="min-height: 350px;">
<?php 
//var_dump($member_related);exit;
?>
	<div class="gable"><?=$member_related['Contents_lang_1']?></div>
</div>
<?php }elseif($_GET['act'] == '4'){?>
<div class="tt">
	<div class="ttt" style="">
		<div class="tes">
			<a class="test" href="/supplier/index.php?act=1">首页</a>
		</div>		
		<div class="tes">
			<a class="test" href="/supplier/index.php?act=2">所有产品</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier/index.php?act=3&Num=1">关于我们</a>
		</div>
		<div class="tesh">
			<a class="test"  href="/supplier/index.php?act=4&Num=2">联系我们</a>
		</div>
	</div>  
</div>
<div class="mask" style="min-height: 350px;">
	<div class="gable"><?=$member_related['Contents_lang_1']?></div>
</div>
<?php }?>	
<?php
	include('../inc/common/footer.php');
  
?>
<?php
/*}else{
	echo '<script>alert("登入后才能访问");</script>';
		header("Refresh:0;url=/account.php?module=login");
		//history.go(-1)禁止提交
		exit;
	}*/
?>
