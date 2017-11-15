$(document).ready(function(){
		
    /* PLUGIN DE WATERMARK */
    watermark.init();

    /* PLUGIN DE PNG FIX */
    if($.browser.msie && ($.browser.version == "6.0")){
        $(document).pngFix();
    }
	
	/*- Links para subir -*/
	$("a[rel*=subir]").click(function(){
		$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
	});
	
});

function voltar(){
	window.history.back(0);
}

function str_replace(haystack, needle, replacement) {
    var temp = haystack.split(needle);
    return temp.join(replacement);
}

function hideError() {
    $("#retorno_erro").animate({
        left:'+=50',
        height:'toggle'
    },500, function() {
        $("#retorno_erro").html('');
        $("#retorno_erro").css('display','block');
    });
    window.clearTimeout(timeoutID);
}

function gotoAnchor(value) {
    var elementClicked = '#'+value;
    var destination = $(elementClicked).offset().top;
    $("html:not(:animated),body:not(:animated)").animate({
        scrollTop: destination-20
        }, 500 );
}

var valEmail = /^[\w-]+(\.[\w-]+)*@(([A-Za-z\d][A-Za-z\d-]{0,61}[A-Za-z\d]\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
