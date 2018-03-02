<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='gift_size';
check_permit('gift_size', 'gift.size.add');

if($_POST){
	$Size=$_POST['Size'];
	$db->insert('gift_size', array(
			'Size'		=>	$Size
		)
	);
	
	save_manage_log('添加礼品尺寸:'.$Size);
	
	header('Location: size.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="dic_con">
	<?php include('size_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="size_add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
        <div class="table">
            <div class="tr last">
                <div class="tr_title"><?=get_lang('ly200.mod').get_lang('gift.size');?></div>
                <div class="form_row">
                    <font class="fl"><?=get_lang('gift.size');?>:</font>
                    <span class="fl">
                        <input name="Size" value="" class="form_input" type="text" size="30" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('gift.size');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="button fr">
                <input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>