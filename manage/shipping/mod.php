<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='shipping';
check_permit('shipping', 'shipping.add');
$UserId = $_SESSION['ly200_AdminUserId'];
if($UserId == '1'){
    $SalesmanName = "超级管理员";
}else{
    $SalesmanName = $_SESSION['ly200_AdminSalesmanName'];
}
$SId = $_GET['SId'];

if($_POST){
    $SId = $_POST['SId'];
    $FirmName = $_POST['firmname'];
    $Express = $_POST['Express'];
    $DelName = $_POST['delegate'];
    $Mobile = $_POST['mobile'];
    $Add = $_POST['add'];
    $TextCenter = $_POST['textcenter'];
    $shippingcharges = $_POST['shippingcharges'];
    $CustomsClearance = $_POST['CustomsClearance'];

    if($_FILES){
        if($_FILES['PicPath']['size'] > 3100000){
            echo '<script>alert("'.$_FILES['PicPath']['name'].'图片大于3M,请重新上传该图片!")</script>';
            header("refresh:0;url=mod.php?SId=".$SId);
            exit;
        }
        $PicPath_r =$db->get_one('shipping',"SId='$SId'","PicPath");
        if($PicPath_r){
            del_file($PicPath_r);
        }
        $tmpname = $_FILES['PicPath']['tmp_name'];
        $pathname = $_FILES['PicPath']['name'];
        $save_dir="../../".get_cfg('ly200.up_file_dir').'transport/';
        $PicPath = "/u_file/transport/".$pathname;
        if(move_uploaded_file($tmpname,$site_root_path.$PicPath)){
            echo '<script>alert("上传成功")</script>';
        }
        
    }

    $db->update('shipping',"SId='$SId'",array(
            'FirmName'          =>  $FirmName,
            'Express'           =>  $Express,
            'DelName'           =>  $DelName,
            'Mobile'            =>  $Mobile,
            'Address'           =>  $Add,
            'PicPath'           =>  $PicPath,
            'TextCenter'        =>  $TextCenter,
            'CreateName'        =>  $SalesmanName,
            'ShippingCharges'   =>  $shippingcharges,
            'CustomsClearance'  =>  $CustomsClearance,
            
        )
    );
    

    
    save_manage_log('修改快递方式:'.$Express);
    //var_dump($SId);exit;
    header('Location: mod.php?SId='.$SId);
    exit;
}
$shipping_row =$db->get_one('shipping',"SId='$SId'");
include('../../inc/manage/header.php');
?>
<form style="background:#fff;min-height:600px;width:95%" action="mod.php" method="post" class="act_form" enctype="multipart/form-data" on>
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">运输渠道添加</div>
     <div class="y_form"><span class="y_title">企业名称：</span><input class="y_title_txt" type="text" name="firmname" value="<?=$shipping_row['FirmName']?>"></div>
    <div class="y_form"><span class="y_title">运输类型：</span>
        <select class="y_title_txt" name="Express" >
            <option value="1" <?=$shipping_row['Express']== '1'? selected :'';?>>空运</option>
            <option value="2" <?=$shipping_row['Express']== '2'? selected :'';?>>海运</option>
        </select></div>
    <div class="y_form"><span class="y_title">法人代表：</span><input class="y_title_txt" type="text" name="delegate" value="<?=$shipping_row['DelName']?>"></div>
    <div class="y_form"><span class="y_title">手机号码：</span><input class="y_title_txt" type="text" name="mobile" value="<?=$shipping_row['Mobile']?>"></div>
    <div class="y_form"><span class="y_title">联系地址：</span><input class="y_title_txt" type="text" name="add" value="<?=$shipping_row['Address']?>"></div>
    <div class="y_form"><span class="y_title">重量标准：</span><input class="y_title_txt_sm2" type="text" name="shippingcharges" value="<?=$shipping_row['ShippingCharges'];?>"><span style="display:inline-block;float:right;margin-right:33px"> USD/KG</span></div>
    <div class="y_form"><span class="y_title">体积标准：</span><input class="y_title_txt_sm2" type="text" name="CustomsClearance" value="<?=$shipping_row['CustomsClearance'];?>"><span style="display:inline-block;float:right;margin-right:33px"> USD/m³</span></div>
    <div class="y_form4"><span class="y_title">企业Logo:</span></div>

    <div class="y_form1">
        <div class="y_form" style="position:relative;"><input class="1" type="button" style="width:75px;height:31px;background:#0b8fff;border-radius:3px;border:none;position:absolute;top:2px;left:105px;color:#fff" value="上传图片"><span class="y_title">1:</span><input id="one" onchange="preImg(this.id,'photoOne');" class="y_title_txt a1" value="上传图片" type="file" name="PicPath"></div>    
        <div class="y_form"></div>
    </div>
    <div style="width:100%;margin-top:20px;float:left;position:relative">
        <span style="position:absolute;top:0px" class="y_title">描述:</span><textarea style="width:750px;height:120px;border:1px solid #ccc;border-radius:3px;margin-left:105px" type="text" name="textcenter"><?=htmlspecialchars($shipping_row['TextCenter'])?></textarea>
    </div>
    <div class="y_submit">
        <input type="hidden" name="SId" value="<?=$SId?>">
        <input type="submit" value="保存" name="submit" class="ys_input">
    </div>
</form>
<?php include('../../inc/manage/footer.php');?>