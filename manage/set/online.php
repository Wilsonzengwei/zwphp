<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'online_set';
check_permit('online');

if($_POST){
	$php_contents="<?php\r\n//在线客服\r\n\r\n";
	
	$j=0;
	for($i=0; $i<count($_POST['Account']); $i++){
		if($_POST['Account'][$i]!=''){
			$_Name=format_post_value($_POST['Name'][$i]);
			$_Account=format_post_value($_POST['Account'][$i]);
			$_AccountType=(int)$_POST['AccountType'][$i];
			
			$php_contents.="\$mCfg['online'][$j]['Name']='$_Name';\r\n";
			$php_contents.="\$mCfg['online'][$j]['Account']='$_Account';\r\n";
			$php_contents.="\$mCfg['online'][$j]['AccountType']=$_AccountType;\r\n\r\n";
			$j++;
		}
	}
	
	$php_contents.='?>';
	write_file('/inc/set/', 'online.php', $php_contents);
	
	save_manage_log('在线客服设置');
	
	header('Location: online.php');
	exit;
}
function get_online_select($sed='')
{
	global $online_ary;
	$html='<select name="AccountType[]" class="form_select">';
	for($i=0;$i<count($online_ary);$i++)
	{
		$selected=$sed==$i?'selected="selected"':'';
		$html.='<option value="'.$i.'" '.$selected.'>'.$online_ary[$i].'</option>';	
	}
	$html.='</select>';
	return $html;
}

include('../../inc/manage/header.php');
?>
<script type="text/javascript">
function add_online_list_item(obj){
	var jqobj = '#' + obj ;
	var list=$_('select_list').innerHTML;
	var its='<div class="form_row">名称:<input name="Name[]" type="text" value="" class="form_input" size="25" maxlength="100"> 帐号:<input name="Account[]" type="text" value="" class="form_input" size="45" maxlength="200"> 帐号类型:'+list+' <a href="javascript:void(0)" onclick="del_online_list_item(this);" class="del"></a></div>';
	jQuery(jqobj).append(its);
}
function del_online_list_item(obj){
	jQuery(obj).parents('.form_row').remove();
}
</script>
<div class="div_con">
    <div id="select_list" style="display:none"><?=get_online_select()?></div>
	<?php include('set_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="online.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	
        <div class="table" id="mouse_trBgcolor_table">
            <div class="table_bg"></div>
            <div class="online_set_con">
            	<?php /*count(get_cfg('ly200.lang_array'))*/ ?>
				<?php for($i=0,$ilen=1;$i<$ilen; $i++){?>
                    <div class="tr<?=$i==$ilen-1?' last':''?>" id="online_list_<?=$i?>">
                        <div class="tr_title fl"><?=get_lang('set.online.set');?></div>
                        <a href="javascript:void(0);" onClick="this.blur(); add_online_list_item('online_list_<?=$i?>');" class="online_del fr" title="<?=get_lang('ly200.add_item');?>"></a>
                        <div class="clear"></div>
                        <?php
                        $count=count($mCfg['online']);
                        $count==0 && $count=1;
                        for($j=0; $j<$count; $j++){
                        ?>
                            <div class="form_row">
                                <?=get_lang('ly200.name');?>:<input name="Name[]" type="text" value="<?=htmlspecialchars($mCfg['online'][$j]['Name']);?>" class="form_input" size="25" maxlength="100"> 帐号:<input name="Account[]" type="text" value="<?=htmlspecialchars($mCfg['online'][$j]['Account']);?>" class="form_input" size="45" maxlength="200"> 帐号类型:<?=get_online_select($mCfg['online'][$j]['AccountType'])?> <a href="javascript:void(0)" onClick="del_online_list_item(this);" class="del"></a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="button fr"><input type="submit" value="<?=get_lang('ly200.submit');?>" name="submit" class="form_button"></div>
            <div class="clear"></div>
        </div>
        
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>