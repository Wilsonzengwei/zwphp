<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_binding';
check_permit('product_binding', 'product.binding.add');

if($_POST['do_action']=='products_binding_add'){
	$ProId=(int)$_POST['ProId'];
	$AssociateProId=$_POST['AssociateProId'];
	
	$db->insert('product_binding', array(
			'ProId'				=>	$ProId,
			'AssociateProId'	=>	$AssociateProId,
			'AccTime'			=>	$service_time
		)
	);
	
	save_manage_log('添加产品捆绑');
	
	header('Location: binding.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('binding_header.php');?>
    <table id="bing_form" class="bing_form" width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="45%" valign="top">
            <form method="post" name="act_form" id="act_form" class="act_form" action="binding_add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
            <div>
                <input class="sm_form_button" type="submit" name="submit" value="<?=get_lang('ly200.add');?>">
                <?php /*?><a class="return" href="binding.php"><?=get_lang('ly200.return');?></a><?php */?>
            </div>
            <div class="blank"></div>
            <div class="binding_t"><strong><?=get_lang('product.binding.primary_products');?></strong></div>
            <table class="binding_item" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td class="img"><div id="binding_item_primary_img" class="c"><div class="t"><?=get_lang('product.binding.select_products');?></div></div></td>
                    <td id="binding_item_primary_info" valign="top">
                        <ul>
                            <li><?=get_lang('ly200.name');?>:</li>
                            <li><?=get_lang('product.price');?>:</li>
                            <li><?=get_lang('product.item_number');?>:</li>
                        </ul>
                    </td>
                </tr>
            </table>
            <br />
            <div class="binding_t"><strong><?=get_lang('product.binding.associate_products');?></strong></div>
            <?php
            for($i=0; $i<get_cfg('product.binding.bind_count'); $i++){
            ?>
            <table class="binding_item" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td class="img"><div id="binding_item_associate_img_<?=$i;?>" class="c"><div class="t"><?=get_lang('product.binding.select_products');?></div></div></td>
                    <td id="binding_item_associate_info_<?=$i;?>" valign="top">
                        <ul>
                            <li><?=get_lang('ly200.name');?>:</li>
                            <li><?=get_lang('product.price');?>:</li>
                            <li><?=get_lang('product.item_number');?>:</li>
                        </ul>
                    </td>
                </tr>
            </table>
            <br />
            <?php }?>
            <input id="ProId" type="hidden" check="<?=get_lang('ly200.filled_out').get_lang('product.binding.primary_products');?>!~*" value="" name="ProId">
            <input id="AssociateProId" type="hidden" check="<?=get_lang('ly200.filled_out').get_lang('product.binding.associate_products');?>!~*" value="" name="AssociateProId">
            <input id="all_ProId" type="hidden" value="" name="all_ProId">
            <input type="hidden" value="products_binding_add" name="do_action">
            <input id="binding_item_count" type="hidden" value="<?=get_cfg('product.binding.bind_count');?>" name="binding_item_count">
            </form>
        </td>
        <td width="55%" valign="top">
            <div id="pro_list"></div>
            <iframe src="pro_list.php?module=add" name="pro_list_iframe" style="display:none;"></iframe>
        </td>
      </tr>
    </table>
</div>
<?php include('../../inc/manage/footer.php');?>