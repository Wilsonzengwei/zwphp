<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='payment_method';
check_permit('payment_method', 'payment_method.mod');
$PId = $_GET['PId'];
if($_POST){
    $PId = $_POST['PId'];
    $FirmName = $_POST['FirmName'];
    $TransType = $_POST['TransType'];
    $DelName = $_POST['DelName'];
    $Mobile = $_POST['Mobile'];
    $Address = $_POST['Address'];
    $CollectNum1 = $_POST['CollectNum1'];
    $CollectNum2 = $_POST['CollectNum2'];
    $TextCenter = $_POST['TextCenter'];
    if($_FILES){
        if($_FILES['PicPath']['size'] > 3100000){
            echo '<script>alert("'.$_FILES['PicPath']['name'].'图片大于3M,请重新上传该图片!")</script>';
            header("refresh:0;url=add.php");
            exit;
        }
        $PicPath_r =$db->get_one('payment_method',"PId='$PId'","PicPath");
        if($PicPath_r){
            del_file($PicPath_r);
        }
        $tmpname = $_FILES['PicPath']['tmp_name'];
        $pathname = $_FILES['PicPath']['name'];
        $save_dir="../../".get_cfg('ly200.up_file_dir').'TransType/';
        $PicPath = "/u_file/transport/".$pathname;
        if(move_uploaded_file($tmpname,$site_root_path.$PicPath)){
            echo '<script>alert("上传成功")</script>';
        }
        
    }
    $db->update('payment_method',"PId='$PId'",array(
            'FirmName'      =>  $FirmName,
            'TransType'     =>  $TransType,
            'DelName'       =>  $DelName,
            'Mobile'        =>  $Mobile,
            'Address'       =>  $Address,
            'CollectNum1'   =>  $CollectNum1,
            'CollectNum2'   =>  $CollectNum2,
            'PicPath'       =>  $PicPath,
            'TextCenter'    =>  $TextCenter,
            'PTime'         =>  time()
            
        )
    );
    

    
    save_manage_log('添加付款方式:'.$Express);
    
    header('Location: index.php');
    exit;
}
$payment_method_row = $db->get_one('payment_method',"PId='$PId'");
include('../../inc/manage/header.php');
?>
<form style="background:#fff;min-height:600px;width:95%" action="add.php" method="post" class="act_form" enctype="multipart/form-data">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">付费方式添加</div>
    <div class="y_form"><span class="y_title">企业名称：</span><input class="y_title_txt" type="text" name="FirmName" value="<?=$payment_method_row['FirmName']?>"></div>
    <div class="y_form"><span class="y_title">付费类型：</span>
        <select class="y_title_txt" name="TransType" >
            <option value="1" <?=$payment_method_row['TransType'] == '1' ? selected : '';?>>线上</option>
            <option value="2" <?=$payment_method_row['TransType'] == '2' ? selected : '';?>>线下</option>
        </select></div>
    <div class="y_form"><span class="y_title">法人代表：</span><input class="y_title_txt" type="text" name="DelName" value="<?=$payment_method_row['DelName']?>"></div>
    <div class="y_form"><span class="y_title">手机号码：</span><input class="y_title_txt" type="text" name="Mobile" value="<?=$payment_method_row['Mobile']?>"></div>
    <div class="y_form"><span class="y_title">联系地址：</span><input class="y_title_txt" type="text" name="Address" value="<?=$payment_method_row['Address']?>"></div>
     <div class="y_form"><span class="y_title">收款账号1：</span><input class="y_title_txt" type="text" name="CollectNum1" value="<?=$payment_method_row['CollectNum1']?>"></div>
      <div class="y_form"><span class="y_title">收款账号2：</span><input class="y_title_txt" type="text" name="CollectNum2" value="<?=$payment_method_row['CollectNum2']?>"></div>
    <div class="y_form4"><span class="y_title">企业Logo:</span></div>
    <div class="y_form1">
        <div class="y_form" style="position:relative;"><input class="1" type="button" style="width:75px;height:31px;background:#0b8fff;border-radius:3px;border:none;position:absolute;top:2px;left:105px;color:#fff" value="上传图片"><span class="y_title">&nbsp;</span><input id="one" onchange="preImg(this.id,'photoOne');" class="y_title_txt a1" value="上传图片" type="file" name="PicPath"></div>    
        <div class="y_form"></div>
    </div>
    <div style="width:100%;margin-top:20px;float:left;position:relative">
        <span style="position:absolute;top:0px" class="y_title">描述:</span><textarea style="width:750px;height:120px;border:1px solid #ccc;border-radius:3px;margin-left:105px" type="text" name="TextCenter"><?=htmlspecialchars($payment_method_row['TextCenter'])?></textarea>
    </div>
    <div class="y_submit">
        <input type="hidden" name="PId" value="<?=$PId?>">
        <input type="submit" value="保存" name="submit" class="ys_input">
    </div>
</form>
<?php include('../../inc/manage/footer.php');?>