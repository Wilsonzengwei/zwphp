<?php 

/*if($_SESSION['IsSupplier'] !== '1'){
  
    echo '<script>alert("只有商户才能访问");</script>';
    header("Refresh:0;url=/");
    exit;
}*/
$SupplierId = $_SESSION['member_MemberId'];
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
    header('Location: /supplier_manage.php?module=ad_mod&AId='.$AId);
	exit;
}

if($_POST){
   // $AdCenter = $_POST['AdCenter'];
    $SupplierId = $_POST['SupplierId'];
	$save_dir='/u_file/'.date('ym').'/'.'ad/'.date('y_m_d/', $service_time);
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
                //'AdCenter'         =>  $AdCenter,
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
	
	header('refresh:0;url=/supplier_manage.php?module=ad_mod&AId='.$AId);
	exit;
}
$AId=(int)$_GET['AId'];
$ad_row=$db->get_one('ad', "AId='$AId'");
?>
<link rel="stylesheet" href="/css/supplier_m/ad_mod.css">
<form method="post" action="/supplier_manage.php"  enctype="multipart/form-data">
<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['header'.$lang]['mjzx']?></div>
	<ul class="y_list">
        <li class="y" data='1'><a href="/supplier_manage.php?module=index&act=1" class='s1'><?=$website_language['supplier_m_index'.$lang]['dpgl']?></a>                        
        </li>
        <li class="y" data='1'><a href="/supplier_manage.php?module=index&act=2" class='s2'><?=$website_language['supplier_m_index'.$lang]['gggl']?></a>            
        </li>
        <li class="y" data='1'><a href="/supplier_manage.php?module=product&act=3" class='s1'><?=$website_language['supplier_m_index'.$lang]['cpgl']?></a>          
        </li>
        <li class="y" data='1'><a href="/supplier_manage.php?module=order&act=4" class='s1'><?=$website_language['supplier_m_index'.$lang]['ddgl']?></a>        
        </li>
    </ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['supplier_m_index'.$lang]['gggl']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<div class="biaoti"><?=$website_language['supplier_m_index'.$lang]['xgxx']?></div>
			<!-- <div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['ggmc']?>：</span><input class="y_title_txt" type="text" name="" value="<?=$ad_row['PageName'];?>">
			</div> -->
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['ggwz']?>：</span><input class="y_title_txt" type="text" name="" value="<?=$ad_row['AdPosition'];?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['ggkd']?>：</span><input placeholder='单位：PX' class="y_title_txt" type="text" name="" value="<?=$ad_row['Width']?$ad_row['Width'].'px':'auto';?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['gggd']?>：</span><input placeholder='单位：PX' class="y_title_txt" type="text" name="" value="<?=$ad_row['Width']?$ad_row['Height'].'px':'auto';?>">
			</div>						
	        
	        <div class="y_form1">
	             <?php 
            $ad_path = array('one','two','three','four','five');
            $ad_path_2 = array($website_language['ylfy'.$lang]['t1'],$website_language['ylfy'.$lang]['t2'],$website_language['ylfy'.$lang]['t3'],$website_language['ylfy'.$lang]['t4'],$website_language['ylfy'.$lang]['t5']);
            $ad_path_3 = array('oneone','twotwo','threethree','fourfour','fivefive');
            for($i=0; $i<$ad_row['PicCount']; $i++){
                $strstr = strstr($ad_row['PicPath_'.$i],"ad/");
                $substr = substr($strstr,12);
        ?>
        <div class="y_form1">
            <div class="y_form" style="position:relative;"><input class="<?=$i+1?>" type="button" style="width:100px;height:33px;background:#0b8fff;border-radius:3px;border:none;position:absolute;left:155px;color:#fff" value="<?=$website_language['supplier_m_index'.$lang]['sctp']?>"><span class="y_title"><?=$i+1?>:</span><input id="<?=$ad_path_3[$i]?>" type="text" style="width:210px;height:33px;background:#fff;border-radius:3px;border:1px solid #ccc;position:absolute;left:255px;color:#000" value="<?=$substr?>"><input id="<?=$ad_path[$i]?>" onchange="preImg(this.id,'photo<?=$ad_path[$i]?>','<?=$ad_path_3[$i]?>');" class="y_title_txt a<?=$i+1?>" value="上传图片" type="file" name="PicPath_<?=$i?>" ><input type="hidden" name="S_PicPath_<?=$i;?>" value="<?=$ad_row['PicPath_'.$i];?>" /></div>    
            <div class="y_form"><span class="y_title"><?=$website_language['supplier_m_index'.$lang]['ljdz']?>:</span><input class="y_title_txt"  type="text" name="Url_<?=$i;?>" value="<?=htmlspecialchars($ad_row['Url_'.$i]);?>"></div>
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
                <div style="height:20px;line-height:20px;margin-top:10px;text-align: center;" >
                    <div style="float:left"><?=$ad_path_2[$i]?></div>
                    <a id="img_list_<?=$i;?>_a" style="float:left" class="yxx_del" href="/supplier_manage.php?module=ad_mod&action=delimg&AId=<?=$AId;?>&Field=PicPath_<?=$i;?>&PicPath=<?=$ad_row['PicPath_'.$i];?>">&nbsp;&nbsp;&nbsp;<?=$website_language['supplier_m_index'.$lang]['sc']?></a>

                </div>
            </div>
            <?php }?>   
	        </div>
	        <div class="y_submit">	
	       		<input type="hidden" name="AId" value="<?=$AId;?>">
                <input type="hidden" name="AdType" value="<?=$ad_row['AdType'];?>" />
                <input type="hidden" name="module" value="ad_mod">
            	<input type="hidden" name="PicCount" value="<?=$ad_row['PicCount'];?>" />
		        <input class="ys_input" type="submit" value="<?=$website_language['supplier_m_index'.$lang]['bc']?>">
		    </div>
		</div>
		</div>
	</div>
</div>
</form>
<script>
		function getFileUrl(sourceId) {  
                var url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));    
                return url;  
            }  
            function preImg(sourceId,id){   
                var url = getFileUrl(sourceId);                   
                document.getElementById(id).value=document.getElementById(sourceId).value; 
              
            }  
            function preImg2(sourceId, targetId){   
                var url = getFileUrl(sourceId);   
                var imgPre = document.getElementById(targetId);
                imgPre.src = url;                       
            } 
	$('.111').click(function(){
		$('#aa1').click();
	})
	$('.222').click(function(){
		$('#bb1').click();
	})
	$('.333').click(function(){
		$('#cc1').click();
	})
</script>
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
           $(".y_form1").find(".a1").click();
        })
        $(".y_form1").find('.2').click(function(){
           $(".y_form1").find(".a2").click();
        })
        $(".y_form1").find('.3').click(function(){
           $(".y_form1").find(".a3").click();
        })
        $(".y_form1").find('.4').click(function(){
           $(".y_form1").find(".a4").click();
        })
        $(".y_form1").find('.5').click(function(){
           $(".y_form1").find(".a5").click();
        })
    })
    
</script>