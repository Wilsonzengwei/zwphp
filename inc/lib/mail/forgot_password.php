<?php
ob_start();
?>
Dear <strong><?=htmlspecialchars($fullname);?></strong>:<br /><br />

This is an automated email from <a href="<?=get_domain();?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=get_domain(0);?></a> in response to your request to reset your password. Please do not reply to this email.<br /><br />

<strong>To reset your password and access your <a href="<?=get_domain();?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=get_domain(0);?></a> account, follow these steps:</strong><br /><br />

<div style="font-family:Arial; line-height:180%; padding-left:20px;">1)&nbsp;&nbsp;Click the following link or copy and paste the link into your address bar of your web browser.<br /><a href="<?=get_domain().$member_url;?>?module=forgot&act=2&email=<?=urlencode($EmailEncode);?>&expiry=<?=urlencode($Expiry);?>&act=2&method=email&myname=<?=$myname?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=get_domain().$member_url;?>?module=forgot&amp;email=<?=urlencode($EmailEncode);?>&amp;expiry=<?=urlencode($Expiry);?></a></div><br />
<div style="font-family:Arial; line-height:180%; padding-left:20px;">2)&nbsp;&nbsp;The above link will take you to our "Reset password" page. Fill in the appropriate fields and click "Submit", you will then be able to access your account now.</div><br />

If you have any queries, please email our Customer Care Team.<br /><br />

Yours sincerely,<br /><br />

<?=get_domain(0);?> Customer Care Team
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>