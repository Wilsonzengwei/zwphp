<?php 
include('../../inc/include.php'); 
// $page_name = 'home';
$supplier_row = $db->get_one('member',"MemberId='$SupplierId'");
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
	<div id="supplier_index">
		<?php $index_ad = $db->get_one('ad','Num=1 and SupplierId='.$SupplierId); ?>
		<script src="<?=$mobile_url; ?>/js/TouchSlide.1.1.js"></script>
		<!-- banner主要代码 Start ================================ -->
		<div id="focus" class="banner">
			<div class="bg"></div>
			<div class="information">
				<a href="" class="logo"><span class="pic"><img src="<?=$supplier_row['LogoPath']; ?>" alt=""></span></a>
				<div class="content"><?=nl2br($supplier_row['Supplier_BriefDescription'.$lang]); ?></div>
			</div>
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
		<div class="link_list">
			<a href="<?=$mobile_url; ?>/supplier/products.php?SupplierId=<?=$SupplierId; ?>" class="list"><?=$mobile_language['index'.$lang]['title3']; ?></a>
			<a href="<?=$mobile_url; ?>/supplier/article.php?SupplierId=<?=$SupplierId; ?>&AId=<?=$db->get_value('article','Num=2 and SupplierId='.$SupplierId,'AId'); ?>" class="list" title="<?=$website_language['nav'.$lang]['contact_us']; ?>"><?=$website_language['nav'.$lang]['contact_us']; ?></a>
			<div class="clear"></div>
		</div>
		<div class="hot_pro">
			<div class="title"><?=$mobile_language['index'.$lang]['title2']; ?></div>
			<div class="pro_list">
				<?php 
				$ind_supplier_pro_row = $db->get_limit('product','SupplierId='.$SupplierId.$mCfg_product_where,'*','MyOrder desc,ProId desc',0,12);
				foreach((array)$ind_supplier_pro_row as $k => $v){ 
					$name = $v['Name'.$lang];
					$img = $v['PicPath_0'];
					$url = $mobile_url.get_url('product',$v);
					$price = $v['Price_1'];
					?>
					<div class="list">
						<a href="<?=$url; ?>" class="pic" title="<?=$name; ?>"><img src="<?=$img; ?>" alt=""></a>
						<a href="<?=$url; ?>" class="name" title="<?=$name; ?>"><?=$name; ?> </a>
						<div class="price">$<?=$price; ?></div>
					</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<?php include($site_root_path.$mobile_url.'/inc/footer.php'); ?>
</body>
</html>