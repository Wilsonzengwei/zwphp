<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

$page_cur='admin';
check_permit('admin');

$where="Del=1";

if($_GET['query_string']){
	$page=(int)$_GET['page'];
	header("Location: index.php?{$_GET['query_string']}&page=$page");
	exit;
}
if($_GET['user'] == 'sousuo'){
	if($_GET['UserName']){
		$UserName_s = $_GET['UserName'];
		$where.= " and UserName like '%$UserName_s%'";
	}
	if($_GET['Status'] !== ''){
		//var_dump($_GET['Status']);exit;
		$Status_s = $_GET['Status'];
		$where.= " and Status='$Status_s'";
	}
	if($_GET['AUersName']){
		$AUersName_s = (int)$_GET['AUersName'];
		
		$where.= " and AUersName like '%$AUersName_s%'";
	}
}
if($_GET['act'] == 'admin_no_1'){
		
	$UId = $_GET['UId'];
	$db->update('admin_info',"UId='$UId'",array(
				"Status" => "0",
			));
	save_manage_log('禁用后台管理员');
	echo '<script>alert("禁用成功");</script>';
	header('Refresh:0;url=index.php');
	exit;
}
if($_GET['act'] == 'admin_no_2'){
	$GroupId = $_SESSION['ly200_AdminGroupId'];
	$UId = $_GET['UId'];
	$AUersName = $db->get_one("admin_info","1","AUersName");
	if(strpos($AUersName['AUersName'],'9')){
		if(!strpos($AUersName['AUersName'],'9')){
			echo '<script>alert("您没有相应的权限");</script>';
			header('Refresh:0;url=index.php');
			exit;
		}
		
	}
	$db->update('admin_info',"UId='$UId'",array(
			"Del"	=>	'0',
		));
	save_manage_log('删除后台管理员');
	echo '<script>alert("删除成功");</script>';
	header('Refresh:0;url=index.php');
	exit;
}
if($_GET['act'] == 'admin_no_3'){
		
	$UId = $_GET['UId'];
	$db->update('admin_info',"UId='$UId'",array(
				"PassWord" => password("12345678"),
			));
	header('Location: index.php');
	exit;
}
if($_POST['list_form_action']=='admin_del'){
	if($_POST['select_admin']){
		$UId=implode(',', $_POST['select_admin']);
		$where="UId in($UId)";
		$db->update('admin_info', $where,array(
				'Del'	=>	'0',
			));
		
		save_manage_log('批量删除后台管理员');
		echo '<script>alert("批量删除成功");</script>';
		header('Refresh:0;url=index.php');
		exit;
	}else{
        echo '<script>alert("未选中选项,批量删除失败");</script>';
        header('Refresh:0;url=index.php?$query_string&page=$page"');
        exit;
    }
}
if($_POST['list_form_action']=='admin_no'){
	if($_POST['select_admin']){
		$UId=implode(',', $_POST['select_admin']);
		$where="UId in($UId)";

		$db->update('admin_info',$where,array(
			"Status"	=>	"0",
			));
			
		save_manage_log('批量禁用后台管理员');
		
		echo '<script>alert("批量禁用成功");</script>';
		header('Refresh:0;url=index.php');
		exit;
	}else{
        echo '<script>alert("未选中选项,批量删除失败");</script>';
       	header('Refresh:0;url=index.php');
		exit;
    }
}

$row_count=$db->get_row_count('admin_info', $where);
$total_pages=ceil($row_count/get_cfg('admin.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('admin.page_count');
$admin_info = $db->get_limit('admin_info', $where, '*', 'UId desc',$start_row, get_cfg('admin.page_count'));
$count_all = count($admin_info);

include('../../inc/manage/header.php');
?>
   <form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
    	<span style="font-size:14px;color:#666;margin-left:20px">用户名:</span>
    	<input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="UserName" value="<?=$UserName_s?>">
    	<span style="font-size:14px;color:#666">状态:</span>
    		<select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="Status">
    			<option value="">全部</option>
    			<option value="1" <?=$Status_s == '1' ? selected : '';?>>启用</option>
    			<option value="0" <?=$Status_s == '0' ? selected : '';?>>禁用</option>
    		</select>
    	<span style="font-size:14px;color:#666">所属角色:</span>
	    	<select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="AUersName" id="">
	    		<option value="">全部</option>
	    		<?php 
	    			$character = $db->get_all('userinfo2','1');
	    			for ($i=0; $i < count($character); $i++) { 
	    				
	    			
	    		?>
	    		<option value="<?=$character[$i]['AUId']?>" <?=$AUersName_s == (int)$character[$i]['AUId'] ? selected : '';?>><?=$character[$i]['AUersName']?></option>
	    		<?php }?>
	    	</select>
	    <input type="hidden" name="user" value="sousuo">
    	<input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">

    </form>
    <form style="width:100%;background:#ececec;margin-top:30px" class="list_form" name="list_form" id="list_form"  method="post" action="index.php" >
    	<div>
    	<a href="add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加用户</a>
	    	<input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_admin[]");' value="全选">
	    	<input name="admin_del" id="admin_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
	    	<input type="button" id="admin_no" name="admin_no" value="批量禁用" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick="click_button(this, 'list_form', 'list_form_action');">
    		<span style="position:absolute;right:20px">
    			<span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px"><?=$row_count?></span><span style="font-size:12px;color:#999">名用户</span>
    		</span>
    	</div>
   
    	<div style="background:#fff;color:#666;font-size:12px">
    		<table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
    			<tr style="height:60px;" align="center">		           
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>选项</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>序号</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>用户名</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>姓名</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>联系电话</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>所属角色</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>状态</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><div style="width:70px">创建时间</div></td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap><div style="width:70px">上次登录时间</div></td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="15%" nowrap>上次登录ip</td>
		            <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="15%" nowrap>操作</td>	            
	        	</tr>
	        	<?php 

		        include($site_root_path.'/inc/fun/ip_to_area.php');
		       
        		$UserId = $_SESSION['ly200_AdminUserId'];
    			for($i=0;$i<count($admin_info );$i++){
    				$ip_area=ip_to_area($admin_info[$i]['LastLoginIp']);
    				if(!$ip_area){
    					$ip_area['country'] = '未登入';
    					$ip_area['area'] = 'a';
    				}
    				if($admin_info[$i]['Status'] == '0'){
    					$Status = '禁用';
    				}elseif($admin_info[$i]['Status'] == '1') {
    					$Status = '启用';
    				}
    				/*if($admin_info[$i]['AUersName']){
    					$AUersName_r = $admin_info[$i]['AUersName'];
    					$Name_sr = $db->get_all('userinfo2',"AUId in($AUersName_r)","AUersName");
	    					foreach ($Name_sr as $key => $value) {
	    						foreach ($value as $key1 => $value1) {
	    							$arr_r[] = $value1;
	    							$Name_srr = implode(',',$arr_r);
	    						}
	    						
	    					}
	    				
    					
    				}
*/
    				if($admin_info[$i]['UId'] != 16){
    		?>
	        	<tr class="list" style="height:60px" align="center">		           
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>
						<input class="yx" type="checkbox" name="select_admin[]" value="<?=$admin_info[$i]['UId'];?>">
		            </td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$start_row+$i+1;?></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$admin_info[$i]['UserName']?></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$admin_info[$i]['Name']?></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$admin_info[$i]['Mombil']?></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$admin_info[$i]['ACharater']?></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$Status?></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><div style="width:70px"><?=date(get_lang('ly200.time_format_full'), $admin_info[$i]['CreateTime']);?></div></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" ><div style="width:70px"><?=date(get_lang('ly200.time_format_full'), $admin_info[$i]['LastLoginTime']);?></div></td>
		            <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="15%" ><div><?=$admin_info[$i]['country']?></div><div title="<?=$ip_area['country'].$ip_area['area']?>"><?=strCut($ip_area['country'].$ip_area['area'],12)?></div></td>
		            <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="16%" >
		            	<a href="mod.php?UId=<?=$admin_info[$i]['UId']?>">修改</a>
		            	<a href="index.php?act=admin_no_1&UId=<?=$admin_info[$i]['UId'];?>">禁用</a>
		            	<a href="index.php?act=admin_no_2&UId=<?=$admin_info[$i]['UId'];?>">删除</a>
		            	<a href="index.php?act=admin_no_3&UId=<?=$admin_info[$i]['UId'];?>">重置密码</a>
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
<?php include('../../inc/manage/footer.php');?>