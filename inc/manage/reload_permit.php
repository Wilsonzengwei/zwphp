<?php
//*********************************加载权限文件（start here）**********************************************************************
if((int)$_SESSION['ly200_AdminUserId']){
	foreach($manage_menu as $group_key=>$group){
		foreach($group as $key=>$value){
			$menu[$key]==0 && $manage_menu[$group_key][$key]='';
		}
	}
	
	$permit_act_ary=array('add', 'mod', 'del', 'order', 'move', 'reset');
	$tmp_Ly200Cfg=$Ly200Cfg;
	$tmp_menu=$menu;
	$tmp_manage_menu=$manage_menu;
	
	if($_SESSION['ly200_AdminGroupId']!=9){	//非超级管理员权限重载
		$groupid = explode(',',$_SESSION['ly200_AdminGroupId']);
		for ($i=0; $i < count($groupid); $i++) { 
		
			@include($site_root_path."/inc/manage/character/$groupid[$i].php");
		}
		//var_dump($groupid);exit;
		foreach($manage_menu as $group_key=>$group){
			foreach($group as $key=>$value){
				if($menu[$key]==1){
					if((int)$permit_menu[$key]==0){	//大栏目权限
						$menu[$key]=0;
						$manage_menu[$group_key][$key]='';
					}
					$find=0;
					$cfg=get_cfg($key);
					if(!is_array($cfg)){
						$find=1;
						$cfg=get_cfg(str_replace('_', '.', $key));
					}
					if(check_permit_act_value($cfg, $permit_act_ary)){	//添加、修改、删除等具体权限
						$k=$find==0?"['$key']":('[\''.str_replace('_', '\'][\'', $key).'\']');
						for($i=0; $i<count($permit_act_ary); $i++){
							if($cfg[$permit_act_ary[$i]]==1){
								$v=(int)eval("return \$permit_Ly200Cfg{$k}[{$permit_act_ary[$i]}];");
								eval("\$Ly200Cfg{$k}['{$permit_act_ary[$i]}']=$v;");
							}
						}
					}
				}
			}
		}
	}
}
//*********************************加载权限文件（end here）************************************************************************
?>