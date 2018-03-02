function alerts(td,td2,hs){
    var alertDiv=document.createElement("div");
    alertDiv.id="alertDiv";    
    alertDiv.style.width="420px";
    alertDiv.style.height="210px";
    alertDiv.style.background="#fff";
    alertDiv.style.zIndex="200";
    alertDiv.style.left="35%";
    alertDiv.style.top="25%";
    alertDiv.style.boxShadow="0px 2px 2px #888888";
    alertDiv.style.border="1px solid #ccc";
    alertDiv.style.position="fixed";
    // alertDiv.style.marginLeft = document.body.clientWidth;
    // alertDiv.style.marginTop =document.body.clientHeight";

    str="<div>";
    str+="<ul style=\"list-style:none;margin:0px;padding:0px;width:100%;font-weight:bold\">";
    str+="<li style=\"line-height:30px;width:100%;height:28px;font-size:12px;background:#f6f6f6;color:#333;border-bottom:1px solid #dbdbdb\">&nbsp;&nbsp;系统提示";
    str+="<span style='display:inline-block;height:10px;width:10px;position:absolute;right:10px;top:10px;cursor:pointer;' onclick='disappear()'><img style='position:absolute;width:12px;height:12px;' src='/images/exit.jpg'></span>";
    str+="</li>";
    str+="<li>";
    str+="<span style=\"display:inline-block;width:17%;height:27px;background:url(/images/Prompt.jpg) no-repeat;margin-top:29px;margin-left:31px\"></span>";
    str+="<span style=\"display:inline-block;background:#fff;position:absolute;top:30%;left:25%;text-align:center;font-size:14px;font-weight:normal\">"+td+"</span>";    
    str+="</li>";
    str+='<div style="width:300px;height:12px;position:absolute;margin-left:105px;margin-top:20px;font-size:12px">'+td2+'</div>';
    str+="<button style='background:#ed5758;width:53px;height:23px;border:1px solid #e14343;border-radius:5px;color:#fff;zIndex:999;position:absolute;left:30%;bottom:10%;cursor:pointer;' onclick='hrefs()'>确定</button>";
    str+="<button style='background:#f5f5f5;width:53px;height:23px;border:1px solid #cccccc;border-radius:5px;color:#000;zIndex:999;position:absolute;right:30%;bottom:10%;cursor:pointer;' onclick='disappear()'>取消</button>";
    str+="</ul>";
    str+="</div>";
    var shield = document.createElement("DIV");
    shield.id = "shield";
    shield.style.position = "fixed";
    shield.style.left = "0px";
    shield.style.top = "0px";
    shield.style.width = "100%";
    shield.style.height = document.body.scrollHeight+"px";
     //弹出对话框时的背景颜色
    shield.style.background = "#000";
    shield.style.textAlign = "center";
    shield.style.zIndex = "100";
    shield.style.opacity = "0.4";
    shield.style.filter="alpha(opacity=40)";
    alertDiv.innerHTML=str;
    document.body.appendChild(shield);
    document.body.appendChild(alertDiv);
    this.disappear=function(){
        shield.style.display="none";
        document.body.removeChild(alertDiv);
        document.body.removeChild(shield);
        alertDiv.style.display="none";
       
        }
    this.hrefs=function(){
        document.location=hs;
    }
    document.body.onselectstart = function(){return false;};
    
} 