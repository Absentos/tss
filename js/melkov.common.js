/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */

$(document).ready(function(){
	var featured_content = $('#featured'),
		et_disable_toptier = $("meta[name=et_disable_toptier]").attr('content'),
		et_cufon = $("meta[name=et_cufon]").attr('content'),
		et_featured_slider_pause = $("meta[name=et_featured_slider_pause]").attr('content'),
		et_featured_slider_auto = $("meta[name=et_featured_slider_auto]").attr('content'),
		et_featured_auto_speed = $("meta[name=et_featured_auto_speed]").attr('content');

	if ( et_cufon == 1 ) {
		Cufon.replace('.service h3.title',{textShadow:'1px 1px 1px #fff'})('#quote-inner p')('a.additional-info')('h4.widgettitle',{textShadow:'1px 1px 1px rgba(0,0,0,0.5)'})('h1.category-title',{textShadow:'1px 1px 1px rgba(0,0,0,0.6)'})('h2.title, h3#comments, .entry h1, .entry h2, .entry h3, .entry h4, .entry h5, .entry h6, h3#reply-title span',{textShadow:'1px 1px 1px #fff'})('.post p.meta-info',{textShadow:'1px 1px 1px #fff'})('#sidebar h4.widgettitle',{textShadow:'1px 1px 1px #fff'})('#featured .description h2',{textShadow:'1px 1px 1px rgba(0,0,0,0.4)'})('.comment-meta')('.wp-pagenavi span',{textShadow:'1px 1px 1px #fff'})('.wp-pagenavi a',{textShadow:'1px 1px 1px #fff'})('.wp-pagenavi span.current',{textShadow:'1px 1px 1px rgba(0,0,0,0.4)'});
	}

	$('ul.nav').superfish({ 
		delay:       200,                             
		animation:   {opacity:'show',height:'show'},
		speed:       'fast',                        
		autoArrows:  true,                          
		dropShadows: false                          
	});

	$('ul.nav > li > a.sf-with-ul').parent('li').addClass('sf-ul');
		
	if (featured_content.length) {
		var featured_slides = featured_content.find('.slide'),
			slides_pos = [],
			slides_zindex = [],
			active_slide_width = 500,
			small_slide_width = 250,
			slide_margin = 16,
			featured_animation = 'easeInOutQuad', //'easeInOutQuad','easeInOutQuint', 'easeInOutQuart'
			et_animation_running = false,
			last_slide = false,
			pause_scroll = false,
			top_slide_pos,
			left_slide_pos,
			slide_opacity;
					
		featured_slides.each(function(index, domEle){
			var this_slide = $(domEle);
			
			top_slide_pos = 82;
			slide_opacity = 0.3;
			
			if ( index === 0 ) {
				top_slide_pos = 0;
				slide_opacity = 1;
				left_slide_pos = 230;
			}
			if ( index === 1 ) left_slide_pos = 620;
			if ( index === 2 ) left_slide_pos = 90;
			if ( index > 2 ) {
				if ( index % 2 === 1 ) left_slide_pos = slides_pos[index-2].left + small_slide_width + slide_margin;
				else left_slide_pos = slides_pos[index-2].left - small_slide_width - slide_margin;
			}
			
			if ( index !== 0 ) {
				this_slide.find('img').attr({
					width: '250',
					height: '169'
				});
			}
							
			slides_pos[index] = {
				width: this_slide.width(),
				top: top_slide_pos,
				left: left_slide_pos,
				opacity: slide_opacity
			};
			
			this_slide.css('zIndex',featured_slides.length-index);
			slides_zindex[index] = this_slide.css('zIndex');
			
			this_slide.animate(slides_pos[index],100);
			$(domEle).data('slide_pos',index);
		});
		
		$('a.nextslide').live('click',function(event){
			event.preventDefault();
			if (!et_animation_running) rotate_slide('next');
			if ( typeof(et_auto_animation) !== 'undefined' ) clearInterval(et_auto_animation);
		});
		
		$('a.prevslide').live('click',function(event){
			event.preventDefault();
			if (!et_animation_running) rotate_slide('prev');
			if ( typeof(et_auto_animation) !== 'undefined' ) clearInterval(et_auto_animation);
		});
		
		featured_slides.hover(function(){
			if ( !et_animation_running ) {
				if ( $(this).hasClass('active') ){
					$(this).find('.additional').stop(true, true).animate({'opacity':'show'},300);
				}
			}
			if ( et_featured_slider_pause == 1 ) pause_scroll = true;
		},function(){
			if ( !et_animation_running ) {
				$(this).find('.additional').stop(true, true).animate({'opacity':'hide'},300);
			}
			if ( et_featured_slider_pause == 1 ) pause_scroll = false;
		});
		
		var et_mousex = 0,
			et_mousey = 0,
			featured_activeslide_x = featured_content.find('.container').offset().left + 230,
			featured_activeslide_y = featured_content.find('.container').offset().top;
		
		$(document).mousemove(function(e){
			et_mousex = e.pageX;
			et_mousey = e.pageY;
		});
		 
		function rotate_slide(direction){
			featured_slides.removeClass('active');
							
			featured_slides.each(function(index, domEle){
				var this_slide = $(domEle),
					next_slide_num = this_slide.data('slide_pos');
				
				et_animation_running = true;	
				last_slide = false;
				
				featured_slides.find('.additional').css('display','none');
				
				if ( direction === 'next' ){
					if ( next_slide_num === 0 ) next_slide_num = 2;
					else if ( next_slide_num === 1 ) next_slide_num = 0;
					else if ( featured_slides.length % 2 === 0 && next_slide_num === ( featured_slides.length - 2 ) ) {
						next_slide_num = featured_slides.length - 1;
					}
					else {
						if ( next_slide_num !== (featured_slides.length - 1) ) {
							if ( next_slide_num % 2 === 0 )  next_slide_num = next_slide_num + 2;
							else next_slide_num = next_slide_num - 2;
						} else {
							if ( featured_slides.length % 2 === 0 ) {
								if ( next_slide_num % 2 === 0 )  next_slide_num = next_slide_num + 2;
								else next_slide_num = next_slide_num - 2;
							}
							else { 
								next_slide_num = featured_slides.length - 2;
								last_slide = true;
							}
						}
					}
				} else {
					if ( next_slide_num === 0 ) next_slide_num = 1;
					else if ( featured_slides.length % 2 === 0 && next_slide_num === ( featured_slides.length - 1 ) ) {
						next_slide_num = featured_slides.length - 2;
					}
					else {
						if ( featured_slides.length % 2 === 0 ) {
							if ( next_slide_num % 2 === 0 ) next_slide_num = next_slide_num - 2;
							else next_slide_num = next_slide_num + 2;
						} else {
							if ( next_slide_num !== (featured_slides.length - 2) ) {
								if ( next_slide_num % 2 === 0 ) next_slide_num = next_slide_num - 2;
								else next_slide_num = next_slide_num + 2;
							} else {
								next_slide_num = featured_slides.length-1;
								last_slide = true;
							}
						}
					}
				}
							
				if ( last_slide ) {
					this_slide.css('left',slides_pos[next_slide_num].left);
				}
									
				this_slide.stop(true, true).animate(slides_pos[next_slide_num],600,featured_animation,function(){
					if ( index === featured_slides.length - 1 ) et_animation_running = false;
									
					if ( !et_animation_running ) {
						if ( et_mousex > featured_activeslide_x && et_mousex < (featured_activeslide_x + 500) && et_mousey > featured_activeslide_y && et_mousey < (featured_activeslide_y + 335) ){
							if ( next_slide_num === 0 ) featured_content.find('.slide').filter(':eq('+(featured_slides.length - 1)+')').find('.additional').stop(true, true).animate({'opacity':'show'},300);
							else featured_content.find('.active .additional').stop(true, true).animate({'opacity':'show'},300);
							
							if ( et_featured_slider_pause == 1 ) pause_scroll = true;
						}
					}
				});
				if ( next_slide_num != 0 ) {
					this_slide.find('img').stop(true, true).animate({'width':'250px','height':'169px'},600,featured_animation);
				}
				else { 
					this_slide.find('img').stop(true, true).animate({'width':'500px','height':'335px'},600,featured_animation,function(){
						this_slide.addClass('active');
					});
				}
					
				setTimeout(function(){
					this_slide.css({zIndex: slides_zindex[next_slide_num]});
				},300);
				
				this_slide.data('slide_pos',next_slide_num);
			});
		}
		
		if ( et_featured_slider_auto == 1 ) {
			et_auto_animation = setInterval(function(){
				if ( !pause_scroll ) rotate_slide('next');
			}, et_featured_auto_speed);
		}
	}

	var et_blurb_thumb = $('div.project');
	et_blurb_thumb.hover(function(){
		$(this).find('img').fadeTo('fast', 0.8);
		$(this).find('.more-icon,.zoom-icon').fadeTo('fast', 1);
	}, function(){
		$(this).find('img').fadeTo('fast', 1);
		$(this).find('.more-icon,.zoom-icon').fadeTo('fast', 0);
	});

	var footer_widget = $("#footer-widgets .footer-widget");
	if ( footer_widget.length ) {
		footer_widget.each(function (index, domEle) {
			if ((index+1)%3 == 0) $(domEle).addClass("last").after("<div class='clear'></div>");
		});
	}

	if ( et_disable_toptier == 1 ) $("ul.nav > li > ul").prev("a").attr("href","#");
			 
	if ( et_cufon == 1 ) Cufon.now();
});