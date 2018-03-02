<div id="lib_member_menu" class="lib_member_item_card">
	<dl>
		<dt><?=$website_language['member'.$lang]['menu']['detail']; ?></dt>
			<dd><a href="<?=$mobile_url.$member_url;?>?module=index"><?=$website_language['member'.$lang]['menu']['account']; ?></a></dd>
			<dd><a href="<?=$mobile_url.$member_url;?>?module=profile"><?=$website_language['member'.$lang]['menu']['edit_account']; ?></a></dd>
			<dd><a href="<?=$mobile_url.$member_url;?>?module=password"><?=$website_language['member'.$lang]['menu']['edit_pwd']; ?></a></dd>
			<dd class="clear_line"></dd>
		<?php /*<dt>delivery details</dt>
			<dd><a href="<?=$mobile_url.$member_url;?>?module=addressbook">Manage Address Book</a></dd>
			<dd class="clear_line"></dd>*/ ?>
		<dt><?=$website_language['member'.$lang]['menu']['order_list']; ?></dt>
			<dd><a href="<?=$mobile_url.$member_url;?>?module=orders&act=list"><?=$website_language['member'.$lang]['menu']['my_order']; ?></a></dd>
			<?php/* foreach($order_status_ary as $key=>$value){?>
				<dd><a href="<?=$mobile_url.$member_url;?>?module=orders&status=<?=$key;?>&act=list"><?=$value;?></a></dd>
			<?php }*/ ?>
			<dd class="clear_line"></dd>
		<dt><?=$website_language['member'.$lang]['menu']['shopping']; ?></dt>
			<dd><a href="<?=$mobile_url.$member_url;?>?module=wishlists"><?=$website_language['member'.$lang]['menu']['favor']; ?></a></dd>
			<dd class="clear_line"></dd>
		<dt><?=$website_language['member'.$lang]['menu']['sign_out']; ?></dt>
			<dd><a href="<?=$mobile_url.$member_url;?>?module=logout"><?=$website_language['member'.$lang]['menu']['sign_out']; ?></a></dd>
	</dl>
</div>