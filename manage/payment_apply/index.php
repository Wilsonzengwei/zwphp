<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='payment_apply';
check_permit('payment_apply');

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('payment_header.php');?>
    <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
        <tr align="center" class="list_form_title nosearch" id="list_form_title">
            <td width="8%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <td width="25%" nowrap><strong>姓名</strong></td>
            <td width="25%" nowrap><strong>支付卡号</strong></td>
            <td width="25%" nowrap><strong>支付订单号</strong></td>
            <td width="25%" nowrap><strong>是否查看</strong></td>
            <td width="25%" nowrap><strong>是否汇款</strong></td>
            <?php if(get_cfg('payment_method.mod')){?><td width="10%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
        </tr>
        <?php
        $payment_apply_row=$db->get_all('orders_payment_info', '1', '*', 'InfoId desc');
        for($i=0; $i<count($payment_apply_row); $i++){
        ?>
        <tr align="center">
            <td nowrap><?=$i+1 ;?></td>
            <td class="break_all"><?=$payment_apply_row[$i]['FirstName'].' '.$payment_apply_row[$i]['LastName'];?></td>
            <td><?=$payment_apply_row[$i]['MTCNNumber']?$payment_apply_row[$i]['MTCNNumber']:$payment_apply_row[$i]['BankTransactionNumber'];?></td>
            <td><?=$db->get_value('orders',"OrderId = '{$payment_apply_row[$i]['OrderId']}'",'OId');?></td>
            <td nowrap><?=$payment_apply_row[$i]['IsLook']?'已查看':'<font class="fc_red">未查看</font>';?></td>
            <td nowrap><?=$payment_apply_row[$i]['IsPay']==1?'未汇款':'<font class="fc_red">已汇款</font>';?></td>
            <?php if(get_cfg('payment_method.mod')){?><td nowrap><a href="mod.php?InfoId=<?=$payment_apply_row[$i]['InfoId']?>" title="<?=get_lang('ly200.mod');?>" class="mod"></a></td><?php }?>
        </tr>
        <?php }?>
    </table>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>