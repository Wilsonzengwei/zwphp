<?php
if($_POST['data']=='inquire_cn'){
	$un_keyword_ary=array('www', 'http');	//带有本关键词的内容不存入数据库
	$ProId=$_POST['ProId'];
	$FirstName=$_POST['FirstName'];
	$LastName=$_POST['LastName'];
	$Email=$_POST['Email'];
	$State=$_POST['State'];
	$City=$_POST['City'];
	$Area=$_POST['Area'];
	$Address=$_POST['Address'];
	$PostalCode=$_POST['PostalCode'];
	$Phone=$_POST['Phone'];
	$Fax=$_POST['Fax'];
	$Subject=$_POST['Subject'];
	$Message=$_POST['Message'];
	
	$str=$FirstName.$Subject.$Message;	//过滤内容
	$in=0;
	foreach($un_keyword_ary as $value){
		if(@substr_count($str, $value)){
			$in=1;
			break;
		}
	}
	
	($in==1 || $FirstName=='' || $Subject=='' || $Message=='') && js_location($jump_url);
	
	$db->insert('product_inquire', array(
			'ProId'		=>	$ProId,
			'FirstName'	=>	$FirstName,
			'LastName'	=>	$LastName,
			'Email'		=>	$Email,
			'Country'	=>	'中国',
			'State'		=>	$State,
			'City'		=>	$City,
			'Area'		=>	$Area,
			'Address'	=>	$Address,
			'PostalCode'=>	$PostalCode,
			'Phone'		=>	$Phone,
			'Fax'		=>	$Fax,
			'Subject'	=>	$Subject,
			'Message'	=>	$Message,
			'Ip'		=>	get_ip(),
			'PostTime'	=>	$service_time
		)
	);
	
	js_location('/', '提交成功，我们将会尽快与您取得联系！');
}

$ProId=(int)$_GET['ProId']?(int)$_GET['ProId']:(int)$_POST['ProId'];
!$ProId && $ProId=@implode(',', $_POST['ProId']);
!$ProId && $ProId=0;

$product_img_width=160;	//产品图片宽度
$product_img_height=160;	//产品图片高度
$contents_width=720;	//显示内容的div的宽度

$product_row=$db->get_all('product', "ProId in(0,$ProId,0)", '*', 'MyOrder desc, ProId desc');

ob_start();
?>
<script language="javascript" src="/js/checkform.js"></script>
<div id="lib_product_inquire">
	<div class="product_list">
		<?php
		for($i=0; $i<count($product_row); $i++){
			$url=get_url('product', $product_row[$i]);
		?>
		<div class="item" style="width:<?=$contents_width;?>px;">
			<div class="img" style="width:<?=$product_img_width;?>px; height:<?=$product_img_height;?>px"><div><a href="<?=$url;?>" target="_blank"><img src="<?=$product_row[$i]['PicPath_0'];?>"/></a></div></div>
			<div class="info" style="width:<?=$contents_width-$product_img_width-15;?>px;">
				<div class="proname"><a href="<?=$url;?>" target="_blank"><?=$product_row[$i]['Name'];?></a></div>
				<div class="flh_180"><?=format_text($product_row[$i]['BriefDescription']);?></div>
			</div>
			<div class="cline"><div class="line"></div></div>
		</div>
		<?php }?>
	</div>
	<div class="form" style="width:<?=$contents_width;?>px;">
		<form action="<?=$_SERVER['PHP_SELF'].'?'.query_string();?>" method="post" name="inquire_en_form" OnSubmit="return checkForm(this);">
			<div class="rows">
				<label>联 系 人: <font class='fc_red'>*</font></label>
				<span><input name="FirstName" type="text" class="form_input" check="请正确填写联系人姓名!~*" size="25" maxlength="20"></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>邮箱地址: <font class="fc_red">*</font></label>
				<span><input name="Email" value="" type="text" class="form_input" check="请正确填写邮箱!~email|{value}不是一个有效的邮箱地址!*" size="50" maxlength="100"></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>省份城市: <font class="fc_red">*</font></label>
				<span>
					<select name="State" id="State" check="请正确填写省份城市!~*"></select>
					<select name="City" id="City" check="请正确填写省份城市!~*"></select>
					<select name="Area" id="Area" check="请正确填写省份城市!~*"></select>
					<script language="javascript" src="/js/china_area.js"></script>
					<script language="javascript">new PCAS('State', 'City', 'Area');</script>
				</span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>详细地址: <font class="fc_red">*</font></label>
				<span><input name="Address" value="" type="text" class="form_input" check="请正确填写详细地址!~*" size="70" maxlength="200"></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>邮政编码: <font class="fc_red">*</font></label>
				<span><input name="PostalCode" value="" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" type="text" class="form_input" size="10" maxlength="10"></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>联系电话: <font class="fc_red">*</font></label>
				<span><input name="Phone" value="" type="text" class="form_input" check="请正确填写联系电话!~*" size="40" maxlength="20" /></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>传真号码: <font class="fc_red">*</font></label>
				<span><input name="Fax" value="" type="text" class="form_input" size="40" maxlength="20" /></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>询盘主题: <font class='fc_red'>*</font></label>
				<span><input name="Subject" type="text" class="form_input" check="请正确填写主题!~*" size="50" maxlength="100"></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>询盘内容: <font class='fc_red'>*</font></label>
				<span><textarea name="Message" class="form_area contents" check="请正确填写询盘内容!~*"></textarea></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label></label>
				<span><input name="Submit" type="submit" class="form_button" value="提 交"></span>
				<div class="clear"></div>
			</div>
			<input type="hidden" name="ProId" value="<?=$ProId;?>" />
			<input type="hidden" name="data" value="inquire_cn" />
		</form>
	</div>
</div>
<?php
$product_inquire_form_cn=ob_get_contents();
ob_end_clean();
?>