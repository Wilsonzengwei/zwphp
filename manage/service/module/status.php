<form style="background:#fff;height:60px;width:95%;line-height:40px;overflow:hidden;margin-top:20px" action="" method="" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    <div class="y_form"><span class="y_title">订单号：</span><input class="y_title_txt" type="text" name="" value="<?=$order_row['OId']?>"></div>
    <div class="y_form"><span class="y_title">产品名称：</span><input class="y_title_txt" type="text" name="" value="<?=$order_product_name?>"></div>
</form>
<form style="background:#fff;height:110px;width:95%;overflow:hidden;margin-top:20px" action="view.php" method="post" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
     <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">生成订单</div>
    <div class="y_form"><span class="y_title">客户付款状态：</span>
        <a class="y_input"><input class="input_r" type="radio" value="2" name="payment_status" id="" <?=$order_row['PaymentStatus']==2?'checked':'';?>><span class='input_s'>已付</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="payment_status" id="" <?=$order_row['PaymentStatus']==1?'checked':'';?>><span class='input_s' >未付</span></a>
    </div>
    <div class="y_form3"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="act" value="mod_order_status" /><input type="submit" value="提交" name="submit" class="ys_input"></div>
    

</form> 
<form style="background:#fff;height:450px;width:95%;overflow:hidden;margin-top:20px" action="view.php" method="post" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
     <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">开始生产</div>
    <div class="y_form"><span class="y_title">预付款状态：</span>
        <a class="y_input"><input class="input_r" type="radio" value="2" name="Payment_1" <?=$factory_order_row['SMApply_1']==2?'checked':'';?> ><span class='input_s' >已付</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="Payment_1" <?=$factory_order_row['SMApply_1']==1?'checked':'';?> ><span class='input_s'>未付</span></a>
    </div>
    <div class="y_form"><span class="y_title">付款金额：</span><input class="y_title_txt_sm" type="text" name="Advance_1" value="<?=$factory_order_row['Advance_1'];?>">元（RMB）</div>
    <div style="width:100%;margin-top:20px;float:left;position:relative">
        <span style="position:absolute;top:0px" class="y_title">收据图片：</span>
        <span style="display:inline-block;width:300px;height:150px;border:1px solid #ccc;border-radius:3px;margin-left:115px;overflow:hidden">
        <?php if($factory_order_row['SMPach_1']){
            $factory_order_pach = $factory_order_row['SMPach_1'];
            ?>
            <a style="display:inline-block;width:95%;height:90%;padding:10px;background: url(<?=$factory_order_pach?>) no-repeat;" id="img_list_<?=$i;?>" href="<?=str_replace('s_', '', $factory_order_pach);?>" target="_blank" href=""></a>
        <?php }else{?>
            <a style="display:inline-block;width:95%;height:90%;padding:10px" href="">背景</a>
        <?php }?>

        </span>
    </div>
    <div class="y_form"><span class="y_title">是否有效：</span>

        <a class="y_input"><input class="input_r" type="radio" value="2" name="SMApply_submit_1" id="" <?=$factory_order_row['SMApply_submit_1']==2?'checked':'';?>><span class='input_s'>有效</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="SMApply_submit_1" id="" <?=$factory_order_row['SMApply_submit_1']==1?'checked':'';?>><span class='input_s'>无效</span></a>
    </div>
    <div class="y_form1"><span class="y_title">备注：</span><input class="y_title_txt" type="text" name="invalidcause_1" value="<?=$factory_order_row['Invalidcause_1']?>"></div>
    <input type="hidden" name="OrderId" value="<?=$OrderId;?>" />
    <input type="hidden" name="SMApply_submit1" value="SMApply_submit1">
    <input type="hidden" name="module" value="<?=$module;?>" />
    <div class="y_submit">
        <input class="ys_input" type="submit" value="提交">
    </div> 
</form> 
<form style="background:#fff;height:110px;width:95%;overflow:hidden;margin-top:20px" action="view.php" method="post" class="act_form" enctype="multipart/form-data">
     <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">生产完成</div>
    <div class="y_form"><span class="y_title">是否到达仓库：</span>
        <a class="y_input"><input class="input_r" type="radio" value="2" name="arrive_warehouse" id="" <?=$factory_order_row['SMAffirm']==2?'checked':'';?>><span class='input_s'>已到</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="arrive_warehouse" id="" <?=$factory_order_row['SMAffirm']==1?'checked':'';?>><span class='input_s'>未到</span></a>
        
    </div>
   <div class="y_form3"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="submit" value="提交" name="submit" class="ys_input"></div>
</form> 
<form style="background:#fff;height:450px;width:95%;overflow:hidden;margin-top:20px" action="view.php" method="post" class="act_form" enctype="multipart/form-data">
     <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">运输中</div>
    <div class="y_form"><span class="y_title">生产金额状态：</span>
        <a class="y_input"><input class="input_r" type="radio" value="2" name="Payment_2" <?=$factory_order_row['SMApply_2']==2?'checked':'';?>><span class='input_s'>已付</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="Payment_2" <?=$factory_order_row['SMApply_2']==1?'checked':'';?>><span class='input_s'>未付</span></a>
    </div>
    <div class="y_form"><span class="y_title">付款金额：</span><input class="y_title_txt_sm" type="text" name="Advance_2" value="<?=$factory_order_row['Advance_2'];?>">元（RMB）</div>
    <div style="width:100%;margin-top:20px;float:left;position:relative">
        <span style="position:absolute;top:0px" class="y_title">收据图片：</span>
        <span style="display:inline-block;width:300px;height:150px;border:1px solid #ccc;border-radius:3px;margin-left:115px;overflow:hidden">
        <?php if($factory_order_row['SMPach_2']){
            $factory_order_pach = $factory_order_row['SMPach_2'];
            ?>
            <a style="display:inline-block;width:95%;height:90%;padding:10px;background: url(<?=$factory_order_pach?>) no-repeat;" id="img_list_<?=$i;?>" href="<?=str_replace('s_', '', $factory_order_pach_2);?>" target="_blank" href=""></a>
        <?php }else{?>
            <a style="display:inline-block;width:95%;height:90%;padding:10px" href=""></a>
        <?php }?>
        </span>
    </div>
    <div class="y_form"><span class="y_title">是否有效：</span>
        <input type="hidden" name="SMApply_submit" value="SMApply_submit">
        <a class="y_input"><input class="input_r" type="radio" value="2" name="SMApply_submit_2" id="" <?=$factory_order_row['SMApply_submit_2']==2?'checked':'';?>><span class='input_s'>有效</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="SMApply_submit_2" id="" <?=$factory_order_row['SMApply_submit_2']==1?'checked':'';?>><span class='input_s'>无效</span></a>
    </div>
    <div class="y_form1"><span class="y_title">备注：</span><input class="y_title_txt" type="text" name="invalidcause_2" value="<?=$factory_order_row['Invalidcause_2']?>"></div>
    <input type="hidden" name="OrderId" value="<?=$OrderId;?>" />
    <input type="hidden" name="SMApply_submit2" value="SMApply_submit2">
    <input type="hidden" name="module" value="<?=$module;?>" />
    <div class="y_submit">
        <input class="ys_input" type="submit" value="提交">
    </div> 
</form> 
<form style="background:#fff;height:130px;width:95%;overflow:hidden;margin-top:20px" action="view.php" method="post" class="act_form" enctype="multipart/form-data">
     <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">客户签收</div>
    <div class="y_form"><span class="y_title">客户是否签收：</span>
        <a class="y_input"><input class="input_r" type="radio" value="2" name="Signfor" id="" <?=$order_row['Signfor']==2?'checked':'';?>><span class='input_s'>已签收</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="Signfor" id="" <?=$order_row['Signfor']==1?'checked':'';?>><span class='input_s'>未签收</span></a>
        
    </div>
   <div class="y_form3"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="submit" value="提交" name="submit" class="ys_input"></div>
</form> 

<form style="background:#fff;height:450px;width:95%;overflow:hidden;margin-top:20px" action="view.php" method="post" class="act_form" enctype="multipart/form-data">
     <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">订单完成</div>
    <div class="y_form"><span class="y_title">尾款金额状态：</span>
        <a class="y_input"><input class="input_r" type="radio" value="2" name="Payment_3" id="" <?=$factory_order_row['SMApply_3']==2?'checked':'';?>><span class='input_s' >已付</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="Payment_3" id="" <?=$factory_order_row['SMApply_3']==1?'checked':'';?>><span class='input_s'>未付</span></a>
    </div>
    <div class="y_form"><span class="y_title">付款金额：</span><input class="y_title_txt_sm" type="text" name="Advance_3" value="<?=$factory_order_row['Advance_3'];?>">元（RMB）</div>
    <div style="width:100%;margin-top:20px;float:left;position:relative">
        <span style="position:absolute;top:0px" class="y_title">收据图片：</span>
        <span style="display:inline-block;width:300px;height:150px;border:1px solid #ccc;border-radius:3px;margin-left:115px;overflow:hidden">
        <?php if($factory_order_row['SMPach_3']){
            $factory_order_pach = $factory_order_row['SMPach_3'];
            ?>
            <a style="display:inline-block;width:95%;height:90%;padding:10px;background: url(<?=$factory_order_pach?>) no-repeat;" id="img_list_<?=$i;?>" href="<?=str_replace('s_', '', $factory_order_pach_3);?>" target="_blank" href=""></a>
        <?php }else{?>
            <a style="display:inline-block;width:95%;height:90%;padding:10px" href="">背景</a>
        <?php }?>
        </span>
    </div>
    <div class="y_form"><span class="y_title">是否有效：</span>
        <a class="y_input"><input class="input_r" type="radio" value="2" name="SMApply_submit_3" id="" <?=$factory_order_row['SMApply_submit_3']==2?'checked':'';?>><span class='input_s' >有效</span></a>
        <a class="y_input"><input class="input_r" type="radio" value="1" name="SMApply_submit_3" id="" <?=$factory_order_row['SMApply_submit_3']==1?'checked':'';?>><span class='input_s'>无效</span></a>
    </div>
    <div class="y_form1"><span class="y_title">备注：</span><input class="y_title_txt" type="text" name="invalidcause_3" value="<?=$factory_order_row['Invalidcause_3']?>"></div>
     <input type="hidden" name="OrderId" value="<?=$OrderId;?>" />
    <input type="hidden" name="SMApply_submit3" value="SMApply_submit3">
    <input type="hidden" name="module" value="<?=$module;?>" />
    <div class="y_submit">
        <input class="ys_input" type="submit" value="提交">
    </div> 
</form> 