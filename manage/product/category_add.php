<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_category';
check_permit('product_category', 'product.category.add');

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'product/'.date('y_m_d/', $service_time);
	$UnderTheCateId=(int)$_POST['UnderTheCateId'];
	$Category_lang_1=$_POST['Category_lang_1'];
	$IsInIndex=(int)$_POST['IsInIndex'];
	$SeoTitle=$_POST['SeoTitle_lang_1'];
	$SeoKeywords=$_POST['SeoKeywords_lang_1'];
	$SeoDescription=$_POST['SeoDescription_lang_1'];
	
	
	if(get_cfg('product.category.upload_pic')){
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('product.category.pic_width'), get_cfg('product.category.pic_height'));
		}
		if($BigPicPath_1=up_file($_FILES['PicPath_1'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath_1=img_resize($BigPicPath_1, '', 60,60);
		}
	}
	
	if($UnderTheCateId==0){
		$UId='0,';
		$Dept=1;
		$PIdCateId=(int)$_POST['PIdCateId'];
	}else{
		$UId=get_UId_by_CateId($UnderTheCateId, 'product_category');
		$Dept=substr_count($UId, ',');
	}
	
	$db->insert('product_category', array(
			'UId'			=>	$UId,
			'Category_lang_1'		=>	$Category_lang_1,
			'IsInIndex'		=>	$IsInIndex,
			'PicPath'		=>	$SmallPicPath,
			'PicPath_1'		=>	$SmallPicPath_1,
			'SeoTitle_lang_1'		=>	$SeoTitle,
			'SeoKeywords_lang_1'	=>	$SeoKeywords,
			'SeoDescription_lang_1'=>	$SeoDescription,
			'Dept'			=>	$Dept,
			'PIdCateId'		=>	$PIdCateId
		)
	);
	
	$CateId=$db->get_insert_id();
	get_cfg('product.category.description') && $Description=save_remote_img($_POST['Description'], $save_dir);
	$db->insert('product_category_description', array(
			'CateId'		=>	$CateId,
			'Description'	=>	$Description
		)
	);
	
	//保存另外的语言版本的数据
	$Category=$_POST['Category'];
	$Category_lang_1=$_POST['Category_lang_1'];
	$Category_lang_2=$_POST['Category_lang_2'];
	$db->update('product_category', "CateId='$CateId'", array(
					'Category'			=>	$Category,
					'Category_lang_1'	=>	$Category_lang_1,
					'Category_lang_2'	=>	$Category_lang_2,
					
				)
			);
	if(count(get_cfg('ly200.lang_array'))>1){
		add_lang_field('product_category', array('Category', 'SeoTitle', 'SeoKeywords', 'SeoDescription'));
		add_lang_field('product_category_description', 'Description');
		
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$CategoryExt=$_POST['Category'.$field_ext];
			$SeoTitleExt=$_POST['SeoTitle'.$field_ext];
			$SeoKeywordsExt=$_POST['SeoKeywords'.$field_ext];
			$SeoDescriptionExt=$_POST['SeoDescription'.$field_ext];
			$db->update('product_category', "CateId='$CateId'", array(
					//'Category'.$field_ext		=>	$CategoryExt,
					'SeoTitle'.$field_ext		=>	$SeoTitleExt,
					'SeoKeywords'.$field_ext	=>	$SeoKeywordsExt,
					'SeoDescription'.$field_ext	=>	$SeoDescriptionExt
				)
			);
			
			if(get_cfg('product.category.description')){
				$DescriptionExt=save_remote_img($_POST['Description'.$field_ext], $save_dir);
				$db->update('product_category_description', "CateId='$CateId'", array(
						'Description'.$field_ext	=>	$DescriptionExt
					)
				);
			}
		}
	}
	
	$db->update('manage_operation_log', 'Operation="product_category_add"', array(
			'Value'	=>	$UnderTheCateId
		)
	);
	
	category_subcate_statistic('product_category');
	set_page_url('product_category', "CateId='$CateId'", get_cfg('product.category.page_url'), 0);
	
	save_manage_log('添加产品类别:'.$Category);
	
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
                            <input name="Category<?=lang_name($i, 1);?>" class="form_input" type="text" size="98" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('ly200.category_name');?>!~*" <?=get_cfg('product.category.mod_name')?'':'disabled';?>>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?> 
            </div>
            
			<?php if(get_cfg('product.category.dept')>1){ ?>
                <div class="tr">
                	<div class="form_row">
                        <font class="fl"><?=get_lang('ly200.under_the');?>:</font>
                        <span class="fl">
							<?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('UnderTheCateId', $db->get_value('manage_operation_log', 'Operation="product_category_add"', 'Value'), 'product_category', 'UId="0,"', 'Dept<'.get_cfg('product.category.dept'), get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            <?php if(get_cfg('product.category.upload_pic')){?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.photo');?>:</font>
                        <span class="fl">
                            <input name="PicPath" type="file" size="50" class="form_input" contenteditable="false">
							<b>图片尺寸 一级分类 290*520 像素  二级分类 420*240 像素</b>
                            <br>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="tr">
                    <div class="tr_title">手机版<?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.photo');?>:</font>
                        <span class="fl">
                            <input name="PicPath" type="file" size="50" class="form_input" contenteditable="false">
							<b> 仅一级分类上传 图片尺寸 60*60 像素  </b>
                            <br>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            <?php if(get_cfg('product.category.is_in_index')){?>
            	<div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.other_property');?>:</div>
                    <div class="form_row">
                        <span class="fl">
							<?php if(get_cfg('product.is_in_index')){?>
                            	<div class="items" onClick="checkproperty(this)"><?=get_lang('ly200.is_in_index');?></div>
                            	<input name="IsInIndex" type="hidden" value="0">
							<?php }?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <?php if(get_cfg('product.category.seo_tkd')){?>
				
                    <div class="tr">
                        <div class="tr_title"><?=get_lang('ly200.seo.seo');?>:</div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                            <span class="fl">
                                <input name="SeoTitle_lang_1" type="text" value="" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                            <span class="fl">
                                <input name="SeoKeywords_lang_1" type="text" value="" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                            <span class="fl">
                                <input name="SeoDescription_lang_1" type="text" value="" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
               
            <?php } ?>

			<?php if(get_cfg('product.category.description')){?>
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