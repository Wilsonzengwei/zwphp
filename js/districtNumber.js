

	$(function(){
    $("#districtNumber").click(function(){
      $(this).val("");
    })
    $("#mobile").click(function(){
      $(this).val("");
    })
    
    
    var a=0;
    var timer="";
      $("#btn").click(function(){
          var districtNumber=$("#districtNumber").val();
          var mobile=$("#mobile").val();
          var c=Math.floor(Math.random()*10000000).toString(16);
          if(c.length<6){
            return c+"[0-9]" || c+"[a-z]" || c+"[A-Z]";
          }
          $(this).attr("disabled","true");      
        timer=setInterval(function(){
          for(var i=0;i<1;i++){
            a++;
            $("#btn").val("请"+a+"s后重新获取");
          if(a==60){
            a=0;
            clearInterval(timer);
            $('#btn').removeAttr('disabled')
            $("#btn").val("获取验证码");           	
            }          
          } 
        },1000)   
      
      $.ajax({
          type:"POST",
          url:"regajax.php",
          data:{
              districtNumber:districtNumber,              
              mobile:mobile,
              identifyingcode:c,
              content:"Your "+c+"。",
          },             
          success:function(data){          	
              console.log(data);
          },
          error:function(data){
              console.log("调用失败");
          }
      })
      window.localStorage.setItem("验证码",c);
      })  
   })
