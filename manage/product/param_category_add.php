<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='param_category';
check_permit('param_category', 'param.category.add');

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'param/'.date('y_m_d/', $service_time);
	$UnderTheCateId=(int)$_POST['UnderTheCateId'];
	$Category=$_POST['Category'];
	
	if(get_cfg('param.category.upload_pic')){
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('param.category.pic_width'), get_cfg('param.category.pic_height'));
		}
	}
	
	if($UnderTheCateId==0){
		$UId='0,';
		$Dept=1;
	}else{
		$UId=get_UId_by_CateId($UnderTheCateId, 'param_category');
		$Dept=substr_count($UId, ',');
	}
	
	$db->insert('param_category', array(
			'UId'			=>	$UId,
			'Category'		=>	$Category,
			'PicPath'		=>	$SmallPicPath,
			'Dept'			=>	$Dept
		)
	);
	
	/*$db->update('manage_operation_log', 'Operation="param_category_add"', array(
			'Value'	=>	$UnderTheCateId
		)
	);*/
	
	/*category_subcate_statistic('param_category');
	set_page_url('param_category', "CateId='$CateId'", get_cfg('param.category.page_url'), 0);*/
	
	save_manage_log('添加产品属性类别:'.$Category);
	
	header('Location: param_category.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('param_category_header.php');?>
	<form method="post" name="act_form" id="act_form" class="act_form" action="param_category_add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
        <div class="table">
            <div class="table_bg"></div>
            <div class="tr">
                <div class="tr_title"><?=get_lang('ly200.mod').get_lang('param.category');?></div>
                <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.category_name').lang_name($i, 0);?>:</font>
                        <span class="fl">
                            <input name="Category<?=lang_name($i, 1);?>" value="" class="form_input" type="text" size="98" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('ly200.category_name');?>!~*" <?=get_cfg('param.category.mod_name')?'':'disabled';?>>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>  
            </div>
            
            <?php if(get_cfg('param.category.upload_pic')){?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.photo');?>:</font>
                        <span class="fl">
                            <input name="PicPath" type="file" size="50" class="form_input" contenteditable="false"><br>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.add');?>" name="submit" class="form_button">
            </div>
            <div class="clear"></div>
        </div>
	</form>
</div>
<?php include('../../inc/manage/footer.php');?>