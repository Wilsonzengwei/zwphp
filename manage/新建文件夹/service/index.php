<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='orders';
check_permit('orders');
// $db->update('orders', "OrderStatus=5 and ShippingTime+15*3600*24<$service_time", array(
//      'OrderStatus'   =>  6
//  )
// );
// if($db->get_row_count('orders', "OrderStatus<5 and OrderTime+".$mCfg['OrderLife']."*3600*24<$service_time")){
//  $order_cancel=$db->get_limit('orders', "OrderStatus<5 and OrderTime+".$mCfg['OrderLife']."*3600*24<$service_time");
//  $db->update('orders', "OrderStatus<5 and OrderTime+".$mCfg['OrderLife']."*3600*24<$service_time", array(
//          'OrderStatus'   =>  7
//      )
//  );
//  foreach((array)$order_cancel as $item){
//      $ProId='0,';
//      $where="OrderId = {$item['OrderId']}";
//      $item_row=$db->get_all('orders_product_list', $where, '*', 'ProId desc, LId desc');
//      for($i=0; $i<count($item_row); $i++){
//          $ProId.=$item_row[$i]['ProId'].',';
//          $db->query("update product set Stock=Stock+{$item_row[$i]['Qty']} where ProId='{$item_row[$i]['ProId']}'");
//      }
//      $ProId.='0';
//      $db->update('product', "ProId in($ProId) and Stock<0", array(
//              'Stock' =>  0
//          )
//      );
        
//      $db->update('orders', $where, array(
//              'CutStock'  =>  1
//          )
//      );
//  }
// }
$GroupId = $_SESSION['ly200_AdminGroupId'];
if(strpos($GroupId ,'35') || strpos($GroupId ,'36')){
    $Statusmun = '1';
    $User_Name = $_SESSION['ly200_AdminSalesmanName'];
}else{
    $Statusmun = '0';
    $User_Name = '';
}
if($_POST['list_form_action']=='orders_del'){
    check_permit('', 'orders.del');
    if(count($_POST['select_OrderId'])){
        $OrderId=implode(',', $_POST['select_OrderId']);
        $row=$db->get_all('orders', "OrderId in($OrderId)", 'OId, OrderTime');
        
        for($i=0; $i<count($row); $i++){
            $ym=date('Y_m', $row[$i]['OrderTime']);
            del_dir("/images/orders/$ym/{$row[$i]['OId']}/");
        }
        
        $db->delete('orders', "OrderId in($OrderId)");
        $db->delete('orders_product_list', "OrderId in($OrderId)");
        $db->delete('orders_payment_info', "OrderId in($OrderId)");
    
    save_manage_log('批量删除订单');
    
    $page=(int)$_POST['page'];
    $query_string=urldecode($_POST['query_string']);
    echo '<script>alert("批量删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
    exit;
    }else{
        $page=(int)$_POST['page'];
        $query_string=urldecode($_POST['query_string']);
        echo '<script>alert("未选中选项,批量删除失败");</script>';
        header('Refresh:0;url=index.php?$query_string&page=$page"');
        exit;
    }
}
if($_POST['list_form_action']=='orders_Sataus'){
        $OrderId=implode(',', $_POST['select_OrderId']);
        var_dump($_POST['select_OrderId']);exit;
        $row=$db->update('orders', "OrderId in($OrderId)", array(
            'FollowStatus' =>  $Statusmun,
            'FollowUp'     =>  $User_Name

            ));
    save_manage_log('批量删除订单');
    
    $page=(int)$_POST['page'];
    $query_string=urldecode($_POST['query_string']);
    header("Location: index.php?$query_string&page=$page");
    exit;
}
if($_GET['act'] == 'FollowStatus'){
    $OrderId = $_GET['OrderId'];
    $db->update('orders',"OrderId='$OrderId'",array(
            'FollowStatus' =>  $Statusmun,
            'FollowUp'     =>  $User_Name
        ));
    save_manage_log('跟进订单');
    header("Location: index.php?$query_string&page=$page");
    exit;
}
if($_GET['query_string']){
    $page=(int)$_GET['page'];
    header("Location: index.php?{$_GET['query_string']}&page=$page");
    exit;
}

//分页查询
$UserId_Name = $_SESSION['ly200_AdminSalesmanName'];
$where="FollowUp='$UserId_Name'";
$OId=$_GET['OId'];
$TrackingNumber=$_GET['TrackingNumber'];
$FullName=$_GET['FullName'];
$Email=$_GET['Email'];
$OrderStatus=(int)$_GET['OrderStatus'];
$OrderTimeS=$_GET['OrderTimeS'];
$OrderTimeE=$_GET['OrderTimeE'];

$OId && $where.=" and OId like '%$OId%'";
$TrackingNumber && $where.=" and TrackingNumber like '%$TrackingNumber%'";
$FullName && $where.=" and (concat(ShippingFirstName, ' ', ShippingLastName) like '%$FullName%') or FollowUp like '%$FullName%'";
$Email && $where.=" and Email like '%$Email%'";
$OrderStatus && $where.=" and OrderStatus='$OrderStatus'";
if($OrderTimeS && $OrderTimeE){
    $ts=@strtotime($OrderTimeS);
    $te=@strtotime($OrderTimeE);
    $te && $te+=86400;
    ($ts && $te) && $where.=" and OrderTime between $ts and $te";
}

$order_ary=array(
    1=>'OId asc,',
    2=>'OId desc,',
    3=>'Email asc,',
    4=>'Email desc,',
    5=>'((TotalPrice+ShippingPrice)*(1+PayAdditionalFee/100)) asc,',
    6=>'((TotalPrice+ShippingPrice)*(1+PayAdditionalFee/100)) desc,',
    7=>'OrderStatus asc,',
    8=>'OrderStatus desc,',
    9=>'OrderTime asc,',
    10=>'OrderTime desc,'
);
$order=(int)$_GET['order'];

$row_count=$db->get_row_count('orders', $where);

$total_pages=ceil($row_count/get_cfg('orders.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('orders.page_count');
$order_row=$db->get_limit('orders', $where, '*', "{$order_ary[$order]}OrderId desc", $start_row, get_cfg('orders.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');
$query_string_no_order=query_string(array('page', 'order'));

include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
    <span class="fc_gray mgl14">订单号:<input class="form_input2" type="text" size="10" maxlength='20' name="OId" value="<?=$OId?>"></span>
    <span class="fc_gray mgl14">跟进人:<input style="width: 50px;" class="form_input2" type="text" size="10" maxlength='20' name="FullName" value="<?=$FullName?>"></span>
    <span class="fc_gray mgl14">客户邮箱:<input class="form_input2" type="text" size="10" maxlength='20' name="Email" value="<?=$Email?>"></span>
    <span style="font-size:14px;color:#666;margin-left:5px">订单状态:</span>
    <select style="width:130px;height:25px;border-radius:3px;font-size:12px;color:#666" name="OrderStatus" id="">
      <option value="0" >全部</option>
        <?php foreach($order_status_ary as $key=>$value){?>
            <?php 
                if($key == '2'){
                    $orders_table_row = $db->get_row_count('orders',"OrderStatus='2'")."条";
                }elseif($key == '3'){
                    $orders_table_row = $db->get_row_count('orders',"OrderStatus='3'")."条";
                }elseif($key == '7'){
                    $orders_table_row = $db->get_row_count('orders',"OrderStatus='7'")."条";
                }else{
                    $orders_table_row = '';
                }

            ?>

            <option value="<?=$key;?>" style="color:;" <?=$OrderStatus == $key ? selected :'';?>><?=$value;?>&nbsp;<span style="color:red;"><?=$orders_table_row;?></option>
        <?php }?>
    </select>
    <span class="fc_gray mgl14"><?=get_lang('ly200.time');?>:<input style="width:100px" name="OrderTimeS" type="text" size="12" contenteditable="false" value="<?=$OrderTimeS?>" class="form_input" id="SelectDateS"/><span style="padding:0 10px">-</span><input style="width:100px" name="OrderTimeE" type="text" size="12" contenteditable="false" value="<?=$OrderTimeE?>" class="form_input" id="SelectDateE"/></span>
    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button" />
 </form>
<form style="width:100%;background:#ececec;margin-top:30px" name="list_form" id="list_form" class="list_form"  method="post" action="index.php">
        <div>
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_OrderId[]");' value="全选">
            <input name="orders_del" id="orders_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action')">
            
            <span style="position:absolute;right:20px">
                <span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px"><?=$row_count?></span><span style="font-size:12px;color:#999">条订单</span>
            </span>
        </div>
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">订单号</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:80px;overflow:hidden;text-align:center">客户姓名</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">会员邮箱</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center">联系电话</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">总价</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>订单状态</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>跟进状态</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:80px;overflow:hidden;text-align:center">跟进人</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%">所属地区</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">下单时间</div></td>

                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>                               
                </tr>
                <?php 
                    include($site_root_path.'/inc/fun/ip_to_area.php');
                    for ($i=0; $i < count($order_row); $i++) { 

                        
                        $MId = $order_row[$i]['MemberId'];

                        $moblie = $db->get_one('member',"MemberId='$MId'","RegIp,Supplier_Mobile");
                        $ip_area=ip_to_area($moblie['RegIp']);
                        $country = $ip_area['country'];
                        /*

                        if($moblie){*/
                        $moblie =  $moblie['Supplier_Mobile'];
                        /*}else{
                        $moblie = $db->get_one('member',"MemberId='$MId'","Supplier_Phone");
                        $moblie =  $moblie['Supplier_Phone'];
                        }*/
                        if($order_row[$i]['FollowStatus'] == '1'){
                            $FollowStatus_r = '已跟进';
                        }else{
                            $FollowStatus_r = '未跟进';
                        }
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" >
                        <input class="yx" type="checkbox" name="select_OrderId[]" value="<?=$order_row[$i]['OrderId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$start_row+$i+1;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$order_row[$i]['OId']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:80px;text-align:left;overflow:hidden;text-align:center"><?=$order_row[$i]['ShippingFirstName'].$order_row[$i]['ShippingLastName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$order_row[$i]['Email']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center"><?=$moblie?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><span><?=sprintf('%01.2f', ($order_row[$i]['TotalPrice']+$order_row[$i]['ShippingPrice'])*(1+$order_row[$i]['PayAdditionalFee']/100))?></span><span>美元</span></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$order_status_ary[$order_row[$i]['OrderStatus']];?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$FollowStatus_r;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:80px;text-align:left;overflow:hidden;text-align:center"><?=$order_row[$i]['FollowUp']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%"><?=$country?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date("Y-m-d H:i:s",$order_row[$i]['OrderTime']);?></div></td>
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="view.php?OrderId=<?=$order_row[$i]['OrderId']?>&OId=<?=$order_row[$i]['OId']?>">修改</a>
                                
                    </td>               
                </tr> 
                <?php }?>             
            </table>            
        </div> 

        <input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
        <input type="hidden" name="page" value="<?=$page;?>">
        <input name="list_form_action" id="list_form_action" type="hidden" value="">     
        <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>
    </form>
<?php include('../../inc/manage/footer.php');?>