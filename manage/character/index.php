<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'Character_admin';
check_permit('Character_admin');
if($_GET['act'] == 'del_character'){

	$AUId_d = $_GET['AUId'];
	$admin_info_row = $db->get_all('admin_info',"Del=1");
	for ($i=0; $i < count($admin_info_row); $i++) { 
		$AUersName = $admin_info_row[$i]['AUersName'];
		$arr_d[] = explode(',',$AUersName);
	}
	foreach ($arr_d as $key => $value) {
		foreach ($value as $key1 => $value1) {
			$arr_dd[] = $value1;
		}
	}
	if(in_array($AUId_d,$arr_dd)){
		echo '<script>alert("该角色已有用户,删除失败");</script>';
		header('Refresh:0;url=index.php');
		exit;
	}else{
		$db->delete('userinfo2',"AUId='$AUId_d'");
		save_manage_log('删除角色');
		echo '<script>alert("删除成功");</script>';
		header('Refresh:0;url=index.php');
		exit;
	}
}

if($_POST['list_form_action'] == 'del_AUId'){
	$AUId_d = $_POST['select_AUId'];
	$AUId_s = implode(',',$AUId_d);
	$db->delete('userinfo2',"AUId in($AUId_s)");
	save_manage_log('批量删除角色');
	echo '<script>alert("批量删除成功");</script>';
	header('Refresh:0;url=index.php');
	exit;
}
$where = 1;
if($_GET['AUersName']){
	//var_dump($_GET['AUersName']);exit;
	$AUersName_s = $_GET['AUersName'];
	$where .= " and AUersName like '%$AUersName_s%'";
}
$row_count=$db->get_row_count('userinfo2', $where);
$total_pages=ceil($row_count/get_cfg('admin.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('admin.page_count');
$userinfo2_row = $db->get_limit('userinfo2',$where,'*',"AccTime desc",$start_row, get_cfg('admin.page_count'));
include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
    	<span style="font-size:14px;color:#666;margin-left:20px">用户名:</span>
    	<input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="AUersName" value="<?=$AUersName_s?>">
    	<!-- <span style="font-size:14px;color:#666">状态:</span>
    		<select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="" id="">
    			<option value="">全部</option>
    		</select>
    	<span style="font-size:14px;color:#666">所属角色:</span>
	    	<select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="" id="">
	    		<option value="">全部</option>
	    	</select> -->
    	<input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">
</form> 
<form style="width:100%;background:#ececec;margin-top:30px" name="list_form" id="list_form" class="list_form" method="post" action="index.php">
   
    		<a href="add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加角色</a><!-- 	<div>
	    	<input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_AUId[]");' value="全选"> 
	    	<input name="del_AUId" id="del_AUId" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
	    	<input type="button" value="批量禁用" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">
    		<span style="position:absolute;right:20px">
    			<span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px">3</span><span style="font-size:12px;color:#999">名角色</span>
    		</span>
    	</div> -->

    	<div style="background:#fff;color:#666;font-size:12px">
    		<table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
    			<tr style="height:60px;" align="center">		           
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>选项</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>序号</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>角色名称</td><!-- 
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>角色类型</td> -->
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="17%" nowrap>角色描述</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>创建时间</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>创建人</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>		                       
	        	</tr>
	        	<?php 
	        		for ($i=0; $i < count($userinfo2_row); $i++) { 
	        		if($userinfo2_row[$i]['AUId'] !=9){
	        	?>
	        	<tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">		           
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" >
						<input class="yx" type="checkbox" name="select_AUId[]" id="" value="<?=$userinfo2_row[$i]['AUId']?>">
		            </td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$start_row+$i+1?></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$userinfo2_row[$i]['AUersName']?></td>
		            <!-- <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$userinfo2_row[$i]['ALocked']?></td> -->
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="17%" ><?=$userinfo2_row[$i]['Description']?></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><?=date("Y-m-d H:i:s",$userinfo2_row[$i]['AccTime']);?></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$userinfo2_row[$i]['AddName']?></td>
		            <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
		            	<a href="mod.php?AUId=<?=$userinfo2_row[$i]['AUId']?>">修改</a>
		            	<a href="">查看</a>
		            	<a href="index.php?AUId=<?=$userinfo2_row[$i]['AUId']?>&act=del_character">删除</a> 
		            </td>	            
	        	</tr>
	        	<?php }}?>
	        </table>    		
    	</div>   
    	<input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
        <input type="hidden" name="page" value="<?=$page;?>">
        <input name="list_form_action" id="list_form_action" type="hidden" value="">	
    	<div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>
    </form>
