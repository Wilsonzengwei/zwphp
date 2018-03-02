<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='manage_log';
check_permit('manage_log');

if($_POST['list_form_action']=='manage_log_del'){
	if(count($_POST['select_manage_log'])){
		$LId=implode(',', $_POST['select_manage_log']);
		$where="LId in($LId)";
		$db->delete('manage_log', $where);
	
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	echo '<script>alert("批量删除成功");</script>';
    header('Refresh:0;url=index.php');
	exit;
    }else{
        echo '<script>alert("未选中选项,批量删除失败");</script>';
        header('Refresh:0;url=index.php');
        exit;
    }
}

if($_GET['query_string']){
	$page=(int)$_GET['page'];
	header("Location: index.php?{$_GET['query_string']}&page=$page");
	exit;
}

//分页查询
$where=1;
$AdminUserName=$_GET['AdminUserName'];
$PageUrl=$_GET['PageUrl'];
$Ip=$_GET['Ip'];
$LogContents=$_GET['LogContents'];
$OpTimeS=$_GET['OpTimeS'];
$OpTimeE=$_GET['OpTimeE'];
$AdminUserName && $where.=" and AdminUserName like'%$AdminUserName%'";
$PageUrl && $where.=" and PageUrl like '%$PageUrl%'";
$Ip && $where.=" and Ip='$Ip'";
$LogContents && $where.=" and LogContents like '%$LogContents%'";
if($OpTimeS && $OpTimeE){
	$ts=@strtotime($OpTimeS);
	$te=@strtotime($OpTimeE);
	$te && $te+=86400;
	($ts && $te) && $where.=" and OpTime between $ts and $te";
}

$row_count=$db->get_row_count('manage_log', $where);
$total_pages=ceil($row_count/get_cfg('manage_log.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('manage_log.page_count');
$manage_log_row=$db->get_limit('manage_log', $where, '*', 'LId desc', $start_row, get_cfg('manage_log.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('manage_log_header.php');?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bat_form">
        <tr>
            <td height="58" class="flh_150">
                <form method="get" name="manage_log_search_form" action="index.php" onsubmit="this.submit.disabled=true;">
                    <span class="fc_gray mgl14">账户名:<input name="AdminUserName" class="form_input" type="text" size="10" maxlength='20' value="<?=$AdminUserName?>"></span>
                    <span class="fc_gray mgl14"><?=get_lang('manage_log.ip');?>:<input name="Ip" class="form_input" type="text" size="15" maxlength='15' value="<?=$Ip?>"></span>
                    <span class="fc_gray mgl14"><?=get_lang('ly200.time');?>:<input style="width:100px" name="OpTimeS" type="text" size="12" contenteditable="false" value="<?=$OpTimeS?>" class="form_input" id="SelectDateS"/><span style="padding:0 10px">-</span><input style="width:100px" name="OpTimeE" type="text" size="12" contenteditable="false" value="<?=$OpTimeE?>" class="form_input" id="SelectDateE"/></span>
                    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button" />
                </form>
            </td>
        </tr>
    </table>
    <form style="height:768px;background:#fff" class="list_form" id="list_form" name="list_form" method="post" action="index.php"> 
    <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_manage_log[]");' value="全选">
    <input name="manage_log_del" id="manage_log_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
           
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;width:100%" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="7%" nowrap>用户名</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="7%" nowrap><a style="display:inline-block;width:130px;text-align:center">IP地址</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="12%" nowrap>IP来源</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%"><a style="display:inline-block;width:160px;text-align:center">请求URL</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="7%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:120px;text-align:center;overflow:hidden">日志内容</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%" nowrap>请求时间</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%" nowrap>操作</td>                
                </tr>
                <?php 
                    include($site_root_path.'/inc/fun/ip_to_area.php');
                    for($i=0;$i<count($manage_log_row);$i++){
                        $ip_area=ip_to_area($manage_log_row[$i]['Ip']);
                        if(!$ip_area){
                            $ip_area['country'] = '未知地点';
                            $ip_area['area'] = '';
                        }
                        if(!$manage_log_row[$i]['Ip']){
                            $manage_log_row[$i]['Ip'] = "未知ip";
                        }

                ?>
                <tr class="list" style="height:60px;width:100%;" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>
                        <input class="yx" type="checkbox" name="select_manage_log[]" id="" value="<?=$manage_log_row[$i]['LId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$i+1?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$manage_log_row[$i]['AdminUserName']?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:inline-block;width:130px;text-align:center;"><?=$manage_log_row[$i]['Ip'];?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="12%" ><?=$ip_area['country'].$ip_area['area']?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:160px;text-align:left;overflow:hidden"><?=$manage_log_row[$i]['PageUrl']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:120px;text-align:left;overflow:hidden"><?=$manage_log_row[$i]['LogContents'];?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><?=date(get_lang('ly200.time_format_full'), $manage_log_row[$i]['OpTime']);?></td>
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" >
                        <a href="mod.php?LId=<?=$manage_log_row[$i]['LId']?>">查看</a>                      
                    </td>               
                </tr>               
               <?php }?>
            </table>    
                          
                <input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
                <input type="hidden" name="page" value="<?=$page;?>">
                <input name="list_form_action" id="list_form_action" type="hidden" value="">
         
            <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>      
        </div>       

    </form>    
  
</div>
<?php include('../../inc/manage/footer.php');?>