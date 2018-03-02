/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
$.toJSON = typeof JSON == "object" && JSON.stringify ? JSON.stringify: function(e) {
	if (e === null) return "null";
	var t, n, r, i, s = $.type(e);
	if (s === "undefined") return undefined;
	if (s === "number" || s === "boolean") return String(e);
	if (s === "string") return $.quoteString(e);
	if (typeof e.toJSON == "function") return $.toJSON(e.toJSON());
	if (s === "date") {
		var o = e.getUTCMonth() + 1,
		u = e.getUTCDate(),
		a = e.getUTCFullYear(),
		f = e.getUTCHours(),
		l = e.getUTCMinutes(),
		c = e.getUTCSeconds(),
		h = e.getUTCMilliseconds();
		o < 10 && (o = "0" + o);
		u < 10 && (u = "0" + u);
		f < 10 && (f = "0" + f);
		l < 10 && (l = "0" + l);
		c < 10 && (c = "0" + c);
		h < 100 && (h = "0" + h);
		h < 10 && (h = "0" + h);
		return '"' + a + "-" + o + "-" + u + "T" + f + ":" + l + ":" + c + "." + h + 'Z"'
	}
	t = [];
	if ($.isArray(e)) {
		for (n = 0; n < e.length; n++) t.push($.toJSON(e[n]) || "null");
		return "[" + t.join(",") + "]"
	}
	if (typeof e == "object") {
		for (n in e) if (hasOwn.call(e, n)) {
			s = typeof n;
			if (s === "number") r = '"' + n + '"';
			else {
				if (s !== "string") continue;
				r = $.quoteString(n)
			}
			s = typeof e[n];
			if (s !== "function" && s !== "undefined") {
				i = $.toJSON(e[n]);
				t.push(r + ":" + i)
			}
		}
		return "{" + t.join(",") + "}"
	}
};
//string => Object
$.evalJSON = typeof JSON == "object" && JSON.parse ? JSON.parse: function(str) {
	return eval("(" + str + ")")
};
$.fn.loading=function(e){
	e=$.extend({opacity:.5,size:"big"},e);
	$(this).each(function(){
		if($(this).hasClass("masked")) return;
		var obj=$(this);
		var l=$('<div class="loading"></div>').css("opacity", 0);
		obj.addClass("masked").append(l);
		var lb=$('<div class="loading_msg loading_big"></div>').appendTo(obj);
		lb.css({
			top: obj.height() / 2 - (lb.height() + parseInt(lb.css("padding-top")) + parseInt(lb.css("padding-bottom"))) / 2,
			left: obj.width() / 2 - (lb.width() + parseInt(lb.css("padding-left")) + parseInt(lb.css("padding-right"))) / 2
		});
	});
	return this;
}
//取消loading加载效果
$.fn.unloading=function(){
	$(this).each(function(){
		$(this).find(".loading_msg, .loading").remove();
		$(this).removeClass("masked");
	});
}

//滚动插件
$.fn.carousel=function(e){
	e=$.extend({itemsPerMove:2,duration:1e3,vertical:!1,specification:"",width:0,height:0,step:1,preCtrEntity:"pre_arrow",nextCtrEntity:"next_arrow"},e);
	var t=this,
		n=t.find(".viewport"),
		r=n.find(".list"),
		i,s,o,u,a,f=!1,
		l={
			init:function(){
				var oFirst=r.children(":first"),
					oLast=r.children(":last"),
					l,c,list_len=r.children().length;
				
				if(e.vertical){	//判断滚动方式
					l=Math.max(oFirst.outerHeight(!0), oLast.outerHeight(!0));
					i=l*e.itemsPerMove;
					c=oFirst.outerHeight(!0)-oFirst.outerHeight();
					t.addClass("vertical").css({height:e.height||i-c, width:e.width||oFirst.outerWidth(!0)});
					r.height(l*list_len);
					if(l*list_len>(e.height || i-c)){
						s={scrollTop:"-="+i};
						o={scrollTop:i};
						u={scrollTop:"-="+i*e.step};
						a={scrollTop:i*e.step};
						this.bind_event();
					}
				}else{
					l=Math.max(oFirst.outerWidth(!0), oLast.outerWidth(!0));
					i=l*e.itemsPerMove;
					c=oFirst.outerWidth(!0)-oFirst.outerWidth();
					t.addClass("horizontal").css({height:e.height||oFirst.outerHeight(!0), width:e.width||i-c});
					r.width(l*list_len);
					if(l*list_len>(e.width || i-c)){
						s={scrollLeft:"-="+i};
						o={scrollLeft:"+="+i};
						u={scrollLeft:"-="+i*e.step};
						a={scrollLeft:i*e.step};
						this.bind_event();
					}
				}
			},
			step_prev:function(t){
				if(f) return;f=!0;
				for(var o=0;o<e.itemsPerMove;o++)r.prepend(r.children(":last"));
				n[e.vertical?"scrollTop":"scrollLeft"](i).stop().animate(s,{
					duration:e.duration,
					complete:function(){
						t-=1;
						f=!1;
						t>0 && l.step_prev(t);
					}
				});
			},
			step_next:function(t){
				if(f) return;
				f=!0;
				n.stop().animate(o, {
					duration:e.duration,
					complete:function(){
						l.repeatRun(function(){
							r.children(":last").after(r.children(":first"))
						}, e.itemsPerMove);
						e.vertical?n.scrollTop(0):n.scrollLeft(0);
						t-=1;
						f=!1;
						t>0 && l.step_next(t);
					}
				})
			},
			moveSlide:function(t){
				t==="next"?this.step_next(e.step):this.step_prev(e.step)
			},
			repeatRun:function(e,t){
				for(var n=0; n<t; n++) e()
			},
			bind_event:function(){
				t.find(".btn").on("click", function(e){
					l.moveSlide($(this).hasClass("prev")?"prev":"next")
				});
			}
		}
	l.init();
}

$.fn.extend({
	//放大镜插件
	magnify:function(t){
		t=$.extend({blankHeadHeight:0,detailWidth:455,detailHeight:455,detailLeft:458,featureImgRect:"460x460",large:"v"},t);
		
		var n=!1,
			win_left=$(window).scrollLeft(),
			win_top=$(window).scrollTop(),
			u=$("img", this).width(),
			a=$("img", this).height(),
			c=$(this).children("a"),
			narmal_pic=$(this).find(".normal"),
			h='<div class="detail_img_box" style="width:'+t.detailWidth+'px;height:'+t.detailHeight+'px;left:'+t.detailLeft+'px;"><img class="detail_img" onerror="$.imgOnError(this)"></div><div class="rect_mask"></div>';
		$(h).appendTo(this);
		
		var d=this.find(".detail_img_box"),
			v=d.find("img"),
			m=this.find(".rect_mask"),
			g=this,
			w=function($){
				d.hide();
				m.hide();
				m.css("top","-9999px");
				d.css("top","-9999px");
				n=!1
			};
		
		$(this).mouseleave(w).mousemove(function(h){
			if(!n){
				if(!c.attr("href")) return;
				var p=c.attr("href");
				v.attr("src", p);
				s=$(this).offset().left;
				o1=$(this).offset().top;
				o2=$(this).parent().parent().offset().top;
				v_top=o1-o2;
				d.css({top:t.blankHeadHeight-v_top});
				n=!0
			}
			d.css({'width':(v.width()<t.detailWidth?v.width():t.detailWidth),'height':(v.height()<t.detailHeight?v.height():t.detailHeight)});
			u=narmal_pic.width();
			a=narmal_pic.height();
			f=u*(t.detailWidth/v.width()>1?1:t.detailWidth/v.width());
			l=a*(t.detailHeight/v.height()>1?1:t.detailHeight/v.height());
			m.css({"width":f,"height":l});
			d.css({left:t.detailLeft-parseInt(d.parent().parent().css("left"))});
			if(h.clientX+win_left>u+s) return $(this).trigger("mouseleave");
			var g=h.clientX+win_left-s,
				w=h.clientY+win_top-o1;
			g<f/2?g=0:g>u-f/2?g=u-f:g-=f/2;
			w<l/2?w=0:w>a-l/2?w=a-l:w-=l/2;
			m.css({left:g, top:w});
			v.css({left:-(t.detailWidth/f)*g, top:-(t.detailHeight/l)*w, "max-width":"inherit", "max-height":"inherit"});
			d.show();
			m.show()
		});
		
		$(window).on("scroll", function(t){
			win_left=$(window).scrollLeft();
			win_top=$(window).scrollTop();
		});
	},
	
	//购买数量增减
	set_amount:function(e){
		e=$.extend({min:1,max:999},e);
		
		var t=this,
			n=t.find(".qty_num");
		t.on("blur", ".qty_num", function(){
			var num=parseInt($(this).val(), 10);
			if(!/^\d+$/.test($(this).val())){
				alert('Quantity entered must be a number!');
				$(this).val(num).focus();
			}
			return $(this).val()==""?( n.val(e.min), !1):isNaN(num)||e.min>num||num>e.max?(n.val(e.min), !1):(n.val(num) ,0);
		}).on("keyup", ".qty_num", function(){
			var num=parseInt($(this).val(), 10);
			if(!/^\d+$/.test($(this).val())){
				alert('Quantity entered must be a number!');
				$(this).val(num).focus();
			}
			return $(this).val()==""?( n.val(e.min), !1):isNaN(num)||e.min>num||num>e.max?(n.val(e.min), !1):(n.val(num) ,0);
		}).on('click','.add,.del',function(){
			if($(this).hasClass('add')){
				var num=parseInt(n.val(), 10)+1;
				return n.val()==""?( n.val(e.min), !1):isNaN(num)||e.min>num||num>e.max?(n.val(e.min), !1):(n.val(num) ,0);
			}else{
				var num=parseInt(n.val(), 10)-1;
				return n.val()==""?( n.val(e.min), !1):isNaN(num)||e.min>num||num>e.max?(n.val(e.min), !1):(n.val(num) ,0);
			}
		});
	},
	
	//总价格整理
	
});

(function($){
	var k=!1,
	a=function(){
		b();
		c();
		h();
		d();
		f();
		//g();
		//m();
		n();
	},
	b=function(){//生成大图
		//var $bigPic=$(".detail_pic"),
		//	$qtyBox=$(".quantity_box");
		//
		////价格显示
		//qty_data=$.evalJSON($qtyBox.attr("data"));
		//set_amount=$qtyBox.set_amount(qty_data);
	},
	c=function(){//大图定位
		var $bigPic=$(".detail_pic"),
			$picShell=$bigPic.find(".pic_shell");
			$bigBox=$picShell.find(".big_box");
		
		pleft=($picShell.width()-$bigBox.width())/2;
		ptop=($picShell.height()-$bigBox.height())/2;
		if($bigBox.height()>$picShell.height()){
			//$bigBox.css({height:$picShell.height()});
			//$bigBox.find(".magnify").css({height:$picShell.height()});
			pleft=($picShell.width()-$bigBox.find('.magnify .big_pic img').width())/2;
			ptop=($picShell.height()-$bigBox.height())/2;
		}
		$bigBox.css({left:pleft, top:ptop});
	},
	h=function(){//大图loading
		$(".detail_left").height(350).loading();
		$.ajax({
			url:"/ajax/goods_detail_pic.php",
			async:false,
			type:'get',
			data:{"ProId":$("#ProId").val(), "ColorId":$("#ColorId").val()},
			dataType:'html',
			success:function(result){
				if(result){
					$(".detail_left").html(result);
				}
			}
		});
		
		$(".detail_left").height("auto").unloading();
		n_data=$.evalJSON($(".detail_pic .magnify").attr("data"));
		if($(window).width()>=1250){
			magnify=$(".magnify").magnify($.extend({detailWidth:453,detailHeight:453,detailLeft:465}, n_data));
		}else{
			magnify=$(".magnify").magnify($.extend({detailWidth:390,detailHeight:390,detailLeft:345}, n_data));
		}
		$(".big_pic img").load(function(){
			c();
		});
		d();
		
		$(window).resize(function(){//网站宽度变动，更新宽度
			if($(window).width()>=1250){
				magnify=$(".magnify").magnify($.extend({detailWidth:453,detailHeight:453,detailLeft:465}, n_data));
			}else{
				magnify=$(".magnify").magnify($.extend({detailWidth:390,detailHeight:390,detailLeft:345}, n_data));
			}
		});
	},
	d=function(){//小图列表
		var $bigPic=$(".detail_pic"),
			$small=$bigPic.find('.small_carousel'),
			r, k;
		
		if($(".detail_left").hasClass("prod_gallery_x")){
			$small.carousel({itemsPerMove:1,height:378,width:74,duration:200,vertical:1,step:1});
		}else{
			$small.carousel({itemsPerMove:1,height:91,width:318,duration:200,vertical:!1,step:1});
		}
		
		$bigPic.on("click",".item a",function(t){
			r=$bigPic.find(".current");
			var i=$(this).parent();
			if(!i.hasClass("current")){
				r.removeClass("current");
				r=i;
				r.addClass("current");
				$bigPic.find(".big_pic").attr("href", $(this).find("img").attr("mask"));
				$bigPic.find(".normal").attr("src", $(this).find("img").attr("normal")).load(function(){
					if(!k) c();
					k=!0;
				});
				k=!1;
			}
			return false;
		});
	},
	f=function(){//产品属性、其他执行事件
		$(".prod_info_pdf").click(function(){//PDF打印
			$("#export_pdf").attr("src", "http://pdfmyurl.com?url="+window.location.href.replace(/^http[s]?:\/\//, ""));	
		});
		$('.attr_show span').click(
			function(){
				$('#attr_'+$(this).attr('data')).val($(this).attr('value'));
				$(this).parent().find('span').removeClass('cur');
				$(this).addClass('cur');
				if($(this).hasClass('colorid')){
					$('#ColorId').val($(this).attr('value'));
					h();
				}
				$.post('/ajax/get_price.php', 'act=get_price&'+$('.prod_info_form').serialize(), function(data){
					if(data){
						$('#cur_price').html(data[0]);
						$('#Save').html(data[1]);
						$('#price_del').html(data[2]);
						if(data[3]){
							$('#Stock').html(data[3]);
							var $qtyBox=$(".quantity_box");
							qty_data=$.evalJSON($qtyBox.attr("data"));
							if(qty_data.max!=data[3]){//更新属性库存
								qty_data.max=data[3];
								$qtyBox.attr("data", $.toJSON(qty_data));
							}
							$('.addtocart').val('Add to Cart');
							$('.addtocart').removeAttr('disable','disable');
							b();
							//console.info((qty_box);
						}else{
							$('#Stock').html('no stock!');
							$('.addtocart').val('No Stock');
							$('.addtocart').attr('disable','disable');
						}
					}
				}, 'json');
			}
		);
		$(window).resize(function(){//网站宽度变动，更新宽度
			$(".group_promotion .gp_title span").each(function(){
				var $obj=$("#gp_list_"+$(this).attr("data"));
				var suits_ulW=$obj.find(".suits li").outerWidth(true)*($obj.find(".suits li").size()+5);
				$obj.find(".suits ul").css({"width":suits_ulW});
			});
		});
	},
	/*m=function(){//组合产品
		$('.group_promotion').delegate('input:checkbox', 'click', function(){
			var $obj=$(this).parents('.promotion_body'),
				$totalPrice=0,
				$totalOld=0
				$num=0;
			
			$obj.find('input:checkbox:checked').each(function(){
				$totalPrice+=parseFloat($(this).attr('curprice'));
				$totalOld+=parseFloat($(this).attr('oldprice'));
				$num+=1;
			});
			$obj.find('.group_nums').text($num-1);
			$obj.find('.group_curprice .price_data').text($totalPrice.toFixed(2));
			$obj.find('.group_totalprice .price_data').text($totalOld.toFixed(2));
		});
		
		$('.group_promotion').delegate('.gp_btn', 'click', function(){
			var $obj=$(this).parents('.promotion_body'),
				$PId=$obj.find('input[name=PId]').val(),
				$ProId='',
				$num=0,
				$data;
			
			var subObj=$("#goods_form"),
				result=0;
			subObj.find("select").each(function(){
				$(this).css("border","1px #ccc solid");
				if(!$(this).val()){
					$(this).css("border","1px red solid");
					result=1;
				}
			});
			if(result){
				$('body,html').animate({scrollTop:subObj.find("select").offset().top}, 500);
				return false;
			}
			
			$obj.find('input:checkbox:checked').each(function(){
				$ProId+=($num?',':'')+parseInt($(this).attr('proid'));
				$num+=1;
			});
			
			$.ajax({
				url:"/",
				async:false,
				type:'post',
				data:{"ProId":$ProId, "PId":$PId, "Attr":$('#attr_hide').val(), "products_type":($PId?4:3), "do_action":"cart.additem"},
				dataType:'html',
				success:function(result){
					if(result){
						window.location='/cart/';
					}
				}
			});
		});
	}*/
	n=function(){
		/**** 运费查询 Start ****/
		$('#shipping_cost_button').click(function(){
			if($(this).attr('disabled')) return false;
			$(this).blur().attr('disabled', 'disabled');
			$.ajax({
				type: "POST",
				url: "/?do_action=cart.get_excheckout_country",
				dataType: "json",
				success: function(data){
					if(data.ret==1){
						var c=data.msg.country;
						var country_select='';
						var defaultCId=226;
						var CId=parseInt($('#CId').val());
						for(i=0; i<c.length; i++){
							if((!CId && c[i].IsDefault==1) || CId==c[i].CId) defaultCId=c[i].CId;
							var s=defaultCId==c[i].CId?'selected':'';
							var f=c[i].FlagPath?' path="'+c[i].FlagPath+'"':'';
							country_select=country_select+'<option value="'+c[i].CId+'" acronym="'+c[i].Acronym+'" '+f+s+'>'+c[i].Country+'</option>';
						}
						
						var ProductPrice=$('form[name=prod_info_form] input[name=ItemPrice]').val();
						var excheckout_html='<div id="shipping_cost_choose">';
							excheckout_html=excheckout_html+'<div class="box_bg"></div><a class="noCtrTrack" id="choose_close">×</a>';
							excheckout_html=excheckout_html+'<div id="choose_content"><form name="shipping_cost_form" target="_blank" method="POST" action="">';
								excheckout_html=excheckout_html+'<label>Select you country: </label>';
								excheckout_html=excheckout_html+'<select name="CId"><option value="0">--Please select your country--</option>'+country_select+'</select>';
								excheckout_html=excheckout_html+'<ul id="shipping_method_list"></ul>';
								excheckout_html=excheckout_html+'<p class="footRegion">';
									excheckout_html=excheckout_html+'<input class="btn btn-success" id="excheckout_button" type="submit" value="OK" />';
								excheckout_html=excheckout_html+'</p>';
							excheckout_html=excheckout_html+'<input type="hidden" name="ProductPrice" value="' + ProductPrice + '" /><input type="hidden" name="ShippingMethodType" value="" /><input type="hidden" name="ShippingPrice" value="0" /><input type="hidden" name="ShippingExpress" value="" /><input type="hidden" name="ShippingBrief" value="" /></form></div>';
						excheckout_html=excheckout_html+'</div>';
						
						$('#shipping_cost_choose').length && $('#shipping_cost_choose').remove();
						$('body').prepend(excheckout_html);
						$('#shipping_cost_choose').css({left:$(window).width()/2-220});
						global_obj.div_mask();
						
						get_shipping_methods(defaultCId);
						
					}else{
						global_obj.win_alert('Please sign in first!', function(){window.top.location='/account/login.html';});
					}
				}
			});
		});
		
		//选择国家操作
		$('body').delegate('form[name=shipping_cost_form] select[name=CId]', 'change', function(){
			get_shipping_methods($(this).val());
		});
		
		//选择快递操作
		$('body').delegate('form[name=shipping_cost_form] input[name=SId]', 'click', function(){
			var price=parseFloat($(this).attr('price'));
			var insurance=parseFloat($(this).attr('insurance'));
			
			$('form[name=shipping_cost_form] input[name=ShippingMethodType]').val($(this).attr('ShippingType'));
			$('#shipping_method_list li.insurance span.price').text(ueeshop_config.currency_symbols + insurance.toFixed(2));
			
			$('form[name=shipping_cost_form] input[name=ShippingExpress]').val($(this).attr('method'));
			$('form[name=shipping_cost_form] input[name=ShippingBrief]').val($(this).attr('brief'));
			$('form[name=shipping_cost_form] input[name=ShippingPrice]').val(price.toFixed(2));
		});
		
		//关闭运费查询
		$('body').delegate('#choose_close, #div_mask, #exback_button', 'click', function(){
			if($('#shipping_cost_choose').length){
				$('#shipping_cost_choose').remove();
				global_obj.div_mask(1);
				$('#shipping_cost_button').removeAttr('disabled');
			}
		});
		
		//提交运费查询
		$('body').delegate('form[name=shipping_cost_form]', 'submit', function(){
			var obj=$('form[name=shipping_cost_form]');
			obj.find('input[type=submit]').attr('disabled', 'disabled').blur();
			if(!obj.find('input[name=SId]:checked').val() && obj.find('input[name=ShippingMethodType]').val()==''){
				alert('Please select a shipping method!');
				$('#excheckout_button').removeAttr('disabled');
				return false;
			}
			
			var shipping_price=$('form[name=shipping_cost_form] input[name=ShippingPrice]').val();
			if(shipping_price>0){
				$('#shipping_cost_price').css('display', '').text(ueeshop_config.currency_symbols+shipping_price);
				$('#shipping_cost_freeshipping').css('display', 'none');
			}else{
				$('#shipping_cost_freeshipping').css('display', '');
				$('#shipping_cost_price').css('display', 'none').text(' ');
			}
			$('#delivery_time_processing').text($('form[name=shipping_cost_form] input[name=ShippingBrief]').val());
			var $selectObj=$('form[name=shipping_cost_form] select[name=CId] option:selected');
			var country_name=$selectObj.text();
			var acronym_name=$selectObj.attr('acronym');
			var flagpath=$selectObj.attr('path');
			var express_name=$('form[name=shipping_cost_form] input[name=ShippingExpress]').val();
			$('#CId').val($('form[name=shipping_cost_form] select[name=CId]').val());
			$('#CountryName').val(country_name);
			$('#CountryAcronym').val(acronym_name);
			$('#ShippingId').val($('form[name=shipping_cost_form] input[name=SId]:checked').val());
			
			$('#shipping_cost_choose').hide();
			if(flagpath){
				$('#shipping_flag').removeClass().html('<img src="'+flagpath+'" />');
			}else{
				$('#shipping_flag').removeClass().addClass('icon_flag flag_'+acronym_name.toLowerCase());
			}
			$('#shipping_cost_button').text(country_name+' Via '+express_name).attr('title', country_name+' Via '+express_name).removeAttr('disabled');
			global_obj.div_mask(1);
			
			return false;
		});
		
		$CId=$('#CId').val();
		get_shipping_methods($CId, 1);
		/**** 运费查询 End ****/
	},
	get_shipping_methods=function(CId, Method){
		$.post('/?do_action=cart.get_shipping_methods', 'CId='+CId+'&Type=shipping_cost&ProId='+$('#ProId').val()+'&Qty='+$('#quantity').val()+'&Attr='+$('#attr_hide').val(), function(data){
			if(data.ret==1){
				var v=data.msg.info;					
				var str=shipType=shipMethod='';
				var shipPrice=0;
				var SId=parseInt($('#ShippingId').val());
				for(i=0;i<v.length;i++){
					if((!SId && i==0) || SId==v[i].SId){
						var sed='checked';
						SId=v[i].SId;
						if(Method){
							shipType=v[i].type;
							shipMethod=v[i].Name;
							ShippingInsurance=1;
							shipPrice=parseFloat(v[i].ShippingPrice);
							insurance=parseFloat(v[i].InsurancePrice);
							shipBrief=v[i].Brief;
						}
					}else{
						var sed='';
					}
					str = str + '<li name="'+v[i].Name.toUpperCase()+'"><label for="__SId__'+i+'">';
						str = str + '<span><input type="radio" id="__SId__'+i+'" name="SId" value="' + v[i].SId + '" method="' + v[i].Name  + '" price="'+ v[i].ShippingPrice + '" brief="'+ v[i].Brief + '" insurance="'+ v[i].InsurancePrice + '" ShippingType="' + v[i].type + '" ' + sed + ' /></span>';
						str = str + '<strong>' + v[i].Name  + '</strong>';
						str = str + '<span>' + v[i].Brief + '</span>';
						if(v[i].Name.toUpperCase()=='DHL' && v[i].Shipping!=1000 && v[i].IsAPI==1){
							if(v[i].ShippingPrice>0){
								str = str + '<span class="price">--</span>';
							}else str = str + '<span class="price">Free Shipping</span>';
						}else{
							str = str + '<span class="price">' + (v[i].ShippingPrice>0?ueeshop_config.currency_symbols + v[i].ShippingPrice:'Free Shipping') + '</span>';
						}
					str = str + '</label></li>';
				}
				
				if(Method){
					if(!shipMethod){
						shipType=v[0].type;
						shipMethod=v[0].Name;
						ShippingInsurance=1;
						shipPrice=parseFloat(v[0].ShippingPrice);
						insurance=parseFloat(v[0].InsurancePrice);
						shipBrief=v[0].Brief;
					}
					shipPrice=shipPrice.toFixed(2);
					if(shipPrice>0){
						$('#shipping_cost_price').css('display', '').text(ueeshop_config.currency_symbols+shipPrice);
						$('#shipping_cost_freeshipping').css('display', 'none');
					}else{
						$('#shipping_cost_freeshipping').css('display', '');
						$('#shipping_cost_price').css('display', 'none').text(' ');
					}
					$('#delivery_time_processing').text(shipBrief);
					$('#shipping_flag').addClass('flag_'+$('#CountryAcronym').val().toLowerCase());
					$('#shipping_cost_button').text($('#CountryName').val()+' Via '+shipMethod).attr('title', $('#CountryName').val()+' Via '+shipMethod);
					$('#ShippingId').val(SId);
				}else{
					if(str!=''){
						var checkObj=$(str).find('input[name=SId]:checked');
						if(checkObj.attr('method')!=shipMethod){
							shipType=checkObj.attr('ShippingType');
							shipMethod=checkObj.attr('method');
							ShippingInsurance=1;
							shipPrice=parseFloat(checkObj.attr('price'));
							insurance=parseFloat(checkObj.attr('insurance'));
							shipBrief=checkObj.attr('brief');
						}else{
							shipType=v[0].type;
							shipMethod=v[0].Name;
							ShippingInsurance=1;
							shipPrice=parseFloat(v[0].ShippingPrice);
							insurance=parseFloat(v[0].InsurancePrice);
							shipBrief=v[0].Brief;
						}
					}else{
						str = str + '<li><strong>No optional!</strong></li>';
					}
					
					$('form[name=shipping_cost_form] input[name=ShippingExpress]').val(shipMethod);
					$('form[name=shipping_cost_form] input[name=ShippingMethodType]').val(shipType);
					$('form[name=shipping_cost_form] input[name=ShippingPrice]').val(shipPrice.toFixed(2));
					$('form[name=shipping_cost_form] input[name=ShippingBrief]').val(shipBrief);
					$('#shipping_method_list').html(str);
				}
			}else{
				$('.key_info_line').css('display', 'none');
			}
		}, 'json');
	}
	
	a();
	
	$('.FontPicArrowColor').css('border-color', 'transparent transparent '+$('.FontColor').css('color')+' transparent');
	$('.FontPicArrowXColor').css('border-color', 'transparent transparent transparent '+$('.FontColor').css('color'));
	
})(jQuery);