<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

check_permit('search_keyword');

if($_POST['list_form_action']=='search_keyword_order'){
	check_permit('', 'search_keyword.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$order=abs((int)$_POST['MyOrder'][$i]);
		$KId=(int)$_POST['KId'][$i];
		
		$db->update('search_keyword', "KId='$KId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	save_manage_log('热门搜索排序');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['list_form_action']=='search_keyword_del'){
	check_permit('', 'search_keyword.del');
	if(count($_POST['select_KId'])){
		$KId=implode(',', $_POST['select_KId']);
		$db->delete('search_keyword', "KId in($KId)");
	}
	save_manage_log('批量删除热门搜索');
	
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
$Keyword=$_GET['Keyword'];
$Language=$_GET['Language'];
$Keyword && $where.=" and Keyword like '%$Keyword%'";
$Language && $where.=" and Language='$Language'";

$row_count=$db->get_row_count('search_keyword', $where);
$total_pages=ceil($row_count/get_cfg('search_keyword.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('search_keyword.page_count');
$search_keyword_row=$db->get_limit('search_keyword', $where, '*', 'MyOrder desc, KId desc', $start_row, get_cfg('search_keyword.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');

include('../../inc/manage/header.php');
?>
<div class="header">
	<div class="float_left"><?=get_lang('ly200.current_location');?>:<a href="index.php"><?=get_lang('search_keyword.search_keyword_manage');?></a>&nbsp;-&gt;&nbsp;<?=get_lang('ly200.list');?></div>
	<?php if(get_cfg('search_keyword.add')){?><div class="float_right"><a href="add.php"><?=get_lang('ly200.add');?></a></div><?php }?>
</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bat_form">
	<tr>
		<td height="22" class="flh_150">
			<form method="get" name="search_keyword_search_form" action="index.php" onsubmit="this.submit.disabled=true;">
				<?=get_lang('search_keyword.keyword');?>:<input name="Keyword" class="form_input" type="text" size="25" maxlength='100'>
				<?php if(count(get_cfg('ly200.lang_array'))>1){?><?=get_lang('ly200.language');?>:<?=output_language_select(-1, 1, get_lang('ly200.select'));?><?php }?>
				<input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="form_button">
			</form>
		</td>
	</tr>
</table>
<form method="get" class="turn_page_form" action="index.php" onsubmit="javascript:turn_page(this);">
	<?=turn_page($page, $total_pages, "index.php?$query_string&page=", $row_count, get_lang('ly200.pre_page'), get_lang('ly200.next_page'));?>
	<?=get_lang('ly200.turn');?>:<input name="page" id="page" class="form_input" type="text" size="2" maxlength="5">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>">
	<input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
	<input name="query_string" type="hidden" value="<?=$query_string;?>">
</form>
<form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
<table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
	<tr align="center" class="list_form_title" id="list_form_title">
		<td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
		<?php if(get_cfg('search_keyword.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
		<?php if(get_cfg('search_keyword.order')){?><td width="5%" nowrap><strong><?=get_lang('ly200.order');?></strong></td><?php }?>
		<td width="25%" nowrap><strong><?=get_lang('search_keyword.keyword');?></strong></td>
		<?php if(count(get_cfg('ly200.lang_array'))>1){?><td width="5%" nowrap><strong><?=get_lang('ly200.language');?></strong></td><?php }?>
		<?php if(get_cfg('search_keyword.mod')){?><td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
	</tr>
	<?php
	for($i=0; $i<count($search_keyword_row); $i++){
	?>
	<tr align="center">
		<td nowrap><?=$start_row+$i+1;?></td>
		<?php if(get_cfg('search_keyword.del')){?><td><input type="checkbox" name="select_KId[]" value="<?=$search_keyword_row[$i]['KId'];?>"></td><?php }?>
		<?php if(get_cfg('search_keyword.order')){?><td><input type="text" name="MyOrder[]" class="form_input" value="<?=$search_keyword_row[$i]['MyOrder'];?>" size="3" maxlength="10"><input name="KId[]" type="hidden" value="<?=$search_keyword_row[$i]['KId'];?>"></td><?php }?>
		<td class="break_all"><?=$search_keyword_row[$i]['Keyword'];?></td>
		<?php if(count(get_cfg('ly200.lang_array'))>1){?><td nowrap><?=get_lang('ly200.lang_array.lang_'.$search_keyword_row[$i]['Language']);?></td><?php }?>
		<?php if(get_cfg('search_keyword.mod')){?><td nowrap><a href="mod.php?<?=$query_string;?>&KId=<?=$search_keyword_row[$i]['KId']?>"><img src="../images/mod.gif" alt="<?=get_lang('ly200.mod');?>"></a></td><?php }?>
	</tr>
	<?php }?>
	<?php if((get_cfg('search_keyword.order') || get_cfg('search_keyword.del')) && count($search_keyword_row)){?>
	<tr>
		<td colspan="20" class="bottom_act">
			<?php if(get_cfg('search_keyword.order')){?><input name="search_keyword_order" id="search_keyword_order" type="button" class="form_button" onClick="click_button(this, 'list_form', 'list_form_action')" value="<?=get_lang('ly200.order');?>"><?php }?>
			<?php if(get_cfg('search_keyword.del')){?>
				<input name="button" type="button" class="form_button" onClick='change_all("select_KId[]");' value="<?=get_lang('ly200.anti_select');?>">
				<input name="search_keyword_del" id="search_keyword_del" type="button" class="form_button" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'list_form_action');};" value="<?=get_lang('ly200.del');?>">
			<?php }?>
			<input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
			<input type="hidden" name="page" value="<?=$page;?>">
			<input name="list_form_action" id="list_form_action" type="hidden" value="">
		</td>
	</tr>
	<?php }?>
</table>
</form>
<form method="get" class="turn_page_form" action="index.php" onsubmit="javascript:turn_page(this);">
	<?=turn_page($page, $total_pages, "index.php?$query_string&page=", $row_count, get_lang('ly200.pre_page'), get_lang('ly200.next_page'));?>
	<?=get_lang('ly200.turn');?>:<input name="page" id="page" type="text" size="2" maxlength="5" class="form_input">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>">
	<input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
	<input name="query_string" type="hidden" value="<?=$query_string;?>">
</form>
<?php include('../../inc/manage/footer.php');?>