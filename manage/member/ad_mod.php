<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'ad_member';
check_permit('ad_member', 'ad_member.mod');

if($_GET['action']=='delimg'){
	$AId=(int)$_GET['AId'];
	$Field=$_GET['Field'];
	$PicPath=$_GET['PicPath'];
	$ImgId=$_GET['ImgId'];
	
	del_file($PicPath);
	
	$db->update('ad', "AId='$AId'", array(
			$Field	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('$ImgId').innerHTML='$str'; parent.document.getElementById('{$ImgId}_a').innerHTML='';</script>";
    header('Location: ad_mod.php?AId='.$AId);
	exit;
}

if($_POST){
    $AdCenter = $_POST['AdCenter'];
	$save_dir=get_cfg('ly200.up_file_base_dir').'ad/'.date('y_m_d/', $service_time);
	$AId=(int)$_POST['AId'];
	$AdType=(int)$_POST['AdType'];
	
	if($AdType==0){
		$PicCount=(int)$_POST['PicCount'];
		$PicPath=$Name=$Url=array();
		
		for($i=0; $i<$PicCount; $i++){
			$S_PicPath=$_POST['S_PicPath_'.$i];
			$Name[]=$_POST['Name_'.$i];
			$Url[]=$_POST['Url_'.$i];
			if($tmp_path=up_file($_FILES['PicPath_'.$i], $save_dir)){
				$PicPath[$i]=$tmp_path;
				del_file($S_PicPath);
			}else{
				$PicPath[$i]=$S_PicPath;
			}
		}

        $AdPicPath=$Url2=array();
        for($j=0; $j<$PicCount; $j++){
            $S_AdPicPath=$_POST['S_AdPicPath_'.$j];
            $Url2[]=$_POST['Url2_'.$j];
            
            if($tmp_path1=up_file($_FILES['AdPicPath_'.$j], $save_dir)){
                $AdPicPath[$j]=$tmp_path1;
                del_file($S_AdPicPath);
            }else{
                $AdPicPath[$j]=$S_AdPicPath;
            }
        }
        $AdPicPath2=$Url3=array();
        for($j=0; $j<$PicCount; $j++){
            $S_AdPicPath2=$_POST['S_AdPicPath2_'.$j];
            $Url3[]=$_POST['Url3_'.$j];
            //var_dump($_POST['Url3_'.$i]);exit;
            if($tmp_path2=up_file($_FILES['AdPicPath2_'.$j], $save_dir)){
                $AdPicPath2[$j]=$tmp_path2;
                del_file($S_AdPicPath2);
            }else{
                $AdPicPath2[$j]=$S_AdPicPath2;
            }
        }

        $PicPathBack=array();
        for($j=0; $j<$PicCount; $j++){
            $S_PicPathBack=$_POST['S_PicPathBack_'.$j];
            if($tmp_path2=up_file($_FILES['PicPathBack_'.$j], $save_dir)){
                $PicPathBack[$j]=$tmp_path2;
                del_file($S_AdPicPath2);
            }else{
                $PicPathBack[$j]=$S_PicPathBack;
            }
        }
		$db->update('ad', "AId='$AId'", array(
				'Name_0'		=>	$Name[0],
				'Name_1'		=>	$Name[1],
				'Name_2'		=>	$Name[2],
				'Name_3'		=>	$Name[3],
				'Name_4'		=>	$Name[4],
				'Url_0'			=>	$Url[0],
				'Url_1'			=>	$Url[1],
				'Url_2'			=>	$Url[2],
				'Url_3'			=>	$Url[3],
				'Url_4'			=>	$Url[4],
				'PicPath_0'		=>	$PicPath[0],
				'PicPath_1'		=>	$PicPath[1],
				'PicPath_2'		=>	$PicPath[2],
				'PicPath_3'		=>	$PicPath[3],
				'PicPath_4'		=>	$PicPath[4],

                'PicPathBack_0' =>  $PicPathBack[0],
                'PicPathBack_1' =>  $PicPathBack[1],
                'PicPathBack_2' =>  $PicPathBack[2],
                'PicPathBack_3' =>  $PicPathBack[3],
                'PicPathBack_4' =>  $PicPathBack[4],

                'AdPicPath_0'   =>  $AdPicPath[0],
                'AdPicPath_1'   =>  $AdPicPath[1],
                'AdPicPath_2'   =>  $AdPicPath[2],
                'AdPicPath_3'   =>  $AdPicPath[3],
                'AdPicPath_4'   =>  $AdPicPath[4],
                'AdPicPath2_0'  =>  $AdPicPath2[0],
                'AdPicPath2_1'  =>  $AdPicPath2[1],
                'AdPicPath2_2'  =>  $AdPicPath2[2],
                'AdPicPath2_3'  =>  $AdPicPath2[3],
                'AdPicPath2_4'  =>  $AdPicPath2[4],
                
                'Url2_0'         =>  $Url2[0],
                'Url2_1'         =>  $Url2[1],
                'Url2_2'         =>  $Url2[2],
                'Url2_3'         =>  $Url2[3],
                'Url2_4'         =>  $Url2[4],
                'Url3_0'         =>  $Url3[0],
                'Url3_1'         =>  $Url3[1],
                'Url3_2'         =>  $Url3[2],
                'Url3_3'         =>  $Url3[3],
                'Url3_4'         =>  $Url3[4],
                'AdPicPath3_0'     =>  $AdPicPath3[0],
                'AdPicPath3_1'     =>  $AdPicPath3[1],
                'AdPicPath3_2'     =>  $AdPicPath3[2],
                'AdPicPath3_3'     =>  $AdPicPath3[3],
                'AdPicPath3_4'     =>  $AdPicPath3[4],
                'AdCenter'         =>  $AdCenter,
			)
		);
	}elseif($AdType==1){
		$Name=$_POST['Name'];
		$S_FlashPath=$_POST['S_FlashPath'];
		
		if($tmp_path=up_file($_FILES['FlashPath'], $save_dir)){
			$FlashPath=$tmp_path;
			del_file($S_FlashPath);
		}else{
			$FlashPath=$S_FlashPath;
		}
		
		$db->update('ad', "AId='$AId'", array(
				'Name'		=>	$Name,
				'FlashPath'	=>	$FlashPath
			)
		);
	}else{
		$Name=$_POST['Name'];
		$Contents=save_remote_img($_POST['Contents'], $save_dir);
		
		$db->update('ad', "AId='$AId'", array(
				'Name'		=>	$Name,
				'Contents'	=>	$Contents
			)
		);
	}
	
	save_manage_log('更新广告图片');
	
	header('Location: ad.php');
	exit;
}
					
$AId=(int)$_GET['AId'];
$ad_row=$db->get_one('ad', "AId='$AId'");
include('../../inc/manage/header.php');
?>

    <?php include('ad_header.php');?>
    <form style="background:#fff;min-height:768px;width:95%" method="post"  action="ad_mod.php" enctype="multipart/form-data" >
    	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px"><?=get_lang('ly200.mod').get_lang('ad.modelname');?></div>
        <div class="y_form"><span class="y_title"><?=get_lang('ad.pagename');?>:</span><input class="y_title_txt" value="<?=$ad_row['PageName'];?>" type="text"></div>
        <div class="y_form"><span class="y_title"><?=get_lang('ad.ad_position');?>:</span>
            <select name="" id="">
                <option value="<?=$ad_row['AdPosition'];?>"><?=$ad_row['AdPosition'];?></option>
            </select>
        </div>
        <div class="y_form"><span class="y_title"><?=get_lang('ad.width');?>:</span><input class="y_title_txt" value="<?=$ad_row['Width']?$ad_row['Width'].'px':'auto';?>" type="text"></div>
        <div class="y_form"><span class="y_title"><?=get_lang('ad.height');?>:</span><input class="y_title_txt" value="<?=$ad_row['Height']?$ad_row['Height'].'px':'auto';?>" type="text" name></div>
        <div style="width:100%;margin-top:20px;float:left;position:relative">
            <span style="position:absolute;top:0px" class="y_title">广告备注:</span><textarea style="width:750px;height:120px;border:1px solid #ccc;border-radius:3px;margin-left:105px" type="text" name="AdCenter" ><?=htmlspecialchars($ad_row['AdCenter']);?></textarea>
        </div>

        <div class="y_form1"><span class="y_title">广告图片:</span></div>
        <?php 
            $ad_path = array('one','two','three','four','five');
            $ad_path_2 = array('图一','图二','图三','图四','图五');
            $ad_path_3 = array('oneone','twotwo','threethree','fourfour','fivefive');
            for($i=0; $i<$ad_row['PicCount']; $i++){
        ?>
        <div class="y_form1">
            <div class="y_form" style="position:relative;"><input class="<?=$i+1?>" type="button" style="width:75px;height:33px;background:#0b8fff;border-radius:3px;border:none;position:absolute;left:105px;color:#fff" value="上传图片"><span class="y_title"><?=$i+1?>:</span><input id="<?=$ad_path_3[$i]?>" type="text" style="width:240px;height:33px;background:#fff;border-radius:3px;border:1px solid #ccc;position:absolute;left:180px;color:#000" value=""><input id="<?=$ad_path[$i]?>" onchange="preImg(this.id,'photo<?=$ad_path[$i]?>','<?=$ad_path_3[$i]?>');" class="y_title_txt a<?=$i+1?>" value="上传图片" type="file" name="PicPath_<?=$i?>" ><input type="hidden" name="S_PicPath_<?=$i;?>" value="<?=$ad_row['PicPath_'.$i];?>" /></div>    
            <div class="y_form"><span class="y_title">链接地址:</span><input class="y_title_txt"  type="text" name="Url_<?=$i;?>" value="<?=htmlspecialchars($ad_row['Url_'.$i]);?>"></div>
        </div> 
        <?php }?>
       
        <div style="width:800px;float:left;margin-top:40px;margin-left:90px">
            <?php 
                
                for($i=0; $i<$ad_row['PicCount']; $i++){
                    if($ad_row['PicPath_'.$i]){
                        $src = 'src='.$ad_row['PicPath_'.$i];
                    }else{
                        $src = "";
                    }
            ?>
            <div style="width:100px;height:70px;float:left;padding:10px;color:#666;font-size:12px">
                <?php 
                    if($ad_row['PicPath_'.$i]){
                ?>
                    <a id="img_list_<?=$i;?>" href="<?=str_replace('s_', '', $ad_row['PicPath_'.$i]);?>" target="_blank"><img id="photo<?=$ad_path[$i]?>" <?=$src?> style="display: block;width:100%;height:100%;" /></a>
                <?php }else{?>
                    <img id="photo<?=$ad_path[$i]?>" <?=$src?> style="display: block;width:100%;height:100%;" />
                <?php }?>
                <div style="height:20px;line-height:20px;margin-top:10px" >
                    <div style="float:left"><?=$ad_path_2[$i]?></div>
                    <a id="img_list_<?=$i;?>_a" style="float:left" class="yxx_del" href="ad_mod.php?action=delimg&AId=<?=$AId;?>&Field=PicPath_<?=$i;?>&PicPath=<?=$ad_row['PicPath_'.$i];?>">删除</a>

                </div>
            </div>
            <?php }?>    
        </div>              
        <div class="y_submit">
        	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="ys_input">
			<input type="hidden" name="AId" value="<?=$AId;?>"><input type="hidden" name="AdType" value="<?=$ad_row['AdType'];?>" />
            <input type="hidden" name="PicCount" value="<?=$ad_row['PicCount'];?>" />
        </div>
           
        <?php include('../../inc/manage/footer.php');?>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>
<script>
    function getFileUrl(sourceId) {  
                var url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));    
                return url;  
            }  
    function preImg(sourceId, targetId,id) {   
        var url = getFileUrl(sourceId);   
        var imgPre = document.getElementById(targetId);  
        document.getElementById(id).value=document.getElementById(sourceId).value; 
        imgPre.src = url;   
    }   
    $(function(){
        $(".y_form1").find('.1').click(function(){
                  })
        $(".y_form1").find('.2').click(function(){
          
        })
        $(".y_form1").find('.3').click(function(){
          
        })
        $(".y_form1").find('.4').click(function(){
          
        })
        $(".y_form1").find('.5').click(function(){
         
        })
    })
    
</script>