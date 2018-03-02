<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$AId = $_GET['AId'];
if($_POST){
    $Titles = $_POST['Titles'];
    $Titles_en = $_POST['Titles_en'];
    $Titles_lang_1 = $_POST['Titles_lang_1'];

    $KeyWords = $_POST['KeyWords'];
    $Description = $_POST['Description'];
    $TypeManage = $_POST['TypeManage'];
    $Content = $_POST['Content'];
    $Content_en = $_POST['Content_en'];
    $Content_lang_1 = $_POST['Content_lang_1'];
    $AddTime = time();
    $AId = $_POST['AId'];
    $Language = $_POST['Language'];
    $db->update('articles',"AId='$AId'",array(
        'Titles'        =>  $Titles,
        'Titles_en'     =>  $Titles_en,
        'Titles_lang_1' =>  $Titles_lang_1,
        'KeyWords'      =>  $KeyWords,
        'Description'   =>  $Description,
        'Content'       =>  $Content,
        'Content_en'    =>  $Content_en,
        'Content_lang_1'=>  $Content_lang_1,
        'SAId'          =>  $TypeManage,
        'Language'      =>  $Language,
        ));
    
    
    save_manage_log('添加帮助管理页：'.$Title);
    
    header('Location: index.php?GroupId='.$GroupId);
    exit;
}
$articles_row = $db->get_one('articles',"AId='$AId'");
include('../../inc/manage/header.php');
?>
<script charset="utf-8" src="/plugin/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/plugin/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/plugin/kindeditor/plugins/code/prettify.js"></script>
<script>
    <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
        KindEditor.ready(function(K) {
            var editor1 = K.create('.content_duo', {
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
<form style="background:#fff;min-height:600px;width:95%" action="mod.php" method="post" class="act_form" enctype="multipart/form-data">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">添加</div>
    <div class="y_form"><span class="y_title">协议标题(中文)：</span><input class="y_title_txt" type="text" name="Titles_lang_1" value="<?=$articles_row['Titles_lang_1']?>"></div>
    <div class="y_form"><span class="y_title">协议标题(英文)：</span><input class="y_title_txt" type="text" name="Titles_en" value="<?=$articles_row['Titles_en']?>"></div> 
    <div class="y_form"><span class="y_title">协议标题(西文)：</span><input class="y_title_txt" type="text" name="Titles" value="<?=$articles_row['Titles']?>"></div> 
    <div class="y_form"><span class="y_title">帮助类型：</span>
        <select name="TypeManage" id="">
        <?php 
            $help_row =$db->get_all('articles',"Mode=1");

            for($i=0;$i<count($help_row);$i++){
                $inc = $i+1;
        ?>
            <option value="<?=$help_row[$i]['AId']?>" <?=$articles_row['SAId'] == $help_row[$i]['AId'] ? selected : '';?>><?=$help_row[$i]['Titles_lang_1']?></option>
        <?php }?>
           
        </select></div> 
         <div class="y_form"><span class="y_title">语言：</span>
        <select name="Language" id="">
            <option value="1" <?=$articles_row['Language'] == '1' ? selected : '';?>>中文</option>
            <option value="2" <?=$articles_row['Language'] == '2' ? selected : '';?>>西班牙文</option>
           
        </select></div> 
    <div class="y_form"><span class="y_title">关键词：</span><input class="y_title_txt" type="text" name="KeyWords" value="<?=$articles_row['KeyWords']?>"></div> 
    <div class="y_form"><span class="y_title">描述：</span><input class="y_title_txt" type="text" name="Description" value="<?=$articles_row['Description']?>"></div> 
    <div style="clear: both;"></div>
    <div class="editor_row" style="margin-top: 80px;color:#666;font-size:12px;    font-weight: bold;">
        <div class="editor_title fl">详细介绍(中文):</div>

        <div class="editor_con ck_editor fl">
        <textarea style="min-height: 400px;width: 780px;" name="Content_lang_1" class="form-control content_duo"><?=htmlspecialchars($articles_row['Content_lang_1']);?></textarea> 
        </div>
        <div class="clear"></div>
    </div>
    <div class="editor_row" style="margin-top: 80px;color:#666;font-size:12px;    font-weight: bold;">
        <div class="editor_title fl">详细介绍(英文):</div>

        <div class="editor_con ck_editor fl">
        <textarea style="min-height: 400px;width: 780px;" name="Content_en" class="form-control content_duo"><?=htmlspecialchars($articles_row['Content_en']);?></textarea> 
        </div>
        <div class="clear"></div>
    </div>
    <div class="editor_row" style="margin-top: 80px;color:#666;font-size:12px;    font-weight: bold;">
        <div class="editor_title fl">详细介绍(西文):</div>

        <div class="editor_con ck_editor fl">
        <textarea style="min-height: 400px;width: 780px;" name="Content" class="form-control content_duo"><?=htmlspecialchars($articles_row['Content']);?></textarea> 
        </div>
        <div class="clear"></div>
    </div>
    <div class="y_submit">
        <input type="hidden" name="AId" value="<?=$AId?>">
        <input class="ys_input" type="submit" value="保存">
    </div>

</form>
<?php include('../../inc/manage/footer.php');?>