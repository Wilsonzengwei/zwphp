<?php
!isset($order_row) && $order_row=$db->get_one('orders', "OId='$OId'");

ob_start();
?>
Dear <strong><?=htmlspecialchars($order_row['ShippingFirstName'].' '.$order_row['ShippingLastName']);?></strong>:<br /><br />

This is an automated email from <a href="<?=get_domain();?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=get_domain(0);?></a>. Please do not reply to this email.<br /><br />

Thank you for your order#<a href="<?=get_domain().$member_url;?>?module=orders&OId=<?=$order_row['OId'];?>&act=detail" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=$order_row['OId'];?></a> with <?=get_domain(0);?>.<br /><br />

<strong>Please Note :</strong><br />
Your order status is in <strong><?=$order_status_ary[$order_row['OrderStatus']];?></strong> right now, which means not completed payment yet , We only retain your order within 7 days.<br /><br />

You need payment <strong><?=iconv_price(((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice'])*(1+$order_row['PayAdditionalFee']/100));?></strong>, Please submit your <strong>Order Number</strong>, <strong>Reference Number</strong>, <strong>Amount</strong>, <strong>Sender's First Name</strong> and <strong>Last Name</strong> and <strong>Country</strong> To <a href="<?=get_domain().$cart_url;?>?module=payment&OId=<?=$order_row['OId'];?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;">our website</a> After you send payment with <strong>Western Union</strong> or <strong>Money Gram</strong> or <strong>Bank Transfer</strong>, thanks!<br /><br />

<a href="<?=get_domain().$cart_url;?>?module=payment&OId=<?=$order_row['OId'];?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;">If you want to payment online, please click here to continue payment &gt;&gt;</a><br /><br />

<?php include($site_root_path.'/inc/lib/mail/order_detail.php');?>

Yours sincerely,<br /><br />

<?=get_domain(0);?> Customer Care Team
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>