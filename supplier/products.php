<?php
include('../inc/include.php');
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
	$Title=$category_row['Category'];
	list(,$TopCateId,$SecCateId,$ThiCateId,$FouCateId) = explode(',',$UId.$CateId);
	$Column = $category_row['Category'];
}

$page_count=6;//显示数量
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
<?php echo seo_meta();?>
<?php include("$site_root_path/inc/common/static.php"); ?>
</head>
<body>
<?php include("$site_root_path/inc/common/header.php"); ?>
<div id="location">
	<div class="global">
		<a href="/" title="<?=$website_language['nav'.$lang]['home']; ?>"><?=$website_language['nav'.$lang]['home']; ?></a> <?=$CateId?supplier_get_web_position($category_row, 'product_category',' - ','supplier_product_category',$SupplierId):' - '.$website_language['products'.$lang]['products'];?> 
	</div>
</div>
<div id="bus_products" class="global">
	<div class="bus_products_left content_left">
		<div class="title"><?=$website_language['products'.$lang]['products']; ?> </div>
		<?php include("$site_root_path/inc/common/pro_left.php"); ?>
		<?php include("$site_root_path/inc/common/featured_product.php"); ?>
	</div>
	<div class="products_list">
		<div class="top_title"><?=$Column; ?></div>
		<div class="p_list">
			<?php foreach((array)$product_list_row as $k => $v){ 
				$name = $v['Name'.$lang];
				$price = $v['Price_1'];
				$img = $v['PicPath_0'];
				$url = get_url('product',$v);
				?>
				<div class="list <?=$k%3==0 ? 'not_pl' : ''; ?>  <?=$k%3==2 ? 'not_br not_pr' : ''; ?> <?=$k>2 ? '' : 'not_pt'; ?>">
					<div class="pic">
						<a href="<?=$url; ?>" title="<?=$name; ?>"><img src="<?=$img; ?>" alt="<?=$name; ?>"></a>
					</div>
					<a href="<?=$url; ?>" class="name" title="<?=$name; ?>"><?=$name; ?></a>
					<div class="price">USD$ <?=$price; ?></div>
				</div>
			<?php } ?>
			<div class="clear"></div>
		</div>
		<?php if($total_pages>1){?>
			<div id="turn_page"><?=turn_page_html($row_count, $page, $total_pages, $no_page_url, 'Previous', 'Next');?></div>
		<?php }?>
	</div>
	<div class="clear"></div>
</div>
<?php include("$site_root_path/inc/common/footer.php"); ?>
</body>
</html>
