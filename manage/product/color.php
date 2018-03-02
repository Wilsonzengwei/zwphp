<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_color';
check_permit('product_color');

if($_POST['action']=='order_color'){
	check_permit('', 'product.color.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$CId=(int)$_POST['CId'][$i];
		$order=abs((int)$_POST['MyOrder'][$i]);
		
		$db->update('product_color', "CId='$CId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	
	save_manage_log('产品颜色排序');
	
	header('Location: color.php');
	exit;
}

if($_POST['action']=='del_color'){
	check_permit('', 'product.color.del');
	if(count($_POST['select_CId'])){
		$CId=implode(',', $_POST['select_CId']);
		$where="CId in($CId)";
		
		if(get_cfg('product.color.upload_pic')){
			$color_row=$db->get_all('product_color', $where, 'PicPath');
			for($i=0; $i<count($color_row); $i++){
				del_file($color_row[$i]['PicPath']);
				del_file(str_replace('s_', '', $color_row[$i]['PicPath']));
			}
		}
		$db->delete('product_color', $where);
	
	save_manage_log('批量删除产品颜色');
	
	echo '<script>alert("批量删除成功");</script>';
    header('Refresh:0;url=color.php?$query_string&page=$page"');
	exit;
    }else{
        echo '<script>alert("未选中选项,批量删除失败");</script>';
        header('Refresh:0;url=color.php?$query_string&page=$page"');
        exit;
    }
}

if($_GET['act']=='del_color'){
    check_permit('', 'product.color.del');
    $CId_r = $_GET['CId'];
    $db->delete('product_color', "CId='$CId_r'");
    
    save_manage_log('删除产品颜色');
    
    echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=color.php?$query_string&page=$page"');
    exit;
}
include('../../inc/manage/header.php');
?>
<!-- <form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
        <span class="fc_gray mgl14">颜色名称:<input name="FullName" class="form_input" type="text" size="10" maxlength='20'></span>
        <span class="fc_gray mgl14">颜色来源：<select class="owidth" name="" type="text"><option value="">全部</option></select></span>
        
        <input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">
</form> -->
        
<form style="width:100%;background:#ececec;margin-top:30px"  method="post" action="color.php" class="list_form" name="list_form" id="list_form">
        <div>
            <a href="color_add.php?act=添加颜色"><input name="product_del" id="product_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="添加颜色"></a>           
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_CId[]");' value="全选">
            <input name="del_color" id="del_color" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'action');">
        </div>
    <div style="background:#fff;color:#666;font-size:12px">
        <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
            <tr style="height:60px;width:100%" align="center">                   
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%" nowrap>选项</td>
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="5%" nowrap>序号</td>
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center">颜色名称</a></td>
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">颜色来源</a></td>
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:250px;text-align:left;overflow:hidden;text-align:center">描述</a></td>
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">创建人</a></td>
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="6%" nowrap><div style="width:70px">创建时间</div></td>                
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="10%" nowrap>操作</td>  
            </tr>
            <?php
                $color_row=$db->get_all('product_color', 1, '*', 'AddTime desc, CId asc');
                for($i=0; $i<count($color_row); $i++){
            ?>
            <tr class="list" style="height:60px;width:100%;" align="center">                   
                <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" >
                    <input class="yx" type="checkbox" name="select_CId[]" id="" value="<?=$color_row[$i]['CId']?>">
                </td>
                <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><?=$i+1?></td>
                <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center"><?=$color_row[$i]['Color_lang_1']?></a></td>
                <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">系统</a></td>
                <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:250px;text-align:left;overflow:hidden;text-align:center"><?=$color_row[$i]['Description']?></a></td>
                <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$color_row[$i]['AddName']?></a></td>
                <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="6%" ><div style="width:70px"><?=date("Y-m-d H:i:s",$color_row[$i]['AddTime']);?></div></td>                
                <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                    <a href="color_mod.php?CId=<?=$color_row[$i]['CId']?>">修改</a>                      
                    <a href="color.php?CId=<?=$color_row[$i]['CId']?>&act=del_color">删除</a>
                    <a href="">查看</a>
                </td>                  
            </tr>           
           <?php }?>
        </table>    
                      
            <input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
            <input type="hidden" name="page" value="<?=$page;?>">
            <input name="action" id="action" type="hidden" value="">
     
    <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>      
</form>
<?php include('../../inc/manage/footer.php');?>