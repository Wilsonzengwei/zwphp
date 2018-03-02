
	$(function(){

		$('.y').each(function(){
			var bg=$(this).attr('bg');
			var bga=$(this).attr('bga');
			$(this).find('.i1').css('background','url('+bg+') no-repeat center center');
			$(this).find('.s2').css('background','url('+bga+') no-repeat center center');
		})
		$('.hh').each(function(){
			var bg=$(this).attr('bg');
			var bga=$(this).attr('bga');
			$(this).find('.i1').css('background','url('+bg+') no-repeat center center');
			$(this).find('.s2').css('background','url('+bga+') no-repeat center center');
		})
		function ba(id){
			$(id).each(function(){
				var bg=$(this).attr('bg');
				var bga=$(this).attr('bga');
				var curbg=$(this).attr('curbg');				
				var curbga=$(this).attr('curbga');
				$(this).find('.s1').css('color','#fff');
				$(this).css('background','#5f8aff');				
				$(this).find('.y1').css('display','block');
				$(this).attr('datad','2');
				$(this).find('.i1').css('background','url('+curbg+') no-repeat center center');
				$(this).find('.s2').css('background','url('+curbga+') no-repeat center center');				
			})
		}
		function bb(id){
			$(id).each(function(){
				var bg=$(this).attr('bg');
				var bga=$(this).attr('bga');
				var curbg=$(this).attr('curbg');				
				var curbga=$(this).attr('curbga');
				$(this).find('.s1').css('color','#333');
				$(this).css('background','#fff');				
				$(this).find('.y1').css('display','none');
				$(this).attr('datad','1');
				$(this).find('.i1').css('background','url('+bg+') no-repeat center center');
				$(this).find('.s2').css('background','url('+bga+') no-repeat center center');				
			})
		}
		ba('.ccc2');
		var url=location.search;			
		function a(){
			console.log(1);
		}
		if(url=='?data=yhxy1'){
			$('.title1').text('用户协议');
			$('.title2').text('-');
			$('.title3').text('普通客户协议');
			$('.c2').css('display','block');
			$('.c1').css('display','none');
			ba('.ccc2');
			bb('.ccc1');
			$('.x').each(function(){
				if($(this).attr('data')=='xy0'){
					$('.y1').find('.x').css('color','#333');
					$(this).css('color','#2962ff');
				}
			})
			var val=15;
			$.get('/ajax/ajax_help.php',{'act':'help','key':val},function(data){
 					$('.yhh').html(data);
 				})
		}else if(url=='?data=yhxy2'){
			$('.title1').text('用户协议');
			$('.title2').text('-');
			$('.title3').text('普通商家协议');
			$('.c1').css('display','none');
			$('.c2').css('display','block');			
			ba('.ccc2');
			bb('.ccc1');
			$('.x').each(function(){
				if($(this).attr('data')=='xy1'){
					$('.y1').find('.x').css('color','#333');
					$(this).css('color','#2962ff');
				}
			})
			var val=16;
			$.get('/ajax/ajax_help.php',{'act':'help','key':val},function(data){
 					$('.yhh').html(data);
 				})
		}else if(url=='?data=yhxy3'){
			$('.title1').text('用户协议');
			$('.title2').text('-');
			$('.title3').text('eaglehome协议');
			$('.c2').css('display','block');
			$('.c1').css('display','none');
			ba('.ccc2');
			bb('.ccc1');
			$('.x').each(function(){
				if($(this).attr('data')=='xy2'){
					$('.y1').find('.x').css('color','#333');
					$(this).css('color','#2962ff');
				}
			})
			var val=17;
			$.get('/ajax/ajax_help.php',{'act':'help','key':val},function(data){
 					$('.yhh').html(data);
 				})
		}
		else if(url=='?data=xs1'){
			$('.title1').text('新手指南');
			$('.title2').text('-');
			$('.title3').text('客户注册流程');
			$('.c1').css('display','block');
			$('.c2').css('display','none');
			ba('.ccc1');
			bb('.ccc2');
			$('.x').each(function(){
				if($(this).attr('data')=='zn0'){
					$('.y1').find('.x').css('color','#333');
					$(this).css('color','#2962ff');
				}
			})
			var val=18;
			$.get('/ajax/ajax_help.php',{'act':'help','key':val},function(data){
 					$('.yhh').html(data);
 				})
		}		
		$('.y').click(function(){		
			$('.title1').text(''+$(this).find('.s1').text()+'');
			$('.title2').text('');
			$('.title3').text('');
			var bg=$(this).attr('bg');
			var bga=$(this).attr('bga');
			var curbg=$(this).attr('curbg');	
			var curbga=$(this).attr('curbga');				
			if($(this).attr('datad')==1){
				$(this).find('.s1').css('color','#fff');
				$(this).css('background','#5f8aff');				
				$(this).find('.y1').css('display','block');
				$(this).attr('datad','2');
				$(this).find('.i1').css('background','url('+curbg+') no-repeat center center');
				$(this).find('.s2').css('background','url('+curbga+') no-repeat center center');
			}else if($(this).attr('datad')==2){
				$(this).find('.s1').css('color','#333');
				$(this).css('background','#fff');				
				$(this).find('.y1').css('display','none');
				$(this).attr('datad','1');
				$(this).find('.i1').css('background','url('+bg+') no-repeat center center');
				$(this).find('.s2').css('background','url('+bga+') no-repeat center center');
			}						
		})		
		$(".x").click(function(event){
				// url=location.search;
				// url=='?data=''';
				$('.title2').text('-');
				$('.title3').text(''+$(this).text()+'');
				$('.y1').find('.x').css('color','#333');
				$(this).css('color','#2962ff');
 				event.stopPropagation();
 				var val=$(this).attr('datac'); 				
 				$.get('/ajax/ajax_help.php',{'act':'help','key':val},function(data){
 					$('.yhh').html(data);
 				})
 			})
	})
