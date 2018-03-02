<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='gift_review';
check_permit('gift_review');

if($_POST['list_form_action']=='gift_review_del'){
	check_permit('', 'gift_review.del');
	if(count($_POST['select_RId'])){
		$RId=implode(',', $_POST['select_RId']);
		$db->delete('gift_review', "RId in($RId)");
	}
	save_manage_log('批量删除礼品评论');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['list_form_action']=='member_send_mail'){
	include('../../inc/manage/header.php');
	echo '<script language=javascript>';
	echo 'parent.openWindows("win_send_mail", "'.get_lang('send_mail.send_mail_system').'", "send_mail/index.php?RId='.implode(',', $_POST['select_RId']).'")';
	echo '</script>';
	js_back();
}

if($_GET['query_string']){
	$page=(int)$_GET['page'];
	header("Location: index.php?{$_GET['query_string']}&page=$page");
	exit;
}

//分页查询
$where=1;
$row_count=$db->get_row_count('gift_review', $where);
$total_pages=ceil($row_count/get_cfg('gift_review.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('gift_review.page_count');
$gift_review_row=$db->get_limit('gift_review', $where, '*', 'RId desc', $start_row, get_cfg('gift_review.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');
$all_query_string=query_string();

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('review_header.php');?>
    <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
        <tr align="center" class="list_form_title nosearch" id="list_form_title">
            <td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <?php if(get_cfg('gift_review.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <td width="25%" nowrap><strong><?=get_lang('gift_review.gift');?></strong></td>
            <td width="15%" nowrap><strong><?=get_lang('gift_review.full_name');?></strong></td>
            <td width="15%" nowrap><strong><?=get_lang('ly200.email');?></strong></td>
            <td width="10%" nowrap><strong><?=get_lang('gift_review.rating');?></strong></td>
            <?php if(get_cfg('gift_review.display')){?><td width="5%" nowrap><strong><?=get_lang('ly200.display');?></strong></td><?php }?>
            <td width="10%" nowrap><strong><?=get_lang('ly200.ip');?></strong></td>
            <td width="10%" nowrap><strong><?=get_lang('ly200.time');?></strong></td>
            <?php if(get_cfg('gift_review.reply')){?><td width="5%" nowrap><strong><?=get_lang('gift_review.reply');?></strong></td><?php }?>
            <td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td>
        </tr>
        <?php
        include('../../inc/fun/ip_to_area.php');
        for($i=0; $i<count($gift_review_row); $i++){
            $gift_row=$db->get_one('gift', "ProId='{$gift_review_row[$i]['ProId']}'");
            $ip_area=ip_to_area($gift_review_row[$i]['Ip']);
        ?>
        <tr align="center">
            <td nowrap><?=$start_row+$i+1;?></td>
            <?php if(get_cfg('gift_review.del')){?><td><input type="checkbox" name="select_RId[]" value="<?=$gift_review_row[$i]['RId'];?>"></td><?php }?>
            <td align="left"><a href="<?=get_url('gift', $gift_row);?>" target="_blank"><?=htmlspecialchars($gift_row['Name']);?></a></td>
            <td><?=htmlspecialchars($gift_review_row[$i]['FullName']);?></td>
            <td><?php if($menu['send_mail']){?><a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($gift_review_row[$i]['Email'].'/'.$gift_review_row[$i]['FullName']);?>');"><?=htmlspecialchars($gift_review_row[$i]['Email']);?></a><?php }else{?><?=htmlspecialchars($gift_review_row[$i]['Email']);?><?php }?></td>
            <td nowrap><?=str_repeat('<img src="/images/lib/gift/x0.jpg">', $gift_review_row[$i]['Rating']);?></td>
            <?php if(get_cfg('gift_review.display')){?><td nowrap><?=get_lang('ly200.n_y_array.'.$gift_review_row[$i]['Display']);?></td><?php }?>
            <td><?=htmlspecialchars($gift_review_row[$i]['Ip']);?> [<?=$ip_area['country'].$ip_area['area'];?>]</td>
            <td nowrap><?=date(get_lang('ly200.time_format_full'), $gift_review_row[$i]['PostTime']);?></td>
            <?php if(get_cfg('gift_review.reply')){?><td nowrap><?=get_lang('gift_review.reply_status.'.($gift_review_row[$i]['Reply']?1:0));?></td><?php }?>
            <td><a href="view.php?<?=$all_query_string;?>&RId=<?=$gift_review_row[$i]['RId']?>" title="<?=get_lang('ly200.view');?>" class="mod"></a></td>
        </tr>
        <?php }?>
        <?php if(get_cfg('gift_review.del') && count($gift_review_row)){?>
        <tr>
            <td colspan="20" class="bottom_act">
            	<div class="fl mgl20">
                    <input name="button" type="button" class="list_button transition" onClick='change_all("select_RId[]");' value="<?=get_lang('ly200.anti_select');?>">
                    <input name="gift_review_del" id="gift_review_del" type="button" class="list_button transition" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'list_form_action');};" value="<?=get_lang('ly200.del');?>">
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