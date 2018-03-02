<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src='/js/jquery-2.1.0.js'></script>
</head>	

<body>	
<div class="a" style="width:200px;height:32px;line-height:16px;overflow:hidden;font-size:12px;">pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女pU女</div>
<div class="b" style="width:200px;height:32px;line-height:16px;overflow:hidden;font-size:12px;">Nueva cremallera Japón y Corea del Sur versión de la ola de personalizada señoras bolsa de mano bill</div>
</body>
</html>
<script>
	$(function(){
		var a=$('.a').text();
		var al=	a.length;
		var a=a.substring(0,33) + "...";
		console.log(a);	
		if(al>35){
			$('.a').text(a) ;
		}else{
			$('.a').text(1) ;
		}
		
		var b=$('.b').text();
		var bl=	b.length;
		console.log(bl);
		var b=b.substring(0,64) + "...";
		console.log(b);	
		if(bl>66){
			$('.b').text(b) ;
		}else{
			$('.b').text(1) ;
		}
	})
</script>