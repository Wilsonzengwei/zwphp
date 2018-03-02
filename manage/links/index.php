<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='links';
check_permit('links');

if($_POST['list_form_action']=='links_order'){
	check_permit('', 'links.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$order=abs((int)$_POST['MyOrder'][$i]);
		$LId=(int)$_POST['LId'][$i];
		
		$db->update('links', "LId='$LId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	save_manage_log('友情链接排序');
	
	$page=(int)$_POST['page'];
	$query_string=urldecode($_POST['query_string']);
	header("Location: index.php?$query_string&page=$page");
	exit;
}

if($_POST['list_form_action']=='links_del'){
	check_permit('', 'links.del');
	if(count($_POST['select_LId'])){
		$LId=implode(',', $_POST['select_LId']);
		$where="LId in($LId)";
		
		if(get_cfg('links.upload_logo')){
			$links_row=$db->get_all('links', $where, 'LogoPath');
			for($i=0; $i<count($links_row); $i++){
				del_file($links_row[$i]['LogoPath']);
				del_file(str_replace('s_', '', $links_row[$i]['LogoPath']));
			}
		}
		$db->delete('links', $where);
	
	save_manage_log('批量删除友情链接');
	
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
if($_GET['act'] == 'del_links'){
    $del_links = $_GET['LId'];
    $db->delete('links',"LId='$del_links'");
    save_manage_log('删除友情链接');
    echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
    exit;
}
if($_GET['query_string']){
	$page=(int)$_GET['page'];
	header("Location: index.php?{$_GET['query_string']}&page=$page");
	exit;
}

//分页查询
$where=1;
$Name=$_GET['Name'];
$Url=$_GET['Url'];
$Language=$_GET['Language'];
$Name && $where.=" and Name like '%$Name%'";
$Url && $where.=" and Url like '%$Url%'";
$Language && $where.=" and Language='$Language'";

$row_count=$db->get_row_count('links', $where);
$total_pages=ceil($row_count/get_cfg('links.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('links.page_count');
$links_row=$db->get_limit('links', $where, '*', 'AddTime desc, LId asc', $start_row, get_cfg('links.page_count'));

//获取页面跳转url参数
$query_string=query_string('page');

include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
    <span style="font-size:14px;color:#666;margin-left:20px">标题:</span>
    <input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="Name" value="<?=$Name?>">
    <span style="font-size:14px;color:#666;margin-left:20px">链接地址:</span>
    <input style="width:150px;height:25px;border:1px solid #ccc;border-radius:3px" type="text" name="Url" value="<?=$Url?>">
    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button" />
 </form>
<form style="width:100%;background:#ececec;margin-top:30px"  method="post" action="index.php" class="list_form" name="list_form" id="list_form">
        <div>
            <a href="add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加链接</a>
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_LId[]");' value="全选">
            <input name="links_del" id="links_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
            
            <span style="position:absolute;right:20px">
                <span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px">3</span><span style="font-size:12px;color:#999">条数据</span>
            </span>
        </div>
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="2%" nowrap>选项</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">标题</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">链接地址</a></td>
                    
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">关键字</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">创建时间</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">创建人</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>                               
                </tr>
                <?php 

                for ($i=0; $i < count($links_row); $i++) { 
                   
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="2%" >
                        <input class="yx" type="checkbox" name="select_LId[]" id="" value="<?=$links_row[$i]['LId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%"><?=$start_row+$i+1?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$links_row[$i]['Name']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$links_row[$i]['Url']?></a></td>
                    
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$links_row[$i]['Description']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date("Y-m-d H:i:s",$links_row[$i]['AddTime']);?></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$links_row[$i]['AddName']?></a></td>              
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="mod.php?LId=<?=$links_row[$i]['LId']?>">修改</a>
                        <a href="index.php?LId=<?=$links_row[$i]['LId']?>&act=del_links">删除</a>
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