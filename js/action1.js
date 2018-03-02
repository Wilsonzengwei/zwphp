$(function(){
		var timer="";
		var index=-1;
		var a="";		
		var center_img=document.getElementById("center-img");
		var Img=center_img.getElementsByTagName("img");
		var center_li=document.getElementById("center-li");
		var Li=center_li.getElementsByTagName("li");
		var center_img_sm1=document.getElementById("center-img-sm1");
		var ImgSm1=center_img_sm1.getElementsByTagName("img");
		var center_img_sm2=document.getElementById("center-img-sm2");
		var ImgSm2=center_img_sm2.getElementsByTagName("img");
		var yxx=document.getElementById("yxx");
		var yxx1=yxx.getElementsByTagName("div");
		var yxx1L=yxx1.length;		
		var imgL=Img.length;
		var liL=Li.length;
		Li[liL-1].style.background="#fff";
		for(var i=0;i<Li.length;i++){
			Li[i].index=i;
			Li[i].onmouseover=Li[i].onclick=function(){
				clearInterval(timer);
				for(var j=0;j<liL;j++){
					Li[j].style.background="#999";
					Li[j].style.transition="background 3s";
					Img[j].style.opacity="0";
					Img[j].style.transition="opacity 3s";
					ImgSm1[j].style.opacity="0";
					ImgSm2[j].style.opacity="0";
					ImgSm1[j].style.transition="opacity 3s";
					ImgSm2[j].style.transition="opacity 3s";
					yxx1[j].style.opacity="0";
					yxx1[j].style.transition="opacity 3s";
				}
				Li[this.index].style.background="#fff";
				Li[this.index].style.transition="background 3s";
				Img[this.index].style.opacity="1";
				Img[this.index].style.transition="opacity 3s";
				ImgSm1[this.index].style.opacity="1";
				ImgSm2[this.index].style.opacity="1";
				ImgSm1[this.index].style.transition="opacity 3s";
				ImgSm2[this.index].style.transition="opacity 3s";
				yxx1[this.index].style.opacity="1";
				yxx1[this.index].style.transition="opacity 3s";
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
			for(var j=0;j<imgL;j++){
				Img[j].style.opacity="0";
				Img[j].style.transition="opacity 3s";
				Li[j].style.background="#999";
				ImgSm1[j].style.opacity="0";
				ImgSm2[j].style.opacity="0";
				ImgSm1[j].style.transition="opacity 3s";
				ImgSm2[j].style.transition="opacity 3s";
				yxx1[j].style.opacity="0";
				yxx1[j].style.transition="opacity 3s";
			}
			Img[index].style.opacity="1";
			Img[index].style.transition="opacity 3s";
			ImgSm1[index].style.opacity="1";
			ImgSm2[index].style.opacity="1";
			ImgSm1[index].style.transition="opacity 3s";
			ImgSm2[index].style.transition="opacity 3s";
			yxx1[index].style.opacity="1";
			yxx1[index].style.transition="opacity 3s";
			Li[index].style.background="#fff";					
		}
		timer=setInterval(next,6000);
	})