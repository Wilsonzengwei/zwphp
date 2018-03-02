
	$(function(){

		$('.y').each(function(){
			var bg=$(this).attr('bg');
			var bga=$(this).attr('bga');
			$(this).find('.i1').css('background','url('+bg+') no-repeat center center');
			$(this).find('.s2').css('background','url('+bga+') no-repeat center center');
		})
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
				$(this).find('.y1').css('background','#fff');
				$(this).attr('datad','2');
				$(this).find('.i1').css('background','url('+curbg+') no-repeat center center');
				$(this).find('.s2').css('background','url('+curbga+') no-repeat center center');
			}else if($(this).attr('datad')==2){
				$(this).find('.s1').css('color','#333');
				$(this).css('background','#fff');				
				$(this).find('.y1').css('display','none');
				$(this).find('.y1').css('background','#fff');
				$(this).attr('datad','1');
				$(this).find('.i1').css('background','url('+bg+') no-repeat center center');
				$(this).find('.s2').css('background','url('+bga+') no-repeat center center');
			}						
		})		
		var valget=window.sessionStorage.getItem('vals');		
			$('.x1').each(function(){
				var datag=$(this).attr('data');				
				if(datag==valget){
					var bg=$(this).parents('.y').attr('bg');
					var bga=$(this).parents('.y').attr('bga');
					var curbg=$(this).parents('.y').attr('curbg');	
					var curbga=$(this).parents('.y').attr('curbga');	
					$('.title1').text(''+$(this).parents('.y').find('.s1').text()+'');
					$('.title2').text('-');
					$('.title3').text(''+$(this).text()+'');
					$(this).css('color','#2962ff');
					$(this).parents('.y1').css('display','block');	
					$(this).parents('.y').css('background','#5f8aff');
					$(this).parents('.y').find('.i1').css('background','url('+curbg+') no-repeat center center');	
					$(this).parents('.y').find('.s1').css('color','#fff');
					$(this).parents('.y').find('.s2').css('background','url('+curbga+') no-repeat center center');
					$(this).parents('.y').attr('datad','2');				
				}
			})
	
		$(".x1").click(function(event){
				// url=location.search;
				// url=='?data=''';
				$('.title2').text('-');
				$('.title3').text(''+$(this).text()+'');
				$('.y1').find('.x').css('color','#333');
				$(this).css('color','#2962ff');
 				event.stopPropagation();
 				var val=$(this).attr('data'); 	
 				window.sessionStorage.setItem('vals',val);
 				// $.get('/ajax/ajax_help.php',{'act':'help','key':val},function(data){
 				// 	$('.yhh').html(data);
 				// })
 			})
		$('.y1').each(function(){
			$(this).find('.x1:first').css('padding-top','10px');
			$(this).find('.x1:last').css('padding-bottom','10px');
		})
	})
