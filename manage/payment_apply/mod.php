<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='payment_apply';
check_permit('payment_apply', 'payment_apply.mod');

if($_POST){
	$IsPay=(int)$_POST['IsPay'];
	$InfoId= (int)$_POST['InfoId'];
	$db->update('orders_payment_info', "InfoId='$InfoId'", array(
			'IsPay'			=>	$IsPay,
		)
	);
	
	save_manage_log('编辑付款记录');
	
	header("Location: index.php?$query_string");
	exit;
}

$InfoId=(int)$_GET['InfoId'];
$payment_apply_row=$db->get_one('orders_payment_info', "InfoId='$InfoId'");
$db->update('orders_payment_info', "InfoId='$InfoId'", array('IsLook'=>	1));

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('payment_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    <div class="table">
    	<div class="tr">
            <div class="tr_title">支付记录</div>
            <div class="form_row">
            	<font class="fl">预计转账时间:</font>
                <span class="fl"><?=date('d/m/Y',$payment_apply_row['SentTime']);?></span>
                <div class="clear"></div>
            </div>
        </div>
    	<div class="tr">
            <div class="form_row">
            	<font class="fl">卡号:</font>
                <span class="fl"><?=$payment_apply_row['BankTransactionNumber']?$payment_apply_row['BankTransactionNumber']:$payment_apply_row['MTCNNumber']?></span>
                <div class="clear"></div>
            </div>
        </div>
    	<div class="tr">
            <div class="form_row">
            	<font class="fl">转账金额:</font>
                <span class="fl">
                	<?=$payment_apply_row['SentMoney']?>
                </span>
                <div class="clear"></div>
            </div>
        </div>
        <div class="tr">
            <div class="form_row">
            	<font class="fl">转账货币:</font>
                <span class="fl">
                	<?=$payment_apply_row['Currency']?>
                </span>
                <div class="clear"></div>
            </div>
        </div>
        <div class="tr">
            <div class="form_row">
            	<font class="fl">备注:</font>
                <span class="fl">
                	<textarea name="Contents" rows="8" cols="106" class="form_area"><?=$payment_apply_row['Contents'];?></textarea>
                </span>
                <div class="clear"></div>
            </div>
        </div>
        <div class="tr last">
            <div class="editor_row">
                <div class="editor_title fl">付款状态:</div>
                <div class="fl">
                <select name="IsPay" class="form_select">
                	<option value="1" <?=$payment_apply_row['IsPay']==1?'selected="selected"':'';?> >未收到汇款</option>
                    <option value="2" <?=$payment_apply_row['IsPay']==2?'selected="selected"':'';?>>已收到汇款</option>
                </select>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="button fr">
            <input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
			<input type="hidden" name="InfoId" value="<?=$InfoId;?>">
        </div>
        <div class="clear"></div>
    </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>