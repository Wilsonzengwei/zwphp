<script language="javascript">mouse_trBgcolor();</script>
<script type="text/javascript">
	//其他属性点击
	function checkproperty(obj){
		if(jQuery(obj).hasClass('cur')){
			jQuery(obj).removeClass('cur').next().val('0');
		}else{
			jQuery(obj).addClass('cur').next().val('1');	
		}
		jQuery(obj).blur();
	}
	//日期选择
	$('.SelectDate,#SelectDate,#SelectDateS,#SelectDateE,#RegTimeS,#RegTimeE,#LastLoginTimeS,#LastLoginTimeE,#OrderTimeS,#OrderTimeE').daterangepicker({
		autoUpdateInput: false,
		singleDatePicker: true,
		timePicker: true
		//startDate: moment().subtract(1, 'days')
	}).on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
	}).on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:00'));
	});
	//$('#SelectDate,#SelectDateS,#SelectDateE,#RegTimeS,#RegTimeE,#LastLoginTimeS,#LastLoginTimeE,#OrderTimeS,#OrderTimeE').val('');
	
	//开关按钮
	$('.switchery').on('click', function(){
		if($(this).hasClass('checked')){
			$(this).removeClass('checked').find('input').attr('checked', false);
			//cancelBind && cancelBind($(this));
		}else{
			$(this).addClass('checked').find('input').attr('checked', true);
			//confirmBind && confirmBind($(this));
		}
	});
</script>
</body>
</html>