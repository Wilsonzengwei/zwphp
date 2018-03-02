$(function(){
	$('.ac').blur(function(){
			$('.ac').each(function(){
				var ac=$(this).val();	
				if(ac==''){					
					$(this).css('border','1px solid red');				
					window.sessionStorage.setItem('none','1');	
					return false;							
				}else{				
					$(this).css('border','1px solid #ccc');
					window.sessionStorage.setItem('none','3');						
				}
			})
		})
		window.sessionStorage.setItem('none','1');
		$('.psa').click(function(){			
			var noneget=window.sessionStorage.getItem('none');
			$('.ac').each(function(){
				var ac=$(this).val();	
				if(ac==''){					
					$(this).css('border','1px solid red');
					$(this).focus();
					window.sessionStorage.setItem('none','1');	
					return false;							
				}else{				
					$(this).css('border','1px solid #ccc');					
					window.sessionStorage.setItem('none','3');						
				}
			})			
			if(noneget=='1'){
				return false;
			}
		})
		$('.psa').hover(function(){
			var noneget=window.sessionStorage.getItem('none');
			$('.ac').each(function(){
				var ac=$(this).val();	
				if(ac==''){							
					window.sessionStorage.setItem('none','1');	
					return false;							
				}else{				
					$(this).css('border','1px solid #ccc');					
					window.sessionStorage.setItem('none','3');						
				}
			})	
			if(noneget=='1'){
				return false;
			}
		})	
})