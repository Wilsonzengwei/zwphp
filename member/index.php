<?php
	include('../inc/include.php');
	include('../inc/common/header.php');
?>

<link rel="stylesheet" href="/css/member2/index.css">
<div class="index_box">
	<div class="index_logo"></div>
	<div class="index_search">
	<form action="">
		<input class="search_input" placeholder='输入产品名称' style="" type="text">	
		<input class="search_submit" type="button"  value="搜索">
	</form>		
	</div>		
</div>
<?php if($_GET['act'] == '1'){?>
<div class="tt">
	<div class="ttt" style="">
		<div class="tesh">
			<a class="test" href="/supplier_manage/index.php?act=1">首页</a>
		</div>		
		<div class="tes">
			<a class="test" href="/supplier_manage/index.php?act=2">所有产品</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier_manage/index.php?act=3">关于我们</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier_manage/index.php?act=4">联系我们</a>
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
					<li data="<?=$i?>"></li>	
					<li data="<?=$i?>"></li>									
				</div>				
				<a href="<?=$ad_1['Url_'.$i] ? $ad_1['Url_'.$i] : 'javascript:;'; ?>" target="_blank">
					<img src="/images/2.jpg" data="<?=$i?>">
				</a>
				<a href="<?=$ad_1['Url_'.$i] ? $ad_1['Url_'.$i] : 'javascript:;'; ?>" target="_blank">
					<img src="/images/2.jpg" data="<?=$i?>">
				</a>
			</div>		
			<div class="tss">
				<div class="ts1">优惠活动</div>
				<div class="ts2">
					<div class="ts2_1">
						<img src="/images/business/1.png" alt="">
					</div>
					<div class="ts3">
						<div class="ts3_1" title='适用于iPhone X的PZOZ豪华硬 壳适用于苹果10保护性超薄......' style="">适用于iPhone X的PZOZ豪华硬 壳适用于苹果10保护性超薄......</div>
						<div class="ts3_2" title='US $42.00'>US $42.00</div>
					</div>
				</div>
								
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
			<div class="selling_content">
				<div class="selling_center">
					<a href='<?=$url?>' class="selling_img">
						<img src="/images/business/1.png" alt="">
					</a>
					<div class="Commodity_price"><a href="<?=$url?>">1</a></div>
					<div class="Commodity_name"><a href="<?=$url?>">2</a></div>
				</div>				
			</div>	
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
			<a class="test" href="/supplier_manage/index.php?act=1">首页</a>
		</div>		
		<div class="tesh">
			<a class="test" href="/supplier_manage/index.php?act=2">所有产品</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier_manage/index.php?act=3">关于我们</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier_manage/index.php?act=4">联系我们</a>
		</div>
	</div>  
</div>
	<div class="mask">
		<div class="gable">
			<div class="gable1_1">
				<form action="">
					<div class="gable1_2">价格区间：</div>
					<div class="gable1_3">
						<input class="gable1_4" type="text" placeholder="min">
						<span>-</span>
						<input class="gable1_5" type="text" placeholder="max">
						<input class="gable1_6" type="button" value="确定">
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
						<div class="selling_content">
							<div class="selling_center">
								<a href='<?=$url?>' class="selling_img">
									<img src="/images/business/1.png" alt="">
								</a>
								<div class="Commodity_price"><a href="<?=$url?>">1</a></div>
								<div class="Commodity_name"><a href="<?=$url?>">2</a></div>
							</div>				
						</div>	
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
			<a class="test" href="/supplier_manage/index.php?act=1">首页</a>
		</div>		
		<div class="tes">
			<a class="test" href="/supplier_manage/index.php?act=2">所有产品</a>
		</div>
		<div class="tesh">
			<a class="test"  href="/supplier_manage/index.php?act=3">关于我们</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier_manage/index.php?act=4">联系我们</a>
		</div>
	</div>  
</div>
<div class="mask">
	<div class="gable">3</div>
</div>
<?php }elseif($_GET['act'] == '4'){?>
<div class="tt">
	<div class="ttt" style="">
		<div class="tes">
			<a class="test" href="/supplier_manage/index.php?act=1">首页</a>
		</div>		
		<div class="tes">
			<a class="test" href="/supplier_manage/index.php?act=2">所有产品</a>
		</div>
		<div class="tes">
			<a class="test"  href="/supplier_manage/index.php?act=3">关于我们</a>
		</div>
		<div class="tesh">
			<a class="test"  href="/supplier_manage/index.php?act=4">联系我们</a>
		</div>
	</div>  
</div>
<div class="mask">
	<div class="gable">4</div>
</div>
<?php }?>	
<?php
	include('../inc/common/footer.php');
?>