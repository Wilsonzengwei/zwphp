<?php
ob_start();
?>
Dear <strong><?=htmlspecialchars($member_row['Supplier_Name2']);?></strong>:<br /><br />

This is an automated email from <a href="<?=get_domain();?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=get_domain(0);?></a>. Please do not reply to this email.<br /><br />
Thanks for choosing <?=get_domain(0);?>.<br /><br />

You have been a member of our company and welcome to join us to enjoy the convenient and safe shopping experience. Your account information is as follows:<br />
-------------------------------------------------------------------------------------------<br />
<?php /*<div style="height:24px; line-height:24px; clear:both;">
	<div style="float:left; width:92px;">Your Username</div>
	<div style="float:left; width:400px;">: <?=htmlspecialchars($_SESSION['member_FirstName'].' '.$_SESSION['member_LastName']);?></div>
</div>
<div style="height:24px; line-height:24px; clear:both;">
	<div style="float:left; width:92px;">Your E-mail</div>
	<div style="float:left; width:400px;">: <?=htmlspecialchars($_SESSION['member_Email']);?></div>
</div>
<div style="height:24px; line-height:24px; clear:both;">
	<div style="float:left; width:92px;">Your Password</div>
	<div style="float:left; width:400px;">: ********</div>
</div><br /><br />*/ ?>

Please click the following link or copy and paste the link into your address bar of your web browser to shopping:<br />
<a href="<?=get_domain();?>" target="_blank" style="font-family:Arial; color:#1E5494; text-decoration:underline; font-size:12px;"><strong><?=get_domain();?></strong></a><br /><br />

Yours sincerely,<br /><br />

<?=get_domain(0);?> Customer Care Team
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>