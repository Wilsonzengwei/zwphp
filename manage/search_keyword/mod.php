<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

check_permit('search_keyword', 'search_keyword.mod');

if($_POST){
	$KId=(int)$_POST['KId'];
	$query_string=$_POST['query_string'];
	$Keyword=$_POST['Keyword'];
	$Language=count(get_cfg('ly200.lang_array'))?$_POST['Language']:get_cfg('ly200.lang_array.0');
	
	$db->update('search_keyword', "KId='$KId'", array(
			'Keyword'	=>	$Keyword,
			'Language'	=>	$Language
		)
	);
	
	save_manage_log('编辑热门搜索:'.$Keyword);
	
	header("Location: index.php?$query_string");
	exit;
}

$KId=(int)$_GET['KId'];
$query_string=query_string('KId');

$search_keyword_row=$db->get_one('search_keyword', "KId='$KId'");

include('../../inc/manage/header.php');
?>
<div class="header"><?=get_lang('ly200.current_location');?>:<a href="index.php"><?=get_lang('search_keyword.search_keyword_manage');?></a>&nbsp;-&gt;&nbsp;<?=get_lang('ly200.mod');?></div>
<form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
<table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table">
	<tr> 
		<td width="5%" nowrap><?=get_lang('search_keyword.keyword');?>:</td>
		<td width="95%"><input name="Keyword" type="text" value="<?=htmlspecialchars($search_keyword_row['Keyword']);?>" class="form_input" size="30" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('search_keyword.keyword');?>!~*"></td>
	</tr>
	<?php if(count(get_cfg('ly200.lang_array'))>1){?>
		<tr>
			<td nowrap><?=get_lang('ly200.language');?>:</td>
			<td><?=output_language_select($search_keyword_row['Language']);?></td>
		</tr>
	<?php }?>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button"><a href="index.php?<?=$query_string;?>" class="return"><?=get_lang('ly200.return');?></a><input type="hidden" name="query_string" value="<?=$query_string;?>"><input type="hidden" name="KId" value="<?=$KId;?>"></td>
	</tr>
</table>
</form>
<?php include('../../inc/manage/footer.php');?>