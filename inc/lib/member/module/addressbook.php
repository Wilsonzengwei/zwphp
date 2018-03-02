<?php
$query_string=query_string(array('act', 'AId'));

if($_GET['act']=='del'){
	$AId=(int)$_GET['AId'];
	$db->delete('member_address_book', "$where and AId='$AId' and AddressType=0 and IsDefault=0");
	js_location("$member_url?$query_string");
}

if($_GET['act']=='set_default'){
	$AId=(int)$_GET['AId'];
	if($db->get_row_count('member_address_book', "$where and AddressType=0 and AId='$AId'")){
		$db->update('member_address_book', "$where and AddressType=0",
			array(
				'IsDefault'=>0
			)
		);
		$db->update('member_address_book', "$where and AddressType=0 and AId='$AId'",
			array(
				'IsDefault'=>1
			)
		);
	}
	js_location("$member_url?$query_string");
}

if($_POST['data']=='member_address_book'){
	$act=$_POST['act'];
	$AId=(int)$_POST['AId'];
	$Title=$_POST['Title'];
	$FirstName=$_POST['FirstName'];
	$LastName=$_POST['LastName'];
	$AddressLine1=$_POST['AddressLine1'];
	$AddressLine2=$_POST['AddressLine2'];
	$City=$_POST['City'];
	$State=$_POST['State'];
	$Country=$_POST['Country'];
	$PostalCode=$_POST['PostalCode'];
	$Phone=$_POST['Phone'];
	$AlsoBillingAddress=(int)$_POST['AlsoBillingAddress'];
	
	if($act=='add_shipping_address'){	//添加收货地址
		$db->insert('member_address_book', array(
				'MemberId'		=>	$_SESSION['member_MemberId'],
				'Title'			=>	$Title,
				'FirstName'		=>	$FirstName,
				'LastName'		=>	$LastName,
				'AddressLine1'	=>	$AddressLine1,
				'AddressLine2'	=>	$AddressLine2,
				'City'			=>	$City,
				'State'			=>	$State,
				'Country'		=>	$Country,
				'PostalCode'	=>	$PostalCode,
				'Phone'			=>	$Phone,
				'AddressType'	=>	0
			)
		);
		
		if($AlsoBillingAddress==1){
			$db->update('member_address_book', "$where and AddressType=1", array(
					'Title'			=>	$Title,
					'FirstName'		=>	$FirstName,
					'LastName'		=>	$LastName,
					'AddressLine1'	=>	$AddressLine1,
					'AddressLine2'	=>	$AddressLine2,
					'City'			=>	$City,
					'State'			=>	$State,
					'Country'		=>	$Country,
					'PostalCode'	=>	$PostalCode,
					'Phone'			=>	$Phone
				)
			);
		}
	}else{
		if($AId){	//更新收货地址
			if($AlsoBillingAddress==0){
				$where="$where and AId='$AId' and AddressType=0";
			}else{
				$where="$where and ((AId='$AId' and AddressType=0) or AddressType=1) ";
			}
		}else{	//更新帐单地址
			$where="$where and AddressType=1";
		}
		$db->update('member_address_book', $where, array(
				'Title'			=>	$Title,
				'FirstName'		=>	$FirstName,
				'LastName'		=>	$LastName,
				'AddressLine1'	=>	$AddressLine1,
				'AddressLine2'	=>	$AddressLine2,
				'City'			=>	$City,
				'State'			=>	$State,
				'Country'		=>	$Country,
				'PostalCode'	=>	$PostalCode,
				'Phone'			=>	$Phone
			)
		);
	}
	
	js_location("$member_url?$query_string");
}

if($_GET['act']=='add_shipping_address' || $_GET['act']=='upd_shipping_address' || $_GET['act']=='upd_billing_address'){
	if($_GET['act']=='upd_shipping_address'){	//添加修改收货地址
		$AId=(int)$_GET['AId'];
		$AId && $address_row=$db->get_one('member_address_book', "$where and AddressType=0 and AId='$AId'");
	}elseif($_GET['act']=='upd_billing_address'){
		$address_row=$db->get_one('member_address_book', "$where and AddressType=1");
	}
	
	ob_start();
?>
	<form action="<?=$member_url.'?'.$query_string;?>" method="post" name="add_and_update_shipping_address_form" OnSubmit="return checkForm(this);">
		<div class="item lib_member_item_card">
			<div class="rows">
				<div class="fl">Nombre de pila: <font class="fc_red">*</font><br /><select name="Title">
					<option value="Miss" <?=$address_row['Title']=='Miss'?'selected':'';?>>Perder</option>
					<option value="Mrs" <?=$address_row['Title']=='Mrs'?'selected':'';?>>señora</option>
					<option value="Ms" <?=$address_row['Title']=='Ms'?'selected':'';?>>Sra</option>
					<option value="Mr" <?=$address_row['Title']=='Mr'?'selected':'';?>>Señor</option>
				</select><input name="FirstName" value="<?=htmlspecialchars($address_row['FirstName']);?>" type="text" class="form_input" check="First Name is required!~*" size="14" maxlength="20"></div>
				<div class="fr">Apellido: <font class="fc_red">*</font><br /><input name="LastName" value="<?=htmlspecialchars($address_row['LastName']);?>" type="text" class="form_input" check="Last Name is required!~*" size="22" maxlength="20"></div>
				<div class="clear"></div>
			</div>
			<div class="rows">Dirección Línea 1: <font class="fc_red">*</font><br /><input name="AddressLine1" value="<?=htmlspecialchars($address_row['AddressLine1']);?>" type="text" class="form_input" check="Address Line 1 is required!~*" size="57" maxlength="200"></div>
			<div class="rows">Dirección Línea 2: <br /><input name="AddressLine2" value="<?=htmlspecialchars($address_row['AddressLine2']);?>" type="text" class="form_input" size="57" maxlength="200"></div>
			<div class="rows">
				<div class="fl">Ciudad: <font class="fc_red">*</font><br /><input name="City" value="<?=htmlspecialchars($address_row['City']);?>" type="text" class="form_input" check="City is required!~*" size="25" maxlength="50"></div>
				<div class="fr">Estado: <font class="fc_red">*</font><br /><input name="State" value="<?=htmlspecialchars($address_row['State']);?>" type="text" class="form_input" check="State is required!~*" size="22" maxlength="20"></div>
				<div class="clear"></div>
			</div>
			<div class="rows">País: <font class="fc_red">*</font><br /><?=ouput_table_to_select('country', 'Country', 'Country', 'Country', 'Country asc, CId asc', 0, 1, $address_row['Country'], '', 'Please select Country', 'Please select Country!~*');?></div>
			<div class="rows">
				<div class="fl">código postal: <font class="fc_red">*</font><br /><input name="PostalCode" value="<?=htmlspecialchars($address_row['PostalCode']);?>" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" type="text" class="form_input" check="Postal Code is required!~*" size="10" maxlength="10"></div>
				<div class="fr">Teléfono: <font class="fc_red">*</font><br /><input name="Phone" value="<?=htmlspecialchars($address_row['Phone']);?>" type="text" class="form_input" check="Phone is required!~*" size="22" maxlength="20" /></div>
				<div class="clear"></div>
			</div>
			<?php if($_GET['act']=='add_shipping_address' || $_GET['act']=='upd_shipping_address'){?>
				<div class="rows"><input type="checkbox" name="AlsoBillingAddress" value="1" />Este es también mi dirección de facturación.</div>
			<?php }?>
			<div class="rows button"><input name="Submit" type="submit" class="form_button" value="Save"><input name="Cancel" type="button" class="form_button cancel_button" value="Cancel" onclick="window.location='<?=$member_url.'?'.$query_string;?>';"></div>
		</div>
		<input type="hidden" name="act" value="<?=$_GET['act'];?>" />
		<input type="hidden" name="AId" value="<?=$AId;?>" />
		<input type="hidden" name="data" value="member_address_book" />
	</form>
<?php
	$member_address_book_form=ob_get_contents();
	ob_end_clean();
}
?>
<div id="lib_member_address_book">
	<div class="lib_member_title">Manejo de la libreta de direcciones</div>
	<div class="lib_member_info">Gestiona tu libreta de direcciones a continuación. Si aún no tiene una dirección registrada, haga clic en "Agregar un nuevo envío<br />Dirección "abajo.</div>
	<div>
		<div class="address">
			<div class="t">
				<div class="fl">Dirección de Envío</div>
				<div class="fr"><a href="<?=$member_url.'?'.$query_string;?>&act=add_shipping_address" class="add_new_address">Agregar una nueva dirección de envío</a></div>
			</div>
			<?php
			if($_GET['act']=='add_shipping_address' || $_GET['act']=='upd_shipping_address'){
				echo $member_address_book_form;
			}else{
				$shipping_address=$db->get_all('member_address_book', "$where and AddressType=0", '*', 'IsDefault desc, AId desc');
				for($i=0; $i<count($shipping_address); $i++){
			?>
				<div class="item lib_member_item_card">
					<div class="address_info">
						<strong><?=htmlspecialchars($shipping_address[$i]['Title'].' '.$shipping_address[$i]['FirstName'].' '.$shipping_address[$i]['LastName']);?></strong><br />
						<?=htmlspecialchars($shipping_address[$i]['AddressLine1']);?><br />
						<?=htmlspecialchars($shipping_address[$i]['City']);?><br />
						<?=htmlspecialchars($shipping_address[$i]['State']);?> (código postal: <strong><?=htmlspecialchars($shipping_address[$i]['PostalCode']);?></strong>)<br />
						<?=htmlspecialchars($shipping_address[$i]['Country']);?><br />
						<strong>Teléfono: </strong><?=htmlspecialchars($shipping_address[$i]['Phone']);?>
					</div>
					<div class="opt">
						<a href="<?=$member_url.'?'.$query_string;?>&AId=<?=$shipping_address[$i]['AId'];?>&act=upd_shipping_address">editar</a>
						<?php if($i){?>
							<a href="<?=$member_url.'?'.$query_string;?>&AId=<?=$shipping_address[$i]['AId'];?>&act=del">retirar</a>
							<?php if((int)$_GET['checkout']!=1){?><a href="<?=$member_url.'?'.$query_string;?>&AId=<?=$shipping_address[$i]['AId'];?>&act=set_default">Defina esto como predeterminado</a><?php }?>
						<?php }?>
						<?php if((int)$_GET['checkout']==1){?><a href="<?=$cart_url;?>?module=checkout&AId=<?=$shipping_address[$i]['AId'];?>" class="checkout">continuar con el registro</a><?php }?>
					</div>
				</div>
				<?php if($i==0 && count($shipping_address)>1){?><div><strong>Otras direcciones de envío:</strong></div><?php }?>
				<?php }?>
			<?php }?>
		</div>
		<div class="address billing_address">
			<div class="t">Billing AddressDirección de Envio</div>
			<?php
			if($_GET['act']=='upd_billing_address'){
				echo $member_address_book_form;
			}else{
				$billing_address=$db->get_one('member_address_book', "$where and AddressType=1");
			?>
				<div class="item lib_member_item_card">
					<div class="address_info">
						<?php if($billing_address){?>
							<strong><?=htmlspecialchars($billing_address['Title'].' '.$billing_address['FirstName'].' '.$billing_address['LastName']);?></strong><br />
							<?=htmlspecialchars($billing_address['AddressLine1']);?><br />
							<?=htmlspecialchars($billing_address['City']);?><br />
							<?=htmlspecialchars($billing_address['State']);?> (código postal: <strong><?=htmlspecialchars($billing_address['PostalCode']);?></strong>)<br />
							<?=htmlspecialchars($billing_address['Country']);?><br />
							<strong>Teléfono: </strong><?=htmlspecialchars($billing_address['Phone']);?>
						<?php }?>
					</div>
					<div class="opt"><a href="<?=$member_url.'?'.$query_string;?>&act=upd_billing_address">editar</a></div>
				</div>
			<?php }?>
		</div>
		<div class="clear"></div>
	</div>
</div>