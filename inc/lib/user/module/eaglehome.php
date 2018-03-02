<?php 
$center_s = $_GET['center_s'];
$mode = $_GET['mode'];
?>
<link rel="stylesheet" href="/css/eagle.css">
<div class="index_box">
	<div class="index_logo1">
		<a href="/">
		<img style="width:210px;height:60px;" src="/images/index/logo.png">
		</a>
	</div>
	<div class="index_search">
	<form action="" method="get" >
		<input class="search_input" placeholder='请输入商户名称' name="center_s" style="" type="text" value="<?=$center_s?>">	
		<input type="hidden" name="mode" value="<?=$mode?>">
		<input type="hidden" name="module" value="eaglehome">
		<input class="search_submit" type="submit"  value="搜索">
	</form>		
	</div>		
</div>
<div class="mask">
	<div class="margin">
		<div class="abc">
			<a class="acd abc_c" data='1' href="/account.php?module=eaglehome&mode=&center_s=<?=$center_s?>">全部</a>

			<a class="adc abc_c" data='2' href="/account.php?module=eaglehome&mode=A&center_s=<?=$center_s?>">A</a>
			<a class="adc abc_c" data='3' href="/account.php?module=eaglehome&mode=B&center_s=<?=$center_s?>">B</a>
			<a class="adc abc_c" data='4' href="/account.php?module=eaglehome&mode=C&center_s=<?=$center_s?>">C</a>
			<a class="adc abc_c" data='5' href="/account.php?module=eaglehome&mode=D&center_s=<?=$center_s?>">D</a>
			<a class="adc abc_c" data='6' href="/account.php?module=eaglehome&mode=E&center_s=<?=$center_s?>">E</a>
			<a class="adc abc_c" data='7' href="/account.php?module=eaglehome&mode=F&center_s=<?=$center_s?>">F</a>
			<a class="adc abc_c" data='8' href="/account.php?module=eaglehome&mode=G&center_s=<?=$center_s?>">G</a>
			<a class="adc abc_c" data='9' href="/account.php?module=eaglehome&mode=H&center_s=<?=$center_s?>">H</a>
			<a class="adc abc_c" data='10' href="/account.php?module=eaglehome&mode=I&center_s=<?=$center_s?>">I</a>
			<a class="adc abc_c" data='11' href="/account.php?module=eaglehome&mode=J&center_s=<?=$center_s?>">J</a>
			<a class="adc abc_c" data='12' href="/account.php?module=eaglehome&mode=K&center_s=<?=$center_s?>">K</a>
			<a class="adc abc_c" data='13' href="/account.php?module=eaglehome&mode=L&center_s=<?=$center_s?>">L</a>
			<a class="adc abc_c" data='14' href="/account.php?module=eaglehome&mode=M&center_s=<?=$center_s?>">M</a>
			<a class="adc abc_c" data='15' href="/account.php?module=eaglehome&mode=N&center_s=<?=$center_s?>">N</a>
			<a class="adc abc_c" data='16' href="/account.php?module=eaglehome&mode=O&center_s=<?=$center_s?>">O</a>
			<a class="adc abc_c" data='17' href="/account.php?module=eaglehome&mode=P&center_s=<?=$center_s?>">P</a>
			<a class="adc abc_c" data='18' href="/account.php?module=eaglehome&mode=Q&center_s=<?=$center_s?>">Q</a>
			<a class="adc abc_c" data='19' href="/account.php?module=eaglehome&mode=R&center_s=<?=$center_s?>">R</a>
			<a class="adc abc_c" data='20' href="/account.php?module=eaglehome&mode=S&center_s=<?=$center_s?>">S</a>
			<a class="adc abc_c" data='21' href="/account.php?module=eaglehome&mode=T&center_s=<?=$center_s?>">T</a>
			<a class="adc abc_c" data='22' href="/account.php?module=eaglehome&mode=U&center_s=<?=$center_s?>">U</a>
			<a class="adc abc_c" data='23' href="/account.php?module=eaglehome&mode=V&center_s=<?=$center_s?>">V</a>
			<a class="adc abc_c" data='24' href="/account.php?module=eaglehome&mode=W&center_s=<?=$center_s?>">W</a>
			<a class="adc abc_c" data='25' href="/account.php?module=eaglehome&mode=X&center_s=<?=$center_s?>">X</a>
			<a class="adc abc_c" data='26' href="/account.php?module=eaglehome&mode=Y&center_s=<?=$center_s?>">Y</a>
			<a class="adc abc_c" data='27' href="/account.php?module=eaglehome&mode=Z&center_s=<?=$center_s?>">Z</a>			
		</div>
	</div>
</div>
<div class="mask">
	<div class="hi">
		<div class="shangjia" style=''>
		<?php 

		$where = "IsSupplier=1 and Is_Business_License='0'";
		if($_GET['mode']){
			$mode = $_GET['mode'];
			$where .= " and Supplier_Name like '$mode%'";
		}


		if($_GET['center_s']){
			$center_s =$_GET['center_s'];
			$where .= " and Supplier_Name like '%$center_s%'";
		}
			$member_row =$db->get_limit('member',$where,'*','1',"0",'20');
			//var_dump($member_row);exit;
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
		}
	})
</script>