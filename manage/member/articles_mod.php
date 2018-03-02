<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$AId = $_GET['AId'];
if($_POST){
    $Description = $_POST['Description'];
    $Contents = $_POST['Contents_lang_1'];
    $AId = $_POST['AId'];
    $db->update('article',"AId='$AId'",array(
        
        'Description'       =>  $Description,
        'Contents_lang_1'   =>  $Contents,
        
        ));
    
    
    save_manage_log('添加帮助管理页：'.$Title);
    
    header('Location: articles.php?GroupId=0');
    exit;
}
$article_row = $db->get_one('article',"AId='$AId'");
include('../../inc/manage/header.php');
?>
<script charset="utf-8" src="/plugin/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/plugin/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/plugin/kindeditor/plugins/code/prettify.js"></script>
<script>
    <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
        KindEditor.ready(function(K) {
            var editor1 = K.create('#content_duo', {
                cssPath: '/plugin/kindeditor/plugins/code/prettify.css',
                uploadJson: '/plugin/kindeditor/php/upload_json.php',
                fileManagerJson: '/plugin/kindeditor/php/file_manager_json.php',
                allowFileManager: true,
                afterCreate: function() {
                    var self = this;
                    K.ctrl(document, 13, function() {
                        self.sync();
                        K('form[name=info]')[0].submit();
                    });
                    K.ctrl(self.edit.doc, 13, function() {
                        self.sync();
                        K('form[name=info]')[0].submit();
                    });
                }
            });
            prettyPrint();
        });
        <?php }?>
     </script> 
<form style="background:#fff;min-height:600px;width:95%" action="articles_mod.php" method="post" class="act_form" enctype="multipart/form-data">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">添加</div>
    <div class="y_form"><span class="y_title">协议标题：</span><input class="y_title_txt" type="text" name="" value="<?=$article_row['Title_lang_1']?>"></div>
    <div class="y_form"><span class="y_title">描述：</span><input class="y_title_txt" type="text" name="Description" value="<?=$article_row['Description']?>"></div> 
    <div style="clear: both;"></div>
    <div class="editor_row" style="margin-top: 80px;color:#666;font-size:12px;    font-weight: bold;">
        <div class="editor_title fl"><?=get_lang('ly200.description')?>:</div>

        <div class="editor_con ck_editor fl">
        <textarea style="min-height: 400px;width: 780px;" name="Contents_lang_1" id="content_duo" class="form-control"><?=htmlspecialchars($article_row['Contents_lang_1']);?></textarea> 
        </div>
        <div class="clear"></div>
    </div>
    <div class="y_submit">
        <input type="hidden" name="AId" value="<?=$AId?>">
        <input class="ys_input" type="submit" value="保存">
    </div>

</form>
<?php include('../../inc/manage/footer.php');?>