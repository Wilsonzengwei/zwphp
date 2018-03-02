<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='admin';
check_permit('admin');

$Ly200Cfg=$tmp_Ly200Cfg;
$menu=$tmp_menu;
$manage_menu=$tmp_manage_menu;

if($_POST){
	$UserName = $_POST['UserName'];
	$Password = password($_POST['Password']);
	$Name = $_POST['Name'];
	$Mobile = $_POST['Mobile'];
	$Email = $_POST['Email'];
	$Status = $_POST['Status'];
	$UserNameDb = $db->get_all('admin_info','UserName');
	$CreateTime = time();
    $Category = $_POST['Category'];
    $category_str = implode(',',$Category);
    $username_r = $db->get_all('userinfo2',"AUId in($category_str)","AUersName");
    foreach ($username_r as $key => $value) {
        foreach ($value as $key1 => $value1) {
            $arr[] = $value1;
        }
    }
    $ACharater = @implode(',',$arr);
	if($db->get_row_count('admin_info', "UserName='$UserName' and Del=1")){
        echo '<script>alert("用户名已存在");history.go(-1);</script>';
        exit;
    }
	$db->insert('admin_info',array(
		'UserName'	=>	$UserName,
		'Password'	=>	$Password,
		'Name'		=>	$Name,
		'Mobile'	=>	$Mobile,
		'Email'		=>	$Email,
		'Status'	=>	$Status,
		'CreateTime'=>	$CreateTime,
        'AUersName' =>  $category_str,
        'ACharater' =>  $ACharater,
        'Del'       =>  '1',
		));
	$UId=$db->get_insert_id();
	for($i=0; $i<count($_POST['Category']); $i++){
		$category=(int)$_POST['Category'][$i];
		$db->insert('admin_info_cate', array(
				'category'	=>	$category,
				'UId'		=>	$UId
			)
		);
	}
	save_manage_log('添加后台管理员：'.$UserName);
	header('Location: index.php');
	exit;
}
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
    <form method="post" name="act_form" id="act_form" class="act_form" action="add.php" onsubmit="return checkForm(this);">

        <div class="table">
            <div class="table_bg"></div>
            <div class="y">
            	<div class="y_form"><span class="y_title">用户名：</span><input class="y_title_txt" type="text" name="UserName"></div>
                <div class="y_form"><span class="y_title">手机号：</span><input class="y_title_txt" type="text" name="Mobile"></div>
                <div class="y_form"><span class="y_title">姓名：</span><input class="y_title_txt" type="text" name="Name"></div>
                <div class="y_form"><span class="y_title">电子邮箱：</span><input class="y_title_txt" type="text" name="Email"></div>
                <div class="y_form" style="display: none;"><span class="y_title">密码：</span><input class="y_title_txt" type="text" name="Password" value="12345678" ></div>
                <div class="y_check"><span class="yc_title">状态：</span>
					<a class="y_input"><input class="input_r" type="radio" value="1" name="Status" checked><span class='input_s'>启用</span></a>
					<a class="y_input"><input class="input_r" type="radio" value="0" name="Status" id=""><span class='input_s'>禁用</span></a>
                </div>
                <div class="y_check"><span class="yc_title">管理员：</span>
                    <?php 
                    $userinfo2_row = $db->get_all('userinfo2','AUId>1');
                        for ($i=0; $i < count($userinfo2_row); $i++) { 
                          if($userinfo2_row[$i]['AUId'] == '24'){
                            $checked = "checked";
                           // var_dump($checked);exit;
                          }else{
                            $checked = '';
                          }
                          if($userinfo2_row[$i]['AUId'] != 9){
                    ?>
					<span class="y_input"><input type="checkbox" value="<?=$userinfo2_row[$i]['AUId']?>" name="Category[]" <?=$checked;?>>&nbsp;<?=$userinfo2_row[$i]['AUersName']?></span>
                    <?php }}?>
					
                </div>
                <div class="y_submit">
                	<input class="ys_input" type="submit" value="保存">
                </div>
            </div>
           
           
            <div class="clear"></div>
        </div>
    </form>
</div>
<script language="javascript">change_admin_group(2);</script>
<?php include('../../inc/manage/footer.php');?>