<?php
include('../../site_config.php');
include('../../set/ext_var.php');
include('../../fun/mysql.php');
include('../../function.php');

$ProId = (int)$_GET['ProId'];
$products_row=str::str_code($db->get_one('product', "ProId='$ProId'"));

$g_page=(int)$_GET['page'];
$page_count=10;//显示数量

//$review_row=str::str_code(db::get_limit_page('orders o left join orders_products_list p on p.OrderId=o.OrderId', "o.OrderStatus>1 and p.ProId ='{$ProId}'", "o.OrderId,o.OrderTime,o.ShippingCountry, o.ShippingLastName,o.ShippingFirstName,o.OrderStatus,p.LId", 'o.OrderId desc', $g_page, $page_count));
$review_row=str::str_code($db->get_limit('orders o left join orders_product_list p on p.OrderId=o.OrderId', "o.OrderStatus>1 and p.ProId ='{$ProId}' group by o.OrderId", "o.OrderId,o.OrderTime,o.ShippingCountry, o.ShippingLastName,o.ShippingFirstName,o.OrderStatus,p.*", 'o.OrderId desc', $g_page, $page_count));

?>
<script src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
onload=function(){
	parent.jQuery('#lib_product_orderlists').html(jQuery('#lib_product_orderlists').html());
	parent.jQuery('#iframe').attr('src','');
}	
</script>
<div id="lib_product_orderlists">
<table width="100%" class="lpo_list-table">
  <thead>
    <tr>
      <th class="lpo_th1">Buyer</th>
      <th class="lpo_th2" align="left">Transaction Details &nbsp;</th>
      <th class="lpo_th2">Qty</th>
      <th class="lpo_th3">Date</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  	//var_dump($review_row[0]);
  foreach((array)$review_row as $item){
		$product_row=str::str_code($db->get_limit('orders_product_list',"OrderId={$item['OrderId']}"));  
	?>
  <tr>
  <td valign="top" class="lpo_plist"><span class="lpo_name"><?=substr($item['ShippingFirstName'],0,3).'***'.substr($item['ShippingLastName'],0,3)?></span><span class="lpo_state"><?=$item['ShippingCountry']?></span></td>
  <td colspan="2">
      <table width="100%" style="border-collapse:collapse;">
       <?php foreach((array)$product_row as $val){
             ?>
      <tr>
          <td valign="middle">
             <span class="lpo_prolist"></span>
             </td>
         <td>&nbsp;&nbsp;Qty:<?=$val['Qty']?$val['Qty']:'1'?> Piece(s)</td>
      </tr>
      <?php }?>
      </table>
  </td>
  <td valign="middle"><?=date('d/m-Y',$item['OrderTime'])?></td>
  </tr> 
  <?php }?>   
<?php /*?>  <tr>
      <td height="30" colspan="3"><div id="turn_page"><?= str_replace('<a','<a target="lib_product_orderlists_frame"',turn_page_html($review_row[1], $g_page, $review_row[3],'/inc/lib/products/orderlists.php?ProId='.$ProId,'Previous', 'Next','3',$link_ext_str='.html', $html=2));?></div></td>
    </tr><?php */?>
  </tbody>
</table>
</div>