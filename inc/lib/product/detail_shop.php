<?php
$product_img_width=350;	//产品图片宽度
$product_img_height=350;	//产品图片高度
$contents_width=760;	//显示内容的div的宽度

!isset($product_row) && include($site_root_path.'/inc/lib/product/get_detail_row.php');
$Name=$product_row['Name'];
$Price_0=(float)$product_row['Price_0'];
$Price_1=(float)$product_row['Price_1'];
$MOQ=(int)$product_row['MOQ'];
$CateId=(int)$product_row['CateId'];
$CateId && $category_row=str::str_code($db->get_one('product_category', "CateId='$CateId'"));
$product_description_row=str::str_code($db->get_one('product_description', "ProId='$ProId'"));

//产品分类
if($category_row['UId']!='0,'){
	$TopCateId=get_top_CateId_by_UId($category_row['UId']);
	$SecCateId=get_FCateId_by_UId($category_row['UId']);
	$TopCategory_row=str::str_code($db->get_one('product_category', "CateId='$TopCateId'"));
}
$UId_ary=@explode(',', $category_row['UId']);

$Rating=($v['IsDefaultReview'] && $product_row['DefaultReviewRating'] && (float)$product_row['Rating']==0)?(int)$product_row['DefaultReviewRating']:(int)$product_row['Rating'];
$TotalRating=($product_row['IsDefaultReview'] && $product_row['DefaultReviewTotalRating'] && (int)$product_row['TotalRating']==0)?$product_row['DefaultReviewTotalRating']:$product_row['TotalRating'];
$is_promition=($product_row['IsPromotion'] && $product_row['StartTime']<$service_time && $service_time<$product_row['EndTime'])?1:0;
$price_ary=range_price_ext($product_row,$_SESSION['member_Level']);
$MOQ=$product_row['StartFrom']?$product_row['StartFrom']:'1';
ob_start();
?>
<script type="text/javascript">

var service_time_obj=new Date(Date.UTC(<?=date('Y',$service_time)?>, <?=date('m',$service_time)?>, <?=date('d',$service_time)?>, <?=date('H',$service_time)?>, <?=date('i',$service_time)?>, <?=date('s',$service_time)?>));

var service_time_value=service_time_obj.getTime()/1000;

var service_time=function(){service_time_value++;}

setInterval(service_time, 1000);

</script>
<div id="location">Your postion: <a href="/">Home</a><?=get_web_position($category_row, 'product_category');?></div><!-- position end -->
<div class="clearfix">
	<div class="detail_left fl">
        <div class="detail_pic">
            <div class="up pic_shell">
                <div class="big_box">
                    <div class="magnify" data="{}">
                        <a class="big_pic" href="<?=str_replace('s_','',$product_row['PicPath_0'])?>"><img class="normal" src="<?=str_replace('s_','460X460_',$product_row['PicPath_0'])?>"></a>
                    </div>
                </div>
            </div>
            <div class="down">
                <div class="small_carousel horizontal">
                    <div class="viewport" data="{"small":"82x82","normal":"460x460","large":"v"}">
                        <ul class="list">
                            <?php
                                for($i=0,$len=5; $i<$len; $i++){
                                if(!is_file($site_root_path.$product_row['PicPath_'.$i])) continue;
                            ?>
                            <li class="item FontBgColor" pos="<?=$i+1?>"><a href="javascript:void(0);" class="pic_box FontBorderHoverColor" alt="" title="" hidefocus="true"><img width="100%" src="<?=str_replace('s_','',$product_row['PicPath_'.$i])?>" id="BigPic" title="" alt="" normal="<?=str_replace('s_','460X460_',$product_row['PicPath_'.$i])?>" mask="<?=str_replace('s_','',$product_row['PicPath_'.$i])?>"><span></span></a><em class="arrow FontPicArrowColor"></em></li>
                            <?php }?>
                        </ul>
                    </div>
                    <a href="javascript:void(0);" hidefocus="true" class="btn left prev"><span class="icon_left_arraw icon_arraw"></span></a>
                    <a href="javascript:void(0);" hidefocus="true" class="btn right next"><span class="icon_right_arraw icon_arraw"></span></a>
                </div>
            </div>
        </div>
        <div class="prod_info_share"><div class="addthis_sharing_toolbox"></div><b>Share this:</b></div>
    </div>
	<div class="detail_right fr">
		<div class="widget prod_info_title"><h1><?=$Name;?></h1></div>
		<div class="widget prod_info_number"><span>Item Code: <?=$product_row['ItemNumber'];?></span> <span>Warehouse NO.<?=$product_row['ItemNumber2']?></span></div>
		<div class="widget prod_info_review">
			<?php if($TotalRating){?><span class="star star_s<?=$Rating;?>"></span><a class="write_review review_count" href="#review">(<?=$TotalRating;?>)</a><?php }?><a class="write_review track" href="##"><?=$_prodLang['writeReview'];?></a>
			<a class="prod_info_pdf" href="javascript:;" target="export_pdf"><em class="icon_pdf"></em>PDF Format</a>
		</div>
		<div class="widget prod_info_price">
			<div class="widget price_left price_0">
				<div class="price_info_title1">Price:</div>
				<del id="price_del"><?=iconv_price($price_ary[1]);?></del>
			</div>
            <?php 
				//$_SESSION['member_Level'];
				$Pric_name='';
				$Pric_name=$db->get_value('member_level',"LId = '{$_SESSION['member_Level']}'",'Level');
				$is_promition && $Pric_name='Promition';
				//var_dump($_SESSION['member_Level']);
			?>
			<div class="widget price_left price_1">
				<div class="price_info_title webcolor fl"><?=$Pric_name?> Price:</div>
				<div class="current_price">
					<div class="left">
						<dl class="widget prod_info_currency">
							<dt><a href="javascript:void(0)"><?=$_SESSION['Currency'];?><div class="arrow"><em></em><i></i></div></a></dt>
							<dd>
								<ul>
									<?php
									$currency_row=$mCfg['ExchangeRate'];
									foreach((array)$currency_row as $key=> $v){
										if($v['Default']) continue;
									?>
									<li><a href="/inc/lib/global/info.php?currencies=<?=$key;?>" data="<?=$v['Name'];?>"><?=$v['Name'];?></a></li>
									<?php }?>
								</ul>
							</dd>
						</dl>
						<strong id="cur_price" class="price fl">
						<?php echo iconv_price($price_ary[0]);?>
						</strong>
                        <?php if($is_promition){?>
                        <div class="discount_count fl"><div class="discount_num fl"><?=$product_row['Discount']?>% off</div><div class="discount_time fl" id="discount_time">&nbsp;&nbsp;<span id="hour"></span>:<span id="mini"></span>:<span id="sec"></span></div></div>
                        <script type="text/javascript">
							seckill_time_count_dowm(Date.UTC(<?=date('Y',$product_row['EndTime'])?>, <?=date('m',$product_row['EndTime'])?>, <?=date('d',$product_row['EndTime'])?>, <?=date('h',$product_row['EndTime'])?>, <?=date('i',$products_row['EndTime'])?>, <?=date('s',$product_row['EndTime'])?>));
						</script>
                        <?php }?>
					</div>
				</div>
			</div>
            <?php if($is_promition){?>
			<div class="widget discount_sales">
                You Save:<span><em id="Save" style="font-style:inherit;"><?=iconv_price($price_ary[1]-$price_ary[0])?></em>(<?=$product_row['Discount']?>%)</span>
            </div>
            <?php }?>
            <div class="widget stock" style="margin-top:10px;">
                Stock:<span id="Stock"><?=$product_row['Stock']?></span>
            </div>
            <div class="widget Brif">
                <?= nl2br($product_row['BriefDescription'])?>
            </div>
		</div>
		<form class="prod_info_form" action="<?=$cart_url?>?module=add" method="post" target="addcartiframe" >
        <?php
			$all_row=$db->get_all('param','1');
			foreach((array)$all_row as $v){
				$all_attr_row[$v['PId']]=$v;
			}
			$attr_ext_ary=str::json_data(htmlspecialchars_decode($product_row['ExtAttr']), 'decode');
			$attr_ary=str::json_data(htmlspecialchars_decode($product_row['Attr']), 'decode');

				foreach((array)$attr_ary as $k=>$value){

					if($all_attr_row[$k]['FieldType']=='1'){
						$v=str::json_data(htmlspecialchars_decode($all_attr_row[$k]['Value']), 'decode');
			?>
                    <ul class="widget attributes">
                        <li class="attr_show">
                            <h5><?=$all_attr_row[$k]['Name']?>:</h5>
                            <?php
                                foreach((array)$v as $k2=>$v2){
									if(!in_array($k2,$value)) continue;
									$colorimg=$db->get_one('colorimg',"PkeyId = '$k2' and ProId = '{$product_row['ProId']}'");
                            ?>
                            <span value="<?=$k2?>" data="<?=$k?>" class="GoodBorderColor GoodBorderHoverColor colorid">
                                <img width="43" height="43" src="<?=$colorimg['PicPath_0']?>" />
                                <em class="icon_selected"></em>
                                <em class="icon_selected_bg GoodBorderBottomHoverColor"></em>
                                <em class="icon_text"><?=$v2?>
                                    <font></font>
                                </em>
                            </span>
                            <?php }?>
                            <?php /*?><input type="hidden" name="PId[]" value="<?=$parameter_menu[$i]['PId']?>" /><?php */?>
                            <input type="hidden" name="PId[]" value="<?=$k?>" />
                            <input type="hidden" name="AtrrId[]" id="attr_<?=$k?>" value="" class="attr_value" />
                        </li>
                    </ul>
            <?php }elseif($all_attr_row[$k]['FieldType']=='2'){
					$v=str::json_data(htmlspecialchars_decode($all_attr_row[$k]['Value']), 'decode');
				?>
					<ul class="widget attributes">
                        <li class="attr_show">
                            <h5><?=$all_attr_row[$k]['Name']?>:</h5>
                            <?php
                                foreach((array)$v as $k2=>$v2){
									if(!in_array($k2,$value)) continue;
                            ?>
                            <span value="<?=$k2?>" data="<?=$k?>" class="GoodBorderColor GoodBorderHoverColor">
                                <?=$v2?>
                                <em class="icon_selected"></em>
                                <em class="icon_selected_bg GoodBorderBottomHoverColor"></em>
                            </span>
                            <?php }?>
                            <input type="hidden" name="PId[]" value="<?=$k?>" />
                            <input type="hidden" name="AtrrId[]" id="attr_<?=$k?>" value="" class="attr_value" />
                        </li>
                    </ul>
			<?php }
			}
			?>
			
			<?php if($showCfg['prod']['freight']){?>
			<div class="widget key_info_line">
				<div class="key_info_left"><?=$_prodLang['shippingCost'];?>:</div>
				<div class="key_info_right"> 
					<strong id="shipping_cost_price" class="shipping_cost_price"></strong>
					<strong id="shipping_cost_freeshipping" class="FontColor" style="display:none;"><?=$_prodLang['freeShipping'];?></strong>
					<span class="shipping_cost_to"><?=$_prodLang['to'];?></span>
					<span id="shipping_flag" class="icon_flag"></span>
					<span id="shipping_cost_button" class="shipping_cost_button FontColor"></span>
				</div>
			</div>
			<div class="widget key_info_line">
				<div class="key_info_left"><?=$_prodLang['delivery'];?>:</div>
				<div class="key_info_right"><?=$_prodLang['between'];?></div>
			</div>
			<?php }?>
			<div class="widget prod_info_quantity">
				<label class="fl" for="quantity">Min Quantity: </label>
                <img class="fl tip" onmouseover="$('.exlpain').show(200);" src="/images/help_tip.png" />
				<div class="quantity_box" data="<?=htmlspecialchars('{"min":'.$MOQ.',"max":'.$product_row['Stock'].',"count":'.$MOQ.'}');?>">
                	<a class="qty_de qty_btn del"></a>
                	<input id="quantity" class="qty_num" name="Qty" autocomplete="off" type="text" value="<?=$MOQ;?>">
                	<a class="qty_add qty_btn add"></a>
                </div> <span class="qtyd">piece(s)</span> <em class="exlpain"><?=$MOQ?> pieces at least per customer. <font></font></em>
			</div>
            <script type="text/javascript">
				$(function(){
					var $bigPic=$(".detail_pic"),
						$qtyBox=$(".quantity_box");

					//价格显示
					qty_data=$.evalJSON($qtyBox.attr("data"));
					set_amount=$qtyBox.set_amount(qty_data);
				});
			</script>
			<div class="widget prod_info_actions">
				<?php if($is_stockout && $product_row['StockOut']){?>
					<input type="button" value="<?=$_prodLang['notice'];?>" class="add_btn arrival" id="arrival_button">
				<?php }elseif($is_stockout && !$product_row['StockOut']){?>
					<input type="button" value="Slod Out" class="add_btn soldout">
                <?php }elseif($product_row['IsPre']){?>
					<input type="button" value="Pre-Order" class="add_btn preorder_btn">
				<?php }else{?>
					<input type="submit" name="SubT" class="add_btn addtocart AddtoCartBgColor" value="Add to Cart" id="addtocart_button">
					<input type="submit" name="Now" value="Buy Now" class="add_btn buynow BuyNowBgColor" id="buynow_button">
				<?php }?>
				<a class="add_btn favorite_btn add_favorite" href="javascript:;" data="<?=$ProId;?>">Add to Wishlist</a>
			</div>
            <div class="widget ShippingM">
            	<span>Shipping Methods:</span>
                <div class="Shipping">
                	<?php for($i=0;$i<5;$i++){?>
                    	<img src="/images/s<?=$i?>.png" />
                    <?php }?>
                </div>
            </div>
            <div class="widget PaymentP">
            	<span>Payment Methods:</span>
                <div class="Payment">
                	<?php for($i=0;$i<5;$i++){?>
                    	<img src="/images/p<?=$i?>.png" />
                    <?php }?>
                </div>
            </div>
			<input type="hidden" id="ProId" name="ProId" value="<?=$ProId;?>" />
			<input type="hidden" id="ColorId" name="ColorId" value="" />
            <input type="hidden" name="JumpUrl" value="<?=$cart_url;?>?module=add_success" />
		</form>
	</div>
</div>
<iframe id="addcartiframe" name="addcartiframe" src="" style="display:none;"></iframe>
<div class="clearfix">
	<div class="prod_desc_left fl">
		<div class="prod_description">
			<ul class="pd_title">
				<li class="current"><span>Description</span></li>
                <li><span>Shipping & Policy</span></li>
			</ul>
			<div class="pd_content">
				<div class="desc">
					<?=str::str_code($product_description_row['Description'], 'htmlspecialchars_decode');?>
				</div>
			</div>
            <div class="pd_content" style="display:none">
				<div class="desc">
					<?=str::str_code($product_description_row['Description2'], 'htmlspecialchars_decode');?>
				</div>
			</div>
		</div>
        <div class="prod_order_review">
			<ul class="po_title">
				<li class="current"><span><?php $product_order=$db->get_row_count('orders_product_list',"ProId = '{$product_row['ProId']}'");echo $product_order?> Orders</span></li>
                <li><span><?=$product_row['IsDefaultReview']?$product_row['DefaultReviewTotalRating']:$TotalRating?> Reviews</span></li>
			</ul>
            <div class="po_content" >
				<style>
					#lib_product_orderlists .lpo_th1{width:250px;height:30px;}#lib_product_orderlists .lpo_th2{}#lib_product_orderlists .lpo_th3{width:200px;}#lib_product_orderlists .lpo_list-table{border:0;border-spacing:0;border-collapse:collapse;}#lib_product_orderlists .lpo_list-table thead th{border-bottom:2px solid #B7BED1;background-color:#E4E7F0;}#lib_product_orderlists .lpo_list-table tbody td{border-bottom:1px solid #d6d6d6;text-align:center;}#lib_product_orderlists .lpo_list-table .lpo_plist{text-align:left;padding-left:20px;}#lib_product_orderlists .lpo_name{color:#0066CC;font-weight:700;display:block;line-height:20px;}#lib_product_orderlists .lpo_state{display:block;margin-top:5px;line-height:20px;}#lib_product_orderlists .lpo_level{display:block;vertical-align:middle;line-height:20px;margin-top:10px;margin-bottom:10px;}#lib_product_orderlists .lpo_price{color:#bd1a1d;font-weight:700;}#lib_product_orderlists .lpo_prolist{display:block;line-height:20px;}#lib_product_orderlists .lpo_prolist span{ width: 193px; text-align:left;display: block; float: left;}
				</style>
            	<div id="lib_product_orderlists"></div>
                <iframe src="/inc/lib/product/orderlists.php?ProId=<?=$ProId?>" name="lib_product_orderlists_frame" style="display:none;"></iframe>
			</div>
            <div class="po_content" style="display:none">
            	<div class="avetotal">
                    <span>Average rating:</span>
                    <span class="star star_b<?=$Rating;?>"></span><font><?=$Rating;?></font> <span class="ex">(based on <?=$TotalRating;?> reviews)</span>
                </div>
                <div class="clear"></div>
                <?php if($_SESSION['MemmberId']){?>
                <div class="wreiew">
                    <span>Product Reviews:</span>
                    <a href="<?=$member_url?>?moudle=login">Write a review</a>
                </div>
                <?php }?>
                <div class="blank20"></div>
                <div id="lib_product_review"></div>
                <iframe src="/inc/lib/product/review_en.php?ProId=<?=$ProId?>" name="lib_product_orderlists" style="display:none;"></iframe>
			</div>
		</div>
	</div>
    <script>
			$(".prod_description .pd_title li").click(
				function(){
					$(".prod_description .pd_title li").removeClass('current');
					$(this).addClass('current');
					$('.pd_content').hide();
					$('.pd_content').eq($(this).index()).show();
				}
			);
			$(".prod_order_review .po_title li").click(
				function(){
					$(".prod_order_review .po_title li").removeClass('current');
					$(this).addClass('current');
					$('.po_content').hide();
					$('.po_content').eq($(this).index()).show();
				}
			);
	</script>
	<div class="prod_desc_right fr">
			<? include("$site_root_path/inc$lang_path/prorel.php")?>
	</div>
</div>
<div class="blank12"></div>
<script>
	$('.add_favorite').click(
		function(){
			$.get('/ajax/addfav.php?ProId='+$(this).attr('data'),function(data){
				if(data==1){
					pop_info_tips('Add Success!');
				}else if(data==2){
					pop_info_tips('Alredy Add!');
				}else if(data==3){
					location.href='<?=$member_url.'?mouble=login'?>';
				}
			})
		}
	)
</script>
<?php
$product_detail_shop=ob_get_contents();
ob_end_clean();
?>