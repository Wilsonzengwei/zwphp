<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_size';
check_permit('product_size', 'product.size.mod');

if($_POST){
	$SId=(int)$_POST['SId'];	
	$Size=$_POST['Size'];
	
	$db->update('product_size', "SId='$SId'", array(
			'Size'	=>	$Size
		)
	);
	
	save_manage_log('更新产品尺寸:'.$Size);
	
	header('Location: size.php');
	exit;
}

$SId=(int)$_GET['SId'];
$size_row=$db->get_one('product_size', "SId='$SId'");

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('size_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="size_mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="tr last">
            	<div class="tr_title"><?=get_lang('ly200.mod').get_lang('product.size');?></div>
                <div class="form_row">
                	<font class="fl"><?=get_lang('product.size');?>:</font>
                    <span class="fl">
                    	<input name="Size" value="<?=htmlspecialchars($size_row['Size']);?>" class="form_input" type="text" size="30" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('product.size');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
				<input type="hidden" name="SId" value="<?=$SId;?>">
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>