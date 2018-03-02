<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='links';
check_permit('links', 'links.add');
$LId=$_GET['LId'];
if($_POST){
    $LId=$_POST['LId'];
    $Name=$_POST['Name'];
    $Url=$_POST['Url'];
    $Description=$_POST['Description'];
    $Time = time();

    $db->update('links',"LId='$LId'", array(
            'Name'          =>  $Name,
            'Url'           =>  $Url,
            'Description'   =>  $Description,
            
        )
    );
    
    save_manage_log('添加友情链接:'.$Name);
    
    header('Location: index.php');
    exit;
}
$links_row = $db->get_one('links',"LId='$LId'");
include('../../inc/manage/header.php');
?>
<form style="background:#fff;min-height:600px;width:95%" action="mod.php" method="post" class="act_form" enctype="multipart/form-data">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">友情链接添加</div>
    <div class="y_form1"><span class="y_title">标题：</span><input class="y_title_txt" type="text" name="Name" value="<?=$links_row['Name']?>"></div> 
    <div class="y_form1"><span class="y_title">链接地址：</span><input class="y_title_txt" type="text" name="Url" value="<?=$links_row['Url']?>"></div> 
    <div class="y_form1"><span class="y_title">备注：</span><input class="y_title_txt" type="text" name="Description" value="<?=$links_row['Description']?>"></div> 
    <div class="y_submit">
        <input type="hidden" name="LId" value="<?=$LId?>">
        <input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="ys_input">
    </div>
</form>
<?php include('../../inc/manage/footer.php');?>