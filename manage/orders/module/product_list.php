<form style="background:#fff;height:60px;width:95%;line-height:40px;overflow:hidden;margin-top:20px" action="" method="" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	<div class="y_form"><span class="y_title">订单号：</span><input class="y_title_txt" type="text" name="" value="<?=$order_row['OId']?>"></div>
	<div class="y_form"><span class="y_title">产品名称：</span><input class="y_title_txt" type="text" name="" value="<?=$order_product_name?>"></div>
</form>	
<!-- <form style="background:#fff;min-height:110px;width:95%;overflow:hidden;margin-top:20px"  method="" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">清关及运费</div>
	<div class="y_form2"><span class="y_title">运费：</span><input class="y_title_txt_sm" type="text" name="shippingcharges" value="<?=$order_row['ShippingCharges'];?>">美元（USD）</div>
	<div class="y_form2"><span class="y_title">清关费：</span><input class="y_title_txt_sm" type="text" name="CustomsClearance" value="<?=$order_row['CustomsClearance'];?>">美元（USD）</div>
    <div class="y_form3">
    	<input type="hidden" name="shippingcharges_r" class="form_input" value="shippingcharges_r">
	    <input type="hidden" name="OrderId" value="<?=$OrderId;?>" />
	    <input type="hidden" name="module" value="<?=$module;?>" />
    </div>
</form>	 -->
<form style="background:#fff;min-height:110px;width:95%;overflow:hidden;margin-top:20px"  method="" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">鹰洋仓库位置</div>
	<div class="y_form"><span class="y_title">仓库位置：</span><input class="y_title_txt" type="text" name="LTX" value="<?=$order_row['Stowage'];?>"></div>
    <div class="y_form3"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /></div>
</form>	
<form style="background:#fff;min-height:170px;width:95%;overflow:hidden;margin-top:20px"  method="" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">运输追踪</div>
	<div class="y_form2"><span class="y_title">运单号：</span><input class="y_title_txt_sm" type="text" name="tracking_number_1" value="<?=$stutas_ros['TrackingNumber'];?>"></div>
    <div class="y_form"><span class="y_title">进度追踪：</span><input class="y_title_txt" type="text" name="product_tutas" value="<?=$stutas_ros['ProductStutas'];?>"></div>
    <div class="y_form3"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="product_status_time" value="<?=time()?>"></div>
</form>	
<form style="background:#fff;min-height:50px;width:95%;overflow:hidden;margin-top:20px" action="" method="" class="" enctype="multipart/form-data">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">物流信息</div>
	<div class="y_form1"><span class="y_title">运单号：</span><?=$stutas_ros['TrackingNumber'];?><span class="y_title">运输公司：</span><?=$shipping_row['FirmName']?></div>
	<div class="y_form1">
		<div style="text-align:center;width:250px;font-size:12px;color:rgb(102, 102, 102);font-weight: bold;" class="y_form2">日期和时间</div>
		<div style="text-align:center;width:550px;font-size:12px;color:rgb(102, 102, 102);font-weight: bold;" class="y_form">地点跟追踪进度</div>
	</div>
</form>
<?php for($i=0;$i<count($freight_stutas_row);$i++){?>
<form style="background:#fff;min-height:50px;width:95%;overflow:hidden;margin-top:20px"  method="" name="" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	
	<div class="y_form1">
        <span class="services_1" style=""><input type="hidden" name="StutasTime" value="<?=$freight_stutas_row[$i]['StutasTime']?>"><?=date("Y-m-d H:i:s",$freight_stutas_row[$i]['StutasTime'])?></span>
        <span class="services_2" ><input style="width: 500px;height: 30px;" type="text" name="shipping_status" class="form_input" value="<?=$freight_stutas_row[$i]['ProductStutas'];?>"></span>
        </td><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="shipping_val" value="shipping_status">
                    
  	</div>
</form>
<?php }?>
	
	
	
    
</form>	