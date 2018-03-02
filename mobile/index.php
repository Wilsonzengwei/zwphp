<?php 
include('../inc/include.php'); 
$page_name = 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php echo seo_meta();?>
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/global.css">
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/style.css">
</head>
<body>
	<?php include($site_root_path.$mobile_url.'/inc/header.php'); ?>
	<div id="index">
		<?php $index_ad=$db->get_one('ad','AId =1');?>
		<script src="<?=$mobile_url; ?>/js/TouchSlide.1.1.js"></script>
		<!-- banner主要代码 Start ================================ -->
		<div id="focus" class="banner">
			<div class="hd" style="display: none;">
				<ul></ul>
			</div>
			<div class="bd">
				<ul>
					<?php for($i=0;$i<5;$i++){
	                    if(!is_file($site_root_path.$index_ad['PicPath_'.$i]))continue;
	                ?>
						<li><a href="<?=$index_ad['Url_'.$i]?>" target="_blank" title="<?=$index_ad['Name_'.$i]?>"><img src="<?=$index_ad['PicPath_'.$i]; ?>" /></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<script type="text/javascript">
			TouchSlide({ 
				slideCell:"#focus",
				titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
				mainCell:".bd ul", 
				effect:"leftLoop", 
				autoPlay:true,//自动播放
				autoPage:true //自动分页
			});
		</script>
		<!-- banner主要代码 End ================================ -->
		<div class="category">
			<div class="title">
				<span><a href="<?=$mobile_url; ?>/products.php" title="<?=$website_language['head'.$lang]['all_category']; ?>"><?=$website_language['head'.$lang]['all_category']; ?></a></span>
			</div>
			<div class="content">
				<div class="scroll" style="width:<?=1.875*count($All_Category_row['0,']); ?>rem;">
					<?php foreach((array)$All_Category_row['0,'] as $v){ 
						$name = $v['Category'.$lang];
						$img = $v['PicPath_1'];
						$url = $mobile_url.get_url('product_category',$v);
						?>
					<?php if($name == 'EAGLE HOME'){?>
						
						<div class="list <?=$TopCateId==$v['CateId'] ? 'cur' : ''; ?>">
							<a id="aaa" href="<?=$url; ?>" class="pic" style="background-image:url(<?=$img; ?>);" title="<?=$name; ?>"></a>
							<a id="bbb" href="<?=$url; ?>" class="name"  title="<?=$name; ?>"><?=$name; ?></a>
						</div>
						<script>
	                        var  email = "<?=$_SESSION['member_MemberId']?>";

	                         $("#aaa").click(function(){
	                            if(email==""){
	                                var til_1 = "<?=$website_language['member'.$lang]['login']['til_1'];?>";
	                                alert(til_1);
	                                return false;
	                            }
	                           
	                        })
	                          $("#bbb").click(function(){
	                            if(email==""){
	                                var til_1 = "<?=$website_language['member'.$lang]['login']['til_1'];?>";
	                                alert(til_1);
	                                return false;
	                            }
	                           
	                        })
	                    </script>

					<?php }else{?>
	

						<div class="list">
							<a href="<?=$url; ?>" class="pic" style="background-image:url(<?=$img; ?>);"title="<?=$name; ?>"></a>
							<a href="<?=$url; ?>" class="name" title="<?=$name; ?>"><?=$name; ?></a>
						</div>

					<?php } ?>
					<?php } ?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<?php 
			$ad_2 = $db->get_one('ad','AId=2'); 
			if($ad_2){
			?>
			<div class="sec_banner">
				<a href="<?=$ad_2['Url_0'] ? $ad_2['Url_0'] : 'javascript:;'; ?>" target="_blank" title="<?=$ad_2['Name_0']; ?>">
					<img src="<?=$ad_2['PicPath_0']; ?>" alt="<?=$ad_2['Name_0']; ?>">
				</a>
			</div>
		<?php } ?>
		<div class="flash_pro">
			<div class="title"><?=$mobile_language['index'.$lang]['title1'] ?></div>
			<div class="pro_list">
				<?php $ind_recommend_product_row = $db->get_limit('product','IsRecommend=1','*','MyOrder desc,ProId desc',0,20); ?>	
				<div class="scroll" style="width:<?=2.535*count($ind_recommend_product_row); ?>rem;">
					<?php foreach((array)$ind_recommend_product_row as $v){ 
						$name = $v['Name'.$lang];
						$price_0 = $v['Price_0'];
						$price_1 = $v['Price_1'];
						$img = $v['PicPath_0'];
						$url = $mobile_url.get_url('product',$v);
						?>
						<div class="list">
							<a href="<?=$url; ?>" class="pic" title="<?=$name; ?>"><img src="<?=$img; ?>" alt=""></a>
							<div class="price_1">USD $<?=$price_1; ?></div>
							<!--<del class="price_0">$<?=$price_0; ?></del>-->
						</div>
					<?php } ?>
					<div class="clear"></div>
				</div>

			</div>
		</div>
		<div class="hot_pro">
			<div class="title"><?=$mobile_language['index'.$lang]['title2'] ?></div>
			<div class="pro_list">
				<?php 
				$ind_hot_product_row = $db->get_limit('product','IsHot=1','*','MyOrder desc,ProId desc',0,12);
				foreach((array)$ind_hot_product_row as $v){ 
					$name = $v['Name'.$lang];
					$img = $v['PicPath_0'];
					$url = $mobile_url.get_url('product',$v);
					$price = $v['Price_1'];
					?>
					<div class="list">
						<a href="<?=$url; ?>" class="pic" title="<?=$name; ?>"><img src="<?=$img; ?>" alt="<?=$name; ?>"></a>
						<a href="<?=$url; ?>" class="name" title="<?=$name; ?>"><?=$name; ?></a>
						<div class="price">USD $<?=$price; ?></div>
					</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
			<a href="<?=$mobile_url; ?>/products.php" class="more"><?=$mobile_language['index'.$lang]['title3'] ?></a>
		</div>
	</div>
	<?php include($site_root_path.$mobile_url.'/inc/footer.php'); ?>
	<!-- Live800在线客服图标:默认图标[浮动图标]开始-->
<div style='display:none;'>< a href=' '>网页聊天</ a></div><script language="javascript" src="http://chat.live800.com/live800/chatClient/floatButton.js?jid=5513164191&companyID=846315&configID=126818&codeType=custom"></script><div style='display:none;'>< a href='http://en.live800.com'>live chat</ a></div>
<!-- 在线客服图标:默认图标结束-->
	<div style='display:none;'><a href='http://www.live800.com'>客服系统</a></div>
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-40714410-22']);
	 _gaq.push(['_trackPageview']);
	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	 })();
	</script>
	<div style='display:none;'><a href='http://en.live800.com'>live chat</a></div>
</body>
</html>