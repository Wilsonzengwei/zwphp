<style type="text/css">
	body div{margin:0px;padding: 0px;}
	.radio{
		vertical-align:text-bottom;
		margin-bottom:-1px;
		*margin-bottom:-10px;

	}
	.form_button{
		width: 50px;
	}
</style>
<form method="post" name="act_form" id="act_form" class="act_form" action="view.php" onsubmit="return checkForm(this);">
<table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table">
	<tr>
		<td  width="5%" nowrap colspan="3" style="text-align:center;font-size:20px;"><?=get_lang('orders.order_status_1');?></td>
	</tr>
	<tr>
		<td width="5%" nowrap><?=get_lang('orders.order_number');?>:</td>
		<td width="95%" colspan="2"><?=$order_row['OId'];?></td>
	</tr>
	<tr>
		<td nowrap><?=get_lang('orders.order_status');?>:</td>
		<td colspan="2">
		<?php if($order_row['OrderStatus'] == '1'){?>
		未付款
		<?php }elseif($order_row['OrderStatus'] == '2'){?>
		已付款
		<?php }elseif($order_row['OrderStatus'] == '3'){?>
		开始生产
		<?php }elseif($order_row['OrderStatus'] == '4'){?>
		生产中
		<?php }elseif($order_row['OrderStatus'] == '5'){?>
		生产完成
		<?php }elseif($order_row['OrderStatus'] == '6'){?>
		运输中
		<?php }elseif($order_row['OrderStatus'] == '7'){?>
		客户已签收
		<?php }else{?>
		已完成
		<?php }?>
		</td>
	</tr>
	<!--   付款状态    -->
	<tr>
		<td nowrap><?=get_lang('orders.client_payment_status');?>:</td>
		<td colspan="2">
		<input class="radio" type="radio" name="payment_status" value="1" <?=$order_row['PaymentStatus']==1?'checked':'';?>>未付款
		<input style='margin-left:70px' class="radio" type="radio" name="payment_status" value="2" <?=$order_row['PaymentStatus']==2?'checked':'';?>>
			<?php 
				if($order_row['PaymentStatus']==2){
					$color = "red";
				}else{
					$color = '';
				}
			?>
			<font style="color:<?=$color?>;">已付款</font>

		<input style='margin-left:70px' type="submit" name="payment_status_submit" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="act" value="mod_order_status" />
	</tr>
</form>
	
<!--          商家申请25%预付款          -->
<form method="post" name="Payment_form_1"  action="view.php" onsubmit="return checkForm(this);">
	<tr>
		<td rowspan="2">商家申请30%预付款 :</td>
		<td colspan="2">
			<input type="hidden" name="Payment" value="Payment">
			<input class="radio" type="radio" name="Payment_1" value="1" checked>未付款
			<input style='margin-left:70px' class="radio" type="radio" name="Payment_1" value="2" <?=$factory_order_row['SMApply_1']==2?'checked':'';?>>
			<?php 
				if($factory_order_row['SMApply_1']==2){
					$color = "red";
				}else{
					$color = '';
				}
			?>
			<font style="color:<?=$color?>;">已付款</font>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;金额：&nbsp;<input type="text" style="width: 80px;height: 25px;" name="Advance_1" value="<?=$factory_order_row['Advance_1'];?>">&nbsp;元（人民币）
			<input style='margin-left:70px' type="submit" name="Payment_submit_1" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="act" value="mod_order_status" />
		</td>
	</tr>
</form>

<!--     商家上传预付款收据审核              -->

<form method="post" name="Payment_form"  action="view.php" onsubmit="return checkForm(this);">
	<tr>
		<td>
			<div style="width: 240px;height: 90px; ">
				<div style="float: left;margin-top: 5px;width: 55px;">收据照片:</div>
				<div  id="imgClick_1" style="float: left;margin-left:10px;width: 150px;height: 80px;overflow: hidden;">
				<?php if($factory_order_row['SMPach_1']){
					$factory_order_pach = $factory_order_row['SMPach_1'];
					?>
					<img style="width: 100%;height: 100%;object-fit: cover;" src="<?=htmlspecialchars($factory_order_pach);?>">
				<?php }else{?>
					<img style="width: 100%;height: 100%;object-fit: cover;" src="">
				<?php }?>
				</div>
			</div>
			<div style="width: 700px;height: 50px;">
				<div style="float: left;margin-top: 5px;width: 80px;">收据是否有效:</div>
				<div style="margin-left:10px;width: 450px;height: 80px;overflow: hidden;">
					<div>
						<input type="hidden" name="SMApply_submit" value="SMApply_submit">
						<input class="radio" type="radio" name="SMApply_submit_1" value="2" <?=$factory_order_row['SMApply_submit_1']==2?'checked':'';?>>
						<?php 
							if($factory_order_row['SMApply_submit_1']==2){
								$color = "red";
							}else{
								$color = '';
							}
						?>
						<font style="color:<?=$color?>;">有效</font>
					</div>
					<div>
						<input style='' class="radio" type="radio" name="SMApply_submit_1" value="1" <?=$factory_order_row['SMApply_submit_1']==1?'checked':'';?>>无效
						<font style="font-size: 12px;margin-left: 10px;width: 120px;">无效原因:<input type="text" style="margin-left: 10px;width: 250px;height: 20px;font-size: 12px;" name="invalidcause_1" value="<?=$factory_order_row['Invalidcause_1']?>"></font>
						<input style='margin-left:15px' type="submit" name="SMApply_submit_1_1" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="act" value="mod_order_status" />
					</div>
				</div>
			</div>
		</td>
		
	</tr>
</form>




<!--          是否到达仓库        -->	
	<form  method="post" name="act_SMAffirm"  action="view.php" onsubmit="return checkForm(this);">
		<tr>
			<td nowrap><?=get_lang('orders.arrive_warehouse');?>:</td>
			<td colspan="2">
				<input class="radio" type="radio" name="arrive_warehouse" value="1" <?=$factory_order_row['SMAffirm']==1?'checked':'';?>><?=get_lang('orders.un_get_to');?>
				<input style='margin-left:70px' class="radio" type="radio" name="arrive_warehouse" value="2" <?=$factory_order_row['SMAffirm']==2?'checked':'';?>>
				<?php 
					if($factory_order_row['SMAffirm']==2){
						$color = "red";
					}else{
						$color = '';
					}
				?>
				<font style="color:<?=$color?>;"><?=get_lang('orders.get_to');?></font>
				<input style='margin-left:82px' type="submit" name="arrive_warehouse_submit" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" />
		    </td>

		</tr>
	</form>

<!--          商家申请50%生产金额        -->
<form method="post" name="Payment_form_2"  action="view.php" onsubmit="return checkForm(this);">
	<tr>
		<td rowspan="2">商家申请50%生产金额:</td>
		<td colspan="2">
			<input type="hidden" name="Payment" value="Payment">
			<input class="radio" type="radio" name="Payment_2" value="1" checked>未付款
			<input style='margin-left:70px' class="radio" type="radio" name="Payment_2" value="2" <?=$factory_order_row['SMApply_2']==2?'checked':'';?> >
			<?php 
				if($factory_order_row['SMApply_2']==2){
					$color = "red";
				}else{
					$color = '';
				}
			?>
			<font style="color:<?=$color?>;">已付款</font>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;金额：&nbsp;<input type="text" style="width: 80px;height: 25px;" name="Advance_2" value="<?=$factory_order_row['Advance_2'];?>">&nbsp;元（人民币）
			<input style='margin-left:70px' type="submit" name="Payment_submit_2" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="act" value="mod_order_status" />
		</td>
	</tr>
</form>

<!--     商家上传预付款收据审核           -->

<form method="post" name="Payment_form_3"  action="view.php" onsubmit="return checkForm(this);">
	<tr>
		<td>
			<div style="width: 240px;height: 90px; ">
				<div style="float: left;margin-top: 5px;width: 55px;">收据照片:</div>
				<div  id="imgClick_2" style="float: left;margin-left:10px;width: 150px;height: 80px;overflow: hidden;">
					<?php if($factory_order_row['SMPach_2']){
						$factory_order_pach_2 = $factory_order_row['SMPach_2'];
						?>
						<img style="width: 100%;height: 100%;object-fit: cover;" src="<?=htmlspecialchars($factory_order_pach_2);?>">
					<?php }else{?>
						<img style="width: 100%;height: 100%;object-fit: cover;" src="">
					<?php }?>
				</div>
				</div>
				</div>
			</div>
			<div style="width: 700px;height: 50px;">
				<div style="float: left;margin-top: 5px;width: 80px;">收据是否有效:</div>
				<div style="margin-left:10px;width: 450px;height: 80px;overflow: hidden;">
					<div>
						<input type="hidden" name="SMApply_submit" value="SMApply_submit">
						<input class="radio" type="radio" name="SMApply_submit_2" value="2" <?=$factory_order_row['SMApply_submit_2']==2?'checked':'';?>>
						<?php 
							if($factory_order_row['SMApply_submit_2']==2){
								$color = "red";
							}else{
								$color = '';
							}
						?>
						<font style="color:<?=$color?>;">有效</font>
						
					</div>
					<div>
						<input style='' class="radio" type="radio" name="SMApply_submit_2" value="1" <?=$factory_order_row['SMApply_submit_2']==1?'checked':'';?>>无效
						<font style="font-size: 12px;margin-left: 10px;width: 120px;">无效原因:<input type="text" style="margin-left: 10px;width: 250px;height: 20px;font-size: 12px;" name="invalidcause_2" value="<?=$factory_order_row['Invalidcause_2']?>"></font>
						<input style='margin-left:15px' type="submit" name="SMApply_submit_1_2" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="act" value="mod_order_status" />
					</div>
				</div>
			</div>
		</td>
		
	</tr>
</form>


<!--          客户是否签收        -->	
	<form  method="post" name="act_Signfor"  action="view.php" onsubmit="return checkForm(this);">
		<tr>
			<td nowrap><?=get_lang('orders.sign_for_status');?>:</td>
			<td colspan="2">
				<input class="radio" type="radio" name="Signfor" value="1" <?=$order_row['Signfor']==1?'checked':'';?>>未签收
				<input style='margin-left:70px' class="radio" type="radio" name="Signfor" value="2" <?=$order_row['Signfor']==2?'checked':'';?>>
				<?php 
					if($order_row['Signfor']==2){
						$color = "red";
					}else{
						$color = '';
					}
				?>
				<font style="color:<?=$color?>;">已签收</font>
				<input style='margin-left:70px' type="submit" name="Signfor_submit" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" />
		    </td>

		</tr>
	</form>


<!--          商家申请尾款        -->
<form method="post" name="Payment_form_4"  action="view.php" onsubmit="return checkForm(this);">
	<tr>
		<td rowspan="2">商家申请尾款结算 :</td>
		<td colspan="2">
			<input type="hidden" name="Payment" value="Payment">
			<input class="radio" type="radio" name="Payment_3" value="1" checked>未付款
			<input style='margin-left:70px' class="radio" type="radio" name="Payment_3" value="2" <?=$factory_order_row['SMApply_3']==2?'checked':'';?>>
			<?php 
				if($factory_order_row['SMApply_3']==2){
					$color = "red";
				}else{
					$color = '';
				}
			?>
			<font style="color:<?=$color?>;">已付款</font>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;金额：&nbsp;<input type="text" style="width: 80px;height: 25px;" name="Advance_3" value="<?=$factory_order_row['Advance_3'];?>">&nbsp;元（人民币）
			<input style='margin-left:70px' type="submit" name="Signfor_submit_3" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="act" value="mod_order_status" />
		</td>
	</tr>
</form>

<!--     商家上传预付款收据审核           -->

<form method="post" name="Payment_form_5"  action="view.php" onsubmit="return checkForm(this);">
	<tr>
		<td>
			<div style="width: 240px;height: 90px; ">
				<div style="float: left;margin-top: 5px;width: 55px;">收据照片:</div>
				<div  id="imgClick_3" style="float: left;margin-left:10px;width: 150px;height: 80px;overflow: hidden;">
					<?php if($factory_order_row['SMPach_3']){
						$factory_order_pach_3 = $factory_order_row['SMPach_3'];
						?>
						<img style="width: 100%;height: 100%;object-fit: cover;" src="<?=htmlspecialchars($factory_order_pach_3);?>">
					<?php }else{?>
						<img style="width: 100%;height: 100%;object-fit: cover;" src="">
					<?php }?>
				</div>
				</div>
			</div>
			<div style="width: 700px;height: 50px;">
				<div style="float: left;margin-top: 5px;width: 80px;">收据是否有效:</div>
				<div   style="margin-left:10px;width: 450px;height: 80px;overflow: hidden;">
					<div>
						<input type="hidden" name="SMApply_submit" value="SMApply_submit">
						<input class="radio" type="radio" name="SMApply_submit_3" value="2" <?=$factory_order_row['SMApply_submit_3']==2?'checked':'';?>>
						<?php 
							if($factory_order_row['SMApply_submit_3']==2){
								$color = "red";
							}else{
								$color = '';
							}
						?>
						<font style="color:<?=$color?>;">有效</font>
					</div>
					<div>
						<input style='' class="radio" type="radio" name="SMApply_submit_3" value="1" <?=$factory_order_row['SMApply_submit_3']==1?'checked':'';?>>无效
						<font style="font-size: 12px;margin-left: 10px;width: 120px;">无效原因:<input type="text" style="margin-left: 10px;width: 250px;height: 20px;font-size: 12px;" name="invalidcause_3" value="<?=$factory_order_row['Invalidcause_3']?>"></font>
						<input style='margin-left:15px' type="submit" name="SMApply_submit_1_3" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="act" value="mod_order_status" />
					</div>
				</div>
			</div>
		</td>
		
	</tr>
</form>
</table>
<script language="javascript">change_order_status(<?=$tmpOrderStatus?$tmpOrderStatus:$order_row['OrderStatus'];?>);
</script>

<script type="text/javascript">
	
	$("#imgClick_1").click(function () {
		window.open("<?=htmlspecialchars($factory_order_pach);?>");
	});
	$("#imgClick_2").click(function () {
		window.open("<?=htmlspecialchars($factory_order_pach_2);?>");
	});
	$("#imgClick_3").click(function () {
		window.open("<?=htmlspecialchars($factory_order_pach_3);?>");
	});
</script>