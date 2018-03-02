var canvas_ary= new Array();
var cxt_ary=new Array();
for(j=1;j<7;j++){
canvas_ary[j] = document.getElementById('clock'+j);
cxt_ary[j]= canvas_ary[j].getContext("2d");
drawClock(j);
setInterval("drawClock("+j+")", 1000);
}

/*canvas_ary[2] = document.getElementById('clock'+2);
cxt_ary[2]= canvas_ary[2].getContext("2d");
canvas_ary[3] = document.getElementById('clock'+3);
cxt_ary[3]= canvas_ary[3].getContext("2d");
drawClock(1);
drawClock(2);
drawClock(3);
setInterval("drawClock(1)", 1000);
setInterval("drawClock(2)", 1000);
setInterval("drawClock(3)", 1000);*/
//console.info(cxt_ary);
function drawClock(num) {
	
var now = new Date();
var clocktime=canvas_ary[num].getAttribute('data').split(',');
var sec = now.getSeconds();
/*var min = now.getMinutes();
var hour = now.getHours();*/
//var sec = parseInt(clocktime[2])+1;
var min =  parseInt(clocktime[1]);
var hour =  parseInt(clocktime[0]);
hour > 12 ? hour - 12 : hour;
hour += (min / 60);
//先清空画布
cxt_ary[num].clearRect(0, 0, canvas_ary[num].width, canvas_ary[num].height);


//美女图片作为表盘背景    
// var img = new Image();
//img.src = "tw.png";
//cxt_ary[num].drawImage(img, 46, 46);
//img.onload = function () {
//    cxt_ary[num].drawImage(img, 0, 0);
//}


//画表盘大圆 圆心：x=250 y=250
cxt_ary[num].strokeStyle = "#8d8d8d";
cxt_ary[num].lineWidth = 3;
cxt_ary[num].beginPath();
cxt_ary[num].arc(30, 30, 28, 0, 360);
cxt_ary[num].stroke();
cxt_ary[num].closePath();

//时刻度
for (var i = 0; i < 12; i++) {
	cxt_ary[num].save();//保存当前状态
	cxt_ary[num].lineWidth = 1;
	cxt_ary[num].strokeStyle = "#7b7b7b";

	//设置原点
	cxt_ary[num].translate(30, 30);
	//设置旋转角度
	cxt_ary[num].rotate(30 * i * Math.PI / 180);//弧度   角度*Math.PI/180
	cxt_ary[num].beginPath();
	cxt_ary[num].moveTo(0, -28);
	cxt_ary[num].lineTo(0, -23);
	cxt_ary[num].stroke();
	cxt_ary[num].closePath();
	cxt_ary[num].restore();//把原来状态恢复回来
}

//分刻度
for (var i = 0; i < 60; i++) {
	cxt_ary[num].save();
	cxt_ary[num].lineWidth = 0.5;
	cxt_ary[num].strokeStyle = "#7b7b7b";
	cxt_ary[num].translate(30, 30);
	cxt_ary[num].rotate(i * 6 * Math.PI / 180);
	cxt_ary[num].beginPath();
	cxt_ary[num].moveTo(0, -28);
	cxt_ary[num].lineTo(0, -25);
	cxt_ary[num].stroke();
	cxt_ary[num].closePath();
	cxt_ary[num].restore();
}



//以下的时针、分针、秒针均要转动，所以在这里要设置其异次元空间的位置
//根据当前的小时数、分钟数、秒数分别设置各个针的角度即可
//-----------------------------时针-----------------------------
cxt_ary[num].save();
cxt_ary[num].lineWidth = 2;
cxt_ary[num].strokeStyle = "#ccc";
cxt_ary[num].translate(30, 30);
cxt_ary[num].rotate(hour * 30 * Math.PI / 180);//每小时旋转30度
cxt_ary[num].beginPath();
cxt_ary[num].moveTo(0, -20);
cxt_ary[num].lineTo(0, 10);
cxt_ary[num].stroke();
cxt_ary[num].closePath();
cxt_ary[num].restore();

//-----------------------------分针-----------------------------
cxt_ary[num].save();
cxt_ary[num].lineWidth = 1;
cxt_ary[num].strokeStyle = "#ccc";
cxt_ary[num].translate(30, 30);
cxt_ary[num].rotate(min * 6 * Math.PI / 180);//每分钟旋转6度
cxt_ary[num].beginPath();
cxt_ary[num].moveTo(0, -22);
cxt_ary[num].lineTo(0, 10);
cxt_ary[num].stroke();
cxt_ary[num].closePath();
cxt_ary[num].restore();

//-----------------------------秒针-----------------------------
cxt_ary[num].save();
cxt_ary[num].lineWidth = 1;
cxt_ary[num].strokeStyle = "#a62977";
cxt_ary[num].translate(30, 30);
cxt_ary[num].rotate(sec * 6 * Math.PI / 180);//每秒旋转6度
cxt_ary[num].beginPath();
cxt_ary[num].moveTo(0, -25);
cxt_ary[num].lineTo(0, 10);
cxt_ary[num].stroke();
cxt_ary[num].closePath();
cxt_ary[num].restore();



//美化表盘，画中间的小圆
cxt_ary[num].beginPath();
cxt_ary[num].arc(30, 30, 2, 0, 360);
cxt_ary[num].fillStyle = "#FFFF00";
cxt_ary[num].fill();
cxt_ary[num].strokeStyle = "#ccc";
cxt_ary[num].stroke();
cxt_ary[num].closePath();

//秒针上的小圆
cxt_ary[num].beginPath();
cxt_ary[num].arc(0, -140, 10, 0, 360);
cxt_ary[num].fillStyle = "#333";
cxt_ary[num].fill();
cxt_ary[num].stroke();
cxt_ary[num].closePath();
cxt_ary[num].restore();
}