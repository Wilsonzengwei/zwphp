<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_category';
check_permit('product_category');

if($_POST['action']=='order_category'){
    check_permit('', 'product.category.order');
    for($i=0; $i<count($_POST['MyOrder']); $i++){
        $CateId=(int)$_POST['CateId'][$i];
        $order=abs((int)$_POST['MyOrder'][$i]);
        
        $db->update('product_category', "CateId='$CateId'", array(
                'MyOrder'   =>  $order
            )
        );
    }
    
    save_manage_log('产品类别排序');
    
    header('Location: category.php');
    exit;
}

if($_POST['action']=='del_category'){
    check_permit('', 'product.category.del');
    if($_POST['select_CateId']){
        for($i=0; $i<count($_POST['select_CateId']); $i++){
            $CateId=(int)$_POST['select_CateId'][$i];
            $where=get_search_where_by_CateId($CateId, 'product_category');
            $category_row=$db->get_all('product_category', $where, 'PicPath, PageUrl');
            for($j=0; $j<count($category_row); $j++){
                del_dir($category_row[$j]['PageUrl']);
                if(get_cfg('product.category.upload_pic')){
                    del_file($category_row[$j]['PicPath']);
                    del_file(str_replace('s_', '', $category_row[$j]['PicPath']));
                }
            }
            
            $db->delete('product_category_description', $where);
            $db->delete('product_category', $where);
        }
        
        category_subcate_statistic('product_category');
        
        save_manage_log('批量删除产品类别');
        
        echo '<script>alert("批量删除成功");</script>';
        header('Refresh:0;url=category.php?$query_string&page=$page"');
        exit;
    }else{
        echo '<script>alert("未选中选项，批量删除失败");</script>';
        header('Refresh:0;url=category.php?$query_string&page=$page"');
        exit;
    }
    
}
if($_GET['act']=='del_category'){
    check_permit('', 'product.category.del');
        $CateId=(int)$_GET['CateId'];

        $db->delete('product_category', "CateId='$CateId'");
    
    
    category_subcate_statistic('product_category');
    
    save_manage_log('删除产品类别');
    
    echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=category.php?$query_string&page=$page"');
    exit;
}
include('../../inc/manage/header.php');
?>
<style>
    .yh{
        float: left;
    }
</style>
<!-- <form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
        <span class="fc_gray mgl14">类目名称:<input name="FullName" class="form_input" type="text" size="10" maxlength='20'></span>
        <span class="fc_gray mgl14">一级类目：<select class="owidth" name="" type="text"><option value="">全部</option></select></span>
        <span class="fc_gray mgl14">二级类目：<select class="owidth" name="" type="text"><option value="">全部</option></select></span>
        <span class="fc_gray mgl14">三级类目：<select class="owidth" name="" type="text"><option value="">全部</option></select></span>
        <input value="查找" style="min-width:60px;height:25px;background:#0b8fff;border:0px;border-radius:3px;font-size:12px;color:#f2f2f2;font-family:'Microsoft YaHei'" type="submit">
</form> -->
        
<form style="width:100%;background:#ececec;margin-top:30px" class="list_form" name="list_form" id="list_form"  method="post" action="category.php">
        <div>
            <a href="category_add.php?act=添加类目"><input name="product_del" id="product_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="添加类目"></a>           
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_ProId[]");' value="全选">
            <input name="del_category" id="del_category" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'action');">
        </div>
    <div style="background:#fff;color:#666;font-size:12px">
        <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
            <tr style="height:60px;width:100%" align="center">                   
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="10%" nowrap>选项</td>
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="10%" nowrap>排序</td>
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="60%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:107px;text-align:left;overflow:hidden;text-align:center">类目名称</a></td>
                            
                <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;" width="20%" nowrap>操作</td>  
            </tr>
            <?php
                $n=$m=0;
                $ext_category=array();
                $category_row=ouput_Category_to_Array_hill('product_category');
                $no_del_array = array(110); //  不能删除的分类
                for($i=0; $i<count($category_row); $i++){
                    if($category_row[$i]['Dept']==1){
                        $ext_category[$n++]=$ext_CateId_list;
                        $ext_CateId_list='';
                    }else{
                        $ext_CateId_list.=$m.',';
                    }
                    $cate_row_count = (int)$db->get_row_count('product_category',get_search_where_by_CateId($category_row[$i]['CateId'])." and CateId!='{$category_row[$i]['CateId']}'");
            ?>
            <tr align="center" class="category" id="category_<?=$m++;?>" style="display:<?=$category_row[$i]['Dept']==1?'':'none';?>;height:60px;overflow:hidden">
            <?php if(get_cfg('product.category.del')){?>
                <td>
                    <?php if(!in_array($category_row[$i]['CateId'],$no_del_array)){ ?>
                        <input name="select_CateId[]" type="checkbox" value="<?=$category_row[$i]['CateId'];?>" />
                    <?php } ?>
                </td>
            <?php }?>
            <?php if(get_cfg('product.category.order')){?>
                <td>
                    <?php if(!in_array($category_row[$i]['CateId'],$no_del_array)){ ?>
                        <input name="MyOrder[]" class="form_input3" type="text" size="5" maxlength="10" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="<?=htmlspecialchars($category_row[$i]['MyOrder']);?>" />
                        <input type="hidden" name="CateId[]" value="<?=$category_row[$i]['CateId'];?>" />
                    <?php } ?>
                </td>
            <?php }?>
            <td nowrap align="left" class="category_list_form_catename">
                <div style="float: left;" class="fz_18px category_list_form_catename_prechars"><?=str_repeat('&nbsp;&nbsp;',$category_row[$i]['Dept']==1?0:($category_row[$i]['Dept']*3));?></div>
                <?php if($category_row[$i]['Dept']==1 && $category_row[$i]['SubCate']){?><div class="yh">&nbsp;<img src="/manage/images/ico/category_close.png" onclick="category_sub_menu(<?=$n;?>);" id="category_img_<?=$n;?>" align="absmiddle" /></div><?php }?>
                <div class="yh"><a href="<?=get_url('product_category', $category_row[$i]);?>" target="_blank"><?=list_all_lang_data($category_row[$i], 'Category');?><?=$cate_row_count?" ($cate_row_count) ":''; ?></a><?=$category_row[$i]['IsInIndex'] && $category_row[$i]['Dept']==1 ? ' (首页显示)' : ''; ?></div>
                <?php if(get_cfg('product.category.upload_pic')){?><div class="yh"><?=creat_imgLink_by_sImg($category_row[$i]['PicPath'], 20, 20);?></div><?php }?>
            </td>
            <?php if(get_cfg('product.category.mod')){?><td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="category_mod.php?CateId=<?=$category_row[$i]['CateId'];?>">修改</a>
                        
                        <a href="category.php?CateId=<?=$category_row[$i]['CateId'];?>&act=del_category">删除</a> 
                    </td><?php }?>
        </tr>
        <?php }?>
        <?php if((get_cfg('product.category.order') || get_cfg('product.category.del')) && count($category_row)){?>
       
           <?php }?>
        </table>    
                      
            <input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
            <input type="hidden" name="page" value="<?=$page;?>">
            <input name="action" id="action" type="hidden" value="">
     
    <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>      
</form>
<?php
$ext_category[$n]=$ext_CateId_list;
for($i=0; $i<count($ext_category); $i++){
    echo "<input type='hidden' id='ext_category_$i' value='$ext_category[$i]'>";
}
echo "<input type='hidden' id='ext_category' value='$i'>";
?>
<?php include('../../inc/manage/footer.php');?>