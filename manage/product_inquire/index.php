<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_inquire';
check_permit('product_inquire');

if($_POST['list_form_action']=='product_inquire_del'){
	check_permit('', 'product_inquire.del');
	if(count($_POST['select_IId'])){
		$IId=implode(',', $_POST['select_IId']);
		$db->delete('product_inquire', "IId in($IId)");
	}
	save_manage_log('批量删除在线询盘');
	
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

$row_count=$db->get_row_count('product_inquire', $where);
$total_pages=ceil($row_count/get_cfg('product_inquire.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('product_inquire.page_count');
$product_inquire_row=$db->get_limit('product_inquire', $where, '*', 'IId desc', $start_row, get_cfg('product_inquire.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');
$all_query_string=query_string();

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('../member/member_header.php');?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bat_form">
        <tr>
            <td height="58" class="flh_150">
                <form method="get" name="info_search_form" action="index.php" onsubmit="this.submit.disabled=true;">
                    <span class="fc_gray mgl14">所属商户:<input name="Supplier" value="<?=$Supplier; ?>" class="form_input" type="text" size="25" maxlength='100'></span>
                    <span class="fc_gray mgl14"><input type="submit" name="submit" class="sm_form_button" value="<?=get_lang('ly200.search');?>"></span>
                </form>
            </td>
        </tr>
    </table>
    <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
        <tr align="center" class="list_form_title nosearch" id="list_form_title">
            <td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <?php if(get_cfg('product_inquire.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <td width="10%" nowrap><strong><?=get_lang('ly200.full_name');?></strong></td>
            <td width="10%" nowrap><strong>所属商户</strong></td>
            <td width="10%" nowrap><strong><?=get_lang('product_inquire.phone');?></strong></td>
            <td width="10%" nowrap><strong><?=get_lang('product_inquire.fax');?></strong></td>
            <td width="10%" nowrap><strong><?=get_lang('ly200.email');?></strong></td>
            <td width="25%" nowrap><strong><?=get_lang('product_inquire.subject');?></strong></td>
            <td width="10%" nowrap><strong><?=get_lang('ly200.time');?></strong></td>
            <td width="15%" nowrap><strong><?=get_lang('ly200.ip');?></strong></td>
            <?php if(get_cfg('product_inquire.reply')){?><td width="5%" nowrap><strong><?=get_lang('product_inquire.reply');?></strong></td><?php }?>
            <td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td>
        </tr>
        <?php
        include('../../inc/fun/ip_to_area.php');
        for($i=0; $i<count($product_inquire_row); $i++){
            $ip_area=ip_to_area($product_inquire_row[$i]['Ip']);
        ?>
        <tr align="center" class="<?=$product_inquire_row[$i]['IsRead']?'':'red_row';?>">
            <td nowrap><?=$start_row+$i+1;?></td>
            <?php if(get_cfg('product_inquire.del')){?><td><input type="checkbox" name="select_IId[]" value="<?=$product_inquire_row[$i]['IId'];?>"></td><?php }?>
            <td nowrap><?=htmlspecialchars($product_inquire_row[$i]['FirstName'].' '.$product_inquire_row[$i]['LastName']);?></td>
            <td><?=$db->get_value('member','MemberId ='.$product_inquire_row[$i]['SupplierId'],'Email');?></td>
            <td nowrap><?=htmlspecialchars($product_inquire_row[$i]['Phone']);?></td>
            <td nowrap><?=htmlspecialchars($product_inquire_row[$i]['Fax']);?></td>
            <td><?php if($menu['send_mail']){?><a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($product_inquire_row[$i]['Email'].'/'.$product_inquire_row[$i]['FirstName'].' '.$product_inquire_row[$i]['LastName']);?>');"><?=htmlspecialchars($product_inquire_row[$i]['Email']);?></a><?php }else{?><?=htmlspecialchars($product_inquire_row[$i]['Email']);?><?php }?></td>
            <td class="break_all"><?=htmlspecialchars($product_inquire_row[$i]['Subject']);?></td>
            <td nowrap><?=date(get_lang('ly200.time_format_full'), $product_inquire_row[$i]['PostTime']);?></td>
            <td class="flh_150"><?=htmlspecialchars($product_inquire_row[$i]['Ip']);?> [<?=$ip_area['country'].$ip_area['area'];?>]</td>
            <?php if(get_cfg('product_inquire.reply')){?><td nowrap><?=get_lang('product_inquire.reply_status.'.($product_inquire_row[$i]['Reply']?1:0));?></td><?php }?>
            <td><a href="view.php?<?=$all_query_string;?>&IId=<?=$product_inquire_row[$i]['IId']?>" title="<?=get_lang('ly200.view');?>" class="mod"></a></td>
        </tr>
        <?php }?>
        <?php if(get_cfg('product_inquire.del') && count($product_inquire_row)){?>
        <tr>
            <td colspan="20" class="bottom_act">
            	<div class="fl mgl20">
                    <input name="button" type="button" class="list_button transition" onClick='change_all("select_IId[]");' value="<?=get_lang('ly200.anti_select');?>">
                    <input name="product_inquire_del" id="product_inquire_del" type="button" class="list_button transition" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'list_form_action');};" value="<?=get_lang('ly200.del');?>">
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