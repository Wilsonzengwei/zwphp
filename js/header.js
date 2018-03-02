$(".right-input").on('click',function(){
	    var search=$(".search");
		var val1=$(this).val();		
		$.post('/ajax/ajax_Search.php',{'act':'search','txt':val1},function(data){
				search.html(data);
			});
		if($(".right-input").val()!=''){
			$(".drop_down_box").css("display",'block');
		}else{
			$(".drop_down_box").css("display",'none');
		}
	}).on('keyup',function (){
	    var search=$(".search");
		var val1=$(this).val();		
		$.post('/ajax/ajax_Search.php',{'act':'search','txt':val1},function(data){
				search.html(data);
			});
		if($(".right-input").val()!=''){
			$(".drop_down_box").css("display",'block');
		}else{
			$(".drop_down_box").css("display",'none');
		}
	})

	
	$(".Close").click(function(){
		$(".drop_down_box").css("display",'none');
	})
	$(function(){
		$(".span_lang").hover(function(){	
		$(this).find('.sun').css('display','block');
	},function(){
		$('.span_lang').find('.sun').css('display','none');		
	})	
	$('.sun_aa').click(function(){			
		location=location;
	})		
	var aimgget=window.sessionStorage.getItem('lang');	
	var langget=window.sessionStorage.getItem('langt');	
	if(langget==null){
		$('.langa').text('Spanish');
	}
	else if(langget=='cn'){
		$('.langa').text('中文');
	}
	else if(langget=='en'){
		$('.langa').text('English');
	}	
	else if(langget=='es'){
		$('.langa').text('Spanish');
	}

	if(aimgget==null){	
		$('.lang img').attr('src','/images/header/xibanya.png');
	}else{
		$('.lang img').attr('src',aimgget);
	}
	
	$('.sun').find('a:last').css('padding-bottom','10px');
	$('.ieidk').click(function(){
		var val=$(this).attr('data'); 	
 		window.sessionStorage.setItem('vals',val);
	})
	})
	