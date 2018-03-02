$(function(){
	$('.navigation span:last').each(function(){
			$(this).children('i').html('');			
		})
		$('.navigation span:first').each(function(){
			$(this).css('color','#333');
		})
	$('.index_logo').css('cursor','pointer');
	$('.index_logo').click(function(){
		window.location='/';
	})	
	$('.search_submit').click(function(){
		window.sessionStorage.setItem("dfset",-1);
		window.sessionStorage.setItem('seset',-1);
	})
	$(".header_img").css('cursor','pointer');
	$('.header_img').click(function(){	
		window.location='/index.php';
	})
	var url=window.location.pathname;
	if(url!='/products.php'){
		window.sessionStorage.setItem('seset',-1);
		window.sessionStorage.setItem('dss',1);
	}
	if(url!='/eagle.php'){
		window.sessionStorage.setItem('abcset',1);
	}
	if(url!='/goods.php'){
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
	}
	$('.shangjia_list img').css('displsy','inline-block');

	 $.ajax({
            type:"get",
            url:"/ajax/ajax.php",
            data:{
              act:"get",
            },
          	dataType:"json",               
          	success:function(data){           		      	                    
	             data=data.split(",");
	             RMB=data[6].substring(12,18);
	             console.log(RMB);
	             window.localStorage.setItem('RMB',RMB);
			},error:function(){
		            
		    }
	})
})