/*! Paichen v1.0.1 By:占建斌 QQ:1624447337  */
//;Number.prototype.toFixed=function(d){var s=this;if(!d){d=0;}with(Math){return round(s*pow(10,d))/pow(10,d);}};
;(function(win,undefined){
	pChen=function(){pChen.fn=pChen.prototype;return this;}
	pChen.fn=pChen.prototype={
		constructor:pChen,
		cookie:function(name, value, expires, path, domain, secure) {//名字,值,过期时间(分)
			if (typeof value != 'undefined') { 
				if (value === null) {
					value = '';
					expires = -1;
				}
				var expires_s = '';
				if (expires && (typeof expires == 'number' || expires.toUTCString)) {
					var date;
					if (typeof expires == 'number') {
						date = new Date();
						date.setTime(date.getTime() + (expires * 60 * 1000));//expires * 24 * 60 * 60 * 1000
					} else {
						date = expires;
					}
					expires_s = '; expires=' + date.toUTCString();
				}
				path = path ? '; path=' + (path) : '';
				domain = domain ? '; domain=' + (domain) : '';
				secure = secure ? '; secure' : '';
				document.cookie = [name, '=', encodeURIComponent(value), expires_s, path, domain, secure].join('');
			} else {
				var cookieValue = null;
				if (document.cookie && document.cookie != '') {
					var cookies = document.cookie.split(';');
					for (var i = 0; i < cookies.length; i++) {
						var cookie = this.trim(cookies[i]);
						if (cookie.substring(0, name.length + 1) == (name + '=')) {
							cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
							break;
						}
					}
				}
				return cookieValue;
			}
		},
		browser:function(){var bwTest=(function(){var undef,v=5,div=document.createElement("div"),all=div.getElementsByTagName("i");while(div.innerHTML="<!--[if gt IE "+(++v)+"]><i></i><![endif]-->",all[0]){alert(v);return v>=6?v:undef}}());return{version:bwTest || 0,msie:!!bwTest,ie6:!!bwTest&&bwTest==6,ie7:!!bwTest&&bwTest==7,ie8:!!bwTest&&bwTest==8,ie9:!!bwTest&&bwTest==9,ie8d:!!bwTest&&!!document.documentMode}},
		isUndefined:function(a){return typeof a=="undefined"? !0 : !1;},//任何值为0、null、未定义或空字符串的表达式被解释为 !1
		empty:function(e,c){var d=c||!1;e=e||"";e=this.trim(e);if(!d){return(e.length<1)?!0:!1;}else{return(!e||e==0)?!0:!1;}},
		isEmpty:function(e,c){return this.empty(e,c);},
		in_array:function(c,b){if(typeof c=="string"||typeof c=="number"){for(var a in b){if(b[a]==c){return !0;}}}return !1;},
		preg_match:function(a,b){return a.test(b);},
		trim:function(a){return (a+"").replace(/(\s+)$/g,"").replace(/^\s+/g,"");},
		preg_replace:function(e,d,f,b){var b=!b?"ig":b,a=e.length;for(var c=0;c<a;c++){re=new RegExp(e[c],b);f=f.replace(re,typeof d=="string"?d:(d[c]?d[c]:d[0]));}return f;},
		isPhone:function(c){var a=/^(0\d{2,3}-?)?[2-9]\d{6,7}$/,b=/^1[3-9]{1}[0-9]{9}$/;return a.test(c)||b.test(c);},
		htmlencode:function(a){return this.preg_replace(["&","<",">",'"'],["&amp;","&lt;","&gt;","&quot;"],a);},
		isEmail:function(a){return a.length>6&&this.preg_match(/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/gi,a)?!0:!1;},
		str_pad:function(d,a){var b=new Array();for(var c=0;c<a;c++){b.push(d);}return b.join("");},
		intval:function(h,b){var f=b||0,c=0,h=h||f;try{c=parseInt(h,10);c=isNaN(c)?f:c;}catch(g){c=f;}return c;},
		floatval:function(i,h,c){var g=c||0,b=h||0,d=0,i=i||g;try{d=parseFloat(i);d=isNaN(d)?g:d;}catch(j){d=g;}return Number(d.toFixed(b));},
		strlen:function(a){return(!-[1,]&&a.indexOf("\n")!=-1)?a.replace(/\r?\n/g,"_").length:a.length;},
		$:function(d){return document.getElementById(d);},
		$N:function(c){return document.getElementsByName(c);},
		addStyle:function(css){if(this.browser.msie&&8>this.browser.version){css=css.replace(/opacity:\s*(\d?\.\d+)/g,function($,$1){$1=parseFloat($1)*100;if($1<0||$1>100){return""}return"filter:alpha(opacity="+$1+");"})}css+="\n";var doc=document,head=doc.getElementsByTagName("head")[0],styles=head.getElementsByTagName("style"),style,media;if(styles.length==0){if(doc.createStyleSheet){doc.createStyleSheet()}else{style=doc.createElement("style");style.setAttribute("type","text/css");head.insertBefore(style,null)}}style=styles[0];media=style.getAttribute("media");if(media===null&&!/screen/i.test(media)){style.setAttribute("media","all")}if(style.styleSheet){style.styleSheet.cssText+=css}else{if(doc.getBoxObjectFor){style.innerHTML+=css}else{style.appendChild(doc.createTextNode(css))}};},
		addAjaxframe:function(){if(!this.$("ajaxframe")){var o=document.body;var ajaxframe=document.createElement("DIV");ajaxframe.id="ajaxframe";var ajaxtip=document.createElement("DIV");ajaxtip.id="ajaxtip";o.insertBefore(ajaxtip,o.firstChild);o.insertBefore(ajaxframe,ajaxtip);var aw_lock=document.createElement("DIV");aw_lock.id="ajaxwait_lock";var aw=document.createElement("DIV");aw.id="ajaxwait";aw.innerHTML="正在获取数据...";o.appendChild(aw_lock);o.appendChild(aw);this.addStyle("#ajaxframe{display:none;z-index:100}#ajaxtip{display:none;z-index:101;position:fixed;left:50%;margin-left:-160px;top:30.9%;padding:20px 10px;min-width:320px;text-align:center;background:#900;color:#fff;border:1px solid #929292;border-radius:5px;box-shadow:0 3px 8px rgba(0,0,0,.2);-moz-transition:-moz-box-shadow linear .2s;-webkit-transition:-webkit-box-shadow linear .2s;transition:-webkit-box-shadow linear .2s}#ajaxwait{position:fixed;background-color:#000;color:#FFF;display:none;height:auto;min-width:300px;padding:5px;z-index:999999;height:60px;line-height:60px;border:1px solid #333;border-radius:5px;box-shadow:0 3px 8px rgba(0,0,0,.2);-moz-transition:-moz-box-shadow linear .2s;-webkit-transition:-webkit-box-shadow linear .2s;transition:-webkit-box-shadow linear .2s}#ajaxwait_lock{position:fixed;width:100%;height:100%;left:0;top:0;z-index:999998;background-color:#000;filter:alpha(opacity=80);-moz-opacity:.8;-khtml-opacity:.8;opacity:.8;display:none;visibility:hidden}")};},
		hideTip:function(){jQuery("#ajaxtip").hide()},
		showTip:function(a,b,c){b = b || 0;jQuery("#ajaxtip").html(a).show();!b || setTimeout(function(){pChen.hideTip();if(typeof c=="function") c();},b)},
		parseJson:function(b){b = b || '{"msg":"Parse error:Page error or data returned empty!","status":"-1","data":"0"}';var a ={msg:"Parse error:Page error or data returned empty!",status:"-1",data:"0"};try{a = jQuery.parseJSON(b)}catch(d){if(!this.empty(b)){var c = b.indexOf('{"msg"');if(c>0){b = b.substr(c)}else{b = '{"msg":data,"status":"0","data":"0"}'}try{a = jQuery.parseJSON(b)}catch(d){a ={msg:"Parse error:Page error or data returned empty!",status:"-1",data:"0"}}}}return a},
		showWait:function(j){var g = this.isUndefined(j.data) ? "正在获取数据...":j.data;var i = this.isUndefined(j.lock) ? 0:1;var d = this.isUndefined(j.pos) ? "topRight":j.pos;var e = this.isUndefined(j.css) ? "":j.css;var a = jQuery("#ajaxwait");var f = iH = "";a.html(g);f =(0 -(a.outerWidth()>>1))+"px";iH =(0 -(a.outerHeight()>>1))+"px";switch(d){case "topLeft":a.css({top:0,left:0});break;case "topMiddle":a.css({top:0,left:"50%","margin-left":f});break;case "middleLeft":a.css({top:"30%",left:0});break;case "middle":a.css({top:(50 * .618)+"%",left:"50%","margin-left":f,"margin-top":iH});break;case "middleRight":a.css({top:"30%",right:0});break;case "bottomLeft":owa.css({bottom:0,left:0});break;case "bottomMiddle":a.css({bottom:0,left:"50%","margin-left":f});break;case "bottomRight":a.css({bottom:0,right:0});break;default:a.css({top:0,right:0})}if(i){this.showLock()}if(!this.empty(e)){var h = e.split(";");for(var b = 0;b < h.length;b++){var c = h[b].split(":");if(c.length>1){a.css(c[0],c[1])}}}a.show()},
		hideWait:function(){this.hideLock();jQuery("<div id='ajaxwait'></div>").replaceAll("#ajaxwait").hide()},
		showLock:function(){jQuery("#ajaxwait_lock").show()},
		hideLock:function(){jQuery("#ajaxwait_lock").hide()},
		getUrlVal:function(name,defv){var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"),v=defv || null,r = window.location.search.substr(1).match(reg); 
			if(r!=null){
				return  unescape(r[2]);
			}
			return v; 
		},
		/*增加AjaxWindow功能*/
		AjaxWindow:function(T,data,fndone,fnback,fnclose){
			if(pChen.isUndefined(T)){return;}
			var winid=pChen.isUndefined(T['winid'])? 'Xh_AjaxOxWindow' : T['winid'];
			if(jQuery('#'+winid).size()){
				pChen.XhAjaxHideWindow(winid);
			}
			var d=document.createElement("div");
				d.id=winid;
				d.style.position="fixed";
				d.style.backgroundColor="#FF0000";
				d.style.visibiliy="hidden";
				d.style.height= "auto";
				d.style.width="120px";
				d.style.right="0";
				d.style.top="0";
				
				d.innerHTML='正在获取数据...';
				document.body.appendChild(d);
				if(!pChen.isUndefined(T['url'])){
					mothed=(pChen.isUndefined(T['mothed']) || T['mothed']=='POST')? 'POST' : 'GET';
					jQuery.ajax({
					   type: mothed,
					   url: T['url'],
					   data: T['parm']+'&_trnd_='+Math.random(),
					   cache: false,
					   dataType: "html",
					   success: function(re){
						if(pChen.isUndefined(re) || re==0){
							re='没有获得有效数据!';
							pChen.XhAjaxOxWriteHtml(T,re,fnback,fnclose);
						}else{
							pChen.XhAjaxOxWriteHtml(T,re,fnback,fnclose);
							if(typeof(fndone)=='function'){
								s=fndone();
							} else {
								s=eval(fndone);
							}
						}
					   },
					   error:function(){
							pChen.XhAjaxOxWriteHtml({'title':'响应失败','width':200,'height':60,'posid':T['posid']},'获取数据出错',fnback,fnclose);
					   }
					}); 
				}else if(!pChen.isUndefined(data) && !pChen.empty(data)){
					pChen.XhAjaxOxWriteHtml(T,data,fnback,fnclose);
					if(typeof(fndone)=='function'){
						s=fndone();
					} else {
						s=eval(fndone);
					}
					
				}else{
					data=jQuery('#'+T['sid']).html();
					pChen.XhAjaxOxWriteHtml(T,data,fnback,fnclose);
					if(typeof(fndone)=='function'){
						s=fndone();
					} else {
						s=eval(fndone);
					}
				}
					
		},
		XhAjaxOxWriteHtml:function(T,data,fnback,fnclose) {
			var winid=pChen.isUndefined(T['winid'])? 'Xh_AjaxOxWindow' : T['winid'];
			if(jQuery('#'+winid).size()){
				pChen.XhAjaxHideWindow(winid);
			}
			var height=pChen.isUndefined(T['height'])? NaN : parseInt(T['height']);
			var width=pChen.isUndefined(T['width'])? NaN : (20<data.length)? parseInt(T['width']) : 200;
			//if(20>len(data)){width=100;}
			var dvHeight=isNaN(parseInt(height))? 'auto' : (height+60)+'px';
			var dvWidth=isNaN(parseInt(width))? 'auto' : (width+10) + "px";
			var title=pChen.isUndefined(T['title'])? '' : T['title'];
			var istitleBar=pChen.isUndefined(T['bar'])? 1 : parseInt(T['bar']);
			var isclose=pChen.isUndefined(T['close'])? 1 : parseInt(T['close']);
			var closebar=pChen.isUndefined(T['closebar'])? 0 : parseInt(T['closebar']);
			var autohide=!pChen.isUndefined(T['timeout'])? (' onblur="setTimeout(function(){pChen.XhAjaxHideWindow(\'"+winid+"\');},'+ T['timeout']+')"') : '';
			var leavehide=pChen.isUndefined(T['leavehide'])? '' : T['leavehide'];
			
			var bord=pChen.isUndefined(T['bord'])? '6' : parseInt(T['bord']);
				bord=isNaN(bord)? 0 : bord;
			
			var d=document.createElement("div");
				d.id=winid;
				d.style.position="absolute";
				d.style.backgroundColor="#FFF";
			if(bord==0){
				d.style.border="none";
			}else{
				d.style.border=bord+"px solid #666";
			}
				d.style.visibiliy="hidden";
				d.style.display="none";
				d.style.height=dvHeight;
			if(dvHeight!='auto'){
				d.style.overflow='auto';
			}
				d.style.width=dvWidth;
				d.style.top="0px";
				d.style.left="0px";
				d.className=pChen.isUndefined(T['class'])? 'Xh_AjaxOxWindow' : T['class'];
			var txt="";
			if(istitleBar){
				txt+="<div id='Xh_AjOx_title'><div style='float:left;'>"+title+"</div>";
			if(isclose){
				txt+="<div style='float:right;'><a href='javascript:pChen.XhAjaxHideWindow(\""+winid+"\")' title='关闭'><img src='/i/close.gif' /></a></div>";
			}
				txt+="<div class='clearfix'></div></div>";
			}
				txt+="<div id=\"Xh_AjOx_content\""+autohide+">"+data+"</div>";
				txt+="</div>";
			if(closebar){
				txt+="<div align=center id='Xh_AjOx_barEx'><a href='javascript:pChen.XhAjaxHideWindow(\""+winid+"\");'>[关闭]</a></div>";
			}
				d.innerHTML = txt;
				document.body.appendChild(d);
				
				if(!pChen.isUndefined(fnclose)){jQuery("#"+winid).data('fnclose',fnclose);}
				if(!pChen.empty(leavehide)){jQuery("#"+winid).bind(leavehide,function(){pChen.XhAjaxHideWindow(winid);});}
				if(typeof(fnback)=='function'){
					fnback();
				} else {
					eval(fnback);
				}
				
				pChen.XhAjOxSetWinPos(T['posid'],T);
				if(!pChen.isUndefined(T['timeout'])){
				jQuery(T['posid']).one('blur',function(){setTimeout(function(){pChen.XhAjaxHideWindow(winid);},T['timeout']);});
				}
		},
		XhAjOxSetWinPos:function(obj,T,curobj){
				var winid=pChen.isUndefined(T['winid'])? 'Xh_AjaxOxWindow' : T['winid'];
				var curOBJ=pChen.isUndefined(curobj)? jQuery('#'+winid) : jQuery(curobj);
				var scrollTop = jQuery(document).scrollTop();
				var scrollLeft = jQuery(document).scrollLeft();
				var offsetPos=jQuery(obj).offset();
				var poffH=parseInt(jQuery(obj).height());
				var poffW=parseInt(jQuery(obj).width());
				var pwinH=parseInt(curOBJ.height());
				var pwinW=parseInt(curOBJ.width());
				var winH=jQuery(window).height();
				var winW=jQuery(window).width();
		
				var showType=pChen.isUndefined(T['slide'])? 'none' : T['slide'];
		
				if(((winH+scrollTop)-(offsetPos.top+poffH))<pwinH){
					
					var calTop=offsetPos.top-pwinH+Math.floor(poffH/2);
					if(0>=calTop){
						var calTop=offsetPos.top+poffH;
					}else{
						showType='fadeIn';
					}
				}else{
					var calTop=offsetPos.top+poffH;
				}
				//if((jQuery(document).width()-(offsetPos.left+poffW-scrollLeft))>pwinW){
				if(((winW+scrollLeft)-(offsetPos.left+poffW))>pwinW){
					var calLeft=offsetPos.left;
				}else{
					var calLeft=offsetPos.left-pwinW+poffW;
					if(0>=calLeft){
						calLeft=Math.floor(jQuery(document).width()/2)-Math.floor(pwinW/2);
					}
				}
				   curOBJ.css({'left':calLeft,'top':calTop});
				   switch(showType){
					case 'toggle':
						curOBJ.toggle('fast','linear');
						break;
					case 'slideUp':
						curOBJ.fadeIn('fast');
						break;
					default:
						curOBJ.slideDown('fast');
				   }
				
			//}
		},
		XhAjaxHideWindow:function(id){
			var winid=pChen.isUndefined(id)? jQuery("#Xh_AjaxOxWindow") : jQuery("#"+id);
			if(winid){
				var fn=winid.data('fnclose');
				winid.toggle('fast');
				winid.remove();
				if(typeof(fn)=='function'){
					fn();
				} else {
					eval(fn);
				}
			}
		}
	};
	win.pChen=this._pChen || (this._pChen=new pChen());
})(window);