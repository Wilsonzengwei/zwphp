<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='supplier_manage';
check_permit('supplier_manage');

if($_POST['list_form_action']=='member_del'){
    check_permit('', 'member.del');
    if(count($_POST['select_MemberId'])){
       /* $MemberId=implode(',', $_POST['select_MemberId']);
        $db->update('member', "MemberId in($MemberId)",array(
                'Del'   =>  '0',
            ));*/
        $db->delete('member', "MemberId in($MemberId)");
        $db->delete('member_address_book', "MemberId in($MemberId)");
        $db->delete('member_forgot', "MemberId in($MemberId)");
        $db->delete('ad', "SupplierId in($MemberId)");
        $db->delete('article', "SupplierId in($MemberId)");
    save_manage_log('批量删除商家');
    
    $page=(int)$_POST['page'];
    $query_string=urldecode($_POST['query_string']);
    echo '<script>alert("批量删除成功");</script>';
    header('Refresh:0;url=supplier.php?$query_string&page=$page"');
    exit;
    }else{
        echo '<script>alert("未选中选项,批量删除失败");</script>';
        header('Refresh:0;url=supplier.php?$query_string&page=$page"');
        exit;  
    }
}

if($_GET['act'] == 'del_member_one'){
        
    $MemberId = $_GET['MemberId'];
  /*  $db->update('member',"MemberId='$MemberId'",array(
            'Del'   =>  '0',
        ));*/
    $db->delete("member","MemberId='$MemberId'");
    $LogoPat_r = $db->get_one('member',"MemberId='$MemberId'","LogoPath");
    $ad_r = $db->get_all('ad',"SupplierId='$MemberId'","AId");
    $article_r = $db->get_all('article',"SupplierId='$MemberId'","AId");
    if($ad_r){
        foreach ($ad_r as $key => $value) {
           $ad_rr[] = $value['AId'];
          
        }
        $ad_rs = implode(",",$ad_rr);
        $db->delete('ad',"AId in ($ad_rs)");
    }
    if($article_r){
        
        foreach ($article_r as $key1 => $value1) {
           $article_rr[] = $value1['AId'];
        }
        $article_rs = implode(",",$article_rr);
    
        $db->delete('article',"AId in ($article_rs)");
    }
    del_file($LogoPat_r['LogoPath']);
    save_manage_log('删除商户');
   
    echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=supplier.php?$query_string&page=$page"');
    exit;
}

if($_POST['list_form_action']=='member_send_mail'){
    include('../../inc/manage/header.php');
    echo '<script language=javascript>';
    echo 'parent.openWindows("win_send_mail", "'.get_lang('send_mail.send_mail_system').'", "send_mail/supplier.php?MemberId='.implode(',', $_POST['select_MemberId']).'")';
    echo '</script>';
    js_back();
}

if($_GET['query_string']){
    $page=(int)$_GET['page'];
    header("Location: supplier.php?{$_GET['query_string']}&page=$page");
    exit;
}

//分页查询
$where='IsSupplier=1';
$Supplier = $_GET['Supplier'];
if($Supplier){
    $where .= " and Email like '%$Supplier%'";
}
/*$Supplier = mysql_real_escape_string($_GET['Supplier']);
$Supplier && $supplier_list = $db->get_all('member',"Supplier_Name like '%$Supplier%' or Email like '%$Supplier%'",'MemberId');
if($supplier_list){
    $supplier_id = array();
    foreach((array)$supplier_list as $v){
        $supplier_id[] = $v['MemberId'];
    }
    $supplier_id=implode(',', $supplier_id);
}*/
$supplier_id && $where.=" and MemberId in ({$supplier_id})";

$FullName=$_GET['FullName'];
$Email=$_GET['Email'];
$RegTimeS=$_GET['RegTimeS'];
$RegTimeE=$_GET['RegTimeE'];
$LastLoginTimeS=$_GET['LastLoginTimeS'];
$LastLoginTimeE=$_GET['LastLoginTimeE'];

$FullName && $where.=" and concat(m.FirstName, ' ', m.LastName) like '%$FullName%'";
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

$_GET['Is_Business_License']=='yes' && $where.= ' and Is_Business_License=1';
$_GET['Is_Business_License']=='no' && $where.= ' and Is_Business_License=0';
$_GET['IsConfirm']=='1' && $where.= ' and IsConfirm=1';
$_GET['IsConfirm']=='0' && $where.= ' and IsConfirm=0';
$_GET['IsUse']=='1' && $where.= ' and IsUse=1';
$_GET['IsUse']=='2' && $where.= ' and IsUse=2';
$_GET['IsUse']=='0' && $where.= ' and IsUse=0';
$IsUse = $_GET['IsUse'];
$Is_Business_License = $_GET['Is_Business_License'];
$IsConfirm = $_GET['IsConfirm'];
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
$admin_userId = $_SESSION['ly200_AdminUserId'];
$supplier_rs = $db->get_one('userinfo', "UserId='$admin_userId'");
//var_dump($supplier_rs);exit;
if($supplier_rs['Salesman_Name'] !== '' && $supplier_rs['GroupId'] =='3'){
    $where .= ' and Salesman_Name=\''.$supplier_rs['Salesman_Name'].'\'';
    $member_rs=$db->query("select m.* from member m  where $where group by m.MemberId order by IsUse asc,{$order_ary[$order]}m.MemberId desc limit {$start_row},".get_cfg('member.page_count'));
}else{
    
    $member_rs=$db->query("select m.* from member m  where $where group by m.MemberId order by IsUse asc,{$order_ary[$order]}m.MemberId desc limit {$start_row},".get_cfg('member.page_count'));
}
//获取页面跳转url参数
$query_string=query_string('page');
$query_string_no_order=query_string(array('page', 'order'));

//会员等级
$level_row=$db->get_all('member_level', 1, '*', 'UpgradePriceS desc');
$level_ary=array();
$level_ary[0]='没有等级';
for($i=0,$count=count($level_row); $i<$count; $i++){
    $level_ary[$level_row[$i]['LId']]=$level_row[$i]['Level'];
}

include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="supplier.php">
    <span class="fc_gray mgl14">商家名称:<input name="Supplier" class="form_input2" type="text" size="10" maxlength='20' value="<?=$Supplier;?>"></span>
    <span class="fc_gray mgl14">邮箱:<input name="Email" class="form_input2" type="text" size="10" maxlength='20' value="<?=$Email;?>"></span>
    <span style="font-size:14px;color:#666;margin-left:20px">商家类型:</span>
        <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="Is_Business_License" id="">
            <option value="">全部</option>
            <option value="yes" <?=$Is_Business_License == 'yes' ? selected : '';?>>普通商户</option>
            <option value="no" <?=$Is_Business_License == 'no' ? selected : '';?>>EAGLE HOME</option>
        </select>
    <span style="font-size:14px;color:#666;margin-left:20px">是否激活:</span>
        <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="IsConfirm" id="">
            <option value="">全部</option>
            <option value="1" <?=$IsConfirm == '1' ? selected : '';?>>是</option>
            <option value="0" <?=$IsConfirm == '0' ? selected : '';?>>否</option>
        </select>
    <span style="font-size:14px;color:#666;margin-left:20px">审核状态:</span>
        <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="IsUse" id="">
            <option value="">全部</option>
            <option value="1" <?=$IsUse == '1' ? selected : '';?>>待审核</option>
            <option value="2" <?=$IsUse == '2' ? selected : '';?>>审核通过</option>
            <option value="0" <?=$IsUse == '0' ? selected : '';?>>审核不通过</option>
        </select>
    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button" />
 </form>
<form style="width:100%;background:#ececec;margin-top:30px" class="list_form" name="list_form" id="list_form" method="post" action="supplier.php">
        <div>
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_MemberId[]");' value="全选">
           <input name="member_del" id="member_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
            <span style="position:absolute;right:20px">
                <span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px"><?=$row_count?></span><span style="font-size:12px;color:#999">名商户</span>
            </span>
        </div>
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="2%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">商户名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">会员邮箱</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center">手机号码</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">成交总金额</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">等级</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%" nowrap>是否激活</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">商家类型</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>审核状态</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">登录次数</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">创建时间</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>                               
                </tr>
                <?php
                    include('../../inc/fun/ip_to_area.php');
                    $i=1;
                    while($member_row=mysql_fetch_assoc($member_rs)){
                        $MemberId_r = $member_row['MemberId'];

                        $SupplierId_r = $db->get_all('orders',"SupplierId='$MemberId_r'","TotalPrice");
                        //var_dump($MemberId_r);exit;
                        if ($SupplierId_r['TotalPrice']){
                            $array_sum = array_sum($SupplierId_r['TotalPrice']);
                        }else{
                            $array_sum = '0';
                        }
                        if($member_row['IsUse'] == '1'){
                            $IsUse_r = "未审核";
                        }elseif($member_row['IsUse'] == '2'){
                            $IsUse_r = "审核通过";
                        }elseif($member_row['IsUse'] == '0'){
                            $IsUse_r = "审核不通过";
                        }
                        if($member_row['IsConfirm'] == '1'){
                            $IsConfirm_r = "是";
                        }else{
                            $IsConfirm_r = "否";
                        }
                        if($member_row['Is_Business_License'] == '1'){
                            $Is_Business_r = "普通商户";
                        }else{
                            $Is_Business_r = "EAGLE HOME";
                        }
                        $reg_ip_area=ip_to_area($member_row['RegIp']);
                        $last_login_ip_area=ip_to_area($member_row['LastLoginIp']);
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="2%" >
                        <input class="yx" type="checkbox" name="select_MemberId[]" id="" value="<?=$member_row['MemberId'];?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%"><?=$start_row+$i++;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=htmlspecialchars($member_row['Supplier_Name']); ?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=htmlspecialchars($member_row['Email']); ?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center"><?=htmlspecialchars($member_row['Supplier_Mobile']); ?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><span><?=$array_sum?></span><span>美元</span></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><span>0</span></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%"><?=$IsConfirm_r?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$Is_Business_r?></a></td>                    
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$IsUse_r?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><span><?=$member_row['LoginTimes'];?></span></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date(get_lang('ly200.time_format_full'), $member_row['RegTime']);?></div></td>
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="supplier_add.php?SupplierId=<?=$member_row['MemberId'];?>">修改</a>
                        <a href="supplier.php?MemberId=<?=$member_row['MemberId'];?>&act=del_member_one">删除</a>
                        <a href="">查看</a>                        
                    </td>               
                </tr>    
                <?php }?>     
            </table>            
        </div>
        <input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
        <input type="hidden" name="page" value="<?=$page;?>">
        <input name="list_form_action" id="list_form_action" type="hidden" value="">
         <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "supplier.php?$query_string&page=", $row_count, '〈', '〉');?></div>
                <div class="clear"></div>  
    </form>
<?php include('../../inc/manage/footer.php');?>