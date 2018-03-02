<form style="background:#fff;min-height:110px;width:95%;overflow:hidden;margin-top:20px"  method="post" action="view.php" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	<!-- 运输清关 -->
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">运输及清关标准</div>
	<div class="y_form"><span class="y_title">订单号：</span><input class="y_title_txt" type="text" name="" value="<?=$order_row['OId'];?>"></div>
	<div class="y_form"><span class="y_title">产品名称：</span><input class="y_title_txt" type="text" name="" value="<?=$order_product_name;?>"></div>
	<!-- <div class="y_form"><span class="y_title">重量标准：</span><input class="y_title_txt_sm2" type="text" name="shippingcharges" value="<?=$order_row['ShippingCharges'];?>"><span style="display:inline-block;float:right;margin-right:33px"> 例：100件/10KG</span></div>
	<div class="y_form"><span class="y_title">体积标准：</span><input class="y_title_txt_sm2" type="text" name="CustomsClearance" value="<?=$order_row['CustomsClearance'];?>"><span style="display:inline-block;float:right;margin-right:33px"> 例：100件/m³</span></div> -->
    <div class="y_form3">
    	<input type="hidden" name="shippingcharges_r" class="form_input" value="shippingcharges_r">
	    <input type="hidden" name="OrderId" value="<?=$OrderId;?>" />
	    <input type="hidden" name="module" value="<?=$module;?>" />
    </div>
    <div class="y_form"><span class="y_title">总重量：</span><input class="y_title_txt_sm2" type="text" name="Weight" value="<?=$order_row['Weight'];?>">KG</div>
	<div class="y_form"><span class="y_title">总体积：</span><input class="y_title_txt_sm2" type="text" name="Volume" value="<?=$order_row['Volume'];?>">m³</div>
	<div class="y_form"><span class="y_title">清关费用：</span><input class="y_title_txt_sm2" type="text" name="QPrice" value="<?=$order_row['QPrice'];?>">USD</div>
    <div class="y_submit">
    	<input type="submit" value="保存" name="submit" class="ys_input">
	</div>
	
</form>	
<!-- <form style="background:#fff;min-height:110px;width:95%;overflow:hidden;margin-top:20px"  method="post" action="view.php" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">鹰洋代理运输清关费用</div>
	<div class="y_form"><span class="y_title">空运费用：</span><input class="y_title_txt_sm2" type="text" name="KPrice" value="<?=$order_row['KPrice'];?>"><span class='susd'>美元（USD)</span></div>
	<div class="y_form"><span class="y_title">海运费用：</span><input class="y_title_txt_sm2" type="text" name="HPrice" value="<?=$order_row['HPrice'];?>"><span class='susd'>美元（USD)</span></div>
	<div class="y_form"><span class="y_title">清关费用：</span><input class="y_title_txt_sm2" type="text" name="QPrice" value="<?=$order_row['QPrice'];?>"><span class='susd'>美元（USD)</span></div>
    <div class="y_submit">
    	<input type="hidden" name="Trans_Clert" class="form_input" value="Trans_Clert">
	    <input type="hidden" name="OrderId" value="<?=$OrderId;?>" />
	    <input type="hidden" name="module" value="<?=$module;?>" />
    	<input type="submit" value="保存" name="submit" class="ys_input">
	</div>
</form>	 -->