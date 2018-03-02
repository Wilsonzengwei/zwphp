<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_size';
check_permit('product_size');

if($_POST['action']=='order_size'){
	check_permit('', 'product.size.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$SId=(int)$_POST['SId'][$i];
		$order=abs((int)$_POST['MyOrder'][$i]);
		
		$db->update('product_size', "SId='$SId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	
	save_manage_log('产品尺寸排序');
	
	header('Location: size.php');
	exit;
}

if($_POST['action']=='del_size'){
	check_permit('', 'product.size.del');
	if(count($_POST['select_SId'])){
		$SId=implode(',', $_POST['select_SId']);
		$db->delete('product_size', "SId in($SId)");
	}
	save_manage_log('删除产品尺寸');
	
	header('Location: size.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('size_header.php');?>
    <form name="list_form" id="list_form" class="list_form" method="post" action="size.php">
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgsize_tr='list_form_title'>
        <tr align="center" class="list_form_title nosearch" id="list_form_title">
            <td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <?php if(get_cfg('product.size.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <?php if(get_cfg('product.size.order')){?><td width="5%" nowrap><strong><?=get_lang('ly200.order');?></strong></td><?php }?>
            <td width="16%" nowrap><strong><?=get_lang('product.size');?></strong></td>
            <?php if(get_cfg('product.size.mod')){?><td width="8%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
        </tr>
        <?php
        $size_row=$db->get_all('product_size', 1, '*', 'MyOrder desc, SId asc');
        for($i=0; $i<count($size_row); $i++){
        ?>
        <tr align="center">
            <td nowrap><?=($i+1)?></td>
            <?php if(get_cfg('product.size.del')){?><td><input name="select_SId[]" type="checkbox" value="<?=$size_row[$i]['SId'];?>" /></td><?php }?>
            <?php if(get_cfg('product.size.order')){?><td><input name="MyOrder[]" class="form_input" type="text" size="5" maxlength="10" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="<?=htmlspecialchars($size_row[$i]['MyOrder']);?>" /><input type="hidden" name="SId[]" value="<?=$size_row[$i]['SId'];?>" /></td><?php }?>
            <td nowrap><?=$size_row[$i]['Size'];?></td>
            <?php if(get_cfg('product.size.mod')){?><td nowrap><a href="size_mod.php?SId=<?=$size_row[$i]['SId'];?>" title="<?=get_lang('ly200.mod');?>" class="mod"></a></td><?php }?>
        </tr>
        <?php }?>
        <?php if((get_cfg('product.size.order') || get_cfg('product.size.del')) && count($size_row)){?>
        <tr>
            <td colspan="5" class="bottom_act">
            	<div class="fl mgl20">
					<?php if(get_cfg('product.size.order')){?><input name="order_size" type="button" class="list_button transition" onClick="click_button(this, 'list_form', 'action');" value="<?=get_lang('ly200.order');?>"><?php }?>
                    <?php if(get_cfg('product.size.del')){?>
                        <input name="button" type="button" class="list_button transition" onClick='change_all("select_SId[]");' value="<?=get_lang('ly200.anti_select');?>">
                        <input name="del_size" type="button" class="list_button transition" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'action');};" value="<?=get_lang('ly200.del');?>">
                    <?php }?>
                    <input name="action" id="action" type="hidden" value="">
                </div>
                <div class="clear"></div>
            </td>
        </tr>
        <?php }?>
    </table>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>