<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'supplier_manage';
$v = check_permit('supplier_manage');

$SupplierId = (int)$_GET['SupplierId'];
$width = 360;
$height = 140;
if($_GET['action']=='delimg'){ //删除商户Logo
    $LogoPath=$_GET['LogoPath'];
    
    del_file($LogoPath);
    del_file(str_replace('s_', '', $LogoPath));
    
    $str=js_contents_code('No Logo');
    echo "<script language=javascript>parent.document.getElementById('img_list').innerHTML='$str';parent.document.getElementById('img_list').setAttribute('target','');parent.document.getElementById('img_list').setAttribute('href','javascript:void(0);');parent.document.getElementById('img_list_a').style.display='none';</script>";
    exit;
}
if($_POST){
    $Salesman_Name=$_POST['Salesman_Name'];
    $SupplierId = (int)$_POST['SupplierId'];
    $S_LogoPath = $_POST['S_LogoPath'];
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
    $LegalName = $_POST['LegalName'];
    
    if($db->get_row_count('member', "MemberId!='$SupplierId' and Supplier_Name = '$Supplier_Name'", 'Supplier_Name')){
        echo '<script>alert("商户名称已存在");history.go(-1);</script>';
        exit;
    }
    $save_dir=get_cfg('ly200.up_file_base_dir')."supplier/{$SupplierId}/";
    
    if($LogoPath=up_file($_FILES['LogoPath'], $save_dir)){
        include('../../inc/fun/img_resize.php');
        $SmallLogoPath=img_resize($LogoPath, '', $width, $height);
    }else{
        $SmallLogoPath=$S_LogoPath;
    }
    if($Business_License=up_file($_FILES['Business_License'], $save_dir)){
        include('../../inc/fun/img_resize.php');
        $SmallBusiness_License=img_resize($Business_License, '', $width, $height);
    }else{
        $SmallBusiness_License=$_POST['S_Business_License'];
    }
    $data = array(
        'IsUse' =>  $IsUse,
        'LogoPath' => $SmallLogoPath,
        'MemberLevel' => $MemberLevel,
        
       
        'Supplier_Name' => $Supplier_Name,
        'Supplier_Name2' => $Supplier_Name2,
        'Salesman_Name'  =>$Salesman_Name,
        'Supplier_Phone' => $Supplier_Phone,
        'Supplier_Mobile' => $Supplier_Mobile,
        'Business_License' => $SmallBusiness_License,
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
        'LegalName'               => $LegalName,
        'Del'   =>  '1',
    );
    if($IsUse){
        $time = time();
        if($db->get_all("ad","SupplierId='$SupplierId'")){
            
        }else{

            Supplier_Init($SupplierId);//function.php
            $db->update('ad',"SupplierId='$SupplierId'",array(
                'AdTime'    =>  $time,
            ));
            $db->update('ad',"SupplierId='$SupplierId'",array(
                    'AdTime'    =>  $time,
                ));
        }
        
    }
    $db->update('member',"MemberId='$SupplierId'",$data);
    if($Salesman_Name){
         $db->update('member',"Salesman_Name='$Salesman_Name'",$data);
    }
    //----------------------------------------------------------------------------------------------------------------------------------------------------------
    
    // save_manage_log('系统全局设置');
    header('Location: supplier_add.php?SupplierId='.$SupplierId);
    exit;
}

$supplier_row = $db->get_one('member',"MemberId='$SupplierId'");
    include('../../inc/manage/header.php');
?>

<form style="background:#fff;min-height:600px;width:95%;overflow:hidden" method="post" action="supplier_add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">修改商家</div>
    <div class="y_form"><span class="y_title">商户名称：</span><input class="y_title_txt" type="text" name="Supplier_Name" value="<?=htmlspecialchars($supplier_row['Supplier_Name']);?>"></div>
    <div class="y_form"><span class="y_title">商家类型：</span>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="Is_Business_License" id="" <?=$supplier_row['Is_Business_License'] == '1' ? checked : '';?>><span class='input_s'>普通</span></a>
        <?php 
        ?>
        <a class="y_input"><input class="input_r" type="radio" value="0" name="Is_Business_License" id="" <?=$supplier_row['Is_Business_License'] == '0'? checked : '';?>><span class='input_s'>Eagle Home</span></a>
    </div>
    <div class="y_form1">
        <span style="float:left" class="y_title">商家Logo：</span>            
        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
        <div style="margin-left:6px" class="operation fl">
            <input id='1' onchange="preImg2(this.id,'photoOne');" name="LogoPath" type="file" value="<?=htmlspecialchars($supplier_row['LogoPath']);?>" class="form_file fl">
            <input type="hidden" name="S_LogoPath" value="<?=$supplier_row['LogoPath']?>" />
        </div>
        <?php 

            if($supplier_row['LogoPath']){
        ?>
            <a href="<?=is_file($site_root_path.$supplier_row['LogoPath']) ? str_replace('s_','',$supplier_row['LogoPath']) : 'javascript:void(0);'?>" class="logo_con fl" id="img_list" <?=is_file($site_root_path.$supplier_row['LogoPath']) ? 'target="_blank"' : '';?> class="logo_con fl" id="img_list" target="_blank" style="width:300px;height:200px;border:1px solid #ccc;margin-left:20px;margin-top:5px">
                <img id='photoOne' style="max-width:300px;max-height:200px;" src="<?=$supplier_row['LogoPath']?>">
            </a>            
            <a class="del fl" style="margin-top:170px" target="del_img_iframe" id="img_list_a" href="supplier_add.php?action=delimg&LogoPath=<?=$supplier_row['LogoPath'];?>&ImgId=img_list"></a>
        <?php }else{?>
            <a href="" class="logo_con fl" id="img_list" target="_blank" style="width:300px;height:200px;border:1px solid #ccc;margin-left:20px;margin-top:5px">
                <img style="max-width:300px;max-height:200px;" id='photoOne' src=''>
            </a>
        <?php }?>

    </div>
    <div class="y_form"><span class="y_title">公司名称：</span><input class="y_title_txt" type="text" name="Supplier_Name2" value="<?=$supplier_row['Supplier_Name'];?>"></div>
    <div class="y_form"><span class="y_title">商家等级：</span>
        <?php 
            $member_level_row = $db->get_all('member_level',"IsSupplier=1");
            for ($i=0; $i < count($member_level_row); $i++) { 
        ?>
        <a class="y_input"><input class="input_r" type="radio" value="<?=$member_level_row[$i]['LId']?>" name="MemberLevel" id="" <?=$supplier_row['MemberLevel'] == $member_level_row[$i]['LId'] ? checked :'';?>><span class='input_s'><?=$member_level_row[$i]['Level']?></span></a>

        <?php }?>     
    </div>
    <div class="y_form"><span class="y_title">联系邮箱：</span><input class="y_title_txt" type="text" name="Supplier_Email" value="<?=htmlspecialchars($supplier_row['Supplier_Email']);?>"></div>
    <div class="y_form"><span class="y_title">审核状态：</span>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="IsUse" id="" <?=$supplier_row['IsUse']==1 ? 'checked' : ''; ?>><span class='input_s' >审核中</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="2" name="IsUse" id="" <?=$supplier_row['IsUse']==2 ? 'checked' : ''; ?>><span class='input_s' >已通过</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="0" name="IsUse" id="" <?=$supplier_row['IsUse']==0 ? 'checked' : ''; ?>><span class='input_s' >未通过</span></a>
    </div>
    <div class="y_form"><span class="y_title">联系Skype：</span><input class="y_title_txt" type="text" name="Supplier_Online_0" value="<?=htmlspecialchars($supplier_row['Supplier_Online_0']);?>"></div>
    <div class="y_form"><span class="y_title">联系QQ：</span><input class="y_title_txt" type="text" name="Supplier_Online_1" value="<?=htmlspecialchars($supplier_row['Supplier_Online_1']);?>"></div>
    <div class="y_form1" style="min-height: 170px;">
        <span style="float:left" class="y_title">营业执照：</span>            
        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
        <div style="margin-left:6px" class="operation fl">
            <input id='2' onchange="preImg2(this.id,'photoTwo');" name="Business_License" type="file" value="<?=htmlspecialchars($supplier_row['Business_License']);?>" class="form_file fl">
        </div>
        <?php 

            if($supplier_row['Business_License']){
        ?>
            <a href="<?=is_file($site_root_path.$supplier_row['Business_License']) ? str_replace('s_','',$supplier_row['Business_License']) : 'javascript:void(0);'?>" class="logo_con fl" id="img_list" <?=is_file($site_root_path.$supplier_row['Business_License']) ? 'target="_blank"' : '';?> class="logo_con fl" id="img_list" target="_blank" style="width:300px;height:200px;border:1px solid #ccc;margin-left:20px;margin-top:5px">
                <img style="max-width:230px;max-height:280px;" id='photoTwo' src='<?=$supplier_row['Business_License'];?>'>
            </a>          
            <a class="del fl" style="margin-top:170px" target="del_img_iframe" id="img_list_a" href="shipping_add.php?action=delimg&WebLogo=<?=$mCfg['WebLogo'];?>&ImgId=img_list"></a>
        <?php }else{?>
            <a href="" class="logo_con fl" id="img_list" target="_blank" style="width:300px;height:200px;border:1px solid #ccc;margin-left:20px;margin-top:5px">
                <img style="max-width:230px;max-height:280px;" id='photoTwo' src=''>
            </a>          
            <a class="del fl" style="margin-top:170px" target="del_img_iframe" id="img_list_a" href="shipping_add.php?action=delimg&WebLogo=<?=$mCfg['WebLogo'];?>&ImgId=img_list"></a>
        <?php }?>
    </div>
    <div class="y_form"><span class="y_title">法人代表：</span><input class="y_title_txt" type="text" name="LegalName" value="<?=htmlspecialchars($supplier_row['LegalName']);?>"></div>
    <div class="y_form"><span class="y_title">固定电话：</span><input class="y_title_txt" type="text" name="Supplier_Phone" value="<?=htmlspecialchars($supplier_row['LegalName']);?>"></div>
    <div class="y_form"><span class="y_title">手机号码：</span><input class="y_title_txt" type="text" name="Supplier_Mobile" value="<?=htmlspecialchars($supplier_row['Supplier_Mobile']);?>"></div>
    <div class="y_form"><span class="y_title">办公地址：</span><input class="y_title_txt" type="text" name="Supplier_Company_Address" value="<?=htmlspecialchars($supplier_row['Supplier_Company_Address']);?>"></div>
    <div class="y_form"><span class="y_title">收款账号：</span><input class="y_title_txt" type="text" name="Supplier_Pay_Number" value="<?=htmlspecialchars($supplier_row['Supplier_Pay_Number']);?>"></div>
    <div class="y_form"><span class="y_title">主营产品：</span>
        <input class="y_title_txt" type="text" name="Supplier_Main_Products" value="<?=htmlspecialchars($supplier_row['Supplier_Main_Products']);?>">
    </div>
    <div style="width:100%;margin-top:20px;float:left;position:relative">
        <span style="position:absolute;top:0px" class="y_title">公司简介：</span><textarea name="Supplier_BriefDescription<?=lang_name($i, 1);?>" style="width:750px;height:120px;border:1px solid #ccc;border-radius:3px;margin-left:105px" type="text"><?=htmlspecialchars($supplier_row['Supplier_BriefDescription'.lang_name($i, 1)]);?></textarea>
    </div>
    <div class="y_submit">
        <input type="hidden" name="SupplierId" value="<?=$SupplierId; ?>" />
        <input class="ys_input" type="submit" value="保存">
    </div>     
</form>
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
            function preImg2(sourceId, targetId) {   
                var url = getFileUrl(sourceId);   
                var imgPre = document.getElementById(targetId);
                imgPre.src = url;                       
            } 
</script>
<?php include('../../inc/manage/footer.php');?>