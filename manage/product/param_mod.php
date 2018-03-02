<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

check_permit('product_parameter', 'product.parameter.mod');

if($_POST){
	$FieldType=$_POST['FieldType'];
	$CateId=$_POST['CateId'];
	$Name=$_POST['Name'];
	$Value=$_POST['Value'];
	$PId=$_POST['PId'];
	if($FieldType==1){
		if($db->get_row_count('param',"CateId ='$CateId' and FieldType='1' and PId !='$PId'")){
			$to_db=0;
			exit;
		}else{
			$to_db=1;	
		}
	}else{
		$to_db=1;
	}
	$ary=$try_ary=array();
	$max=0;
	$dataAry=str::json_data(htmlspecialchars_decode(str_replace('\\', '', $Value)), 'decode');
	if(count($dataAry)){
		$dataAryTo=@array_flip($dataAry);
		$max=max($dataAryTo);
	}
	$val_ary=explode("\r\n", $Value);
	foreach($val_ary as $v2){
		if(@in_array($v2, $dataAry)){
			$ary[$dataAryTo[$v2]]=$v2;
		}else{
			$ary[++$max]=$v2;
		}
	}
	if($k==0){//匹对相应的id
		$first_ary=$ary;
	}else{
		$i=0;
		foreach($first_ary as $k2=>$v2){
			$try_ary[$k2]=$val_ary[$i];
			$i+=1;
		}
		$ary=array();
		$ary=$try_ary;
	}
	$data['Value']=addslashes(str::json_data(str::str_code($ary, 'stripslashes')));
	
	if($to_db==1){
		$db->update('param',"PId = '$PId'",array(
				'FieldType'				=>	$FieldType,
				'CateId'				=>	$CateId,
				'Name'					=>	$Name,
				'Value'					=>	$data['Value'],
			)
		);
	}
	
	save_manage_log('更新产品参数:'.$Name);
	
	header('Location: param.php');
	exit;
}

$PId=(int)$_GET['PId'];
$parameter_row=$db->get_one('param', "PId='$PId'");

include('../../inc/manage/header.php');
?>
<?php include('param_header.php');?>
<form method="post" name="act_form" id="act_form" class="act_form" action="param_mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
<table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgparam_table">
	<tr>
		<td width="5%" nowrap><?=get_lang('param.type');?>:</td>
		<td width="95%">
            <select name="FieldType" id="FieldType">
            	<option value="0">请选择属性类型</option>
                <option <?=$parameter_row['FieldType']==1?'selected':'';?> value="1">颜色属性</option>
                <option <?=$parameter_row['FieldType']==2?'selected':'';?> value="2">普通属性</option>
            </select>
       </td>
	</tr>
    <tr id="field_name">
		<td nowrap><?=get_lang('param.category');?>:</td>
		<td><?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('CateId',$parameter_row['CateId'], 'param_category', 'UId="0,"', 1, get_lang('ly200.select')));?></td>
	</tr>
	<tr id="field_name">
		<td nowrap><?=get_lang('ly200.name');?>:</td>
		<td><input name="Name" type="text" value="<?=$parameter_row['Name']?>" class="form_input" size="30" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*"></td>
	</tr>

	<tr id="select_item">
		<td><?=get_lang('param.default_value');?>:</td>
        
		<td>
        	<textarea name="Value" rows="8" class="form_area" cols="60"><?php 
				$data=str::json_data(htmlspecialchars_decode($parameter_row['Value']), 'decode');
				$value=implode("\r\n", $data);
				echo $value;
			?></textarea>&nbsp;&nbsp;
		<?=get_lang('param.select_item_mark');?>
       </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="Submit" name="submit" value="<?=get_lang('ly200.mod');?>" class="form_button"><a href='parameter.php' class="return"><?=get_lang('ly200.return');?></a><input type="hidden" name="PId" value="<?=$PId;?>" /></td>
	</tr>
</table>
</form>
<?php include('../../inc/manage/footer.php');?>