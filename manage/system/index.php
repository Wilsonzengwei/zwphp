<?php

    $a1 = '2000';
    $a2 = '3000';
    $a3 = '4000';
    $a4 = '5000';
    $a5 = '6000';
    $a6 = '7000';
    $a7 = '8000';
    $a8 = '9000';
    $a9 = '10000';
    $a10 = '11000';
    $a11 = '12000';
    $a12 = '13000';
?>
<style>
	.bar-legend li span {
        width: 0.5em;
        height: 1em;
        display: inline-block;
        margin-right: 5px;
    }

    .bar-legend {
        list-style: none;
        text-align:right;
    }
    .legend{
    	width:100%;    	
    }   
    .bar-chart{
    	width:50%;
    	height:350px;
    	float:left;
    	padding-top:20px;
    }
    .bar-chart canvas{
    	width:80%;
    	height:300px;
    }
    .bar-title{
    	color:#333;
    	font-size:16px;
    }
</style>
			<!-- <div style="height:150px;min-width:950px;background:red"></div> -->
 			<div style="min-height:850px;min-width:950px;margin-top:20px;border:1px solid #ccc;text-align:center">
 				<div style="margin-top:10px;text-align:left;padding-left:20px;font-size:14px;color:#3894e1;font-weight:bold">统计信息</div>
	 			<div class="bar-chart">
	                <h5 class="bar-title">产品总数</h5>
	                <canvas id="bar1"></canvas>
	                <div id="legend1"></div>
	            </div>	
	            <div class="bar-chart">
	                <h5 class="bar-title">卖家总数</h5>
	                <canvas id="bar2"></canvas>
	                <div id="legend2"></div>
	            </div>	
	            <div class="bar-chart">
	                <h5 class="bar-title">商家总数</h5>
	                <canvas id="bar3"></canvas>
	                <div id="legend3"></div>
	            </div>	
	            <div class="bar-chart">
	                <h5 class="bar-title">访问总数</h5>
	                <canvas id="bar4"></canvas>
	                <div id="legend4"></div>
	            </div>	
 			</div>
 			<div style="min-height:150px;min-width:950px;margin-top:20px;border:1px solid #ccc;">
 				<div style="margin-top:20px;text-align:left;padding-left:20px;font-size:14px;color:#3894e1;font-weight:bold">系统信息</div>
 				<div style="margin-top:10px;"><span style="display:inline-block;width:100px;text-align:right;font-size:12px;color:#333;padding-right:10px">登录时间:</span><span style="font-size:12px;color:#999" class='hours'></span><span style='margin-left:15px;font-size:12px;color:#999'>[<span style="padding:0 5px;font-size:12px;color:#999" class='ip'>"</span><span style="padding:0 5px;font-size:12px;color:#999" class='ip_address'></span>]</span></div>
 				<div style="margin-top:10px;"><span style="display:inline-block;width:100px;text-align:right;font-size:12px;color:#333;padding-right:10px">数据库:</span><span style="font-size:12px;color:#999">版本 5.5.54-log</span><span style="font-size:12px;color:#999;margin-left:15px">占用内存</span style="font-size:12px;color:#999;margin-left:10px"><span style="font-size:12px;color:#999;margin-left:5px">24.46</span><span style="font-size:12px;color:#999;">MB</span></div>
 				<div style="margin-top:10px;"><span style="display:inline-block;width:100px;text-align:right;font-size:12px;color:#333;padding-right:10px">服务器:</span><span style="font-size:12px;color:#999">信息 nginx/1.12.1</span><span style="font-size:12px;color:#999;margin-left:15px">服务器时间</span><span class="hours" style="font-size:12px;color:#999;margin-left:5px"></span></div>
 			</div>
<script language="javascript" src="../../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://pv.sohu.com/cityjson?ie=utf-8"></script> 
<script src="../../js/Chart.min.js"></script>
<script>

       // 柱状图数据
    var a1 = "<?=$a1;?>";
    var a2 = "<?=$a2;?>";
    var a3 = "<?=$a3;?>";
    var a4 = "<?=$a4;?>";
    var a5 = "<?=$a5;?>";
    var a6 = "<?=$a6;?>";
    var a7 = "<?=$a7;?>";
    var a8 = "<?=$a8;?>";
    var a9 = "<?=$a9;?>";
    var a10 = "<?=$a10;?>";
    var a11 = "<?=$a11;?>";
    var a12 = "<?=$a12;?>";
   	var a=[10, 20, 30, 40, 50, 60, 70,80, 90, 100, 110, 120];
  
   	function y(a,y1,y2,color){
   	var asum=eval(a.join("+"));
   	console.log(asum)

    var chartData = {
        // x轴显示的label
        labels:['1月', '2月', '3月', '4月', '5月', '6月', '7月','8月', '9月', '10月', '11月', '12月'],
        datasets:[
            {               
                fillColor:color,// 填充色              
                data:a, // 数据               
                label:'月销售量' // 图例
            }
        ]
    };
    // 柱状图选项设置
    var configs  = {
        scaleOverlay : true,  // 网格线是否在数据线的上面
        scaleOverride : false, // 是否用硬编码重写y轴网格线
        scaleSteps : null, //y轴刻度的个数
        scaleStepWidth : null, //y轴每个刻度的宽度
        scaleStartValue : null,  //y轴的起始值
        scaleLineColor : "rgba(0,0,0,.1)",// x轴y轴的颜色
        scaleLineWidth : 1,// x轴y轴的线宽  
        scaleShowLabels : true,// 是否显示y轴的标签
        scaleLabel : "<%=value%>",// 标签显示值
        scaleFontFamily : "'Arial'",// 标签的字体
        scaleFontSize : 12,// 标签字体的大小
        scaleFontStyle : "normal",// 标签字体的样式
        scaleFontColor : "#666",// 标签字体的颜色
        scaleShowGridLines : false,// 是否显示网格线
        scaleGridLineColor : "rgba(0,0,0,.05)",    // 网格线的颜色
        scaleGridLineWidth : 0, // 网格线的线宽
        scaleBeginAtZero: false, // y轴标记是否从0开始
        scaleShowHorizontalLines: true, // 是否显示横向线
        scaleShowVerticalLines: true, // 是否显示竖向线
        barShowStroke : true, // 是否显示线
        barStrokeWidth : 0,   // 线宽
        barValueSpacing : 5,// 柱状块与x值所形成的线之间的距离
        barDatasetSpacing : 0,// 在同一x值内的柱状块之间的间距
        animation : true,//是否有动画效果
        animationSteps : 60,//动画的步数
        animationEasing : "easeOutQuart",// 动画的效果
        showTooltips: false, // 是否显示提示
        // 图例
        legendTemplate : '<ul style="text-align:right;padding-right:20px"><span style="color:#999;font-size:12px">总计：'+asum+'</span></ul>',
        // 动画完成后调用的函数(每个柱上显示对应的数据)
        onAnimationComplete: function () {
            var ctx = this.chart.ctx;
            ctx.font = this.scale.font;
            ctx.fillStyle = this.scale.textColor;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';
            this.datasets.forEach(function (dataset){
                dataset.bars.forEach(function (bar) {
                    ctx.fillText(bar.value, bar.x, bar.y);
                });
            });
        }
    };

    // 开始绘制柱状图
    var ctx = document.getElementById(y1).getContext('2d');
    var bar = new Chart(ctx).Bar(chartData, configs);
     var legend = document.getElementById(y2);  
    // 图例
    legend.innerHTML = bar.generateLegend();   
   	}
   	y(a,'bar1','legend1','#8cf5b8');
   	y(a,'bar2','legend2','#8ccaf5');
   	y(a,'bar3','legend3','#f5d18c');
   	y(a,'bar4','legend4','#cf8cf5');

   
   	function getNowFormatDate() {  
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";    
    var strDate = date.getDate();
    var year = date.getFullYear();
    var month = date.getMonth() + 1;    
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 1 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    if(year >= 0 && year <= 9) {
        year = "0" + year;
    }if (hours >= 0 && hours <= 9) {
        hours = "0" + hours;
    }if (minutes >= 0 && minutes <= 9) {
        minutes = "0" + minutes;
    }if (seconds >= 0 && seconds <= 9) {
        seconds = "0" + seconds;
    }
    var currentdate = year + seperator1 + month + seperator1 + strDate
            + " " + hours + seperator2 + minutes
            + seperator2 + seconds;
    $('.hours').html(currentdate);
}
	getNowFormatDate();
	var ip=returnCitySN.cip;
	$('.ip').html(ip);
	$(function(){
		var ip=$('.ip').html();
		$.get('../../ajax/getip.php',{'getip':ip},function(data){
				data=data.split(",")		
                var data3=data[3].length;				
				$('.ip_address').html(data[3].substring(21,data3-1));
			});
	})	
</script>
