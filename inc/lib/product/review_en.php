<?php
include('../../site_config.php');
include('../../set/ext_var.php');
include('../../fun/mysql.php');
include('../../function.php');

if($_POST['data']=='review_en'){
	$un_keyword_ary=array('www', 'http');	//带有本关键词的内容不存入数据库
	
	$ProId=(int)$_POST['ProId'];
	$FullName=$_POST['FullName'];
	$Email=$_POST['Email'];
	$Rating=(int)$_POST['Rating'];
	($Rating<1 || $Rating>5) && $Rating=5;
	$Contents=$_POST['Contents'];
	
	$in=0;
	foreach($un_keyword_ary as $value){
		if(@substr_count($Contents, $value)){
			$in=1;
			break;
		}
	}
	
	($in==1 || $FullName=='' || $Email=='' || $Contents=='') && js_location('/', '', '.top');
	
	$db->insert('product_review', array(
			'ProId'		=>	$ProId,
			'FullName'	=>	$FullName,
			'Email'		=>	$Email,
			'Rating'	=>	$Rating,
			'Contents'	=>	$Contents,
			'Ip'		=>	get_ip(),
			'PostTime'	=>	$service_time
		)
	);
	
	js_location("/inc/lib/product/review_en.php?ProId=$ProId", 'Thank you for your Review!');
}

$ProId=(int)$_GET['ProId'];
$where="ProId='$ProId'";
$page_count=10;

$row_count=$db->get_row_count('product_review', $where);
$total_pages=ceil($row_count/$page_count);
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*$page_count;
$review_row=$db->get_limit('product_review', $where, '*', 'RId desc', $start_row, $page_count);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="save" content="history" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<?=seo_meta();?>
<script language="javascript" src="/js/lang/en.js"></script>
<script language="javascript" src="/js/global.js"></script>
<script language="javascript">
onload=function(){
	parent.$_('lib_product_review').innerHTML=$_('lib_product_review').innerHTML;
}
</script>
</head>

<body>
<div id="lib_product_review">
	<iframe name="post_data_iframe"></iframe>
	<div class="t">Customer's Reviews:</div>
	<?php
	for($i=0; $i<count($review_row); $i++){
	?>
		<div class="item">
			<div class="fc"><?=str_repeat('<img src="/images/lib/product/x0.jpg">', $review_row[$i]['Rating']);?>&nbsp;&nbsp;&nbsp;<?=date('m/d/Y', $review_row[$i]['PostTime']);?>, By <span><?=htmlspecialchars($review_row[$i]['FullName']);?></span></div>
			<div><img src="/images/lib/product/review_top.jpg" /></div>
			<div class="review_contents"><?=format_text($review_row[$i]['Contents']);?></div>
			<div><img src="/images/lib/product/review_bot.jpg" /></div>
		</div>
	<?php }?>
	<div class="blank6"></div>
	<div id="turn_page"><?=str_replace('<a ', '<a target="post_data_iframe"', turn_page($page, $total_pages, "/inc/lib/product/review_en.php?ProId=$ProId&page=", $row_count));?></div>
	<div class="blank20"></div>
	<div class="t">Write Your Review:</div>
	<div class="txt">Tell us what you think about this item and share your opinions with other people. Please make sure your review focuses only on this item. All reviews are moderated and will be reviewed within two business days. Inappropriate reviews will not be posted. After-sales questions and issues: Contact our Customer Service Department. (A customer representative will get back to you). Please Login first if you want to later edit or manage reviews uploaded by yourself.</div>
	<div class="form">
		<form action="/inc/lib/product/review_en.php" method="post" target="post_data_iframe" name="review_en_form" OnSubmit="return checkForm(this);">
			<div class="rows">
				<label>Full Name: <font class='fc_red'>*</font></label>
				<span><input name="FullName" type="text" class="form_input" check="Full Name is required!~*" size="25" maxlength="20"></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>Email Address: <font class="fc_red">*</font></label>
				<span><input name="Email" value="" type="text" class="form_input" check="Email Address is required!~email|Email entered doesn't match with confirm Email value!*" size="50" maxlength="100"></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>Rating: <font class="fc_red">*</font></label>
				<span class="rating">
					<img src="/images/lib/product/x0.jpg" id="rating_1" onmouseover="product_review_show_star(1);" onmouseout="product_review_show_star(parseInt($_('Rating').value));" onclick="$_('Rating').value=1; product_review_show_star(1);" /><img src="/images/lib/product/x0.jpg" id="rating_2" onmouseover="product_review_show_star(2);" onmouseout="product_review_show_star(parseInt($_('Rating').value));" onclick="$_('Rating').value=2; product_review_show_star(2);" /><img src="/images/lib/product/x0.jpg" id="rating_3" onmouseover="product_review_show_star(3);" onmouseout="product_review_show_star(parseInt($_('Rating').value));" onclick="$_('Rating').value=3; product_review_show_star(3);" /><img src="/images/lib/product/x0.jpg" id="rating_4" onmouseover="product_review_show_star(4);" onmouseout="product_review_show_star(parseInt($_('Rating').value));" onclick="$_('Rating').value=4; product_review_show_star(4);" /><img src="/images/lib/product/x0.jpg" id="rating_5" onmouseover="product_review_show_star(5);" onmouseout="product_review_show_star(parseInt($_('Rating').value));" onclick="$_('Rating').value=5; product_review_show_star(5);" />
					<input type="hidden" name="Rating" id="Rating" value="5">
				</span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>Review Contents: <font class='fc_red'>*</font></label>
				<span><textarea name="Contents" class="form_area contents" check="Review Contents is required!~*"></textarea></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label></label>
				<span><input name="Submit" type="submit" class="form_button form_button_130" value="Submit Review"></span>
				<div class="clear"></div>
			</div>
			<input type="hidden" name="ProId" value="<?=$ProId;?>" />
			<input type="hidden" name="data" value="review_en" />
		</form>
	</div>
</div>
</body>
</html>