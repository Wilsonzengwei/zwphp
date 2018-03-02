<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='coupon';
check_permit('coupon', 'coupon.mod');

if($_POST){
	$CId=(int)$_POST['CId'];
	$query_string=$_POST['query_string'];
	$Deadline=strtotime($_POST['Deadline'])+86400-1;
	$Length=(int)$_POST['Length'];
	$Discount=(float)$_POST['Discount'];
	$Money=$_POST['Money'];
	$CType=(int)$_POST['CType'];
	$UseCondition=(float)$_POST['UseCondition'];
	$CanUsedTimes=(int)$_POST['CanUsedTimes'];
	$MemberId=(int)$_POST['MemberId'];
	
	$Deadline=strtotime($_POST['Deadline'])+86400-1;
	$db->update('coupon', "CId='$CId'", array(
			'Deadline'		=>	$Deadline,
			'Discount'		=>	$Discount,
			'Money'			=>	$Money,
			'CType'			=>	$CType,
			'UseCondition'	=>	$UseCondition,
			'CanUsedTimes'	=>	$CanUsedTimes,
			'MemberId'		=>	$MemberId
		)
	);
	
	save_manage_log('编辑优惠券:'.$CalendarDate);
	
	header("Location: index.php?$query_string");
	exit;
}

$CId=(int)$_GET['CId'];
$query_string=query_string('CId');

$coupon_row=$db->get_one('coupon', "CId='$CId'");

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('coupon_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
            <div class="table_bg"></div>
            <div class="tr">
                <div class="tr_title"><?=get_lang('ly200.mod').get_lang('coupon.coupon');?></div>
                <div class="form_row">
                    <font class="fl"><?=get_lang('coupon.coupon');?>:</font>
                    <span class="fl"><?=$coupon_row['CNumber']?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                    <font class="fl"><?=get_lang('coupon.type');?>:</font>
                    <span class="fl">
                        <input type="radio" name="CType" value="1" <?=$coupon_row['CType']==1?'checked="checked"':''?> onclick="CL(1)" /><?=get_lang('coupon.discount');?><br />
                        <input type="radio" name="CType" value="0" <?=$coupon_row['CType']==0?'checked="checked"':''?> onclick="CL(0)" /><?=get_lang('coupon.less_cash');?>
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                    <font class="fl">绑定会员:</font>
                    <span class="fl">
                       <select name="MemberId" style="margin-top:5px;">
                       		<option>绑定会员</option>
                            <?php $member_row=$db->get_all('member','1');
								foreach((array) $member_row as $item){
							?>
                            	<option value="<?=$item['MemberId']?>" <?= $item['MemberId']==$coupon_row['MemberId']?'selected="selected"':''?> ><?=$item['Email']?></option>
                            <?php }?>
                       </select>
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr" id="CType_1" style="display:<?=$coupon_row['CType']==1?"":"none";?>;">
                <div class="form_row">
                    <font class="fl"><?=get_lang('coupon.discount');?>:</font>
                    <span class="fl">
                        <input type="text" name="Discount" value="<?=$coupon_row['Discount']?>" size="8" maxlength="5" class="form_input" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" />% off
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr" id="CType_0" style="display:<?=$coupon_row['CType']==0?"":"none";?>;">
                <div class="form_row">
                    <font class="fl"><?=get_lang('coupon.less_cash');?>:</font>
                    <span class="fl">
                        $<input type="text" name="Money" value="<?=$coupon_row['Money']?>" size="8" maxlength="5" class="form_input" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" />
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                    <font class="fl"><?=get_lang('coupon.conditions');?>:</font>
                    <span class="fl">
                        $<input name="UseCondition" type="text" value="<?=$coupon_row['UseCondition']?>" check="" class="form_input" size="5" maxlength="5" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" /><?=get_lang('coupon.conditions_info');?>
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="form_row">
                    <font class="fl"><?=get_lang('coupon.valid');?>:</font>
                    <span class="fl">
                        <input name="Deadline" type="text" value="<?=$coupon_row['Deadline']==''?'':date('Y-m-d',$coupon_row['Deadline'])?>" class="form_input" size="10" maxlength="20" id="SelectDate">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr last">
                <div class="form_row">
                    <font class="fl"><?=get_lang('coupon.number_of_times');?>:</font>
                    <span class="fl">
                        <input name="CanUsedTimes" type="text" value="<?=$coupon_row['CanUsedTimes']?>" check="" class="form_input" size="8" maxlength="5" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" />次
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="button fr">
                <input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
                <input type="hidden" name="CId" value="<?=$CId?>" />
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<script>
function CL(num){
	var i=0;
	for(i=0; i<2; i++){
		$_('CType_'+i).style.display='none';
	}
	$_('CType_'+num).style.display='';
}
</script>
<?php include('../../inc/manage/footer.php');?>