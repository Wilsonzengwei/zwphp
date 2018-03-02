<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_color';
check_permit('product_color', 'product.color.add');

if($_POST){
	$Color_lang_1=$_POST['Color_lang_1'];
    $Color=$_POST['Color'];
    $Color_en=$_POST['Color_en'];
	$Description=$_POST['Description'];
	$CId=$_POST['CId'];
/*	if(get_cfg('product.color.upload_pic')){
		$save_dir=get_cfg('ly200.up_file_base_dir').'product/color/'.date('y_m_d/', $service_time);
		
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('product.color.pic_width'), get_cfg('product.color.pic_height'));
		}
	}*/
	//var_dump($_POST);exit;
	$db->update('product_color',"CId='$CId'",array(
			'Color'         =>  $Color,
            'Color_lang_1'  =>  $Color_lang_1,
            'Color_en'      =>  $Color_en,
            'Description'   =>  $Description,
		)
	);
	
	
	
	save_manage_log('添加产品颜色:'.$Color);
	
	header('Location: color.php');
	exit;
}
$CId=$_GET['CId'];
$color_row = $db->get_one('product_color',"CId='$CId'");
include('../../inc/manage/header.php');
?>
<style>
    .y{
        height:350px;
        background:#fff;
    }
    .y_input{
        font-size:12px;color:#666;cursor:pointer;border-radius:3px;margin-right:20px;
    }
    .input_s{
        margin-left:7px
    }
    .y_form{
        width:450px;float:left;margin-top:20px;height:31px;line-height:31px;
    }
    .y_form1{
        width:100%;float:left;margin-top:20px;height:31px;line-height:31px;
    }
    .yc_title{
        display:inline-block;width:100px;text-align:right;font-size:12px;color:#666;font-weight:bold;
    }
    .y_title{
        display:inline-block;width:100px;text-align:right;font-size:12px;color:#666;font-weight:bold;
    }
    .y_title_txt{
        width:300px;height:29px;border-radius:3px;border:1px solid #ccc;color:#666;
    }
    .y_submit{
        width:100%;
        float: left;
        margin-top:40px;
        text-align:center;
    }
    .ys_input{
        border:none;background:#218fde;width:133px;height:29px;line-height:29px;
        text-align: center;
        color: #fff;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
    }
</style>
<form style="background:#fff;min-height:600px;width:95%" action="color_mod.php" method="post">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">修改颜色</div>
        <div class="table">
            <div class="table_bg"></div>
            <div class="y">
                <div class="y_form"><span class="y_title">颜色名称(中文)：</span><input class="y_title_txt" type="text" name="Color_lang_1" value="<?=$color_row['Color_lang_1']?>"></div>               
                <div class="y_form"><span class="y_title">颜色名称(西文)：</span><input class="y_title_txt" type="text" name="Color" value="<?=$color_row['Color']?>"></div>               
                <div class="y_form"><span class="y_title">颜色名称(英文)：</span><input class="y_title_txt" type="text" name="Color_en" value="<?=$color_row['Color_en']?>"></div>               
              	<div style="width:100%;margin-top:20px;float:left;position:relative">
                    <span style="position:absolute;top:0px" class="y_title">描述：</span><textarea style="width:750px;height:120px;border:1px solid #ccc;border-radius:3px;margin-left:100px" type="text" name="Description"><?=$color_row['Description']?></textarea>
                </div>
                <div class="y_submit">
                	<input type="hidden" name="CId" value="<?=$CId;?>">
                    <input class="ys_input" type="submit" value="保存">
                </div>
            </div>
        </div>
</form>
<?php include('../../inc/manage/footer.php');?>