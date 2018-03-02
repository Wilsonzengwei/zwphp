<?php
if($_SESSION['ProductListType']==0){
	$list_row_count=1;	//每行显示的产品件数
	$product_img_width=160;	//产品图片宽度
	$product_img_height=160;	//产品图片高度
}elseif($_SESSION['ProductListType']==1){
	$list_row_count=4;
	$product_img_width=160;
	$product_img_height=160;
}elseif($_SESSION['ProductListType']==2){
	$list_row_count=3;
	$product_img_width=230;
	$product_img_height=230;
}

!isset($_SESSION['ProductListType']) && $_SESSION['ProductListType']=1;
!isset($_SESSION['ProductSortedBy']) && $_SESSION['ProductSortedBy']=0;
!isset($_SESSION['ProductShow']) && $_SESSION['ProductShow']=0;

$products_sorted_by_ary=array('', 'Name asc,', 'Price_1 asc,', 'Price_1 desc,');
$products_sorted_by_value_ary=array('Default', 'Item Name', 'Price(Low to high)', 'Price(High to low)');
$products_show_ary=array(24, 36, 48);

if(!isset($product_row)){
	$page_count=$products_show_ary[$_SESSION['ProductShow']];
	$products_order_by=$products_sorted_by_ary[$_SESSION['ProductSortedBy']];
	$where='SoldOut=0';	//基本搜索条件，如果后台开启了上下架功能，这里请设置为：SoldOut=0
	include($site_root_path.'/inc/lib/product/get_list_row.php');
}

ob_start();
?>
<div id="lib_product_list_shop">
	<div class="index">
		<div class="info">Showing <?=$start_row+1;?> - <?=$start_row+count($product_row);?> of <?=$row_count;?> Items</div>
		<div id="turn_page"><?=turn_page($page, $total_pages, '', $row_count, '<<', '>>', 1);?></div>
		<div class="clear"></div>
	</div>
	<div class="lcr">
		<div class="view">
			<ul>
				<li class="v"><div>View:</div></li>
				<li class="<?=$_SESSION['ProductListType']==0?'cur':'';?>"><div class="t0"><a href="/inc/lib/global/info.php?ListType=0">List</a></div></li>
				<li class="<?=$_SESSION['ProductListType']==1?'cur':'';?>"><div class="t1"><a href="/inc/lib/global/info.php?ListType=1">Grid</a></div></li>
				<li class="<?=$_SESSION['ProductListType']==2?'cur':'';?>"><div class="t2"><a href="/inc/lib/global/info.php?ListType=2">Gallery</a></div></li>
			</ul>
		</div>
		<div class="act">
			<div class="po">
				<div><strong>Sort by:</strong></div>
				<div class="menu">
					<dl class="menuout" onmouseover="this.className='menuover';" onmouseout="this.className='menuout';"> 
						<dt><?=$products_sorted_by_value_ary[$_SESSION['ProductSortedBy']];?> <img src="/images/lib/product/jt.jpg" align="absmiddle" /></dt> 
						<dd> 
							<?php
							for($i=0; $i<count($products_sorted_by_ary); $i++){
							?>
								<a href="/inc/lib/global/info.php?SortedBy=<?=$i;?>"><?=$products_sorted_by_value_ary[$i];?></a>
							<?php }?>
						</dd> 
					</dl>
				</div>
				<div><strong>Show:</strong></div>
				<div class="menu show">
					<dl class="menuout" onmouseover="this.className='menuover';" onmouseout="this.className='menuout';"> 
						<dt><?=$products_show_ary[$_SESSION['ProductShow']];?> <img src="/images/lib/product/jt.jpg" align="absmiddle" /></dt> 
						<dd> 
							<?php
							for($i=0; $i<count($products_show_ary); $i++){
							?>
								<a href="/inc/lib/global/info.php?Show=<?=$i;?>"><?=$products_show_ary[$i];?></a>
							<?php }?>
						</dd> 
					</dl>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php
	$j=1;
	for($i=0; $i<count($product_row); $i++){
		$url=get_url('product', $product_row[$i]);
		if($_SESSION['ProductListType']==0){
			$img_path=$product_row[$i]['PicPath_0'];
		}elseif($_SESSION['ProductListType']==1){
			$img_path=$product_row[$i]['PicPath_0'];
		}else{
			$img_path=str_replace('s_', '230X230_', $product_row[$i]['PicPath_0']);
		}
		
		if($_SESSION['ProductListType']==0){
	?>
			<div class="item_0">
				<ul>
					<li class="img" style="width:<?=$product_img_width;?>px; height:<?=$product_img_height;?>px;"><div><a href="<?=$url;?>" title="<?=$product_row[$i]['Name'];?>"><img src="<?=$img_path;?>"/></a></div></li>
					<li class="info">
						<div class="name"><a href="<?=$url;?>" title="<?=$product_row[$i]['Name'];?>"><?=$product_row[$i]['Name'];?></a></div>
						<div class="desc"><strong>Description: </strong><?=$product_row[$i]['BriefDescription'];?>&nbsp;&nbsp;<a href="<?=$url;?>" title="<?=$product_row[$i]['Name'];?>">Learn more..</a></div>
						<div class="w_review"><a href="<?=$url;?>#write_review_form">Write a review</a></div>
					</li>
					<li class="price">
						<div class="p0">List Price: <del><?=price_list($product_row[$i]['Price_0']);?></del></div>
						<div class="p1">Sale: <?=price_list($product_row[$i]['Price_1']);?></div>
					</li>
				</ul>
			</div>
			<?php if($j++<count($product_row)){?><div class="blank12"></div><?php }?>
	<?php }else{?>
			<div class="item" style="width:<?=sprintf('%01.2f', 100/$list_row_count);?>%;">
				<ul style="width:<?=$product_img_width+2;?>px;">
					<li class="img" style="width:<?=$product_img_width;?>px; height:<?=$product_img_height;?>px;"><div><a href="<?=$url;?>" title="<?=$product_row[$i]['Name'];?>"><img src="<?=$img_path;?>"/></a></div></li>
					<li class="name"><a href="<?=$url;?>" title="<?=$product_row[$i]['Name'];?>"><?=$product_row[$i]['Name'];?></a></li>
					<li class="price"><del><?=price_list($product_row[$i]['Price_0']);?></del><span>Sale <?=price_list($product_row[$i]['Price_1']);?></span></li>
				</ul>
			</div>
			<?php if($j++%$list_row_count==0 && $j<=count($product_row)){echo '<div class="blank12"></div>';};?>
	<?php
		}
	}
	?>
	<div class="clear"></div>
	<div id="turn_page"><?=turn_page($page, $total_pages, '', $row_count, '<<', '>>', 1);?></div>
</div>
<?php
$product_list_shop=ob_get_contents();
ob_clean();
?>