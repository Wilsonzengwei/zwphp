<?php
ob_start();
?>
<div style="width:700px; margin:10px auto;">
	<table width="700" border="0" cellspacing="0" cellpadding="0" style="border-bottom:2px solid #999;">
		<tr>
			<td width="350" style="padding-bottom:8px;"><a href="<?=get_domain();?>" target="_blank"><img src="<?=get_domain();?>/images/logo.gif" border="0" /></a></td>
			<td width="350" align="right" valign="bottom" style="padding-bottom:8px;">
				<div style="text-align:right; font-size:9px; font-family:Arial; color:#333; height:25px; width:100%;"><?=date('m/d/Y H:i:s', $service_time);?></div>
				<a href="<?=get_domain();?>" target="_blank" style="font-size:11px; margin-left:12px; text-decoration:underline; color:#1E5494; font-family:Verdana;">Home</a>
				<a href="<?=get_domain().$member_url;?>" target="_blank" style="font-size:11px; margin-left:12px; text-decoration:underline; color:#1E5494; font-family:Verdana;">My Account</a>
				<a href="<?=get_domain();?>/contact-us.html" target="_blank" style="font-size:11px; margin-left:12px; text-decoration:underline; color:#1E5494; font-family:Verdana;">Contact Us</a>
			</td>
		</tr>
	</table>
	<div style="font-family:Arial; padding:15px 0; line-height:150%; min-height:100px; _height:100px; color:#333; font-size:12px;"><?=$mail_contents;?></div>
	<div style="padding:20px 0; line-height:180%; font-family:Arial; font-size:11px; color:#000; border-top:1px solid #ccc; border-bottom:1px solid #ccc;">
		You have received this email because you are a registered member of the <?=get_domain(0);?> website.<br />
		For further information, log in to your account at: <a href="<?=get_domain();?>" target="_blank" style="font-family:Arial; font-size:11px; color:#1E5494; text-decoration:underline;"><?=get_domain();?></a> and submit your request or use live chat.
	</div>
</div>
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>