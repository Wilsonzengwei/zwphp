<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
include('../../inc/manage/header.php');
$UserId = $_SESSION['ly200_AdminUserId'];

if($_GET['action']=='delimg'){ //删除头像
    $LogoPath=$_GET['LogoPath'];
    
    del_file($LogoPath);
    del_file(str_replace('s_', '', $LogoPath));
    
    $str=js_contents_code('No Logo');
    echo "<script language=javascript>parent.document.getElementById('img_list').innerHTML='$str';parent.document.getElementById('img_list').setAttribute('target','');parent.document.getElementById('img_list').setAttribute('href','javascript:void(0);');parent.document.getElementById('img_list_a').style.display='none';</script>";
    exit;
}
if($_POST){
$UserName =$_POST['UserName'];
$Name =$_POST['Name'];
$Mobile =$_POST['Mobile'];
$Email =$_POST['Email'];
$Sex =$_POST['Sex'];
$S_LogoPath =$_POST['S_LogoPath'];
$width = 360;
$height = 360;
$save_dir=get_cfg('ly200.up_file_base_dir')."supplier/{$SupplierId}/";
if($LogoPath=up_file($_FILES['LogoPath'], $save_dir)){
    include('../../inc/fun/img_resize.php');
    $SmallLogoPath=img_resize($LogoPath, '', $width, $height);
}else{
    $SmallLogoPath=$S_LogoPath;
}

$db->update("admin_info","UId='$UserId'",array(
        
        'UserName'  =>$UserName,
        'Name'      =>$Name,
        'Mobile'    =>$Mobile,
        'Email'     =>$Email,
        'Sex'       =>$Sex,
        'LogoPath'  =>$SmallLogoPath,

    ));

}
$UserId_row = $db->get_one('admin_info',"UId='$UserId'");
?>
<form style="background:#fff;min-height:600px;width:95%" action="index.php" method="post" enctype="multipart/form-data">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">添加用户</div>
        <div class="table">
            <div class="table_bg"></div>
            <div class="y">
            	<div class="y_form"><span class="y_title">用户名：</span><input class="y_title_txt" type="text" name="UserName" value="<?=$UserId_row['UserName']?>"></div>
                <div class="y_form"><span class="y_title">手机号：</span><input class="y_title_txt" type="text" name="Mobile" value="<?=$UserId_row['Mobile']?>"></div>
                <div class="y_form"><span class="y_title">姓名：</span><input class="y_title_txt" type="text" name="Name" value="<?=$UserId_row['Name']?>"></div>
                <div class="y_form"><span class="y_title">电子邮箱：</span><input class="y_title_txt" type="text" name="Email" value="<?=$UserId_row['Email']?>"></div>
                <div class="y_form"><span class="yc_title">性别：</span>
					<a class="y_input"><input class="input_r" type="radio" value="1" name="Sex" id="" <?=$UserId_row['Sex'] == '1' ? checked : '';?>><span class='input_s'>男</span></a>
					<a class="y_input"><input class="input_r" type="radio" value="2" name="Sex" id="" <?=$UserId_row['Sex'] == '2' ? checked : '';?>><span class='input_s'>女</span></a>
                </div>
                <div class="y_form1">
                    <span style="float:left" class="y_title">头像：</span>            
                    <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                    <div style="margin-left:6px" class="operation fl">
                        <input id='1' onchange="preImg2(this.id,'photoOne');" name="LogoPath" type="file" value="<?=htmlspecialchars($UserId_row['LogoPath']);?>" class="form_file fl">
                        <input type="hidden" name="S_LogoPath" value="<?=$UserId_row['LogoPath']?>" />
                    </div>
                    <?php 

                        if($UserId_row['LogoPath']){
                    ?>
                        <a href="<?=is_file($site_root_path.$UserId_row['LogoPath']) ? str_replace('s_','',$UserId_row['LogoPath']) : 'javascript:void(0);'?>" class="logo_con fl" id="img_list" <?=is_file($site_root_path.$UserId_row['LogoPath']) ? 'target="_blank"' : '';?> class="logo_con fl" id="img_list" target="_blank" style="width:300px;height:200px;border:1px solid #ccc;margin-left:20px;margin-top:5px">
                            <img id='photoOne' style="max-width:300px;max-height:200px;" src="<?=$UserId_row['LogoPath']?>">
                        </a>            
                        <a class="del fl" style="margin-top:170px" target="del_img_iframe" id="img_list_a" href="index.php?action=delimg&LogoPath=<?=$UserId_row['LogoPath'];?>&ImgId=img_list"></a>
                    <?php }else{?>
                        <a href="" class="logo_con fl" id="img_list" target="_blank" style="width:300px;height:200px;border:1px solid #ccc;margin-left:20px;margin-top:5px">
                            <img style="max-width:300px;max-height:200px;" id='photoOne' src=''>
                        </a>  
                    <?php }?>

                </div>
                <div class="y_submit">
                	<input class="ys_input" type="submit" value="保存">
                </div>
            </div>        
           
            <div class="clear"></div>
        </div>
    </form>
</div>
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