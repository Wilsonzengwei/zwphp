<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'info_two';
check_permit('info_two');

if($_GET['act']=='del'){ //删除文章
	$InfoId=$_GET['InfoId'];
	$info_two_row = $db->get_one('info_two',"InfoId='$InfoId'");
	del_file($info_two_row['PageUrl']);
	if(get_cfg('info_two.upload_pic')){
		del_file($info_two_row['PicPath']);
		del_file(str_replace('s_', '', $info_two_row['PicPath']));
	}
	$db->delete('info_two_contents', "InfoId='$InfoId'");
	$db->delete('info_two',"InfoId='$InfoId'");
	save_manage_log('删除文章'.'id:'.$InfoId.','.'标题:'.$info_two_row['Title']);
	
	$query_string=$_GET['query_string'];
	$page=(int)$_GET['page'];
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['list_form_action']=='info_two_order'){
	check_permit('', 'info_two.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$order=abs((int)$_POST['MyOrder'][$i]);
		$InfoId=(int)$_POST['InfoId'][$i];
		
		$db->update('info_two', "InfoId='$InfoId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	save_manage_log('文章排序');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['list_form_action']=='info_two_move'){
	check_permit('', 'info_two.move');
	$CateId=(int)$_POST['CateId'];
	$InfoId=implode(',', $_POST['select_InfoId']);
	count($_POST['select_InfoId']) && move_to_other_category('info_two', $CateId, "InfoId in($InfoId)");
	
	save_manage_log('批量移动文章');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['bat_form_action']=='info_two_move'){
	check_permit('', 'info_two.move');
	$SorceCateId=(int)$_POST['SorceCateId'];
	$DestCateId=(int)$_POST['DestCateId'];
	($SorceCateId && $DestCateId && $SorceCateId!=$DestCateId) && move_to_other_category('info_two', $DestCateId, get_search_where_by_CateId($SorceCateId, 'info_two_category'));
	
	save_manage_log('批量移动文章');
	
	header("Location: index.php");
	exit;
}

if($_POST['list_form_action']=='info_two_del'){
	check_permit('', 'info_two.del');
	if(count($_POST['select_InfoId'])){
		$InfoId=implode(',', $_POST['select_InfoId']);
		$where="InfoId in($InfoId)";
		
		$info_two_row=$db->get_all('info_two', $where, 'PicPath, PageUrl');
		for($i=0; $i<count($info_two_row); $i++){
			del_file($info_two_row[$i]['PageUrl']);
			if(get_cfg('info_two.upload_pic')){
				del_file($info_two_row[$i]['PicPath']);
				del_file(str_replace('s_', '', $info_two_row[$i]['PicPath']));
			}
		}
		
		$db->delete('info_two_contents', "InfoId in(select InfoId from info_two where $where)");
		$db->delete('info_two', $where);
	}
	save_manage_log('批量删除文章');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['bat_form_action']=='info_two_del'){
	check_permit('', 'info_two.del');
	$CateId=(int)$_POST['CateId'];
	
	if($CateId){
		$where=get_search_where_by_CateId($CateId, 'info_two_category');
		
		$info_two_row=$db->get_all('info_two', $where, 'PicPath, PageUrl');
		for($i=0; $i<count($info_two_row); $i++){
			del_file($info_two_row[$i]['PageUrl']);
			if(get_cfg('info_two.upload_pic')){
				del_file($info_two_row[$i]['PicPath']);
				del_file(str_replace('s_', '', $info_two_row[$i]['PicPath']));
			}
		}
		
		$db->delete('info_two_contents', "InfoId in(select InfoId from info_two where $where)");
		$db->delete('info_two', $where);
	}
	save_manage_log('批量删除文章');
	
	header("Location: index.php");
	exit;
}

if($_GET['query_string']){
	$page=(int)$_GET['page'];
	header("Location: index.php?{$_GET['query_string']}&page=$page");
	exit;
}

//分页查询
$where=1;
$Title=$_GET['Title'];
$CateId=(int)$_GET['CateId'];
$ext_where=$_GET['ext_where'];
$Title && $where.=" and Title like '%$Title%'";
if($_GET['Language']!=''){
	$Language=(int)$_GET['Language'];
	$Language>=0 && $where.=" and Language='$Language'";
}
$CateId && $where.=' and '.get_search_where_by_CateId($CateId, 'info_two_category');
$ext_where && $where.=" and $ext_where";

$row_count=$db->get_row_count('info_two', $where);
$total_pages=ceil($row_count/get_cfg('info_two.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('info_two.page_count');
$info_two_row=$db->get_limit('info_two', $where, '*', 'MyOrder desc, InfoId desc', $start_row, get_cfg('info_two.page_count'));

//获取类别列表
$cate_ary=$db->get_all('info_two_category');
for($i=0; $i<count($cate_ary); $i++){
	$category[$cate_ary[$i]['CateId']]=$cate_ary[$i];
}
$select_category=ouput_Category_to_Select('CateId', '', 'info_two_category', 'UId="0,"', 1, get_lang('ly200.select'));

//获取页面跳转url参数
$query_string=query_string('page');
$all_query_string=query_string();

include('../../inc/manage/header.php');
?>

<div class="div_con">
	<?php include('info_two_header.php');?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bat_form">
        <?php /*?><?php if(count($category)>1 && (get_cfg('info_two.move') || get_cfg('info_two.del'))){?> //以后可能需要的
        <tr>
            <td height="58" class="flh_150">
                <?php if(get_cfg('info_two.move')){?>
                    <div>
                        <form method="post" name="info_two_move_form" action="index.php" onsubmit="this.submit.disabled=true;">
                            <span class="fc_gray mgl14"><?=get_lang('ly200.move');?>:<?=str_replace(array('CateId','<select'), array('SorceCateId','<select class="form_select"'), $select_category);?> -> <?=str_replace(array('CateId','<select'), array('DestCateId','<select class="form_select"'), $select_category);?></span>
                            <span class="fc_gray mgl14"><input type="submit" name="submit" value="<?=get_lang('ly200.move');?>" class="sm_form_button"><input type="hidden" name="bat_form_action" value="info_two_move" /></span>
                        </form>
                    </div>
                <?php }?>
                <?php if(get_cfg('info_two.del')){?> 
                    <div>
                        <form method="post" name="info_two_del_form" action="index.php" onsubmit="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{if(checkForm(this)){this.submit.disabled=true;}else{return false;}}">
                            <span class="fc_gray mgl14"><?=get_lang('ly200.del');?>:<?=str_replace('<select','<select class="form_select"',$select_category);?></span>
                            <span class="fc_gray mgl14"><input type="submit" name="submit" value="<?=get_lang('ly200.del');?>" class="sm_form_button"><input type="hidden" name="bat_form_action" value="info_two_del" /></span>
                        </form>
                    </div>
                <?php }?>
            </td>
        </tr>
        <?php }?><?php */?>
        <tr>
            <td height="58" class="flh_150">
                <form method="get" name="info_two_search_form" action="index.php" onsubmit="this.submit.disabled=true;">
                    <span class="fc_gray mgl14"><?=get_lang('ly200.title');?>:<input name="Title" class="form_input" type="text" size="25" maxlength='100'></span>
                    <?php if(count(get_cfg('ly200.lang_array'))>1){?><span class="fc_gray mgl14"><?=get_lang('ly200.language');?>:<?=output_language_select(-1, 1, get_lang('ly200.select'));?></span><?php }?>
                    <?php if(count($category)>1){?><span class="fc_gray mgl14"><?=get_lang('ly200.category');?>:<?=str_replace('<select','<select class=form_select',$select_category);?></span><?php }?>
                    <?php if(get_cfg('info_two.is_in_index') || get_cfg('info_two.is_hot')){?>
                        <span class="fc_gray mgl14">
                            <?=get_lang('ly200.other_property');?>:<select name="ext_where" class="form_select">
                                <option value=''>--<?=get_lang('ly200.select');?>--</option>
                                <?php if(get_cfg('info_two.is_in_index')){?><option value='IsInIndex=1'><?=get_lang('ly200.is_in_index');?></option><?php }?>
                                <?php if(get_cfg('info_two.is_hot')){?><option value='IsHot=1'><?=get_lang('info_two.is_hot');?></option><?php }?>
                            </select>
                        </span>
                    <?php }?>
                    <span class="fc_gray mgl14"><input type="submit" name="submit" class="sm_form_button" value="<?=get_lang('ly200.search');?>"></span>
                </form>
            </td>
        </tr>
    </table>
    <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
    
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
        <tr align="center" class="list_form_title" id="list_form_title">
            <td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <?php if(get_cfg('info_two.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <?php if(get_cfg('info_two.order')){?><td width="5%" nowrap><strong><?=get_lang('ly200.order');?></strong></td><?php }?>
            <td width="25%" nowrap><strong><?=get_lang('ly200.title');?></strong></td>
            <?php if(count(get_cfg('ly200.lang_array'))>1){?><td width="5%" nowrap><strong><?=get_lang('ly200.language');?></strong></td><?php }?>
            <?php if(count($category)>1){?><td width="15%" nowrap><strong><?=get_lang('ly200.category');?></strong></td><?php }?>
            <?php if(get_cfg('info_two.upload_pic')){?><td width="10%" nowrap><strong><?=get_lang('ly200.photo');?></strong></td><?php }?>
            <?php if(get_cfg('info_two.author')){?><td width="10%" nowrap><strong><?=get_lang('info_two.author');?></strong></td><?php }?>
            <?php if(get_cfg('info_two.provenance')){?><td width="10%" nowrap><strong><?=get_lang('info_two.provenance');?></strong></td><?php }?>
            <?php if(get_cfg('info_two.burden')){?><td width="10%" nowrap><strong><?=get_lang('info_two.burden');?></strong></td><?php }?>
            <?php if(get_cfg('info_two.is_in_index') || get_cfg('info_two.is_hot')){?><td width="10%" nowrap><strong><?=get_lang('ly200.other_property');?></strong></td><?php }?>
            <?php if(get_cfg('info_two.acc_time')){?><td width="10%" nowrap><strong><?=get_lang('ly200.time');?></strong></td><?php }?>
            <?php if(get_cfg('info_two.mod')){?><td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
        </tr>
        <?php
        for($i=0; $i<count($info_two_row); $i++){
        ?>
        <tr align="center">
            <td nowrap><?=$start_row+$i+1;?></td>
            <?php if(get_cfg('info_two.del')){?><td><input type="checkbox" name="select_InfoId[]" value="<?=$info_two_row[$i]['InfoId'];?>"></td><?php }?>
            <?php if(get_cfg('info_two.order')){?><td><input type="text" name="MyOrder[]" value="<?=$info_two_row[$i]['MyOrder'];?>" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" class="form_input" size="10" maxlength="10"><input name="InfoId[]" type="hidden" value="<?=$info_two_row[$i]['InfoId'];?>"></td><?php }?>
            <td class="break_all"><a href="<?=get_url('info_two', $info_two_row[$i]);?>" target="_blank"><?=$info_two_row[$i]['Title'];?></a></td>
            <?php if(count(get_cfg('ly200.lang_array'))>1){?><td nowrap><?=get_lang('ly200.lang_array.lang_'.$info_two_row[$i]['Language']);?></td><?php }?>
            <?php if(count($category)>1){?>
                <td align="left" class="flh_150"><?php
                    $lang_key=lang_name(array_search($info_two_row[$i]['Language'], get_cfg('ly200.lang_array')), 1);
                    $UId=$category[$info_two_row[$i]['CateId']]['UId'];	//按CateId获取对应的UId
                    $current_key_ary=@explode(',', $UId);
                    for($m=1; $m<count($current_key_ary)-1; $m++){	//按CateId列表列出对应的类别名
                        echo $category[$current_key_ary[$m]]['Category'.$lang_key].'<font class="fc_red">-></font>';
                    }
                    echo $category[$info_two_row[$i]['CateId']]['Category'.$lang_key];	//列表本身的类别名，因为UId不包含它本身
                ?></td>
            <?php }?>
            <?php if(get_cfg('info_two.upload_pic')){?><td><?=creat_imgLink_by_sImg($info_two_row[$i]['PicPath']);?></td><?php }?>
            <?php if(get_cfg('info_two.author')){?><td><?=$info_two_row[$i]['Author'];?></td><?php }?>
            <?php if(get_cfg('info_two.provenance')){?><td><?=$info_two_row[$i]['Provenance'];?></td><?php }?>
            <?php if(get_cfg('info_two.burden')){?><td><?=$info_two_row[$i]['Burden'];?></td><?php }?>
            <?php if(get_cfg('info_two.is_in_index') || get_cfg('info_two.is_hot')){?>
                <td class="flh_150">
                    <?=(get_cfg('info_two.is_in_index') && $info_two_row[$i]['IsInIndex'])?get_lang('ly200.is_in_index').'<br>':'';?>
                    <?=(get_cfg('info_two.is_hot') && $info_two_row[$i]['IsHot'])?get_lang('info_two.is_hot').'<br>':'';?>
                </td>
            <?php }?>
            <?php if(get_cfg('info_two.acc_time')){?><td nowrap><?=date(get_lang('ly200.time_format_ymd'), $info_two_row[$i]['AccTime']);?></td><?php }?>
            <td nowrap>
                <?php if(get_cfg('info_two.mod')){?><a href="mod.php?<?=$all_query_string;?>&InfoId=<?=$info_two_row[$i]['InfoId']?>" title="<?=get_lang('ly200.mod');?>" class="mod"></a><?php }?>
                <?php if(get_cfg('info_two.del')){?><a href="javascript:void(0);" class="del" title="<?=get_lang('ly200.del');?>" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{window.location='index.php?act=del&InfoId=<?=$info_two_row[$i]['InfoId']?>&query_string=<?=$query_string?>&page=<?=$page?>'; };"></a><?php } ?>
            </td>
        </tr>
        <?php }?>
        <?php if((get_cfg('info_two.order') || get_cfg('info_two.del') || get_cfg('info_two.move')) && count($info_two_row)){?>
        <tr>
            <td colspan="20" class="bottom_act">
                <div class="fl mgl20">
                    <?php if(get_cfg('info_two.order')){?><input name="info_two_order" id="info_two_order" class="list_button transition" type="button" onClick="click_button(this, 'list_form', 'list_form_action')" value="<?=get_lang('ly200.order');?>"><?php }?>
                    <?php if((count($category)>1 && get_cfg('info_two.move')) || get_cfg('info_two.del')){?><input name="button" type="button" class="list_button transition" onClick='change_all("select_InfoId[]");' value="<?=get_lang('ly200.anti_select');?>"><?php }?>
                    <?php /*?><?php if(count($category)>1 && get_cfg('info_two.move')){?>
                        <?=get_lang('ly200.move_selected_to');?>:<?=$select_category;?>
                        <input name="info_two_move" id="info_two_move" type="button" class="list_button transition" onClick="click_button(this, 'list_form', 'list_form_action')" value="<?=get_lang('ly200.move');?>">
                    <?php }?><?php */?>
                    <?php if(get_cfg('info_two.del')){?><input name="info_two_del" id="info_two_del" type="button" class="list_button transition" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'list_form_action');};" value="<?=get_lang('ly200.del');?>"><?php }?>
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