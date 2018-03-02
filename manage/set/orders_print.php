<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='orders_print_set';
check_permit('orders_print_set');

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'orders_print/';
	if($Path=up_file($_FILES['LogoPath'], $save_dir)){
		$LogoPath=$save_dir.'logo.'.get_ext_name($Path);
		del_file($LogoPath);
		@rename($site_root_path.$Path, $site_root_path.$LogoPath);
	}else{
		$LogoPath=$mCfg['OrdersPrint']['LogoPath'];
	}
	
	$Company=format_post_value($_POST['Company'], 1);
	$Address=format_post_value($_POST['Address'], 1);
	$Phone=format_post_value($_POST['Phone'], 1);
	$Fax=format_post_value($_POST['Fax'], 1);
	
	$php_contents=str_replace("\t", '', "<?php
	//订单打印设置
	\$mCfg['OrdersPrint']['LogoPath']='$LogoPath';
	\$mCfg['OrdersPrint']['Company']='$Company';
	\$mCfg['OrdersPrint']['Address']='$Address';
	\$mCfg['OrdersPrint']['Phone']='$Phone';
	\$mCfg['OrdersPrint']['Fax']='$Fax';
	?>");
	
	write_file('/inc/set/', 'orders_print.php', $php_contents);
	
	save_manage_log('订单打印设置');
	
	header('Location: orders_print.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('set_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="orders_print.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
            <div class="tr">
                <div class="form_row">
                    <font class="fl"><?=get_lang('ly200.logo');?>:</font>
                    <span class="fl">
                        <input name="LogoPath" type="file" size="50" class="form_input" contenteditable="false"><br>
                        <?=get_lang('ly200.preview');?>:<br><img src="<?=$mCfg['OrdersPrint']['LogoPath'];?>" />
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                    <font class="fl"><?=get_lang('set.orders_print.company');?>:</font>
                    <span class="fl">
                        <input name="Company" type="text" value="<?=htmlspecialchars($mCfg['OrdersPrint']['Company']);?>" class="form_input" size="98" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('set.orders_print.company');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                    <font class="fl"><?=get_lang('set.orders_print.address');?>:</font>
                    <span class="fl">
                        <input name="Address" type="text" value="<?=htmlspecialchars($mCfg['OrdersPrint']['Address']);?>" class="form_input" size="98" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('set.orders_print.address');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                    <font class="fl"><?=get_lang('set.orders_print.phone');?>:</font>
                    <span class="fl">
                        <input name="Phone" type="text" value="<?=htmlspecialchars($mCfg['OrdersPrint']['Phone']);?>" class="form_input" size="98" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('set.orders_print.phone');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr last">
                <div class="form_row">
                    <font class="fl"><?=get_lang('set.orders_print.fax');?>:</font>
                    <span class="fl">
                        <input name="Fax" type="text" value="<?=htmlspecialchars($mCfg['OrdersPrint']['Fax']);?>" class="form_input" size="98" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('set.orders_print.fax');?>!~*">
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