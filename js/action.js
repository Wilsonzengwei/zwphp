$(function(){
		var timer="";		
		var a="";		
		var prevc=document.getElementById('center_prev');
		var nextc=document.getElementById('center_next');
		var center_img=document.getElementById("center-img");
		var Imga=center_img.getElementsByTagName("a");
		var imgaL=Imga.length;
		var Img=center_img.getElementsByTagName("img");
		var center_li=document.getElementById("center-li");
		var Li=center_li.getElementsByTagName("li");		
		var imgL=Img.length;
		var index=imgL-1;
		var liL=Li.length;		
		Li[liL-1].style.background="#fff";
		for(var i=0;i<Li.length;i++){
			Li[i].index=i;
			Li[i].onmouseover=Li[i].onclick=function(){
				clearInterval(timer);
				for(var j=0;j<imgaL;j++){
					Li[j].style.background="#999";
					Li[j].style.transition="background 3s";
					Img[j].style.opacity="0";
					Img[j].style.transition="opacity 3s";					
					Imga[j].style.opacity='0';
					Imga[j].style.zIndex='17';
					Imga[j].style.transition='opacity 3s';
				}
				Li[this.index].style.background="#fff";
				Li[this.index].style.transition="background 3s";
				Img[this.index].style.opacity="1";
				Img[this.index].style.transition="opacity 3s";		
				Imga[this.index].style.opacity='1';		
				Imga[this.index].style.transition='opacity 3s';
				Imga[this.index].style.zIndex='18';
				index=this.index;
			}
			Li[i].onmouseout=function(){
				timer=setInterval(next,6000);
			}
		}
		function next(){
			index++;
			if(index==imgL){
				index=0;
			}			
			for(var j=0;j<imgaL;j++){
				Img[j].style.opacity="0";
				Img[j].style.transition="opacity 3s";
				Imga[j].style.opacity='0';
				Imga[j].style.transition='opacity 3s';
				Imga[j].style.zIndex='17';
				Li[j].style.background="#999";				
			}
			Img[index].style.opacity="1";
			Img[index].style.transition="opacity 3s";		
			Imga[index].style.opacity='1';	
			Imga[index].style.transition='opacity 3s';
			Imga[index].style.zIndex='18';	
			Li[index].style.background="#fff";					
		}
		function prev(){
			index--;
			if(index<=-1){
				index=imgL-1;
			}			
			for(var j=0;j<imgaL;j++){
				Img[j].style.opacity="0";
				Img[j].style.transition="opacity 3s";
				Imga[j].style.opacity='0';
				Imga[j].style.transition='opacity 3s';
				Imga[j].style.zIndex='17';
				Li[j].style.background="#999";				
			}
			Img[index].style.opacity="1";
			Img[index].style.transition="opacity 3s";	
			Imga[index].style.opacity='1';		
			Imga[index].style.transition='opacity 3s';
			Imga[index].style.zIndex='18';	
			Li[index].style.background="#fff";					
		}
		nextc.onmouseover=function(){
			clearInterval(timer);
		}
		nextc.onmouseout=function(){
			timer=setInterval(next,6000);
		}
		prevc.onmouseover=function(){
			clearInterval(timer);
		}
		prevc.onmouseout=function(){
			timer=setInterval(prev,6000);
		}
		timer=setInterval(next,6000);
		nextc.onclick=function(){			
			next();
		}
		prevc.onclick=function(){
			prev();
		}
	})