/* 获取关键词 */
function api_tags(obj,out,title)
{
	$(obj).attr('title',$(obj).val()).val('正在获取...')
	$.get('/api/tags/'+$("#"+title).val(),function(data){
		$('#'+out).val(data);
		$(obj).val($(obj).attr('title'))
	})
};

/* 获取拼音 */
function get_pinyin(obj,input,title)
{
	$(obj).attr('title',$(obj).val()).val('正在获取...')

	$.get('/zpadmin/api/admin/json_get_pinyin/'+title,function(data){
		$("#"+input).val(data);
		$(obj).val($(obj).attr('title'))
	})
}

/* input输入框点击隐藏提示,带有z_replace样式的对象*/
(function($){
	$.fn.z_replace = function(options) 
	{
		$(this).bind('click',function(){
			if ($(this).attr('title') == $(this).val())
			{
				$(this).val('').css('color','#666');
			}
		});
		$(this).bind('blur',function(){
			if ($(this).val()=='')
			{
				$(this).val($(this).attr('title')).css('#ccc');
			}
		})
	};  

})(jQuery);

/* app */
function wall_init()
{
	$("#wall_init").find('.goods_info').each(function(k,v){
			$container.append("<div class='poster_wall goods_list box_shadow' style='padding-bottom:0px;border-bottom:0px;'>"+$(v).html()+'</div>');
			$(v).remove();
		})
		$newElems = $(".poster_wall").hide();
		$newElems.imagesLoaded(function(){
			$container.show();
			$newElems.fadeIn(600).show();
			$container.masonry( 'appended', $newElems, false );
			$loadingItem.hide().removeClass('spelling').css({'height':'60px','margin':'0'});
			$loadingItem.find('center').css('margin','0');
			scroll = true;
		});
}


/* ajax 表单提交 */
(function($){
	$.fn.z_form_submit = function(options) 
	{
		var defaults = {    
		    url:window.location.href,
		    return_url:0 ,
		    obj_tips:false,
		    tips:'',
		    /* 验证函数 */
		    call_fun:'',
		    ret_settimeout:1000
		  }; 
		var opts = $.extend(defaults, options);
		if (opts.obj_tips !== false) 
		{
			opts._obj_tips = true;
		}
		$(this).bind('submit',function(data){
			if (typeof(opts.call_act)!='undefined' && opts.call_act($(this)) == false)
			{
				return false;
			}
			var isNotEvaluated = false;
			/* 检查参数 */
			$.each($(this).find('input'),function(k,v){
				if (typeof($(v).attr('data-check'))!='undefined' && $(v).val() == '')
				{
					tips(opts,$(v).attr('data-check'),false);
					isNotEvaluated = true;
					return false;
				}
			})
			if (isNotEvaluated == true)
			{
				return false;
			}
			if (opts.tips != '')
			{
				tips(opts,opts.tips,true);
			}
			post_data = $(this).serialize();
			obj = $(this);
			$(this).find('input').attr('disabled',true);
			$.post($(this).attr('action'),post_data,function(data){
				if (data.status == 1)
				{
					if (opts.return_url == 0)
					{
						tb_tips_url(data.msg,opts.url,opts.ret_settimeout);
					}
					else
					{
						tb_tips_url(data.msg,data.msg.url,opts.ret_settimeout);
					}
				}
				else
				{
					tips(opts,data.msg,false);
					$(obj).find('input').attr('disabled',false);
				}
			},'json')
			return false;
		})
	};
	function tips(opts,tips,retu)
	{
		if (opts._obj_tips == true) 
		{
			$(opts.obj_tips).show().html(tips);

			if (retu == false)
			{
				$(opts.obj_tips).removeClass('loading');
			}
			else
			{
				$(opts.obj_tips).addClass('loading');
			}
		}
		else
		{
			tb_tips(tips);
		}
	}

})(jQuery);

function show_goods()
{
	if (scroll == false)
	{
		return false;
	}
	else
	{
		if( $(document).scrollTop() + $(window).height() > $(document).height() - 600)
		{
			scroll = false;

			$loadingItem.slideDown(300,function(){
				
				next_page = next_url.replace('#scroll_page#',scroll_page);
				/* 加载URL */
				$.get(next_page,function(data){
					if (data != '')
					{
						$container.append(data);
						$newElems = $(".scroll_"+scroll_page);
						$newElems.imagesLoaded(function(){
							$container.masonry( 'appended', $newElems, false );
							$newElems.fadeIn(600).show();
							$loadingItem.hide();
							if (scroll_page >= scroll_count-1)
							{
								$("#page").show();
								return false;
							}
							setTimeout(function(){
								scroll = true;
								scroll_page++;
							},0)
						});

					}
					else
					{
						setTimeout(function(){
							$loadingItem.slideUp(300);
							$("#page").show();
							return false;
						},600)
						
					}
				})
			});
		}		
	}
}

(function($){
	$.fn.z_gotop = function() 
	{
		$(this).bind('click',function(){
			$("html, body").animate({ scrollTop: 0 }, 120);
		})
	};  

})(jQuery);