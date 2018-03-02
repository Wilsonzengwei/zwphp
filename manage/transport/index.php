<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'transport';
check_permit('transport');

if($_POST['list_form_action']=='transpot_del'){
    check_permit('', 'transport.del');
    if(count($_POST['select_tran'])){
        $OrderId=implode(',', $_POST['select_tran']);
        $db->delete('transport', "TId in($OrderId)");
        
    
    save_manage_log('批量删除托运订单');
    
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
    }
}

if($_GET['query_string']){
    $page=(int)$_GET['page'];
    header("Location: index.php?{$_GET['query_string']}&page=$page");
    exit;
}
$where = 1;

$ShippingTimeS=$_GET['ShippingTimeS'];
$ShippingTimeE=$_GET['ShippingTimeE'];
if($ShippingTimeS && $ShippingTimeE){
    $ts=@strtotime($ShippingTimeS);
    $te=@strtotime($ShippingTimeE);
    $te && $te+=86400;
    ($ts && $te) && $where.=" and ShippingTime between $ts and $te";
}
$row_count=$db->get_row_count('transport', $where);

$total_pages=ceil($row_count/get_cfg('transport.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('transport.page_count');

//$start_row=($page-1)*get_cfg('transport.page_count');
if($_GET['STOId']){
    $STOId = $_GET['STOId'];
    $where.= " and TOId like '%$STOId%'";
}
if($_GET['SProductName']){
    $SProductName = $_GET['SProductName'];
    $where.= " and ProductName like '%$SProductName%'";
}
if($_GET['SFNAME']){
    $SFNAME = $_GET['SFNAME'];
    $where.= " and FNAME like '%$SFNAME%'";
}

$transport_row=$db->get_limit('transport', $where, '*', "ShippingTime asc");

//var_dump($transport_row);exit;
include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
    <span class="fc_gray mgl14">产品名称:<input name="SProductName" class="form_input2" type="text" size="10" maxlength='20' value="<?=$SProductName?>"></span>
    <span class="fc_gray mgl14">发货人:<input name="SFNAME" class="form_input2" type="text" size="10" maxlength='20' value="<?=$SFNAME?>"></span>
    <span class="fc_gray mgl14">提单号:<input name="STOId" class="form_input2" type="text" size="10" maxlength='20' value="<?=$STOId?>"></span>
    <span class="fc_gray mgl14"><?=get_lang('ly200.time');?>:<input style="width:100px" name="ShippingTimeS" type="text" size="12" contenteditable="false" value="<?=$ShippingTimeS?>" class="form_input" id="SelectDateS"/><span style="padding:0 10px">-</span><input style="width:100px" name="ShippingTimeE" type="text" size="12" contenteditable="false" value="<?=$ShippingTimeE?>" class="form_input" id="SelectDateE"/></span>
    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button" />
 </form>
<form style="width:100%;background:#ececec;margin-top:30px" name="list_form" class="list_form" id="list_form" method="post" action="index.php">
        <div>
            <a href="add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加托运中心</a>
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_tran[]");' value="全选">
            <input name="transpot_del" id="transpot_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
            <span style="position:absolute;right:20px">
                <span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px"><?=$row_count?></span><span style="font-size:12px;color:#999">条单号</span>
            </span>
        </div>
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="2%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">提单号</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">发货人</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">目的地</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center">联系电话</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">产品名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">数量</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">重量</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">运费</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">创建时间</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>                               
                </tr>
                <?php 
                    for($i=0;$i<count($transport_row);$i++){
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="2%" >
                        <input class="yx" type="checkbox" name="select_tran[]" id="" value="<?=$transport_row[$i]['TId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%"><?=$start_row+$i+1?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$transport_row[$i]['TOId']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$transport_row[$i]['FNAME']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$transport_row[$i]['Sdeliveryaddress']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center"><?=$transport_row[$i]['SMoble']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$transport_row[$i]['ProductName'];?></a></td>                    
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><span><?=$transport_row[$i]['Qty']?></span></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><span><?=$transport_row[$i]['Weight']?></span><span>kg</span></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><span><?=$transport_row[$i]['TotalPrice']?></span><span>美元</span></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date("Y-m-d H:i:s",$transport_row[$i]['ShippingTime'])?></div></td>
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="mod.php?TId=<?=$transport_row[$i]['TId']?>">修改</a>
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