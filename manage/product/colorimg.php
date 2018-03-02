<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');


if($_GET['action']=='delimg'){
	$AId=(int)$_POST['AId'];
	$Field=$_GET['Field'];
	$PicPath=$_GET['PicPath'];
	$ImgId=$_GET['ImgId'];
	
	foreach(get_cfg('product.pic_size') as $key=>$value){
		if("$key"=='default'){
			del_file($PicPath);
			del_file(str_replace('s_', '', $PicPath));
		}else{
			del_file(str_replace('s_', $value.'_', $PicPath));
		}
	}
	
	$db->update('colorimg', "AId='$AId'", array(
			$Field	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('$ImgId').innerHTML='$str'; parent.document.getElementById('{$ImgId}_a').innerHTML='';</script>";
	exit;
}

if($_POST){
	$PkeyId=$_POST['PkeyId'];	
	$PkeyId=$_POST['PkeyId'];
	$ProId=$_POST['ProId'];
	$AId=$_POST['AId'];
	$save_dir=get_cfg('ly200.up_file_base_dir').'product/color/'.date('y_m_d/', $service_time);
	include('../../inc/fun/img_resize.php');
	//include('../../inc/fun/img_add_watermark.php');
	for($t=0;$t<count($PkeyId);$t++){
		$BigPicPath=$SmallPicPath=array();	//$SmallPicPath存入数据库的
		if(get_cfg('product.pic_count')){
			for($i=0; $i<get_cfg('product.pic_count'); $i++){
				$S_PicPath=$_POST['S_PicPath'.$PkeyId[$t].'_'.$i];
				if($tmp_path=up_file($_FILES['PicPath'.$PkeyId[$t].'_'.$i], $save_dir)){
					$BigPicPath[$i]=$SmallPicPath[$i]=$tmp_path;
					del_file($S_PicPath);
					del_file(str_replace('s_', '', $S_PicPath));
					foreach(get_cfg('product.pic_size') as $key=>$value){
						$w_h=@explode('X', $value);
						$filename="$key"=='default'?'':dirname($tmp_path).'/'.$value.'_'.basename($tmp_path);
						$path=img_resize($SmallPicPath[$i], $filename, (int)$w_h[0], (int)$w_h[1]);
						"$key"=='default' && $SmallPicPath[$i]=$path;
						del_file(str_replace('s_', $value.'_', $S_PicPath));
					}
				}else{
					$SmallPicPath[$i]=$S_PicPath;
				}
			}
			if(get_cfg('ly200.img_add_watermark')){
				foreach($BigPicPath as $value){
					img_add_watermark($value);
				}
			}
		}
		if($AId[$t]){
			$db->update('colorimg', "AId='$AId[$t]'", array(
					'PkeyId'	=>	$PkeyId[$t],
					'ProId'		=>	$ProId,
					'PicPath_0'	=>	$SmallPicPath[0],
					'PicPath_1'	=>	$SmallPicPath[1],
					'PicPath_2'	=>	$SmallPicPath[2],
					'PicPath_3'	=>	$SmallPicPath[3],
					'PicPath_4'	=>	$SmallPicPath[4],
				)
			);
		}else{
			$db->insert('colorimg', array(
					'PkeyId'	=>	$PkeyId[$t],
					'ProId'		=>	$ProId,
					'PicPath_0'	=>	$SmallPicPath[0],
					'PicPath_1'	=>	$SmallPicPath[1],
					'PicPath_2'	=>	$SmallPicPath[2],
					'PicPath_3'	=>	$SmallPicPath[3],
					'PicPath_4'	=>	$SmallPicPath[4],
				)
			);
		}
	}
	save_manage_log('更新产品属性颜色颜色:'.$ProId);
	
	header('Location: colorimg.php?ProId='.$ProId);
	exit;
}

$ProId=(int)$_GET['ProId'];
$product_row=$db->get_one('product', "ProId='$ProId'");

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('color_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="colorimg.php?ProId=<?=$ProId?>" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    <div class="table">
    <?php 
		$all_row=$db->get_all('param','1');
		foreach((array)$all_row as $v){
			$all_attr_row[$v['PId']]=$v;
		}
		
		$attr_ary=str::json_data(htmlspecialchars_decode($product_row['Attr']), 'decode');
		foreach((array)$attr_ary as $k=>$value){
			
			if($all_attr_row[$k]['FieldType']=='1'){
				$v=str::json_data(htmlspecialchars_decode($all_attr_row[$k]['Value']), 'decode');
				foreach((array)$v as $k2=>$v2){
					if(!in_array($k2,$value)) continue;
					$colorimg=$db->get_one('colorimg',"PkeyId = '$k2' and ProId = '{$product_row['ProId']}'");
		?>
            	<div class="tr">
                	<div class="tr_title"><?=$v2;?>:</div>
                    <div class="form_row">
                    	<?php for($i=0; $i<get_cfg('product.pic_count'); $i++){ ?>
                            <font class="fl">图片<?=($i+1);?></font>
                            <span class="fl">
                                <input name="PicPath<?=$k2?>_<?=$i?>" type="file" class="form_largefile" contenteditable="false">
                                <br /><br />
                            </span>
                            <div class="clear"></div>
                       	<?php } ?>
                        <input type="hidden" name="PkeyId[]" value="<?=$k2?>" />
                        <input type="hidden" name="AId[]" value="<?=$colorimg['AId']?>" />
                        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px; margin-left:<?=get_cfg('product.pic_count')>1?'12':'0';?>px;">
                          <tr>
                            <?php
                            for($i=0; $i<get_cfg('product.pic_count'); $i++){
                                if(!is_file($site_root_path.$colorimg['PicPath_'.$i])){
                                    continue;
                                }
                            ?>
                                <td>
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list_<?=$k2.$i;?>"><a href="<?=str_replace('s_', '', $colorimg['PicPath_'.$i]);?>" target="_blank"><img src="<?=$colorimg['PicPath_'.$i];?>" <?=img_width_height(70, 70, $colorimg['PicPath_'.$i]);?> /></a><input type='hidden' name='S_PicPath<?=$k2?>_<?=$i;?>' value='<?=$colorimg['PicPath_'.$i];?>'></td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_<?=$k2.$i;?>_a">&nbsp;<a href="colorimg.php?action=delimg&AId=<?=$colorimg['AId']?>&Field=PicPath_<?=$i;?>&PicPath=<?=$colorimg['PicPath_'.$i];?>&ImgId=img_list_<?=$k2.$i;?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="5">&nbsp;&nbsp;</td>
                            <?php }?>
                          </tr>
                        </table>
                    </div>
                </div>
                <?php }?>
            <?php } ?>
           <?php } ?>
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
				<input type="hidden" name="ProId" value="<?=$ProId;?>">
            </div>
            <div class="clear"></div>
        </div>
    </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>