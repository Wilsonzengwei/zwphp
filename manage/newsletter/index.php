<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='newsletter';
check_permit('newsletter');

if($_POST['list_form_action']=='newsletter_del'){
	check_permit('', 'newsletter.del');
	if(count($_POST['select_NId'])){
		$NId=implode(',', $_POST['select_NId']);
		$db->delete('newsletter', "NId in($NId)");
	}
	save_manage_log('批量删除邮件列表');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['list_form_action']=='member_send_mail'){
	include('../../inc/manage/header.php');
	echo '<script language=javascript>';
	echo 'parent.openWindows("win_send_mail", "'.get_lang('send_mail.send_mail_system').'", "send_mail/index.php?NId='.implode(',', $_POST['select_NId']).'")';
	echo '</script>';
	js_back();
}

if($_GET['query_string']){
	$page=(int)$_GET['page'];
	header("Location: index.php?{$_GET['query_string']}&page=$page");
	exit;
}

//分页查询
$where=1;
if($_GET['SEmail']){
    $SEmail=$_GET['SEmail'];
    $where .= " and Email like '%$SEmail%'";
}
$OrderTimeS=$_GET['OrderTimeS'];
$OrderTimeE=$_GET['OrderTimeE'];
if($OrderTimeS && $OrderTimeE){
    $ts=@strtotime($OrderTimeS);
    $te=@strtotime($OrderTimeE);
    $te && $te+=86400;
    ($ts && $te) && $where.=" and PostTime between $ts and $te";
}
$row_count=$db->get_row_count('newsletter', $where);
$total_pages=ceil($row_count/get_cfg('newsletter.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('newsletter.page_count');
$newsletter_row=$db->get_limit('newsletter', $where, '*', 'NId desc', $start_row, get_cfg('newsletter.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');

include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
    <span class="fc_gray mgl14">客户邮箱:<input class="form_input2" type="text" size="10" maxlength='20' name="SEmail" value="<?=$SEmail?>"></span>
    <span class="fc_gray mgl14"><?=get_lang('ly200.time');?>:<input style="width:100px" name="OrderTimeS" type="text" size="12" contenteditable="false" value="<?=$OrderTimeS?>" class="form_input" id="SelectDateS"/><span style="padding:0 10px">-</span><input style="width:100px" name="OrderTimeE" type="text" size="12" contenteditable="false" value="<?=$OrderTimeE?>" class="form_input" id="SelectDateE"/></span>
    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button" />
 </form>
<form style="width:100%;background:#ececec;margin-top:30px"  method="post" action="index.php">
        
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="2%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">会员邮箱</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">商户名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">发送类型</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">发送缘由</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">创建时间</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">发送人</a></td>
                </tr>
                <?php 
                    for($i=0;$i<count($newsletter_row);$i++){


                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="2%" >
                        <input class="yx" type="checkbox" name="select_ProId[]" id="" value="<?=$newsletter_row[$i]['NId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%">01</td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a href="../send_mail/index.php?email=<?=urlencode($newsletter_row[$i]['Email']);?>" style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$newsletter_row[$i]['Email']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date("Y-m-d H:i:s",$newsletter_row[$i]['PostTime']);?></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">郎朗</a></td>              
                </tr>
                <?php }?>                    
            </table>            
        </div>      
        <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>
    </form>
<?php include('../../inc/manage/footer.php');?>