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
				'MyOrder'	=>	$order
			)
		);
	}
	
	save_manage_log('快递方式排序');
	
	header('Location: index.php');
	exit;
}
if($_GET['act'] == 'del_one'){
    $SId=$_GET['SId'];
    $shipping = $db->get_one('shipping',"SId='$SId'");
    $db->delete('shipping', "SId='$SId'");
    del_file($shipping['PicPath']);
    save_manage_log('删除快递方式');
    echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
}
if($_POST['list_form_action']=='del_shipping'){

	if(count($_POST['select_SId'])){
		$SId=implode(',', $_POST['select_SId']);
		$db->delete('shipping', "SId in($SId)");
        $shipping_row=$db->get_all('shipping', "SId in($SId)");
        for($i=0; $i<count($shipping_row); $i++){
            del_file($shipping_row[$i]['PicPath']);
        }
	
	save_manage_log('批量删除快递方式');
	
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
if($_GET['FirmName']){
    $FirmName = $_GET['FirmName'];
    $where .= " and FirmName like '%$FirmName%'";
}
if($_GET['Express']){
    $Express = $_GET['Express'];
    $where .= " and Express='$Express'";
}
$row_count=$db->get_row_count('shipping', $where);
$total_pages=ceil($row_count/get_cfg('orders.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('shipping.page_count');
$shipping_row=$db->get_limit('shipping', $where, '*', "ShippingTime desc", $start_row, get_cfg('shipping.page_count'));
include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
        <span style="font-size:14px;color:#666;margin-left:20px">企业名称:</span>
        <input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="FirmName" value="<?=$FirmName?>">
        <span style="font-size:14px;color:#666;margin-left:20px">运输类型:</span>
        <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="Express" id="">
            <option value="0" <?=$Express == '0' ? selected : '';?>>全部</option>
            <option value="1" <?=$Express == '1' ? selected : '';?>>空运</option>
            <option value="2" <?=$Express == '2' ? selected : '';?>>海运</option>
        </select>
        <input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">
</form>
<form style="width:100%;background:#ececec;margin-top:30px" class="list_form" name="list_form" id="list_form"  method="post" action="index.php">
        <div>
            <a href="add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加运输方式</a>
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_SId[]");' value="全选">
            <input name="del_shipping" id="del_shipping" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
            
            <span style="position:absolute;right:20px">
                <span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px"><?=$row_count?></span><span style="font-size:12px;color:#999">种运输方式</span>
            </span>
        </div>
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">企业名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>运输类型</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:inline-block;width:47px;overflow:hidden;text-align:center">图片</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">法人代表</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center">联系电话</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">联系地址</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">创建人</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">创建时间</div></td>

                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>                               
                </tr>
                <?php 

                for($i=0;$i<count($shipping_row);$i++){
                    if($shipping_row[$i]['Express'] == '1'){
                        $Express = '空运';
                    }elseif($shipping_row[$i]['Express'] == '2'){
                        $Express = '海运';
                    }
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" >
                        <input class="yx" type="checkbox" name="select_SId[]" value="<?=$shipping_row[$i]['SId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$start_row+$i+1;?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$shipping_row[$i]['FirmName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$Express?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:inline-block;width:80px;height:30px;overflow:hidden;text-align:center"><img style="width:100%;height:100%" src="<?=$shipping_row[$i]['PicPath']?>" alt=""></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$shipping_row[$i]['DelName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="word-break: break-all;word-wrap:break-word;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center"><?=$shipping_row[$i]['Mobile']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$shipping_row[$i]['Address']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$shipping_row[$i]['CreateName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date("Y-m-d H:i:s",$shipping_row[$i]['ShippingTime'])?></div></td>
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="mod.php?SId=<?=$shipping_row[$i]['SId']?>">修改</a>
                        <a href="index.php?SId=<?=$shipping_row[$i]['SId']?>&act=del_one">删除</a>
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