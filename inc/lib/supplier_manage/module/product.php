<?php 
include($site_root_path.'/inc/lang/cn.php');
include($site_root_path.'/inc/manage/config/1.php');
/*if($_SESSION['IsSupplier'] !== '1'){
  
    echo '<script>alert("只有商户才能访问");</script>';
    header("Refresh:0;url=/");
    exit;
}*/

$SupplierId = $_SESSION['member_MemberId'];
if($_GET['act_r'] == 'del_one'){
	$ProId = $_GET['ProId'];
	$db->get_one("product","ProId=".$ProId." and SupplierId=".$SupplierId);

	if($db->get_one("product","ProId=".$ProId." and SupplierId=".$SupplierId)){
		$db->update("product","ProId='$ProId'",array(
				'Del'	=>	'0',
			));
		echo '<script>alert("删除成功");</script>';
	    header("Refresh:0;url=/supplier_manage.php?module=product&act=".$act."&page=".$page);
	    exit;
	}else{
		echo '<script>alert("请不要进行非法操作");</script>';
	    header("Refresh:0;url=/supplier_manage.php?module=product&act=".$act."&page=".$page);
	    exit;
	}
}
$act=(int)$_GET['act'];
$where = "SupplierId='$SupplierId' and Del=1";
$ext_where=$_GET['ext_where'];
$ext_where && $where.=" and $ext_where";
$order_bay = "AccTime desc";
$Name=$_GET['Name'];
$Stock_order = $_GET['Stock_order'];
$CateId=(int)$_GET['CateId'];
$Name && $where.=" and (Name_lang_1 like '%$Name%' or Name like '%$Name%' or Name_lang_1 like '%$Name%')" ;

$CateId && $where.=' and '.get_search_where_by_CateId($CateId, 'product_category');
if($Stock_order == '1'){
	$order_bay = "Stock desc";
	
}elseif ($Stock_order == '2') {
	$order_bay = "Stock asc";
}
$row_count=$db->get_row_count('product', $where);
$total_pages=ceil($row_count/20);
$page=(int)$_GET['page'];
if($_POST['page_input']){
	$page_input = $_POST['page_input'];
	$page = $page_input;
	header("Location: /supplier_manage.php?module=product&act=$act&page=$page");
	exit;
}
$page<1 && $page=1;
$page>$total_pages && $page=1;

$start_row=($page-1)*get_cfg('product.page_count');
$product_row = $db->get_limit("product",$where,'*',$order_bay ,$start_row,'20');
$select_category=ouput_Category_to_Select2('CateId', $CateId, 'product_category', 'UId="0,"', 1, $website_language['ylfy'.$lang]['xz']);
$cate_ary=$db->get_all('product_category');
for($i=0; $i<count($cate_ary); $i++){
	$category[$cate_ary[$i]['CateId']]=$cate_ary[$i];
}
?>
<?php
	echo '<link rel="stylesheet" href="/css/supplier_m/product'.$lang.'.css">'
?>

<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['header'.$lang]['mjzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/supplier_manage.php?module=index&act=1" class='s1'><?=$website_language['supplier_m_index'.$lang]['dpgl']?></a>						
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=index&act=2" class='s1'><?=$website_language['supplier_m_index'.$lang]['gggl']?></a>			
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=product&act=3" class='s2'><?=$website_language['supplier_m_index'.$lang]['cpgl']?></a>			
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=order&act=4" class='s1'><?=$website_language['supplier_m_index'.$lang]['ddgl']?></a>		
		</li>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['supplier_m_index'.$lang]['cpgl']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>		
		<form method="get" action="">
		<div class="yhh">
		<style>
			
		</style>
			<div class="bg1">
				<div class="w_270_es"><?=$website_language['supplier_m_product'.$lang]['cpmc']?>：<input type="text" class="y_text" name="Name" value="<?=$Name?>"></div>
				<div class="w_2701"><?=$website_language['supplier_m_product'.$lang]['cpfl']?>：
					<?=str_replace('<select','<select class="form_select"',$select_category);?>
				</div>
				<div class="w_2702"><?=$website_language['supplier_m_product'.$lang]['shzt']?>：
					<select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="ext_where" id="">
           		<option value=''>--<?=get_lang('ly200.select1');?>--</option>
           		<?php ?>
                <option value='IsUse=0' <?=$ext_where == 'IsUse=0' ? selected : '';?>><?=$website_language['ylfy'.$lang]['shz']?></option>
                <option value='IsUse=1' <?=$ext_where == 'IsUse=1' ? selected : '';?>><?=$website_language['ylfy'.$lang]['shbtg']?></option>
                <option value='IsUse=2' <?=$ext_where == 'IsUse=2' ? selected : '';?>><?=$website_language['ylfy'.$lang]['shtg']?></option>
            </select>
				</div>
				<input type="hidden" name="act" value="<?=$act?>">
				<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
				<div class="w_2703"><input type="submit" class="submit_txt"  value="<?=$website_language['supplier_m_product'.$lang]['qd']?>"><a class="tj" style='color:#fff'  href="/supplier_manage.php?module=product_add"><?=$website_language['supplier_m_product'.$lang]['tj']?></a></div>
			</div>	
			</form>
<form method="post" action="/supplier_manage.php?module=product">
			<div class="product_yhh_t">
				<div class="product_yhh_t_1"><?=$website_language['supplier_m_product'.$lang]['xh']?></div>
				<div class="product_yhh_t_2"><?=$website_language['supplier_m_product'.$lang]['cpmc']?></div>
				<div class="product_yhh_t_3"><?=$website_language['supplier_m_product'.$lang]['tp']?></div>
				<div class="product_yhh_t_4"><?=$website_language['supplier_m_product'.$lang]['dj']?></div>
				<div class="product_yhh_t_31"><?=$website_language['supplier_m_product'.$lang]['kcl']?></div>
				<div class="product_yhh_t_32"><?=$website_language['supplier_m_product'.$lang]['qdl']?></div>
				<div class="product_yhh_t_5"><?=$website_language['supplier_m_product'.$lang]['lb']?></div>
				<div class="product_yhh_t_6"><?=$website_language['supplier_m_product'.$lang]['shzt']?></div>
				<div class="product_yhh_t_7"><?=$website_language['supplier_m_product'.$lang]['cjsj']?></div>
				<div class="product_yhh_t_8"><?=$website_language['supplier_m_product'.$lang]['cz']?></div>
			</div>
			<?php 
				for ($i=0; $i < count($product_row); $i++) { 
					
			?>
			<div class="product_yhh_t1">
				<div class="product_yhh_t_1"><?=$start_row+$i+1;?></div>
				<div class="product_yhh_t_2" title="<?=$product_row[$i]['Name_lang_1']?>"><?=$product_row[$i]['Name_lang_1']?></div>
				<div class="product_yhh_t_3">
					<a  href="<?=get_url('product', $product_row[$i]);?>" target="_blank"><img style="width:30px;height:30px;padding:5px 0" src="<?=$product_row[$i]['PicPath_0'];?>" alt=""></a>
				</div>
				<div class="product_yhh_t_4t">USD $<?=$product_row[$i]['Price_1'];?></div>
				<div class="product_yhh_t_31"><?=$product_row[$i]['Stock'];?></div>
				<div class="product_yhh_t_32t"><?=$product_row[$i]['StartFrom']?></div>
				<div class="product_yhh_t_5">
					<?php
	                   
	                    $UId=$category[$product_row[$i]['CateId']]['UId'];
	                    $current_key_ary=@explode(',', $UId);
	                    echo $category[$product_row[$i]['CateId']]['Category'.$lang];
	                ?>
	               
		        </div>
				<div class="product_yhh_t_6t">
					<?=$product_row[$i]['IsUse']==0? $website_language['ylfy'.$lang]['shz'].'<br>':'';?>
                    <?=$product_row[$i]['IsUse']==1? '<span style="color:red;">'.$website_language['ylfy'.$lang]['shbtg'].'</span><br>':'';?>
                    <?=$product_row[$i]['IsUse']==2? '<span style="color:blue;">'.$website_language['ylfy'.$lang]['shtg'].'</span><br>':'';?>
                    <?=(get_cfg('product.is_in_index') && $product_row[$i]['IsInIndex'])?get_lang('ly200.is_in_index').'<br>':'';?>
                    <?=(get_cfg('product.is_hot') && $product_row[$i]['IsHot'])?get_lang('product.is_hot').'<br>':'';?>
                    <?=(get_cfg('product.is_recommend') && $product_row[$i]['IsRecommend'])?get_lang('product.is_recommend').'<br>':'';?>
                    <?=(get_cfg('product.is_new') && $product_row[$i]['IsNew'])?get_lang('product.is_new').'<br>':'';?>
                    <?=(get_cfg('product.is_featured') && $product_row[$i]['IsFeatured'])?get_lang('product.is_featured').'<br>':'';?>
                    <?=get_cfg('product.sold_out')?get_lang('product.sold_out').':'.get_lang('ly200.n_y_array.'.$product_row[$i]['SoldOut']).'<br>':'';?>

				</div>
				<div class="product_yhh_t_7t"><?=date('Y-m-d H:i:s', $product_row[$i]['AccTime']);?></div>
				<div class="operation product_yhh_t_8" style=''>
					<a href="/supplier_manage.php?module=product_mod&ProId=<?=$product_row[$i]['ProId']?>"><?=$website_language['supplier_m_product'.$lang]['xg']?></a>
					<a href="/supplier_manage.php?module=product&act_r=del_one&ProId=<?=$product_row[$i]['ProId']?>&SupplierId=<?=$SupplierId?>&act=3"><?=$website_language['supplier_m_product'.$lang]['sc']?></a>
				</div>

			</div>
			<?php }?>
				<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "/supplier_manage.php?module=product&act=".$act."&SupplierId=".$SupplierId."?$query_string&page=", $row_count, '〈', '〉');?></div>
				<input type="hidden" name="module" value="<?=$_GET['module']?>">
		
		</div>

	</div>
	</div>
</div>

</form>