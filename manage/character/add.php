<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$UserId = $_SESSION['ly200_AdminUserId'];
if($UserId == '1'){
    $SalesmanName = "超级管理员";
}else{
    $SalesmanName = $_SESSION['ly200_AdminSalesmanName'];
}
$Ly200Cfg=$tmp_Ly200Cfg;
$menu=$tmp_menu;
$manage_menu=$tmp_manage_menu;

if($_POST){
	$Name=$_POST['Name'];
	$JType=$_POST['JType'];
	$Description=$_POST['Description'];
	$time = time();
	$db->insert('userinfo2', array(
			'AUersName'		=>	$Name,
			'ALocked'		=>	$JType,
			'AccTime'		=>	$time,
			'AddName' 		=> 	$SalesmanName,
			'Description'	=>	$Description
		)
	);
	//------------------------------------------------------------------------权限(start here)------------------------------------------------------------------------
	if($GroupId!=1){
		$php_contents_menu='';
		$php_contents_config='';
		foreach($manage_menu as $group_key=>$group){
			if(implode($group)==''){
				continue;
			}
			foreach($group as $key=>$value){
				if($menu[$key]!=1 || $key=='admin'){
					continue;
				}
				if((int)$_POST['permit_'.$key] == 1){
					$php_contents_menu.="\$permit_menu['$key']=".(int)$_POST['permit_'.$key].";\r\n";
				}
				$find=0;
				$cfg=get_cfg($key);
				if(!is_array($cfg)){
					$find=1;
					$cfg=get_cfg(str_replace('_', '.', $key));
				}
				if(check_permit_act_value($cfg, $permit_act_ary)){
					$k=$find==0?"['$key']":('[\''.str_replace('_', '\'][\'', $key).'\']');
					for($i=0; $i<count($permit_act_ary); $i++){
						$cfg[$permit_act_ary[$i]]==1 && $php_contents_config.="\$permit_Ly200Cfg{$k}['{$permit_act_ary[$i]}']=1".";\r\n";
					}
				}
			}
		}
		$php_contents="<?php\r\n//管理员{$UserName}权限配置\r\n".$php_contents_menu."\r\n".$php_contents_config.'?>';
		write_file('/inc/manage/character/', $db->get_insert_id().'.php', $php_contents);
	}
	//------------------------------------------------------------------------权限(end here)-------------------------------------------------------------------------
	if($_POST['mod_salesman']){
    $mod_salesman = $_POST['mod_salesman'];
        $db->update('userinfo', "UserId='$UserId'",array(
                'Salesman_Name' => $mod_salesman
            ));
    }
	save_manage_log('添加后台角色：'.$UserName);
	
	header('Location: index.php');
	exit;
}
include('../../inc/manage/header.php');
?>


<form style="background:#fff;min-height:600px;width:95%" action="add.php" method="post">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">添加角色</div>
	<div style="margin-top:20px"><span class="y_title">角色名称：</span><input class="y_title_txt" type="text" name="Name">
	</div>
	<div style="position:relative;margin-top:20px;min-height:200px"><span class="y_title">拥有权限：</span>
		<span>
			<?php 
                foreach($manage_menu as $group_key=>$group){
                    if(implode($group)==''){
                        continue;
                    }

			?>
			<div data='1' class="hhe" style="width:80%;vertical-align:middle;color:#333;font-size:14px;padding:2px 0;position:relative;left:110px;top:-20px"><img style="position:absolute;top:5px" class="hheimg" src="../images/ico/Add01.png" alt=""><span style="margin-left:20px"><?=get_lang('menu.'.$group_key);?></span>
			
				<div class="hhetxt" style="width:900px;overflow:hidden;margin-left:15px;display:none">
				<?php 
					foreach($group as $key=>$value){
	                    if($menu[$key]!=1 || $key=='admin'){
	                        continue;
	                    }
	                    
	                
				?>
					<div style='width:100px;height:20px;float:left;padding:6px 0;color:#666;overflow:hidden'>
						<input type="checkbox"  name="<?='permit_'.$key?>" value='1' <?=$checked?>><span style="font-size:12px;margin-left:5px;"><?=get_lang($value[1])?></span>
					</div>
				
				<?php }?>
				</div>
		
			</div>
			<?php }?>
		</span>
	<div style="margin-top:20px;position:relative">
		<span style="position:relative;top:-55px" class="y_title">描述</span><input style="width:750px;height:120px;border:1px solid #ccc;border-radius:3px;margin-left:10px" type="text" name="Description">
	</div>	
	</div>	
	<div class="y_submit">
        <input class="ys_input" type="submit" value="保存">
    </div>	
</form>
<?php include('../../inc/manage/footer.php');?>
<script>
	$(function(){
		$('.hhe').click(function(){
			if($(this).attr('data')=='1'){
				$(this).find('.hhetxt').show();
				$(this).find('.hheimg').attr('src','../images/ico/Del01.png');
				$(this).attr('data','2');
			}else if($(this).attr('data')=='2'){
				$(this).find('.hhetxt').hide();
				$(this).find('.hheimg').attr('src','../images/ico/Add01.png');
				$(this).attr('data','1');
			}
		$('.hhetxt').click(function(){
			event.stopPropagation();
		})
			
		})
	})
</script>
