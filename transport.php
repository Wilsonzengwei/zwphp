<?php
include("inc/include.php");
if($_GET['act'] =='select'){
    $TId = $_GET['TOId'];
    $transport_row = $db->get_one("transport","TOId='$TId'");
    if($transport_row){
        $logistics_row = $db->get_all("logistics","TId=".$transport_row['TId'],'*','LogisticsTime asc');
    }else{
        $logistics_row = '';
    }

    
}

include('inc/common/header.php');
?>
<?php
    echo '<link rel="stylesheet" href="/css/tuoyun'.$lang.'.css">'
?>

<div class="mask">
	<div class="index_box">
	<div class="index_logo1"></div>
    <div style='float:left;height:90px;line-height:90px;margin-left:20px;font-size:24px;font-weight:bold;margin-right:30px'><?=$website_language['transport'.$lang]['tyzx']?></div>
	<div class="index_search">
	<form action="" method="get">
		<input class="search_input" placeholder='<?=$website_language['transport'.$lang]['srddh']?>' name="TOId" style="" type="text">	
		<input class="search_submit" type="submit"  value="">
		<input type="hidden" name="act" value="select">
	</form>		
	</div>		
</div>
</div>

<div class="mask3">
	<div class="content_right">          
          
            <div class="titleState">
            	<div>
            		<span  class="titleInfo"><?=$website_language['transport'.$lang]['ydhm']?>：</span><span class='title_content'><strong><?=$transport_row['TOId']?></strong></span>
            	</div>
                <div>
                	<span class="titleCompany"><?=$website_language['transport'.$lang]['wlgs']?>：</span><span class='title_content'><strong><?=$transport_row['Company']?></strong></span>
                </div>
                <div>
                	<span class="titlePhone"><?=$website_language['transport'.$lang]['kfdh']?>：</span><span class='title_content'><strong>0755-33119835</strong></span>
                </div>
                
            </div>
            <hr style="width:1200px">
            <span id="time-state"><?=$website_language['transport'.$lang]['rq']?></span>    
            <span id="time-tubiao">&nbsp;</span> 
            <span id="content-state"><?=$website_language['transport'.$lang]['zzjd']?></span>
            <div style="min-height:275px;">   
            <table  class="table-state">    
            <?php 
                if($_GET['act'] =='select'){
                    if($logistics_row){                    
                        for ($i=0; $i < count($logistics_row); $i++) { 
                

                ?>     

                            
                            <tr class="tr">      
                                <td class="timeInfo">
                                <?=date('Y-m-d H:i:s',$logistics_row[$i]['LogisticsTime']);?>
                                </td>   
                                <td class="tubiao_content"></td>                  
                                <td class="LocationAndTrackingProgress"><?=$logistics_row[$i]['LogisticsInfo']?></td>
                            </tr>
            <?php
                        }
                    }else{
            ?>
                        <div class="acha">
                            <div class="acha1"><img src="/images/tuoyun/gantan.png" alt=""><span class="acha1_span"><?=$website_language['transport'.$lang]['bq']?></span></div>
                            <div class="acha2">
                                <div class="acha3">
                                    <img class="acha3_img" src="/images/tuoyun/cha.png" alt="">
                                    <div class="acha3_1"><?=$website_language['transport'.$lang]['dhcw']?></div>
                                    <div class="acha3_2"><?=$website_language['transport'.$lang]['sfzq']?></div>
                                </div>
                                <div class="acha4">
                                    <img class="acha3_img" src="/images/tuoyun/gou.png" alt="">
                                    <div class="acha3_1"><?=$website_language['transport'.$lang]['qrww']?></div>
                                    <div class="acha3_2"><?=$website_language['transport'.$lang]['shzs']?> </div>
                                </div>
                            </div>
                        </div>
            
                <?php }?>
            <?php }?>
            </table>
            </div>
        </div>
</div>

<script>
$(function(){
    $('.LocationAndTrackingProgress').each(function(){      
        var a=$(this).css('height');
        if(a>'26px'){
            $(this).css('text-align','left');
        }else{
            $(this).css('text-align','left');
        }
    })
    $('.index_logo1').css('cursor','pointer');
    $('.index_logo1').click(function(){
        window.location.href='/index.php';
    })
      $(".table-state tr:eq(0)").siblings("tr").each(function(){
           $(this).children("td:eq(1)").each(function(){
               $(this).css("background","url(images/atricle/gfd03.png) no-repeat center left");
           })
        })
        $(".table-state tr:last td:eq(1)").each(function(){
            $(this).css("background","url(images/atricle/gfd04.png) no-repeat center left");
        })   
        $(".table-state tr:last td:eq(1)").siblings("td").each(function(){
            $(this).css("color","#ec6400");
        })

    $("#txt").click(function(){
        $(this).val("");
    })
})
    

</script>

</script>
