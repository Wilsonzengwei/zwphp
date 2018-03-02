<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='shipping';
check_permit('shipping');
$jurisdiction = $_SESSION['ly200_AdminGroupId'];
if($_POST['action']=='order_shipping'){
    check_permit('', 'shipping.order');
    for($i=0; $i<count($_POST['MyOrder']); $i++){
        $SId=(int)$_POST['SId'][$i];
        $order=abs((int)$_POST['MyOrder'][$i]);
        
        $db->update('shipping', "SId='$SId'", array(
                'MyOrder'   =>  $order
            )
        );
    }
    
    save_manage_log('快递方式排序');
    
    header('Location: index.php');
    exit;
}

if($_GET['act'] == 'del_payment1'){
    $PId=$_GET['PId'];
    $payment = $db->get_one('payment_method',"PId='$PId'");
    $db->delete('payment_method', "PId='$PId'");
    del_file($payment['PicPath']);
    save_manage_log('删除付费方式');
    echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
    exit;
}

if($_POST['list_form_action']=='del_payment'){

    if(count($_POST['select_PId'])){
        $PId=implode(',', $_POST['select_PId']);
        $db->delete('payment_method', "PId in($PId)");
        $payment_row=$db->get_all('payment_method',"PId in($PId)");
        for($i=0; $i<count($payment_row); $i++){
            del_file($payment_row[$i]['PicPath']);
        }
    
    save_manage_log('批量删除付费方式');
    
    echo '<script>alert("批量删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
    exit;
    }else{
        echo '<script>alert("未选中选项,批量删除失败");</script>';
        header('Refresh:0;url=index.php?$query_string&page=$page"');
        exit; 
    }
}


$where = 1;
if($_GET['CollectNum1']){
    $CollectNum1 = $_GET['CollectNum1'];
    $where .= " and CollectNum1 like '%$CollectNum1%'";
}
if($_GET['TransType']){
    $TransType = $_GET['TransType'];
    $where .= " and TransType='$TransType'";
}

$row_count=$db->get_row_count('payment_method', $where);
$total_pages=ceil($row_count/get_cfg('payment_method.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('payment_method.page_count');
//var_dump($where);exit;
$payment_method_row =$db->get_limit('payment_method', $where, '*', "PTime desc", $start_row, get_cfg('payment_method.page_count'));
include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
        
        <span style="font-size:14px;color:#666;margin-left:20px">收款账号:</span>
        <input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="CollectNum1" value="<?=$CollectNum1?>">
        <span style="font-size:14px;color:#666;margin-left:5px">收款类型:</span>
        <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="TransType">
            <option value="0" <?=$TransType == '0' ? selected :'';?>>全部</option>
            <option value="1" <?=$TransType == '1' ? selected :'';?>>线上</option>
            <option value="2" <?=$TransType == '2' ? selected :'';?>>线下</option>
        </select>
        
        <input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">
</form>
<form style="width:100%;background:#ececec;margin-top:30px" name="list_form"  class="list_form" id="list_form" method="post" action="index.php">
        <div>
            <a href="add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加产品</a>
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_PId[]");' value="全选">
            <input name="del_payment" id="del_payment" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
            
            <span style="position:absolute;right:20px">
                <span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px"><?=$row_count?></span><span style="font-size:12px;color:#999">种付费方式</span>
            </span>
        </div>
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">收款账号</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">收款企业名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:inline-block;width:60px;overflow:hidden;text-align:center">企业Logo</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">法人代表</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">付费类型</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center">联系电话</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">联系地址</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">创建人</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">创建时间</div></td>

                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="25%" nowrap>操作</td>                               
                </tr>
                <?php 
                    for($i=0;$i<count($payment_method_row);$i++){
                        if($payment_method_row[$i]['TransType'] == '1'){
                            $TransType = '线上';
                        }elseif($payment_method_row[$i]['TransType'] == '2'){
                            $TransType = '线下';
                        }
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" >
                        <input class="yx" type="checkbox" name="select_PId[]" id="" value="<?=$payment_method_row[$i]['PId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$start_row+$i+1;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$payment_method_row[$i]['CollectNum1']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$payment_method_row[$i]['FirmName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:inline-block;width:80px;height:30px;overflow:hidden;text-align:center"><img style="width:100%;height:100%" src="<?=$payment_method_row[$i]['PicPath']?>" alt=""></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$payment_method_row[$i]['DelName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$TransType?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center"><?=$payment_method_row[$i]['Mobile']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$payment_method_row[$i]['Address']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$payment_method_row[$i]['CreateName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date("Y-m-d H:i:s",$payment_method_row[$i]['PTime'])?></div></td>
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="25%" >
                        <a href="mod.php?PId=<?=$payment_method_row[$i]['PId']?>">修改</a>
                        <a href="index.php?PId=<?=$payment_method_row[$i]['PId']?>&act=del_payment1">删除</a>
                        <a href="">查看</a> 
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