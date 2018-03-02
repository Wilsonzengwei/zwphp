<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='buyers_member_manage';
check_permit('buyers_member_manage');

if($_POST['list_form_action']=='member_del'){
    check_permit('', 'member.del');
    if(count($_POST['select_MemberId'])){
       
        $MemberId=implode(',', $_POST['select_MemberId']);
       /* $db->update('member', "MemberId in($MemberId)",array(
                'Del'   =>  '0',
            ));*/
        $db->delete('member', "MemberId in($MemberId)");
        $db->delete('member_address_book', "MemberId in($MemberId)");
        $db->delete('member_forgot', "MemberId in($MemberId)");
        
    save_manage_log('批量删除会员');
    
    $page=(int)$_POST['page'];
    $query_string=urldecode($_POST['query_string']);
    echo '<script>alert("批量删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
    exit;
    }else{
        echo '<script>alert("未选中选项,批量删除失败");</script>';
        header('Refresh:0;url=index.php?$query_string&page=$page"');
        exit;
    }
}
if($_POST['list_form_action']=='member_dis'){
    if(count($_POST['select_MemberId'])){
       
        $MemberId=implode(',', $_POST['select_MemberId']);
        $db->update('member', "MemberId in($MemberId)",array(
                'Disabled'  => '0',
            ));
    
    save_manage_log('批量禁用会员');
    
    $page=(int)$_POST['page'];
    $query_string=urldecode($_POST['query_string']);
    echo '<script>alert("批量禁用成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
    exit;
    }else{
        echo '<script>alert("未选中选项,批量禁用失败");</script>';
        header('Refresh:0;url=index.php?$query_string&page=$page"');
        exit;
    }
}
if($_GET['act'] == 'member_no_1'){
        
    $UId = $_GET['UId'];
    $db->update('member',"MemberId='$UId'",array(
                "Status" => "0",
            ));
    save_manage_log('禁用会员');
    echo '<script>alert("禁用成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
    exit;
}
if($_GET['act'] == 'member_no_2'){
        
    $UId = $_GET['UId'];
    /*$db->update('member', "MemberId='$UId'",array(
                'Del'   =>  '0',
            ));*/
    $db->delete('member',"MemberId='$UId'");
    save_manage_log('删除会员');
    echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
    exit;
}
if($_POST['list_form_action']=='member_send_mail'){
    include('../../inc/manage/header.php');
    echo '<script language=javascript>';
    echo 'parent.openWindows("win_send_mail", "'.get_lang('send_mail.send_mail_system').'", "send_mail/index.php?MemberId='.implode(',', $_POST['select_MemberId']).'")';
    echo '</script>';
    js_back();
}

if($_GET['query_string']){
    $page=(int)$_GET['page'];
    header("Location: index.php?{$_GET['query_string']}&page=$page");
    exit;
}

//分页查询
$where='IsSupplier=0';
if($_GET['name'] == 'sousuo'){
    if($_GET['FullName']){
        $FullName = $_GET['FullName'];
        $where.= " and Supplier_Name like '%$FullName%'";
    }
    if($_GET['Email']){
        $Email = $_GET['Email'];
        $where.= " and Email like '%$Email%'";
    }
    if($_GET['IsConfirm'] != ''){
        $IsConfirm = (int)$_GET['IsConfirm'];
        //var_dump($IsConfirm);exit;
        $where.= " and IsConfirm='$IsConfirm'";
    }
    if($_GET['Level']){
        $Level = $_GET['Level'];
        $where.= " and Level='$Level'";
    }
    
}
$FullName=$_GET['FullName'];
$Email=$_GET['Email'];
$RegTimeS=$_GET['RegTimeS'];
$RegTimeE=$_GET['RegTimeE'];
$LastLoginTimeS=$_GET['LastLoginTimeS'];
$LastLoginTimeE=$_GET['LastLoginTimeE'];


$Email && $where.=" and m.Email like '%$Email%'";
if($RegTimeS && $RegTimeE){
    $ts=@strtotime($RegTimeS);
    $te=@strtotime($RegTimeE);
    $te && $te+=86400;
    ($ts && $te) && $where.=" and m.RegTime between $ts and $te";
}
if($LastLoginTimeS && $LastLoginTimeE){
    $ts=@strtotime($LastLoginTimeS);
    $te=@strtotime($LastLoginTimeE);
    $te && $te+=86400;
    ($ts && $te) && $where.=" and m.LastLoginTime between $ts and $te";
}

$order_ary=array(
    1=>'m.RegTime asc,',
    2=>'m.RegTime desc,',
    3=>'m.LastLoginTime asc,',
    4=>'m.LastLoginTime desc,',
    5=>'total_price asc,',
    6=>'total_price desc,',
    7=>'m.LoginTimes asc,',
    8=>'m.LoginTimes desc,'
);
$order=(int)$_GET['order'];

$table_asname = $FullName || $Email || $RegTimeS || $RegTimeE || $LastLoginTimeS || $LastLoginTimeE || $order? ' as m' : '';

$row_count=$db->get_row_count('member'.$table_asname, $where);
$total_pages=ceil($row_count/get_cfg('member.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('member.page_count');
$member_rs=$db->query("select m.* from member m  where $where group by m.MemberId order by {$order_ary[$order]}m.MemberId desc limit {$start_row},".get_cfg('member.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');
$query_string_no_order=query_string(array('page', 'order'));

//会员等级
$level_row=$db->get_all('member_level', 1, '*', 'UpgradePriceS desc');
$level_ary=array();
for($i=0,$count=count($level_row); $i<$count; $i++){
    $level_ary[$level_row[$i]['LId']]=$level_row[$i]['Level'];
}



include('../../inc/manage/header.php');
?>

    
    <form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
                    <span class="fc_gray mgl14">用户名:<input name="FullName" class="form_input" type="text" size="10" maxlength='20' value="<?=$FullName?>"></span>
                   <span class="fc_gray mgl14"> <?=get_lang('ly200.email');?>:<input name="Email" class="form_input" type="text" size="20" maxlength='200' value="<?=$Email?>"></span>
                   <span class="fc_gray mgl14">等级：<select class="owidth" name="Level" type="text">
                        <option value="">全部</option>
                        <option value="1" <?=$Level == '1' ? 'selected' :'';?>>LV1</option>
                        <option value="2" <?=$Level == '2' ? 'selected' :'';?>>LV2</option>
                        <option value="3" <?=$Level == '3' ? 'selected' :'';?>>LV3</option>
                   </select></span>
                    <span class="fc_gray mgl14">是否激活：
                        <select class="owidth" name="IsConfirm" type="text">
                            <option value="">全部</option>
                            <option value="0" <?=$IsConfirm == '0' ? 'selected' :'';?>>否</option>
                            <option value="1" <?=$IsConfirm == '1' ? 'selected' :'';?>>是</option>
                        </select>
                    </span>
                     <!-- <span class="fc_gray mgl14">所属地区：<select class="owidth" name="" type="text"><option value="">全部</option></select></span> -->
                    <input type="hidden" name="name" value="sousuo">
                   <input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">
    </form>
        
    <form style="width:100%;background:#ececec;margin-top:30px" name="list_form" class="list_form" id="list_form"  method="post" action="index.php">
        <div>
            <!-- <a href="add.php?act=添加客户"><input name="product_del" id="product_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="添加客户"></a>            -->
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_MemberId[]");' value="全选">
            <input name="member_del" id="member_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
            <input type="button" value="批量禁用" name="member_dis" id="member_dis" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick="click_button(this, 'list_form', 'list_form_action');">
        </div>
    
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;width:100%" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="3%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="4%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center">用户名</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">姓名</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center">邮箱</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center">联系电话</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%">所属地区</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%">是否激活</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%" nowrap>会员等级</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><div style="width:70px">注册时间</div></td>                
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="4%" nowrap>登录次数</td>  
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="10%" nowrap>操作</td>  
                </tr>
                <?php
                    include($site_root_path.'/inc/fun/ip_to_area.php');
                    $i=1;
                    while($member_row=mysql_fetch_assoc($member_rs)){
                        $reg_ip_area=ip_to_area($member_row['RegIp']);
                        $last_login_ip_area=ip_to_area($member_row['LastLoginIp']);
                        if($member_row['IsConfirm'] == '' || $member_row['IsConfirm'] == '0'){
                            $IsConfirm = '否';
                        }elseif($member_row['IsConfirm'] == '1'){
                            $IsConfirm = '是';
                        }
                        if($member_row['Level'] ){
                            $Level_arr = 'LV'.$member_row['Level'];
                        }else{
                            $Level_arr = '';
                        }
                       
                ?>
                <tr class="list" style="height:60px;width:100%;" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="3%" >
                        <input class="yx" type="checkbox" name="select_MemberId[]"  value="<?=$member_row['MemberId'];?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%" ><?=$start_row+$i++;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=htmlspecialchars($member_row['UserName']);?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$member_row['FirstName'];?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center;word-break: break-all;word-wrap:break-word;"><?=$member_row['Email'];?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center"><?=$member_row['Supplier_Mobile'];?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%"><?php if($member_row['RegIp']){ echo htmlspecialchars($member_row['RegIp']); } ?><?=htmlspecialchars($member_row['RegIp']);?><br><?php if($reg_ip_area){ echo '['.$reg_ip_area['country'].$reg_ip_area['area'].']'; } ?> </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$IsConfirm ;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%" ><?=$Level_arr?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><div style="width:70px"><?=date(get_lang('ly200.time_format_full'), $member_row['RegTime']);?></div></td>                
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%" ><?=$member_row['LoginTimes'];?></td>  
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="mod.php?MemberId=<?=$member_row['MemberId']?>">修改</a>
                        <!-- <a href="index.php?act=member_no_1&UId=<?=$member_row['MemberId'];?>">禁用</a> -->
                        <a href="index.php?act=member_no_2&UId=<?=$member_row['MemberId'];?>">删除</a>
                        <a href="">查看</a>
                    </td>                  
                </tr>           
            <?php }?>
            </table>    
                          
                <input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
                <input type="hidden" name="page" value="<?=$page;?>">
                <input name="list_form_action" id="list_form_action" type="hidden" value="">
         
            <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>      
        

    </form>

<?php include('../../inc/manage/footer.php');?>