<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'seo_set';
check_permit('seo_set');

if($_POST){
	$SeoTitle=format_post_value($_POST['SeoTitle']);
	$SeoKeywords=format_post_value($_POST['SeoKeywords']);
	$SeoDescription=format_post_value($_POST['SeoDescription']);
	$php_contents="\$mCfg['SeoTitle']='$SeoTitle';\r\n\$mCfg['SeoKeywords']='$SeoKeywords';\r\n\$mCfg['SeoDescription']='$SeoDescription';\r\n\r\n";
	
	//保存另外的语言版本的数据
	if(count(get_cfg('ly200.lang_array'))>1){
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$SeoTitleExt=format_post_value($_POST['SeoTitle'.$field_ext]);
			$SeoKeywordsExt=format_post_value($_POST['SeoKeywords'.$field_ext]);
			$SeoDescriptionExt=format_post_value($_POST['SeoDescription'.$field_ext]);
			$php_contents.="\$mCfg['SeoTitle{$field_ext}']='$SeoTitleExt';\r\n\$mCfg['SeoKeywords{$field_ext}']='$SeoKeywordsExt';\r\n\$mCfg['SeoDescription{$field_ext}']='$SeoDescriptionExt';\r\n\r\n";
		}
	}
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------------
	
	$JsCode=format_post_value($_POST['JsCode'], 0);
	$php_contents.="\$mCfg['JsCode']='$JsCode';\r\n\r\n";
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------------

	write_file('/inc/set/', 'seo.php', "<?php\r\n$php_contents?>");
	
	save_manage_log('优化管理');
	
	header('Location: seo.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('set_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="seo.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
        <div class="table" id="mouse_trBgcolor_table">
        	<div class="table_bg"></div>
        	<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                <div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.seo.seo').lang_name($i, 0);?></div>
                	<div class="form_row">
                    	<font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                        <span class="fl">
							<input name="SeoTitle<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($mCfg['SeoTitle'.lang_name($i, 1)]);?>" class="form_input" size="98" maxlength="200" check="<?=get_lang('ly200.filled_out').get_lang('ly200.seo.title');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                	<div class="form_row">
                    	<font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                        <span class="fl">
							<input name="SeoKeywords<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($mCfg['SeoKeywords'.lang_name($i, 1)]);?>" class="form_input" size="98" maxlength="200" check="<?=get_lang('ly200.filled_out').get_lang('ly200.seo.keywords');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                	<div class="form_row">
                    	<font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                        <span class="fl">
							<input name="SeoDescription<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($mCfg['SeoDescription'.lang_name($i, 1)]);?>" class="form_input" size="98" maxlength="200" check="<?=get_lang('ly200.filled_out').get_lang('ly200.seo.description');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <div class="tr last">
            	<div class="tr_title"><?=get_lang('set.seo.js_code');?>:</div>
                <div class="form_row mgl10"><textarea name="JsCode" rows="8" cols="106" class="form_area"><?=htmlspecialchars($mCfg['JsCode']);?></textarea></div>
            </div>
            <div class="button fr"><input type="submit" value="<?=get_lang('ly200.submit');?>" name="submit" class="form_button"></div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>