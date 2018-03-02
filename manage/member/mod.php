<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

$page_cur='buyers_member_manage';
check_permit('buyers_member_manage');

$memberid=$_GET['MemberId'];
if($_POST['submit_hid'] == 'hid'){
    
    $MemberId2 = $_POST['memberid'];
    $Supplier_Name = $_POST['Supplier_Name'];
    $Email = $_POST['Email'];
    $Supplier_Name2 = $_POST['Supplier_Name2'];
    $Sex = $_POST['Sex'];
    $Add2 = $_POST['Add2'];
    $Supplier_Mobile = $_POST['Supplier_Mobile'];
    $MemberLevel = $_POST['Level'];
    $IsConfirm = $_POST['IsConfirm'];
    $db->update('member',"MemberId='$MemberId2'",array(
            'Supplier_Name'   =>  $Supplier_Name,
            'Supplier_Name2'  =>  $Supplier_Name2,
            'Email'           =>  $Email,
            'Supplier_Mobile' =>  $Supplier_Mobile,
            'IsConfirm'        =>  $IsConfirm,
            'Sex'             =>  $Sex,
            'Add2'            =>  $Add2,
            'Level'           =>  $MemberLevel,

        ));
    header('Location: index.php');
    exit;
}

$member_row = $db->get_one('member',"MemberId=$memberid");
include('../../inc/manage/header.php');
?>
<style>
	.y{
        height:350px;
        background:#fff;
    }
    .y_input{
    	font-size:12px;color:#666;cursor:pointer;border-radius:3px;margin-right:20px;
    }
    .input_s{
		margin-left:7px
    }
    .y_form{
    	width:450px;float:left;margin-top:20px;height:31px;line-height:31px;
    }
    .y_form1{
    	width:100%;float:left;margin-top:20px;height:31px;line-height:31px;
    }
    .yc_title{
    	display:inline-block;width:100px;text-align:right;font-size:12px;color:#666;font-weight:bold;
    }
    .y_title{
        display:inline-block;width:100px;text-align:right;font-size:12px;color:#666;font-weight:bold;
    }
    .y_title_txt{
		width:300px;height:29px;border-radius:3px;border:1px solid #ccc;color:#333;
    }
    .y_submit{
    	width:100%;
		float: left;
    	margin-top:40px;
    	text-align:center;
    }
    .ys_input{
		border:none;background:#218fde;width:133px;height:29px;line-height:29px;
	    text-align: center;
	    color: #fff;
	    font-size: 14px;
	    border-radius: 4px;
	    cursor: pointer;
	    -moz-border-radius: 4px;
	    -webkit-border-radius: 4px;
    }
</style>
<form style="background:#fff;min-height:600px;width:95%" action="" method="post">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px"><?=$a?></div>
	 <div class="table">
            <div class="table_bg"></div>
            <div class="y">
            	<div class="y_form"><span class="y_title">用户名：</span><input class="y_title_txt" type="text" name="Supplier_Name" value="<?=$member_row['UserName']?>"></div>
                <div class="y_form"><span class="y_title">电子邮箱：</span><input class="y_title_txt" type="text" name="Email" value="<?=$member_row['Email']?>"></div>
                <div class="y_form"><span class="y_title">姓名：</span><input class="y_title_txt" type="text" name="Supplier_Name2" value="<?=$member_row['FirstName']?>"></div>
		        <div class="y_form"><span class="y_title">性别：</span>
					<a class="y_input"><input class="input_r" type="radio" name="Sex" value="1" id="" <?=$member_row['Sex'] == '1' ? checked : '';?>><span class='input_s'>男</span></a>
					<a class="y_input"><input class="input_r" type="radio" name="Sex" value="2" id="" <?=$member_row['Sex'] == '2' ? checked : '';?>><span class='input_s'>女</span></a>
				</div>
                <div class="y_form"><span class="y_title">所属地区：</span>
                <select class="y_title_txt" name="Add2" id="">
                    <option value="1"  <?=$member_row['Add2'] == '1' ? selected : '';?>>中国</option>
                    <option value="2"  <?=$member_row['Add2'] == '2' ? selected : '';?>>墨西哥</option>
                    <option value="3"  <?=$member_row['Add2'] == '3' ? selected : '';?>>美国</option>
                </select></div>
                <div class="y_form"><span class="y_title">手机号：</span><input class="y_title_txt" type="text" name="Supplier_Mobile" value="<?=$member_row['Supplier_Mobile']?>"></div>
                <div class="y_form"><span class="y_title">会员等级：</span>

                <select class="y_title_txt" name="Level">
                	<option value="1" <?=$member_row['Level'] == '1' ? selected : '';?>>LV1</option>
                	<option value="2" <?=$member_row['Level'] == '2' ? selected : '';?>>LV2</option>
                    <option value="3" <?=$member_row['Level'] == '3' ? selected : '';?>>LV3</option>
                </select>

                </div>

                <div class="y_form"><span class="y_title">是否激活：</span>
                	<a class="y_input"><input class="input_r" type="radio" value="1" name="IsConfirm" id="" <?=$member_row['IsConfirm'] == '1' ? checked : '';?>><span class='input_s'>是</span></a>
                	<a class="y_input"><input class="input_r" type="radio" value="0" name="IsConfirm" id="" <?=$member_row['IsConfirm'] == '0' ? checked : '';?>><span class='input_s'>否</span></a>
                </div>
                <div class="y_submit">
                    <input type="hidden" name="submit_hid" value="hid">
                    <input type="hidden" name="memberid" value="<?=$memberid?>">
			        <input class="ys_input" type="submit" value="保存">
			    </div>
             </div>
    </div>
</form>
<?php include('../../inc/manage/footer.php');?>