$(document).ready(function(){

    //Url Padrão do Site
    base_url = base_url();

    $('.nyroModal').click(function(e) {
            e.preventDefault();
            $(this).nyroModalManual();
    });

    $("a[rel*='gallery']").click(function(e){
            e.preventDefault();
    });

     //Máscaras Javascript
    $('input:text').setMask();
    
    //Links para voltar à página anterior
    $('a[rel="voltar"]').click(function(){
        history.back();
        return false;
    });
    
    //Links para abrirem em uma página nova
    $('a[rel="externo"]').each(function(){
        $(this).attr('target','_blank');
    });

    //Validação de Somente Número
    $('.numero').each(function(){
        $(this).keypress(function(e){
            if(e.which!=8 && e.which!=0 && e.which!=46 && (e.which<48 || e.which>57)){
                return false;
            }
        });
    });

    //Validação de Somente Letras
    $('.letra').each(function(){
        $(this).keypress(function(e){
            if((e.which > 64 && e.which < 91) || (e.which > 96 && e.which < 123) || e.which == 8 || e.which == 0 || (e.which > 224 && e.which < 251)) {
                return true;
            } else {
                return false;
            }
        });
    });
    
    //Validação de Somente Letras
    $('.query').each(function(){
        $(this).keypress(function(e){
            if((e.which > 64 && e.which < 91) || (e.which > 96 && e.which < 123) || (e.which > 47 && e.which < 52) || e.which == 8 || e.which == 32 || e.which == 0 || e.which == 13 || (e.which > 224 && e.which < 251)) {
                return true;
            } else {
                return false;
            }
        });
    });

});

/**
 * Função que calcula a altura da página
 *
 * @return int
 */
function getPageHeight(){

	var windowHeight

	if (self.innerHeight) {	// all except Explorer
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowHeight = document.body.clientHeight;
	}

	return windowHeight;

}


/**
 * Função que determina a URL Padrão do Site
 * @return string
 */
function base_url(){

    baseUrl = '';

    if($('base').length > 0){
        baseUrl = $('base').attr('href');
    }

    return baseUrl;
}

/*
* get base rel
*/
function get_base_rel() {
	if($('base').attr('rel') == '' || $('base').attr('rel') == 'undefined' || $('base').attr('rel') == null )
		return '';
	else
		return $('base').attr('rel');																	
}

/**
 * Função que valida o CPF
 * @return boolean
 */
function checaCPF(CPF){

	if (CPF.charAt(3) == '.') {
		CPF = CPF.substr(0,3) + CPF.substr(4);
	}
	if (CPF.charAt(6) == '.') {
		CPF = CPF.substr(0,6) + CPF.substr(7);
	}
	if (CPF.charAt(9) == '-') {
		CPF = CPF.substr(0,9) + CPF.substr(10);
	}

	if (CPF.length != 11 || CPF == "00000000000" || CPF == "11111111111" ||
	CPF == "22222222222" || CPF == "33333333333" || CPF == "44444444444" ||
	CPF == "55555555555" || CPF == "66666666666" || CPF == "77777777777" ||
	CPF == "88888888888" || CPF == "99999999999")
		return false;

	soma = 0;
	for (i=0; i < 9; i ++)
		soma += parseInt(CPF.charAt(i)) * (10 - i);
	resto = 11 - (soma % 11);
	if (resto == 10 || resto == 11)
		resto = 0;
	if (resto != parseInt(CPF.charAt(9)))
		return false;
	soma = 0;
	for (i = 0; i < 10; i ++)
		soma += parseInt(CPF.charAt(i)) * (11 - i);
	resto = 11 - (soma % 11);
	if (resto == 10 || resto == 11)
		resto = 0;
	if (resto != parseInt(CPF.charAt(10)))
		return false;

	return true;

}



/*
 * jQuery Autocomplete plugin 1.1
 *
 * Copyright (c) 2009 Jörn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Revision: $Id: jquery.autocomplete.js 15 2009-08-22 10:30:27Z joern.zaefferer $
 */;(function($){$.fn.extend({autocomplete:function(urlOrData,options){var isUrl=typeof urlOrData=="string";options=$.extend({},$.Autocompleter.defaults,{url:isUrl?urlOrData:null,data:isUrl?null:urlOrData,delay:isUrl?$.Autocompleter.defaults.delay:10,max:options&&!options.scroll?10:150},options);options.highlight=options.highlight||function(value){return value;};options.formatMatch=options.formatMatch||options.formatItem;return this.each(function(){new $.Autocompleter(this,options);});},result:function(handler){return this.bind("result",handler);},search:function(handler){return this.trigger("search",[handler]);},flushCache:function(){return this.trigger("flushCache");},setOptions:function(options){return this.trigger("setOptions",[options]);},unautocomplete:function(){return this.trigger("unautocomplete");}});$.Autocompleter=function(input,options){var KEY={UP:38,DOWN:40,DEL:46,TAB:9,RETURN:13,ESC:27,COMMA:188,PAGEUP:33,PAGEDOWN:34,BACKSPACE:8};var $input=$(input).attr("autocomplete","off").addClass(options.inputClass);var timeout;var previousValue="";var cache=$.Autocompleter.Cache(options);var hasFocus=0;var lastKeyPressCode;var config={mouseDownOnSelect:false};var select=$.Autocompleter.Select(options,input,selectCurrent,config);var blockSubmit;$.browser.opera&&$(input.form).bind("submit.autocomplete",function(){if(blockSubmit){blockSubmit=false;return false;}});$input.bind(($.browser.opera?"keypress":"keydown")+".autocomplete",function(event){hasFocus=1;lastKeyPressCode=event.keyCode;switch(event.keyCode){case KEY.UP:event.preventDefault();if(select.visible()){select.prev();}else{onChange(0,true);}break;case KEY.DOWN:event.preventDefault();if(select.visible()){select.next();}else{onChange(0,true);}break;case KEY.PAGEUP:event.preventDefault();if(select.visible()){select.pageUp();}else{onChange(0,true);}break;case KEY.PAGEDOWN:event.preventDefault();if(select.visible()){select.pageDown();}else{onChange(0,true);}break;case options.multiple&&$.trim(options.multipleSeparator)==","&&KEY.COMMA:case KEY.TAB:case KEY.RETURN:if(selectCurrent()){event.preventDefault();blockSubmit=true;return false;}break;case KEY.ESC:select.hide();break;default:clearTimeout(timeout);timeout=setTimeout(onChange,options.delay);break;}}).focus(function(){hasFocus++;}).blur(function(){hasFocus=0;if(!config.mouseDownOnSelect){hideResults();}}).click(function(){if(hasFocus++>1&&!select.visible()){onChange(0,true);}}).bind("search",function(){var fn=(arguments.length>1)?arguments[1]:null;function findValueCallback(q,data){var result;if(data&&data.length){for(var i=0;i<data.length;i++){if(data[i].result.toLowerCase()==q.toLowerCase()){result=data[i];break;}}}if(typeof fn=="function")fn(result);else $input.trigger("result",result&&[result.data,result.value]);}$.each(trimWords($input.val()),function(i,value){request(value,findValueCallback,findValueCallback);});}).bind("flushCache",function(){cache.flush();}).bind("setOptions",function(){$.extend(options,arguments[1]);if("data"in arguments[1])cache.populate();}).bind("unautocomplete",function(){select.unbind();$input.unbind();$(input.form).unbind(".autocomplete");});function selectCurrent(){var selected=select.selected();if(!selected)return false;var v=selected.result;previousValue=v;if(options.multiple){var words=trimWords($input.val());if(words.length>1){var seperator=options.multipleSeparator.length;var cursorAt=$(input).selection().start;var wordAt,progress=0;$.each(words,function(i,word){progress+=word.length;if(cursorAt<=progress){wordAt=i;return false;}progress+=seperator;});words[wordAt]=v;v=words.join(options.multipleSeparator);}v+=options.multipleSeparator;}$input.val(v);hideResultsNow();$input.trigger("result",[selected.data,selected.value]);return true;}function onChange(crap,skipPrevCheck){if(lastKeyPressCode==KEY.DEL){select.hide();return;}var currentValue=$input.val();if(!skipPrevCheck&&currentValue==previousValue)return;previousValue=currentValue;currentValue=lastWord(currentValue);if(currentValue.length>=options.minChars){$input.addClass(options.loadingClass);if(!options.matchCase)currentValue=currentValue.toLowerCase();request(currentValue,receiveData,hideResultsNow);}else{stopLoading();select.hide();}};function trimWords(value){if(!value)return[""];if(!options.multiple)return[$.trim(value)];return $.map(value.split(options.multipleSeparator),function(word){return $.trim(value).length?$.trim(word):null;});}function lastWord(value){if(!options.multiple)return value;var words=trimWords(value);if(words.length==1)return words[0];var cursorAt=$(input).selection().start;if(cursorAt==value.length){words=trimWords(value)}else{words=trimWords(value.replace(value.substring(cursorAt),""));}return words[words.length-1];}function autoFill(q,sValue){if(options.autoFill&&(lastWord($input.val()).toLowerCase()==q.toLowerCase())&&lastKeyPressCode!=KEY.BACKSPACE){$input.val($input.val()+sValue.substring(lastWord(previousValue).length));$(input).selection(previousValue.length,previousValue.length+sValue.length);}};function hideResults(){clearTimeout(timeout);timeout=setTimeout(hideResultsNow,200);};function hideResultsNow(){var wasVisible=select.visible();select.hide();clearTimeout(timeout);stopLoading();if(options.mustMatch){$input.search(function(result){if(!result){if(options.multiple){var words=trimWords($input.val()).slice(0,-1);$input.val(words.join(options.multipleSeparator)+(words.length?options.multipleSeparator:""));}else{$input.val("");$input.trigger("result",null);}}});}};function receiveData(q,data){if(data&&data.length&&hasFocus){stopLoading();select.display(data,q);autoFill(q,data[0].value);select.show();}else{hideResultsNow();}};function request(term,success,failure){if(!options.matchCase)term=term.toLowerCase();var data=cache.load(term);if(data&&data.length){success(term,data);}else if((typeof options.url=="string")&&(options.url.length>0)){var extraParams={timestamp:+new Date()};$.each(options.extraParams,function(key,param){extraParams[key]=typeof param=="function"?param():param;});$.ajax({mode:"abort",port:"autocomplete"+input.name,dataType:options.dataType,url:options.url,data:$.extend({q:lastWord(term),limit:options.max},extraParams),success:function(data){var parsed=options.parse&&options.parse(data)||parse(data);cache.add(term,parsed);success(term,parsed);}});}else{select.emptyList();failure(term);}};function parse(data){var parsed=[];var rows=data.split("\n");for(var i=0;i<rows.length;i++){var row=$.trim(rows[i]);if(row){row=row.split("|");parsed[parsed.length]={data:row,value:row[0],result:options.formatResult&&options.formatResult(row,row[0])||row[0]};}}return parsed;};function stopLoading(){$input.removeClass(options.loadingClass);};};$.Autocompleter.defaults={inputClass:"ac_input",resultsClass:"ac_results",loadingClass:"ac_loading",minChars:1,delay:400,matchCase:false,matchSubset:true,matchContains:false,cacheLength:10,max:100,mustMatch:false,extraParams:{},selectFirst:true,formatItem:function(row){return row[0];},formatMatch:null,autoFill:false,width:0,multiple:false,multipleSeparator:", ",highlight:function(value,term){return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi,"\\$1")+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>");},scroll:true,scrollHeight:180};$.Autocompleter.Cache=function(options){var data={};var length=0;function matchSubset(s,sub){if(!options.matchCase)s=s.toLowerCase();var i=s.indexOf(sub);if(options.matchContains=="word"){i=s.toLowerCase().search("\\b"+sub.toLowerCase());}if(i==-1)return false;return i==0||options.matchContains;};function add(q,value){if(length>options.cacheLength){flush();}if(!data[q]){length++;}data[q]=value;}function populate(){if(!options.data)return false;var stMatchSets={},nullData=0;if(!options.url)options.cacheLength=1;stMatchSets[""]=[];for(var i=0,ol=options.data.length;i<ol;i++){var rawValue=options.data[i];rawValue=(typeof rawValue=="string")?[rawValue]:rawValue;var value=options.formatMatch(rawValue,i+1,options.data.length);if(value===false)continue;var firstChar=value.charAt(0).toLowerCase();if(!stMatchSets[firstChar])stMatchSets[firstChar]=[];var row={value:value,data:rawValue,result:options.formatResult&&options.formatResult(rawValue)||value};stMatchSets[firstChar].push(row);if(nullData++<options.max){stMatchSets[""].push(row);}};$.each(stMatchSets,function(i,value){options.cacheLength++;add(i,value);});}setTimeout(populate,25);function flush(){data={};length=0;}return{flush:flush,add:add,populate:populate,load:function(q){if(!options.cacheLength||!length)return null;if(!options.url&&options.matchContains){var csub=[];for(var k in data){if(k.length>0){var c=data[k];$.each(c,function(i,x){if(matchSubset(x.value,q)){csub.push(x);}});}}return csub;}else
if(data[q]){return data[q];}else
if(options.matchSubset){for(var i=q.length-1;i>=options.minChars;i--){var c=data[q.substr(0,i)];if(c){var csub=[];$.each(c,function(i,x){if(matchSubset(x.value,q)){csub[csub.length]=x;}});return csub;}}}return null;}};};$.Autocompleter.Select=function(options,input,select,config){var CLASSES={ACTIVE:"ac_over"};var listItems,active=-1,data,term="",needsInit=true,element,list;function init(){if(!needsInit)return;element=$("<div/>").hide().addClass(options.resultsClass).css("position","absolute").appendTo(document.body);list=$("<ul/>").appendTo(element).mouseover(function(event){if(target(event).nodeName&&target(event).nodeName.toUpperCase()=='LI'){active=$("li",list).removeClass(CLASSES.ACTIVE).index(target(event));$(target(event)).addClass(CLASSES.ACTIVE);}}).click(function(event){$(target(event)).addClass(CLASSES.ACTIVE);select();input.focus();return false;}).mousedown(function(){config.mouseDownOnSelect=true;}).mouseup(function(){config.mouseDownOnSelect=false;});if(options.width>0)element.css("width",options.width);needsInit=false;}function target(event){var element=event.target;while(element&&element.tagName!="LI")element=element.parentNode;if(!element)return[];return element;}function moveSelect(step){listItems.slice(active,active+1).removeClass(CLASSES.ACTIVE);movePosition(step);var activeItem=listItems.slice(active,active+1).addClass(CLASSES.ACTIVE);if(options.scroll){var offset=0;listItems.slice(0,active).each(function(){offset+=this.offsetHeight;});if((offset+activeItem[0].offsetHeight-list.scrollTop())>list[0].clientHeight){list.scrollTop(offset+activeItem[0].offsetHeight-list.innerHeight());}else if(offset<list.scrollTop()){list.scrollTop(offset);}}};function movePosition(step){active+=step;if(active<0){active=listItems.size()-1;}else if(active>=listItems.size()){active=0;}}function limitNumberOfItems(available){return options.max&&options.max<available?options.max:available;}function fillList(){list.empty();var max=limitNumberOfItems(data.length);for(var i=0;i<max;i++){if(!data[i])continue;var formatted=options.formatItem(data[i].data,i+1,max,data[i].value,term);if(formatted===false)continue;var li=$("<li/>").html(options.highlight(formatted,term)).addClass(i%2==0?"ac_even":"ac_odd").appendTo(list)[0];$.data(li,"ac_data",data[i]);}listItems=list.find("li");if(options.selectFirst){listItems.slice(0,1).addClass(CLASSES.ACTIVE);active=0;}if($.fn.bgiframe)list.bgiframe();}return{display:function(d,q){init();data=d;term=q;fillList();},next:function(){moveSelect(1);},prev:function(){moveSelect(-1);},pageUp:function(){if(active!=0&&active-8<0){moveSelect(-active);}else{moveSelect(-8);}},pageDown:function(){if(active!=listItems.size()-1&&active+8>listItems.size()){moveSelect(listItems.size()-1-active);}else{moveSelect(8);}},hide:function(){element&&element.hide();listItems&&listItems.removeClass(CLASSES.ACTIVE);active=-1;},visible:function(){return element&&element.is(":visible");},current:function(){return this.visible()&&(listItems.filter("."+CLASSES.ACTIVE)[0]||options.selectFirst&&listItems[0]);},show:function(){var offset=$(input).offset();element.css({width:typeof options.width=="string"||options.width>0?options.width:$(input).width(),top:offset.top+input.offsetHeight,left:offset.left}).show();if(options.scroll){list.scrollTop(0);list.css({maxHeight:options.scrollHeight,overflow:'auto'});if($.browser.msie&&typeof document.body.style.maxHeight==="undefined"){var listHeight=0;listItems.each(function(){listHeight+=this.offsetHeight;});var scrollbarsVisible=listHeight>options.scrollHeight;list.css('height',scrollbarsVisible?options.scrollHeight:listHeight);if(!scrollbarsVisible){listItems.width(list.width()-parseInt(listItems.css("padding-left"))-parseInt(listItems.css("padding-right")));}}}},selected:function(){var selected=listItems&&listItems.filter("."+CLASSES.ACTIVE).removeClass(CLASSES.ACTIVE);return selected&&selected.length&&$.data(selected[0],"ac_data");},emptyList:function(){list&&list.empty();},unbind:function(){element&&element.remove();}};};$.fn.selection=function(start,end){if(start!==undefined){return this.each(function(){if(this.createTextRange){var selRange=this.createTextRange();if(end===undefined||start==end){selRange.move("character",start);selRange.select();}else{selRange.collapse(true);selRange.moveStart("character",start);selRange.moveEnd("character",end);selRange.select();}}else if(this.setSelectionRange){this.setSelectionRange(start,end);}else if(this.selectionStart){this.selectionStart=start;this.selectionEnd=end;}});}var field=this[0];if(field.createTextRange){var range=document.selection.createRange(),orig=field.value,teststring="<->",textLength=range.text.length;range.text=teststring;var caretAt=field.value.indexOf(teststring);field.value=orig;this.selection(caretAt,caretAt+textLength);return{start:caretAt,end:caretAt+textLength}}else if(field.selectionStart!==undefined){return{start:field.selectionStart,end:field.selectionEnd}}};})(jQuery);

/*
*jQuery browser plugin detection 1.0.2
* http://plugins.jquery.com/project/jqplugin
* Checks for plugins / mimetypes supported in the browser extending the jQuery.browser object
* Copyright (c) 2008 Leonardo Rossetti motw.leo@gmail.com
* MIT License: http://www.opensource.org/licenses/mit-license.php
  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
*/

(function($){if(typeof $.browser==="undefined"||!$.browser){var browser={};$.extend(browser);}var pluginList={flash:{activex:"ShockwaveFlash.ShockwaveFlash",plugin:/flash/gim},sl:{activex:["AgControl.AgControl"],plugin:/silverlight/gim},pdf:{activex:"PDF.PdfCtrl",plugin:/adobe\s?acrobat/gim},qtime:{activex:"QuickTime.QuickTime",plugin:/quicktime/gim},wmp:{activex:"WMPlayer.OCX",plugin:/(windows\smedia)|(Microsoft)/gim},shk:{activex:"SWCtl.SWCtl",plugin:/shockwave/gim},rp:{activex:"RealPlayer",plugin:/realplayer/gim},java:{activex:navigator.javaEnabled(),plugin:/java/gim}};var isSupported=function(p){if(window.ActiveXObject){try{new ActiveXObject(pluginList[p].activex);$.browser[p]=true;}catch(e){$.browser[p]=false;}}else{$.each(navigator.plugins,function(){if(this.name.match(pluginList[p].plugin)){$.browser[p]=true;return false;}else{$.browser[p]=false;}});}};$.each(pluginList,function(i,n){isSupported(i);});})(jQuery);


/**
 * Função extendida de URLEncode
 *
 * http://www.meiocodigo.com/projects/meiomask/
 *
 */
$.extend({URLEncode:function(c){var o='';var x=0;c=c.toString();var r=/(^[a-zA-Z0-9_.]*)/;
  while(x<c.length){var m=r.exec(c.substr(x));
    if(m!=null && m.length>1 && m[1]!=''){o+=m[1];x+=m[1].length;
    }else{if(c[x]==' ')o+='+';else{var d=c.charCodeAt(x);var h=d.toString(16);
    o+='%'+(h.length<2?'0':'')+h.toUpperCase();}x++;}}return o;},
URLDecode:function(s){var o=s;var binVal,t;var r=/(%[^%]{2})/;
  while((m=r.exec(o))!=null && m.length>1 && m[1]!=''){b=parseInt(m[1].substr(1),16);
  t=String.fromCharCode(b);o=o.replace(m[1],t);}return o;}
});


/**
 * --------------------------------------------------------------------
 * jQuery-Plugin "Flash"
 * Version: 1.1, 11.09.2007
 * by bits
 *
 * Copyright (c) 2009
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
(function(){var b;b=jQuery.fn.flash=function(g,f,d,i){var h=d||b.replace;f=b.copy(b.pluginOptions,f);if(!b.hasFlash(f.version)){if(f.expressInstall&&b.hasFlash(6,0,65)){var e={flashvars:{MMredirectURL:location,MMplayerType:"PlugIn",MMdoctitle:jQuery("title").text()}}}else{if(f.update){h=i||b.update}else{return this}}}g=b.copy(b.htmlOptions,e,g);return this.each(function(){h.call(this,b.copy(g))})};b.copy=function(){var f={},e={};for(var g=0;g<arguments.length;g++){var d=arguments[g];if(d==undefined){continue}jQuery.extend(f,d);if(d.flashvars==undefined){continue}jQuery.extend(e,d.flashvars)}f.flashvars=e;return f};b.hasFlash=function(){if(/hasFlash\=true/.test(location)){return true}if(/hasFlash\=false/.test(location)){return false}var e=b.hasFlash.playerVersion().match(/\d+/g);var f=String([arguments[0],arguments[1],arguments[2]]).match(/\d+/g)||String(b.pluginOptions.version).match(/\d+/g);for(var d=0;d<3;d++){e[d]=parseInt(e[d]||0);f[d]=parseInt(f[d]||0);if(e[d]<f[d]){return false}if(e[d]>f[d]){return true}}return true};b.hasFlash.playerVersion=function(){try{try{var d=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");try{d.AllowScriptAccess="always"}catch(f){return"6,0,0"}}catch(f){}return new ActiveXObject("ShockwaveFlash.ShockwaveFlash").GetVariable("$version").replace(/\D+/g,",").match(/^,?(.+),?$/)[1]}catch(f){try{if(navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin){return(navigator.plugins["Shockwave Flash 2.0"]||navigator.plugins["Shockwave Flash"]).description.replace(/\D+/g,",").match(/^,?(.+),?$/)[1]}}catch(f){}}return"0,0,0"};b.htmlOptions={height:240,flashvars:{},pluginspage:"http://www.adobe.com/go/getflashplayer",src:"#",type:"application/x-shockwave-flash",width:320};b.pluginOptions={expressInstall:false,update:true,version:"6.0.65"};b.replace=function(d){this.innerHTML='<div class="alt">'+this.innerHTML+"</div>";jQuery(this).addClass("flash-replaced").prepend(b.transform(d))};b.update=function(e){var d=String(location).split("?");d.splice(1,0,"?hasFlash=true&");d=d.join("");var f='<p>This content requires the Flash Player. <a href="http://www.adobe.com/go/getflashplayer">Download Flash Player</a>. Already have Flash Player? <a href="'+d+'">Click here.</a></p>';this.innerHTML='<span class="alt">'+this.innerHTML+"</span>";jQuery(this).addClass("flash-update").prepend(f)};function a(){var e="";for(var d in this){if(typeof this[d]!="function"){e+=d+'="'+this[d]+'" '}}return e}function c(){var e="";for(var d in this){if(typeof this[d]!="function"){e+=d+"="+encodeURIComponent(this[d])+"&"}}return e.replace(/&$/,"")}b.transform=function(d){d.toString=a;if(d.flashvars){d.flashvars.toString=c}return"<embed "+String(d)+"/>"};if(window.attachEvent){window.attachEvent("onbeforeunload",function(){__flash_unloadHandler=function(){};__flash_savedUnloadHandler=function(){}})}})();


/**
 * --------------------------------------------------------------------
 * jQuery-Plugin "captalize"
 * Version: 1.1, 11.09.2007
 * by 
 *
 * Copyright (c) 2010
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
 (function($){jQuery.fn.capitalize=function(options){var defaults={capitalize_on:'keyup'};var opts=$.extend(defaults,options);this.each(function(){jQuery(this).bind(defaults.capitalize_on,function(){jQuery(this).val(jQuery.cap(jQuery(this).val()));});});}})(jQuery);jQuery.cap=function capitalizeTxt(txt){txt=txt.toLowerCase();var split_txt=txt.split(' ');var result='';for(var i=0;i<split_txt.length;i++){result=result.concat(' '+split_txt[i].substring(0,1).toUpperCase()+split_txt[i].substring(1,split_txt[i].length));}return result.substring(1,result.length);};



/**
 * --------------------------------------------------------------------
 * jQuery-Plugin "watermark"
 * Version: 1.1, 11.09.2007
 * by bits
 *
 * Copyright (c) 2009
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
watermark={
	init:function(){
			$('input.watermark[type="text"], input.watermark[type="password"], textarea.watermark').focus(
				function(){
					watermark.focus($(this))
			}).blur(
				function(){
					watermark.blur($(this))
			}).each(function(){
				if($(this).attr("type") == 'password') {
					$(this).addClass('watermarkPass');
				} else
					$(this).attr("title",$(this).val()
			)}
	)}
	,focus:function(a){
		val=$(a).val();
		if($(a).val()==$(a).attr("title")) {
			$(a).val("");
			$(a).attr("alt",val);
			if($(a).attr("type") == 'password')
				$(a).removeClass('watermarkPass');
		} 
	}
	,blur:function(a){
		val=$(a).attr("alt");
		if($(a).val()=="") {
			$(a).val(val);
			$(a).attr("alt","");
			if($(a).attr("type") == 'password')
				$(a).addClass('watermarkPass');
		}
	}
};


/**
 * Função máscara javascript para inputs
 *
 * http://www.meiocodigo.com/projects/meiomask/
 *
 */
(function(B){var A=(window.orientation!=undefined);B.extend({mask:{rules:{"z":/[a-z]/,"Z":/[A-Z]/,"a":/[a-zA-Z]/,"*":/[0-9a-zA-Z]/,"@":/[0-9a-zA-ZÃƒÆ'Ã‚Â§ÃƒÆ'Ã¢â‚¬Â¡ÃƒÆ'Ã‚Â¡ÃƒÆ' ÃƒÆ'Ã‚Â£ÃƒÆ'Ã‚Â©ÃƒÆ'Ã‚Â¨ÃƒÆ'Ã‚Â­ÃƒÆ'Ã‚Â¬ÃƒÆ'Ã‚Â³ÃƒÆ'Ã‚Â²ÃƒÆ'Ã‚ÂµÃƒÆ'Ã‚ÂºÃƒÆ'Ã‚Â¹ÃƒÆ'Ã‚Â¼]/},fixedChars:"[(),.:/ -]",keyRepresentation:{8:"backspace",9:"tab",13:"enter",27:"esc",37:"left",38:"up",39:"right",40:"down",46:"delete"},ignoreKeys:[8,9,13,16,17,18,27,33,34,35,36,37,38,39,40,45,46,91,116],iphoneIgnoreKeys:[10,127],signals:["+","-"],options:{attr:"mask",mask:null,type:"fixed",defaultValue:"",signal:false,onInvalid:function(){},onValid:function(){},onOverflow:function(){}},masks:{"phone":{mask:"9999-9999"},"phone-br":{mask:"99 9999-99999"},"phone-us":{mask:"(999) 9999-9999"},"cpf":{mask:"999.999.999-99"},"cnpj":{mask:"99.999.999/9999-99"},"date":{mask:"39/19/9999"},"hour":{mask:"24:60"},"date-us":{mask:"19/39/9999"},"date-cc":{mask:"39/9999"},"cep":{mask:"99999-999"},"hour":{mask:"29:69"},"cc":{mask:"9999 9999 9999 9999"},"integer":{mask:"999.999.999.999",type:"reverse"},"decimal":{mask:"99,999.999.999.999",type:"reverse",defaultValue:"000"},"decimal-us":{mask:"99.999,999,999,999",type:"reverse",defaultValue:"000"},"signed-decimal":{mask:"99,999.999.999.999",type:"reverse",defaultValue:"+000"},"signed-decimal-us":{mask:"99,999.999.999.999",type:"reverse",defaultValue:"+000"}},init:function(){if(!this.hasInit){var C;this.ignore=false;this.fixedCharsReg=new RegExp(this.fixedChars);this.fixedCharsRegG=new RegExp(this.fixedChars,"g");for(C=0;C<=9;C++){this.rules[C]=new RegExp("[0-"+C+"]")}this.hasInit=true}},set:function(G,D){var C=this,E=B(G),F="maxLength";this.init();return E.each(function(){var N=B(this),O=B.extend({},C.options),M=N.attr(O.attr),H="",J=C.__getPasteEvent();H=(typeof D=="string")?D:(M!="")?M:null;if(H){O.mask=H}if(C.masks[H]){O=B.extend(O,C.masks[H])}if(typeof D=="object"){O=B.extend(O,D)}if(B.metadata){O=B.extend(O,N.metadata())}if(O.mask!=null){if(N.data("mask")){C.unset(N)}var I=O.defaultValue,L=N.attr(F),K=(O.type=="reverse");O=B.extend({},O,{maxlength:L,maskArray:O.mask.split(""),maskNonFixedCharsArray:O.mask.replace(C.fixedCharsRegG,"").split(""),defaultValue:I.split("")});if(K){N.css("text-align","right")}if(N.val()!=""){N.val(C.string(N.val(),O))}else{if(I!=""){N.val(C.string(I,O))}}N.data("mask",O);N.removeAttr(F);N.bind("keydown",{func:C._keyDown,thisObj:C},C._onMask).bind("keyup",{func:C._keyUp,thisObj:C},C._onMask).bind("keypress",{func:C._keyPress,thisObj:C},C._onMask).bind(J,{func:C._paste,thisObj:C},C._delayedOnMask)}})},unset:function(D){var C=B(D),E=this;return C.each(function(){var H=B(this);if(H.data("mask")){var F=H.data("mask").maxlength,G=E.__getPasteEvent();if(F!=-1){H.attr("maxLength",F)}H.unbind("keydown",E._onMask).unbind("keypress",E._onMask).unbind("keyup",E._onMask).unbind(G,E._delayedOnMask).removeData("mask")}})},string:function(F,D){this.init();var E={};if(typeof F!="string"){F=String(F)}switch(typeof D){case"string":if(this.masks[D]){E=B.extend(E,this.masks[D])}else{E.mask=D}break;case"object":E=D;break}var C=(E.type=="reverse");this._insertSignal(C,F,E);return this.__maskArray(F.split(""),E.mask.replace(this.fixedCharsRegG,"").split(""),E.mask.split(""),C,E.defaultValue,E.signal)},_onMask:function(C){var E=C.data.thisObj,D={};D._this=C.target;D.$this=B(D._this);if(D.$this.attr("readonly")){return true}D.value=D.$this.val();D.nKey=E.__getKeyNumber(C);D.range=E.__getRangePosition(D._this);D.valueArray=D.value.split("");D.data=D.$this.data("mask");D.reverse=(D.data.type=="reverse");return C.data.func.call(E,C,D)},_delayedOnMask:function(C){C.type="paste";setTimeout(function(){C.data.thisObj._onMask(C)},1)},_keyDown:function(D,E){var C=A?this.iphoneIgnoreKeys:this.ignoreKeys;this.ignore=(B.inArray(E.nKey,C)>-1);if(this.ignore){E.data.onValid.call(E._this,this.keyRepresentation[E.nKey]?this.keyRepresentation[E.nKey]:"",E.nKey)}return A?this._keyPress(D,E):true},_keyUp:function(C,D){if(D.nKey==9&&(B.browser.safari||B.browser.msie)){return true}return this._paste(C,D)},_paste:function(D,E){this._changeSignal(D.type,E);var C=this.__maskArray(E.valueArray,E.data.maskNonFixedCharsArray,E.data.maskArray,E.reverse,E.data.defaultValue,E.data.signal);E.$this.val(C);if(!E.reverse&&E.data.defaultValue.length&&(E.range.start==E.range.end)){this.__setRange(E._this,E.range.start,E.range.end)}return true},_keyPress:function(J,C){if(this.ignore||J.ctrlKey||J.metaKey||J.altKey){return true}this._changeSignal(J.type,C);var K=String.fromCharCode(C.nKey),M=C.range.start,G=C.value,E=C.data.maskArray;if(C.reverse){var F=G.substr(0,M),I=G.substr(C.range.end,G.length);G=(F+K+I);if(C.data.signal&&(M-C.data.signal.length>0)){M-=C.data.signal.length}}var L=G.replace(this.fixedCharsRegG,"").split(""),D=this.__extraPositionsTill(M,E);C.rsEp=M+D;if(!this.rules[E[C.rsEp]]){C.data.onOverflow.call(C._this,K,C.nKey);return false}else{if(!this.rules[E[C.rsEp]].test(K)){C.data.onInvalid.call(C._this,K,C.nKey);return false}else{C.data.onValid.call(C._this,K,C.nKey)}}var H=this.__maskArray(L,C.data.maskNonFixedCharsArray,E,C.reverse,C.data.defaultValue,C.data.signal,D);C.$this.val(H);return(C.reverse)?this._keyPressReverse(J,C):this._keyPressFixed(J,C)},_keyPressFixed:function(C,D){if(D.range.start==D.range.end){if((D.rsEp==0&&D.value.length==0)||D.rsEp<D.value.length){this.__setRange(D._this,D.rsEp,D.rsEp+1)}}else{this.__setRange(D._this,D.range.start,D.range.end)}return true},_keyPressReverse:function(C,D){if(B.browser.msie&&((D.rangeStart==0&&D.range.end==0)||D.rangeStart!=D.range.end)){this.__setRange(D._this,D.value.length)}return false},_setMaskData:function(F,C,E){var D=F.data("mask");D[C]=E;F.data("mask",D)},_changeSignal:function(D,E){if(E.data.signal!==false){var C=(D=="paste")?E.value.substr(0,1):String.fromCharCode(E.nKey);if(B.inArray(C,this.signals)>-1){if(C=="+"){C=""}this._setMaskData(E.$this,"signal",C);E.data.signal=C}}},_insertSignal:function(C,F,E){if(C&&E.defaultValue){if(typeof E.defaultValue=="string"){E.defaultValue=E.defaultValue.split("")}if(B.inArray(E.defaultValue[0],this.signals)>-1){var D=F.substr(0,1);E.signal=(B.inArray(D,this.signals)>-1)?D:E.defaultValue[0];if(E.signal=="+"){E.signal=""}E.defaultValue.shift()}}},__getPasteEvent:function(){return(B.browser.opera||(B.browser.mozilla&&parseFloat(B.browser.version.substr(0,3))<1.9))?"input":"paste"},__getKeyNumber:function(C){return(C.charCode||C.keyCode||C.which)},__maskArray:function(H,G,E,D,C,I,F){if(D){H.reverse()}H=this.__removeInvalidChars(H,G);if(C){H=this.__applyDefaultValue.call(H,C)}H=this.__applyMask(H,E,F);if(D){H.reverse();if(!I||I=="+"){I=""}return I+H.join("").substring(H.length-E.length)}else{return H.join("").substring(0,E.length)}},__applyDefaultValue:function(E){var C=E.length,D=this.length,F;for(F=D-1;F>=0;F--){if(this[F]==E[0]){this.pop()}else{break}}for(F=0;F<C;F++){if(!this[F]){this[F]=E[F]}}return this},__removeInvalidChars:function(E,D){for(var C=0;C<E.length;C++){if(D[C]&&this.rules[D[C]]&&!this.rules[D[C]].test(E[C])){E.splice(C,1);C--}}return E},__applyMask:function(E,C,F){if(typeof F=="undefined"){F=0}for(var D=0;D<E.length+F;D++){if(C[D]&&this.fixedCharsReg.test(C[D])){E.splice(D,0,C[D])}}return E},__extraPositionsTill:function(E,C){var D=0;while(this.fixedCharsReg.test(C[E])){E++;D++}return D},__setRange:function(E,F,C){if(typeof C=="undefined"){C=F}if(E.setSelectionRange){E.setSelectionRange(F,C)}else{var D=E.createTextRange();D.collapse();D.moveStart("character",F);D.moveEnd("character",C-F);D.select()}},__getRangePosition:function(D){if(!B.browser.msie){return{start:D.selectionStart,end:D.selectionEnd}}var E={start:0,end:0},C=document.selection.createRange();E.start=0-C.duplicate().moveStart("character",-100000);E.end=E.start+C.text.length;return E}}});B.fn.extend({setMask:function(C){B.invalid;return B.mask.set(this,C)},unsetMask:function(){return B.mask.unset(this)}})})(jQuery)

/**
 * --------------------------------------------------------------------
 * jQuery-Plugin "pngFix"
 * Version: 1.1, 11.09.2007
 * by Andreas Eberhard, andreas.eberhard@gmail.com
 *                      http://jquery.andreaseberhard.de/
 *
 * Copyright (c) 2007 Andreas Eberhard
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
eval(function(p,a,c,k,e,r){e=function(c){return(c<62?'':e(parseInt(c/62)))+((c=c%62)>35?String.fromCharCode(c+29):c.toString(36))};if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'([237-9n-zA-Z]|1\\w)'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(s(m){3.fn.pngFix=s(c){c=3.extend({P:\'blank.gif\'},c);8 e=(o.Q=="t R S"&&T(o.u)==4&&o.u.A("U 5.5")!=-1);8 f=(o.Q=="t R S"&&T(o.u)==4&&o.u.A("U 6.0")!=-1);p(3.browser.msie&&(e||f)){3(2).B("img[n$=.C]").D(s(){3(2).7(\'q\',3(2).q());3(2).7(\'r\',3(2).r());8 a=\'\';8 b=\'\';8 g=(3(2).7(\'E\'))?\'E="\'+3(2).7(\'E\')+\'" \':\'\';8 h=(3(2).7(\'F\'))?\'F="\'+3(2).7(\'F\')+\'" \':\'\';8 i=(3(2).7(\'G\'))?\'G="\'+3(2).7(\'G\')+\'" \':\'\';8 j=(3(2).7(\'H\'))?\'H="\'+3(2).7(\'H\')+\'" \':\'\';8 k=(3(2).7(\'V\'))?\'float:\'+3(2).7(\'V\')+\';\':\'\';8 d=(3(2).parent().7(\'href\'))?\'cursor:hand;\':\'\';p(2.9.v){a+=\'v:\'+2.9.v+\';\';2.9.v=\'\'}p(2.9.w){a+=\'w:\'+2.9.w+\';\';2.9.w=\'\'}p(2.9.x){a+=\'x:\'+2.9.x+\';\';2.9.x=\'\'}8 l=(2.9.cssText);b+=\'<y \'+g+h+i+j;b+=\'9="W:X;white-space:pre-line;Y:Z-10;I:transparent;\'+k+d;b+=\'q:\'+3(2).q()+\'z;r:\'+3(2).r()+\'z;\';b+=\'J:K:L.t.M(n=\\\'\'+3(2).7(\'n\')+\'\\\', N=\\\'O\\\');\';b+=l+\'"></y>\';p(a!=\'\'){b=\'<y 9="W:X;Y:Z-10;\'+a+d+\'q:\'+3(2).q()+\'z;r:\'+3(2).r()+\'z;">\'+b+\'</y>\'}3(2).hide();3(2).after(b)});3(2).B("*").D(s(){8 a=3(2).11(\'I-12\');p(a.A(".C")!=-1){8 b=a.13(\'url("\')[1].13(\'")\')[0];3(2).11(\'I-12\',\'none\');3(2).14(0).15.J="K:L.t.M(n=\'"+b+"\',N=\'O\')"}});3(2).B("input[n$=.C]").D(s(){8 a=3(2).7(\'n\');3(2).14(0).15.J=\'K:L.t.M(n=\\\'\'+a+\'\\\', N=\\\'O\\\');\';3(2).7(\'n\',c.P)})}return 3}})(3);',[],68,'||this|jQuery||||attr|var|style||||||||||||||src|navigator|if|width|height|function|Microsoft|appVersion|border|padding|margin|span|px|indexOf|find|png|each|id|class|title|alt|background|filter|progid|DXImageTransform|AlphaImageLoader|sizingMethod|crop|blankgif|appName|Internet|Explorer|parseInt|MSIE|align|position|relative|display|inline|block|css|image|split|get|runtimeStyle'.split('|'),0,{}))


/** 
 * flashembed 0.31. Adobe Flash embedding script
 * 
 * http://flowplayer.org/tools/flash-embed.html
 *
 * Copyright (c) 2008 Tero Piirainen (tipiirai@gmail.com)
 *
 * Released under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * >> Basically you can do anything you want but leave this header as is <<
 *
 * version 0.01 - 03/11/2008 
 * version 0.31 - Tue Jul 22 2008 06:30:31 GMT+0200 (GMT+02:00)
 */
function flashembed(root,userParams,flashvars){function getHTML(){var html="";if(typeof flashvars=='function'){flashvars=flashvars();}if(navigator.plugins&&navigator.mimeTypes&&navigator.mimeTypes.length){html='<embed type="application/x-shockwave-flash" ';if(params.id){extend(params,{name:params.id});}for(var key in params){if(params[key]!==null){html+=[key]+'="'+params[key]+'"\n\t';}}if(flashvars){html+='flashvars=\''+concatVars(flashvars)+'\'';}html+='/>';}else{html='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';html+='width="'+params.width+'" height="'+params.height+'"';if(!params.id&&document.all){params.id="_"+(""+Math.random()).substring(5);}if(params.id){html+=' id="'+params.id+'"';}html+='>';html+='\n\t<param name="movie" value="'+params.src+'" />';params.id=params.src=params.width=params.height=null;for(var k in params){if(params[k]!==null){html+='\n\t<param name="'+k+'" value="'+params[k]+'" />';}}if(flashvars){html+='\n\t<param name="flashvars" value=\''+concatVars(flashvars)+'\' />';}html+="</object>";if(debug){alert(html);}}return html;}function init(name){var timer=setInterval(function(){var doc=document;var el=doc.getElementById(name);if(el){flashembed(el,userParams,flashvars);clearInterval(timer);}else if(doc&&doc.getElementsByTagName&&doc.getElementById&&doc.body){clearInterval(timer);}},13);return true;}function extend(to,from){if(from){for(key in from){if(from.hasOwnProperty(key)){to[key]=from[key];}}}}var params={src:'#',width:'100%',height:'100%',version:null,onFail:null,expressInstall:null,debug:false,bgcolor:'#ffffff',allowfullscreen:true,allowscriptaccess:'always',quality:'high',type:'application/x-shockwave-flash',pluginspage:'http://www.adobe.com/go/getflashplayer'};if(typeof userParams=='string'){userParams={src:userParams};}extend(params,userParams);var version=flashembed.getVersion();var required=params.version;var express=params.expressInstall;var debug=params.debug;if(typeof root=='string'){var el=document.getElementById(root);if(el){root=el;}else{return init(root);}}if(!root){return;}if(!required||flashembed.isSupported(required)){params.onFail=params.version=params.expressInstall=params.debug=null;root.innerHTML=getHTML();return root.firstChild;}else if(params.onFail){var ret=params.onFail.call(params,flashembed.getVersion(),flashvars);if(ret){root.innerHTML=ret;}}else if(required&&express&&flashembed.isSupported([6,65])){extend(params,{src:express});flashvars={MMredirectURL:location.href,MMplayerType:'PlugIn',MMdoctitle:document.title};root.innerHTML=getHTML();}else{if(root.innerHTML.replace(/\s/g,'')!==''){}else{root.innerHTML="<h2>Flash version "+required+" or greater is required</h2>"+"<h3>"+(version[0]>0?"Your version is "+version:"You have no flash plugin installed")+"</h3>"+"<p>Download latest version from <a href='"+params.pluginspage+"'>here</a></p>";}}function concatVars(vars){var out="";for(var key in vars){if(vars[key]){out+=[key]+'='+asString(vars[key])+'&';}}return out.substring(0,out.length-1);}function asString(obj){switch(typeOf(obj)){case'string':return'"'+obj.replace(new RegExp('(["\\\\])','g'),'\\$1')+'"';case'array':return'['+map(obj,function(el){return asString(el);}).join(',')+']';case'function':return'"function()"';case'object':var str=[];for(var prop in obj){if(obj.hasOwnProperty(prop)){str.push('"'+prop+'":'+asString(obj[prop]));}}return'{'+str.join(',')+'}';}return String(obj).replace(/\s/g," ").replace(/\'/g,"\"");}function typeOf(obj){if(obj===null||obj===undefined){return false;}var type=typeof obj;return(type=='object'&&obj.push)?'array':type;}if(window.attachEvent){window.attachEvent("onbeforeunload",function(){__flash_unloadHandler=function(){};__flash_savedUnloadHandler=function(){};});}function map(arr,func){var newArr=[];for(var i in arr){if(arr.hasOwnProperty(i)){newArr[i]=func(arr[i]);}}return newArr;}return root;}if(typeof jQuery=='function'){(function($){$.fn.extend({flashembed:function(params,flashvars){return this.each(function(){flashembed(this,params,flashvars);});}});})(jQuery);}flashembed=flashembed||{};flashembed.getVersion=function(){var version=[0,0];if(navigator.plugins&&typeof navigator.plugins["Shockwave Flash"]=="object"){var _d=navigator.plugins["Shockwave Flash"].description;if(typeof _d!="undefined"){_d=_d.replace(/^.*\s+(\S+\s+\S+$)/,"$1");var _m=parseInt(_d.replace(/^(.*)\..*$/,"$1"),10);var _r=/r/.test(_d)?parseInt(_d.replace(/^.*r(.*)$/,"$1"),10):0;version=[_m,_r];}}else if(window.ActiveXObject){try{var _a=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");}catch(e){try{_a=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");version=[6,0];_a.AllowScriptAccess="always";}catch(ee){if(version[0]==6){return;}}try{_a=new ActiveXObject("ShockwaveFlash.ShockwaveFlash");}catch(eee){}}if(typeof _a=="object"){_d=_a.GetVariable("$version");if(typeof _d!="undefined"){_d=_d.replace(/^\S+\s+(.*)$/,"$1").split(",");version=[parseInt(_d[0],10),parseInt(_d[2],10)];}}}return version;};flashembed.isSupported=function(version){var now=flashembed.getVersion();var ret=(now[0]>version[0])||(now[0]==version[0]&&now[1]>=version[1]);return ret;};


/**
 * --------------------------------------------------------------------
 * jQuery-Plugin "Custom Select"
 */
(function($){
 $.fn.extend({
 
 	customStyle : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {
	  
			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="customStyleSelectBox"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));			
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				// selectBoxSpanInner.text($(this).val()).parent().addClass('changed');   This was not ideal
			selectBoxSpanInner.text($(this).find(':selected').text()).parent().addClass('changed');
				// Thanks to Juarez Filho & PaddyMurphy
			});
			
	  });
	  }
	}
 });
})(jQuery);



/**
 * Função Modal 
 * 
 */


$.showModal = function(titulo,url,settings) {
	var defaults = {
		classe: '',
		topo: '50',
		btn_close: true,
		width: '500',
		texto: '',
		textWait: 'carregando'
	}
	
	if (url != '') {
		createModal();
		addLoad();
		addAjaxContent();
	} else {
		createModal();
		close();
		btn_ok();
	}
	
	function addLoad() {
		$('#containerModal .contentModal .bodyModal').html('<div class="content_image"><img src="'+base_url+'assets/frontend/img/loading.gif" class="imgLoad" /><br />'+settings.textWait+'</div>');
		$('#containerModal .contentModal .bodyModal .content_image').css('margin-top','50px').css('margin-bottom','50px');
	}
	
	function addAjaxContent() {
		$.ajax({
			type: "POST",
			url: url,
			success: function(msg){
				$('#containerModal .contentModal .bodyModal').html(msg);
				close();
				btn_ok();
			}
		});
	}
	
	function createModal() { 
		settings = $.extend(defaults, settings);
		
		//FIX SELECT IE6
		$('select').each(function() { 
			if($(this).css('display') != 'none') {
				$(this).addClass('selectOut');
			}
		});
			
		$('input').attr('readonly','readonly');
		
		if($('#containerModal').size() ) {
			$('#containerBody').remove();
			$('#containerModal').remove();
		}
		
		// BASE HTML
		var content = '<div id="containerBody" style="background: #000; z-index:190000; width: 100%; height: '+$('body').height()+'px; position: absolute; top: 0px; left: 0px; -moz-opacity:.65; filter:alpha(opacity=65); opacity:.65; " >&nbsp;</div>';
		content += '<div id="containerModal" class="'+settings.classe+'"> \
					   		<div class="contentModal"> \
					   			<div class="btn_close close">X</div> \
								<div class="bodyModal"></div> \
							</div> \
						</div>';
		$('body').append(content);
		
		if(settings.btn_close == false) 
			$('#containerModal .contentModal .close').remove();
		
		$('#containerModal .contentModal .title').html(titulo);
		$('#containerModal .contentModal .bodyModal').html(settings.texto);
		
		// ATRIBUICOES CSS
		if($.browser.msie && ($.browser.version == "6.0")) {	
			$('#containerModal').css('position','absolute');
			 var total = parseInt(getTopPage())+parseInt(settings.topo);
			$('#containerModal').css('top',total+'px');
			$(window).scroll(function () {
			    var total = parseInt(getTopPage())+parseInt(settings.topo);
			    $('#containerModal').css('top',total+'px');
			});
		} else {
			$('#containerModal').css('position','fixed').css('top',settings.topo+'px');
		}
		
		margin_left = parseInt(settings.width/2);
		$('#containerModal').css('width',settings.width+'px').css('height','auto');
		$('#containerModal').css('left','50%').css('margin-left','-'+margin_left+'px');
		$('#containerModal .contentModal').css('height','auto');
	}
	
	function close() {
		//BTN_CLOSE
		$('#containerModal .close').each(function() { 
			$(this).click(function() {
				$('#containerBody').remove();
				$('#containerModal').remove();
				
				//FIX SELECT
				$('select').each(function() { 
					$(this).removeClass('selectOut');
				});
				
				$('input').attr('readonly','');
				return false;
			});
		});
	}
	
	function btn_ok() {
		//BTN_OK
		$('#containerModal .ok').each(function() { 
			$(this).click(function() {
				//FIX SELECT IE6
				$('select').each(function() { 
					if($(this).is('.selectOut')) {
						$(this).removeClass('selectOut');
					}
				});
			});
		});
	}
	
	function getTopPage() {
		if (self.pageYOffset) {
	      yScroll = self.pageYOffset;
	    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
	      yScroll = document.documentElement.scrollTop;
	    } else if (document.body) {// all other Explorers
	      yScroll = document.body.scrollTop;
	    }
	    return yScroll;
	}
}