<?php
include('../inc/include.php');
$supplierid = $_GET['SupplierId'];
$IsSupplier = $_SESSION['IsSupplier'];
$act=$_GET['act'];
$page=$_GET['page'];
$min=$_GET['min'];
$max=$_GET['max'];
$mode=$_GET['mode'];
$products_name=$_GET['products_name'];
//if($supplierid){
	$member_row = $db->get_one("member","MemberId='$supplierid'");
	$ad_row = $db->get_one("ad","Num=1 and SupplierId='$supplierid'");
	$product_time_row = $db->get_limit("product","SupplierId='$supplierid' and IsUse=2 and Del=1",'*',"AccTime desc",'0','4');
	$product_new_row = $db->get_limit("product","SupplierId='$supplierid' and IsUse=2 and Del=1",'*',"AccTime desc",'0','20');
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
<?php 
	echo '<link rel="stylesheet" href="/css/member2/member_admin'.$lang.'.css">'
?>

<div class="index_box">
	<div class="index_logo1">
		<img style="width:210px;height:60px;" src="<?=$member_row['LogoPath'] != '' ? $member_row['LogoPath'] : '/images/supplier.png';?>">

	</div>
	<div class="index_search">
	<form action="">
		<input class="search_input" placeholder='<?=$website_language['header'.$lang]['qsrspmc']?>' name="products_name" style="" type="text" value="<?=$products_name?>">	
		<input class="search_submit" type="submit"  value="<?=$website_language['header'.$lang]['ss']?>">
		<input type="hidden" name="act" value="2">
		<input type="hidden" name="SupplierId" value="<?=$supplierid?>">
		<input type="hidden" name="page" value="<?=$page?>">
		<input type="hidden" name="min" value="<?=$min?>">
		<input type="hidden" name="max" value="<?=$max?>">
		<input type="hidden" name="mode" value="<?=$mode?>">
	</form>		
	</div>		
</div>
<?php if($_GET['act'] == '1'){?>
<div class="tt">
	<div class="ttt" style="">
		<div class="tesh">
			<a class="test" href="/member_admin/index.php?act=1&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['sy']?></a>
		</div>		
		<div class="tes">
			<a class="test" href="/member_admin/index.php?act=2&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['qbcp']?></a>
		</div>
		<!-- <div class="tes">
			<a class="test"  href="/member_admin/index.php?act=3&Num=1&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['gywm']?></a>
		</div>
		<div class="tes">
			<a class="test"  href="/member_admin/index.php?act=4&Num=2&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['lxwm']?></a>
		</div> -->
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
					if(!is_file($site_root_path.$ad_row['PicPath_0']) && !is_file($site_root_path.$ad_row['PicPath_1']) && !is_file($site_root_path.$ad_row['PicPath_2']) && !is_file($site_root_path.$ad_row['PicPath_3']) && !is_file($site_root_path.$ad_row['PicPath_4'])){
				?>
					<img src="/images/member_admin.png" >
				<?php }else{ ?>
					<?php 
						for ($i=0; $i < count($ad_row); $i++) { 
							if(!is_file($site_root_path.$ad_row['PicPath_'.$i]))continue;
					?>			
					<a href="<?=$ad_row['Url_'.$i] ? $ad_row['Url_'.$i] : 'javascript:;'; ?>" target="_blank">
						<img src="<?=$ad_row['PicPath_'.$i]?>" data="<?=$i?>">
					</a>
					<?php }?>
				<?php }?>
			</div>		
			<div class="tss">
				<div class="ts1"><?=$website_language['member_admin'.$lang]['yhhd']?></div>
				<?php 
					for ($i=0; $i < count($product_time_row); $i++) { 
						$name = $product_time_row[$i]['Name'.$lang];
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
					
						<div class="ts3_1" title='<?=$name?>' style=""><a href="<?=$url?>"><?=$name?></a><i class='slh'></i></div>
						<div class="ts3_2" title='USD $42.00'><a href="<?=$url?>">USD $<?=$price?></a></div>
				
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

			$name = $product_new_row[$i]['Name'.$lang];
			$desc = $product_new_row[$i]['BriefDescription'.$lang];
			$url = get_url('product',$product_new_row[$i]);
			$img = $product_new_row[$i]['PicPath_0'];
			$price = $product_new_row[$i]['Price_1'];
			$ProId = $product_new_row[$i]['ProId'];
		?>	
			<div class="selling_content">
				<div data='<?=$ProId?>' class="selling_center">
					<a href='<?=$url?>' class="selling_img">
						<img src="<?=$img?>" alt="">
					</a>
					<a class="Commodity_pricea" href="<?=$url?>"><div class="Commodity_price">USD $<?=$price?></div></a>
					<a class="Commodity_namea" href="<?=$url?>"><div class="Commodity_name"><?=$name?></div><i class='slh'></i></a>
				</div>				
			</div>
		<?php }?>
		</div>
	</div>
	<form action="products.php?CateId=<?=$CateId?>" method="post">
		<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "products.php?CateId=".$CateId."&page=", $row_count, '〈', '〉');?></div>
	</form>
</div>
<script>
			var d=1;      
   			var email ="<?=$_SESSION['UserName']; ?>";
		    $(".selling_center").click(function(){  		  		           	
            var c=$(this).attr("data");            
    
				$.ajax({
	         	type:"get",
	         	url:"/getGoodId.php",
	         	data:{
	         		act:'index',
	         		getProId:c,
	         		cishu:d,
	         		email:email,
	         	},
	         	success:function(data){	          	
	         		
	         	},
	         	error:function(){
	        	 	
	         	}
	         })					
		}) 
	$('.ts3_1').each(function(){
		var a=$(this).find('a').css('height');
		if(a>'32px'){
			$(this).find('.slh').css('display','block');
		}else{
			$(this).find('.slh').css('display','none');
		}
	})
	$('.Commodity_namea').each(function(){
		var he=$(this).find('.Commodity_name').css('height');
		if(he>'32px'){
			$(this).find('.slh').css('display','block');
		}else{
			$(this).find('.slh').css('display','none');
		}
	})
</script>
<?php }elseif($_GET['act'] == '2'){?>
<div class="tt">
	<div class="ttt" style="">
		<div class="tes">
			<a class="test" href="/member_admin/index.php?act=1&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['sy']?></a>
		</div>		
		<div class="tesh">
			<a class="test" href="/member_admin/index.php?act=2&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['qbcp']?></a>
		</div>
		<!-- <div class="tes">
			<a class="test"  href="/member_admin/index.php?act=3&Num=1&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['gywm']?></a>
		</div>
		<div class="tes">
			<a class="test"  href="/member_admin/index.php?act=4&Num=2&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['lxwm']?></a>
		</div> -->
	</div>  
</div>
	<div class="mask">
		<div class="gable">
			<div class="mask2">
				<div class="gable1_1">
				<form action="" method="get">
					<div class="gable1_2"><?=$website_language['products'.$lang]['jgqj']?>：</div>
					<div class="gable1_3">
						<input class="gable1_4" type="text" placeholder="min" name="min" value="<?=$min?>">
						<span>-</span>
						<input class="gable1_5" type="text" placeholder="max" name="max" value="<?=$max?>">
						<input type="hidden" name="act" value="2">
						<input class="gable1_6" type="submit" value="<?=$website_language['products'.$lang]['qd']?>">
						<input type="hidden" name="SupplierId" value="<?=$supplierid?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="products_name" value="<?=$products_name?>">
						
					</div>
				</form>												
			</div>			
			<div class="ac1">
			<div class="f_14">
				<form action="">
					<div class="paixufs"><?=$website_language['products'.$lang]['pxfs']?>：</div>
					<div class="hie">
						<a data='1' class="hie_list hie_list_color" href="/member_admin/index.php?act=2&mode=new&SupplierId=<?=$supplierid?>&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&products_name=<?=$products_name?>"><?=$website_language['products'.$lang]['zx']?></a>
						<a data='2' class="hie_list" href="/member_admin/index.php?act=2&mode=Selling&SupplierId=<?=$supplierid?>&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&products_name=<?=$products_name?>"><?=$website_language['products'.$lang]['zr']?></a>
						<?php 
							if($_GET['mode'] == 'Price_desc'){
						?>
							<a data='3' class="hie_list jiage" href="/member_admin/index.php?act=2&mode=Price_asc&SupplierId=<?=$supplierid?>&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&products_name=<?=$products_name?>"><?=$website_language['products'.$lang]['jgsx']?></a>&nbsp;<span class='ccc'><img src="/images/products/jiage01.png" alt=""></span>
						<?php }elseif($_GET['mode'] == 'Price_asc'){?>
							<a data='3' class="hie_list jiage" href="/member_admin/index.php?act=2&mode=Price_desc&SupplierId=<?=$supplierid?>&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&products_name=<?=$products_name?>"><?=$website_language['products'.$lang]['jgjx']?></a>&nbsp;<span class='ccc'><img src="/images/products/jiage02.png" alt=""></span>
						<?php }else{?>
							<a data='3' class="hie_list jiage" href="/member_admin/index.php?act=2&mode=Price_desc&SupplierId=<?=$supplierid?>&page=<?=$page?>&min=<?=$min?>&max=<?=$max?>&products_name=<?=$products_name?>"><?=$website_language['products'.$lang]['jgjx']?></a>&nbsp;<span class='ccc'><img src="/images/products/jiage00.png" alt=""></span>
						<?php }?>
					</div>
				</form>
			</div>
			</div>
			</div>
			
			<script>
			
				var vg=window.sessionStorage.getItem('jiage');
				// var jg="<?=$website_language['products'.$lang]['jgsx']?>";
				/*if(vg=='1'){
					$('.jiage').text('价格升序');
					$('.ccc').css('background','url(/images/products/jiage01.png) no-repeat center');
				}else if(vg=='2'){
					$('.jiage').text('价格降序');
					$('.ccc').css('background','url(/images/products/jiage02.png) no-repeat center');
				// }*/
				// $('.jiage').click(function(){
				// 	var v=$(this).text();	
				// 	if(v=='jg'){			
				// 		window.sessionStorage.setItem('jiage','2');		
				// 	}else{			
				// 		window.sessionStorage.setItem('jiage','1');
				// 	}
				// })
				var dsg=window.sessionStorage.getItem('dss');
				var cc=$('.hie_list').attr('data');
				if(dsg=='1'){
					$('.hie_list').each(function(){
						var cs=$(this).attr('data');
						if(cs=='1'){
							$('.hie_list').removeClass('hie_list_color');
							$(this).addClass('hie_list_color');
						}
					})
				}else if(dsg=='2'){
					$('.hie_list').each(function(){
						var cs=$(this).attr('data');
						if(cs=='2'){
							$('.hie_list').removeClass('hie_list_color');
							$(this).addClass('hie_list_color');
						}
					})
				}else if(dsg=='3'){
					$('.hie_list').each(function(){
						var cs=$(this).attr('data');
						if(cs=='3'){
							$('.hie_list').removeClass('hie_list_color');
							$(this).addClass('hie_list_color');
						}
					})
				}
				$('.hie_list').click(function(){
					var ds=$(this).attr('data');	
					window.sessionStorage.setItem('dss',ds);
				})
			</script>							
			

				<div class="mask">
				
						<div class="selling">	
							<div class="selling_bg">
							<?php

								$where = "SupplierId='$supplierid' and IsUse=2 and Del=1";
								if($_GET['products_name']){
									$products_name = $_GET['products_name'];
									$where .= " and Name".$lang." like '%$products_name%'";
								}
								$orderby = "AccTime desc";
								if($_GET['mode'] == "new"){
									$orderby = "AccTime desc";
								}elseif($_GET['mode'] == "Selling"){

								}elseif($_GET['mode'] == "Price_desc"){
									$orderby = "Price_1 asc";
								}elseif($_GET['mode'] == "Price_asc"){
									$orderby = "Price_1 desc";
								}
								$min_price = (float)$_GET['min'];
								$max_price = (float)$_GET['max'];
								$max_price || $min_price && $where.=" and Price_1 >'$min_price'";
								$min_price || $max_price && $where.=" and Price_1 <'$max_price'";
								$min_price && $max_price && $where.=" and Price_1 >'$min_price' and Price_1 < '$max_price'";

								//var_dump($max);exit;
								$page_count = 25; //显示数量
								$row_count=$db->get_row_count('product', $where);
								$total_pages=ceil($row_count/$page_count);
								$page=(int)$_GET['page'];
								$page<1 && $page=1;
								$page>$total_pages && $page=1;
								$start_row=($page-1)*$page_count;
								$product_num_row = $db->get_limit("product",$where,'*',$orderby,'0',$page_count);
								?>
							<?php if($product_num_row){ ?>
							<?php 
								for ($i=0; $i < count($product_num_row); $i++) { 
									$name = $product_num_row[$i]['Name'.$lang];
									$desc = $product_num_row[$i]['BriefDescription'.$lang];
									$url = get_url('product',$product_num_row[$i]);
									$img = $product_num_row[$i]['PicPath_0'];
									$price = $product_num_row[$i]['Price_1'];
									$ProId = $product_num_row[$i]['ProId'];
							?>
								<div class="selling_content">
									<div data='<?=$ProId?>' class="selling_center">
										<a href='<?=$url?>' class="selling_img">
											<img src="<?=$img?>" alt="">
										</a>
										<a class="Commodity_pricea" href="<?=$url?>"><div class="Commodity_price">USD $<?=$price?></div></a>
										<a class="Commodity_namea" href="<?=$url?>"><div class="Commodity_name"><?=$name?></div><i class='slh'></i></a>
									</div>				
								</div>
								<?php }?>
							<?php }else{?>
								<div class="wzd1200">
									<div class="wzd_img">
										<img src="/images/index/weizhaodao.png" alt="">
									</div>
									<div class="wzd1">  没有找到与“<d class="wzd"><?=$products_name?></d>”相关的商品</div>
								</div>
							<?php }?>
							</div>
						</div>
					

				</div>
			<script>
			var d=1;      
   			var email ="<?=$_SESSION['UserName']; ?>";
		    $(".selling_center").click(function(){  		  		           	
            var c=$(this).attr("data");        
				$.ajax({
	         	type:"get",
	         	url:"/getGoodId.php",
	         	data:{
	         		act:'index',
	         		getProId:c,
	         		cishu:d,
	         		email:email,
	         	},
	         	success:function(data){	          	
	         		
	         	},
	         	error:function(){
	        	 	
	         	}
	         })					
		}) 
				$('.Commodity_namea').each(function(){
				var he=$(this).find('.Commodity_name').css('height');
				if(he>'32px'){
					$(this).find('.slh').css('display','block');
				}else{
					$(this).find('.slh').css('display','none');
				}
			})
			</script>


		</div>		
		<form action="products.php?CateId=<?=$CateId?>" method="post">
			<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "index.php?&products_name=".$products_name."&page=".$page."&act=".$act."&min=".$min."&max=".$max."&mode=".$mode."&SupplierId=".$SupplierId."&CateId=".$CateId."&page=", $row_count, '〈', '〉');?></div>
		</form>
	</div>
<?php }elseif($_GET['act'] == '3'){?>

<div class="tt">
	<div class="ttt" style="">
		<div class="tes">
			<a class="test" href="/member_admin/index.php?act=1&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['sy']?></a>
		</div>		
		<div class="tes">
			<a class="test" href="/member_admin/index.php?act=2&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['qbcp']?></a>
		</div>
	<!-- 	<div class="tesh">
			<a class="test"  href="/member_admin/index.php?act=3&Num=1&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['gywm']?></a>
		</div>
		<div class="tes">
			<a class="test"  href="/member_admin/index.php?act=4&Num=2&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['lxwm']?></a>
		</div> -->
	</div>  
</div>
<div class="mask" style="min-height: 350px;">
<?php 
//var_dump($member_related);exit;
?>
	<div class="gable"><?=$member_related['Contents'.$lang]?></div>
</div>
<?php }elseif($_GET['act'] == '4'){?>
<div class="tt">
	<div class="ttt" style="">
		<div class="tes">
			<a class="test" href="/member_admin/index.php?act=1&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['sy']?></a>
		</div>		
		<div class="tes">
			<a class="test" href="/member_admin/index.php?act=2&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['qbcp']?></a>
		</div>
		<!-- <div class="tes">
			<a class="test"  href="/member_admin/index.php?act=3&Num=1&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['gywm']?></a>
		</div>
		<div class="tesh">
			<a class="test"  href="/member_admin/index.php?act=4&Num=2&SupplierId=<?=$supplierid?>"><?=$website_language['member_admin'.$lang]['lxwm']?></a>
		</div> -->
	</div>  
</div>
<div class="mask" style="min-height: 350px;">
	<div class="gable"><?=$member_related['Contents'.$lang]?></div>
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
