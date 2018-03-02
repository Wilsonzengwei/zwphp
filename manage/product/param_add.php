<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

check_permit('param', 'product.param.add');

if($_POST){
	$FieldType=$_POST['FieldType'];
	$CateId=$_POST['CateId'];
	$Name=$_POST['Name'];
	$Value=$_POST['Value'];
	if($FieldType==1){
		if($db->get_row_count('param',"CateId ='$CateId' and FieldType='1'")){
			$to_db=0;
		}else{
			$to_db=1;	
		}
	}else{
		$to_db=1;
	}
	
	if($to_db==1){
		$db->insert('param', array(
				'FieldType'				=>	$FieldType,
				'CateId'				=>	$CateId,
				'Name'					=>	$Name,
				'Value'					=>	$Value,
			)
		);
	}
	
	save_manage_log('添加产品参数:'.$Name);
	
	header('Location: param.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<?php include('param_header.php');?>
<form method="post" name="act_form" id="act_form" class="act_form" action="param_add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
<table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgparam_table">
	<tr>
		<td width="5%" nowrap><?=get_lang('param.type');?>:</td>
		<td width="95%">
            <select name="FieldType" id="FieldType">
            	<option value="0">请选择属性类型</option>
                <option value="1">颜色属性</option>
                <option value="2">普通属性</option>
            </select>
       </td>
	</tr>
    <tr id="field_name">
		<td nowrap><?=get_lang('param.category');?>:</td>
		<td><?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('CateId','', 'param_category', 'UId="0,"', 1, get_lang('ly200.select')));?></td>
	</tr>
	<tr id="field_name">
		<td nowrap><?=get_lang('ly200.name');?>:</td>
		<td><input name="Name" type="text" value="" class="form_input" size="30" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*"></td>
	</tr>

	<tr id="select_item">
		<td><?=get_lang('param.default_value');?>:</td>
		<td><textarea name="Value" rows="8" class="form_area" cols="60"></textarea>&nbsp;&nbsp;<?=get_lang('param.select_item_mark');?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="Submit" name="submit" value="<?=get_lang('ly200.add');?>" class="form_button"><a href='param.php' class="return"><?=get_lang('ly200.return');?></a></td>
	</tr>
</table>
</form>
<?php include('../../inc/manage/footer.php');?>