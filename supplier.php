<?php
include('./inc/include.php');
$supplierid = $_GET['SupplierId'];
$IsSupplier = $_SESSION['IsSupplier'];
//if($supplierid){
	$member_row = $db->get_one("member","MemberId='$supplierid'");
	$ad_row = $db->get_one("ad","Num=1 and SupplierId='$supplierid'");
	$product_time_row = $db->get_limit("product","SupplierId='$supplierid'",'*',"AccTime desc",'0','4');
	$product_new_row = $db->get_limit("product","SupplierId='$supplierid'",'*',"AccTime desc",'0','20');
	//var_dump($product_new_row);exit;
if($_GET['Num'] ){
	$Num = $_GET['Num']; 
	//var_dump($Num);exit;
	$member_related = $ad_row = $db->get_one("article","SupplierId='$supplierid' and Num='$Num' ");
}
$center_s = $_GET['center_s'];
	
	//var_dump($ad_row);exit;
	include('./inc/common/header.php');

?>
<?php 
	echo '<link rel="stylesheet" href="/css/supplier'.$lang.'.css">'
?>
<div class="index_box">
	<div class="index_logo"></div>
	<div class="index_search">
	<form action="" method="get">
		<input class="search_input" name="center_s" placeholder='<?=$website_language['header'.$lang]['qsrsjmc']?>' style="" type="text" value="<?=$center_s?>">	
		<input class="search_submit" type="submit"  value="<?=$website_language['header'.$lang]['ss']?>">
	</form>		
	</div>		
</div>
<div class="tt">
	<div class="ttt" style="">
		<div class="tesh">
			<a class="test" href="/supplier.php"><?=$website_language['ylfy'.$lang]['qb']?></a>
		</div>		
		<!-- <div class="tes">
			<a class="test" href="/supplier.php"><?=$website_language['products'.$lang]['zr']?></a>
		</div>
		<div class="tes">
			<a class="test" href="/supplier.php"><?=$website_language['products'.$lang]['tj']?></a>
		</div> -->		
	</div>  
</div>
<div class="mask" style="min-height: 250px;">
	<div class="hi">
		<div class="shangjia" style=''>
		<?php 
		$where = "IsSupplier=1 and Is_Business_License='1' and IsUse=2";
		if($_GET['center_s']){
			$center_s =$_GET['center_s'];
			$where .= " and Supplier_Name like '%$center_s%'";
		}
			$member_row =$db->get_limit('member',$where,'*','RegTime desc',"0",'20');
			foreach ($member_row as $key => $val) {
				$name = $val['Supplier_Name'];
				$img = $val['LogoPath'];
				$Supplier = $val['MemberId'];
		?>
			<div class="shangjia_list">
				<a href="/member_admin/index.php?SupplierId=<?=$Supplier?>&act=1"><img src="<?=$img !='' ? $img : '/images/supplier.png';?>" alt=""></a>
				<a href="/member_admin/index.php?SupplierId=<?=$Supplier?>&act=1"><div class="shangjia_name" title="<?=$name?>"><?=$name?></div></a>
			</div>
		<?php 
			}
		?>
		</div>
	</div>			
	<form action="products.php?CateId=<?=$CateId?>" method="post">
		<div class="turn_page_form fr"><?=turn_bottom_page1($page, $total_pages, "products.php?CateId=".$CateId."&page=", $row_count, '〈', '〉');?></div>
	</form>
</div>
<script>
	$(function(){
		$('.shangjia').find('.shangjia_list:eq(4)').css('margin-right','0px');
	})
</script>

<?php
	include('./inc/common/footer.php');
  
?>
<?php
/*}else{
	echo '<script>alert("登入后才能访问");</script>';
		header("Refresh:0;url=/account.php?module=login");
		//history.go(-1)禁止提交
		exit;
	}*/
?>
