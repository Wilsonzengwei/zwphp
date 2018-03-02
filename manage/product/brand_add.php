<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_brand';
check_permit('product_brand', 'product.brand.add');

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'product/brand/'.date('y_m_d/', $service_time);
	$Brand=$_POST['Brand'];
	$SeoTitle=$_POST['SeoTitle'];
	$SeoKeywords=$_POST['SeoKeywords'];
	$SeoDescription=$_POST['SeoDescription'];
	
	if(get_cfg('product.brand.upload_logo')){
		if($BigLogoPath=up_file($_FILES['LogoPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallLogoPath=img_resize($BigLogoPath, '', get_cfg('product.brand.logo_width'), get_cfg('product.brand.logo_height'));
		}
	}
	
	$db->insert('product_brand', array(
			'Brand'			=>	$Brand,
			'LogoPath'		=>	$SmallLogoPath,
			'SeoTitle'		=>	$SeoTitle,
			'SeoKeywords'	=>	$SeoKeywords,
			'SeoDescription'=>	$SeoDescription
		)
	);
	
	$BId=$db->get_insert_id();
	get_cfg('product.brand.description') && $Description=save_remote_img($_POST['Description'], $save_dir);
	$db->insert('product_brand_description', array(
			'BId'			=>	$BId,
			'Description'	=>	$Description
		)
	);
	
	//保存另外的语言版本的数据
	if(count(get_cfg('ly200.lang_array'))>1){
		add_lang_field('product_brand', array('Brand', 'SeoTitle', 'SeoKeywords', 'SeoDescription'));
		add_lang_field('product_brand_description', 'Description');
		
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$BrandExt=$_POST['Brand'.$field_ext];
			$SeoTitleExt=$_POST['SeoTitle'.$field_ext];
			$SeoKeywordsExt=$_POST['SeoKeywords'.$field_ext];
			$SeoDescriptionExt=$_POST['SeoDescription'.$field_ext];
			$db->update('product_brand', "BId='$BId'", array(
					'Brand'.$field_ext			=>	$BrandExt,
					'SeoTitle'.$field_ext		=>	$SeoTitleExt,
					'SeoKeywords'.$field_ext	=>	$SeoKeywordsExt,
					'SeoDescription'.$field_ext	=>	$SeoDescriptionExt
				)
			);
			
			if(get_cfg('product.category.description')){
				$DescriptionExt=save_remote_img($_POST['Description'.$field_ext], $save_dir);
				$db->update('product_brand_description', "BId='$BId'", array(
						'Description'.$field_ext	=>	$DescriptionExt
					)
				);
			}
		}
	}
	
	set_page_url('product_brand', "BId='$BId'", get_cfg('product.brand.page_url'), 2);
	
	save_manage_log('添加产品品牌:'.$Brand);
	
	header('Location: brand.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
    <form method="post" name="act_form" id="act_form" class="act_form" action="brand_add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
            <div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.add').get_lang('product.brand');?></div>
                <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.brand').lang_name($i, 0);?>:</font>
                        <span class="fl">
                        	<input name="Brand<?=lang_name($i, 1);?>" value="" class="form_input" type="text" size="98" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('ly200.brand_name');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php }?>
            </div>
            
            <?php if(get_cfg('product.brand.upload_logo')){?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.photo');?>:</font>
                        <span class="fl">
                            <input name="LogoPath" type="file" size="50" class="form_input" contenteditable="false"><br>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('product.brand.seo_tkd')){?>
				<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="tr<?=$i==count(get_cfg('ly200.lang_array'))-1?' last':''?>">
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
            
            <?php if(get_cfg('product.brand.description')){?>
            	<div class="tr last">
                	<div class="tr_title"><?=get_lang('ly200.briefinfo');?>:</div>
					<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                        <div class="editor_row">
                            <div class="editor_title fl"><?=get_lang('ly200.description').lang_name($i, 0);?>:</div>
                            <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Description<?=lang_name($i, 1);?>"></textarea></div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
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