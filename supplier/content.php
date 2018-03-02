<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<script src="../js/jquery-2.1.0.js"></script>
<script>  
   $(function(){
      $("#btn").click(function(){
          var c=Math.floor(Math.random()*10000000).toString(16);
          if(c.length<6){
            return c+0;
          }
      $.ajax({
          type:"POST",
          url:"a.php", 
          data:{  
              apikey:"5452e1cbdc253a2c4e3577e00537c13e",
              mobile:"18779790466",
              identifyingcode:c,
              content:"您的验证码是"+c+"，在120分钟内有效。如非本人操作请忽略本短信。",
          },             
          success:function(data){
              console.log(data);
          },
          error:function(data){
            console.log("调用失败");
          }
      })
      })      
     
   })

</script>   

<body>
<input id="btn" type="button" value="点击">
</body>
</html>