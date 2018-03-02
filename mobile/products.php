<?php 
include('../inc/include.php'); 
$no_page_url='?'.query_string('page');
$no_sort_url='?'.query_string('sort');
$no_stock_url='?'.query_string('stock');
$no_sale_url='?'.query_string('sale');
$CateId=(int)$_GET['CateId'];
$where = '1'.$mCfg_product_where;

$Keyword = mysql_real_escape_string($_GET['Keyword']);


//eagle home 
$Eagle_home = $db->get_one('product_category',"CateId='$CateId'",'Category');
$Eagle_home_1 = $db->get_all('product_category',"find_in_set('110',UId)",'CateId');



// 产品搜索
$IsSupplier = (int)$_GET['IsSupplier'];
if($IsSupplier){
	$Supplier = $Keyword;
	$Supplier && $supplier_list = $db->get_all('member',"Supplier_Name like '%$Supplier%' or Email like '%$Supplier%'",'MemberId');
	if($supplier_list){
	    $supplier_id = array();
	    foreach((array)$supplier_list as $v){
	        $supplier_id[] = $v['MemberId'];
	    }
	    $supplier_id=implode(',', $supplier_id);
	}
	$supplier_id && $where.=" and SupplierId in ({$supplier_id})";
}else{
	$Keyword && $where.=" and (Name like'%$Keyword%' or Name_lang_1 like'%$Keyword%')";
}
/** 各类产品展示 **/

$pro_type = array(
	1 => ' and IsNew=1',
	2 => ' and IsHot=1',
	3 => ' and IsRecommend=1',
	4 => ' and IsBest=1',
	5 => ' and IsFeatured=1',
);
$Title=$mobile_language['products'.$lang]['products'];
$_GET['pro_type'] && $where.=$pro_type[(int)$_GET['pro_type']];
$_GET['pro_type'] && $Title=$website_language['nav'.$lang]['type_'.(int)$_GET['pro_type']];
/** 产品筛选开始  **/
// 颜色
$ColorId = (int)$_GET['color'];
$ColorId &&	$where.=" and ColorId like '%|$ColorId|%'";

// 价格范围搜索
$min_price = (int)$_GET['min'];
$max_price = (int)$_GET['max'];
$max_price || $min_price && $where.=" and Price_1 >'$min_price'";
$min_price || $max_price && $where.=" and Price_1 <'$max_price'";
$min_price && $max_price && $where.=" and Price_1 >'$min_price' and Price_1 < '$max_price'";

// 热卖
$on_sale = (int)$_GET['sale'];
$on_sale && $where.=" and IsHot=1";

// 库存
$in_stock = (int)$_GET['stock'];
$in_stock && $where.=" and Stock > 0";

// 排序
$sort_ary = array(
	'1'	=> 'ProId desc,',
	'2'	=> 'Price_1 asc,',
	'3'	=> 'Price_1 desc,',
	'4'	=> "Name{$lang} asc,",
	);
$pro_sort = (int)$_GET['sort'];
$pro_sort && $products_sory = $sort_ary[$pro_sort];
/** 产品筛选结束  */
if($CateId){
	$category_row=$db->get_one('product_category', "CateId='$CateId'");
	$UId=$category_row['UId'].$CateId.',';
	$where.=" and (CateId in(select CateId from product_category where UId like '%{$UId}%') or CateId='{$CateId}')";
	$Title=$category_row['Category'.$lang];
	list(,$TopCateId,$SecCateId,$ThiCateId,$FouCateId) = explode(',',$UId.$CateId);
	$topcategory_row=$db->get_one('product_category', "CateId='$TopCateId'");
}
$_SESSION['mobile_turn_page_where'] = $where;
$_SESSION['mobile_turn_page_order'] = $products_sory.'ProId desc';
$page_count = 8; //显示数量
$row_count=$db->get_row_count('product', $where);
$total_pages=ceil($row_count/$page_count);
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*$page_count;
$product_list_row=str::str_code($db->get_limit('product', $where.' and SoldOut = 0', '*', $products_sory.'ProId desc', $start_row, $page_count));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php echo seo_meta($category_row['SeoTitle'.$lang],$category_row['SeoKeyword'.$lang],$category_row['SeoDescription'.$lang]);?>
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/global.css">
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/style.css">
	<style type="text/css">
		#myli {
			padding: 10px;
			width: 90%;

			margin: 0 auto;
			text-align:center;
			height: 20px;
		}
		#myli ul{
			margin:0 auto;
		}
		#myli li{
			overflow: hidden;
			float: left;
			margin-left: 10px;
		}
	</style>
</head>
<body>
	<?php include($site_root_path.$mobile_url.'/inc/header.php'); ?>
	<div id="products">
		<div class="category">
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

					<div class="list <?=$TopCateId==$v['CateId'] ? 'cur' : ''; ?>">
						<a href="<?=$url; ?>" class="pic" style="background-image:url(<?=$img; ?>);" title="<?=$name; ?>"></a>
						<a href="<?=$url; ?>" class="name"  title="<?=$name; ?>"><?=$name; ?></a>
					</div>
				<?php } ?>

			<?php } ?>
		</div>
		<div class="rig_con">
			<div class="title"><?=$Title; ?></div>
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
						<div class="price">USD$ <?=$price; ?></div>
					</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
			<?php if($total_pages>1){?>
			<div id="myli"><?=turn_page_html($row_count, $page, $total_pages, $no_page_url, 'Previous', 'Next');?></div>
			<?php }?>
			<div class="more_products"><?=$mobile_language['products'.$lang]['last']; ?></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php include($site_root_path.$mobile_url.'/inc/footer.php'); ?>
</body>
</html>
<script>
	$(function(){
		var page = 1,
			lock = 0;
		$(window).scroll(function(){
			var pro_list = $('.rig_con .pro_list'),
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