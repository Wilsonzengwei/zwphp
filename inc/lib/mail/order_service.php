<?php
!isset($order_row) && $order_row=$db->get_one('orders', "OId='$OId'");

ob_start();
?>
Dear <strong>张雅玉</strong>:<br /><br />

这是自动发送的电子邮件 <a href="<?=get_domain();?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=get_domain(0);?></a>。请不要回复此邮件。<br /><br />

您收到一条新订单#<a href="<?=get_domain().$member_url;?>?module=orders&OId=<?=$order_row['OId'];?>&act=detail" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=$order_row['OId'];?></a> 

<strong>Please Note :</strong><br />
这条订单状态是 <strong><?=$order_status_ary[$order_row['OrderStatus']];?></strong> 现在，这意味着还没有完成支付 。<br /><br />

请前往后台跟进订单。

<a href="<?=get_domain().$cart_url;?>?module=payment&OId=<?=$order_row['OId'];?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;">If you want to payment online, please click here to continue payment &gt;&gt;</a><br /><br />

<?php include($site_root_path.'/inc/lib/mail/order_detail_service.php');?>

Yours sincerely,<br /><br />

<?=get_domain(0);?> Customer Care Team
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>