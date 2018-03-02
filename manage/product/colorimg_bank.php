<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

if($_POST){
	$CId=(int)$_POST['CId'];	
	$Color=$_POST['Color'];
	
	if(get_cfg('product.color.upload_pic')){
		$save_dir=get_cfg('ly200.up_file_base_dir').'product/color/'.date('y_m_d/', $service_time);
		$S_PicPath=$_POST['S_PicPath'];
		
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('product.color.pic_width'), get_cfg('product.color.pic_height'));
			del_file($S_PicPath);
			del_file(str_replace('s_', '', $S_PicPath));
		}else{
			$SmallPicPath=$S_PicPath;
		}
	}
	
	$db->update('product_color', "CId='$CId'", array(
			'Color'		=>	$Color,
			'PicPath'	=>	$SmallPicPath
		)
	);
	
	//保存另外的语言版本的数据
	if(count(get_cfg('ly200.lang_array'))>1){
		add_lang_field('product_color', 'Color');
		
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$ColorExt=$_POST['Color'.$field_ext];
			$db->update('product_color', "CId='$CId'", array(
					'Color'.$field_ext	=>	$ColorExt
				)
			);
		}
	}
	
	save_manage_log('更新产品颜色:'.$Color);
	
	header('Location: color.php');
	exit;
}
$type=$_GET['type'];



$ProId=(int)$_GET['ProId'];
$ProId_row=$db->get_one('product', "ProId='$ProId'");

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('color_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="color_mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
            <div class="tr last">
            	<div class="tr_title"><?=get_lang('ly200.mod').get_lang('product.color');?></div>
				<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.color').lang_name($i, 0);?>:</font>
                        <span class="fl">
                            <input name="Color<?=lang_name($i, 1);?>" value="<?=htmlspecialchars($color_row['Color'.lang_name($i, 1)]);?>" class="form_input" type="text" size="30" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('product.color');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php }?>
            </div>
            
            <?php if(get_cfg('product.color.upload_pic')){?>
            	<div class="tr last">
                	<div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.photo');?>:</font>
                        <span class="fl">
                            <input name="PicPath" type="file" size="50" class="form_input" contenteditable="false"><br>
                        </span>
                        <div class="clear"></div>
                        <?php if(is_file($site_root_path.$color_row['PicPath'])){?>
                        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px;">
                            <tr>
                                <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list"><a href="<?=str_replace('s_', '', $color_row['PicPath']);?>" target="_blank"><img src="<?=$color_row['PicPath'];?>" <?=img_width_height(70, 70, $color_row['PicPath']);?> /></a><input type='hidden' name='S_PicPath' value='<?=$color_row['PicPath'];?>'></td>
                            </tr>
                            <tr>
                                <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_a">&nbsp;<a href="color_mod.php?action=delimg&CId=<?=$CId;?>&PicPath=<?=$color_row['PicPath'];?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
                            </tr>
                        </table>
                        <?php }?>
                    </div>
                </div>
            <?php } ?>
            
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
				<input type="hidden" name="CId" value="<?=$CId;?>">
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>