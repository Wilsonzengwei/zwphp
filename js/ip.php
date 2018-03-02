

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<script src="jquery-2.1.0.js"></script>
<script type="text/javascript" src="http://pv.sohu.com/cityjson?ie=utf-8"></script>  
<script type="text/javascript">  
$(function(){
	var ip=returnCitySN.cip;
    $.ajax({
    	type:"get",
    	url:"ipget.php",
    	data:{
    		ip:ip
    	},
    	success:function(data){
    		alert(data);
    	},
    	error:function(){
    		alert("错误");
    	}

    })
})
    

</script>
</body>
</html>