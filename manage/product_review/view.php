<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_review';
check_permit('product_review');

if($_POST){
	$page=(int)$_POST['page'];
	$RId=(int)$_POST['RId'];
	$query_string=$_POST['query_string'];
	
	$Display=(int)$_POST['Display'];
	$Reply=$_POST['Reply'];
	
	$db->update('product_review', "RId='$RId'", array(
			'Display'	=>	$Display,
			'Reply'		=>	$Reply,
			'ReplyTime'	=>	$service_time
		)
	);
	
	save_manage_log('产品评论回复');
	
	header("Location: index.php?$query_string");
	exit;
}

$RId=(int)$_GET['RId'];
$query_string=query_string('RId');

$product_review_row=$db->get_one('product_review', "RId='$RId'");
$product_row=$db->get_one('product', "ProId='{$product_review_row['ProId']}'");

include('../../inc/fun/ip_to_area.php');
$ip_area=ip_to_area($product_review_row['Ip']);

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('review_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="view.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
            <div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.view').get_lang('product_review.modelname');?></div>
                <div class="form_row">
                    <font class="fl"><?=get_lang('product_review.product');?>:</font>
                    <span class="fl"><a href="<?=get_url('product', $product_row);?>" target="_blank"><?=htmlspecialchars($product_row['Name']);?></a></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('product_review.full_name');?>:</font>
                    <span class="fl"><?=htmlspecialchars($product_review_row['FullName']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('ly200.email');?>:</font>
                    <span class="fl">
                        <?=htmlspecialchars($product_review_row['Email']);?><?php if($product_review_row['Email'] && $menu['send_mail']){?>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($product_review_row['Email'].'/'.$product_review_row['FullName']);?>');" class="red"><?=get_lang('send_mail.send');?></a><?php }?>
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('product_review.rating');?>:</font>
                    <span class="fl"><?=str_repeat('<img src="/images/lib/product/x0.jpg">', $product_review_row['Rating']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('ly200.contents');?>:</font>
                    <span class="fl"><?=format_text($product_review_row['Contents']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('ly200.ip');?>:</font>
                    <span class="fl"><?=$product_review_row['Ip'];?> [<?=$ip_area['country'].$ip_area['area'];?>]</span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                    <font class="fl"><?=get_lang('ly200.time');?>:</font>
                    <span class="fl"><?=date(get_lang('ly200.time_format_full'), $product_review_row['PostTime']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <?php if(get_cfg('product_review.display')){?>
                <div class="tr">
                	<div class="form_row">
                        <font class="fl"><?=get_lang('ly200.display');?>:</font>
                        <span class="fl"><input type="checkbox" name="Display" value="1" <?= $product_review_row['Display']==1?'checked':'';?> /></span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <?php if(get_cfg('product_review.reply')){?>
                <div class="tr last">
                	<div class="form_row">
                        <font class="fl"><?=get_lang('product_review.reply');?>:</font>
                        <span class="fl"><textarea name="Reply" rows="8" cols="106" class="form_area"><?=htmlspecialchars($product_review_row['Reply'])?></textarea></span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <div class="button fr">
            	<?php if(get_cfg('product_review.reply')){?>
					<input type="submit" value="<?=get_lang('product_review.reply');?>" name="submit" class="form_button">
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