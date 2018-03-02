<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='instance_category';
check_permit('instance_category', 'instance.category.add');

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'instance/'.date('y_m_d/', $service_time);
	$UnderTheCateId=(int)$_POST['UnderTheCateId'];
	$Category=$_POST['Category'];
	$SeoTitle=$_POST['SeoTitle'];
	$SeoKeywords=$_POST['SeoKeywords'];
	$SeoDescription=$_POST['SeoDescription'];
	
	if(get_cfg('instance.category.upload_pic')){
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('instance.category.pic_width'), get_cfg('instance.category.pic_height'));	
		}
	}
	
	if($UnderTheCateId==0){
		$UId='0,';
		$Dept=1;
	}else{
		$UId=get_UId_by_CateId($UnderTheCateId, 'instance_category');
		$Dept=substr_count($UId, ',');
	}
	
	$db->insert('instance_category', array(
			'UId'			=>	$UId,
			'Category'		=>	$Category,
			'PicPath'		=>	$SmallPicPath,
			'SeoTitle'		=>	$SeoTitle,
			'SeoKeywords'	=>	$SeoKeywords,
			'SeoDescription'=>	$SeoDescription,
			'Dept'			=>	$Dept
		)
	);
	
	$CateId=$db->get_insert_id();
	get_cfg('instance.category.description') && $Description=save_remote_img($_POST['Description'], $save_dir);
	$db->insert('instance_category_description', array(
			'CateId'		=>	$CateId,
			'Description'	=>	$Description
		)
	);
	
	//保存另外的语言版本的数据
	if(count(get_cfg('ly200.lang_array'))>1){
		add_lang_field('instance_category', array('Category', 'SeoTitle', 'SeoKeywords', 'SeoDescription'));
		add_lang_field('instance_category_description', 'Description');
		
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$CategoryExt=$_POST['Category'.$field_ext];
			$SeoTitleExt=$_POST['SeoTitle'.$field_ext];
			$SeoKeywordsExt=$_POST['SeoKeywords'.$field_ext];
			$SeoDescriptionExt=$_POST['SeoDescription'.$field_ext];
			$db->update('instance_category', "CateId='$CateId'", array(
					'Category'.$field_ext		=>	$CategoryExt,
					'SeoTitle'.$field_ext		=>	$SeoTitleExt,
					'SeoKeywords'.$field_ext	=>	$SeoKeywordsExt,
					'SeoDescription'.$field_ext	=>	$SeoDescriptionExt
				)
			);
			
			if(get_cfg('instance.category.description')){
				$DescriptionExt=save_remote_img($_POST['Description'.$field_ext], $save_dir);
				$db->update('instance_category_description', "CateId='$CateId'", array(
						'Description'.$field_ext	=>	$DescriptionExt
					)
				);
			}
		}
	}
	
	category_subcate_statistic('instance_category');
	set_page_url('instance_category', "CateId='$CateId'", get_cfg('instance.category.page_url'), 0);
	
	$db->update('manage_operation_log', 'Operation="instance_category_add"', array(
			'Value'	=>	$UnderTheCateId
		)
	);
	
	save_manage_log('添加成功案例类别:'.$Category);
	
	header('Location: category.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('category_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="category_add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
        <div class="table">
            <div class="table_bg"></div>
            <div class="tr">
                <div class="tr_title"><?=get_lang('ly200.mod').get_lang('ly200.category');?></div>
                <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.category_name').lang_name($i, 0);?>:</font>
                        <span class="fl">
                            <input name="Category<?=lang_name($i, 1);?>" value="" class="form_input" type="text" size="98" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('ly200.category_name');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>  
            </div>
            
			<?php if(get_cfg('instance.category.dept')>1){ ?>
                <div class="tr">
                	<div class="form_row">
                        <font class="fl"><?=get_lang('ly200.under_the');?>:</font>
                        <span class="fl">
							<?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('UnderTheCateId', $db->get_value('manage_operation_log', 'Operation="instance_category_add"', 'Value'), 'instance_category', 'UId="0,"', 'Dept<'.get_cfg('instance.category.dept'), get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            
            <?php if(get_cfg('instance.category.upload_pic')){?>
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
            
            <?php if(get_cfg('instance.category.seo_tkd')){?>
				<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="tr">
                        <div class="tr_title"><?=get_lang('ly200.seo.seo').lang_name($i, 0);?>:</div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                            <span class="fl">
                                <input name="SeoTitle<?=lang_name($i, 1);?>" type="text" value="" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                            <span class="fl">
                                <input name="SeoKeywords<?=lang_name($i, 1);?>" type="text" value="" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                            <span class="fl">
                                <input name="SeoDescription<?=lang_name($i, 1);?>" type="text" value="" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

			<?php if(get_cfg('instance.category.description')){?>
                <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="tr<?=$i==count(get_cfg('ly200.lang_array'))-1?' last':'';?>">
                    	<div class="tr_title"><?=get_lang('ly200.briefinfo');?>:</div>
                        <div class="editor_row">
                            <div class="editor_title fl"><?=get_lang('ly200.description').lang_name($i, 0);?>:</div>
                            <div class="editor_con ck_editor fl">
                                <textarea class="ckeditor" name="Description<?=lang_name($i, 1);?>"></textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php }?>
            <?php }?>
            
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.add');?>" name="submit" class="form_button">
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>