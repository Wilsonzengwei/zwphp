<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

if($_POST['list_form_action']=='param_order'){
	check_permit('', 'param.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$order=abs((int)$_POST['MyOrder'][$i]);
		$PId=(int)$_POST['PId'][$i];
		
		$db->update('param', "PId='$PId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	save_manage_log('产品参数排序');
	
	header('Location: param.php');
	exit;
}

if($_POST['list_form_action']=='del_param'){
	check_permit('', 'param.del');
	if(count($_POST['select_PId'])){
		$PId=implode(',', $_POST['select_PId']);
		$where="PId in($PId)";
		$db->delete('param', $where);
	}
	save_manage_log('删除产品参数');
	
	header('Location: param.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<form method="post" name="list_form" id="list_form" class="act_form" action="param.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
<div class="div_con">
	<?php include('param_header.php');?>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
        <tr align="center" class="list_form_title" id="list_form_title">
            <td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <?php /*?><?php if(get_cfg('param.order')){?><td width="5%" nowrap><strong><?=get_lang('ly200.order');?></strong></td><?php }?><?php */?>
            <?php if(get_cfg('param.del')){?><td width="10%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <td width="16%" nowrap><strong><?=get_lang('ly200.name');?></strong></td>
            <td width="16%" nowrap><strong><?=get_lang('ly200.category');?></strong></td>
            <td width="16%" nowrap><strong><?=get_lang('param.type');?></strong></td>
            <td width="16%" nowrap><strong><?=get_lang('param.default_value');?></strong></td>
            <?php if(get_cfg('param.mod')){?><td width="8%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
        </tr>
        <?php
        $param_row=$db->get_all('param', 1, '*', 'CateId desc,Myorder desc, PId asc');
        for($i=0; $i<count($param_row); $i++){
        ?>
        <tr align="center">
            <td nowrap><?=($i+1)?></td>
            <?php /*?><?php if(get_cfg('param.order')){?><td><input type="text" name="MyOrder[]" class="form_input" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="<?=$param_row[$i]['MyOrder'];?>" size="3" maxlength="10"><input name="PId[]" type="hidden" value="<?=$param_row[$i]['PId'];?>"></td><?php }?><?php */?>
            <?php if(get_cfg('param.del')){?><td><input name="select_PId[]" type="checkbox" value="<?=$param_row[$i]['PId'];?>" /></td><?php }?>
            <td nowrap><?=$param_row[$i]['Name']?></td>
            <td width="16%" nowrap><strong><?=$db->get_value('param_category',"CateId = '{$param_row[$i]['CateId']}'",'Category');?></strong></td>
            <td nowrap><?php
                if($param_row[$i]['FieldType']=='1'){
                   	echo '颜色属性';
                }else{
                    echo '普通属性';
                }
            ?></td>

            <td align="left" class="flh_150">
			<?php
				//$v=explode("\r\n", $param_row[$i]['Value']);
				$v=str::json_data(htmlspecialchars_decode($param_row[$i]['Value']), 'decode');
				$k=1;
				foreach((array)$v as $value){
					if($value!=''){
						echo ($k++).'. '.$value.'<br>';
					}
				}
            ?>
            </td>
            <?php if(get_cfg('param.mod')){?><td nowrap><a href="param_mod.php?PId=<?=$param_row[$i]['PId'];?>" title="修改" class="mod"></a></td><?php }?>
        </tr>
        <?php }?>
        <?php if(get_cfg('param.del') && count($param_row)){?>
        <tr>
            <td colspan="8" class="bottom_act">
                <?php /*?><?php if(get_cfg('param.order')){?><input name="param_order" id="param_order" type="button" class="form_button" onClick="click_button(this, 'list_form', 'action')" value="<?=get_lang('ly200.order');?>"><?php }?><?php */?>
                <input name="button" type="button" class="form_button" onClick='change_all("select_PId[]");' value="<?=get_lang('ly200.anti_select');?>">
                <input name="del_param" type="button" class="form_button" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'list_form_action');};" value="<?=get_lang('ly200.del');?>">
                <input name="list_form_action" id="list_form_action" type="hidden" value="">
            </td>
        </tr>
        <?php }?>
    </table>
</div>
</form>
<?php include('../../inc/manage/footer.php');?>