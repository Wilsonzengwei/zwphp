<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
include($site_root_path.'/inc/fun/ip_to_area.php');
$page_cur='manage_log';
check_permit('manage_log');
$LId = $_GET['LId'];
$manage_log_row = $db->get_one('manage_log',"LId='$LId'");
$ip_area=ip_to_area($manage_log_row['Ip']);
if(!$ip_area){
    $ip_area['country'] = '未知地点';
    $ip_area['area'] = '';
}
if(!$manage_log_row['Ip']){
    $manage_log_row['Ip'] = "未知ip";
}
	include('../../inc/manage/header.php');
?>
<style>
	.y{
        height:350px;
        background:#fff;
    }
    .y_form{
    	width:450px;float:left;margin-top:20px;height:31px;line-height:31px;
    }
    .y_form1{
    	width:100%;float:left;margin-top:20px
    }
    .yc_title{
    	display:inline-block;width:100px;text-align:right;font-size:12px;color:#666;font-weight:bold;
    }
    .y_title{
        display:inline-block;width:100px;text-align:right;font-size:12px;color:#666;font-weight:bold;
    }
    .y_title_txt{
		width:300px;height:29px;border-radius:3px;border:1px solid #ccc;color:#333;
    }
    .y_submit{
        width:100%;
        float:left;
        margin-top:40px;
        text-align:center;
    }
    .ys_input{
        border:none;background:#218fde;width:133px;height:29px;line-height:29px;
        text-align: center;
        color: #fff;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
    }
</style>
<form style="background:#fff;min-height:600px;width:95%" action="">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px"><?=$a?></div>
	<div class="table">
            <div class="table_bg"></div>
            <div class="y">
            	<div class="y_form"><span class="y_title">账户名：</span><input class="y_title_txt" type="text" value="<?=$manage_log_row['AdminUserName']?>"></div>
                <div class="y_form"><span class="y_title">IP地址：</span><input class="y_title_txt" type="text" value="<?=$manage_log_row['Ip']?>"></div>
                <div class="y_form"><span class="y_title">IP来源：</span><input class="y_title_txt" type="text" value="<?=$ip_area['country'].$ip_area['area']?>"></div>
                <div class="y_form"><span class="y_title">请求URL：</span><input class="y_title_txt" type="text" value="<?=$manage_log_row['PageUrl']?>"></div>
                <div class="y_form1"><span class="y_title">请求时间：</span><input class="y_title_txt" type="text" value="<?=date(get_lang('ly200.time_format_full'), $manage_log_row['OpTime']);?>"></div>
                <div class="y_form1"><span class="y_title">请求内容：</span><input class="y_title_txt" type="text" value="<?=$manage_log_row['LogContents'];?>"></div>
            </div>   
    </div>           
</form>
<?php include('../../inc/manage/footer.php');?>