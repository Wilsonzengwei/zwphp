<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='coupon';
check_permit('coupon');
if($_POST['list_form_action']=='coupon_del'){
	check_permit('', 'coupon.del');
	if(count($_POST['select_CId'])){
		$CId=implode(',', $_POST['select_CId']);
		$db->delete('coupon', "CId in($CId)");
	}
	save_manage_log('批量删除优惠券');
	
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
$row_count=$db->get_row_count('coupon', $where);
$total_pages=ceil($row_count/get_cfg('coupon.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('coupon.page_count');
$coupon_row=$db->get_limit('coupon', $where, '*', 'CId desc', $start_row, get_cfg('coupon.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('coupon_header.php');?>
<?php /*?><form method="get" class="turn_page_form" action="index.php" onsubmit="javascript:turn_page(this);">
	<?=turn_page($page, $total_pages, "index.php?$query_string&page=", $row_count, get_lang('ly200.pre_page'), get_lang('ly200.next_page'));?>
	<?=get_lang('ly200.turn');?>:<input name="page" id="page" class="form_input" type="text" size="2" maxlength="5">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>">
	<input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
	<input name="query_string" type="hidden" value="<?=$query_string;?>">
</form><?php */?>
<form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
<table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
	<tr align="center" class="list_form_title nosearch" id="list_form_title">
		<td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
		<?php if(get_cfg('coupon.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
		<?php if(get_cfg('coupon.order')){?><td width="5%" nowrap><strong><?=get_lang('ly200.order');?></strong></td><?php }?>
		<td width="10%" nowrap><strong><?=get_lang('coupon.code');?></strong></td>
        <td width='12%' nowrap><strong><?=get_lang('coupon.type');?></strong></td>
        <td width='10%' nowrap><strong><?=get_lang('coupon.conditions');?></strong></td>
        <td width="5%" nowrap><strong><?=get_lang('coupon.valid');?></strong></td>
        <td width='8%' nowrap><strong><?=get_lang('coupon.number_of_times');?></strong></td>
        <td width='13%' nowrap><strong><?=get_lang('coupon.use_of_time');?></strong></td>
        <td width='13%' nowrap><strong><?=get_lang('coupon.generation_time');?></strong></td>
		<?php if(get_cfg('coupon.mod')){?><td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
	</tr>
	<?php
	for($i=0; $i<count($coupon_row); $i++){
	?>
	<tr align="center">
		<td nowrap><?=$start_row+$i+1;?></td>
		<?php if(get_cfg('coupon.del')){?><td><input type="checkbox" name="select_CId[]" value="<?=$coupon_row[$i]['CId'];?>"></td><?php }?>
		<?php if(get_cfg('coupon.order')){?><td><input type="text" name="MyOrder[]" class="form_input" value="<?=$coupon_row[$i]['MyOrder'];?>" size="3" maxlength="10"><input name="CId[]" type="hidden" value="<?=$coupon_row[$i]['CId'];?>"></td><?php }?>
		<td class="break_all"><?=$coupon_row[$i]['CNumber'];?></td>
        <td nowrap>
		<?=$coupon_row[$i]['CType']==0?get_lang('coupon.less_cash').": ".get_lang('ly200.price_symbols').$coupon_row[$i]['Money']:"";?>
        <?=$coupon_row[$i]['CType']==1?get_lang('coupon.discount').": ".$coupon_row[$i]['Discount'].'% off':"";?>
        </td>
        <td nowrap><?=$coupon_row[$i]['UseCondition']==0?get_lang('coupon.without_limiting_the'):get_lang('ly200.price_symbols').$coupon_row[$i]['UseCondition']?></td>
        <td nowrap><?=$coupon_row[$i]['Deadline']?date('Y-m-d',$coupon_row[$i]['Deadline']):"N/A";?></td>
        <td nowrap><?=$coupon_row[$i]['CanUsedTimes']?>次</td>
        <td nowrap><?=$coupon_row[$i]['UseTime']?date('Y-m-d',$coupon_row[$i]['UseTime']):"N/A";?></td>
        <td nowrap><?=$coupon_row[$i]['AddTime']?date('Y-m-d',$coupon_row[$i]['AddTime']):"N/A";?></td>
		
		<?php if(get_cfg('coupon.mod')){?><td nowrap><a href="mod.php?<?=$query_string;?>&CId=<?=$coupon_row[$i]['CId']?>"><img src="../images/ico/mod.png" alt="<?=get_lang('ly200.mod');?>"></a></td><?php }?>
	</tr>
	<?php }?>
	<?php if((get_cfg('coupon.order') || get_cfg('coupon.del')) && count($coupon_row)){?>
	<tr>
		<td colspan="20" class="bottom_act">
        	<div class="fl mgl20">
				<?php if(get_cfg('coupon.order')){?><input name="coupon_order" id="coupon_order" type="button" class="form_button" onClick="click_button(this, 'list_form', 'list_form_action')" value="<?=get_lang('ly200.order');?>"><?php }?>
                <?php if(get_cfg('coupon.del')){?>
                    <input name="button" type="button" class="form_button" onClick='change_all("select_CId[]");' value="<?=get_lang('ly200.anti_select');?>">
                    <input name="coupon_del" id="coupon_del" type="button" class="form_button" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'list_form_action');};" value="<?=get_lang('ly200.del');?>">
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
<?php /*?><form method="get" class="turn_page_form" action="index.php" onsubmit="javascript:turn_page(this);">
	<?=turn_page($page, $total_pages, "index.php?$query_string&page=", $row_count, get_lang('ly200.pre_page'), get_lang('ly200.next_page'));?>
	<?=get_lang('ly200.turn');?>:<input name="page" id="page" type="text" size="2" maxlength="5" class="form_input">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>">
	<input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
	<input name="query_string" type="hidden" value="<?=$query_string;?>">
</form<?php */?>
<?php include('../../inc/manage/footer.php');?>