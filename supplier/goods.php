<?php 
include("../inc/include.php");
$MemberId = $_SESSION['member_MemberId'];
$IsSupplier = $_SESSION['IsSupplier'];
$Is_Business_License = $_SESSION['Is_Business_License'];
$SupplierId = $_GET['SupplierId'];
$ProId = (int)$_GET['ProId'];
$ProId && $product_row = $db->get_one('product',"ProId='$ProId'");
$CateId = $product_row['CateId'];
$CateId && $category_row = $db->get_one('product_category',"CateId='$CateId'");
$product_description_row = $db->get_one('product_description',"ProId='$ProId'");
$goods_row=$db->get_all('product_wholesale_price', "ProId='$ProId'", '*', 'PId desc');
$shipping_row=$db->get_all('shipping_freight','SFID=1');
$shipping_row_2=$db->get_all('shipping_freight','SFID=2');
$member_supplierid = (int)$_GET['SupplierId'];
//$proid_cishu = $db->get_one('goods_Browser',"ShopId='$ProId'",'Browser');
$number =$product_row['ProductCodeId'];
$supplierid = $_GET['SupplierId'];
$isbl = $db->get_one('member',"MemberId=$supplierid",'Is_Business_License');
$isbl = $isbl['Is_Business_License'];
$OrderStatus = $db->get_row_count('orders',"MemberId='$SupplierId' and OrderStatus='8'");
$coll_row = $db->get_row_count('coll',"ProId='$ProId'");

include("../inc/common/header.php");
include("../inc/common/search_header.php");
?>
<link href="/css/base.css" rel="stylesheet" type="text/css" />
<?php 
	echo '<link rel="stylesheet" href="/css/supplier/yxx'.$lang.'.css" />';
?>
<script type="text/javascript" src="../js/base.js"></script>
<script src="../js/goods.js"></script>
<script type="text/javascript" src="../js/jquery.jqzoom.js"></script>
<form action="/cart.php?module=add" method="post">
<div class="mask2">
	<div class="lunbo_box">
	<div class="chanpinleimu"><div class="chanpimg"></div><a class="chanp_a" href=""><?=$website_language['goods'.$lang]['cplm']?></a></div>
	<div class="chanpinleimu_right" style="">
		<div class="guide">
		<div class="navigation">
			<!-- <?=$website_language['nav_lang_1']['home']; ?> -->&nbsp;&nbsp;&nbsp;&nbsp; <?=$CateId?supplier_get_web_position2($category_row, 'product_category',' <i><i class="icon iconfont icon-left"></i></i> ','supplier_product_category',$SupplierId):$website_language['products'.$lang]['products'];?>	
		</div>	
		</div>	
	</div>
	</div>	
</div>
<div class="mask">
	<div class="goods_top">
<div class="goods_top_up">
<div class="right-extra">
  <div>

    <div id="preview" class="spec-preview"> <span class="jqzoom"><img src="<?=str_replace('s_','',$product_row['PicPath_0']); ?>" /></span> </div>
    <div class="spec-scroll"> <a class="prev">&lt;</a> <a class="next">&gt;</a>
      <div class="items">
        <ul class="small_img">
			<?php for($i=0;$i<5;$i++){ 
				if(!is_file($site_root_path.$product_row['PicPath_'.$i])) continue;
			?>
          		<li class="list" data="1"><img class="item_img"  alt=""  src="<?=str_replace('s_','',$product_row['PicPath_'.$i]); ?>"></li> 
          	<?php } ?>
        </ul>
      </div>
    </div>
  </div>
  <div style="clear:both;height:10px;"></div>  
</div>	
  <div class="goods_top_right">
    <div class="Commodity">
      <div class="Commodity_name"><?=$product_row['Name'.$lang] ? $product_row['Name'.$lang] : $product_row['Name'];?></div>
     <!--  <div class="Commodity_evaluation"><img src="../images/goods/wuxingpinglun.png" alt="" /><a href="">0评论</a><a href=""><?=$OrderStatus?>笔交易</a></div> -->
    </div>
    <div class="Commodity_mask">
    	<div class="Convention1" style="position:relative">
    		<div class="Convention_price"><?=$website_language['goods'.$lang]['jg']?>:</div>
    		<div class="Convention_price_txt"><span>USD $</span><span class='Convention_price_txt_t'><?=$product_row['Price_1']?></span>/<?=$website_language['goods'.$lang]['jian']?></div>
    		<div class="refer" id="refer"><?=$website_language['ylfy'.$lang]['ckhb']; ?></div>
			<div class="rate" id="rate">
				<div class="rate-w">
					<p class="rete-title"><?=$website_language['ylfy'.$lang]['ckhb']; ?></p>
					<div class="rate-con">
						<ul class="rate-ul" id="rateDiv">
							<li><img src="/../images/rete/BRL.jpg"/><span class="rate-ul_span1">BRL</span><span title="100000000000.00" class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/EUR.jpg"/><span class="rate-ul_span1">EUR</span><span title="100000000000.00" class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/RUB.jpg"/><span class="rate-ul_span1">RUB</span><span class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/PHP.jpg"/><span class="rate-ul_span1">PHP</span><span class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/INR.jpg"/><span class="rate-ul_span1">INR</span><span class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/CAD.jpg"/><span class="rate-ul_span1">CAD</span><span class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/AUD.jpg"/><span class="rate-ul_span1">AUD</span><span class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/TRY.jpg"/><span class="rate-ul_span1">TRY</span><span class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/GBP.jpg"/><span class="rate-ul_span1">GBP</span><span class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/SEK.jpg"/><span class="rate-ul_span1">SEK</span><span class="rate-ul_span2">0.00~0.00</span></li>
							<li><img src="/../images/rete/MYR.jpg"/><span class="rate-ul_span1">MYR</span><span class="rate-ul_span2">0.00~0.00</span></li>
						</ul>
					</div>
					<p class="tips"><?=$website_language['ylfy'.$lang]['zhuyi']; ?></p>
				</div>
			</div>
    	</div>
    	<div class="Convention">
    		<div class="min_Order"><?=$website_language['goods'.$lang]['zxqd']?>:</div>
    		<div class="min_Order_number"><span class="Order_number"><?=$product_row['StartFrom']; ?></span><span class="order_Company">&nbsp;<?=$website_language['goods'.$lang]['jian']?></span></div>
    	</div>
    	<div class="Convention">
    		<div class="Wholesale_price"><?=$website_language['goods'.$lang]['pfjg']?>:</div>
    		<div class="Wholesale_right">
			<?php if($goods_row['1'] == ''){?>
	    		<div class="Wholesale_mask" style="">
	    			<div class="Wholesale_div">
	    				<div class="Wholesale_number"><?=$product_row['StartFrom']; ?>+</div>
	    				<div class="Wholesale_dollar" style="">USD $<?=$product_row['Price_1']; ?></div>
	    			</div>
	    		</div>	    		
			<?php }else{
				for($i=0; $i<count($goods_row); $i++){
				?>
					<?php if(count($goods_row) > 1){?>
			    		<div class="Wholesale_mask" style="">
			    			<div class="Wholesale_div">
			    				<div class="Wholesale_number"><?=$goods_row[$i]['Qty']; ?>+</div>
			    				<div class="Wholesale_dollar" style="">USD $<?=$goods_row[$i]['Price']; ?></div>
			    			</div>
			    		</div>
			    	<?php }?>
    			<?php }?>
    		<?php }?>
    		</div>
    	</div>     	
    	<div class="Convention2">
    		<div class="Convention_color"><?=$website_language['goods'.$lang]['ys']?>:</div>
    		<div class="Convention_img">
    		<?php 
    			$color_id =$product_row['ColorId'];
	    			$color_id_arr = explode(",",$color_id);
	    			for ($i=0; $i <count($color_id_arr); $i++){
	    				if(count($color_id_arr) > 0){
	    				$CId = $color_id_arr[$i];
	    				$product_color_one = $db->get_one("product_color","CId='$CId'");
    		?>
						<div class="Convention_list" >
							<span class='color_name'><?=$product_color_one['Color_lang_1']?></span>
							<span class='color_member'>
							<input type="hidden" name="Order_Color[]" value="<?=$product_color_one['CId']?>">
								<a class="del">-</a>
								<input class="Qty" name="Color_Qty[]" type="text" value='0'>
								<a class="add">+</a>
							</span>
						</div>   
						
						
			<?php }}?> 		
	    		    	 
    		</div>

    		<div class="bor">
    			<div class="over"></div>
    		</div>
    		
    	</div> 
    	<div class="Convention">
    		<div class="Convention_number"><?=$website_language['goods'.$lang]['sl']?>:</div>
    		<div class="number_right">
    			<span id='number_div' class="number_div">0</span><span><?=$website_language['goods'.$lang]['jian']?></span>
    			<input type="hidden" name="Qty" class="sum" value="0">
    			<span class="error_text"></span>
    		</div>
    	</div>
    <!-- 	<div class="Convention">
    		<div class="shipping_type">运输方式:</div>
    		<div class="shipping_right">
	    		<div class="position">
		    		<input type="button" value="空运" class="air_transport">
		    		<input type="button" value="船运" class="air_transport">
	    		</div>       			
    		</div>
    	</div> -->

    	<!-- <div class="Convention_shipping">
    		<div class="shipping">运输:</div>
    		<div class="shipping_rightDiv">
    			<div class="delivery" >
    				<select class="place1" name="" id="">
						<option value="墨西哥">墨西哥</option>
						<option value="中国">中国</option>					
					</select>
					<span>送货到</span><select class="place" name="" id="">
						<option value="墨西哥">墨西哥</option>
						<option value="中国">中国</option>					
					</select>
				</div>				
    		</div>
    		<div class="deliveryTips" id="deliveryTips">
						<?=$website_language['goods_lang_1']['tips']; ?>
			</div>    				
    	</div> -->

    	<div class="Convention_button">

    		<?php if($IsSupplier !='1'){ ?>
	    		<input type="submit" class="buy_now" name="mysubmit" value="1">
	    		<input type="button" class="buy_now2" value="<?=$website_language['goods'.$lang]['ljgm']?>">
	    		<button class="join_shopping_cart" style="" id=""><?=$website_language['goods'.$lang]['jrgwc']?></button>
    		<?php }elseif($Is_Business_License !='1'){ ?>
    			<input type="submit" class="buy_now" name="mysubmit" value="1">
	    		<input type="button" class="buy_now2" value="<?=$website_language['goods'.$lang]['ljgm']?>">
	    		<button class="join_shopping_cart" style="" id=""><?=$website_language['goods'.$lang]['jrgwc']?></button>
    		<?php }else{ ?>
				<input type="submit" disabled="true" class="buy_now" name="mysubmit" value="1">
	    		<input type="button" disabled="true" class="buy_now2 buy_now3" value="<?=$website_language['goods'.$lang]['ljgm']?>">
	    		<button disabled="true" class="join_shopping_cart buy_now3" style="" id=""><?=$website_language['goods'.$lang]['jrgwc']?></button>
				<div style="clear:both;"></div>
	    		<div class="sorry">*对不起，商户账号不能直接进行购买或加入购物车！</div>
    		<?php }?>
    		<!-- <div style="float:right">
	    		<div class="share_txt"><?=$website_language['goods'.$lang]['fx']?>：</div>
			 	<div class="share_mask">
			 		<a href=""><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/tumblr.png" alt="" /></a>
			 		<a href=""><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" alt="" /></a>
			 		<a href=""><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" alt="" /></a>
			 		<a href=""><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/print.png" alt="" /></a>
			 		<a href=""><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/addthis.png" alt="" /></a>
			 	</div>
    		</div> -->
			<input type="hidden" name="ProId" value="<?=$ProId; ?>">
			<input type="hidden" name="SupplierId" value="<?=$SupplierId; ?>">
			<input type="hidden" name="SupplierId" value="<?=$SupplierId; ?>">
    	</div>
</form>
			<?php 
			
			if($MemberId != ''){
    			if($IsSupplier != '1'){
    		?>
    	<div class="Convention_Favorites">
    		<div class="Favorites_img">
    		<?php 
    			$coll_row_j = $db->get_one("coll","MemberId='$MemberId' and ProId='$ProId'");
    			if($coll_row_j){
    		?>
    			<img id="Favorites_pic" src="../images/goods/Favorites_before2.png" alt="" />  
    		<?php }else{?> 
    			<img id="Favorites_pic" src="../images/goods/Favorites_before.png" alt="" />  
    		<?php }?>  	 			
    		</div>
    		
    			<div class="Favorites_txt"><a id="Favorites"><?=$website_language['goods'.$lang]['jrscj']?></a><!-- (<a id="Favorites_number"><?=$coll_row ? $coll_row : 0;?></a>) --></div>
    		
    	</div>	
    	<?php }}?>	
    </div>
  </div>   
	</div>
</div>
</div>
<div class="mask">
	<div class="goods_index">
	<div class="Isolation_layer">
		<div class="Best_Sellers_mask">
		<div class="Best_Sellers_mask_1">
			<div class="Best_title"><?=$website_language['goods'.$lang]['xgcp']?></div>
			<?php 
			
			$related_product_row = $db->get_limit('product',"CateId=".$product_row['CateId'].' and IsUse=2 and ProId!='.$ProId,'*','MyOrder desc,ProId desc',0,4);
			//var_dump($related_product_row);exit;
			foreach((array)$related_product_row as $k=>$v){ 
				$name = $v['Name'.$lang];
				$img = $v['PicPath_0'];
				$url = get_url('product',$v);
				$price = $v['Price_1'];
				$ProId1 = $v['ProId'];
			?>
			<div class="Best_title_mask">
				<div data='<?=$ProId1?>' class="Best_title_inner">
					<div class="title_inner_img">
						<a class="Product_price_a" href="<?=$url?>">
							<img title="<?=$name?>" src="<?=$img?>" alt="" />
						</a>
					</div>
					<div class="Product_price"><a class="Product_price_a" href="<?=$url?>">USD $<?=$price?></a><span class="Product_price_span">/<?=$website_language['goods'.$lang]['jian']?></span></div>	
					<div class="Product_name">
						<a class="Product_price_a" href="<?=$url?>">
							<?=$name?>
						</a>
						<i class='slh'></i>
					</div>								
				</div>				
			</div>	
			<?php }?>
				
		</div>				
		</div>
		<div class="Commodity_parameter">
			<div class="Commodity_Description_mask">
				<div data='cs1' class="cs"><?=$website_language['goods'.$lang]['cpxq']?></div>
				<div data='cs2' class="cs"><?=$website_language['goods'.$lang]['khpl']?></div>
				<div data='cs3' class="cs"><?=$website_language['goods'.$lang]['shyfk']?></div>
			</div>
			<div class="cs1 hh">
				<!--<div class="Article_details">
						
				</div>-->		
				<div class="Article_details_txt">	
				<?php 
					if($lang == "_en"){
						$Description_goods = $product_description_row['Description_lang_2'];
					}else{
						$Description_goods = $product_description_row['Description'.$lang];
					}
				?>			
					<?=$Description_goods; ?>
				</div>
			</div>
			<div class="cs2 hh">
				<?=$website_language['goods'.$lang]['khpl']?>
			</div>
			<div class="cs3 hh">
				<?=$website_language['goods'.$lang]['shyfk']?>
			</div>
			
		</div>
	</div>
</div>
</div>

<script>
	$(function(){
		 $(document).click(function(){
			var te=$('.number_div').text();			
		    var sum=0; 
		    $("input[class^='Qty']").each(function(){ 
			    var r = /^-?\d+$/ ;　//正整数 
			   	if($(this).val() !=''&&!r.test($(this).val())){ 
			    $(this).val("");  //正则表达式不匹配置空 
			    }else if($(this).val() !=''){ 
			       sum+=parseInt($(this).val()); 	
			       $(".number_div").text(sum); 
			       $(".sum").val(sum); 		    
			    } 			    
			});		 					
	 	var BRL=window.localStorage.getItem("BRL",BRL);
	 	var EUR=window.localStorage.getItem("EUR",EUR);
	 	var RUB=window.localStorage.getItem("RUB",RUB);
	 	var PHP=window.localStorage.getItem("PHP",PHP);
	 	var INR=window.localStorage.getItem("INR",INR);
	 	var CAD=window.localStorage.getItem("CAD",CAD);
	 	var AUD=window.localStorage.getItem("AUD",AUD);
	 	var GBP=window.localStorage.getItem("GBP",GBP);
	 	var SEK=window.localStorage.getItem("SEK",SEK);
	 	var MYR=window.localStorage.getItem("MYR",MYR);
	 	var rateDiv = $("#rateDiv");
		var pt =$('.Convention_price_txt_t').text();
		var p=$('.number_div').text();
		rateDiv.html('<li><img src="/images/rete/BRL.jpg"/><span class="rate-ul_span1">BRL</span><span class="rate-ul_span2">'+(pt*BRL*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/EUR.jpg"/><span class="rate-ul_span1">EUR</span><span class="rate-ul_span2">'+(pt*EUR*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/RUB.jpg"/><span class="rate-ul_span1">RUB</span><span class="rate-ul_span2">'+(pt*RUB*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/PHP.jpg"/><span class="rate-ul_span1">PHP</span><span class="rate-ul_span2">'+(pt*PHP*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/INR.jpg"/><span class="rate-ul_span1">INR</span><span class="rate-ul_span2">'+(pt*INR*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/CAD.jpg"/><span class="rate-ul_span1">CAD</span><span class="rate-ul_span2">'+(pt*CAD*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/AUD.jpg"/><span class="rate-ul_span1">AUD</span><span class="rate-ul_span2">'+(pt*AUD*p).toFixed(2)+'</span></li>'+			
					'<li><img src="/images/rete/GBP.jpg"/><span class="rate-ul_span1">GBP</span><span class="rate-ul_span2">'+(pt*GBP*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/SEK.jpg"/><span class="rate-ul_span1">SEK</span><span class="rate-ul_span2">'+(pt*SEK*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/MYR.jpg"/><span class="rate-ul_span1">MYR</span><span class="rate-ul_span2">'+(pt*MYR*p).toFixed(2)+'</span></li>');
        $.ajax({
            type:"get",
            url:"/supplier/ajax.php",
            data:{
              act:"get",
            },
          	dataType:"jsonp",
          	jsonp:"callback",          
          	success:function(brl){           		
	          	var rateDiv = $("#rateDiv");
				var pt =$('.Convention_price_txt_t').text();
				var p=$('.number_div').text();
	              brl=brl.split(",");     	                    
	              BRL=brl[6].substring(12,18);             
	              EUR=brl[23].substring(12,18);
	              RUB=brl[40].substring(12,19);
	              PHP=brl[57].substring(12,19);
	              INR=brl[74].substring(12,19);
	              CAD=brl[91].substring(12,18);
	              AUD=brl[108].substring(12,18);
	              GBP=brl[125].substring(12,18);
	              SEK=brl[142].substring(12,18);
	              MYR=brl[159].substring(12,18);  
	              window.localStorage.setItem("BRL",BRL);
	              window.localStorage.setItem("EUR",EUR);
	              window.localStorage.setItem("RUB",RUB);
	              window.localStorage.setItem("PHP",PHP);
	              window.localStorage.setItem("INR",INR);
	              window.localStorage.setItem("CAD",CAD);
	              window.localStorage.setItem("AUD",AUD);
	              window.localStorage.setItem("GBP",GBP);
	              window.localStorage.setItem("SEK",SEK);
	              window.localStorage.setItem("MYR",MYR);
	              function exchangeRate(){
	              	var exchangeRateTxt=rateDiv.html('<li><img src="/images/rete/BRL.jpg"/><span class="rate-ul_span1">BRL</span><span class="rate-ul_span2">'+(pt*BRL*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/EUR.jpg"/><span class="rate-ul_span1">EUR</span><span class="rate-ul_span2">'+(pt*EUR*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/RUB.jpg"/><span class="rate-ul_span1">RUB</span><span class="rate-ul_span2">'+(pt*RUB*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/PHP.jpg"/><span class="rate-ul_span1">PHP</span><span class="rate-ul_span2">'+(pt*PHP*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/INR.jpg"/><span class="rate-ul_span1">INR</span><span class="rate-ul_span2">'+(pt*INR*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/CAD.jpg"/><span class="rate-ul_span1">CAD</span><span class="rate-ul_span2">'+(pt*CAD*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/AUD.jpg"/><span class="rate-ul_span1">AUD</span><span class="rate-ul_span2">'+(pt*AUD*p).toFixed(2)+'</span></li>'+			
					'<li><img src="/images/rete/GBP.jpg"/><span class="rate-ul_span1">GBP</span><span class="rate-ul_span2">'+(pt*GBP*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/SEK.jpg"/><span class="rate-ul_span1">SEK</span><span class="rate-ul_span2">'+(pt*SEK*p).toFixed(2)+'</span></li>'+
					'<li><img src="/images/rete/MYR.jpg"/><span class="rate-ul_span1">MYR</span><span class="rate-ul_span2">'+(pt*MYR*p).toFixed(2)+'</span></li>');
					return exchangeRateTxt;
	              }
	              exchangeRate();	             		
			     
          },
          error:function(){
            
          }
        })          
})
})
</script>
<script type="text/javascript">
$(function(){
			var d=1;      
   			var email ="<?=$_SESSION['UserName']; ?>";
		    $(".Best_title_inner").click(function(){  		  		           	
            var c=$(this).attr("data");          
          	
				$.ajax({
	         	type:"get",
	         	url:"/getGoodId.php",
	         	data:{
	         		act:'index',
	         		getProId:c,
	         		cishu:d,
	         		email:email,
	         	},
	         	success:function(data){	          	
	         		
	         	},
	         	error:function(){
	        	 	
	         	}
	         })					
		}) 
		$("#AddToCart").click(function(){
			$.ajax({
			type:"GET",
			url:"/inc/lib/cart/module/add.php",
			data:{
				act:"goods",
				ProId:"<?=$product_row['ProId']; ?>",
				name:"<?=$product_row['Name_lang_1']; ?>",
				Price_1:"<?=$product_row['Price_1']; ?>",
				StartFrom:"<?=$product_row['StartFrom']; ?>",

				},
			// dataType:"json", 
			success:function(){		
				//alert('成功加入购物车');
			},
			error:function(){

			}
		})
	})	
	
	
	
	$("#Favorites").click(function(){
		var SupplierId = "<?=$SupplierId;?>";
		var MemberId = "<?=$MemberId;?>";
		var ProId = "<?=$ProId;?>";
		//console.log(ProId);
		$.ajax({
			type:"get",
            url:"/ajax/ajax_Favorites.php",
            data:{
              act:"coll",
              SupplierId:SupplierId,
              ProId:ProId,
              MemberId:MemberId,
            },
          	success:function(data){
          		data=eval('(' +data+ ')');
          		var status=data.status;
          		var count=data.count;       
          		if(status==1){      		
          			$('#Favorites_pic').attr('src','/images/goods/Favorites_before2.png');
          			$("#Favorites").text('取消收藏');
          		}else if(status==3){
          			$('#Favorites_pic').attr('src','/images/goods/Favorites_before.png');
          			// $("#Favorites_number").text(count);
          			$("#Favorites").text("<?=$website_language['goods'.$lang]['jrscj']?>");
          		}else if(status==0){
          			alert("<?=$website_language['ylfy'.$lang]['scsb']; ?>");
          		}          		
          	},
          	error:function(){
          		alert("<?=$website_language['ylfy'.$lang]['cw'];?>")
          	}
		})		
	})			
})
</script>
<?php 
include("../inc/common/footer.php");
?>