<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='translate';
check_permit('translate');

if($_POST['list_form_action']=='translate_order'){
	check_permit('', 'translate.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$order=abs((int)$_POST['MyOrder'][$i]);
		$LId=(int)$_POST['LId'][$i];
		
		$db->update('translate', "LId='$LId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	save_manage_log('友情链接排序');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['list_form_action']=='translate_del'){
	check_permit('', 'translate.del');
	if(count($_POST['select_LId'])){
		$LId=implode(',', $_POST['select_LId']);
		$where="LId in($LId)";
		
		if(get_cfg('translate.upload_logo')){
			$translate_row=$db->get_all('translate', $where, 'LogoPath');
			for($i=0; $i<count($translate_row); $i++){
				del_file($translate_row[$i]['LogoPath']);
				del_file(str_replace('s_', '', $translate_row[$i]['LogoPath']));
			}
		}
		$db->delete('translate', $where);
	}
	save_manage_log('批量删除友情链接');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_GET['query_string']){
	$page=(int)$_GET['page'];
	header("Location: index.php?{$_GET['query_string']}&page=$page");
	exit;
}

//分页查询
$where=1;
$Name=$_GET['Name'];
$Url=$_GET['Url'];
$Language=$_GET['Language'];
$Name && $where.=" and Name like '%$Name%'";
$Url && $where.=" and Url like '%$Url%'";
$Language && $where.=" and Language='$Language'";

$row_count=$db->get_row_count('translate', $where);
$total_pages=ceil($row_count/get_cfg('translate.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('translate.page_count');
$translate_row=$db->get_limit('translate', $where, '*', 'MyOrder desc, LId desc', $start_row, get_cfg('translate.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('translate_header.php');?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bat_form">
        <tr>
            <td height="58" class="flh_150">
                <form method="get" name="translate_search_form" action="index.php" onsubmit="this.submit.disabled=true;">
                    <span class="fc_gray mgl14"><?=get_lang('ly200.name');?>:<input name="Name" class="form_input" type="text" size="25" maxlength='100'></span>
                    <span class="fc_gray mgl14"><?=get_lang('translate.url');?>:<input name="Url" class="form_input" type="text" size="25" maxlength='100'></span>
                    <?php if(count(get_cfg('ly200.lang_array'))>1){?><span class="class="fc_gray mgl14""><?=get_lang('ly200.language');?>:<?=str_replace('<select','<select class="form_select"',output_language_select(-1, 1, get_lang('ly200.select')));?></span><?php }?>
                    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button">
                </form>
            </td>
        </tr>
    </table>
    <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
        <tr align="center" class="list_form_title" id="list_form_title">
            <td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <?php if(get_cfg('translate.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <?php if(get_cfg('translate.order')){?><td width="5%" nowrap><strong><?=get_lang('ly200.order');?></strong></td><?php }?>
            <td width="25%" nowrap><strong><?=get_lang('ly200.name');?></strong></td>
            <td width="25%" nowrap><strong><?=get_lang('translate.url');?></strong></td>
            <?php if(count(get_cfg('ly200.lang_array'))>1){?><td width="5%" nowrap><strong><?=get_lang('ly200.language');?></strong></td><?php }?>
            <?php if(get_cfg('translate.upload_logo')){?><td width="10%" nowrap><strong><?=get_lang('ly200.logo');?></strong></td><?php }?>
            <?php if(get_cfg('translate.mod')){?><td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
        </tr>
        <?php
        for($i=0; $i<count($translate_row); $i++){
        ?>
        <tr align="center">
            <td nowrap><?=$start_row+$i+1;?></td>
            <?php if(get_cfg('translate.del')){?><td><input type="checkbox" name="select_LId[]" value="<?=$translate_row[$i]['LId'];?>"></td><?php }?>
            <?php if(get_cfg('translate.order')){?><td><input type="text" name="MyOrder[]" class="form_input" value="<?=$translate_row[$i]['MyOrder'];?>" size="3" maxlength="10"><input name="LId[]" type="hidden" value="<?=$translate_row[$i]['LId'];?>"></td><?php }?>
            <td class="break_all"><?=$translate_row[$i]['Name'];?></td>
            <td class="break_all"><a href="<?=$translate_row[$i]['Url'];?>" target="_blank"><?=$translate_row[$i]['Url'];?></a></td>
            <?php if(count(get_cfg('ly200.lang_array'))>1){?><td nowrap><?=get_lang('ly200.lang_array.lang_'.$translate_row[$i]['Language']);?></td><?php }?>
            <?php if(get_cfg('translate.upload_logo')){?><td><?=creat_imgLink_by_sImg($translate_row[$i]['LogoPath']);?></td><?php }?>
            <?php if(get_cfg('translate.mod')){?><td nowrap><a href="mod.php?<?=$query_string;?>&LId=<?=$translate_row[$i]['LId']?>" title="<?=get_lang('ly200.mod');?>" class="mod"></a></td><?php }?>
        </tr>
        <?php }?>
        <?php if((get_cfg('translate.order') || get_cfg('translate.del')) && count($translate_row)){?>
        <tr>
            <td colspan="20" class="bottom_act">
            	<div class="fl mgl20">
					<?php if(get_cfg('translate.order')){?><input name="translate_order" id="translate_order" type="button" class="list_button transition" onClick="click_button(this, 'list_form', 'list_form_action')" value="<?=get_lang('ly200.order');?>"><?php }?>
                    <?php if(get_cfg('translate.del')){?>
                        <input name="button" type="button" class="list_button transition" onClick='change_all("select_LId[]");' value="<?=get_lang('ly200.anti_select');?>">
                        <input name="translate_del" id="translate_del" type="button" class="list_button transition" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'list_form_action');};" value="<?=get_lang('ly200.del');?>">
                    <?php }?>
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