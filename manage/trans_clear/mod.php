<?php 
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='transclear';
check_permit('transclear');
$TId = $_GET['TId'];
if($_POST){
    $TId = $_POST['TId'];
    $PaymentStatus=$_POST['PaymentStatus'];
    $DYName=$_POST['DYName'];
    $FollowUp=$_POST['FollowUp'];
    $db->update('trans_clear',"TId='$TId'",array(
            'FollowUp'      =>  $FollowUp,
            'PaymentStatus' =>  $PaymentStatus,
            'DYName'        =>  $DYName,
        ));
}


$trans_clear_one = $db->get_one("trans_clear","TId='$TId'");
$XSId = $trans_clear_one['XSId'];
$shipping_row = $db->get_one("shipping","SId=".$XSId);
$OrderId = $trans_clear_one['OrderId'];
$OId = $db->get_one("orders","OrderId='$OrderId'");
$MemberId = $trans_clear_one['MemberId'];
$FirstName = $db->get_one("member","MemberId='$MemberId'");
include('../../inc/manage/header.php');
?>
<link href="/css/lyz.calendar.css" rel="stylesheet" type="text/css" />
<script src="http://www.jq22.com/jquery/1.4.4/jquery.min.js"></script>
<script src="/js/lyz.calendar.min.js" type="text/javascript"></script>
<script src="/js/lyz.calendar.min.js" type="text/javascript"></script>
<form style="background:#fff;min-height:500px;width:95%;overflow:hidden;margin-top:20px"  method="post" action="" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">订单服务信息修改</div>
    <div class="y_form"><span class="y_title">订单服务号：</span><input class="y_title_txt" type="text" name="" value="<?=$trans_clear_one['TOrderId'];?>"></div>
    <div class="y_form"><span class="y_title">订单号码：</span><input class="y_title_txt" type="text" name="" value="<?=$OId['OId'];?>"></div>
    <div class="y_form"><span class="y_title">客户名称：</span><input class="y_title_txt" type="text" name="" value="<?=$FirstName['FirstName'];?>"></div>
    <div class="y_form"><span class="y_title">产品名称：</span><input class="y_title_txt" type="text" name="" value="<?=$trans_clear_one['PName'];?>"></div>
    <div class="y_form"><span class="y_title">运输方式:</span>
        <select name="" id="">
            <option value="0" <?=$trans_clear_one['Transport'] == "0" ? selected : '';?>>自行运输</option>
            <option value="1" <?=$trans_clear_one['Transport'] == "1" ? selected : '';?>>鹰洋带理空运</option>
            <option value="2" <?=$trans_clear_one['Transport'] == "2" ? selected : '';?>>鹰洋带理海运</option>
        </select>
    </div>
    <div class="y_form"><span class="y_title">运输费用：</span><input class="y_title_txt" type="text" name="" value="<?='USD $'.$trans_clear_one['TotalPrice'];?>"></div>
    <div class="y_form"><span class="y_title">清关方式:</span>
        <select name="" id="">
            <option value="0" <?=$trans_clear_one['Clearance'] == "0" ? selected : '';?>>自行清关</option>
            <option value="1" <?=$trans_clear_one['Clearance'] == "1" ? selected : '';?>>鹰洋代理清关</option>
        </select>
    </div>
    <div class="y_form"><span class="y_title">清关费用：</span><input class="y_title_txt" type="text" name="" value="<?=$trans_clear_one['QPrice'];?>"></div>
    <div class="y_form"><span class="y_title">付款状态:</span>
        <select name="PaymentStatus" id="">
            <option value="0" <?=$trans_clear_one['PaymentStatus'] != "1" ? selected : '';?>>未付款</option>
            <option value="1" <?=$trans_clear_one['PaymentStatus'] == "1" ? selected : '';?>>已付款</option>
        </select>
    </div>
    <div class="y_form"><span class="y_title">运输公司：</span><input class="y_title_txt" type="text" name="DYName" value="<?=$shipping_row['FirmName'];?>"></div>

    <div class="y_form">    
        <span class="y_title">生成时间：</span><input id="" type="text" class="y_title_txt" value="<?=date('Y-m-d H:i:s',$trans_clear_one['AccTime'])?>">   
      <!--   <input id="txtBeginDate" style="opacity:0" value="1">  -->            
    </div>  
    <div class="y_form"><span class="y_title">跟进人：</span><input class="y_title_txt" type="text" name="FollowUp" value="<?=$OId['FollowUp'];?>"></div>
    <div class="y_submit">
        <input type="hidden" name="TId" value="<?=$TId?>">
        <input type="submit" value="保存" name="submit" class="ys_input">
        <a href='index.php' class="ys_input">返回</a>
    </div>
</form> 
<!-- <script>

    $(function () {

        $("#txtEndDate").calendar({

            controlId: "divDate",                                 // 弹出的日期控件ID，默认: $(this).attr("id") + "Calendar"

            speed: 200,                                           // 三种预定速度之一的字符串("slow", "normal", or "fast")或表示动画时长的毫秒数值(如：1000),默认：200

            complement: true,                                     // 是否显示日期或年空白处的前后月的补充,默认：true

            readonly: true,                                       // 目标对象是否设为只读，默认：true

            upperLimit: new Date("2100/01/01"),                   // 日期上限，默认：NaN(不限制)

            lowerLimit: new Date("1900/01/01"),                   // 日期下限，默认：NaN(不限制)

            callback: function () {                               // 点击选择日期后的回调函数

                console.log("您选择的日期是：" + $("#txtEndDate").val());
                $('#txtBeginDate').focus();
            }
        });
    });
</script> -->