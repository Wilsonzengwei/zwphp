<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

/*
$_GET['data']值列表：
input or textarea, 表单名称（,字段类型），size，maxlength，数据表名，数据表唯一字段名，权限检查相关字，数据表唯一字段值
如：input|FirstPrice,float|5|10|shipping_price|PId|shipping|5
*/

$value=$_GET['value'];
$data=explode('|', $_GET['data']);
if(count($data)!=8){
	exit('fail');
}

if((int)$_SESSION['ly200_AdminGroupId']!=1){	//非超级管理员
	!substr_count($data[4], str_replace('.', '_', $data[6])) && exit('update_no_permit');
	(int)$menu[$data[6]]!=1 && exit('update_no_permit');
	(int)get_cfg($data[6].'.mod')!=1 && exit('update_no_permit');
}

$data[7]=(int)$data[7];
$field=explode(',', $data[1]);
$db->update($data[4], "{$data[5]}={$data[7]}", array(
		$field[0]	=>	$value
	)
);

echo $db->get_value($data[4], "{$data[5]}={$data[7]}", $field[0]);
?>