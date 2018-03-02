<?php
!isset($order_row) && $order_row=$db->get_one('orders', "OId='$OId'");

ob_start();
?>
Dear <strong><?=htmlspecialchars($order_row['ShippingFirstName'].' '.$order_row['ShippingLastName']);?></strong>:<br /><br />

This is an automated email from <a href="<?=get_domain();?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=get_domain(0);?></a>. Please do not reply to this email.<br /><br />

Your order#<a href="<?=get_domain().$member_url;?>?module=orders&OId=<?=$order_row['OId'];?>&act=detail" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=$order_row['OId'];?></a> has shipped!<br /><br />

<?php include($site_root_path.'/inc/lib/mail/order_detail.php');?>

Yours sincerely,<br /><br />

<?=get_domain(0);?> Customer Care Team
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>