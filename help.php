<?php
	include("inc/include.php");
	include('inc/common/header.php');
?>
<script src='/js/help.js'></script>
<link rel="stylesheet" href="/css/help.css">
<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['ylfy'.$lang]['bzzx']?></div>
	<ul class="y_list">
		<?php 
			$articles_row_1 = $db->get_all('articles',"Mode='1'",'*',"AId asc");
			for ($j=0; $j < count($articles_row_1); $j++) { 
				$SAId_a = $articles_row_1[$j]['AId'];
			$bg=$menu_logo_ary2[$j][0];
			$curbg=$menu_logo_ary2[$j][1];	
			//var_dump($articles_row);exit;
		?>
			<li class="y ccc1" bg='<?=$bg?>' curbg='<?=$curbg?>' bga='images/help/left01.png' curbga='images/help/left03.png'  datad='1'><i class="i1"></i><span class='s1'><?=$articles_row_1[$j]['Titles'.$lang]?></span><span class='s2'></span>
				<div class="clear"></div>
				<ul class="y1 c1" data='<?=$j?>' >
				<?php 
					$articles_row = $db->get_all('articles',"SAId='$SAId_a'",'*',"AId asc");
					for ($i=0; $i < count($articles_row); $i++) { 
						
					//var_dump($articles_row);exit;
				?>
					<a href="/help.php?AId=<?=$articles_row[$i]['AId']?>" data="<?=$articles_row[$i]['AId']?>" style='' class="x1 a<?=$articles_row[$i]['AId']?>"><?=$articles_row[$i]['Titles'.$lang]?></a>
				<?php }?>
					
				</ul>
			</li>
		<?php }?>

	</ul>		
	<div class="yx">
		<div class="title">
			<div class="title1"></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<?php 
				if($_GET['AId']){
					$AId = $_GET['AId'];
					$articles_one_row = $db->get_one("articles","AId='$AId'");
					//var_dump($articles_one_row);exit;
				}
			?>
			<?=$articles_one_row['Content'.$lang]?>
		</div>
	</div>
</div>
<?php 
	include('inc/common/footer.php');
?> 