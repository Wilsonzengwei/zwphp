<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'gift';
check_permit('gift');

if($_POST['list_form_action']=='gift_order'){
	check_permit('', 'gift.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$order=abs((int)$_POST['MyOrder'][$i]);
		$ProId=(int)$_POST['ProId'][$i];
		
		$db->update('gift', "ProId='$ProId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	save_manage_log('礼品排序');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['list_form_action']=='gift_move'){
	check_permit('', 'gift.move');
	$CateId=(int)$_POST['CateId'];
	$ProId=implode(',', $_POST['select_ProId']);
	count($_POST['select_ProId']) && move_to_other_category('gift', $CateId, "ProId in($ProId)");
	
	save_manage_log('批量移动礼品');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['bat_form_action']=='gift_move'){
	check_permit('', 'gift.move');
	$SorceCateId=(int)$_POST['SorceCateId'];
	$DestCateId=(int)$_POST['DestCateId'];
	($SorceCateId && $DestCateId && $SorceCateId!=$DestCateId) && move_to_other_category('gift', $DestCateId, get_search_where_by_CateId($SorceCateId, 'gift_category'));
	
	save_manage_log('批量移动礼品');
	
	header('Location: index.php');
	exit;
}

if($_POST['list_form_action']=='gift_del'){
	check_permit('', 'gift.del');
	if(count($_POST['select_ProId'])){
		$ProId=implode(',', $_POST['select_ProId']);
		$where="ProId in($ProId)";
		
		$gift_row=$db->get_all('gift', $where);
		for($i=0; $i<count($gift_row); $i++){
			del_file($gift_row[$i]['PageUrl']);
			if(get_cfg('gift.pic_count')){
				for($j=0; $j<get_cfg('gift.pic_count'); $j++){
					del_file($gift_row[$i]['PicPath_'.$j]);
					del_file(str_replace('s_', '', $gift_row[$i]['PicPath_'.$j]));
					foreach(get_cfg('gift.pic_size') as $key=>$value){
						del_file(str_replace('s_', $value.'_', $gift_row[$i]['PicPath_'.$j]));
					}
				}
			}
		}
		
		$db->delete('gift_ext', "ProId in(select ProId from gift where $where)");
		$db->delete('gift_description', "ProId in(select ProId from gift where $where)");
		$db->delete('gift_wholesale_price', "ProId in(select ProId from gift where $where)");
		$db->delete('gift', $where);
	}
	save_manage_log('批量删除礼品');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['bat_form_action']=='gift_del'){
	check_permit('', 'gift.del');
	$CateId=(int)$_POST['CateId'];
	
	if($CateId){
		$where=get_search_where_by_CateId($CateId, 'gift_category');
		
		$gift_row=$db->get_all('gift', $where);
		for($i=0; $i<count($gift_row); $i++){
			del_file($gift_row[$i]['PageUrl']);
			if(get_cfg('gift.pic_count')){
				for($j=0; $j<get_cfg('gift.pic_count'); $j++){
					del_file($gift_row[$i]['PicPath_'.$j]);
					del_file(str_replace('s_', '', $gift_row[$i]['PicPath_'.$j]));
					foreach(get_cfg('gift.pic_size') as $key=>$value){
						del_file(str_replace('s_', $value.'_', $gift_row[$i]['PicPath_'.$j]));
					}
				}
			}
		}
		
		$db->delete('gift_ext', "ProId in(select ProId from gift where $where)");
		$db->delete('gift_description', "ProId in(select ProId from gift where $where)");
		$db->delete('gift_wholesale_price', "ProId in(select ProId from gift where $where)");
		$db->delete('gift', $where);
	}
	save_manage_log('批量删除礼品');
	
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
$where=1;
$Name=$_GET['Name'];
$ItemNumber=$_GET['ItemNumber'];
$Model=$_GET['Model'];
$CateId=(int)$_GET['CateId'];
$ext_where=$_GET['ext_where'];
$OrderBy=(int)$_GET['OrderBy'];
($OrderBy<0 || count($order_by_ary)<=$OrderBy) && $OrderBy=0;

$Name && $where.=" and Name like '%$Name%'";
$ItemNumber && $where.=" and ItemNumber like '%$ItemNumber%'";
$Model && $where.=" and Model='$Model'";
$CateId && $where.=' and '.get_search_where_by_CateId($CateId, 'gift_category');
$ext_where && $where.=" and $ext_where";

$row_count=$db->get_row_count('gift', $where);
$total_pages=ceil($row_count/get_cfg('gift.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('gift.page_count');
$gift_row=$db->get_limit('gift', $where, '*', $order_by_ary[$OrderBy].'MyOrder desc, ProId desc', $start_row, get_cfg('gift.page_count'));

//获取类别列表
$cate_ary=$db->get_all('gift_category');
for($i=0; $i<count($cate_ary); $i++){
	$category[$cate_ary[$i]['CateId']]=$cate_ary[$i];
}
$category_count=$db->get_row_count('gift_category');
$select_category=ouput_Category_to_Select('CateId', '', 'gift_category', 'UId="0,"', 1, get_lang('ly200.select'));

//获取页面跳转url参数
$query_string=query_string('page');
$all_query_string=query_string();

include('../../inc/manage/header.php');
?>
<div class="div_con">
    <?php include('../product/product_header.php');?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bat_form">
        <?php /*?><?php if($category_count>1 && (get_cfg('gift.move') || get_cfg('gift.del'))){?>
        <tr>
            <td height="22" class="flh_150">
                <?php if(get_cfg('gift.move')){?>
                    <div>
                        <form method="post" name="gift_move_form" action="index.php" onsubmit="this.submit.disabled=true;">
                            <?=get_lang('ly200.move');?>:<?=str_replace('CateId', 'SorceCateId', $select_category);?>-><?=str_replace('CateId', 'DestCateId', $select_category);?>
                            <input type="submit" name="submit" value="<?=get_lang('ly200.move');?>" class="form_button"><input type="hidden" name="bat_form_action" value="gift_move" />
                        </form>
                    </div>
                <?php }?>
                <?php if(get_cfg('gift.del')){?>
                    <div>
                        <form method="post" name="gift_del_form" action="index.php" onsubmit="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{if(checkForm(this)){this.submit.disabled=true;}else{return false;}}">
                            <?=get_lang('ly200.del');?>:<?=$select_category;?>
                            <input type="submit" name="submit" value="<?=get_lang('ly200.del');?>" class="form_button"><input type="hidden" name="bat_form_action" value="gift_del" />
                        </form>
                    </div>
                <?php }?>
            </td>
        </tr>
        <?php }?><?php */?>
        <tr>
            <td height="58" class="flh_150">
                <form method="get" name="gift_search_form" action="index.php" onsubmit="this.submit.disabled=true;">
                    <span class="fc_gray mgl14"><?=get_lang('ly200.name');?>:<input name="Name" class="form_input" type="text" size="25" maxlength='100'></span>
                    <?php if(get_cfg('gift.item_number')){?><span class="fc_gray mgl14"><?=get_lang('gift.item_number');?>:<input name="ItemNumber" class="form_input" type="text" size="15" maxlength='50'></span><?php }?>
                    <?php if(get_cfg('gift.model')){?><span class="fc_gray mgl14"><?=get_lang('gift.model');?>:<input name="Model" class="form_input" type="text" size="15" maxlength='50'></span><?php }?>
                    <?php if($category_count>1){?><span class="fc_gray mgl14"><?=get_lang('ly200.category');?>:<?=str_replace('<select','<select class="form_select"',$select_category);?></span><?php }?>
                    <?php if(get_cfg('gift.is_in_index') || get_cfg('gift.is_hot') || get_cfg('gift.is_recommend') || get_cfg('gift.is_new') || get_cfg('gift.sold_out') || (get_cfg('gift.price') && get_cfg('gift.special_offer'))){?>
                        <span class="fc_gray mgl14"><?=get_lang('ly200.other_property');?>:<select name="ext_where" class="form_select">
                            <option value=''>--<?=get_lang('ly200.select');?>--</option>
                            <?php if(get_cfg('gift.is_in_index')){?><option value='IsInIndex=1'><?=get_lang('ly200.is_in_index');?></option><?php }?>
                            <?php if(get_cfg('gift.is_hot')){?><option value='IsHot=1'><?=get_lang('gift.is_hot');?></option><?php }?>
                            <?php if(get_cfg('gift.is_recommend')){?><option value='IsRecommend=1'><?=get_lang('gift.is_recommend');?></option><?php }?>
                            <?php if(get_cfg('gift.is_new')){?><option value='IsNew=1'><?=get_lang('gift.is_new');?></option><?php }?>
                            <?php if(get_cfg('gift.sold_out')){?><option value='SoldOut=1'><?=get_lang('gift.sold_out');?></option><?php }?>
                            <?php if(get_cfg('gift.price') && get_cfg('gift.special_offer')){?><option value='IsSpecialOffer=1'><?=get_lang('gift.special_offer');?></option><?php }?>
                        </select></span>
                    <?php }?>
                    <span class="fc_gray mgl14"><?=get_lang('ly200.order');?>:<select name="OrderBy" class="form_select">
                        <option value='0'>--<?=get_lang('ly200.select');?>--</option>
                        <?php if(get_cfg('gift.stock')){?>
                            <option value="1"><?=get_lang('gift.stock_asc');?></option>
                            <option value="2"><?=get_lang('gift.stock_desc');?></option>
                        <?php }?>
                        <option value="3"><?=get_lang('gift.time_asc');?></option>
                        <option value="4"><?=get_lang('gift.time_desc');?></option>
                    </select></span>
                    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button">
                </form>
            </td>
        </tr>
    </table>
    <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
        <tr align="center" class="list_form_title" id="list_form_title">
            <td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <?php if(get_cfg('gift.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <?php if(get_cfg('gift.order')){?><td width="5%" nowrap><strong><?=get_lang('ly200.order');?></strong></td><?php }?>
            <td width="20%" nowrap><strong><?=get_lang('ly200.name');?></strong></td>
            <?php if(get_cfg('gift.item_number')){?><td width="10%" nowrap><strong><?=get_lang('gift.item_number');?></strong></td><?php }?>
            <?php if(get_cfg('gift.model')){?><td width="10%" nowrap><strong><?=get_lang('gift.model');?></strong></td><?php }?>
            <?php if(get_cfg('gift.price')){?><td width="10%" nowrap><strong><?=get_lang('gift.price');?></strong></td><?php }?>
            <?php if(get_cfg('gift.stock')){?><td width="5%" nowrap><strong><?=get_lang('gift.stock');?></strong></td><?php }?>
            <?php if(get_cfg('gift.start_from')){?><td width="5%" nowrap><strong><?=get_lang('gift.start_from');?></strong></td><?php }?>
            <?php if($category_count>1){?><td width="15%" nowrap><strong><?=get_lang('ly200.category');?></strong></td><?php }?>
            <?php if(get_cfg('gift.pic_count')){?><td width="8%" nowrap><strong><?=get_lang('ly200.photo');?></strong></td><?php }?>
            <?php if(get_cfg('gift.is_in_index') || get_cfg('gift.is_hot') || get_cfg('gift.is_recommend') || get_cfg('gift.is_new') || get_cfg('gift.sold_out')){?><td width="8%" nowrap><strong><?=get_lang('ly200.other_property');?></strong></td><?php }?>
            <td width="10%" nowrap><strong><?=get_lang('ly200.time');?></strong></td>
            <?php if(get_cfg('gift.mod') || get_cfg('gift.copy')){?><td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
        </tr>
        <?php
        for($i=0; $i<count($gift_row); $i++){
        ?>
        <tr align="center">
            <td nowrap><?=$start_row+$i+1;?></td>
            <?php if(get_cfg('gift.del')){?><td><input type="checkbox" name="select_ProId[]" value="<?=$gift_row[$i]['ProId'];?>"></td><?php }?>
            <?php if(get_cfg('gift.order')){?><td><input type="text" name="MyOrder[]" class="form_input" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="<?=$gift_row[$i]['MyOrder'];?>" size="5" maxlength="10"><input name="ProId[]" type="hidden" value="<?=$gift_row[$i]['ProId'];?>"></td><?php }?>
            <td class="break_all"><a href="<?=get_url('gift', $gift_row[$i]);?>" target="_blank"><?=list_all_lang_data($gift_row[$i], 'Name');?></a></td>
            <?php if(get_cfg('gift.item_number')){?><td nowrap><?=$gift_row[$i]['ItemNumber'];?></td><?php }?>
            <?php if(get_cfg('gift.model')){?><td nowrap><?=$gift_row[$i]['Model'];?></td><?php }?>
            <?php if(get_cfg('gift.price')){?>
                <td nowrap class="flh_150" align="left">
                    <?php
                    $p_ary=get_cfg('gift.price_list');
                    for($j=0; $j<count($p_ary); $j++){
                        echo get_lang('gift.price_list.'.$p_ary[$j]).':'.get_lang('ly200.price_symbols').sprintf('%01.2f', $gift_row[$i]['Price_'.$j]).'<br>';
                    }
                    if(get_cfg('gift.special_offer')){
                        echo get_lang('gift.special_offer').':'.($gift_row[$i]['IsSpecialOffer']?('<font class="fc_red">'.get_lang('ly200.price_symbols').sprintf('%01.2f', $gift_row[$i]['SpecialOfferPrice']).'</font>'):get_lang('ly200.n_y_array.0'));
                    }
                    ?>
                </td>
            <?php }?>
            <?php if(get_cfg('gift.stock')){?><td nowrap><?=$gift_row[$i]['Stock'];?></td><?php }?>
            <?php if(get_cfg('gift.start_from')){?><td nowrap><?=$gift_row[$i]['StartFrom'];?></td><?php }?>
            <?php if($category_count>1){?>
                <td align="left" class="flh_150"><?php
                    $lang_key=lang_name(array_search($gift_row[$i]['Language'], get_cfg('ly200.lang_array')), 1);
                    $UId=$category[$gift_row[$i]['CateId']]['UId'];	//按CateId获取对应的UId
                    $current_key_ary=@explode(',', $UId);
                    for($m=1; $m<count($current_key_ary)-1; $m++){	//按CateId列表列出对应的类别名
                        echo $category[$current_key_ary[$m]]['Category'.$lang_key].'<font class="fc_red">-></font>';
                    }
                    echo $category[$gift_row[$i]['CateId']]['Category'.$lang_key];	//列表本身的类别名，因为UId不包含它本身
                ?></td>
            <?php }?>
            <?php if(get_cfg('gift.pic_count')){?><td><?=creat_imgLink_by_sImg($gift_row[$i]['PicPath_0']);?></td><?php }?>
            <?php if(get_cfg('gift.is_in_index') || get_cfg('gift.is_hot') || get_cfg('gift.is_recommend') || get_cfg('gift.is_new') || get_cfg('gift.sold_out')){?>
                <td class="flh_150">
                    <?=(get_cfg('gift.is_in_index') && $gift_row[$i]['IsInIndex'])?get_lang('ly200.is_in_index').'<br>':'';?>
                    <?=(get_cfg('gift.is_hot') && $gift_row[$i]['IsHot'])?get_lang('gift.is_hot').'<br>':'';?>
                    <?=(get_cfg('gift.is_recommend') && $gift_row[$i]['IsRecommend'])?get_lang('gift.is_recommend').'<br>':'';?>
                    <?=(get_cfg('gift.is_new') && $gift_row[$i]['IsNew'])?get_lang('gift.is_new').'<br>':'';?>
                    <?=get_cfg('gift.sold_out')?get_lang('gift.sold_out').':'.get_lang('ly200.n_y_array.'.$gift_row[$i]['SoldOut']).'<br>':'';?>
                </td>
            <?php }?>
            <td nowrap><?=date(get_lang('ly200.time_format_ymd'), $gift_row[$i]['AccTime']);?></td>
            <?php if(get_cfg('gift.mod') || get_cfg('gift.copy')){?><td nowrap><?php if(get_cfg('gift.mod')){?><a href="mod.php?<?=$all_query_string;?>&ProId=<?=$gift_row[$i]['ProId']?>" title="<?=get_lang('ly200.mod');?>" class="mod"></a><?php }?><?php if(get_cfg('gift.copy')){?>&nbsp;&nbsp;<a href="copy.php?ProId=<?=$gift_row[$i]['ProId']?>"><img src="../images/copy.gif" alt="<?=get_lang('ly200.copy');?>"></a><?php }?></td><?php }?>
        </tr>
        <?php }?>
        <?php if((get_cfg('gift.order') || get_cfg('gift.del') || get_cfg('gift.move')) && count($gift_row)){?>
        <tr>
            <td colspan="20" class="bottom_act">
            	<div class="fl mgl20">
					<?php if(get_cfg('gift.order')){?><input name="gift_order" id="gift_order" type="button" class="list_button transition" onClick="click_button(this, 'list_form', 'list_form_action')" value="<?=get_lang('ly200.order');?>"><?php }?>
                    <?php if(($category_count>1 && get_cfg('gift.move')) || get_cfg('gift.del')){?><input name="button" type="button" class="list_button transition" onClick='change_all("select_ProId[]");' value="<?=get_lang('ly200.anti_select');?>"><?php }?>
                    <?php /*?><?php if($category_count>1 && get_cfg('gift.move')){?>
                        <?=get_lang('ly200.move_selected_to');?>:<?=$select_category;?>
                        <input name="gift_move" id="gift_move" type="button" class="list_button transition" onClick="click_button(this, 'list_form', 'list_form_action')" value="<?=get_lang('ly200.move');?>">
                    <?php }?><?php */?>
                    <?php if(get_cfg('gift.del')){?><input name="gift_del" id="gift_del" type="button" class="list_button transition" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'list_form_action');};" value="<?=get_lang('ly200.del');?>"><?php }?>
                    <input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
                    <input type="hidden" name="page" value="<?=$page;?>">
                    <input name="list_form_action" id="list_form_action" type="hidden" value="">
                </div>
                <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>
                <div class="clear"></div>  
            </td>
        </tr>
        <?php }?>
    </table>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>