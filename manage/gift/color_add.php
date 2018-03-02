<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='gift_color';
check_permit('gift_color', 'gift.color.add');

if($_POST){
	$Color=$_POST['Color'];
	
	if(get_cfg('gift.color.upload_pic')){
		$save_dir=get_cfg('ly200.up_file_base_dir').'gift/color/'.date('y_m_d/', $service_time);
		
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('gift.color.pic_width'), get_cfg('gift.color.pic_height'));
		}
	}
	
	$db->insert('gift_color', array(
			'Color'		=>	$Color,
			'PicPath'	=>	$SmallPicPath
		)
	);
	
	$CId=$db->get_insert_id();
	
	//保存另外的语言版本的数据
	if(count(get_cfg('ly200.lang_array'))>1){
		add_lang_field('gift_color', 'Color');
		
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$ColorExt=$_POST['Color'.$field_ext];
			$db->update('gift_color', "CId='$CId'", array(
					'Color'.$field_ext	=>	$ColorExt
				)
			);
		}
	}
	
	save_manage_log('添加礼品颜色:'.$Color);
	
	header('Location: color.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('color_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="color_add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
            <div class="table">
                <div class="table_bg"></div>
                <div class="tr last">
                    <div class="tr_title"><?=get_lang('ly200.add').get_lang('gift.color');?></div>
                    <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('gift.color').lang_name($i, 0);?>:</font>
                            <span class="fl">
                                <input name="Color<?=lang_name($i, 1);?>" value="" class="form_input" type="text" size="30" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('gift.color');?>!~*">
                            </span>
                            <div class="clear"></div>
                        </div>
                    <?php }?>
                </div>
                
                <?php if(get_cfg('gift.color.upload_pic')){?>
                	<div class="tr last">
                    	<div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.photo');?>:</font>
                            <span class="fl">
                                <input name="PicPath" type="file" size="50" class="form_input" contenteditable="false"><br>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php } ?>
                
                <div class="button fr">
                    <input type="submit" value="<?=get_lang('ly200.add');?>" name="submit" class="form_button">
                </div>
                <div class="clear"></div>
            </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>