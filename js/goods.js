
$(document).ready(function(){
		$(".expressTr").click(function(){
	    	$('.radioTd').removeAttr('checked');
	    	$(".expressTr").attr("class","tabDiv_bottom expressTr");
	    	$(this).attr("class","tabDiv_bottom expressTr trClick");
	    	$($(this).children().children()[0]).attr('checked','checked');
	    });
		$("#refer").hover(function(){
	    	$("#rate").toggle();
	    });
	    
	    $(".divSale").click(function(){
	    	$(".divSale").attr("class","divSale")
	    	$(this).attr("class","divSale saleClick");
	    	$("#Qty").val($(this).children()[0].innerHTML);
	    });
	    
	    $("#air").click(function(){
	    	$("#shipping").attr("class","transport");
	    	$("#air").attr("class","transport transportClick");
	    	$("#minday").html($("#air").attr("minday"));
	    	$("#maxday").html($("#air").attr("maxday"));
	    	$("#airTab").attr("class","expressTab displayB");
	    	$("#shippingTab").attr("class","expressTab displayN");
	    });

	    $("#shipping").click(function(){
	    	$("#air").attr("class","transport");
	    	$("#shipping").attr("class","transport transportClick");
	    	$("#minday").html($("#shipping").attr("minday"));
	    	$("#maxday").html($("#shipping").attr("maxday"));
	    	$("#airTab").attr("class","expressTab displayN");
	    	$("#shippingTab").attr("class","expressTab displayB");
	    });
	    
	    $("#question").hover(function(){
	    	$("#deliveryTips").toggle();
	    });
	    
	    $(".clearance").click(function(){
	    	$(".clearance").attr("class","place clearance maxW-150");
	    	$(this).attr("class","place clearance clearanceClick maxW-150");
	    });
	    
	    /*选择运送方式*/
	    
	    
	    $("#deliveryClick").click(function(){
	    	$("#mode").css("display","block");
	    })
	    $("#closeDiv").click(function(){
	    	$("#mode").css("display","none");
	    })
	    $("#modeBtn").click(function(){
	    	$("#mode").css("display","none");
	    	$("#minday").html(parseFloat($(".trClick").attr("minday"))+parseFloat($(".clearanceClick").attr("day")));
	    	$("#maxday").html(parseFloat($(".trClick").attr("maxday"))+parseFloat($(".clearanceClick").attr("day")));
	    	$("#express").html($(".trClick").attr("kdname"));
	    });
	$('.position').find('.air_transport').click(function(){
		$('.position').find('.air_transport').css('border','1xp solid #ddd');
		$(this).css('border','1px solid #5f8aff');
	})	
	$('.position').each(function(){
		$(this).find('.air_transport:eq(0)').css('border','1px solid #5f8aff');
	})
	$('.Commodity_Description_mask').each(function(){
		$(this).find('.cs:eq(0)').css('background','#2962ff').css('color','#fff');
	})
	$('.Wholesale_right').each(function(){
		$(this).find('.Wholesale_mask:eq(0)').css('background','#fcf2e0');
	})
	$('.cs').click(function(){
		$('.cs').css('background','#fff').css('color','#333');
		$(this).css('background','#2962ff').css('color','#fff');
		var cd=$(this).attr('data');
		$('.hh').css('display','none');
		$('.'+cd+'').css('display','block');
	})
	$('.small_img .list').mouseover(function(){	
		preview($(this).children("img"));		
		$('.small_img .list').children("img").css("border","1px solid #ccc");
		$(this).children("img").css("border","1px solid #2962ff").css("padding","1px");		
	});
	// $('.buy_now').click(function(){
	// 	var te=$('.number_div').text();
	// 	var tem=$('.Order_number').text();		
	// 	if(te<tem){		
	// 		$('.error_text').text('总数量不能小于起订量');
	// 		return false;
	// 	}else{	
	// 		$('.error_text').text('');	
	// 		return true;
	// 	}
	// })
	// $('.join_shopping_cart').click(function(){
	// 	var te=$('.number_div').text();
	// 	var tem=$('.Order_number').text();		
	// 	if(te<tem){		
	// 		$('.error_text').text('总数量不能小于起订量');
	// 		return false;
	// 	}else{		
	// 		$('.error_text').text('');
	// 		return true;
	// 	}
	// })
	
	$('.Product_name').each(function(){
		var ah=$(this).find('.Product_price_a').css('height');
		if(ah>'32px'){
			$(this).find('.slh').css('display','block');
		}else{
			$(this).find('.slh').css('display','none');
		}
	})
	var a=$('.Convention_img .Convention_list').length;
	if(a>6){
		$('.over').css('display','block');
	}else if(a<=6){
		$('.over').css('display','none');
	}
	var flag=true;
	$('.over').click(function(){
		if(flag){
			$('.Convention_img').css('max-height','276px').css('overflow-y','auto');			
			flag=false;
		}else{
			$('.Convention_img').css('max-height','138px').css('overflow-y','hidden');			
			flag=true;
		}			
	})
	
	$('.buy_now2').click(function(){
		$('.buy_now').click();
	})
		 $('.Qty').keyup(function(){  
		 	var te=$('.number_div').text();			
		    var sum=0; 
		    $("input[class^='Qty']").each(function(){ 
			    var r = /^-?\d+$/ ;　//正整数 
			   	if($(this).val() !=''&&!r.test($(this).val())){ 
			    $(this).val("");  //正则表达式不匹配置空 
			    }else if($(this).val() !=''){ 
			       sum+=parseInt($(this).val()); 	
			       $(".number_div").text(sum); 	
			       $('.number_div_i').val(sum);	    
			    } 			    
			});	
		 	var qty=parseInt($(this).val());  	
    		var min=0;       		
    		if(qty<min || !qty){    		
    			qty=0;
    		}
    		$(this).val(qty);    	
    })
		// $('.Qty').each(function(){
		// 	var ac=$(this).val();
		// 	if(ac==0){
		// 		$(this).prev('.del').css('color','red');
		// 	}else{
		// 		$(this).prev('.del').css('color','#ff7300');
		// 	}
		// })
		$('.Convention_list').each(function(){	
		var a=parseInt($(this).find('.Qty').val());	
		$(this).find('.add').hover(function(){
			$(this).css('border','1px solid #ff7300').css('border-left','none').css('color','#ff7300');
			$(this).prev('.Qty').css('border','1px solid #ff7300');
		},function(){
			$(this).css('border','1px solid #e5e5e5').css('border-left','none').css('color','#333');
			$(this).prev('.Qty').css('border','1px solid #e5e5e5');
		});		
		$(this).find('.add').click(function(){			
			var a=parseInt($(this).prev('.Qty').val());
			a=(a+1);
			$(this).prev('.Qty').val(a);		
		})		
		$(this).find('.del').click(function(){	
			var a=parseInt($(this).next('.Qty').val());
			if(a>1){						
				a=(a-1);
			}else{									
				a=0;				
			}			
			$(this).next('.Qty').val(a);
		})
		
		$(this).find('.del').hover(function(){
				var brv=$(this).next('.Qty').val();
				if(brv==0){			
					$(this).css('border','1px solid #e5e5e5').css('border-right','none').css('cursor','not-allowed');
					$(this).next('.Qty').css('border','1px solid #e5e5e5');
				}else{
					$(this).css('border','1px solid #ff7300').css('border-right','none').css('color','#ff7300').css('cursor','pointer');
					$(this).next('.Qty').css('border','1px solid #ff7300');					
				}				
			},function(){
				$(this).css('border','1px solid #e5e5e5').css('border-right','none').css('color','#333');
				$(this).next('.Qty').css('border','1px solid #e5e5e5');
			})
		$('.Qty').hover(function(){
			$(this).css('border','1px solid #ff7300');
		},function(){
			$(this).css('border','1px solid #e5e5e5');
		})	

	})
	   
	});
