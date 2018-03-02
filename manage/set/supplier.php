<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'supplier_set';
check_permit('supplier_set');

$SupplierId = (int)$_GET['SupplierId'];
$supplier_row = $db->get_one('member',"MemberId='$SupplierId'");
$width = 360;
$height = 140;

if($_GET['action']=='delimg'){ //删除商户Logo
	$LogoPath=$_GET['LogoPath'];
	
	del_file($LogoPath);
	del_file(str_replace('s_', '', $LogoPath));
	
	$str=js_contents_code('No Logo');
	echo "<script language=javascript>parent.document.getElementById('img_list').innerHTML='$str';parent.document.getElementById('img_list').setAttribute('target','');parent.document.getElementById('img_list').setAttribute('href','javascript:void(0);');parent.document.getElementById('img_list_a').style.display='none';</script>";
	exit;
}
if($_POST){
    $Salesman_Name=$_POST['Salesman_Name'];
    $SupplierId = (int)$_POST['SupplierId'];
	$S_LogoPath = $_POST['S_LogoPath'];
    $MemberLevel = (int)$_POST['MemberLevel'];
    $IsUse = (int)$_POST['IsUse'];
    $Supplier_Name = trim($_POST['Supplier_Name']);
    $Supplier_Name2 = trim($_POST['Supplier_Name2']);
    $Supplier_Phone = trim($_POST['Supplier_Phone']);
    $Supplier_Mobile = trim($_POST['Supplier_Mobile']);
    $Supplier_Company_Address = trim($_POST['Supplier_Company_Address']);
    $Supplier_Pay_Number = trim($_POST['Supplier_Pay_Number']);
    $Supplier_Main_Products = trim($_POST['Supplier_Main_Products']);
    $Supplier_Email = $_POST['Supplier_Email'];
    $Supplier_Online_0 = $_POST['Supplier_Online_0'];
    $Supplier_Online_1 = $_POST['Supplier_Online_1'];
    $Supplier_Online_2 = $_POST['Supplier_Online_2'];
    $Supplier_Phone = $_POST['Supplier_Phone'];
    $Supplier_Address = $_POST['Supplier_Address'];
    $Supplier_Address_lang_1 = $_POST['Supplier_Address_lang_1'];
    $Supplier_CopyRight = $_POST['Supplier_CopyRight'];
    $Supplier_CopyRight_lang_1 = $_POST['Supplier_CopyRight_lang_1'];
    $Supplier_BriefDescription = $_POST['Supplier_BriefDescription'];
    $Supplier_BriefDescription_lang_1 = $_POST['Supplier_BriefDescription_lang_1'];
    $Supplier_SeoKeywords = $_POST['Supplier_SeoKeywords'];
    $Supplier_SeoDescription = $_POST['Supplier_SeoDescription'];
    if($db->get_row_count('member', "MemberId!='$SupplierId' and Supplier_Name = '$Supplier_Name'", 'Supplier_Name')){
        echo '<script>alert("商户名称已存在");history.go(-1);</script>';
        exit;
    }
	$save_dir=get_cfg('ly200.up_file_base_dir')."supplier/{$SupplierId}/";
	
	if($LogoPath=up_file($_FILES['LogoPath'], $save_dir)){
		include('../../inc/fun/img_resize.php');
		$SmallLogoPath=img_resize($LogoPath, '', $width, $height);
	}else{
		$SmallLogoPath=$S_LogoPath;
	}
    if($Business_License=up_file($_FILES['Business_License'], $save_dir)){
        include('../../inc/fun/img_resize.php');
        $SmallBusiness_License=img_resize($Business_License, '', $width, $height);
    }else{
        $SmallBusiness_License=$_POST['S_Business_License'];
    }
    $data = array(
        'LogoPath' => $SmallLogoPath,
        'Business_License' => $SmallBusiness_License,
        'MemberLevel' => $MemberLevel,
        'Supplier_Name' => $Supplier_Name,
        'Supplier_Name2' => $Supplier_Name2,
        'Salesman_Name'  =>$Salesman_Name,
        'Supplier_Phone' => $Supplier_Phone,
        'Supplier_Mobile' => $Supplier_Mobile,
        'Supplier_Company_Address' => $Supplier_Company_Address,
        'Supplier_Pay_Number' => $Supplier_Pay_Number,
        'Supplier_Main_Products' => $Supplier_Main_Products,
        'Supplier_Email' => $Supplier_Email,
        'Supplier_Online_0' => $Supplier_Online_0,
        'Supplier_Online_1' => $Supplier_Online_1,
        'Supplier_Online_2' => $Supplier_Online_2,
        'Supplier_Phone' => $Supplier_Phone,
        'Supplier_Address' => $Supplier_Address,
        'Supplier_Address_lang_1' => $Supplier_Address_lang_1,
        'Supplier_CopyRight' => $Supplier_CopyRight,
        'Supplier_CopyRight_lang_1' => $Supplier_CopyRight_lang_1,
        'Supplier_BriefDescription' => $Supplier_BriefDescription,
        'Supplier_BriefDescription_lang_1' => $Supplier_BriefDescription_lang_1,
        'Supplier_SeoTitle' => $Supplier_SeoTitle,
        'Supplier_SeoKeywords' => $Supplier_SeoKeywords,
        'Supplier_SeoDescription' => $Supplier_SeoDescription,
    );
    if($IsUse){
        $data['IsUse'] = $IsUse;
        Supplier_Init($SupplierId);//function.php
    }
    $db->update('member',"MemberId='$SupplierId'",$data);
    if($Salesman_Name){
         $db->update('member',"Salesman_Name='$Salesman_Name'",$data);
    }
	//----------------------------------------------------------------------------------------------------------------------------------------------------------
	
	// save_manage_log('系统全局设置');
	header('Location: supplier.php?SupplierId='.$SupplierId);
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
    <form method="post" name="act_form" id="act_form" class="act_form" action="supplier.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
        <div class="table" id="mouse_trBgcolor_table">
        	<div class="table_bg"></div>
            <div class="tr">
                <font class="fl"><a href="/manage/product/index.php?SupplierId=<?=$SupplierId?>">查看商家所有产品</a></font>
            </div>
            <div class="tr">
                <div class="tr_title"><?=get_lang('set.global.baseinfo');?></div>
                <div class="form_row">
                    <font class="fl">商户名称:</font>
                    <span class="fl">
                        <input name="Supplier_Name" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Name']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'商户名称';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="form_row">
                    <font class="fl">商户Logo:</font>
                    <span class="fl">
                        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                        <a href="<?=is_file($site_root_path.$supplier_row['LogoPath']) ? str_replace('s_','',$supplier_row['LogoPath']) : 'javascript:void(0);'?>" class="logo_con fl" id="img_list" <?=is_file($site_root_path.$supplier_row['LogoPath']) ? 'target="_blank"' : '';?> >
                        	<?=is_file($site_root_path.$supplier_row['LogoPath']) ? "<img src='{$supplier_row['LogoPath']}' />" : 'No Logo';?>
                        </a>
                        <div class="operation fl">
                            <input name="LogoPath<?=lang_name($i, 1);?>" type="file" value="<?=htmlspecialchars($supplier_row['LogoPath']);?>" class="form_file fl" id="file_name"><label class="file-lab float-right" id="fileLab"></label>
                            <?php if(is_file($site_root_path.$supplier_row['LogoPath'])){ ?>
                                <a href="supplier.php?action=delimg&LogoPath=<?=$supplier_row['LogoPath'];?>&ImgId=img_list" class="del fl" target="del_img_iframe" id="img_list_a"></a>
                            <?php } ?>
                            <div class="clear"></div>
                            <input type="hidden" name="S_LogoPath" value="<?=$supplier_row['LogoPath']?>" />
                        </div>
                        <div class="clear"></div>
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="form_row">
                    <font class="fl">业务员名称:</font>
                    <span class="fl">
                        <input name="Salesman_Name" type="text" class="form_input" size="98" maxlength="500" value="<?=htmlspecialchars($supplier_row['Salesman_Name']);?>" check2="<?=get_lang('ly200.filled_out').'业务员名称';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
                <div class="tr_title"><?=get_lang('set.global.contactinfo').lang_name($i, 0);?></div>
                    <div class="form_row">
                        <font class="fl">商户审核:</font>
                        <span class="fl">
                            <?php if(!$supplier_row['IsUse']){ ?>
                                <input type="radio" name="IsUse" <?=$supplier_row['IsUse']==1 ? 'checked' : ''; ?> value="1" id="">
                                审核通过  &nbsp;&nbsp;
                                <input type="radio" name="IsUse" <?=$supplier_row['IsUse']==0 ? 'checked' : ''; ?> value="0" id="">
                                未审核 
                            <?php }else{ ?>
                                <span style="color:blue;">审核已通过</span>
                            <?php } ?>
                        </span>
                        <div class="clear"></div>
                    </div>
                <div class="form_row">
                    <font class="fl">商户等级:</font>
                    <span class="fl">
                        <select name="MemberLevel" class="form_select">
                            <option value="">--选择商户等级--</option>
                            <?php
                            $level_row=$db->get_all('member_level', 1, '*', 'UpgradePrice asc');
                            for($i=0,$count=count($level_row); $i<$count; $i++){
                            ?>
                            <option value="<?=$level_row[$i]['LId'];?>" <?=$supplier_row['MemberLevel']==$level_row[$i]['LId']?'selected':'';?>><?=$level_row[$i]['Level'];?></option>
                            <?php }?>
                        </select>
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="form_row">
                    <font class="fl">联系邮箱:</font>
                    <span class="fl">
                        <input name="Supplier_Email" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Email']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'联系邮箱';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="form_row">
                    <font class="fl">联系Skype:</font>
                    <span class="fl">
                        <input name="Supplier_Online_0" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Online_0']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'联系Skype';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="form_row">
                    <font class="fl">联系QQ:</font>
                    <span class="fl">
                        <input name="Supplier_Online_1" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Online_1']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'联系QQ';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="form_row">
                    <font class="fl">联系旺旺:</font>
                    <span class="fl">
                        <input name="Supplier_Online_2" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Online_2']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'联系旺旺';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                 
            </div>
            <div class="tr">
                <div class="tr_title">公司具体信息</div>
                <div class="form_row">
                    <font class="fl">营业执照:</font>
                    <span class="fl">
                        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                        <a href="<?=is_file($site_root_path.$supplier_row['Business_License']) ? str_replace('s_','',$supplier_row['Business_License']) : 'javascript:void(0);'?>" class="logo_con fl" id="img_list" <?=is_file($site_root_path.$supplier_row['Business_License']) ? 'target="_blank"' : '';?> >
                            <?=is_file($site_root_path.$supplier_row['Business_License']) ? "<img src='{$supplier_row['Business_License']}' />" : 'No Business License';?>
                        </a>
                        <div class="operation fl">
                            <input name="Business_License" type="file" value="<?=htmlspecialchars($supplier_row['Business_License']);?>" class="form_file fl">
                            <div class="clear"></div>
                            <input type="hidden" name="S_Business_License" value="<?=$supplier_row['Business_License']?>" />
                        </div>
                        <div class="clear"></div>
                    </span>
                    <div class="clear"></div>
                </div>
                <!-- <div class="form_row">
                    <font class="fl">公司名称:</font>
                    <span class="fl">
                        <input name="Supplier_Name2" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Name2']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'公司名称';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div> -->
                <div class="form_row">
                    <font class="fl">固定电话:</font>
                    <span class="fl">
                        <input name="Supplier_Phone" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Phone']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'固定电话';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                <?php /*
                <div class="form_row">
                    <font class="fl">收货地址:</font>
                    <span class="fl">
                        <input name="Supplier_Address" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Address']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'收货地址';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>*/ ?>
                <div class="form_row">
                    <font class="fl">手机号码:</font>
                    <span class="fl">
                        <input name="Supplier_Mobile" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Mobile']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'手机号码';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="form_row">
                    <font class="fl">办公地址:</font>
                    <span class="fl">
                        <input name="Supplier_Company_Address" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Company_Address']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'办公地址';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="form_row">
                    <font class="fl">收款帐号:</font>
                    <span class="fl">
                        <input name="Supplier_Pay_Number" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Pay_Number']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'收款帐号';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="form_row">
                    <font class="fl">主营产品:</font>
                    <span class="fl">
                        <input name="Supplier_Main_Products" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Main_Products']);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'主营产品';?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
        	<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                <div class="tr last">
                    <div class="tr_title">其它信息<?=lang_name($i, 0); ?></div>
                    <div class="form_row">
                        <font class="fl">联系地址<?=lang_name($i, 0); ?>:</font>
                        <span class="fl">
                            <input name="Supplier_Address<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_Address'.lang_name($i, 1)]);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').'联系地址';?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div> 
                    <div class="form_row">
                        <font class="fl">公司简介:</font>
                        <span class="fl">
                            <textarea name="Supplier_BriefDescription<?=lang_name($i, 1);?>" rows="4" cols="96" class="form_area"><?=htmlspecialchars($supplier_row['Supplier_BriefDescription'.lang_name($i, 1)]);?></textarea>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('set.global.copyright');?>:</font>
                        <span class="fl">
                            <input name="Supplier_CopyRight<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($supplier_row['Supplier_CopyRight'.lang_name($i, 1)]);?>" class="form_input" size="98" maxlength="500" check2="<?=get_lang('ly200.filled_out').get_lang('set.global.copyright');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <div class="button fr"><input type="submit" value="<?=get_lang('ly200.submit');?>" name="submit" class="form_button"></div>
            <div class="clear"></div>
        </div>
        <input type="hidden" name="SupplierId" value="<?=$SupplierId; ?>" />
    </form>
</div>
<script src="/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $("#file_name").change(function(){
        var fileName = $(this).val().split("\\").pop();
        $("#fileLab").html(fileName);
    });
</script>
<?php include('../../inc/manage/footer.php');?>