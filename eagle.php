<?php
	include("inc/include.php");
	include('/inc/common/header.php');
?>
<link rel="stylesheet" href="/css/eagle.css">
<div class="index_box">
	<div class="index_logo1">
		<img style="width:210px;height:60px;" src="<?=$member_row['LogoPath'] != '' ? $member_row['LogoPath'] : '/images/supplier.png';?>">

	</div>
	<div class="index_search">
	<form action="">
		<input class="search_input" placeholder='请输入商户名称' name="products_name" style="" type="text">	
		<input class="search_submit" type="submit"  value="">
		<input type="hidden" name="act" value="2">
		<input type="hidden" name="SupplierId" value="<?=$supplierid?>">
	</form>		
	</div>		
</div>
<div class="mask">
	<div class="margin">
		<div class="abc">
			<a class="acd abc_c" data='1' style="background:#0d36a6;" href="/eagle.php">全部</a>
			<a class="adc abc_c" data='2' href="/eagle.php">A</a>
			<a class="adc abc_c" data='3' href="/eagle.php">B</a>
			<a class="adc abc_c" data='4' href="">C</a>
			<a class="adc abc_c" data='5' href="">D</a>
			<a class="adc abc_c" data='6' href="">E</a>
			<a class="adc abc_c" data='7' href="">F</a>
			<a class="adc abc_c" data='8' href="">G</a>
			<a class="adc abc_c" data='9' href="">H</a>
			<a class="adc abc_c" data='10' href="">I</a>
			<a class="adc abc_c" data='11' href="">J</a>
			<a class="adc abc_c" data='12' href="">K</a>
			<a class="adc abc_c" data='13' href="">L</a>
			<a class="adc abc_c" data='14' href="">M</a>
			<a class="adc abc_c" data='15' href="">N</a>
			<a class="adc abc_c" data='16' href="">O</a>
			<a class="adc abc_c" data='17' href="">P</a>
			<a class="adc abc_c" data='18' href="">Q</a>
			<a class="adc abc_c" data='19' href="">R</a>
			<a class="adc abc_c" data='20' href="">S</a>
			<a class="adc abc_c" data='21' href="">T</a>
			<a class="adc abc_c" data='22' href="">U</a>
			<a class="adc abc_c" data='23' href="">V</a>
			<a class="adc abc_c" data='24' href="">W</a>
			<a class="adc abc_c" data='25' href="">X</a>
			<a class="adc abc_c" data='26' href="">Y</a>
			<a class="adc abc_c" data='27' href="">Z</a>			
		</div>
	</div>
</div>
<div class="mask">
	<div class="hi">
		<div class="shangjia" style=''>
		<?php 
		$where = "IsSupplier=1";
		if($_GET['center_s']){
			$center_s =$_GET['center_s'];
			$where .= " and Supplier_Name like '%$center_s%'";
		}
			$member_row =$db->get_limit('member',$where,'*','1',"0",'20');
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
	$('.abc .abc_c').click(function(){
		var ds=$(this).attr('data');
		window.sessionStorage.setItem('abcset',ds);
	})
	var abcget=window.sessionStorage.getItem('abcset');
	$('.abc .abc_c').each(function(){
		var ds=$(this).attr('data');
		if(abcget==ds){
			$(this).css('background','#0d36a6');
		}else{
			$(this).css('background','#2962ff');
		}
	})
</script>