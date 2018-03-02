<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='member_level';
check_permit('member_level', 'member.level.add');
$LId = $_GET['LId'];
if($_POST){
    $LId=$_POST['LId'];
    $Level=$_POST['Level'];
    $LevelName=$_POST['LevelName'];
    $UpgradePriceS=(float)$_POST['UpgradePriceS'];
    $UpgradePriceE=(float)$_POST['UpgradePriceE'];
    $Discount=(float)$_POST['Discount'];
    $Remarks=$_POST['Remarks'];
    $db->update('member_level',"LId='$LId'",array(
        'Level'             =>  $Level,
        'LevelName'         =>  $LevelName,
        'UpgradePriceS'     =>  $UpgradePriceS,
        'UpgradePriceE'     =>  $UpgradePriceE,
        'Discount'          =>  $Discount,
        'AccTime'           =>  $service_time,
        'IsSupplier'        =>  '0',
        'Remarks'           =>  $Remarks,
        
    )
    );

    save_manage_log('添加会员级别:'.$Level);
    
    header('Location: level.php');
    exit;
}
$level_row = $db->get_one('member_level',"LId='$LId'");
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
        width:300px;height:29px;border-radius:3px;border:1px solid #ccc;color:#333;
    }
    .y_title_txt_sm{
        width:140px;height:29px;border-radius:3px;border:1px solid #ccc;color:#333;
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
<form style="background:#fff;min-height:600px;width:95%" action="level_mod.php" method="post">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px"><?=$a?></div>
     <div class="table">
            <div class="table_bg"></div>
            <div class="y">
                <div class="y_form"><span class="y_title">等级名称：</span><input class="y_title_txt" type="text" name="LevelName" value="<?=$level_row['LevelName']?>"></div>
                <div class="y_form"><span class="y_title">等级：</span><input class="y_title_txt" type="text" name="Level" value="<?=$level_row['Level']?>"></div>
                <div class="y_form"><span class="y_title">积分范围：</span><input class="y_title_txt_sm" type="text" name="UpgradePriceS" value="<?=$level_row['UpgradePriceS']?>"><span style="padding:0 5px;color:#707070">-</span><input name="UpgradePriceE" class="y_title_txt_sm" type="text" value="<?=$level_row['UpgradePriceE']?>"></div>
                <div class="y_form"><span class="y_title">购物折扣：</span><input class="y_title_txt" type="text" name="Discount" value="<?=$level_row['Discount']?>"></div>
                
                <div style="width:100%;margin-top:20px;float:left;position:relative">
                    <span style="position:absolute;top:0px" class="y_title">描述：</span><textarea style="width:750px;height:120px;border:1px solid #ccc;border-radius:3px;margin-left:100px" type="text" name="Remarks" ><?=$level_row['Remarks']?></textarea>
                </div>
                <div class="y_submit">
                    <input type="hidden" name="LId" value="<?=$LId?>">
                    <input class="ys_input" type="submit" value="保存">
                </div>
             </div>
    </div>
</form>
<?php include('../../inc/manage/footer.php');?>