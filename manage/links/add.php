<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$UserId = $_SESSION['ly200_AdminUserId'];
$page_cur='links';
check_permit('links', 'links.add');
if($UserId == '1'){
    $SalesmanName = "超级管理员";
}else{
    $SalesmanName = $_SESSION['ly200_AdminSalesmanName'];
}
if($_POST){
	$Name=$_POST['Name'];
	$Url=$_POST['Url'];
	$Description=$_POST['Description'];
	$Time = time();

	$db->insert('links', array(
			'Name'		=>	$Name,
			'Url'		=>	$Url,
			'Description' 	=>  $Description,
			'AddTime'		=>	$Time,
			'AddName'		=>	$SalesmanName,
		)
	);
	
	save_manage_log('添加友情链接:'.$Name);
	
	header('Location: index.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<form style="background:#fff;min-height:600px;width:95%" action="" method="post" class="act_form" enctype="multipart/form-data">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">友情链接添加</div>
    <div class="y_form1"><span class="y_title">标题：</span><input class="y_title_txt" type="text" name="Name"></div> 
    <div class="y_form1"><span class="y_title">链接地址：</span><input class="y_title_txt" type="text" name="Url"></div> 
    <div class="y_form1"><span class="y_title">备注：</span><input class="y_title_txt" type="text" name="Description"></div> 
    <div class="y_submit">
        <input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="ys_input">
    </div>
</form>
<?php include('../../inc/manage/footer.php');?>