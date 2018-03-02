<?php
$query_string=query_string(array('forgot_success', 'forgot_fail'));

if($_POST['data']=='member_password'){
	if(password($_POST['OldPassword'])!=$_SESSION['member_Password']){
		$_SESSION['password_post']=$_POST;
		js_location("$mobile_url$member_url?password_fail=1&$query_string");
	}
	
	$_SESSION['member_Password']=password($_POST['Password']);
	
	$db->update('member', $where, array(
			'Password'	=>	$_SESSION['member_Password']
		)
	);
	
	js_location("$mobile_url$member_url?password_success=1&$query_string");
}
?>
<div id="lib_member_password">
	<?php if($_GET['password_fail']==1){?>
		<div class="lib_member_msgerror"><img src="/images/lib/member/msg_error.png" align="absmiddle" />&nbsp;&nbsp;<?=$website_language['member'.$lang]['password']['fail']; ?></div>
	<?php }?>
	<div class="lib_member_title"><?=$website_language['member'.$lang]['password']['title1']; ?></div>
	<?php if($_GET['password_success']==1){?>
		<div class="blank15"></div>
		<div class="change_success lib_member_item_card">
			<br /><?=$website_language['member'.$lang]['password']['success']; ?><br /><br /><br />
			<a href="<?=$mobile_url.$member_url;?>?module=index"><strong><?=$website_language['member'.$lang]['password']['return']; ?></strong></a><br /><br />
		</div>
	<?php }else{?>
		<div class="lib_member_info"><?=$website_language['member'.$lang]['password']['title2']; ?></div>
		<div class="form lib_member_item_card">
			<form action="<?=$mobile_url.$member_url.'?'.$query_string;?>" method="post" name="member_password_form" OnSubmit="return checkForm(this);">
				<div class="lib_member_sub_title"><?=$website_language['member'.$lang]['password']['change']; ?></div>
				<div class="rows">
					<label><?=$website_language['member'.$lang]['password']['old']; ?>: <font class="fc_red">*</font></label>
					<span><input name="OldPassword" value="<?=htmlspecialchars($_SESSION['password_post']['OldPassword']);?>" type="password" class="form_input" check="<?=$website_language['member'.$lang]['password']['old_tips']; ?>!~*" size="50" maxlength="20"></span>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="rows">
					<label><?=$website_language['member'.$lang]['password']['new']; ?>: <font class="fc_red">*</font></label>
					<span><input name="Password" value="<?=htmlspecialchars($_SESSION['password_post']['Password']);?>" type="password" class="form_input" check="<?=$website_language['member'.$lang]['password']['new_tips']; ?>!~*" size="50" maxlength="20"></span>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="rows">
					<label><?=$website_language['member'.$lang]['password']['again']; ?>: <font class="fc_red">*</font></label>
					<span><input name="ConfirmPassword" value="<?=htmlspecialchars($_SESSION['password_post']['ConfirmPassword']);?>" type="password" class="form_input" check="<?=$website_language['member'.$lang]['password']['again_tip1']; ?>!~=Password|<?=$website_language['member'.$lang]['password']['again_tip2']; ?>!*" size="50" maxlength="20"></span>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="rows">
					<label></label>
					<span><input name="Submit" type="submit" class="form_button form_button_130" value="<?=$website_language['member'.$lang]['password']['edit']; ?>"></span>
					<div class="clear"></div>
				</div>
				<input type="hidden" name="data" value="member_password" />
			</form>
		</div>
	<?php }?>
</div>
<?php
$_SESSION['password_post']='';
unset($_SESSION['password_post']);
?>