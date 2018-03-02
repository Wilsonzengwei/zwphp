<?php
$shipping_address=$db->get_one('member_address_book', "$where and AddressType=0 and IsDefault=1");
$billing_address=$db->get_one('member_address_book', "$where and AddressType=1");
$member_row=$db->get_one('member',$where);
?>
<div id="lib_member_index">
	<div class="lib_member_title"><?=$website_language['member'.$lang]['index']['welcome']; ?> <?=htmlspecialchars($_SESSION['member_FirstName'].' '.$_SESSION['member_LastName']);?><div class="fr" style="margin-right:100px;"></div></div>
	<div class="lib_member_info"><?=$website_language['member'.$lang]['index']['welcome_tips']; ?></div>
	<div>
		<div class="item_card">
			<div class="title"><?=$website_language['member'.$lang]['index']['account']; ?></div>
			<div class="info lib_member_item_card" style="height: 187px;">
				<strong><?=$website_language['member'.$lang]['index']['email']; ?>: </strong><?=htmlspecialchars($_SESSION['member_Email']);?><br />
				<?php /*if(!$lang){ ?><strong><?=$website_language['member'.$lang]['index']['title']; ?>: </strong><?=htmlspecialchars($_SESSION['member_Title']);?><br /><?php }*/ ?>
				<strong><?=$website_language['member'.$lang]['index']['first_name']; ?>: </strong><?=htmlspecialchars($_SESSION['member_FirstName']);?><br />
				<strong><?=$website_language['member'.$lang]['index']['last_name']; ?>: </strong><?=htmlspecialchars($_SESSION['member_LastName']);?><br />
				<strong><?=$website_language['member'.$lang]['other']['name']; ?>: </strong><?=$member_row['Supplier_Name2']; ?><br />
				<strong><?=$website_language['member'.$lang]['other']['phone']; ?>: </strong><?=$member_row['Supplier_Phone']; ?><br />
				<strong><?=$website_language['member'.$lang]['other']['mobile']; ?>: </strong><?=$member_row['Supplier_Mobile']; ?><br />
				<strong><?=$website_language['member'.$lang]['other']['addr']; ?>: </strong><?=$member_row['Supplier_Address'.$lang]; ?><br />
                <div class="blank9"></div>
				<div><input type="button" value="<?=$website_language['member'.$lang]['index']['edit']; ?> >>" class="form_button" onclick="window.location='<?=$member_url;?>?module=profile';" /></div>
			</div>
		</div>
		<?php /*<div class="item_card">
			<div class="title">Order History</div>
			<div class="info lib_member_item_card">
				<a href="<?=$member_url;?>?module=orders&act=list">All Orders</a> <span>(<?=$db->get_row_count('orders', "$where");?>)</span><br />
				<?php foreach($order_status_ary as $key=>$value){?>
					<a href="<?=$member_url;?>?module=orders&status=<?=$key;?>&act=list"><?=$value;?></a> <span>(<?=$db->get_row_count('orders', "$where and OrderStatus='$key'");?>)</span><br />
				<?php }?>
			</div>
		</div>
		<div class="blank12"></div>
		
		<div class="item_card">
			<div class="title">Your Shipping Address</div>
			<div class="info lib_member_item_card">
				<?php if($shipping_address){?>
					<strong><?=htmlspecialchars($shipping_address['Title'].' '.$shipping_address['FirstName'].' '.$shipping_address['LastName']);?></strong><br />
					<?=htmlspecialchars($shipping_address['AddressLine1']);?><br />
					<?=htmlspecialchars($shipping_address['City']);?><br />
					<?=htmlspecialchars($shipping_address['State']);?> (Postal Code: <strong><?=htmlspecialchars($shipping_address['PostalCode']);?></strong>)<br />
					<?=htmlspecialchars($shipping_address['Country']);?><br />
					<strong>Phone: </strong><?=htmlspecialchars($shipping_address['Phone']);?>
				<?php }?>
				<div class="blank6"></div>
				<div><input type="button" value="Edit >>" class="form_button" onclick="window.location='<?=$member_url;?>?module=addressbook&AId=<?=$shipping_address['AId'];?>&act=upd_shipping_address';" /><a href="<?=$member_url;?>?module=addressbook&act=add_shipping_address" class="add_shipping_address">Add a new shipping address</a></div>
			</div>
		</div>
		<div class="item_card">
			<div class="title">Your Billing Address</div>
			<div class="info lib_member_item_card">
				<?php if($billing_address){?>
					<strong><?=htmlspecialchars($billing_address['Title'].' '.$billing_address['FirstName'].' '.$billing_address['LastName']);?></strong><br />
					<?=htmlspecialchars($billing_address['AddressLine1']);?><br />
					<?=htmlspecialchars($billing_address['City']);?><br />
					<?=htmlspecialchars($billing_address['State']);?> (Postal Code: <strong><?=htmlspecialchars($billing_address['PostalCode']);?></strong>)<br />
					<?=htmlspecialchars($billing_address['Country']);?><br />
					<strong>Phone: </strong><?=htmlspecialchars($billing_address['Phone']);?>
				<?php }?>
				<div class="blank6"></div>
				<div><input type="button" value="Edit >>" class="form_button" onclick="window.location='<?=$member_url;?>?module=addressbook&act=upd_billing_address';" /></div>
			</div>
		</div>*/ ?>
	</div>
</div>