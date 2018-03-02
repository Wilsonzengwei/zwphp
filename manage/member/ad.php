<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='ad_member';
check_permit('ad_member');

if($_POST['action']=='del_ad'){
	check_permit('', 'ad.del');
	if(count($_POST['del_AId'])){
		$AId=implode(',', $_POST['del_AId']);
		$db->delete('ad', "AId in($AId)");
	}
	save_manage_log('删除广告图片');
	
	header('Location: index.php');
	exit;
}

$where = "SupplierId!='0'";
if($_GET['hidden_r'] == 'select_ed'){

    $PageName = $_GET['PageName'];
    $where .= " and PageName like '%$PageName%'";
}
$Supplier = mysql_real_escape_string($_GET['Supplier']);
$Supplier && $supplier_list = $db->get_all('member',"Supplier_Name like '%$Supplier%' or Email like '%$Supplier%'",'MemberId');
if($supplier_list){
    $supplier_id = array();
    foreach((array)$supplier_list as $v){
        $supplier_id[] = $v['MemberId'];
    }
    $supplier_id=implode(',', $supplier_id);
}
$supplier_id && $where.=" and SupplierId in ({$supplier_id})";
$ad_row = $db->get_all('ad',$where,'*',"SupplierId Asc");
include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="ad.php">
        <span style="font-size:14px;color:#666;margin-left:20px">广告名称:</span>
        <input name="PageName" style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" value="<?=$PageName?>">
        <!-- <span style="font-size:14px;color:#666">状态:</span>
            <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="" id="">
                <option value="">全部</option>
                <option value="">全部</option>
                <option value="">全部</option>
            </select>
        <span style="font-size:14px;color:#666">所属角色:</span>
            <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="" id="">
                <option value="">全部</option>
            </select> -->
        <input type="hidden" name="hidden_r" value="select_ed">
        <input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">
</form>
<form style="width:100%;background:#ececec;margin-top:30px"  method="post" action="ad.php">
        
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;overflow:hidden;text-align:center">广告名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">广告位置</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:140px;text-align:left;overflow:hidden;text-align:center">广告尺寸</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">创建时间</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap>创建人</td>
                    
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>                               
                </tr>
                <?php 
                    for ($i=0;$i<count($ad_row);$i++){ 
                       
                    
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><?=$i+1?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:140px;text-align:left;overflow:hidden;text-align:center"><?=$ad_row[$i]['PageName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$ad_row[$i]['AdPosition']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:140px;text-align:left;overflow:hidden;text-align:center">宽：<?=$ad_row[$i]['Width']?>PX  高：<?=$ad_row[$i]['Height']?>PX</a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px">2017-11-09 13：45：00</div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" >后台管理员</td>
                    
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="ad_mod.php?AId=<?=$ad_row[$i]['AId']?>">修改</a>
                        <a href="add.php?act=查看角色">查看</a>
                    </td>               
                </tr>
                <?php }?>
                
            </table>            
        </div>      
        <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>
    </form>
<?php include('../../inc/manage/footer.php');?>