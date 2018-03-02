<form method="post" name="act_form" id="act_form" class="act_form" action="view.php" onsubmit="return checkForm(this);">
<table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table">
	<tr>
		<td  width="5%" nowrap colspan="2" style="text-align:center;font-size:20px;"><?=get_lang('orders.order_status');?></td>
	</tr>
	<tr>
		<td width="5%" nowrap><?=get_lang('orders.order_number');?>:</td>
		<td width="95%"><?=$order_row['OId'];?></td>
	</tr>
	<?=$payment_info_detail;?>
	<tr>
		<td nowrap><?=get_lang('orders.order_status');?>:</td>
		<td><?php if(get_cfg('orders.mod')){?><select name="OrderStatus" id="OrderStatus" onchange="change_order_status(this.value);" class="form_select">
			<?php
			foreach($order_status_ary as $key=>$value){
				$s=($tmpOrderStatus?$tmpOrderStatus:$order_row['OrderStatus'])==$key?'selected':'';
			?>
				<option value="<?=$key;?>" <?=$s;?>><?=$value;?></option>
			<?php }?>
		</select><?php }else{?><?=$order_status_ary[$order_row['OrderStatus']];?><?php }?></td>
	</tr>
	
	
	<tr>
		<td nowrap><?=get_lang('orders.arrive_warehouse');?>:</td>
		<td>
			<select name="arrive_warehouse"  class="form_select">
	            <option value="1" <?=$factory_order_row['SMAffirm']==1?'selected':'';?>><?=get_lang('orders.un_get_to');?></option>
	            <option value="2" <?=$factory_order_row['SMAffirm']==2?'selected':'';?>><?=get_lang('orders.get_to');?></option>
	        </select>
	    </td>
	</tr>
	<?php /*<?php if($order_product_weight==1){?>
		<tr id="shipping_info_0" style="display:none;">
			<td nowrap><?=get_lang('orders.weight');?>:</td>
			<td><?=$upd_weight_link;?></td>
		</tr>
	<?php }?>

	<tr id="shipping_info_1" style="display:none;">
		<td nowrap><?=get_lang('orders.shipping_method');?>:</td>
		<td><?=$upd_express_link;?></td>
	</tr>
	<tr id="shipping_info_2" style="display:none;">
		<td nowrap><?=get_lang('orders.shipping_charges');?>:</td>
		<td><?=get_lang('ly200.price_symbols').$order_row['ShippingPrice'];?></td>
	</tr>*/ ?>
	
	
	<tr>
		<td width="5%" nowrap>跟进人:</td>
		<td width="95%"><input type="text" name="FollowUp" class="form_input" value="<?=$order_row['FollowUp'];?>"></td>
	</tr>
	
	




	<?php if(get_cfg('orders.mod')){?>
		<tr>
			
			<td colspan="2" style="text-align:center;font-size:20px;"><input type="Submit" name="submit" value="<?=get_lang('ly200.mod');?>" class="form_button"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="act" value="mod_order_status" /></td>
		</tr>
	<?php }?>
</form>


<!--          客户付款状态                 -->
	<tr>
		<td  width="5%" nowrap colspan="2" style="text-align:center;font-size:20px;"><?=get_lang('orders.client_payment_status');?></td>
	</tr>
	<form method="post" name="act_form_2"  action="view.php" onsubmit="return checkForm(this);">
		<tr>
			<td nowrap><?=get_lang('orders.client_payment_status');?>:</td>
			<td><?php if(get_cfg('orders.mod')){?>
				<select name="payment_status" onchange="change_admin_group(this.value);" class="form_select">
		            <option value="2" <?=$order_row['PaymentStatus']==2?'selected':'';?>><?=get_lang('orders.non_payment');?></option>
		            <option value="1" <?=$order_row['PaymentStatus']==1?'selected':'';?>><?=get_lang('orders.account_paid');?></option>
		        </select>
				&nbsp;&nbsp;<input type="submit" name="payment_status" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" />
			<?php }?></td>
		</tr>
	</form>


	<!--          商家状态                 -->
	
	<tr>
		<td  width="5%" nowrap colspan="2" style="text-align:center;font-size:20px;"><?=get_lang('orders.group_status');?></td>
	</tr>
	<tr>
		<td nowrap><?=get_lang('orders.application_for_deposit');?>:</td>
		<td><?php 
				if($factory_order_row['SMApply_1'] == '1' 
				&& $factory_order_row['SMApply_2'] == null
				&& $factory_order_row['SMApply_3'] == null){
					$factory_order_describe = '申请订单总金额的25%预付款进行生产。';
				}else if($factory_order_row['SMApply_1'] == '1' 
				&& $factory_order_row['SMApply_2'] == '1'
				&& $factory_order_row['SMApply_3'] == null){
					$factory_order_describe = '申请订单总金额的50%第二段生产款进行生产。';
				}else if($factory_order_row['SMApply_1'] == '1' 
				&& $factory_order_row['SMApply_2'] == '1'
				&& $factory_order_row['SMApply_3'] == "1"){
					$factory_order_describe = '申请尾款结算。';
				}else{
					$factory_order_describe = '商家未申请预付款。';
				}
			?>
			<?=$factory_order_describe;?>
		</td>
	</tr>
	<?php if($factory_order_row['SMApply_submit_1']){
		if($factory_order_row['SMApply_1'] == '1' 
			&& $factory_order_row['SMApply_2'] == null
			&& $factory_order_row['SMApply_3'] == null
			){
			$factory_order_pach = $factory_order_row['SMPach_1'];
			$SMApply_submit = "SMApply_submit_1";
		}else if($factory_order_row['SMApply_2'] == '1'
			&& $factory_order_row['SMApply_1'] == '1'
			&& $factory_order_row['SMApply_3'] == null){
			$factory_order_pach = $factory_order_row['SMPach_2'];
			$SMApply_submit = "SMApply_submit_2";
		}else if($factory_order_row['SMApply_3'] == '1'
			&& $factory_order_row['SMApply_1'] == '1'
			&& $factory_order_row['SMApply_2'] == '1'){
			$SMApply_submit = "SMApply_submit_3";
			$factory_order_pach = $factory_order_row['SMPach_3'];
		}else{
			$SMApply_submit = "";
			$factory_order_pach = "";
		}
		?>
		<?php if($factory_order_pach){?>
		<tr>
			<td nowrap><?=get_lang('orders.receipt_pach');?>:</td>
			<td >
				<div id="imgClick" style="width: 100px;height: 40px;overflow: hidden;">
					<img style="width: 100%;height: 100%;object-fit: cover;" src="<?=htmlspecialchars($factory_order_pach);?>">
				</div>
			</td>
		</tr>
	<form method="post" name="act_form_3"  action="view.php" onsubmit="return checkForm(this);">
		<tr>
			<td nowrap><?=get_lang('orders.confirm_receipt');?>:</td>
			<td >
				<input type="hidden" name="SMApply_submit" value="<?=$SMApply_submit;?>">
				<select name="factory_order_row" class="form_select">
		            <option value="1" <?=$factory_order_row[$SMApply_submit]==1?'selected':'';?>><?=get_lang('orders.unconfirmed');?></option>
		            <option value="2" <?=$factory_order_row[$SMApply_submit]==2?'selected':'';?>><?=get_lang('orders.confirmed');?></option>
		        </select>
		        &nbsp;&nbsp;<input type="submit" name="factory_order_row" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" />
			</td>
		</tr>

	</form>
	<form method="post" name="act_form_5"  action="view.php" onsubmit="return checkForm(this);">
		<tr>
			<td width="5%" nowrap>鹰洋仓库位置:</td>
			<td width="95%"><input type="text" name="LTX" class="form_input" value="<?=$order_row['Stowage'];?>">&nbsp;&nbsp;<input type="submit" name="factory_order_row" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /></td>
		</tr>
	</form>
		<!-- <div id="imgdiv" style="position: fixed;z-index: 2;top:50%;left: 50%;-webkit-transform: translate(-50%, -50%);
	  		transform: translate(-50%, -50%);border: 1px solid #777;display: none;">
	  		<div id="closeClick" style="position: absolute;right: 0;top: 0;font-size: 30px;width: 35px;height: 35px;text-align: center;font-weight: bold;cursor: pointer;background: #000;color: #fff;border-radius: 30px">×</div>
			<img style="width: 100%;" src="<?=htmlspecialchars($factory_order_pach);?>">
		</div> -->
		<?php }?>
	<?php }?>


	<!--        运输追踪                 
	<tr>
		<td  width="5%" nowrap colspan="2" style="text-align:center;font-size:20px;"><?=get_lang('orders.transport_tracking');?></td>
	</tr>
	<form method="post" name="act_form_4"  action="view.php" onsubmit="return checkForm(this);">
	<tr>
		<td nowrap><?=get_lang('orders.track_progress');?>:</td>
		<td><input type="hidden" name="product_status_time" value="<?=time()?>"><input name="product_tutas" type="text" size="20" value="<?=$stutas_ros['ProductStutas'];?>" class="form_input" style="width: 500px;" /></td>
	</tr>
	<tr>
		<td nowrap><?=get_lang('orders.tracking_number_1');?>:</td>
		<td><input name="tracking_number_1" type="text" size="20" value="<?=$stutas_ros['TrackingNumber'];?>" class="form_input" /></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center; ">
			<input type="submit" name="factory_order_row" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" />
		</td>
	</tr>
	</form> -->



	<!--          运输及清关费用                 -->
	<tr>
		<td  width="5%" nowrap colspan="2" style="text-align:center;font-size:20px;"><?=get_lang('shipping.modelname_CustomsClearance');?></td>
	</tr>
	<form method="post" name="act_form_4"  action="view.php" onsubmit="return checkForm(this);">
	<tr>
		<td nowrap><?=get_lang('shipping.modelname');?>:</td>
		<td><input name="shippingcharges" type="text" size="20" value="<?=$order_row['ShippingCharges'];?>" class="form_input" style="width: 100px;" /></td>
	</tr>
	<tr>
		<td nowrap><?=get_lang('shipping.CustomsClearance');?>:</td>
		<td><input name="CustomsClearance" type="text" size="20" value="<?=$order_row['CustomsClearance'];?>" class="form_input" style="width: 100px;" /></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center; ">
			<input type="submit" name="factory_order_row" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" />
		</td>
	</tr>
	</form>
</table>
<script language="javascript">change_order_status(<?=$tmpOrderStatus?$tmpOrderStatus:$order_row['OrderStatus'];?>);
</script>

<script type="text/javascript">
	
	$("#imgClick").click(function () {
		window.open("<?=htmlspecialchars($factory_order_pach);?>");
	});
	
</script>