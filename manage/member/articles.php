<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$GroupId=(int)$_GET['GroupId']?(int)$_GET['GroupId']:(int)$_POST['GroupId'];
$Group='group_0';

if($_POST['list_form_action']=='article_order'){
    !in_array($Group, get_cfg('article.amdo')) && no_permit();
    for($i=0; $i<count($_POST['MyOrder']); $i++){
        $order=abs((int)$_POST['MyOrder'][$i]);
        $AId=(int)$_POST['AId'][$i];
        
        $db->update('article', "AId='$AId'", array(
                'MyOrder'   =>  $order
            )
        );
    }
    save_manage_log('信息页排序');
    
    header("Location: index.php?GroupId=$GroupId");
    exit;
}

if($_POST['list_form_action']=='article_del'){
    !in_array($Group, get_cfg('article.amdo')) && no_permit();
    if(count($_POST['select_AId'])){
        $AId=implode(',', $_POST['select_AId']);
        
        $art_row=$db->get_all('article', "AId in($AId)", 'PageUrl');
        for($i=0; $i<count($art_row); $i++){
            del_file($art_row[$i]['PageUrl']);
        }
        
        $db->delete('article', "AId in($AId)");
    }
    save_manage_log('批量删除信息页');
    
    header("Location: index.php?GroupId=$GroupId");
    exit;
}
$where = "GroupId='0'";

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
$articles_row=$db->get_all('article', $where);
for ($i=0; $i < count($articles_row); $i++) { 
    
    $SupplierId = $articles_row[$i]['SupplierId'];
    $MEmail = $db->get_value('member','MemberId ='.$SupplierId,'Email');
    if($MEmail){
        $Supplier[] = $SupplierId ;
    }

    
    
}
if($Supplier){
    $SupplierId_r=implode(',', $Supplier);
    $where .= " and SupplierId in($SupplierId_r)";
}
$article_row=$db->get_all('article', $where, '*', 'MyOrder desc, AId asc');
include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="articles.php">
    <span class="fc_gray mgl14">标题:<input name="Titles" class="form_input2" type="text" size="10" maxlength='20'></span>
    
   <!--  <span style="font-size:14px;color:#666;margin-left:20px">语言类型:</span>
        <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="Language" id="">
            <option value="0">全部</option>
            <option value="1">中文</option>
            <option value="2">西班牙文</option>
        </select> -->
    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button" />
 </form>
<form style="width:100%;background:#ececec;margin-top:30px"  method="post" action="index.php" class="list_form" name="list_form" id="list_form">
        <!-- <div>
            <a href="add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加用户</a>
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_AId[]");' value="全选">
            <input name="articles_del" id="articles_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
            
            <span style="position:absolute;right:20px">
                <span style="font-size:12px;color:#999">共计有</span><span style="color:#006ac3;padding:0 3px">3</span><span style="font-size:12px;color:#999">条数据</span>
            </span>
        </div> -->
        <div style="background:#fff;color:#666;font-size:12px">
            <table class="haha" width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr style="height:60px;" align="center">                   
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="15%" nowrap>序号</td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="35%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center">标题</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="35%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">所属商户</a></td>
                    
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="15%" nowrap>操作</td>                               
                </tr>
                <?php 
                    for ($i=0; $i < count($article_row); $i++) { 
                       
                        $MEmail = $db->get_value('member','MemberId ='.$article_row[$i]['SupplierId'],'Email');
                        if($article_row[$i]['Title_lang_1']){
                            $Title = $article_row[$i]['Title_lang_1'];
                        }else{
                            $Title = $article_row[$i]['Title'];
                        }
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="15%"><?=$start_row+$i+1?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="35%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$article_row[$i]['Title_lang_1']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="35%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:80%;text-align:left;overflow:hidden;text-align:center"><?=$db->get_value('member','MemberId ='.$article_row[$i]['SupplierId'],'Email');?></a></td>
                                 
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="15%" >
                        <a href="articles_mod.php?AId=<?=$article_row[$i]['AId']?>">修改</a>
                        <a href="">查看</a> 
                    </td>   
                </tr>
                <?php }?>
                <input type="hidden" name="query_string" value="<?=urlencode($query_string);?>">
                <input type="hidden" name="page" value="<?=$page;?>">
                <input name="list_form_action" id="list_form_action" type="hidden" value="">                   
            </table>            
        </div>      
        <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>
    </form>
<?php include('../../inc/manage/footer.php');?>