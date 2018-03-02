<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='feedback';
check_permit('feedback');

if($_POST){
	$FId=(int)$_POST['FId'];
	$query_string=$_POST['query_string'];
	
	$Display=(int)$_POST['Display'];
	$Reply=$_POST['Reply'];
	
	$db->update('feedback', "FId='$FId'", array(
			'Display'	=>	$Display,
			'Reply'		=>	$Reply,
			'ReplyTime'	=>	$service_time
		)
	);
	
	save_manage_log('在线留言回复');
	
	header("Location: index.php?$query_string");
	exit;
}

$FId=(int)$_GET['FId'];
$query_string=query_string('FId');

$feedback_row=$db->get_one('feedback', "FId='$FId'");
!$feedback_row['IsRead'] && $db->update('feedback', "FId='$FId'", array('IsRead'=>1));

include('../../inc/fun/ip_to_area.php');
$ip_area=ip_to_area($feedback_row['Ip']);

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('feedback_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="view.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
        	<div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.view').get_lang('feedback.modelname');?></div>
                <div class="form_row">
                	<font class="fl"><?=get_lang('ly200.full_name');?>:</font>
                    <span class="fl"><?=htmlspecialchars($feedback_row['Name']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
				<div class="form_row">
                	<font class="fl"><?=get_lang('feedback.company');?>:</font>
                    <span class="fl"><?=htmlspecialchars($feedback_row['Company']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                	<font class="fl"><?=get_lang('feedback.phone');?>:</font>
                    <span class="fl"><?=htmlspecialchars($feedback_row['Phone']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                	<font class="fl"><?=get_lang('feedback.mobile');?>:</font>
                    <span class="fl"><?=htmlspecialchars($feedback_row['Mobile']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                	<font class="fl"><?=get_lang('ly200.email');?>:</font>
                    <span class="fl">
						<?=htmlspecialchars($feedback_row['Email']);?><?php if($feedback_row['Email'] && $menu['send_mail']){?>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($feedback_row['Email'].'/'.$feedback_row['Name']);?>');" class="red"><?=get_lang('send_mail.send');?></a><?php }?>
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                	<font class="fl"><?=get_lang('feedback.qq');?>:</font>
                    <span class="fl"><?=htmlspecialchars($feedback_row['QQ']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                	<font class="fl"><?=get_lang('feedback.subject');?>:</font>
                    <span class="fl"><?=htmlspecialchars($feedback_row['Subject']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                	<font class="fl"><?=get_lang('feedback.message');?>:</font>
                    <span class="fl"><?=format_text($feedback_row['Message']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                	<font class="fl"><?=get_lang('ly200.ip');?>:</font>
                    <span class="fl"><?=$feedback_row['Ip'];?> [<?=$ip_area['country'].$ip_area['area'];?>]</span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                	<font class="fl"><?=get_lang('ly200.time');?>:</font>
                    <span class="fl"><?=date(get_lang('ly200.time_format_full'), $feedback_row['PostTime']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <?php if(get_cfg('feedback.display')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.display');?>:</font>
                        <span class="fl"><input type="checkbox" name="Display" value="1" <?= $feedback_row['Display']==1?'checked':'';?> /></span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <?php if(get_cfg('feedback.reply')){?>
                <div class="tr last">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('feedback.reply');?>:</font>
                        <span class="fl"><textarea name="Reply" rows="8" cols="106" class="form_area"><?=htmlspecialchars($feedback_row['Reply'])?></textarea></span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <div class="button fr">
                <?php if(get_cfg('feedback.reply')){?>
                	<input type="submit" value="<?=get_lang('feedback.reply');?>" name="submit" class="form_button">
                    <input type="hidden" name="query_string" value="<?=$query_string;?>">
                    <input type="hidden" name="FId" value="<?=$FId;?>">
				<?php }else{ ?>
                	<a href="index.php?<?=$query_string;?>" class="form_button return"><?=get_lang('ly200.return');?></a>
                <?php } ?>
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>