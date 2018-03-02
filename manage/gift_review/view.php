<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='gift_review';
check_permit('gift_review');

if($_POST){
	$page=(int)$_POST['page'];
	$RId=(int)$_POST['RId'];
	$query_string=$_POST['query_string'];
	
	$Display=(int)$_POST['Display'];
	$Reply=$_POST['Reply'];
	
	$db->update('gift_review', "RId='$RId'", array(
			'Display'	=>	$Display,
			'Reply'		=>	$Reply,
			'ReplyTime'	=>	$service_time
		)
	);
	
	save_manage_log('礼品评论回复');
	
	header("Location: index.php?$query_string");
	exit;
}

$RId=(int)$_GET['RId'];
$query_string=query_string('RId');

$gift_review_row=$db->get_one('gift_review', "RId='$RId'");
$gift_row=$db->get_one('gift', "ProId='{$gift_review_row['ProId']}'");

include('../../inc/fun/ip_to_area.php');
$ip_area=ip_to_area($gift_review_row['Ip']);

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('review_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="view.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
            <div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.view').get_lang('gift_review.modelname');?></div>
                <div class="form_row">
                    <font class="fl"><?=get_lang('gift_review.gift');?>:</font>
                    <span class="fl"><a href="<?=get_url('gift', $gift_row);?>" target="_blank"><?=htmlspecialchars($gift_row['Name']);?></a></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('gift_review.full_name');?>:</font>
                    <span class="fl"><?=htmlspecialchars($gift_review_row['FullName']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('ly200.email');?>:</font>
                    <span class="fl">
                        <?=htmlspecialchars($gift_review_row['Email']);?><?php if($gift_review_row['Email'] && $menu['send_mail']){?>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($gift_review_row['Email'].'/'.$gift_review_row['FullName']);?>');" class="red"><?=get_lang('send_mail.send');?></a><?php }?>
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('gift_review.rating');?>:</font>
                    <span class="fl"><?=str_repeat('<img src="/images/lib/gift/x0.jpg">', $gift_review_row['Rating']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('ly200.contents');?>:</font>
                    <span class="fl"><?=format_text($gift_review_row['Contents']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('ly200.ip');?>:</font>
                    <span class="fl"><?=$gift_review_row['Ip'];?> [<?=$ip_area['country'].$ip_area['area'];?>]</span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('ly200.time');?>:</font>
                    <span class="fl"><?=date(get_lang('ly200.time_format_full'), $gift_review_row['PostTime']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <?php if(get_cfg('gift_review.display')){?>
                <div class="tr">
                	<div class="form_row">
                        <font class="fl"><?=get_lang('ly200.display');?>:</font>
                        <span class="fl"><input type="checkbox" name="Display" value="1" <?= $gift_review_row['Display']==1?'checked':'';?> /></span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <?php if(get_cfg('gift_review.reply')){?>
                <div class="tr last">
                	<div class="form_row">
                        <font class="fl"><?=get_lang('gift_review.reply');?>:</font>
                        <span class="fl"><textarea name="Reply" rows="8" cols="106" class="form_area"><?=htmlspecialchars($gift_review_row['Reply'])?></textarea></span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <div class="button fr">
            	<?php if(get_cfg('gift_review.reply')){?>
					<input type="submit" value="<?=get_lang('gift_review.reply');?>" name="submit" class="form_button">
                    <input type="hidden" name="page" value="<?=$page;?>">
                    <input type="hidden" name="query_string" value="<?=$query_string;?>">
                    <input type="hidden" name="RId" value="<?=$RId;?>">
                <?php }else{ ?>
            		<a href="index.php?<?=$query_string;?>" class="form_button return"><?=get_lang('ly200.return');?></a>
                <?php } ?>
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>