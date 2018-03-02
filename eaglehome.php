<?php
include('inc/include.php');
$no_page_url='?'.query_string('page');
$no_sort_url='?'.query_string('sort');
$no_stock_url='?'.query_string('stock');
$no_sale_url='?'.query_string('sale');
$no_style_url='?'.query_string('style');
$_SESSION['style'] = isset($_GET['style']) ? (int)$_GET['style'] : (isset($_SESSION['style']) ? (int)$_SESSION['style'] : 1);
$CateId=(int)$_GET['CateId'];
$where = '1'.$mCfg_product_where;
$Eagle_home = $db->get_one('product_category',"CateId='$CateId'",'Category');
$Eagle_home_1 = $db->get_all('product_category',"find_in_set('110',UId)",'CateId');
$SupplierId = $_GET['SupplierId'];

if($_GET['SupplierId']){
	$member_where = " and MemberId='$SupplierId_meb'";
}
$member_row =  $db->get_limit('member',"Is_Business_License='0'".$member_where );
$member_row_meb =  $db->get_limit('member',"Is_Business_License='0'");
$members_row =  $db->get_limit('member',"1",'MemberId,LogoPath_1,MemberAbb');

foreach((array)$Eagle_home_1 as $k => $v){
			foreach((array)$v as $k1 => $v1){
				$Eagle_home_2[] = $v1;
			}

		}
//var_dump($Eagle_home_1);exit;
//var_dump($mysql);exit;$Eagle_home = $db->get_all('product_category',"find_in_set('110',UId)",'CateId');
$Keyword = mysql_real_escape_string($_GET['Keyword']);
//产品搜索
$IsSupplier = (int)$_GET['IsSupplier'];
if($IsSupplier == '1'){
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
}elseif($IsSupplier == '3'){
	$Keyword && $where.=" and ProductCodeId='$Keyword'";
}else{
	$Keyword && $where.=" and (Name like'%$Keyword%' or Name_lang_1 like'%$Keyword%')";
}

/** 各类产品展示 */

$pro_type = array(
	1 => ' and IsNew=1',
	2 => ' and IsHot=1',
	3 => ' and IsRecommend=1',
	4 => ' and IsBest=1',
	5 => ' and IsFeatured=1',
);

$_GET['pro_type'] && $where.=$pro_type[(int)$_GET['pro_type']];

/** 产品筛选开始  */
//颜色
$ColorId = (int)$_GET['color'];
$ColorId &&	$where.=" and ColorId like '%|$ColorId|%'";

//价格范围搜索
$min_price = (int)$_GET['min'];
$max_price = (int)$_GET['max'];
$max_price || $min_price && $where.=" and Price_1 >'$min_price'";
$min_price || $max_price && $where.=" and Price_1 <'$max_price'";
$min_price && $max_price && $where.=" and Price_1 >'$min_price' and Price_1 < '$max_price'";

//热卖
$on_sale = (int)$_GET['sale'];
$on_sale && $where.=" and IsHot=1";

//库存
$in_stock = (int)$_GET['stock'];
$in_stock && $where.=" and Stock > 0";

//排序
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
}else{
	$no_show_proid = $db->get_all('product_category','UId like "0,110,%"','CateId');
	foreach((array)$no_show_proid as $v){
		$no_show_proid_str[] = $v['CateId'];	
	}
	$no_show_proid_str[] = 110;
	$no_show_proid_str = implode(',', $no_show_proid_str);
	$no_show_proid_str && $where.=" and CateId not in({$no_show_proid_str})";
}

$where_a = "1";
if($SupplierId){
	$where_a.= " and SupplierId='$SupplierId'";
}

	$page_count = 24; //显示数量
	$row_count=$db->get_row_count('product', $where_a);
	$total_pages=ceil($row_count/$page_count);
	$page=(int)$_GET['page'];
	$page<1 && $page=1;
	$page>$total_pages && $page=1;
	$start_row=($page-1)*$page_count;


$product_list_row=str::str_code($db->get_limit('product', $where_a, '*','ProId desc',$start_row, $page_count));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<?php echo seo_meta();?>
<?php include("$site_root_path/inc/common/static.php"); ?>
</head>
<body>
<?php include("$site_root_path/inc/common/product_header.php"); ?>
<div id="platform_products">
	<div id="platform_location">
		<div id="dataBorder" class="global">
			<a href="/" title="<?=$website_language['nav'.$lang]['home']; ?>" class="home"><img src="/images/home.png" alt="<?=$website_language['nav'.$lang]['home']; ?>"></a>
			<a href="/" title="<?=$website_language['nav'.$lang]['home']; ?>"><?=$website_language['nav'.$lang]['home']; ?></a><?=$CateId?get_web_position($category_row, 'product_category',' » ','supplier_product_category',$SupplierId):' » Products';?> 
		</div>
	</div>
	<div class="global">
		<div class="product_category">
			<div class="title"><?=$website_language['products'.$lang]['category']; ?></div>
			<?php if($CateId){ ?>
				<div class="top_list">
					<a href="<?=get_url('product_category',$topcategory_row); ?>" class="top_item top_on" title="<?=$topcategory_row['Category'.$lang]; ?>"><?=$topcategory_row['Category'.$lang]; ?></a>
				</div>
			<?php } ?>
			<?php 
				$TopCategory = '0,';
				$CateId && $TopCategory .= $TopCateId.',';
				foreach((array)$All_Category_row[$TopCategory] as $k => $v){
				$vCateId = $v['CateId']; 
				$name = $v['Category'.$lang];
				$url = get_url('product_category',$v);
				?>
				<div class="top_list">
					<a href="<?=$url; ?>" class="top_item <?=$SecCateId==$vCateId ? 'sec_on' : ''; ?>" title="<?=$name; ?>"><?=$name; ?></a>
				</div>
				<?php if($All_Category_row["{$v['UId']}{$vCateId},"]){ ?>
					<div class="sec_list <?=$SecCateId==$vCateId ? '' : 'hide'; ?>">
						<?php foreach((array)$All_Category_row["{$v['UId']}{$vCateId},"] as $k1 => $v1){ 
							$v1CateId = $v1['CateId'];
							$name1 = $v1['Category'.$lang];
							$url1 = get_url('product_category',$v1);
							?>
							<a href="<?=$url1; ?>" class="sec_item" title="<?=$name1; ?>"><?=$name1; ?></a>
						<?php } ?>
					</div>
				<?php } ?>
			<?php } ?>
			<div class="rela_products">
				<div class="title"><?=$website_language['products'.$lang]['related']; ?></div>
				<?php $related_product_row = $db->get_limit('product','IsBest=1'.$mCfg_product_where,'*','MyOrder desc,ProId desc',0,4); ?>
				<?php foreach((array)$related_product_row as $k=>$v){ 
					$name = $v['Name'.$lang];
					$img = $v['PicPath_0'];
					$url = get_url('product',$v);
					$price = $v['Price_1'];
					$ProId =  $v['ProId'];
					?>
					<div class="list <?=$k==0 ? 'not_pt' : ''; ?>">
						<div class="pic">
							<a data="<?=$ProId?>" href="<?=$url; ?>" title="<?=$name; ?>"><img data="<?=$ProId?>" src="<?=$img; ?>" alt="<?=$name; ?>"></a>
						</div>
						<a data="<?=$ProId?>" href="<?=$url; ?>" class="name" title="<?=$name; ?>"><?=$name; ?></a>
						<div class="price">USD$ <?=$price; ?></div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="product_list">
			
				
			<div class="cate_title"><span><?=$row_count; ?></span> <?=$website_language['products'.$lang]['in']; ?> <?=$Title ? $Title : 'Products' ?> </div>
			<div style="margin-left:-13px" class="filter">
			<div style="clear:both"></div>


				<form class="form" action="?" style="margin-top: 30px; ">
					<?php foreach((array)$_GET as $k=>$v){ 
						if($k=='page'||$k=='min'||$k=='max'||$k=='color') continue;
						?>
						<input type="hidden" name="<?=$k; ?>" value="<?=$v; ?>" />
					<?php } ?>
					<span class="tit"><?=$website_language['products'.$lang]['price']; ?> :</span>
					<input type="text" style="margin-left:13px" name="min" value="<?=$min_price==0?'':$min_price; ?>" class="pri_input">
					<span class="tit" >-</span>
					<input type="text" name="max" value="<?=$max_price==0?'':$max_price; ?>" class="pri_input">
					&nbsp;&nbsp;&nbsp;
					<span class="tit"><?=$website_language['products'.$lang]['color']; ?> :</span>
					<select name="color" class="select" id="">
						<option value=""><?=$website_language['products'.$lang]['select_color']; ?></option>
						<?php


						 $products_color_row = $db->get_all('product_color','1','*','MyOrder desc,CId asc'); ?>
						<?php foreach((array)$products_color_row as $v){ 
							$name = $v['Color'.$lang];
							$vCId = $v['CId'];
							?>
							<option <?=$ColorId==$vCId?'selected':''; ?> value="<?=$vCId; ?>"><?=$name; ?></option>
						<?php } ?>
					</select>
					<button class="submit"><?=$website_language['products'.$lang]['submit']; ?></button>
				</form>




				<a href="<?=$no_sale_url; ?><?=$on_sale==1?'':'&sale=1';?>" class="no_cur  <?=$on_sale==1 ? 'cur' : ''; ?>"></a>
				<span class="tit"><?=$website_language['products'.$lang]['is_hot']; ?></span>
				<a href="<?=$no_stock_url; ?><?=$in_stock==1?'':'&stock=1';?>" class="no_cur  <?=$in_stock==1 ? 'cur' : ''; ?>"></a>
				<span class="tit"><?=$website_language['products'.$lang]['in_stock']; ?></span>
			</div>
			<div class="order" style="margin-left:-13px">
				<span class="tit"><?=$website_language['products'.$lang]['sort_by']; ?>:</span>
				<a href="<?=$no_sort_url; ?><?=$pro_sort==1?'':'&sort=1';?>" class="no_cur <?=$pro_sort==1 ? 'cur' : ''; ?>" title="Mejor partido"><?=$website_language['products'.$lang]['best_order']; ?></a>       
				<span class="pri">
					<a href="<?=$no_sort_url; ?><?=$pro_sort==2?'&sort=3':'&sort=2';?>" title="price_desc"><?=$website_language['products'.$lang]['price']; ?></a>
					<a href="<?=$no_sort_url; ?><?=$pro_sort==2?'':'&sort=2';?>" class="desc <?=$pro_sort==2 ? 'desc_on' : ''; ?>" title="price_desc"></a>
					<a href="<?=$no_sort_url; ?><?=$pro_sort==3?'':'&sort=3';?>" class="asc <?=$pro_sort==3 ? 'asc_on' : ''; ?>" title="price_asc"></a>
				</span>     
				<a href="<?=$no_sort_url; ?><?=$pro_sort==4?'':'&sort=4';?>" class="no_cur <?=$pro_sort==4 ? 'cur' : ''; ?>" title="Bestselling"><?=$website_language['products'.$lang]['seller']; ?></a>
				<a href="<?=$no_style_url.'&style=1' ?>" class="style_1 <?=$_SESSION['style']==1?'style_1h':'';?>"></a>
				<a href="<?=$no_style_url.'&style=0' ?>" class="style_0 <?=$_SESSION['style']==0?'style_0h':'';?>"></a>
			</div>



		
			

			<div class="prod <?=$_SESSION['style']==0?'prod_style':''; ?>">
				<?php foreach((array)$product_list_row as $k => $v){ 
					$name = $v['Name'.$lang];
					$img = $v['PicPath_0'];
					$price = $v['Price_1'];
					$url = get_url('product',$v);
					$ProId = $v['ProId'];
					?>
					
						<?php if($k%3==0 && $k!=0){ ?>
							<div class="clear br"></div>
						<?php } ?>
					
					<div class="list trans5">
						<div class="img">
							<div class="pic">
								<a data="<?=$ProId?>" href="<?=$url; ?>&CateId=<?=$CateId;?>" title="<?=$name; ?>"><img data="<?=$ProId?>" src="<?=$img; ?>" alt="<?=$name; ?>"></a>
							</div>
						</div>
						<div class="content">
							<a data="<?=$ProId?>" href="<?=$url; ?>&CateId=<?=$CateId;?>" class="name" title="<?=$name; ?>"><?=$name; ?></a>
							<div class="price">USD$ <?=$price; ?></div>
						</div>
						<div class="clear"></div>	
					</div>
				<?php } ?>
				<div class="clear"></div>
			</div>

		

			<?php if($total_pages>1){?>
				<div id="turn_page">
					<?=turn_page_html($row_count, $page, $total_pages, $no_page_url, 'Previous', 'Next');?>
				</div>
			<?php } ?>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php include("$site_root_path/inc/common/platform_foot.php"); ?>
<?php include("$site_root_path/inc/common/footer.php"); ?>
</body>
<script>
	$(function(){  
		$("#dataBorder").click(function(){
			window.localStorage.removeItem("dataBorder");
		}) 
   			var d=1;      
   			var email ="<?=$_SESSION['member_Email']; ?>";
		    $("a").click(function(){                	
            var c=$(this).attr("data");             	
				$.ajax({
	         	type:"get",
	         	url:"getGoodId.php",
	         	data:{
	         		act:'index',
	         		getProId:c,
	         		cishu:d,
	         		email:email
	         	},
	         	success:function(data){	         		
	         	

	         	},
	         	error:function(){
	         	
	         	}
	         })					
		})      
	})
</script>
</html>
