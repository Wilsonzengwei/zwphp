<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='transclear';
check_permit('transclear');

$where = "1";
$row_count=$db->get_row_count('trans_clear', $where);

$total_pages=ceil($row_count/get_cfg('transclear.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('transclear.page_count');
$trans_clear_row = $db->get_limit("trans_clear",$where,'*',"AccTime desc",$start_row,'20');
include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
    <span class="fc_gray mgl14">订单号:<input class="form_input2" type="text" size="10" maxlength='20' name="OId" value="<?=$OId?>"></span>
    <span class="fc_gray mgl14">跟进人:<input style="width: 50px;" class="form_input2" type="text" size="10" maxlength='20' name="FullName" value="<?=$FullName?>"></span>
    <span class="fc_gray mgl14">运输方式:<input class="form_input2" type="text" size="10" maxlength='20' name="Email" value="<?=$Email?>"></span>
    <span style="font-size:14px;color:#666;margin-left:5px">清关方式:</span>
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

            <option value="<?=$key;?>" style="color:;" <?=$OrderStatus == $key ? selected : '';?>><?=$value;?>&nbsp;<span style="color:red;"><?=$orders_table_row;?></option>
        <?php }?>
    </select>
    <span class="fc_gray mgl14"><?=get_lang('ly200.time');?>:<input style="width:100px" name="OrderTimeS" type="text" size="12" contenteditable="false" value="<?=$OrderTimeS?>" class="form_input" id="SelectDateS"/><span style="padding:0 10px">-</span><input style="width:100px" name="OrderTimeE" type="text" size="12" contenteditable="false" value="<?=$OrderTimeE?>" class="form_input" id="SelectDateE"/></span>
    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button" />
 </form>
<form style="width:100%;background:#ececec;margin-top:30px" name="list_form" id="list_form" class="list_form"  method="post" action="index.php">
       
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   

                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">订单号服务号</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:80px;overflow:hidden;text-align:center">订单号</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">客户名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center">产品名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">运输方式</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>运输费用</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>清关方式</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%">清关费用</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:80px;overflow:hidden;text-align:center">跟进人</a></td>
                    
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">下单时间</div></td>

                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>                               
                </tr>
                <?php 
                    for ($i=0; $i < count($trans_clear_row); $i++) { 
                        $OrderId= $trans_clear_row[$i]['OrderId'];
                        $OId = $db->get_one('orders',"OrderId='$OrderId'");
                        $MemberId = $trans_clear_row[$i]['MemberId'];
                        $FirstName = $db->get_one('member',"MemberId='$MemberId'");
                        if($trans_clear_row[$i]['Transport'] == '0'){
                            $Transport_one = '自行运输';
                            $ZQprice ="0.00";
                        }elseif($trans_clear_row[$i]['Transport'] == '1'){
                            $Transport_one = '鹰洋代理空运';
                            $ZQprice = $trans_clear_row[$i]['TotalPrice'];
                        }elseif($trans_clear_row[$i]['Transport'] == '2'){
                            $Transport_one = '鹰洋代理海运';
                            $ZQprice = $trans_clear_row[$i]['TotalPrice'];
                        }
                        if($trans_clear_row[$i]['Clearance'] == '0'){
                            $Clearance_one = '自行清关';
                            $QPrice = "0.00";
                        }elseif($trans_clear_row[$i]['Clearance'] == '1'){
                            $Clearance_one = '鹰洋代理清关';
                            $QPrice = $trans_clear_row[$i]['QPrice'];
                        }
                        
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$start_row+$i+1;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$trans_clear_row[$i]['TOrderId']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:80px;text-align:left;overflow:hidden;text-align:center"><?=$OId['OId']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$FirstName['FirstName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center"><?=$trans_clear_row[$i]['PName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><?=$Transport_one?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" >USD $<?=$ZQprice;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><?=$Clearance_one;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%">USD $<?=$QPrice?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:80px;text-align:left;overflow:hidden;text-align:center"><?=$OId['FollowUp']?></a></td>
                    
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date("Y-m-d H:i:s",$trans_clear_row[$i]['AccTime']);?></div></td>
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="">查看</a>
                            
                        <a href="mod.php?TId=<?=$trans_clear_row[$i]['TId']?>">修改</a> 
                                      
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