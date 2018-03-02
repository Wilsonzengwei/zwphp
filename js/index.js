$(function(){
	var c=($(".top_list").css("background-color"));
	$(".top_list").hover(function(){		
		var bg=$(this).attr('bg');
		var curbg=$(this).attr('curbg');		
		$(this).css('border','1px solid #e9e9e9').css('border-right','1px solid #fff').css('border-left','1px solid #fff');
		$(this).find('.y1').css('background','url('+curbg+') center no-repeat');
		$(this).find(".y2").css("color","#2962ff");
		$(this).find(".y2").css("font-weight","700");
		$(this).find(".sec_list").css("display","block");
	},function(){
		var bg=$(this).attr('bg');
		var curbg=$(this).attr('curbg');
		$(this).css('border','1px solid #fff');
		$(this).find('.y1').css('background','url('+bg+') center no-repeat');
		$(this).find(".y2").css("color","#333");			
		$(this).find(".y2").css("font-weight","0");	
		$(this).find(".sec_list").css("display","none");
	})


	var gwc=$(".right-span-span").html();
	if(gwc>99){
		alert("最大数量不能超过99");
		$(".right-span-span").html("99");
		return false;
	}
	$(".sec_list_sm_div2_a").hover(function(){
		$(this).css("color","#ec6400");
	},function(){
		$(this).css("color","#000");
	})	


	var yx=$(".lunbodiv").css("left");	
	$(".zuojiantou").click(function(){
		$(".lunbodiv").stop(true,false).animate({left:"0px"},1000);		
		$(this).css("background","url(./lunbo/LeftArrow.png)");
		$(".youjiantou").css("background","url(./lunbo/RightBlack.png)");	

		window.sessionStorage.setItem("yx_left",2);	
	})
	$(".youjiantou").click(function(){
		$(".lunbodiv").stop(true,false).animate({left:"-1130px"},1000);
		$(".zuojiantou").css("background","url(./lunbo/LeftBlack.png)");
		$(this).css("background","url(./lunbo/RightArrow.png)");
		window.sessionStorage.setItem("yx_left",1);
	})
	$(".zuojiantou").hover(function(){
		$(this).css('background',"url(./lunbo/Lefthover.png)");
	},function(){
		var y_left=window.sessionStorage.getItem('yx_left');
		if(y_left==1){
			$(this).css('background','url(./lunbo/LeftBlack.png)');
		}else if(y_left==2){
			$(this).css('background','url(./lunbo/LeftArrow.png)');	
		}		
	})
	$(".youjiantou").hover(function(){
		$(this).css('background',"url(./lunbo/Righthover.png)");
	},function(){
		var y_left=window.sessionStorage.getItem('yx_left');
		if(y_left==1){
			$(this).css('background','url(./lunbo/RightArrow.png)');
		}else if(y_left==2){
			$(this).css('background','url(./lunbo/RightBlack.png)');	
		}		
	})
	$('.hot_pro').each(function(){	
		$(this).children(".hot_pro_bg:eq(7)").css('margin-right','0px');
		$(this).children(".hot_pro_bg:eq(15)").css('margin-right','0px');
		$(this).children(".hot_pro_bg:eq(8)").css('margin-top','0px');
		$(this).children(".hot_pro_bg:eq(9)").css('margin-top','0px');
		$(this).children(".hot_pro_bg:eq(10)").css('margin-top','0px');
		$(this).children(".hot_pro_bg:eq(11)").css('margin-top','0px');
		$(this).children(".hot_pro_bg:eq(12)").css('margin-top','0px');
		$(this).children(".hot_pro_bg:eq(13)").css('margin-top','0px');
		$(this).children(".hot_pro_bg:eq(14)").css('margin-top','0px');
		$(this).children(".hot_pro_bg:eq(15)").css('margin-top','0px');
		$(this).children(".hot_pro_bg:eq(16)").css('margin-top','0px');
	})

	$(".tail_mask .tail_mask_bg:last").each(function(){
		$(this).css("border-right","1px solid #eee");
	})	


	$('.Selected_content_bottom .cate_item').click(function(){
		$(this).css('color','#ec6400').siblings('.cate_item').css('color','#333');
		var ind_cateid = $(this).attr('cateid');
		var change_content = $(this).parent().parent().next('.Selected_content_right');
			$.post('./ajax/ajax_commodity.php',{'CateId':ind_cateid,'change_product':'change_product'},function(data){
				change_content.html(data);
			});
	});


	$(".Selected_content_right .Selected_content_right_bg").hover(function(){
		$(this).css("border","1px solid #e60012");
		$(this).find(".Selected_content_right_bg_img img").css("opacity","0.8");
	},function(){
		$(this).css("border","1px solid #f2f2f2");
		$(this).find(".Selected_content_right_bg_img img").css("opacity","1");
	})

	$(".Selected .Selected_content:first").css("display",'block');
	$(".Selected .yxxx:first").css("text-decoration",'underline').css('color','#ec6400');

	$('.Commodity_namea').each(function(){
		var he=$(this).find('.Commodity_name').css('height');
		if(he>'32px'){
			$(this).find('.slh').css('display','block');
		}else{
			$(this).find('.slh').css('display','none');
		}
	})
	$('.selling .selling_content').hover(function(){		
		$(this).css('border','1px solid #895fff');
	},function(){
		$(this).css('border','1px solid #e5e5e5');
	})
	$('.selling1 .selling_content').hover(function(){
		$(this).css('border','1px solid #ff5f5f');
	},function(){
		$(this).css('border','1px solid #e5e5e5');
	})
	$('.selling2 .selling_content').hover(function(){
		$(this).css('border','1px solid #5f5fff');
	},function(){
		$(this).css('border','1px solid #e5e5e5');
	})

	$('.selling_bg').each(function(){
		$(this).children("div:eq(4)").css('margin-right','0px');
		$(this).children("div:eq(9)").css('margin-right','0px');
	})

})
// $(document).mousemove(function(e){
//   console.log(e.pageX + ", " + e.pageY);
// });
