<?php
$Email = addslashes($_GET['Email']);
if($member_row = $db->get_one('member',"Email='$Email' and IsConfirm=0")){
	$Confir_Email = 1;
	$db->update('member',"Email='$Email' and IsConfirm=0",array('IsConfirm'=>1));
	include($site_root_path.'/inc/lib/mail/create_account.php');
	include($site_root_path.'/inc/lib/mail/template.php');
	sendmail($member_row['Email'], $member_row['Supplier_Name2'], 'Welcome to '.get_domain(), $mail_contents);
}
?>
<div id="customer">
	<div class="global">
		<div class="cus_left">
			<div class="supplier_tips">
				<?php /*
				<?=$website_language['member'.$lang]['login']['tips3']; ?><br />
				<a href="/" class="return trans5"><?=$website_language['member'.$lang]['login']['return']; ?></a>*/ ?>
				<?=$Confir_Email ? $website_language['member'.$lang]['login']['tips7'] : $website_language['member'.$lang]['login']['tips8']; ?><br />
				<a href="/account.php" class="return fl"><?=$website_language['member'.$lang]['login']['tips9']; ?></a>
			</div>
		</div>
		<div class="cus_right">
			<div class="content">
				<div class="title"><?=$website_language['member'.$lang]['login']['rig1']; ?></div>
				<a href="<?=$member_url; ?>?&module=create" class="sign_in trans5" title="<?=$website_language['member'.$lang]['login']['rig2']; ?>"><?=$website_language['member'.$lang]['login']['rig2']; ?></a>
			</div>
			<div class="content">
				<div class="title"><?=$website_language['member'.$lang]['login']['rig3']; ?></div>
				<a href="" class="list"><?=$website_language['member'.$lang]['login']['rig4']; ?></a>
				<a href="" class="list"><?=$website_language['member'.$lang]['login']['rig5']; ?></a>
				<a href="" class="list"><?=$website_language['member'.$lang]['login']['rig6']; ?></a>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
$_SESSION['login_post']='';
unset($_SESSION['login_post']);
?>