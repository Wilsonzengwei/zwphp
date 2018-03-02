<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='admin';
check_permit('admin');
$GetUId = $_GET['UId'];
$where = "UId='$UId'";
$Ly200Cfg=$tmp_Ly200Cfg;
$menu=$tmp_menu;
$manage_menu=$tmp_manage_menu;

if($_POST){
    $UId = $_POST['UId'];
    $UserName = $_POST['UserName'];
    //$Password = password($_POST['Password']);
    $Name = $_POST['Name'];
    $Mobile = $_POST['Mobile'];
    $Email = $_POST['Email'];
    $Status = $_POST['Status'];
    $CreateTime = time();
    $Category = $_POST['Category'];
    $category_str = @implode(',',$Category);
    $username_r = $db->get_all('userinfo2',"AUId in($category_str)","AUersName");
    foreach ($username_r as $key => $value) {
        foreach ($value as $key1 => $value1) {
            $arr[] = $value1;
        }
    }
    $ACharater = @implode(',',$arr);
    if($db->get_row_count('admin_info', "UId!='$UId' and UserName='$UserName' and Del=1","UserName")){
        echo '<script>alert("用户名已存在");history.go(-1);</script>';
        exit;
    }
    $db->update('admin_info',"UId='$UId'",array(
        'UserName'  =>  $UserName,
        'Name'      =>  $Name,
        'Mobile'    =>  $Mobile,
        'Email'     =>  $Email,
        'Status'    =>  $Status,
        'CreateTime'=>  $CreateTime,
        'AUersName' =>  $category_str,
        'ACharater' =>  $ACharater
        ));

    
    save_manage_log('修改后台管理员：'.$UserName);
    header('Location: index.php');
    exit;
}
$admin_info = $db->get_one('admin_info',"UId='$GetUId'");
$admin_info_cate = $db->get_all('admin_info_cate',"UId='$GetUId'","category");

/*
foreach((array)$admin_info_cate as $k => $v){
    foreach((array)$v as $k1 => $v1){
        $admin_arr[] = $v1;
    }

}
*/
include('../../inc/manage/header.php');
?>
<style>
    .y{
        height:350px;
        background:#fff;
    }
    .y_form{
        width:450px;float:left;margin-top:20px
    }
    .y_check{
        width:100%;
        float:left;
        margin-top:20px;
    }
    .yc_title{
        display:inline-block;width:100px;text-align:right;font-size:12px;color:#666;font-weight:bold;
    }
    .y_title{
        display:inline-block;width:100px;text-align:right;font-size:12px;color:#666;font-weight:bold;
    }
    .y_title_txt{
        width:300px;height:29px;border-radius:3px;border:1px solid #ccc;color:#aaa;
    }
    .y_input{
        font-size:12px;color:#666;margin-left:10px;
    }
    .y_submit{
        width:100%;
        float:left;
        margin-top:20px;
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
    .input_s{
        margin-left:7px
    }
</style>
<div class="div_con">
    <?php include('admin_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" onsubmit="return checkForm(this);">

        <div class="table">
            <div class="table_bg"></div>
            <div class="y">
                <div class="y_form"><span class="y_title">用户名：</span><input class="y_title_txt" type="text" name="UserName" value="<?=$admin_info['UserName']?>"></div>
                <div class="y_form"><span class="y_title">手机号：</span><input class="y_title_txt" type="text" name="Mobile" value="<?=$admin_info['Mobile']?>"></div>
                <div class="y_form"><span class="y_title">姓名：</span><input class="y_title_txt" type="text" name="Name" value="<?=$admin_info['Name']?>"></div>
                <div class="y_form"><span class="y_title">电子邮箱：</span><input class="y_title_txt" type="text" name="Email" value="<?=$admin_info['Email']?>"></div>
               <!--  <div class="y_form"><span class="y_title">密码：</span><input class="y_title_txt" type="password" name="" value=""></div> -->
                <div class="y_check"><span class="yc_title">状态：</span>
                    <a class="y_input"><input class="input_r" type="radio" value="1" name="Status" id="" <?=$admin_info['Status']==1 ? checked :''?>><span class='input_s'>启用</span></a>
                    <a class="y_input"><input class="input_r" type="radio" value="0" name="Status" id="" <?=$admin_info['Status']==0 ? checked :''?>><span class='input_s'>禁用</span></a>
                </div>
                <div class="y_check"><span class="yc_title">管理员：</span>
                    <?php 
                        $userinfo2_row = $db->get_all('userinfo2','AUId>1');
                            for ($i=0; $i < count($userinfo2_row); $i++) { 
                              $AUersName_r=explode(',',$admin_info['AUersName']);
                              //var_dump($AUersName_r);exit;
                              $ar = $userinfo2_row[$i]['AUId'];
                              if($ar != 9){
                    ?>

                    <span class="y_input"><input type="checkbox" value="<?=$userinfo2_row[$i]['AUId']?>" name="Category[]" id="" <?=in_array( $ar,$AUersName_r) ? checked :''?>>&nbsp;<?=$userinfo2_row[$i]['AUersName']?></span>
                    <?php }}?>
                    <!-- <span class="y_input"><input type="checkbox" value="2" name="Category[]" id="" <?=in_array("2",$admin_info['AUersName']) ? checked :''?>>&nbsp;业务员</span>
                    <span class="y_input"><input type="checkbox" value="3" name="Category[]" id="" <?=in_array("3",$admin_info['AUersName']) ? checked :''?>>&nbsp;客服</span>
                    <span class="y_input"><input type="checkbox" value="4" name="Category[]" id="" <?=in_array("4",$admin_info['AUersName']) ? checked :''?>>&nbsp;海外客服</span> -->
                </div>
                <div class="y_submit">
                    <input type="hidden" name="UId" value="<?=$GetUId?>">
                    <input class="ys_input" type="submit" value="保存">
                </div>
            </div>
           
           
            <div class="clear"></div>
        </div>
    </form>
</div>
<script language="javascript">change_admin_group(2);</script>
<?php include('../../inc/manage/footer.php');?>