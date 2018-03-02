<?php 
include('../../inc/include.php'); 
$page_name = 'product';
$no_page_url='?'.query_string('page');
$CateId = (int)$_GET['CateId'];
$where = "SupplierId = '$SupplierId'".$mCfg_product_where;
$Column = $website_language['products'.$lang]['products'];

$IsHot = (int)$_GET['IsHot'];
$IsHot && $where.=' and IsHot=1';

$Keyword = mysql_real_escape_string($_GET['Keyword']);
$Keyword && $where.=" and (Name like'%$Keyword%' or Name_lang_1 like'%$Keyword%')";

if($CateId){
	$category_row=$db->get_one('product_category', "CateId='$CateId'");
	$UId=$category_row['UId'].$CateId.',';
	$where.=" and (CateId in(select CateId from product_category where UId like '%{$UId}%') or CateId='{$CateId}')";
	$Title=$category_row['Category'.$lang];
	list(,$TopCateId,$SecCateId,$ThiCateId,$FouCateId) = explode(',',$UId.$CateId);
	$Column = $category_row['Category'];
}
$_SESSION['mobile_turn_page_where'] = $where;
$_SESSION['mobile_turn_page_order'] = $lyc['products_sort'][$Sort].'ProId desc';
$page_count=8;//显示数量
$row_count=$db->get_row_count('product', $where);
$total_pages=ceil($row_count/$page_count);
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*$page_count;
$product_list_row=str::str_code($db->get_limit('product', $where.' and SoldOut = 0', '*', $lyc['products_sort'][$Sort].'ProId desc', $start_row, $page_count));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php echo seo_meta($category_row['SeoTitle'.$lang],$category_row['SeoKeyword'.$lang],$category_row['SeoDescription'.$lang]);?>
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/global.css">
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/style.css">
</head>
<body>
	<?php include($site_root_path.$mobile_url.'/inc/header.php'); ?>
		<div id="supplier_products">
			<?php if(!$CateId){ ?>
			<div class="all_category">
				<div class="top_title">
					<a href="javascript:;" onclick="history.back();" class="return"></a>
					<?=$mobile_language['products'.$lang]['category']; ?>
				</div>
				<?php 
				foreach((array)$All_Category_row['0,'] as $k => $v){
					$vCateId = $v['CateId'];
					$vUId=$v['UId'].$vCateId.',';
					if(!$db->get_row_count('product',"SupplierId='$SupplierId' and (CateId in(select CateId from product_category where UId like '%{$vUId}%') or CateId='{$vCateId}')".$mCfg_product_where)) continue;
					if(!$db->get_row_count('product',"SupplierId='$SupplierId' and (CateId in(select CateId from product_category where UId like '%{$vUId}%'))".$mCfg_product_where)){
						$not_pro = 1;
					}
					$name = $v['Category'.$lang];
					$v['SupplierId'] = $SupplierId;
					$url = $mobile_url.get_url('supplier_product_category',$v);
					?>
					<div class="top_list">
						<div class="top_item">
							<a href="<?=$url; ?>" class="top" title="<?=$name; ?>"><?=$name; ?></a>
							<?php if(!$not_pro){ ?>
								<em class="plus <?=$TopCateId==$vCateId ? 'less' : ''; ?>"></em>
							<?php } ?>
						</div>
						<?php if(!$not_pro){ ?>
							<?php foreach((array)$All_Category_row['0,'.$vCateId.','] as $k1 => $v1){ 
								$v1CateId = $v1['CateId'];
								$v1UId=$v1['UId'].$v1CateId.',';
								if(!$db->get_row_count('product',"SupplierId='$SupplierId' and (CateId in(select CateId from product_category where UId like '%{$v1UId}%') or CateId='{$v1CateId}')".$mCfg_product_where)) continue; 
								if(!$db->get_row_count('product',"SupplierId='$SupplierId' and (CateId in(select CateId from product_category where UId like '%{$v1UId}%'))".$mCfg_product_where)){
									$sec_not_pro = 1;
								} 
								$name1 = $v1['Category'.$lang];
								$v1['SupplierId'] = $SupplierId;
								$url1 = $mobile_url.get_url('supplier_product_category',$v1);
								?>
								<div class="sec_list <?=$TopCateId==$v1CateId ? '' : 'hide'; ?>">
									<div class="sec_item">
										<a href="<?=$url1; ?>" class="sec" title="<?=$name1; ?>"><?=$name1; ?></a>
										<?php if(!$sec_not_pro){ ?>
											<em class="plus <?=$SecCateId==$v1CateId ? 'less' : ''; ?>"></em>
										<?php } ?>
									</div>
									<?php if(!$sec_not_pro){ ?>
									<div class="thi_list <?=$SecCateId==$v1CateId ? '' : 'hide'; ?>">
										<?php foreach((array)$All_Category_row['0,'.$vCateId.','.$v1CateId.','] as $k2 => $v2){ 
											$v2CateId = $v2['CateId'];
											$v2UId=$v2['UId'].$v2CateId.',';
											if(!$db->get_row_count('product',"SupplierId='$SupplierId' and (CateId in(select CateId from product_category where UId like '%{$v2UId}%') or CateId='{$v2CateId}')".$mCfg_product_where)) continue; 
											$name2 = $v2['Category'.$lang];
											$v2['SupplierId'] = $SupplierId;
											$url2 = $mobile_url.get_url('supplier_product_category',$v2);
											?>
											<a href="<?=$url2; ?>" class="thi_item <?=$CateId==$v2CateId ? 'thi_on' : '' ?>" title="<?=$name2; ?>"><?=$name2; ?></a>
										<?php } ?>
									</div>
									<?php } ?>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
			<script>
				$('.all_category .plus').click(function(){
					if($(this).hasClass('less')){
						$(this).removeClass('less');
						$(this).parent().siblings('div').addClass('hide');
					}else{
						$(this).addClass('less');
						$(this).parent().siblings('div').removeClass('hide');
					}
				});
			</script>
		<?php }else{ ?>
			<div class="top_title">
				<a href="javascript:;" onclick="history.back();" class="return"></a>
				<?=$Title; ?>
			</div>
			<div class="search">
				<form action="">
					<?php foreach((array)$_GET as $k=>$v){ 
						if($k=='Keyword') continue;
						?>
						<input type="hidden" name="<?=$k; ?>" value="<?=$v; ?>">
					<?php } ?>
					<button></button>
					<input type="text" placeholder="<?=$website_language['head'.$lang]['placeholder']; ?>" name="Keyword" value="<?=stripslashes($Keyword); ?>" id="">
					<div class="clear"></div>
				</form>
			</div>
			<div class="hot_pro">
				<div class="pro_list">
					<?php foreach((array)$product_list_row as $v){ 
						$name = $v['Name'.$lang];
						$img = $v['PicPath_0'];
						$url = $mobile_url.get_url('product',$v);
						$price = $v['Price_1'];
						?>
						<div class="list">
							<a href="<?=$url; ?>" class="pic" title="<?=$name; ?>"><img src="<?=$img; ?>" alt="<?=$name; ?>"></a>
							<a href="<?=$url; ?>" class="name" title="<?=$name; ?>"><?=$name; ?></a>
							<div class="price">$<?=$price; ?></div>
						</div>
					<?php } ?>
					<div class="clear"></div>
				</div>
				<div class="more_products"><?=$mobile_language['products'.$lang]['last']; ?></div>
			</div>
		<?php } ?>
	</div>
	<script>
		$(function(){
			var page = 1,
				lock = 0;
			$(window).scroll(function(){
				var pro_list = $('.hot_pro .pro_list'),
					more = $('.more_products'),
					w_h=$(window).height(),
					s_h = $(window).scrollTop(),
					bot_to_top_h = w_h+s_h,
					more_top = more.offset().top,
					limit = <?=$page_count; ?>;
				if(bot_to_top_h>more_top){
					if(!lock){
						$.post('/ajax/mobile_turn_page.php',{'limit':limit,'page':page},function(data){
							if(data==0){
								lock=1;
								more.show();
							}else{
								pro_list.append(data);
								page++;
								lock=0;
							}
						});
					}
					lock = 1;
				}
			});
		});
	</script>
	<?php //include($site_root_path.$mobile_url.'/inc/footer.php'); ?>
</body>
</html>