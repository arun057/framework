/*!
 * innerShiv
 * http://jdbartlett.com/innershiv
 */
window.innerShiv=function(){function h(c,e,b){return/^(?:area|br|col|embed|hr|img|input|link|meta|param)$/i.test(b)?c:e+"></"+b+">"}var c,e=document,j,g="abbr article aside audio canvas datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video".split(" ");return function(d,i){if(!c&&(c=e.createElement("div"),c.innerHTML="<nav></nav>",j=c.childNodes.length!==1)){for(var b=e.createDocumentFragment(),f=g.length;f--;)b.createElement(g[f]);b.appendChild(c)}d=d.replace(/^\s\s*/,"").replace(/\s\s*$/,"").replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,"").replace(/(<([\w:]+)[^>]*?)\/>/g,h);c.innerHTML=(b=d.match(/^<(tbody|tr|td|col|colgroup|thead|tfoot)/i))?"<table>"+d+"</table>":d;b=b?c.getElementsByTagName(b[1])[0].parentNode:c;if(i===!1)return b.childNodes;for(var f=e.createDocumentFragment(),k=b.childNodes.length;k--;)f.appendChild(b.firstChild);return f}}();

/*!
 * CSS Browser Selector v0.4.0 (Nov 02, 2010)
 * http://rafael.adm.br/css_browser_selector
 */
function css_browser_selector(u){var ua=u.toLowerCase(),is=function(t){return ua.indexOf(t)>-1},g='gecko',w='webkit',s='safari',o='opera',m='mobile',h=document.documentElement,b=[(!(/opera|webtv/i.test(ua))&&/msie\s(\d)/.test(ua))?('ie ie'+RegExp.$1):is('firefox/2')?g+' ff2':is('firefox/3.5')?g+' ff3 ff3_5':is('firefox/3.6')?g+' ff3 ff3_6':is('firefox/3')?g+' ff3':is('gecko/')?g:is('opera')?o+(/version\/(\d+)/.test(ua)?' '+o+RegExp.$1:(/opera(\s|\/)(\d+)/.test(ua)?' '+o+RegExp.$2:'')):is('konqueror')?'konqueror':is('blackberry')?m+' blackberry':is('android')?m+' android':is('chrome')?w+' chrome':is('iron')?w+' iron':is('applewebkit/')?w+' '+s+(/version\/(\d+)/.test(ua)?' '+s+RegExp.$1:''):is('mozilla/')?g:'',is('j2me')?m+' j2me':is('iphone')?m+' iphone':is('ipod')?m+' ipod':is('ipad')?m+' ipad':is('mac')?'mac':is('darwin')?'mac':is('webtv')?'webtv':is('win')?'win'+(is('windows nt 6.0')?' vista':''):is('freebsd')?'freebsd':(is('x11')||is('linux'))?'linux':'','js']; c = b.join(' '); h.className += ' '+c; return c;}; css_browser_selector(navigator.userAgent);

/*!
 * (v) Compact labels plugin (v20110124)
 * Takes one option: labelOpacity [default: true] set to false to disable label opacity change on empty input focus
 */
(function($){$.fn.compactize=function(options){var defaults={labelOpacity:true};options=$.extend(defaults,options);return this.each(function(){var label=$(this),input=$('#'+label.attr('for'));input.focus(function(){if(options.labelOpacity){if(input.val()===''){label.css('opacity','0.5');}}else{label.hide();}});input.keydown(function(){label.hide();});input.blur(function(){if(input.val()===''){label.show();if(options.labelOpacity){label.css('opacity',1);}}});window.setTimeout(function(){if(input.val()!==''){label.hide();}},50);});};})(jQuery);

/*!
 * (v) hrefID jQuery extention
 * returns a valid #hash string from link href attribute in Internet Explorer
 */
(function($){$.fn.extend({hrefId:function(){return $(this).attr('href').substr($(this).attr('href').indexOf('#'));}});})(jQuery);

/*
  jQuery-SelectBox
  This product includes software developed 
  by RevSystems, Inc (http://www.revsystems.com/) and its contributors
*/
(function(e,d,g){e.fn.borderWidth=function(){return e(this).outerWidth()-e(this).innerWidth()};e.fn.paddingWidth=function(){return e(this).innerWidth()-e(this).width()};e.fn.extraWidth=function(){return e(this).outerWidth(true)-e(this).width()};e.fn.offsetFrom=function(i){var h=e(i);return{left:e(this).offset().left-h.offset().left,top:e(this).offset().top-h.offset().top}};e.fn.maxWidth=function(){var h=0;e(this).each(function(){if(e(this).width()>h){h=e(this).width()}});return h};e.fn.triggerAll=function(h,i){return e(this).each(function(){e(this).triggerHandler(h,i)})};var c=Array.prototype.slice,a=function(){return Math.floor(Math.random()*999999999)};e.proto=function(){var i=arguments[0],h=arguments[1],j=h,l={},k;opts=e.extend({elem:"elem",access:"access",init:"init",instantAccess:false},arguments[2]);if(h._super){l[opts.init]=function(){};j=h.extend(l)}e.fn[i]=function(){var m,n=arguments;e(this).each(function(){var p=e(this),q=p.data(i),o=!q;if(o){q=new j();if(h._super){q[opts.init]=h.prototype.init}q[opts.elem]=p[0];if(q[opts.init]){q[opts.init].apply(q,opts.instantAccess?[]:c.call(n,0))}p.data(i,q)}if(!o||opts.instantAccess){if(q[opts.access]){q[opts.access].apply(q,c.call(n,0))}if(n.length>0){if(e.isFunction(q[n[0]])){m=q[n[0]].apply(q,c.call(n,1))}else{if(n.length===1){if(e.getObject){m=e.getObject(n[0],q)}else{m=q[n[0]]}}else{if(e.setObject){e.setObject(n[0],n[1],q)}else{q[n[0]]=n[1]}}}}else{if(m===k){m=p.data(i)}}}});if(m===k){return e(this)}return m}};var b=function(){return false},f=function(){var q=this,T={},m=null,C=null,u=null,v=null,l=null,ab=null,V="",F=null,U=null,i=null,S,Y,n,ae,s,ac,X,L,Z,w,ad,h,aa,R,P,K,y,z,j,W,Q,I,H,O,G,N,D,B,k,M,p,A,E,x,t,r,J;S=function(){u=e("<div class='sb "+T.selectboxClass+" "+m.attr("class")+"' id='sb"+a()+"'></div>").attr("role","listbox").attr("aria-has-popup","true").attr("aria-labelledby",C.attr("id")?C.attr("id"):"");e("body").append(u);var af=m.children().size()>0?T.displayFormat.call(m.find("option:selected")[0],0,0):"&nbsp;";v=e("<div class='display "+m.attr("class")+"' id='sbd"+a()+"'></div>").append("<div class='text'>"+af+"</div>").append(T.arrowMarkup);u.append(v);l=e("<ul class='"+T.selectboxClass+" items "+m.attr("class")+"' role='menu' id='sbdd"+a()+"'></ul>").attr("aria-hidden","true");u.append(l).attr("aria-owns",l.attr("id"));if(m.children().size()===0){l.append(Y())}else{m.children().each(function(ag){var ah,ai,aj,ak;if(e(this).is("optgroup")){ai=e(this);aj=e("<li class='optgroup'>"+T.optgroupFormat.call(ai[0],ag+1)+"</li>").addClass(ai.is(":disabled")?"disabled":"").attr("aria-disabled",ai.is(":disabled")?"true":"");ak=e("<ul class='items'></ul>");aj.append(ak);l.append(aj);ai.children("option").each(function(){ah=Y(e(this),ag).addClass(ai.is(":disabled")?"disabled":"").attr("aria-disabled",ai.is(":disabled")?"true":"");ak.append(ah)})}else{l.append(Y(e(this),ag))}})}ab=l.find("li").not(".optgroup");u.attr("aria-active-descendant",ab.filter(".selected").attr("id"));l.children(":first").addClass("first");l.children(":last").addClass("last");if(!T.fixedWidth){var o=l.find(".text, .optgroup").maxWidth()+v.extraWidth()+1;u.width(T.maxWidth?Math.min(T.maxWidth,o):o)}else{if(T.maxWidth&&u.width()>T.maxWidth){u.width(T.maxWidth)}}m.before(u).addClass("has_sb").hide().show();ad();J();l.hide();if(!m.is(":disabled")){m.bind("blur.sb",ae).bind("focus.sb",n);v.mousedown(I).mousedown(R).click(b).focus(z).blur(j).hover(W,Q);N().click(P).hover(W,Q);l.find(".optgroup").hover(W,Q).click(b);ab.filter(".disabled").click(b);if(!e.browser.msie||e.browser.version>=9){e(d).resize(e.throttle?e.throttle(100,h):aa)}}else{u.addClass("disabled").attr("aria-disabled");v.click(function(ag){ag.preventDefault()})}u.bind("close.sb",w).bind("destroy.sb",s);m.bind("reload.sb",ac);if(e.fn.tie&&T.useTie){m.bind("domupdate.sb",X)}};aa=function(){clearTimeout(i);i=setTimeout(h,50)};h=function(){if(u.is(".open")){ad();L(true)}};Y=function(ag,o){if(!ag){ag=e("<option value=''>&nbsp;</option>");o=0}var ai=e("<li id='sbo"+a()+"'></li>").attr("role","option").data("orig",ag[0]).data("value",ag?ag.attr("value"):"").addClass(ag.is(":selected")?"selected":"").addClass(ag.is(":disabled")?"disabled":"").attr("aria-disabled",ag.is(":disabled")?"true":""),ah=e("<div class='item'></div>"),af=e("<div class='text'></div>").html(T.optionFormat.call(ag[0],0,o+1));return ai.append(ah.append(af))};n=function(){t();v.triggerHandler("focus")};ae=function(){v.triggerHandler("blur")};s=function(o){u.remove();m.unbind(".sb").removeClass("has_sb");e(d).unbind("resize",aa);if(!o){m.removeData("sb")}};ac=function(){var af=u.is(".open"),o=v.is(".focused");w(true);s(true);q.init(T);if(af){m.focus();L(true)}else{if(o){m.focus()}}};X=function(){clearTimeout(U);U=setTimeout(ac,30)};x=function(){w();e(document).unbind("click",x)};A=function(){e(".sb.open."+T.selectboxClass).triggerAll("close")};t=function(){e(".sb.focused."+T.selectboxClass).not(u[0]).find(".display").blur()};E=function(){e(".sb.open."+T.selectboxClass).not(u[0]).triggerAll("close")};w=function(o){if(u.is(".open")){v.blur();ab.removeClass("hover");e(document).unbind("keyup",K).unbind("keydown",r).unbind("keypress",r).unbind("keydown",y);l.attr("aria-hidden","true");if(o===true){l.hide();u.removeClass("open");u.append(l)}else{l.fadeOut(T.animDuration,function(){u.removeClass("open");u.append(l)})}}};O=function(){var o=null;if(T.ddCtx==="self"){o=u}else{if(e.isFunction(T.ddCtx)){o=e(T.ddCtx.call(m[0]))}else{o=e(T.ddCtx)}}return o};G=function(){return ab.filter(".selected")};N=function(){return ab.not(".disabled")};Z=function(){l.scrollTop(l.scrollTop()+G().offsetFrom(l).top-l.height()/2+G().outerHeight(true)/2)};J=function(){if(e.browser.msie&&e.browser.version<8){e("."+T.selectboxClass+" .display").hide().show()}};L=function(af){var o,ag=O();t();u.addClass("open");ag.append(l);o=ad();l.attr("aria-hidden","false");if(af===true){l.show();Z()}else{if(o==="down"){l.slideDown(T.animDuration,Z)}else{l.fadeIn(T.animDuration,Z)}}e(document).click(x);m.focus()};ad=function(){var ai=O(),ap=0,ag=v.offsetFrom(ai).left,af=0,aj="",am,o,ao,an,ah,aq,al,ak;l.removeClass("above");l.show().css({maxHeight:"none",position:"relative",visibility:"hidden"});if(!T.fixedWidth){l.width(v.outerWidth()-l.extraWidth()+1)}ao=e(d).scrollTop()+e(d).height()-v.offset().top-v.outerHeight();an=v.offset().top-e(d).scrollTop();ah=v.offsetFrom(ai).top+v.outerHeight();aq=ao-an+T.dropupThreshold;if(l.outerHeight()<ao){ap=T.maxHeight?T.maxHeight:ao;af=ah;aj="down"}else{if(l.outerHeight()<an){ap=T.maxHeight?T.maxHeight:an;af=v.offsetFrom(ai).top-Math.min(ap,l.outerHeight());aj="up"}else{if(aq>=0){ap=T.maxHeight?T.maxHeight:ao;af=ah;aj="down"}else{if(aq<0){ap=T.maxHeight?T.maxHeight:an;af=v.offsetFrom(ai).top-Math.min(ap,l.outerHeight());aj="up"}else{ap=T.maxHeight?T.maxHeight:"none";af=ah;aj="down"}}}}am=(""+e("body").css("margin-left")).match(/^\d+/)?e("body").css("margin-left"):0;o=(""+e("body").css("margin-top")).match(/^\d+/)?e("body").css("margin-top"):0;al=e().jquery>="1.4.2"?parseInt(am):e("body").offset().left;ak=e().jquery>="1.4.2"?parseInt(o):e("body").offset().top;l.hide().css({left:ag+(ai.is("body")?al:0),maxHeight:ap,position:"absolute",top:af+(ai.is("body")?ak:0),visibility:"visible"});if(aj==="up"){l.addClass("above")}return aj};R=function(o){if(u.is(".open")){w()}else{L()}return false};D=function(){var af=e(this),o=m.val(),ag=af.data("value");if(T.useTie&&e.fn.tie){m.find("option").old_removeAttr("selected");e(af.data("orig")).old_attr("selected","selected")}else{m.find("option").removeAttr("selected");e(af.data("orig")).attr("selected","selected")}N().removeClass("selected");af.addClass("selected");u.attr("aria-active-descendant",af.attr("id"));v.find(".text").attr("title",af.find(".text").html());v.find(".text").html(T.displayFormat.call(af.data("orig")));if(o!==ag){m.change()}};P=function(o){D.call(this);x();m.focus();return false};B=function(){V=""};k=function(ai){var ah,ag,o,af=N();for(ah=0;ah<af.size();ah++){o=af.eq(ah).find(".text");ag=o.children().size()==0?o.text():o.find("*").text();if(ai.length>0&&ag.toLowerCase().match("^"+ai.toLowerCase())){return af.eq(ah)}}return null};M=function(af){var o=k(af);if(o!==null){D.call(o[0]);return true}return false};r=function(o){if(o.ctrlKey||o.altKey){return}if(o.which===38||o.which===40||o.which===8||o.which===32){o.preventDefault()}};p=function(ai){var ah,ag,o=G(),af=N();for(ah=af.index(o)+1;ah<af.size();ah++){ag=af.eq(ah).find(".text").text();if(ag!==""&&ag.substring(0,1).toLowerCase()===ai.toLowerCase()){D.call(af.eq(ah)[0]);return true}}return false};y=function(ag){if(ag.altKey||ag.ctrlKey){return false}var af=G(),o=N();switch(ag.which){case 35:if(af.size()>0){ag.preventDefault();D.call(o.filter(":last")[0]);Z()}break;case 36:if(af.size()>0){ag.preventDefault();D.call(o.filter(":first")[0]);Z()}break;case 38:if(af.size()>0){if(o.filter(":first")[0]!==af[0]){ag.preventDefault();D.call(o.eq(o.index(af)-1)[0])}Z()}break;case 40:if(af.size()>0){if(o.filter(":last")[0]!==af[0]){ag.preventDefault();D.call(o.eq(o.index(af)+1)[0]);Z()}}else{if(ab.size()>1){ag.preventDefault();D.call(ab.eq(0)[0])}}break;default:break}};K=function(o){if(o.altKey||o.ctrlKey){return false}if(o.which!==38&&o.which!==40){V+=String.fromCharCode(o.keyCode);if(M(V)){clearTimeout(F);F=setTimeout(B,T.acTimeout)}else{if(p(String.fromCharCode(o.keyCode))){Z();clearTimeout(F);F=setTimeout(B,T.acTimeout)}else{B();clearTimeout(F)}}}};z=function(){E();u.addClass("focused");e(document).unbind("keyup",K).keyup(K).unbind("keypress",r).keypress(r).unbind("keydown",r).keydown(r).keydown(y).unbind("keydown",y).keydown(y)};j=function(){u.removeClass("focused");e(document).unbind("keyup",K).unbind("keydown",r).unbind("keydown",y)};W=function(){e(this).addClass("hover")};Q=function(){e(this).removeClass("hover")};I=function(){v.addClass("active");e(document).bind("mouseup",H)};H=function(){v.removeClass("active");e(document).unbind("mouseup",H)};this.init=function(o){if(e.browser.msie&&e.browser.version<7){return}m=e(this.elem);if(m.attr("id")){C=e("label[for='"+m.attr("id")+"']:first")}if(!C||C.size()===0){C=m.closest("label")}if(m.hasClass("has_sb")){return}T=e.extend({acTimeout:800,animDuration:200,ddCtx:"body",dropupThreshold:150,fixedWidth:false,maxHeight:false,maxWidth:false,selectboxClass:"selectbox",useTie:false,arrowMarkup:"<div class='arrow_btn'><span class='arrow'></span></div>",displayFormat:g,optionFormat:function(af,ah){if(e(this).size()>0){var ag=e(this).attr("label");if(ag&&ag.length>0){return ag}return e(this).text()}else{return""}},optgroupFormat:function(af){return"<span class='label'>"+e(this).attr("label")+"</span>"}},o);T.displayFormat=T.displayFormat||T.optionFormat;S()};this.open=L;this.close=w;this.refresh=ac;this.destroy=s;this.options=function(o){T=e.extend(T,o);ac()}};e.proto("sb",f)}(jQuery,window));


/*!
 * Scripts
 *
 */
jQuery(function($) {
 
	var Engine = {
		utils : {
			links : function(){
				$('a[rel*="external"]').click(function(e){
					e.preventDefault();
					window.open($(this).attr('href'));
				});
			},
			mails : function(){
				$('a[href^="mailto:"]').each(function(){
					var mail = $(this).attr('href').replace('mailto:','');
					var replaced = mail.replace('/at/','@');
					$(this).attr('href','mailto:'+replaced);
					if($(this).text() === mail) {
						$(this).text(replaced);
					}
				});
			}
		},
		ui : {
			share : function() {
				$('.sharebox-a').each(function() {
					var $root = $(this);
					var height = $root.find('#share-a').height();
					$root.find('#share-b').css('min-height',height+'px');					
					
					$root.find('#share-b').append('<p class="close"><a href="#share-a">Close</a></p>').find('p.close a').click(function() {
						$root.find('#share-b').hide().parent().find('#share-a').show();
						return false;
					});
					$root.find('#share-a a.button-b').click(function() {
						if (is_logged_in=='1'){
						$root.find('#share-a').hide().parent().find('#share-b').show();
						}
						
						return false;
					});
				});
			},
			chalice : function() {
				$('#lamp-a p.off').click(function() {
					$(this).next('p.on').fadeTo(0,0).show().fadeTo(1500,1);
				});
			},
			columnists : function() {
				$('.columnists-a').each(function() {
					var $root 		= $(this);
					var $slider 	= $root.find('.wrap ul');
					var count 		= $root.find('li').size();

					var visible 	= 6;
					var current 	= 1;
					
					if(count > visible){
						$root.append('<p class="step scroll-up" style="display: none;"><a href="#up" class="up">Up</a></p><p class="step scroll-down"><a href="#down" class="down">Down</a></p>');
						$root.find('p.step a').click(function() {
							if($slider.is(':animated') || ($(this).is('.up') && current === 1) || ($(this).is('.down') && current+visible > count)) return false;
							if($(this).is('.up')){
								var move =  '+=60px';
								current--;
							} else {
								var move =  '-=60px';
								current++;
							}
							
							var $up = $root.find('p.step.scroll-up');
							var $down = $root.find('p.step.scroll-down');
							
							if(current > 1){
								$up.show();
								if(current+visible > count){
									$down.hide();	
								} else {
									$down.show();
								}
							} else {
								$up.hide();
							}

							$slider.animate({top: move},250,function() {
								
							});
							return false;
						});
					}
				});
			}
		},
		forms : {
			labels : function() {
				$('#search-top label').compactize();
				$('.widget-a form label').compactize();
				$('#share-b form label').compactize();
				$('.cat-form label').compactize();
			},
			selectbox : function(){
				$(".form-b select").sb({
					fixedWidth: true
				});
			}
		},
		fixes : {
			enhancements : function() {
				if($.browser.msie && parseInt($.browser.version,10) < 9){
					$(':last-child:not(cufon)').addClass('last-child');
					$('ul#user-area > li').prepend('<span class="before">|</span>');
				}
				if($.browser.opera) $('body').addClass('operafix');
			}
		}
	};

	Engine.utils.links();
	Engine.utils.mails();
	Engine.ui.share();
	Engine.ui.chalice();
	Engine.ui.columnists();
	Engine.forms.labels();
	Engine.forms.selectbox();
	Engine.fixes.enhancements();
	
	//$('.jc_error').hide();
	
	
});

function slideshow_func(carousel)
{
	carousel.container.find("li").each(function()
	{
		carousel.container.find(".slideshow-slides").append("<a/>");
	});
	
	carousel.container.find(".slideshow-slides a").live("click", function()
	{
		var i = carousel.container.find(".slideshow-slides a").index($(this));
		
		carousel.container.find(".slideshow-slides a").removeClass("selected");
		$(this).addClass("selected");
		
		carousel.scroll(i+1);
		
		return false;
	});
	
	jQuery('.jcarousel-control a').bind('click', function() {
	  carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
	  return false;
	});
};

function slideshow_slide_func(a, b, c, d)
{
	$(".slideshow .slideshow-slides a").removeClass("selected");
	$(".slideshow .slideshow-slides a:eq("+(c-1)+")").addClass("selected");
}

function twitter_slide_func(a, b, c, d)
{
	$(".twitter-block h3 .timestamp").html($(".twitter-block .twitter-slider li:eq("+(c-1)+") .timestamp").html());
}

jQuery(document).ready( function() {
	 
	$("#sm_form .button-a").click(function (e) {
                e.preventDefault();
            var url= $('#sm_form select.select-a option:selected').val();   
			if (url!=0){
			 window.location=url;
			}
      });
	
	$(".slideshow").jcarousel({
		scroll: 1,
                auto: 10,
                wrap: 'last', 
		initCallback: slideshow_func,
		itemFirstInCallback: slideshow_slide_func,
		buttonNextHTML: null,
		buttonPrevHTML: null
	});

	$(".events-slider").jcarousel({
		scroll: 1
	});
			
        $('#header_signin, .body-login').click(function (e) {
                e.preventDefault();
                show_lightbox();
                account_submit('/account/sign_in?ajax=1', ''); 
                $("html,body").animate({ scrollTop: 0 }, "slow");
            });

        $('#sign_in_to_comment').click(function (e) {
                e.preventDefault();
                show_lightbox();
                account_submit('/account/sign_in?ajax=1&continue=' + $(this).attr('href'), ''); 
                $("html,body").animate({ scrollTop: 0 }, "slow");
            });

	//NB: joys and concerns submit joys_and_concerns   joys_concerns_button
	$('#joys_concerns_button').click(function () {
                //$('.jc_error').hide();   						   
                if ($('#f-name-a').val() == '') {
                    $('#label-f-name-a').text('First Name Required');
                    $('#label-f-name-a').css('color','red');
                    // $("label#f-name_error").show();
                    //$('#label-f-name-a').css('color:red');
                    return false ;
                }

                if ($('#f-name-b').val() == '') {
                    $('#label-f-name-b').text('Last Name Required');
                    $('#label-f-name-b').css('color','red');
                    return false ;
                } 
                if ($('#f-city-a').val() == '') {
                    $('#label-f-city-a').text('City Required');
                    $('#label-f-city-a').css('color','red');
                    return false ;
                }
                if ($('#f-state-a').val() == '') {
                    $('#label-f-state-a').text('State Required');
                    $('#label-f-state-a').css('color','red');
                    return false ;
                }
                if ($('#f-message-a').val() == '') {
                    $('#label-f-message-a').text('Message Required');
                    $('#label-f-message-a').css('color','red');
                    return false ;
                }
				
		$('#joys_and_concerns').submit();
		
		///
		/*$.post("/joys_and_concerns/submit_story/", $('#' + joys_and_concerns).serialize(),            function(response) {
                  $('#joy_div').html($response);
                  });*/
            });

        $('.focusable').focus(function() {
									
                if (this.value == this.defaultValue){
                    this.value = '';
                }
                if(this.value != this.defaultValue) {
                    this.select();
                }
            });

        $('.focusable').blur(function() {
                if (this.value == '') {
                    this.value = (this.defaultValue ? this.defaultValue : '');
                }
            });

        $("#dialog").dialog({
            modal: true,
                    bgiframe: true,
                    width: 300,
                    height: 100,
                    autoOpen: false
                    });


        $(".flag_this").live('click', function(e) {
                e.preventDefault();
                var theHREF = $(this).attr("href");
                $("#dialog").dialog('option', 'buttons', {
                        "Confirm" : function() {
                                            window.location.href = theHREF;
                                        },
                                            "Cancel" : function() {
                                            $(this).dialog("close");
                                        }
                    });

                var x = e.pageX - $(window).offsetLeft;
                var y = e.pageY - $(window).scrollTop();

                $("#dialog").dialog('option', 'position', [x,y]);

                $("#dialog").dialog("open");


            });
			
		   $('#share_button').click(function (e) {                                                        
              if (is_logged_in=='0'){  
			     e.preventDefault();                                                                     
                show_lightbox();                                                                        
                account_submit('/account/sign_in?ajax=1', '');                                          
                $("html,body").animate({ scrollTop: 0 }, "slow");                                       
			  }
            });
		   
		   $('#get_updates').submit(function() {
		// update user interface
			  $('#response').html('Adding email address...');
			  
			  // Prepare query string and send AJAX request
			  $.ajax({
				  url: '/site/get_updates',
				  data: 'ajax=true&email=' + escape($('#email').val())+'&zip=' + escape($('#zip').val()),
				  success: function(msg) {
					  $('#response').html(msg);
				  }
			  });
		  
		return false;
	});
			
			
	$(".toggle_container").hide(); 

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$(".trigger").click(function(){
		$(this).toggleClass("trigger_active").next().slideToggle("slow");
		return false; //Prevent the browser jump to the link anchor
	});

    });
