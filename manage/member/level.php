<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'buyers_level_manage';
check_permit('buyers_level_manage');
if($_POST['list_form_action']=='level_del'){
	check_permit('', 'member.level.del');

	if(count($_POST['select_LId'])){
		$LId=implode(',', $_POST['select_LId']);
		$db->delete('member_level', "LId in($LId)");
	
    	save_manage_log('批量删除会员等级');
    	
    	$page=(int)$_POST['page'];
    	$query_string=urldecode($_POST['query_string']);

    	echo '<script>alert("批量删除成功");</script>';
        header('Refresh:0;url=level.php?$query_string&page=$page"');
    	exit;
    }else{
        echo '<script>alert("未选中选项,批量删除失败");</script>';
        header('Refresh:0;url=level.php?$query_string&page=$page"');
        exit;
    }
}
if($_GET['act']=='del_level_r'){
    check_permit('', 'member.level.del');
    $LId=$_GET['LId'];
    $db->delete('member_level',"LId='$LId'");
    save_manage_log('删除会员等级');
    
    $page=(int)$_POST['page'];
    $query_string=urldecode($_POST['query_string']);

    echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=level.php?$query_string&page=$page"');
    exit;
}
if($_GET['query_string']){
	$page=(int)$_GET['page'];
	header("Location: level.php?{$_GET['query_string']}&page=$page");
	exit;
}

//分页查询
$where="IsSupplier=0";
if($_GET['LevelName_s']){
    $LevelName_s = $_GET['LevelName_s'];
    $where .= " and LevelName like '%$LevelName_s%'";
}
if($_GET['Level_s']){
    $Level_s = $_GET['Level_s'];
    $where .= " and Level='$Level_s'";
}
if($_GET['CreateName_s']){
    $CreateName_s = $_GET['CreateName_s'];
    $where .= " and CreateName like '%$CreateName_s%'";
}
$row_count=$db->get_row_count('member_level', $where);
$total_pages=ceil($row_count/get_cfg('member.level.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('member.level.page_count');
$level_row=$db->get_limit('member_level', $where, '*', 'Discount desc', $start_row, get_cfg('member.level.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');
$a=$_GET['act'];
include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="level.php">
        <span style="font-size:14px;color:#666;margin-left:20px">等级名称:</span>
        <input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="LevelName_s" value="<?=$LevelName_s?>">
        <span style="font-size:14px;color:#666">等级:</span>
            <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="Level_s" id="">
                <option value="0">全部</option>
                <?php 
                    $level_row_r = $db->get_all('member_level',"IsSupplier=0",'*',"UpgradePriceS asc");
                    for ($i=0; $i < count($level_row_r); $i++) { 
                ?>
                    <option value="<?=$level_row_r[$i]['Level']?>" <?=$Level_s == $level_row_r[$i]['Level'] ? selected : '';?>><?=$level_row_r[$i]['Level']?></option>
                <?php }?>
            </select>
        <span style="font-size:14px;color:#666;margin-left:20px">创建人:</span>
        <input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="CreateName_s" value="<?=$CreateName_s?>">
        <input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">
</form>
<form style="width:100%;background:#ececec;margin-top:30px" class="list_form" name="list_form" id="list_form" method="post" action="level.php">
    <div>
        <a href="level_add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加等级</a>          
        <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_LId[]");' value="全选">
        <input name="level_del" id="level_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
    </div>
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;width:100%" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center">等级名称</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">等级</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center">积分标准</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%">消费金额</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:250px;text-align:left;overflow:hidden;text-align:center">描述</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center">创建人</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><div style="width:70px">创建时间</div></td>                 
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="10%" nowrap>操作</td>  
                </tr>
                <?php 
                    for ($i=0; $i < count($level_row); $i++) { 
                       

                ?>
                <tr class="list" style="height:60px;width:100%;" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" >
                        <input class="yx" type="checkbox" name="select_LId[]" id="" value="<?=$level_row[$i]['LId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><?=$start_row+$i+1?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$level_row[$i]['LevelName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$level_row[$i]['Level']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:100px;text-align:left;overflow:hidden;text-align:center"><?=$level_row[$i]['UpgradePriceS']?>~<?=$level_row[$i]['UpgradePriceE']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%">0.00</td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:250px;text-align:left;overflow:hidden;text-align:center"><?=$level_row[$i]['Remarks']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$level_row[$i]['CreateName']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><div style="width:70px"><?=date('Y-m-d H:i:s',$level_row[$i]['AccTime']);?></div></td>                
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="level_mod.php?LId=<?=$level_row[$i]['LId']?>">修改</a>                      
                        <a href="level.php?LId=<?=$level_row[$i]['LId']?>&act=del_level_r">删除</a>
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