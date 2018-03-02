<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
check_permit('article_group_0');
if($_GET['act']=='dle_articles'){
    $AId_dle = $_GET['AId'];
    $db->delete('articles',"AId='$AId_dle'");
    save_manage_log('删除帮助页面');
    echo '<script>alert("删除成功");</script>';
    header('Refresh:0;url=index.php?$query_string&page=$page"');
    exit;
}
if($_POST['list_form_action']=='articles_del'){
    check_permit('', 'member.del');
    if(count($_POST['select_AId'])){
        $AId=implode(',', $_POST['select_AId']);
        $where="AId in($AId)";
       
        
        $db->delete('articles', "AId in($AId)");
        
    
    save_manage_log('批量删除管理页');
    
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

$where="AId>6";
if($_GET['Titles']){
    $Titles_s = $_GET['Titles'];
    $where .= " and Titles like '%$Titles_s%'";
}
if($_GET['TypeManage']){
    $TypeManage_s = $_GET['TypeManage'];
    $where .= " and SAId='$TypeManage_s'";
}
if($_GET['Language']){
    $Language_s = $_GET['Language'];
    $where .= " and Language='$Language_s'";
}
$row_count=$db->get_row_count('articles', $where);
$total_pages=ceil($row_count/get_cfg('member.page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('member.page_count');
$articles_row=$db->get_limit('articles', $where, '*', 'AddTime desc', $start_row, get_cfg('member.page_count'));
include('../../inc/manage/header.php');
?>
<form style="width:100%;background:#fff;height:60px;line-height:60px;" method="get" action="index.php">
    <span class="fc_gray mgl14">标题:<input name="Titles" class="form_input2" type="text" size="10" maxlength='20' value="<?=$Titles_s?>"></span>
    <span style="font-size:14px;color:#666;margin-left:20px">帮助类型:</span>
        <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="TypeManage" id="">

            <option value="0">全部</option>
            <?php 
                $articless_row=$db->get_all('articles', 'AId<7');
                //var_dump( $articless_row);exit;
                for ($i=0; $i <4; $i++) { 
            ?>
                <option value="<?=$articless_row[$i]['AId']?>" <?=$TypeManage_s == $articless_row[$i]['AId'] ? selected : '' ;?>><?=$articless_row[$i]['Titles_lang_1']?></option>
            <?php }?>
            
        </select>
    <span style="font-size:14px;color:#666;margin-left:20px">语言类型:</span>
        <select style="width:100px;height:25px;border-radius:3px;font-size:12px;color:#666" name="Language" id="">
            <option value="0">全部</option>
            <option value="1" <?=$Language_s == '1' ? selected : '' ;?>>中文</option>
            <option value="2" <?=$Language_s == '2' ? selected : '' ;?>>西班牙文</option>
        </select>
    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button" />
 </form>
<form style="width:100%;background:#ececec;margin-top:30px"  method="post" action="index.php" class="list_form" name="list_form" id="list_form">
        <div>
            <a href="add.php" style="display:inline-block;margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px">添加帮助</a>
            <input name="button" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" onClick='change_all("select_AId[]");' value="全选">
            <input name="articles_del" id="articles_del" type="button" style="margin:5px;height:25px;line-height:25px;padding:0px 20px;color:#fff;font-size:12px;background:#0b8fff;border:none;border-radius:3px" value="批量删除" onClick="click_button(this, 'list_form', 'list_form_action');">
            
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
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">帮助类型</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">语言类型</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">关键词</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" nowrap><div style="width:70px">创建时间</div></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" nowrap><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center">创建人</a></td>
                    <td style="background:#c8c9cd;border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" nowrap>操作</td>                               
                </tr>
                <?php 
                    for ($i=0; $i < count($articles_row); $i++) { 
                       
                        $SAId = $articles_row[$i]['SAId'];
                        $SAId_r = $db->get_one('articles',"AId='$SAId'","Titles_lang_1");
                   
                        if($articles_row[$i]['Language'] == '1'){
                            $Language_r = "中文";
                        }elseif($articles_row[$i]['Language'] == '2'){
                            $Language_r = "西班牙文";
                        }
                ?>
                <tr class="list" style="width:100%;height:60px;bgcolor:#fff" align="center">                   
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="2%" >
                        <input class="yx" type="checkbox" name="select_AId[]" id="" value="<?=$articles_row[$i]['AId']?>">
                    </td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="4%"><?=$start_row+$i+1?></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%"><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:77px;overflow:hidden;text-align:center"><?=$articles_row[$i]['Titles_lang_1']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$SAId_r['Titles_lang_1']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$Language_r?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$articles_row[$i]['KeyWords']?></a></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="5%" ><div style="width:70px"><?=date("Y-m-d H:i:s",$articles_row[$i]['AddTime']);?></div></td>
                    <td style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="7%" ><a style="display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;width:90px;text-align:left;overflow:hidden;text-align:center"><?=$articles_row[$i]['AddName']?></a></td>              
                    <td class="operation" style="border-bottom:1px solid #e5e5e5;border-right:1px solid #e5e5e5" width="10%" >
                        <a href="mod.php?AId=<?=$articles_row[$i]['AId']?>">修改</a>
                        <a href="index.php?act=dle_articles&AId=<?=$articles_row[$i]['AId']?>">删除</a>
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