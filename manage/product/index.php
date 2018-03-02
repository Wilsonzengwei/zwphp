<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'product';
check_permit('product');
if($_POST['list_form_action']=='product_order'){
	check_permit('', 'product.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$order=abs((int)$_POST['MyOrder'][$i]);
		$ProId=(int)$_POST['ProId'][$i];
		
		$db->update('product', "ProId='$ProId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	save_manage_log('产品排序');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}
if($_GET['act']=='del_one'){
	$ProId = $_GET['ProId'];
	$where = "ProId='$ProId'";
	$db->update('product', $where,array(
		'Del'	=>	'0',
		));
/*	$product_row=$db->get_all('product', $where,"*","AccTime");
		del_file($product_row['PageUrl']);
		if(get_cfg('product.pic_count')){
			for($j=0; $j<get_cfg('product.pic_count'); $j++){
				del_file($product_row['PicPath_'.$j]);
				del_file(str_replace('s_', '', $product_row['PicPath_'.$j]));
				foreach(get_cfg('product.pic_size') as $key=>$value){
					del_file(str_replace('s_', $value.'_', $product_row['PicPath_'.$j]));
				}
			}
		}
	
	
	$db->delete('product_ext', "ProId='$ProId'");
	$db->delete('product_description', "ProId='$ProId'");
	$db->delete('product_wholesale_price',"ProId='$ProId'");
	$db->delete('product', $where);*/
	save_manage_log('删除产品');
	
	echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
	exit;
}
$GroupId = $_SESSION['ly200_AdminGroupId'];
$SupplierId = $_GET['SupplierId'];

$admin_userId = $_SESSION['ly200_AdminUserId'];
if($_POST['list_form_action']=='product_move'){
	check_permit('', 'product.move');
	$CateId=(int)$_POST['CateId'];
	$ProId=implode(',', $_POST['select_ProId']);
	count($_POST['select_ProId']) && move_to_other_category('product', $CateId, "ProId in($ProId)");
	
	save_manage_log('批量移动产品');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['bat_form_action']=='product_move'){
	check_permit('', 'product.move');
	$SorceCateId=(int)$_POST['SorceCateId'];
	$DestCateId=(int)$_POST['DestCateId'];
	($SorceCateId && $DestCateId && $SorceCateId!=$DestCateId) && move_to_other_category('product', $DestCateId, get_search_where_by_CateId($SorceCateId, 'product_category'));
	
	save_manage_log('批量移动产品');
	
	header('Location: index.php');
	exit;
}

if($_POST['list_form_action']=='product_del'){
	check_permit('', 'product.del');
	if(count($_POST['select_ProId'])){
		$ProId=implode(',', $_POST['select_ProId']);
		$where="ProId in($ProId)";
		$db->update('product', $where,array(
			'Del'	=>	'0',
			));
/*		$product_row=$db->get_all('product', $where,"*","AccTime");
		for($i=0; $i<count($product_row); $i++){
			del_file($product_row[$i]['PageUrl']);
			if(get_cfg('product.pic_count')){
				for($j=0; $j<get_cfg('product.pic_count'); $j++){
					del_file($product_row[$i]['PicPath_'.$j]);
					del_file(str_replace('s_', '', $product_row[$i]['PicPath_'.$j]));
					foreach(get_cfg('product.pic_size') as $key=>$value){
						del_file(str_replace('s_', $value.'_', $product_row[$i]['PicPath_'.$j]));
					}
				}
			}
		}
		
		$db->delete('product_ext', "ProId in(select ProId from product where $where)");
		$db->delete('product_description', "ProId in(select ProId from product where $where)");
		$db->delete('product_wholesale_price', "ProId in(select ProId from product where $where)");
		$db->delete('product', $where);*/
	
	save_manage_log('批量删除产品');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	echo '<script>alert("批量删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
	exit;
	}else{
		echo '<script>alert("未选中选项,批量删除失败");</script>';
	    header('Refresh:0;url=index.php?$query_string&page=$page"');
		exit;
	}
}

if($_POST['bat_form_action']=='product_del'){
	check_permit('', 'product.del');
	$CateId=(int)$_POST['CateId'];
	
	if($CateId){
		$where=get_search_where_by_CateId($CateId, 'product_category');
		
		$product_row=$db->get_all('product', $where);
		for($i=0; $i<count($product_row); $i++){
			del_file($product_row[$i]['PageUrl']);
			if(get_cfg('product.pic_count')){
				for($j=0; $j<get_cfg('product.pic_count'); $j++){
					del_file($product_row[$i]['PicPath_'.$j]);
					del_file(str_replace('s_', '', $product_row[$i]['PicPath_'.$j]));
					foreach(get_cfg('product.pic_size') as $key=>$value){
						del_file(str_replace('s_', $value.'_', $product_row[$i]['PicPath_'.$j]));
					}
				}
			}
		}
		
		$db->delete('product_ext', "ProId in(select ProId from product where $where)");
		$db->delete('product_description', "ProId in(select ProId from product where $where)");
		$db->delete('product_wholesale_price', "ProId in(select ProId from product where $where)");
		$db->delete('product', $where);
	}
	save_manage_log('批量删除产品');
	
	header('Location: index.php');
	exit;
}

if($_GET['query_string']){
	$page=(int)$_GET['page'];
	header("Location: index.php?{$_GET['query_string']}&page=$page");
	exit;
}

$order_by_ary=array(
	0=>'',
	1=>'Stock asc,',
	2=>'Stock desc,',
	3=>'AccTime asc,',
	4=>'AccTime desc,'
);

//分页查询
$where="Del=1";

$Supplier = mysql_real_escape_string($_GET['Supplier']);
$Supplier && $supplier_list = $db->get_all('member',"Supplier_Name like '%$Supplier%' or Email like '%$Supplier%'",'MemberId');
if($supplier_list){
    $supplier_id = array();
    foreach((array)$supplier_list as $v){
        $supplier_id[] = $v['MemberId'];
    }
    $supplier_id=implode(',', $supplier_id);
}
$supplier_id && $where.=" and SupplierId in ({$supplier_id})";
$Supplier_Name2_s = $_GET['Supplier_Name2_s'];
if($Supplier_Name2_s){
	$supplier_ids=$db->get_all("member","Supplier_Name2 like '%$Supplier_Name2_s%'","MemberId");
	$str_s1 = array();
	foreach ($supplier_ids as $str_s1 => $vstr_s) {
		$str_s1 = $vstr_s;
	}
	//var_dump($str_s1);exit;
	$str_s = implode(",",$str_s1);
	if($str_s){
		$where .= " and SupplierId in ('$str_s')";
	}
}
$Name=$_GET['Name'];
$ItemNumber=$_GET['ItemNumber'];
$Model=$_GET['Model'];
$CateId=(int)$_GET['CateId'];
$ext_where=$_GET['ext_where'];
$OrderBy=(int)$_GET['OrderBy'];
$ProductCodeId = (int)$_GET['ProductCodeId'];
($OrderBy<0 || count($order_by_ary)<=$OrderBy) && $OrderBy=0;

$ProductCodeId && $where.=" and ProductCodeId like '%$ProductCodeId%'";

$Name && $where.=" and Name_lang_1 like '%$Name%' or Name like '%$Name%'" ;
if(!$db->get_one('product',"Name_lang_1='$Name'")){
$Name && $where.=" and Name like '%$Name%' or Name like '%$Name%'" ;
}
$ItemNumber && $where.=" and ItemNumber like '%$ItemNumber%'";
$Model && $where.=" and Model='$Model'";
$CateId && $where.=' and '.get_search_where_by_CateId($CateId, 'product_category');
$ext_where && $where.=" and $ext_where";
//var_dump($ext_where);exit;
$row_count=$db->get_row_count('product', $where);
$total_pages=ceil($row_count/get_cfg('product.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
if($_POST['page_input']){
	$page_input = $_POST['page_input'];
	$page = $page_input;
}
$start_row=($page-1)*get_cfg('product.page_count');
if($SupplierId){
    $where.=" and SupplierId='$SupplierId'";
    $row_count = $db->get_row_count('product',"SupplierId=$SupplierId");
    $total_pages=ceil($row_count/get_cfg('product.page_count'));
    $page=(int)$_GET['page'];
    $page<1 && $page=1;
    $page>$total_pages && $page=1;
    $start_row=($page-1)*get_cfg('product.page_count');

}
$product_row=$db->get_limit('product', $where, '*', "IsUse asc,".$order_by_ary[$OrderBy].'AccTime desc, ProId desc', $start_row, get_cfg('product.page_count'));
$product_row_s=$db->get_all('product', $where, '*', $order_by_ary[$OrderBy].'AccTime desc, ProId desc');
//获取类别列表
$cate_ary=$db->get_all('product_category');
for($i=0; $i<count($cate_ary); $i++){
	$category[$cate_ary[$i]['CateId']]=$cate_ary[$i];
}
$category_count=$db->get_row_count('product_category');
$select_category=ouput_Category_to_Select('CateId', $CateId, 'product_category', 'UId="0,"', 1, get_lang('ly200.select'));

//获取页面跳转url参数
$query_string=query_string('page');
$all_query_string=query_string();

include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
        <span style="font-size:14px;color:#666;margin-left:20px">产品名称:</span>
        <input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="Name" value="<?=$Name?>">
       
        <span style="font-size:14px;color:#666;margin-left:20px">货号:</span>
        <?php if(!$ProductCodeId){$ProductCodeId='';};?>
        <input style="width:90px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="ProductCodeId" value="<?=$ProductCodeId?>">
        <!-- <span style="font-size:14px;color:#666;margin-left:5px">产品来源:</span>
            <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="" id="">
                <option value="">全部</option>
            </select> -->
        <span style="font-size:14px;color:#666;margin-left:20px">商户:</span>
        <input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="Supplier_Name2_s" value="<?=$Supplier_Name2_s?>">
        <span style="font-size:14px;color:#666;margin-left:5px">审核状态:</span>
            <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="ext_where" id="">
           		<option value=''>--<?=get_lang('ly200.select');?>--</option>
           		<?php ?>
                <option value='IsUse=0' <?=$ext_where == 'IsUse=0' ? selected : '';?>>审核中</option>
                <option value='IsUse=1' <?=$ext_where == 'IsUse=1' ? selected : '';?>>审核不通过</option>
                <option value='IsUse=2' <?=$ext_where == 'IsUse=2' ? selected : '';?>>审核通过</option>
            </select>
        <span style="font-size:14px;color:#666;margin-left:5px">类目:</span>
            <?=str_replace('<select','<select style="width:150px;" class="form_select"',$select_category);?>
        <input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">
</form>
<form style="width:100%;background:#ececec;margin-top:30px" name="list_form" id="list_form" class="list_form"  method="post" action="index.php">
        <div>
            <a href="add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加产品</a>
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_ProId[]");' value="全选">
            <input name="product_del" id="product_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
        
            <!-- <input type="button" value="批量禁用" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px"> -->
            <span style="position:absolute;right:20px">
                <span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px"><?=$row_count;?></span><span style="font-size:12px;color:#999">个产品</span>
            </span>
        </div>
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>货号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">产品名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>来源</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">所属商家</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:47px;text-align:left;overflow:hidden;text-align:center">图片</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">单价</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>审核状态</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>所属类目</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">创建时间</div></td>

                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>                               
                </tr>

				<?php
					for($i=0;$i<count($product_row);$i++){
						$supplier_id = $product_row[$i]['SupplierId'];
						$supplier_name = $db->get_one('member',"MemberId='$supplier_id'","Is_Business_License,Supplier_Name2");
						if($supplier_name['Is_Business_License'] == '1'){
							$supplier_mode = '普通商家';
						}else{
							$supplier_mode = '海外商家';
						}
				?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" >
                        <input class="yx" type="checkbox" name="select_ProId[]" id="" value="<?=$product_row[$i]['ProId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$start_row+$i+1;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$product_row[$i]['ProductCodeId']?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$product_row[$i]['Name_lang_1']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$supplier_mode;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$supplier_name['Supplier_Name2']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:47px;height:41px;text-align:left;overflow:hidden;text-align:center"><img style="width:100%;height:100%" src="<?=$product_row[$i]['PicPath_0']?>" alt=""></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><span><?=get_lang('ly200.price_symbols').$product_row[$i]['Price_1'];?></span><span>美元</span></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" >
	                    <?=$product_row[$i]['IsUse']==0? '审核中<br>':'';?>
	                    <?=$product_row[$i]['IsUse']==1? '<span style="color:red;">审核不通过</span><br>':'';?>
	                    <?=$product_row[$i]['IsUse']==2? '<span style="color:blue;">审核通过</span><br>':'';?>
	                    <?=(get_cfg('product.is_in_index') && $product_row[$i]['IsInIndex'])?get_lang('ly200.is_in_index').'<br>':'';?>
	                    <?=(get_cfg('product.is_hot') && $product_row[$i]['IsHot'])?get_lang('product.is_hot').'<br>':'';?>
	                    <?=(get_cfg('product.is_recommend') && $product_row[$i]['IsRecommend'])?get_lang('product.is_recommend').'<br>':'';?>
	                    <?=(get_cfg('product.is_new') && $product_row[$i]['IsNew'])?get_lang('product.is_new').'<br>':'';?>
	                    <?=(get_cfg('product.is_featured') && $product_row[$i]['IsFeatured'])?get_lang('product.is_featured').'<br>':'';?>
	                    <?=get_cfg('product.sold_out')?get_lang('product.sold_out').':'.get_lang('ly200.n_y_array.'.$product_row[$i]['SoldOut']).'<br>':'';?>
                

                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" >
						<?php
		                    $lang_key=lang_name(array_search($product_row[$i]['Language'], get_cfg('ly200.lang_array')), 1);
		                    $UId=$category[$product_row[$i]['CateId']]['UId'];	//按CateId获取对应的UId
		                    $current_key_ary=@explode(',', $UId);
		                  /*  for($m=1; $m<count($current_key_ary)-1; $m++){	//按CateId列表列出对应的类别名
		                        echo $category[$current_key_ary[$m]]['Category_lang_1'.$lang_key].'<font class="fc_red">-></font>';
		                    }*/
		                    echo $category[$product_row[$i]['CateId']]['Category_lang_1'.$lang_key];	//列表本身的类别名，因为UId不包含它本身
		                ?>
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date('Y-m-d H:i:s', $product_row[$i]['AccTime']);?></div></td>
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="mod.php?ProId=<?=$product_row[$i]['ProId']?>&SupplierId=<?=$product_row[$i]['SupplierId']?>&page=<?=$page?>">修改</a>
                        <a href="add.php?act=查看角色">查看</a>
                        <a href="index.php?act=del_one&ProId=<?=$product_row[$i]['ProId']?>&page=<?=$page?>">删除</a> 
                    </td>               
                </tr>
				<?php }?>
            </table>            
        </div> 
        <input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
        <input type="hidden" name="page" value="<?=$page;?>">
        <input name="list_form_action" id="list_form_action" type="hidden" value="">     
        <div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>
    </form>
<?php include('../../inc/manage/footer.php');?>