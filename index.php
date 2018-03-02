<?php 
include("inc/include.php");
include('inc/set/ext_var.php');

include("inc/common/header.php");
include("inc/common/search_header.php");

?>
<script src="js/index.js"></script>
<script src="js/action.js"></script>
<script language="javascript" src="js/manage.js"></script>
<script type="text/javascript" src="http://pv.sohu.com/cityjson?ie=utf-8"></script> 
<?php 
	echo '<link rel="stylesheet" type="text/css" href="css/index'.$lang.'.css">'
?>
<?php

$page_name = 'index';
$index_time_cou = $db->get_limit('index_time','1','ProductClicks');
$product_new = $db->get_limit("product","IsUse=2 and Del=1","*","AccTime desc",1,10);
$clicks = $db->get_row_count('index_time','1');
$index_time_row = $index_time_cou[$clicks-1];
$time = time();
$index_time = $index_time_row['ProductClicks'];
if($index_time== null){
	$index_time = '0';
}
?>
<div class="mask2">
	<div class="lunbo_box">
	<div class="chanpinleimu"><div class="chanpimg"></div><a class="chanp_a" href=""><?=$website_language['goods'.$lang]['cplm']?></a></div>
	<div class="chanpinleimu_right" style=""><a class="chanp_txt" href="/account.php?module=eaglehome">EAGLE HOME</a></div>
	</div>
</div>
<div class="clear"></div>
<div class="mask">	
	<div class="content-top">	
		<div class="content-center">		
		<div  class="center-center">	
			<div id="center-bg-left" class="center-bg-left">					
				<?php 
					foreach((array)$All_Category_row['0,'] as $k => $v){ 
						
						if($lang == '_en'){
	                    	$name = $v['Category_lang_2'];
	                    }else{
							$name = $v['Category'.$lang];
	                    }
						$vCateId = $v['CateId'];
						$url = get_url('product_category',$v);
						$count_where="(CateId in(select CateId from product_category where UId like '%{$v[UId]}{$vCateId},%') or CateId='{$vCateId}')";
						$logo_ary = $menu_logo_ary1[$k];
				        $logobg = $logo_ary[0];
				        $logocurbg = $logo_ary[1];
						if($name != 'EAGLE HOME'){       
					       
				?>		
							<div class="top_list" bg='<?=$logobg?>' curbg='<?=$logocurbg?>'><div class="y1" style="width:50px;height:36px;float:left;background:url(<?=$logobg?>) center no-repeat"></div><a class="y2" title='<?=$name?>' style="font-size:12px;color:#333;" href="<?=$url; ?>"><?=$name?><i class='slh2'></i></a>
							<?php if($All_Category_row['0,'.$vCateId.',']){ ?>
								
								<span class="sec_list">
									<div class="sec_list_bg">
									<?php
					                    $num=0; 
					                    foreach((array)$All_Category_row['0,'.$vCateId.','] as $k1 => $v1){ 
					                    if($lang == '_en'){
					                    	$name1 = $v1['Category_lang_2'];
					                    }else{
											$name1 = $v1['Category'.$lang];
					                    }
					                    
					                    $v1CateId = $v1['CateId'];
					                    $url1 = get_url('product_category',$v1);
					                    if($num > 8) continue;
					                    if((array)$All_Category_row['0,'.$vCateId.','.$v1CateId.',']){
					                    $num++;
				                    ?>				
										<div class="sec_list_sm">
											<div class="sec_list_sm_div1"><a class="sec_list_sm_div1_a" href="<?=$url1; ?>"><?=$name1?></a><i style="color:#333;font-size:10px;margin-left:20px;position:absolute;top:0px" class="icon iconfont icon-youjiantou"></i></div>							 
											<div class="sec_list_sm_div2">					<?php 
													foreach((array)$All_Category_row['0,'.$vCateId.','.$v1CateId.','] as $k2 => $v2){ 
		                                                   if($lang == '_en'){
										                    	$name2 = $v2['Category_lang_2'];
										                    }else{
																$name2 = $v2['Category'.$lang];
										                    }
		                                                    $v2CateId = $v2['CateId'];
		                                                    $url2 = get_url('product_category',$v2);
                                                  
                                                ?>
												<a class="sec_list_sm_div2_a"  href="<?=$url2; ?>"><?=$name2?></a>		
												<?php }?>				
											</div>								
										</div>
										<?php }}?>				
									</div>
								</span>
							<?php }?>					
							</div>
					<?php }}?>
				
					
							
				<div id="center-img" class="center-img">
					<span class="center_prev" id="center_prev"></span>
					<span class="center_next" id="center_next"></span>
					<div class="center-li" id="center-li">	
					<?php 
						for ($i=0; $i < 5; $i++) { 
							$ad_1 = $db->get_one('ad','AId=1');
		                    if(!is_file($site_root_path.$ad_1['PicPath_'.$i]))continue;
		                
					?>			
						<li data="<?=$i?>"></li>
					<?php }?>					
									
					</div>			
					<?php 
						for ($i=0; $i < 5; $i++) { 
							$ad_1 = $db->get_one('ad','AId=1');
		                    if(!is_file($site_root_path.$ad_1['PicPath_'.$i]))continue;
		                
					?>		
						<a href="<?=$ad_1['Url_'.$i] ? $ad_1['Url_'.$i] : 'javascript:;'; ?>" target="_blank">
							<img src="<?=$ad_1['PicPath_'.$i]?>" data="<?=$i?>">
						</a>
					<?php }?>	
						
						
								
				</div>							
		</div>
	</div>
	</div>
	</div>

</div>
<div class="clear"></div>	
<div class="mask">
<div class="sm_img"><img src="images/index/xiaotu.jpg" alt=""></div>
</div>
<div class="mask">
<div class="brand">
		<div class="brand_bg">
			<i class='bg'></i>
			<span></span>
			<a href="/supplier.php"><?=$website_language['index'.$lang]['gd']?><i class="icon iconfont icon-left"></i></a>			
		</div>
		<div class="hot_pro">	
			<?php
				$where = "IsSupplier=1 and Is_Business_License='1' and IsUse=2";
				$supplier_row = $db->get_limit("member",$where,"*","LogoPath desc, RegTime desc","0","16");
				for ($i=0; $i < count($supplier_row); $i++) {
					$products_set = $db->get_row_count("product","SupplierId=".$supplier_row[$i]['MemberId']." and IsUse=2 and Del=1");
						if($products_set){
					
			?>	
			<div class="hot_pro_bg">
				<div class="hot_pro_bg_top">
					<a href="/member_admin/index.php?SupplierId=<?=$supplier_row[$i]['MemberId']?>&act=1"><img src="<?=$supplier_row[$i]['LogoPath'] ? $supplier_row[$i]['LogoPath'] : '/images/nopacpath.jpg' ;?>" alt=""></a>
				</div>			
			</div>
			<?php }}?>
		</div>
	</div>
	</div>
	<div class="clear"></div>
	<div class="mask">

	<div class="selling">
		<div class="brand_bg">
			<i class='bg'></i>
			<span></span>
			<a href="/products.php?&act=new"><?=$website_language['index'.$lang]['gd']?><i class="icon iconfont icon-left"></i></a>			
		</div>
		<div class="selling_bg">

		<?php 
			$member_row = $db->get_all('member',"IsSupplier=1 and IsUse=2","MemberId");
			for ($j=0; $j < count($member_row); $j++) { 
				$product_id = $db->get_limit('product',"SupplierId=".$member_row[$j]['MemberId']." and IsUse=2 and Del=1","ProId","AccTime desc",0,'1');
				for ($k=0; $k <count($product_id) ; $k++) { 
					$product_id_row[] = $product_id[0]['ProId'];
				}
			}
			if($product_id_row){
			$productid = implode(',', $product_id_row);
			//var_dump($productid);exit;
			$ind_hot_product_row = $db->get_limit('product',"ProId in ($productid)",'*','AccTime desc',0,10);
			foreach((array)$ind_hot_product_row  as $k => $v){ 
			$name = $v['Name'.$lang];
			$desc = $v['BriefDescription'.$lang];
			$url = get_url('product',$v);
			$img = $v['PicPath_0'];
			$price = $v['Price_1'];
			$ProId = $v['ProId'];
		?>
			<div class="selling_content">
				<div data="<?=$ProId?>" class="selling_center">
					<a  href='<?=$url?>' class="selling_img">
						<img src="<?=$img?>" alt="">
					</a>
					<a  class="Commodity_pricea" href="<?=$url?>"><div class="Commodity_price">USD $<?=$price?></div></a>
					<a  class="Commodity_namea" href="<?=$url?>"><div class="Commodity_name"><?=$name?></div><i class='slh'></i></a>
				</div>				
			</div>	
		<?php }}?>
		</div>
	</div>
	</div>
	<div class="clear"></div>
	<div class="mask">
	<div class="selling1">
		<div class="brand_bg">
			<i class='bg'></i>
			<span></span>
			<a href="/products.php?&act=Selling"><?=$website_language['index'.$lang]['gd']?><i class="icon iconfont icon-left"></i></a>			
		</div>
		<div class="selling_bg">
		<?php 
			$product_sid = $db->get_limit('product_selling','1','ProId','Frequency Desc',0,10);
			foreach ($product_sid as $key => $value) {
				foreach ($value as $ke => $val) {
					$product_s[] = $val;
				}
				
			}
			if($product_s){
			$product_sids = implode(",",$product_s);
			for ($q=0; $q < count($product_s); $q++) { 
				$v1 = $db->get_one("product","ProId=".$product_s[$q]);
			//$ind_hot_product_row1 = $db->get_limit('product',"ProId in ($product_sids) and IsUse=2 and Del=1",'*','1',0,10);
			//var_dump($product_s);exit;
			//foreach((array)$ind_hot_product_row1  as $k1 => $v1){ 

			$name1 = $v1['Name'.$lang];
			$desc1 = $v1['BriefDescription'.$lang];
			$url1 = get_url('product',$v1);
			$img1 = $v1['PicPath_0'];
			$price1 = $v1['Price_1'];
			$ProId1 = $v1['ProId'];
		?>
			<div class="selling_content">
				<div data="<?=$ProId1?>" class="selling_center">
					<a  href='<?=$url1?>' class="selling_img">
						<img src="<?=$img1?>" alt="">
					</a>
					<a  class="Commodity_pricea" href="<?=$url1?>"><div class="Commodity_price">USD $<?=$price1?></div></a>
					<a  class="Commodity_namea" href="<?=$url1?>"><div class="Commodity_name"><?=$name1?></div><i class='slh'></i></a>
				</div>				
			</div>
		<?php }}else{

			for ($q=0; $q < count($product_new); $q++) { 
				
			foreach((array)$product_new  as $k1 => $v1){ 

			$name1 = $v1['Name'.$lang];
			$desc1 = $v1['BriefDescription'.$lang];
			$url1 = get_url('product',$v1);
			$img1 = $v1['PicPath_0'];
			$price1 = $v1['Price_1'];
			$ProId1 = $v1['ProId'];

			?>	
			<div class="selling_content">
				<div data="<?=$ProId1?>" class="selling_center">
					<a  href='<?=$url1?>' class="selling_img">
						<img src="<?=$img1?>" alt="">
					</a>
					<a  class="Commodity_pricea" href="<?=$url1?>"><div class="Commodity_price">USD $<?=$price1?></div></a>
					<a  class="Commodity_namea" href="<?=$url1?>"><div class="Commodity_name"><?=$name1?></div><i class='slh'></i></a>
				</div>				
			</div>
		<?php }}}?>			
		</div>
	</div>
	</div>
	<div class="clear"></div>
	<div class="mask">
	<div class="selling2">
		<div class="brand_bg">
			<i class='bg'></i>
			<span></span>
			<a href="/products.php?&act=Price"><?=$website_language['index'.$lang]['gd']?><i class="icon iconfont icon-left"></i></a>			
		</div>
		<div class="selling_bg">
			<?php 
				$ind_hot_product_row2 = $db->get_limit('product','IsUse=2 and Del=1 and Market=1','*','Sequence desc',0,10);
				if(count($ind_hot_product_row2)>9){
				foreach((array)$ind_hot_product_row2  as $k2 => $v2){ 
				$name2 = $v2['Name'.$lang];
				$desc2 = $v2['BriefDescription'.$lang];
				$url2 = get_url('product',$v2);
				$img2 = $v2['PicPath_0'];
				$price2 = $v2['Price_1'];
				$ProId2 = $v2['ProId'];
			?>
				<div class="selling_content">
					<div data="<?=$ProId2?>" class="selling_center">
						<a  href='<?=$url2?>' class="selling_img">
							<img src="<?=$img2?>" alt="">
						</a>
						<a  class="Commodity_pricea" href="<?=$url2?>"><div class="Commodity_price">USD $<?=$price2?></div></a>
						<a  class="Commodity_namea" href="<?=$url2?>"><div class="Commodity_name"><?=$name?><?=$name2?></div><i class='slh'></i></a>
					</div>				
				</div>
			<?php }}else{
				foreach((array)$product_new  as $k2 => $v2){ 
				$name2 = $v2['Name'.$lang];
				$desc2 = $v2['BriefDescription'.$lang];
				$url2 = get_url('product',$v2);
				$img2 = $v2['PicPath_0'];
				$price2 = $v2['Price_1'];
				$ProId2 = $v2['ProId'];
				?>
				<div class="selling_content">
					<div data="<?=$ProId2?>" class="selling_center">
						<a  href='<?=$url2?>' class="selling_img">
							<img src="<?=$img2?>" alt="">
						</a>
						<a  class="Commodity_pricea" href="<?=$url2?>"><div class="Commodity_price">USD $<?=$price2?></div></a>
						<a  class="Commodity_namea" href="<?=$url2?>"><div class="Commodity_name"><?=$name?><?=$name2?></div><i class='slh'></i></a>
					</div>				
				</div>
			<?php }}?>
		</div>
	</div>
	</div>	
	<div class="clear"></div>
	<div class="clear"></div>
	<div class="mask2">
	<div class="tail" style="margin:0 auto">
		<div class="tail_mask">
			<div class="tail_mask_bg">
				<div class="tail_mask_bg_img">
					<img src="images/index/ValueforMoney.png" alt="">
				</div>
				<div class="tail_mask_introduce"><?=$website_language['index'.$lang]['cxjb']?></div>
				<div class="tail_mask_advantage"><?=$website_language['index'.$lang]['cxjbt']?></div>
			</div>
			<div class="tail_mask_bg">
				<div class="tail_mask_bg_img">
					<img src="images/index/GlobalDistribution.png" alt="">
				</div>
				<div class="tail_mask_introduce"><?=$website_language['index'.$lang]['qqps']?></div>
				<div class="tail_mask_advantage"><?=$website_language['index'.$lang]['qqpst']?></div>
			</div>
			<div class="tail_mask_bg">
				<div class="tail_mask_bg_img">
					<img src="images/index/SecurePayment.png" alt="">
				</div>
				<div class="tail_mask_introduce"><?=$website_language['index'.$lang]['aqzf']?></div>
				<div class="tail_mask_advantage"><?=$website_language['index'.$lang]['aqzft']?></div>
			</div>
			<div class="tail_mask_bg">
				<div class="tail_mask_bg_img">
					<img src="images/index/RestAssuredShopping.png" alt="">
				</div>
				<div class="tail_mask_introduce"><?=$website_language['index'.$lang]['fxgw']?></div>
				<div class="tail_mask_advantage"><?=$website_language['index'.$lang]['fxgwt']?></div>
			</div>
			<div class="tail_mask_bg">
				<div class="tail_mask_bg_img">
					<img src="images/index/HelpCenter.png" alt="">
				</div>
				<div class="tail_mask_introduce"><?=$website_language['index'.$lang]['qthbzzx']?></div>
				<div class="tail_mask_advantage"><?=$website_language['index'.$lang]['qthbzzxt']?></div>
			</div>
		</div>
	</div>
</div>

<!-- Live800在线客服图标:默认图标[浮动图标]开始-->
<div style='display:none;'><a href=' '>网页聊天</a></div><script language="javascript" src="http://chat.live800.com/live800/chatClient/floatButton.js?jid=5513164191&companyID=846315&configID=126818&codeType=custom"></script><div style='display:none;'><a href='http://en.live800.com'>live chat</a></div>
<!-- 在线客服图标:默认图标结束-->
<div style='display:none;'><a href='http://www.live800.com'>客服系统</a></div>
<?php include("inc/common/footer.php");?>
<script>
	$(function(){
		var url=window.location.href;
		var ip=returnCitySN.cip;
		var time = <?=$time;?>;
		var Clicks_php = <?=$index_time;?>;
		Clicks_php++;	
		$.ajax({
			type:"get",
			url:"/getTime.php",
			data:{
				HomeTimes:time,
				ProductClicks:Clicks_php,
				ip:ip,
				url:url,
			},
			success:function(data){
			
			},
			error:function(){			
			}
		})	  
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
	})
</script>