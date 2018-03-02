

<?php 
include("inc/include.php");
$no_page_url='?'.query_string('page');
$no_sort_url='?'.query_string('sort');
$no_stock_url='?'.query_string('stock');
$no_sale_url='?'.query_string('sale');
$no_style_url='?'.query_string('style');
$_SESSION['style'] = isset($_GET['style']) ? (int)$_GET['style'] : (isset($_SESSION['style']) ? (int)$_SESSION['style'] : 1);
$CateId=(int)$_GET['CateId'];

if($_POST['page_input']){
	$page = $_POST['page_input'];
	header("Location: products.php?CateId=$CateId&page=$page");
	exit;
	
}
$where = '1'.$mCfg_product_where." and Del=1";

$Eagle_home = $db->get_one('product_category',"CateId='$CateId'",'Category');
$Eagle_home_1 = $db->get_all('product_category',"find_in_set('110',UId)",'CateId');

$member_where = "1";
if($_GET['SupplierId']){
	$SupplierId_meb = $_GET['SupplierId'];
	$member_where .= " and MemberId='$SupplierId_meb'";
}

$member_row =  $db->get_all('member',$member_where." and Is_Business_License='0'");
$member_row_meb =  $db->get_all('member',"Is_Business_License='0'");
$members_row =  $db->get_all('member',"1",'MemberId,LogoPath_1,MemberAbb');

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
//var_dump($min_price);exit;
$mode = $_GET['mode'];
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
if($_GET['SupplierId']){
	$SupplierId = $_GET['SupplierId'];
	$where .= " and SupplierId=$SupplierId";

}
if($_GET['mode_s'] == '1'){
	$mode_s = $_GET['mode_s'];
	$center_s = $_GET['center_s'];
	if($center_s){
		if($db->get_one('product',"Name='$center_s' or Name_lang_1='$center_s' or Name_lang_2='$center_s' and IsUse=2 and Del=1")){
			$product_cates = $db->get_one('product',"(Name='$center_s' or Name_lang_1='$center_s' or Name_lang_2='$center_s') and IsUse=2 and Del=1","CateId");

			/*$product_supplier = $db->get_all("product","CateId='".$product_cates['CateId']."' and IsUse=2 and Del=1","SupplierId");
			if($product_supplier){
				foreach ($product_supplier as $key_r1 => $value_r1) {
					$product_suppliers[] = $value_r1['SupplierId'];
				}
				$supplier_r = array_unique($product_suppliers);
				$suppliers = implode(",",$supplier_r);
			}
*/

		}else{
			$product_cates= $db->get_all('product',"Name like '%$center_s%' or Name_lang_1 like '%$center_s%' or Name_lang_2 like'%$center_s%' and IsUse=2 and Del=1","CateId");
			/*if($product_cates){
				foreach ($product_cates as $key_r => $value_r) {
					$cares[] = $value_r['CateId'];
				}
				$care =array_unique($cares);
				$carer = implode(",",$care);
				$product_supplier = $db->get_all("product","CateId in (".$carer.") and IsUse=2 and Del=1 and (Name like '%$center_s%' or Name_lang_1 like '%$center_s%' or Name_lang_2 like'%$center_s%')","SupplierId");
				foreach ($product_supplier as $key_r1 => $value_r1) {
					$product_suppliers[] = $value_r1['SupplierId'];
				}
				$supplier_r = array_unique($product_suppliers);
				$suppliers = implode(",",$supplier_r);
			}*/
			
		}
	}
	$where .= " and Name".$lang." like '%$center_s%'";
}elseif($_GET['mode_s'] == '2'){
	$center_s = $_GET['center_s'];
	header("Location: /supplier.php?center_s=".$center_s);
}
/*if($_GET['mode_s'] == '1'){
	$center_s = $_GET['center_s'];
	$where .= " and Name_lang_1 like '%$center_s%'";
}else{
	$center_s = $_GET['center_s'];
	$member_s = $db->get_all("member","Supplier_Name like '%$center_s%'","MemberId");
	if($member_s){
		foreach((array)$member_s as $vs){
			$member_ss[] = $vs['MemberId'];	
		}
		$implode = implode(",",$member_ss);
		$where .= " and SupplierId in({$implode})";
	}
	
}*/
if($_GET['Supplier_product'] =='1'){
	$SupplierId_sr = $_GET['SupplierId'];
	//$where .= " and SupplierId='$SupplierId_sr'";
}
	$page_count = 30; //显示数量
	$row_count=$db->get_row_count('product', $where);
	$total_pages=ceil($row_count/$page_count);
	$page=(int)$_GET['page'];
	$page<1 && $page=1;
	$page>$total_pages && $page=1;
	
	$start_row=($page-1)*$page_count;
if($_GET['act'] == 'new'){
	$products_sory = " AccTime desc ,";
}

if($_GET['act'] == 'Price_desc'){
	$products_sory = " Price_1 asc ,";
}elseif($_GET['act'] == 'Price_asc'){
	$products_sory = " Price_1 desc ,";
}
$min_price = (int)$_GET['min'];
$max_price = (int)$_GET['max'];
$max_price || $min_price && $where.=" and Price_1 >'$min_price'";
$min_price || $max_price && $where.=" and Price_1 <'$max_price'";
$min_price && $max_price && $where.=" and Price_1 >'$min_price' and Price_1 < '$max_price'";
if($_GET['SupplierId']){
	$SupplierId = $_GET['SupplierId'];
	//$where .= " and SupplierId='$SupplierId'";
}
$product_list_row=str::str_code($db->get_limit('product', $where.' and SoldOut = 0', '*', $products_sory.'ProId desc', $start_row, $page_count));
$product_count = count($product_list_row);
	?>
<?php 
	include("inc/common/header.php");
	include("inc/common/search_header.php");


?>
<?php
	echo '<link rel="stylesheet" href="/css/products'.$lang.'.css">'
?>

<div class="mask1">
	<div class="lunbo_box">
	<div class="chanpinleimu"><div class="chanpimg"></div><a class="chanp_a" href=""><?=$website_language['products'.$lang]['cplm']?></a></div>
	<div class="chanpinleimu_right" style="">
		<div class="guide">
		<div class="navigation">
			<!-- <?=$website_language['nav_lang_1']['home']; ?> -->&nbsp;&nbsp;&nbsp;&nbsp; <?=$CateId?supplier_get_web_position2($category_row, 'product_category',' <i><i class="icon iconfont icon-left"></i></i> ','supplier_product_category',$SupplierId):$website_language['products'.$lang]['products'];?>	
		</div>	
		</div>	
	</div>
	</div>	
</div>
<div class="pro">
	<div class="pro_mask">		
		<div class="pro_mask1">
		<?php 
			if($CateId){
						//$category_row=$db->get_one('product_category', "CateId=".$CateId,"UId");
						$TopCategory = '0,';
						$CateId && $TopCategory .= $TopCateId.',';
						foreach((array)$All_Category_row[$TopCategory] as $ka => $va){
							$vCateId = $va['CateId']; 
							$vaCateId[] = $va['CateId']; 
							//var_dump($All_Category_row["{$va['UId']}{$vCateId},"]);exit;
							if($All_Category_row["{$va['UId']}{$vCateId},"]){
								foreach($All_Category_row["{$va['UId']}{$vCateId},"] as $ks => $vs){
									$v1CateId[] = $vs['CateId'];
								}
							}

						}
						if($vaCateId && $v1CateId){
							$CateIdss = array_merge($vaCateId,$v1CateId);
							$CateIds = implode(",",$CateIdss);
						}elseif($vaCateId && !$v1CateId){
							$CateIdss = $vaCateId;
							$CateIds = implode(",",$CateIdss);
						}elseif(!$vaCateId && $v1CateId){
							$CateIdss = $v1CateId;
							$CateIds = implode(",",$CateIdss);
						}else{
							$CateIds = '';
						}
						if($CateIds){
							$product_supplier = $db->get_all("product","CateId in (".$CateIds.") and IsUse=2 and Del=1","SupplierId");
							if($product_supplier){
								foreach ($product_supplier as $key_r1 => $value_r1) {
									$product_suppliers[] = $value_r1['SupplierId'];
								}
								$supplier_r = array_unique($product_suppliers);
								$suppliers = implode(",",$supplier_r);
								$where = "MemberId in ($suppliers) and IsSupplier=1 and Is_Business_License='1'";
							}else{
								$where = "IsSupplier=1 and Is_Business_License='1'";
							}
						}else{
							$where = "IsSupplier=1 and Is_Business_License='1'";
						}
					}else{
						if($suppliers){
							$where = "MemberId in ($suppliers) and IsSupplier=1 and Is_Business_License='1'";
						}else{
							$where = "IsSupplier=1 and Is_Business_License='1'";
						}
					}
					$supplier_row = $db->get_limit("member",$where,"*","RegTime desc","0","16");
		?>
			<?php if(count($supplier_row) > 8){ ?>
				<span id="gd">
					<span class='gengduo'><?=$website_language['products'.$lang]['gd']?></span>
					<i class='gengduo_img'></i>
				</span>
			<?php }?>
			<div id='box'>
			<div class="chanpsj"><?=$website_language['products'.$lang]['gys']?>：</div>
			<div id='box1'>
				<?php
					
					
					for ($i=0; $i < count($supplier_row); $i++) {
						$products_set = $db->get_row_count("product","SupplierId=".$supplier_row[$i]['MemberId']." and IsUse=2 and Del=1");
						if($products_set){
						//var_dump($supplier_row[$i]['LogoPath_1']);
				?>
							<a data='<?=$i?>' class="boa" href="/products.php?CateId=<?=$CateId?>&SupplierId=<?=$supplier_row[$i]['MemberId']?>&act=<?=$act?>&min=<?=$min_price?>&max=<?=$max_price?>&center_s=<?=$center_s?>&mode_s=<?=$mode_s?>&mode=<?=$mode?>">
								<img class="boa_img" src="<?=is_file($site_root_path.$supplier_row[$i]['LogoPath']) ? $supplier_row[$i]['LogoPath'] : '/images/nopacpath.jpg' ;?>" alt=""><img class="boa_queding" src="/images/products/queding.png" alt="">
							</a>
			<?php }}?>	
				
			</div>							
			</div>
			<div class="ac">
				<form action="" method="get">
					<div class="jiageqj"><?=$website_language['products'.$lang]['jgqj']?>：</div>
					<div class="pos">
						<input class="min_max" type="text" name="min" placeholder="min" value="<?=$min_price ? $min_price : '';?>">
						<span>-</span>
						<input  class="min_max" type="text" name="max" placeholder="max"  value="<?=$max_price ? $max_price : '';?>">
						<input class="qujian" type="submit" value="<?=$website_language['products'.$lang]['qd']?>" style="">
						<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
						<input type="hidden" name="act" value="<?=$act?>">
						<input type="hidden" name="mode_s" value="<?=$mode_s?>">
						<input type="hidden" name="center_s" value="<?=$center_s?>">
						<input type="hidden" name="CateId" value="<?=$CateId?>">
						<input type="hidden" name="mode" value="min_max">
						<input type="hidden" name="page" value="<?=$page?>">
					</div>
				</form>												
			</div> 

			<div class="ac1">
			<div class="f_14">
				<form action="">
					<div class="paixufs"><?=$website_language['products'.$lang]['pxfs']?>：</div>
					<div class="hie">
						<?php 
							if($_GET['act'] == 'new'){
						?>
						<a data='1' class="hie_list hie_list_color" href="products.php?CateId=<?=$CateId?>&act=new&SupplierId=<?=$SupplierId?>&min=<?=$min_price?>&max=<?=$max_price?>&center_s=<?=$center_s?>&mode_s=<?=$mode_s?>&mode=<?=$mode?>&page=<?=$page?>"><?=$website_language['products'.$lang]['zx']?></a>
						<?php }else{?>
						<a data='1' class="hie_list" href="products.php?CateId=<?=$CateId?>&act=new&SupplierId=<?=$SupplierId?>&min=<?=$min_price?>&max=<?=$max_price?>&center_s=<?=$center_s?>&mode_s=<?=$mode_s?>&mode=<?=$mode?>&page=<?=$page?>"><?=$website_language['products'.$lang]['zx']?></a>
						<?php }?>
						<?php 
							if($_GET['act'] == 'Selling'){
						?>
						<a data='2' class="hie_list hie_list_color" href="products.php?CateId=<?=$CateId?>&act=Selling&SupplierId=<?=$SupplierId?>&min=<?=$min_price?>&max=<?=$max_price?>&center_s=<?=$center_s?>&mode_s=<?=$mode_s?>&mode=<?=$mode?>&page=<?=$page?>"><?=$website_language['products'.$lang]['zr']?></a>
						<?php }else{?>
						<a data='2' class="hie_list" href="products.php?CateId=<?=$CateId?>&act=Selling&SupplierId=<?=$SupplierId?>&min=<?=$min_price?>&max=<?=$max_price?>&center_s=<?=$center_s?>&mode_s=<?=$mode_s?>&mode=<?=$mode?>&page=<?=$page?>"><?=$website_language['products'.$lang]['zr']?></a>
						<?php }?>
						<?php 
							if($_GET['act'] == 'Price_desc'){
						?>
							<a data='3' class="hie_list hie_list_color jiage" href="/products.php?CateId=<?=$CateId?>&act=Price_asc&SupplierId=<?=$SupplierId?>&min=<?=$min_price?>&max=<?=$max_price?>&center_s=<?=$center_s?>&mode_s=<?=$mode_s?>&mode=<?=$mode?>&page=<?=$page?>"><?=$website_language['products'.$lang]['jgsx']?></a>&nbsp;<span class='ccc'><img src="/images/products/jiage01.png" alt=""></span>
						<?php }elseif($_GET['act'] == 'Price_asc'){?>
							<a data='3' class="hie_list hie_list_color jiage" href="/products.php?CateId=<?=$CateId?>&act=Price_desc&SupplierId=<?=$SupplierId?>&min=<?=$min_price?>&max=<?=$max_price?>&center_s=<?=$center_s?>&mode_s=<?=$mode_s?>&mode=<?=$mode?>&page=<?=$page?>"><?=$website_language['products'.$lang]['jgjx']?></a>&nbsp;<span class='ccc'><img src="/images/products/jiage02.png" alt=""></span>
						<?php }else{?>
							<a data='3' class="hie_list jiage" href="/products.php?CateId=<?=$CateId?>&act=Price_desc&SupplierId=<?=$SupplierId?>&min=<?=$min_price?>&max=<?=$max_price?>&center_s=<?=$center_s?>&mode_s=<?=$mode_s?>&mode=<?=$mode?>&page=<?=$page?>"><?=$website_language['products'.$lang]['jgjx']?></a>&nbsp;<span class='ccc'><img src="/images/products/jiage00.png" alt=""></span>
						<?php }?>
					</div>
				</form>
			</div>				
							
			</div>
			</div>
			<div class="selling">

				<div class="selling_bg">
				<?php if($product_count){ ?>
					<?php 

					foreach((array)$product_list_row as $k => $v){ 
					$name = $v['Name'.$lang];
					$img = $v['PicPath_0'];
					$price = $v['Price_1'];
					$url = get_url('product',$v);
					$ProId = $v['ProId'];
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
					<div class="wzd1">  没有找到与“<d class="wzd"><?=$center_s?></d>”相关的商品</div>
				</div>
			<?php }?>
			</div>
			<form action="products.php?CateId=<?=$CateId?>" method="post">
			<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "products.php?SupplierId=".$SupplierId."&min=".$min_price."&max=".$max_price."&center_s=".$center_s."&mode_s=".$mode_s."&mode=".$mode."&act=".$act."&CateId=".$CateId."&page=", $row_count, '〈', '〉');?></div>
			</form>
		</div>	
</div>
 <?php include("./inc/common/footer.php");?>
</body>
</html>

<script src="./js/products.js"></script>
<script>
	$(function(){
		$('.selling_bg').each(function(){
			$(this).children("div:eq(4)").css('margin-right','0px');
			$(this).children("div:eq(9)").css('margin-right','0px');
			$(this).children("div:eq(14)").css('margin-right','0px');
			$(this).children("div:eq(19)").css('margin-right','0px');
			$(this).children("div:eq(24)").css('margin-right','0px');
			$(this).children("div:eq(29)").css('margin-right','0px');
		})
	})	
</script>
<script>
$(function(){
		$('.Commodity_namea').each(function(){
		var he=$(this).find('.Commodity_name').css('height');
		if(he>'32px'){
			$(this).find('.slh').css('display','block');
		}else{
			$(this).find('.slh').css('display','none');
		}
	})
		var mode = '<?=$mode?>';
		if(mode=='min_max'){
			$('.qujian').css('color','#666');
			$('.qujian').hover(function(){
				$('.qujian').css('background','#2962ff').css('border','1px solid #2962ff').css('color','#f2f2f2');
			},function(){
				$('.qujian').css('background','#fff').css('border','1px solid #ccc').css('color','#666');
			})
		}
	$('.navigation span:last').each(function(){
			$(this).children('i').html('');			
		})
		$('.navigation span:first').each(function(){
			$(this).children('i').html('');
			$(this).css('color','#333');
		})
	var vg=window.sessionStorage.getItem('jiage');
	// if(vg=='1'){
	// 	$('.jiage').text('价格升序');
	// 	$('.ccc').css('background','url(/images/products/jiage01.png) no-repeat center');
	// }else if(vg=='2'){
	// 	$('.jiage').text('价格降序');
	// 	$('.ccc').css('background','url(/images/products/jiage02.png) no-repeat center');
	// }
	// $('.jiage').click(function(){
	// 	var v=$(this).text();	
	// 	if(v=='价格升序'){			
	// 		window.sessionStorage.setItem('jiage','2');		
	// 	}else{			
	// 		window.sessionStorage.setItem('jiage','1');
	// 	}
	// })
	var dsg=window.sessionStorage.getItem('dss');
	var cc=$('.hie_list').attr('data');
	var url=location.search;
	var urltest=url.indexOf('act');
	if(urltest=='-1'){	
		$('.hie_list').each(function(){
			var cs=$(this).attr('data');
			if(cs=='1'){
				$('.hie_list').removeClass('hie_list_color');
				$(this).addClass('hie_list_color');
			}
		})
	}else if(urltest=='2'){	
		$('.hie_list').each(function(){
			var cs=$(this).attr('data');
			if(cs=='1'){
				$('.hie_list').removeClass('hie_list_color');
				$(this).addClass('hie_list_color');
			}
		})
	}
	else if(dsg=='1'){
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
})
	$(function(){		
	var al=$("#box a").length;		
	var flag=true;
	$("#gd").click(function(){
		if(flag){
			$("#gd span").html("<?=$website_language['products'.$lang]['sq']?>");	
			$("#gd i").css("background-position","4px -41px");
			$("#gd i").css("transition","background-position .15s ease-in-out");							
			if(al<9){
				$("#box").css("overflow-y","hidden");
				$("#box").css("height","87px");
			}else{
				$("#box").css("overflow-y","scroll");		
				$("#box").css('height','160px');	
				window.sessionStorage.setItem('seset',10);
			}			
			$("#gd").hover(function(){
			$("#gd i").css("background-position","4px -42px");
			$("#gd span").css("color","#2962ff");
			$("#gd i").css("transition","background-position .15s ease-in-out");	
	},function(){
			$("#gd i").css("background-position","4px -24px");
			$("#gd span").css("color","#000");
			$("#gd i").css("transition","background-position .15s ease-in-out");	
	})
			flag=false;
		}else{
			$("#gd span").html("<?=$website_language['products'.$lang]['gd']?>");
			$("#gd i").css("background-position","4px -7px");
			$("#gd i").css("transition","background-position .15s ease-in-out");
			$("#box").css('height','87px');						
			$("#box").css("overflow","hidden");
			window.sessionStorage.setItem('seset',1);
			$("#gd").hover(function(){
			$("#gd i").css("background-position","4px -8px");
			$("#gd span").css("color","#2962ff");
			$("#gd i").css("transition","background-position .15s ease-in-out");	
	},function(){
			$("#gd i").css("background-position","4px 11px");
			$("#gd span").css("color","#000");
			$("#gd i").css("transition","background-position .15s ease-in-out");	
	})
			flag=true;
		}						
	})
		$("#gd").hover(function(){
			$("#gd i").css("background-position","4px -7px");
			$("#gd span").css("color","#2962ff");
			$("#gd i").css("transition","background-position .15s ease-in-out");	
	},function(){
			$("#gd i").css("background-position","4px 10px");
			$("#gd span").css("color","#666666");
			$("#gd i").css("transition","background-position .15s ease-in-out");	
	})
	var dfget=window.sessionStorage.getItem('dfset');
	var seget=window.sessionStorage.getItem('seset');
	if(seget>=10){
		$("#box").css("overflow-y","scroll");		
		$("#box").css('height','160px');
		$("#gd span").html("<?=$website_language['products'.$lang]['sq']?>");	
		$("#gd i").css("background-position","4px -41px");
		flag=false;
	}
	$('.boa').each(function(){
		var sc=$(this).attr('data');
		if(dfget==sc){
			$(this).css('border','1px solid #2962ff');
			$(this).find('.boa_queding').css('display','block');
		}
	})
	$('.boa').click(function(){
		var dfset=$(this).attr('data');
		window.sessionStorage.setItem("dfset",dfset);
		window.sessionStorage.setItem("dss",1);
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