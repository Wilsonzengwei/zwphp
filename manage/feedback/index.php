<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='feedback';
check_permit('feedback');

if($_POST['list_form_action']=='feedback_del'){
	check_permit('', 'feedback.del');
	if(count($_POST['select_FId'])){
		$FId=implode(',', $_POST['select_FId']);
		$db->delete('feedback', "FId in($FId)");
	}
	save_manage_log('批量删除在线留言');
	
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
$row_count=$db->get_row_count('feedback', $where);
$total_pages=ceil($row_count/get_cfg('feedback.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('feedback.page_count');
$feedback_row=$db->get_limit('feedback', $where, '*', 'FId desc', $start_row, get_cfg('feedback.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');
$all_query_string=query_string();

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('feedback_header.php');?>
    <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
        <tr align="center" class="list_form_title nosearch" id="list_form_title">
            <td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <?php if(get_cfg('feedback.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <td width="10%" nowrap><strong><?=get_lang('ly200.full_name');?></strong></td>
            <td width="10%" nowrap><strong><?=get_lang('feedback.phone');?></strong></td>
            <td width="10%" nowrap><strong><?=get_lang('feedback.mobile');?></strong></td>
            <td width="10%" nowrap><strong><?=get_lang('ly200.email');?></strong></td>
            <td width="20%" nowrap><strong><?=get_lang('feedback.subject');?></strong></td>
            <?php if(get_cfg('feedback.display')){?><td width="5%" nowrap><strong><?=get_lang('ly200.display');?></strong></td><?php }?>
            <td width="15%" nowrap><strong><?=get_lang('ly200.ip');?></strong></td>
            <td width="10%" nowrap><strong><?=get_lang('ly200.time');?></strong></td>
            <?php if(get_cfg('feedback.reply')){?><td width="5%" nowrap><strong><?=get_lang('feedback.reply');?></strong></td><?php }?>
            <td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td>
        </tr>
        <?php
        include('../../inc/fun/ip_to_area.php');
        for($i=0; $i<count($feedback_row); $i++){
            $ip_area=ip_to_area($feedback_row[$i]['Ip']);
        ?>
        <tr align="center" class="<?=$feedback_row[$i]['IsRead']?'':'red_row';?>">
            <td nowrap><?=$start_row+$i+1;?></td>
            <?php if(get_cfg('feedback.del')){?><td><input type="checkbox" name="select_FId[]" value="<?=$feedback_row[$i]['FId'];?>"></td><?php }?>
            <td nowrap><?=htmlspecialchars($feedback_row[$i]['Name']);?></td>
            <td nowrap><?=htmlspecialchars($feedback_row[$i]['Phone']);?></td>
            <td nowrap><?=htmlspecialchars($feedback_row[$i]['Mobile']);?></td>
            <td><?php if($menu['send_mail']){?><a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($feedback_row[$i]['Email'].'/'.$feedback_row[$i]['Name']);?>');"><?=htmlspecialchars($feedback_row[$i]['Email']);?></a><?php }else{?><?=htmlspecialchars($feedback_row[$i]['Email']);?><?php }?></td>
            <td class="break_all"><?=htmlspecialchars($feedback_row[$i]['Subject']);?></td>
            <?php if(get_cfg('feedback.display')){?><td nowrap><?=get_lang('ly200.n_y_array.'.$feedback_row[$i]['Display']);?></td><?php }?>
            <td><?=htmlspecialchars($feedback_row[$i]['Ip']);?> [<?=$ip_area['country'].$ip_area['area'];?>]</td>
            <td nowrap><?=date(get_lang('ly200.time_format_full'), $feedback_row[$i]['PostTime']);?></td>
            <?php if(get_cfg('feedback.reply')){?><td nowrap><?=get_lang('feedback.reply_status.'.($feedback_row[$i]['Reply']?1:0));?></td><?php }?>
            <td><a href="view.php?<?=$all_query_string;?>&FId=<?=$feedback_row[$i]['FId']?>" title="<?=get_lang('ly200.view');?>" class="mod"></a></td>
        </tr>
        <?php }?>
        <?php if(get_cfg('feedback.del') && count($feedback_row)){?>
        <tr>
            <td colspan="20" class="bottom_act">
            	<div class="fl mgl20">
                    <input name="button" type="button" class="list_button transition" onClick='change_all("select_FId[]");' value="<?=get_lang('ly200.anti_select');?>">
                    <input name="feedback_del" id="feedback_del" type="button" class="list_button transition" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'list_form_action');};" value="<?=get_lang('ly200.del');?>">
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