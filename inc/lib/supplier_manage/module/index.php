<?php

if($_SESSION['IsSupplier'] !== '1'){
  
    /*echo '<script>alert("只有商户才能访问");</script>';
    header("Refresh:0;url=/");
    exit;*/
}
$SupplierId = $_SESSION['member_MemberId'];
$width = 360;
$height = 140;
$act=$_GET['act'];
if($_GET['action']=='delimg'){ //删除商户Logo
	$LogoPath=$_GET['LogoPath'];
	
	del_file($LogoPath);
	del_file(str_replace('s_', '', $LogoPath));
	$path = 's_'.$LogoPath;
	$db->update("member","MemberId='$SupplierId'",array(
			'LogoPath'  => '',
		));
	$str=js_contents_code('No Logo');
	echo "<script language=javascript>parent.document.getElementById('img_list').innerHTML='$str';parent.document.getElementById('img_list').setAttribute('target','');parent.document.getElementById('img_list').setAttribute('href','javascript:void(0);');parent.document.getElementById('img_list_a').style.display='none';</script>";
	echo '<script>alert("删除成功")</script>';
	header('refresh:0;url=/supplier_manage.php?module=index&act='.$act.'&SupplierId='.$SupplierId);
	exit;
}
if($_GET['action']=='delimg1'){ //删除商户Logo
	$LogoPath_1=$_GET['LogoPath_1'];
	
	del_file($LogoPath_1);
	del_file(str_replace('s_', '', $LogoPath_1));
	$path = 's_'.$LogoPath_1;
	$db->update("member","MemberId='$SupplierId'",array(
			'LogoPath_1'  => '',
		));
	$str=js_contents_code('No Logo');
	echo "<script language=javascript>parent.document.getElementById('img_list_1').innerHTML='$str';parent.document.getElementById('img_list_1').setAttribute('target','');parent.document.getElementById('img_list_1').setAttribute('href','javascript:void(0);');parent.document.getElementById('img_list_a_1').style.display='none';</script>";
	echo '<script>alert("删除成功")</script>';
	header('refresh:0;url=/supplier_manage.php?module=index&act='.$act.'&SupplierId='.$SupplierId);
	exit;
}
if($_GET['act_r']=='del_one'){
	$ProId = $_GET['ProId'];
	$where = "ProId='$ProId'";
	$db->update('product', "ProId='$ProId'",array(
			'Del'	=>	'0',
		));
	/*$db->delete('product_ext', "ProId='$ProId'");
	$db->delete('product_description', "ProId='$ProId'");
	$db->delete('product_wholesale_price',"ProId='$ProId'");
	$db->delete('product', $where);*/
	//save_manage_log('删除产品');
	
	echo '<script>alert("删除成功")</script>';
	header('refresh:0;url=product.php?act='.$act.'&SupplierId='.$SupplierId);
	exit;
}
if($_POST['methods'] == 'Shop'){
	$act = $_POST['act'];
	$IsUse = '0';
    $Salesman_Name=$_POST['Salesman_Name'];
    $SupplierId = (int)$_POST['SupplierId'];
	$S_LogoPath = $_POST['S_LogoPath'];
	$S_LogoPath_1 = $_POST['S_LogoPath_1'];
    $MemberLevel = (int)$_POST['MemberLevel'];
    $IsUse = (int)$_POST['IsUse'];
    $Supplier_Name = trim($_POST['Supplier_Name']);
    $Supplier_Name2 = trim($_POST['Supplier_Name2']);
    $Supplier_Phone = trim($_POST['Supplier_Phone']);
    $Supplier_Mobile = trim($_POST['Supplier_Mobile']);
    $Supplier_Company_Address = trim($_POST['Supplier_Company_Address']);
    $Supplier_Pay_Number = trim($_POST['Supplier_Pay_Number']);
    $Supplier_Main_Products = trim($_POST['Supplier_Main_Products']);
    $Supplier_Email = $_POST['Supplier_Email'];
    $Supplier_Online_0 = $_POST['Supplier_Online_0'];
    $Supplier_Online_1 = $_POST['Supplier_Online_1'];
    $Supplier_Online_2 = $_POST['Supplier_Online_2'];
    $Supplier_Phone = $_POST['Supplier_Phone'];
    $Supplier_Address = $_POST['Supplier_Address'];
    $Supplier_Address_lang_1 = $_POST['Supplier_Address_lang_1'];
    $Supplier_CopyRight = $_POST['Supplier_CopyRight'];
    $Supplier_CopyRight_lang_1 = $_POST['Supplier_CopyRight_lang_1'];
    $Supplier_BriefDescription = $_POST['Supplier_BriefDescription'];
    $Supplier_BriefDescription_lang_1 = $_POST['Supplier_BriefDescription_lang_1'];

    $Supplier_SeoKeywords = $_POST['Supplier_SeoKeywords'];
    $Supplier_SeoDescription = $_POST['Supplier_SeoDescription'];
     $Supplier_BriefDescription_en = $_POST['Supplier_BriefDescription_en'];
    /*if($db->get_row_count('member', "MemberId!='$SupplierId' and Supplier_Name = '$Supplier_Name'", 'Supplier_Name')){
        echo '<script>alert("商户名称已存在");history.go(-1);</script>';
        exit;
    }*/

	$save_dir='/u_file/'.date('ym').'/'."supplier/{$SupplierId}/";
	include($site_root_path.'/inc/fun/img_resize.php');
	if($LogoPath=up_file($_FILES['LogoPath'], $save_dir)){

		$SmallLogoPath=img_resize($LogoPath, '', $width, $height);
	}else{
		$SmallLogoPath=$S_LogoPath;
	}

	if($LogoPath_1=up_file($_FILES['LogoPath_1'], $save_dir)){
		
		$SmallLogoPath_1=img_resize($LogoPath_1, '', $width, $height);
	}else{
		$SmallLogoPath_1=$S_LogoPath_1;
	}
    if($Business_License=up_file($_FILES['Business_License'], $save_dir)){
        $SmallBusiness_License=img_resize($Business_License, '', $width, $height);
    }else{
        $SmallBusiness_License=$_POST['S_Business_License'];
    }
    //var_dump($LogoPath);exit;
    $data = array(
    	'IsUse'	=>	$IsUse,
        'LogoPath' => $SmallLogoPath,
        'LogoPath_1' => $SmallLogoPath_1,
        'Business_License' => $SmallBusiness_License,
        'MemberLevel' => $MemberLevel,
        'Supplier_Name' => $Supplier_Name,
        'Supplier_Name2' => $Supplier_Name2,
        'Salesman_Name'  =>$Salesman_Name,
        'Supplier_Phone' => $Supplier_Phone,
        'Supplier_Mobile' => $Supplier_Mobile,
        'Supplier_Company_Address' => $Supplier_Company_Address,
        'Supplier_Pay_Number' => $Supplier_Pay_Number,
        'Supplier_Main_Products' => $Supplier_Main_Products,
        'Supplier_Email' => $Supplier_Email,
        'Supplier_Online_0' => $Supplier_Online_0,
        'Supplier_Online_1' => $Supplier_Online_1,
        'Supplier_Online_2' => $Supplier_Online_2,
        'Supplier_Phone' => $Supplier_Phone,
        'Supplier_Address' => $Supplier_Address,
        'Supplier_Address_lang_1' => $Supplier_Address_lang_1,
        'Supplier_CopyRight' => $Supplier_CopyRight,
        'Supplier_CopyRight_lang_1' => $Supplier_CopyRight_lang_1,
        'Supplier_BriefDescription' => $Supplier_BriefDescription,
        'Supplier_BriefDescription_lang_1' => $Supplier_BriefDescription_lang_1,
        
        'Supplier_SeoTitle' => $Supplier_SeoTitle,
        'Supplier_SeoKeywords' => $Supplier_SeoKeywords,
        'Supplier_SeoDescription' => $Supplier_SeoDescription,
        'Supplier_BriefDescription_en' => $Supplier_BriefDescription_en,
    );
    if($IsUse){
        $data['IsUse'] = $IsUse;
        Supplier_Init($SupplierId);//function.php
    }
    $db->update('member',"MemberId='$SupplierId'",$data);
    if($Salesman_Name){
         $db->update('member',"Salesman_Name='$Salesman_Name'",$data);
    }
	//----------------------------------------------------------------------------------------------------------------------------------------------------------
	
	// save_manage_log('系统全局设置');
	header('Location: /supplier_manage.php?module=index&act='.$act);
	exit;
}

$member_row = $db->get_one("member","MemberId='$SupplierId'");

$ad_row = $db->get_all("ad","SupplierId='$SupplierId'");
?>
<?php
	echo '<link rel="stylesheet" href="/css/supplier_m/index'.$lang.'.css">'
?>

<?php if($_GET['act'] == '1'){?>
<form action="/supplier_manage.php" method="post" enctype="multipart/form-data">
<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['header'.$lang]['mjzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/supplier_manage.php?module=index&act=1" class='s2'><?=$website_language['supplier_m_index'.$lang]['dpgl']?></a>						
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=index&act=2" class='s1'><?=$website_language['supplier_m_index'.$lang]['gggl']?></a>			
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=product&act=3" class='s1'><?=$website_language['supplier_m_index'.$lang]['cpgl']?></a>			
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=order&act=4" class='s1'><?=$website_language['supplier_m_index'.$lang]['ddgl']?></a>		
		</li>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['supplier_m_index'.$lang]['dpgl']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh"> 
			<div style="color:#303030;font-size:14px;font-weight:bold;text-indent:25px;line-height:50px"><?=$website_language['supplier_m_index'.$lang]['shxx']?></div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['shmc']?>：</span><input class="y_title_txt ac" type="text" name="Supplier_Name" value="<?=$member_row['Supplier_Name']?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['lxdz']?>：</span><input class="y_title_txt ac" type="text" name="Supplier_Address_lang_1" value="<?=$member_row['Supplier_Address_lang_1']?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['lxsk']?>：</span><input class="y_title_txt" type="text" name="Supplier_Online_0" value="<?=$member_row['Supplier_Online_0']?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['lxqq']?>：</span><input class="y_title_txt" type="text" name="Supplier_Online_1" value="<?=$member_row['Supplier_Online_1']?>">
			</div>	
			<div class="y_form2">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['sjlg']?>：</span>

				<input id="y1" onchange="preImg2(this.id,'photoOne');" type="file" name="LogoPath" value="<?=$member_row['LogoPath']?>">
				<input type="hidden" name="S_LogoPath" value="<?=$member_row['LogoPath']?>" />
				<span id='y2' class="file_span"><?=$website_language['supplier_m_index'.$lang]['sclg']?></span>
				<a href="<?=is_file($site_root_path.$member_row['LogoPath']) ? str_replace('s_','',$member_row['LogoPath']) : 'javascript:void(0);'?>" class="logo_con fl" id="img_list" <?=is_file($site_root_path.$member_row['LogoPath']) ? 'target="_blank"' : '';?> >
                	
                        
					<img name="del_img_iframe" src="<?=$member_row['LogoPath']?>" alt="" id='photoOne' class="file_span2">
				</a>
				<?php if($member_row['LogoPath']){
					//var_dump($member_row['LogoPath']);exit;
					?>
				<a href="/supplier_manage.php?module=index&action=delimg&LogoPath=<?=$member_row['LogoPath'];?>&ImgId=img_list&act=<?=$act?>&SupplierId=<?=$SupplierId?>" class="del fl"  id="img_list_a"></a>
				<?php }?>
			</div>
		<!-- 	<div class="y_form2">
				<span class="y_title">上传品牌：</span><input id="x1" onchange="preImg2(this.id,'photoTwo');" type="file" name="LogoPath_1" value="<?=$member_row['LogoPath_1']?>"><input type="hidden" name="S_LogoPath_1" value="<?=$member_row['LogoPath_1']?>" /><span id='x2' class="file_span">上传品牌</span>
				<a href="<?=is_file($site_root_path.$member_row['LogoPath_1']) ? str_replace('s_','',$member_row['LogoPath_1']) : 'javascript:void(0);'?>" class="logo_con fl" id="img_list_1" <?=is_file($site_root_path.$member_row['LogoPath_1']) ? 'target="_blank"' : '';?> >
				<img name="del_img_iframe_1" src="<?=$member_row['LogoPath_1']?>" alt="" id='photoTwo' class="file_span2">
				</a>
				<a href="index.php?action=delimg1&LogoPath=<?=$member_row['LogoPath_1'];?>&ImgId=img_list&act=<?=$act?>&SupplierId=<?=$SupplierId?>" class="del fl"  id="img_list_a_1"></a>
			</div> -->
			<div class="clear"></div>
			<div style="color:#303030;font-size:14px;font-weight:bold;text-indent:25px;line-height:50px"><?=$website_language['supplier_m_index'.$lang]['gsxx']?></div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['gsmc']?>：</span><input class="y_title_txt ac" type="text" name="Supplier_Name" value="<?=$member_row['Supplier_Name']?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['zycp']?>：</span><input class="y_title_txt ac" type="text" name="Supplier_Main_Products" value="<?=$member_row['Supplier_Main_Products']?>">
			</div>
			<div class="y_form2">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['yyzz']?>：</span><input id="z1" onchange="preImg2(this.id,'photoThree');" type="file" name="Business_License" value="<?=$member_row['Business_License']?>"><span id='z2' class="file_span"><?=$website_language['supplier_m_index'.$lang]['scwj']?></span>
				<a href="<?=is_file($site_root_path.$member_row['Business_License']) ? str_replace('s_','',$member_row['Business_License']) : 'javascript:void(0);'?>" class="logo_con fl" id="img_list_1" <?=is_file($site_root_path.$member_row['Business_License']) ? 'target="_blank"' : '';?> >
				<img name="del_img_iframe" src="<?=$member_row['Business_License']?>" alt="" id='photoThree' class="file_span2">
				</a>
				<input type="hidden" name="S_Business_License" value="<?=$member_row['Business_License']?>" />
			</div>
			<div class="clear"></div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['gddh']?>：</span><input class="y_title_txt" type="text" name="Supplier_Phone" value="<?=$member_row['Supplier_Phone']?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['sjhm']?>：</span><input class="y_title_txt ac" type="text" name="Supplier_Mobile" value="<?=$member_row['Supplier_Mobile']?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['skzh']?>：</span><input class="y_title_txt ac" type="text" name="Supplier_Pay_Number" value="<?=$member_row['Supplier_Pay_Number']?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['bgdz']?>：</span><input class="y_title_txt ac" type="text" name="Supplier_Company_Address" value="<?=$member_row['Supplier_Company_Address']?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_index'.$lang]['bq']?>：</span><input class="y_title_txt" type="text" name="Supplier_CopyRight" value="<?=$member_row['Supplier_CopyRight']?>">
			</div>
			<div class="he_mask">
            	<span class="span_title1"><?=$website_language['supplier_m_index'.$lang]['gsjj']?>(<?=$website_language['ylfy'.$lang]['zw']?>)：</span><textarea class="tx" name="Supplier_BriefDescription_lang_1" type="text"><?=$member_row['Supplier_BriefDescription_lang_1']?></textarea>
       		</div>
       		<div class="he_mask">
            	<span class="span_title1"><?=$website_language['supplier_m_index'.$lang]['gsjj']?>(<?=$website_language['ylfy'.$lang]['xw']?>)：</span><textarea class="tx" name="Supplier_BriefDescription" type="text"><?=$member_row['Supplier_BriefDescription']?></textarea>
       		</div>
       		<div class="he_mask">
            	<span class="span_title1"><?=$website_language['supplier_m_index'.$lang]['gsjj']?>(<?=$website_language['ylfy'.$lang]['yw']?>)：</span><textarea class="tx" name="Supplier_BriefDescription_en" type="text"><?=$member_row['Supplier_BriefDescription_en']?></textarea>
       		</div>
	   		<div class="y_submit">
	   			<input type="hidden" name="methods" value="Shop">
	   			<input type="hidden" name="act" value="1">	
	   			<input type="hidden" name="module" value="index">
	   			<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">      
		        <input class="ys_input psa" type="submit" value="<?=$website_language['supplier_m_index'.$lang]['bc']?>">
		    </div>
		</div>
</div>
</div>
</div>
</form>
<script src='/js/none.js'></script>
<script>
	function getFileUrl(sourceId) {  
                var url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));    
                return url;  
            }  
            function preImg(sourceId, targetId,id){   
                var url = getFileUrl(sourceId);   
                var imgPre = document.getElementById(targetId);  
                document.getElementById(id).value=document.getElementById(sourceId).value; 
                imgPre.src = url;   
            }  
            function preImg2(sourceId, targetId){   
                var url = getFileUrl(sourceId);   
                var imgPre = document.getElementById(targetId);
                imgPre.src = url;                       
            } 
    function del(targetId){
    	 var imgPre = document.getElementById(targetId);
    	 imgPre.src='';  
    }		
	$('#y2').click(function(){
		$('#y1').click();
	})
	$('#x2').click(function(){
		$('#x1').click();
	})
	$('#z2').click(function(){
		$('#z1').click();
	})
</script>
<?php }elseif($_GET['act'] == '2'){?>
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
			<div class="yhh_t">
				<div class="yhh_t_1" style=''><?=$website_language['supplier_m_index'.$lang]['xh']?></div>
			<!-- 	<div class="yhh_t_2" style=''><?=$website_language['supplier_m_index'.$lang]['bt']?></div> -->
				<div class="yhh_t_3" style=''><?=$website_language['supplier_m_index'.$lang]['ggwz']?></div>
				<div class="yhh_t_4" style=''><?=$website_language['supplier_m_index'.$lang]['cjsj']?></div>
				<div class="yhh_t_5" style=''><?=$website_language['supplier_m_index'.$lang]['cz']?></div>
			</div>
			<?php 
				for ($i=0; $i < count($ad_row); $i++) { 
					$explode_ad = explode('/',$ad_row[$i]['AdPosition']);
					if($lang == '_lang_1'){
						$AdPosition = $explode_ad[0];
					}elseif($lang == ''){
						$AdPosition = $explode_ad[1];
					}elseif($lang == '_en'){
						$AdPosition = $explode_ad[2];
					}
			?>
			<div class="yhh_t1">
				<div class="yhh_t_1"><?=$i+1?></div>
				<!-- <div class="yhh_t_2"><?=$ad_row[$i]['PageName']?></div> -->
				<div class="yhh_t_3_es"><?=$AdPosition?></div>
				<div class="yhh_t_4"><?=date("Y-m-d H:i:s", $ad_row[$i]['AdTime']);?></div>
				<div class="operation yhh_t_5">
					<a href="/supplier_manage.php?module=ad_mod&AId=<?=$ad_row[$i]['AId']?>"><?=$website_language['supplier_m_index'.$lang]['xg']?></a>
                    <a href="/supplier_manage.php?module=index&act=6&AId=<?=$ad_row[$i]['AId']?>"><?=$website_language['supplier_m_index'.$lang]['ck']?></a>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
	</div>
</div>
<?php }elseif($_GET['act'] == '3'){?>


<?php }elseif($_GET['act'] == '5'){?>
	
<?php }elseif($_GET['act'] == '6'){?>

<?php 
$AId=(int)$_GET['AId'];
$ad_row=$db->get_one('ad', "AId='$AId'");
?>
<link rel="stylesheet" href="/css/supplier_m/ad_mod.css">
<form method="" action=""  enctype="multipart/form-data">
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
            <div class="y_form" style="position:relative;"><input class="<?=$i+1?>" type="button" style="width:100px;height:33px;background:#0b8fff;border-radius:3px;border:none;position:absolute;left:155px;color:#fff" value="<?=$website_language['supplier_m_index'.$lang]['sctp']?>"><span class="y_title"><?=$i+1?>:</span><input id="<?=$ad_path_3[$i]?>" type="text" style="width:210px;height:33px;background:#fff;border-radius:3px;border:1px solid #ccc;position:absolute;left:255px;color:#000" value=""><input id="<?=$ad_path[$i]?>" onchange="preImg(this.id,'photo<?=$ad_path[$i]?>','<?=$ad_path_3[$i]?>');" class="y_title_txt a<?=$i+1?>" value="上传图片" type="file" name="PicPath_<?=$i?>" ><input type="hidden" name="S_PicPath_<?=$i;?>" value="<?=$ad_row['PicPath_'.$i];?>" /></div>    
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
	        
		</div>
		</div>
	</div>
</div>
</div>
</form>
<?php }?>
<script>
	$('.y').click(function(){
			$('.title1').text(''+$(this).find('.s1').text()+'');
			$('.title2').text('');
			$('.title3').text('');
		})
</script>
