var numero_de_digitos = 15;

$(document).ready(function(){
	
	$('.phones').keyup(function(){
        var valor = $(this).val();
        
        if(valor[1] == '1' && valor[2] == '1' && valor[5] == '9'){
            $(this).setMask('(99) 99999-9999');
            numero_de_digitos = 15;
            // alert('Entrou 1');
        } else if ( valor[1] == '0' && valor[2] == '1' && valor[3] == '1' && valor[6] == '9') {
            $(this).setMask('(999) 99999-9999');
            numero_de_digitos = 16;
            // alert('Entrou 2');
        } else if (valor[1] == '0' && (valor[1] == '1' && valor[2] == '1') == false) {
            $(this).setMask('(999) 9999-9999');
            numero_de_digitos = 15;
            // alert('Entrou 3');
        } else {
            $(this).setMask('(99) 9999-9999');
            numero_de_digitos = 14;
            // alert('Entrou 4');
        }
    });
	
});

function sendValidateCareer(){
	msg = "";
    
    if($('#form_career input[type="button"]').attr('disabled') != 'disabled') {
	
	    if($("#tc_name").val() == "Nome") {
	        msg += "* Campo Nome é obrigatório. \n";
	    }
	        
	    if($("#tc_email").val() == "E-mail") {
	        msg += "* Campo E-mail é obrigatório. \n";
	    } else if(!valEmail.test($("#tc_email").val())) {
	        msg += "* Campo E-mail inválido. \n";
	    }
								
	    if($("#tc_message").val() == "Mensagem") {
	        msg += "* Campo Mensagem é obrigatório. \n";
	    }
		
		if($('#phone').val() == '(99) 9999-9999' || $('#phone').val() == '(88) 8888-8888' || $('#phone').val() == '(77) 7777-7777' || $('#phone').val() == '(66) 6666-6666' || $('#phone').val() == '(55) 5555-5555' || $('#phone').val() == '(44) 4444-4444' || $('#phone').val() == '(33) 3333-3333' || $('#phone').val() == '(22) 2222-2222' || $('#phone').val() == '(11) 1111-1111' || $('#phone').val() == '(00) 0000-0000'){
			msg += "- Fone inválido\n";
		}
		
		if($("input[type=checkbox][name=checkbox]:not(:checked)").val()){
			msg += "* Você precisa aceitar a política de privacidade.\n";
		}
	
	    disabledFormButton('#form_career input[type="button"]');
			
	    if(msg != "") {
	        msg = "Os seguintes campos encontram-se com problemas: \n\n" + msg;
	        alert(msg);
	        enabledFormButton('#form_career input[type="button"]');			
	    } else {
			if($('#tc_formulario').val() == 'trabalhe'){
				$('#form_career').submit();
			}
	    }    
    }	
    return false;
}

function sendValidate(pg,id){
	msg = "";
    
	if($('.form'+id+' input[type="submit"]').attr('disabled') != 'disabled') {
		
	    if($(".form"+id+" #name").val() == "Nome") {
	        msg += "* Campo Nome é obrigatório. \n";
	    }
	        
	    if($(".form"+id+" #email").val() == "E-mail") {
	        msg += "* Campo E-mail é obrigatório. \n";
	    } else if(!valEmail.test($(".form"+id+" #email").val())) {
	        msg += "* Campo E-mail inválido. \n";
	    }
								
	    if($(".form"+id+" #message").val() == "Mensagem") {
	        msg += "* Campo Mensagem é obrigatório. \n";
	    }
		
		if( $('.phone').val() == '(99) 9999-9999' || 
			$('.phone').val() == '(88) 8888-8888' || 
			$('.phone').val() == '(77) 7777-7777' || 
			$('.phone').val() == '(66) 6666-6666' || 
			$('.phone').val() == '(55) 5555-5555' || 
			$('.phone').val() == '(44) 4444-4444' || 
			$('.phone').val() == '(33) 3333-3333' || 
			$('.phone').val() == '(22) 2222-2222' || 
			$('.phone').val() == '(11) 1111-1111' || 
			$('.phone').val() == '(00) 0000-0000'){
			msg += "- Fone inválido\n";
		}
		
		if($(".form"+id+" input[id=checkbox]:not(:checked)").val()){
			msg += "* Você precisa aceitar a política de privacidade. \n";
		}
		
	    disabledFormButton('.form'+id+' input[type="submit"]');
			
	    if(msg != "") {
	        msg = "Os seguintes campos encontram-se com problemas: \n\n" + msg;
	        alert(msg);
	        enabledFormButton('.form'+id+' input[type="submit"]');
	    } else {
			/*- ajax form contato -*/
			if($('.formulario').val() == 'contato') {
				var form_validate = $('.form'+id).serialize();
				
				$.ajax({
					type	: 'POST',
					url		: 'contact/send'+pg,
					data	: form_validate,
					success : function(msg){
						if(msg == 'error'){
							alert('Erro de trasmissão tente novamente');
							enabledFormButton('.form'+id+' input[type="submit"]');
						}
						else {
							alert('Solicitação enviada com sucesso.');
							$('#name').val('Nome');
							$('#email').val('E-mail');
							$('#phone').val('Telefone');
							$('#city').val('Cidade');
							$('#state').val('UF');
							$('#message').val('Mensagem');
							
							enabledFormButton('.form'+id+' input[type="submit"]');
						}
					}
				});
			}
	    }    
    }	
    return false;
}

function sendNews() {
    msg = "";
		
    if($('#formNewsletter input[type="button"]').attr('disabled') != 'disabled') {
		
		if($("#n_name").val() == "" || $("#n_name").val() == "Nome"){
			msg += "* Nome não preenchido. \n";
		}
	
		if($("#n_email").val() == "" || $("#n_email").val() == "E-mail"){
			msg += "* Email não preenchido. \n";
		} else if(!valEmail.test($("#n_email").val())){
			msg += "* E-mail inválido. \n";
		}
	
		disabledFormButton('#formNewsletter input[type="button"]');
		
		if(msg != ""){
			alert("Os seguintes campos contém erros:\n\n" + msg);
			enabledFormButton('#formNewsletter input[type="button"]');
		} else {
			
			$.ajax({
				type: 	"POST",
				url: 	'product/newsletter',
				data: 	"name="+$("#n_name").val()+"&email="+$("#n_email").val(),
				success: function(msg){
					if(msg == 'ok') {
						alert('Cadastro realizado com sucesso.');
						$('#n_name').val('Nome');
						$('#n_email').val('E-mail');
						
						enabledFormButton('#formNewsletter input[type="button"]');
					}
					else{
						alert('Erro de trasmissão tente novamente');
						enabledFormButton('#formNewsletter input[type="button"]');
					}
				}
			});
		}
	}
	return false;
}

function validaBuscaTopFooter(){
	msg = "";
	
	if($("#campo_busca").val() == ""){
		msg += "Sua busca não pode ser realizada. \n";
	}
	
	if(msg != ""){
		msg = "Os seguintes campos são obrigatórios:\n\n" + msg;
		alert(msg);
		return false;
	} else {
		return true;
	}
}

function disabledFormButton(ct) {
    $(ct).attr('disabled','disabled').css('cursor','default').css('filter','alpha(opacity=40)').css('-moz-opacity','0.4').css('opacity','0.4');
}

function enabledFormButton(ct) {
    $(ct).attr('disabled','').css('cursor','pointer').css('filter','alpha(opacity=100)').css('-moz-opacity','1').css('opacity','1');
	$(ct).removeAttr('disabled');
}

function modalPolitica(){
	$('#modal_politica').dialog({
		modal		:true,
		draggable	:false,
		resizable	:false,
		width		:750,
		height		:450,
		buttons		: {
			Fechar: function(){
				$('#modal_politica').dialog( "close" );
			}
		}
	});
}

/*- validação de campo hora -*/
function Mascara_Hora(horario){
    var hora01 = '';
    hora01 = hora01 + horario;
    if (hora01.length == 2){
        hora01 = hora01 + ':';
        document.forms[0].horario.value = hora01;
    }
    if (hora01.length == 5){
        Verifica_Hora();
    }
}

function Verifica_Hora(){
    hrs = (document.forms[0].horario.value.substring(0,2));
    min = (document.forms[0].horario.value.substring(3,5));

    estado = "";
    if ((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59)){
        estado = "errada";
    }

    if (document.forms[0].horario.value == "") {
        estado = "errada";
    }

    if (estado == "errada") {
        alert("Hora inválida!");
        document.forms[0].horario.focus();
    }
}

/*- funções de validação -*/
function somente_letras(letra){
    var validos  = "_abcdefghijklmnopkrstuvxzywABCDEFGHIJKLMNOPQRSTUVXYWZ"+"*";
    var letra_ok = '';

    for(i = 0; i < letra.length; i++)   {
        if(validos.indexOf(letra.substr(i,1)) != -1) {
            letra_ok += letra.substr(i,1);
        }
    }
    return letra_ok;
}
function somente_numero(numero){
    var validos = "0123456789" + ":";
    var numero_ok = '';
	
    for(i = 0; i < numero.length; i++)  {
        if(validos.indexOf(numero.substr(i,1)) != -1) {
            numero_ok += numero.substr(i,1);
        }
    }
    return numero_ok;
}
function coloca_mascara(objCampo, mascara){
    switch(mascara) {
        //000.000.000-00
        case 'cpf':
        objCampo.value = somente_numero(objCampo.value);
        pri = objCampo.value.substring(0,3);
        seg = objCampo.value.substring(3,6);
        ter = objCampo.value.substring(6,9);
        qua = objCampo.value.substring(9,11);

        objCampo.value = pri+
        ((seg!='') ? '.'+seg : '')+
        ((ter!='') ? '.'+ter : '')+
        ((qua!='') ? '-'+qua : '');
        break;

        //00.000.000/0000-00
        case 'cnpj':
        objCampo.value = somente_numero(objCampo.value);
        pri = objCampo.value.substring(0,2);
        seg = objCampo.value.substring(2,5);
        ter = objCampo.value.substring(5,8);
        qua = objCampo.value.substring(8,12);
        qui = objCampo.value.substring(12,14);

        objCampo.value = pri+
        ((seg!='') ? '.'+seg : '')+
        ((ter!='') ? '.'+ter : '')+
        ((qua!='') ? '/'+qua : '')+
        ((qui!='') ? '-'+qui : '');
        break;

        //(00) 0000-0000
        case 'telefone':
        objCampo.value = somente_numero(objCampo.value);

        pri = objCampo.value.substring(0,2);
        seg = objCampo.value.substring(2,6);
        ter = objCampo.value.substring(6,11);

        objCampo.value = ((pri!='') ? pri+'-' : '')+
        ((seg!='') ? seg : '')+
        ((ter!='') ? '.'+ter : '');
        break;

        case 'telefone2':
        objCampo.value = somente_numero(objCampo.value);

        seg = objCampo.value.substring(0,4);
        ter = objCampo.value.substring(4,8);

        objCampo.value =
        ((seg!='') ? seg : '')+
        ((ter!='') ? '.'+ter : '');
        break;

        //00000-000
        case 'cep':
        objCampo.value = somente_numero(objCampo.value);

        pri = objCampo.value.substring(0,5);
        seg = objCampo.value.substring(5,8);

        objCampo.value = pri+
        ((seg!='') ? '-'+seg : '');
        break;

        //00/00/0000
        case 'data':
        objCampo.value = somente_numero(objCampo.value);

        pri = objCampo.value.substring(0,2);
        seg = objCampo.value.substring(2,4);
        ter = objCampo.value.substring(4,8);

        objCampo.value = pri+
        ((seg!='') ? '/'+seg : '')+
        ((ter!='') ? '/'+ter : '')
        break;

        //00/0000
        case 'venc_cartao':
        objCampo.value = somente_numero(objCampo.value);

        pri = objCampo.value.substring(0,2);
        seg = objCampo.value.substring(2,6);

        objCampo.value = pri+
        ((seg!='') ? '/'+seg : '')
        break;

        //0000 0000 0000 0000
        case 'cartao':
        objCampo.value = somente_numero(objCampo.value);

        pri = objCampo.value.substring(0,4);
        seg = objCampo.value.substring(4,8);
        ter = objCampo.value.substring(8,12);
        qua = objCampo.value.substring(12,16);

        objCampo.value = pri+
        ((seg!='') ? '-'+seg : '')+
        ((ter!='') ? '-'+ter : '')+
        ((qua!='') ? '-'+qua : '');
        break;

        case 'numero':
        objCampo.value = somente_numero(objCampo.value);
        break;

        case 'letra':
        objCampo.value = somente_letras(objCampo.value);
        break;

        //1.000.000.000.000,00
        case 'moeda':
        len = 20
        cur = objCampo
        n   = '0123456789';
        d   = objCampo.value;
        l   = d.length;
        r   = '';

        if( l > 0 ) {
            z = d.substr(0,l);
            s = '';
            a = 0;

            for( i=0; i < l; i++ ) {
                c = d.charAt(i);
                if( n.indexOf(c) > a ) {
                    a  = -1;
                    s += c;
                };
            };
            l = s.length;
            t = len - 1;
            if( l > t ) {
                l = t;
                s = s.substr(0,t);
            }
            if( l > 2 ) {
                r = s.substr(0,l-2)+','+s.substr(l-2,2);
            }
            else {
                if( l == 2 ) {
                    r='0,'+s;
                }
                else {
                    if( l == 1 ) {
                        r = '0,0'+s;
                    }
                }
            }
            if( r == '' ) {
                r = '0,00';
            }
            else {
                l=r.length;
                if(l > 6) {
                    j  = l%3;
                    w  = r.substr(0,j);
                    wa = r.substr(j,l-j-6);
                    wb = r.substr(l-6,6);
                    if ( j > 0 ){
                        w+='.';
                    };
                    k = (l-j)/3-2;
                    for ( i=0; i < k; i++ ){
                        w += wa.substr(i*3,3)+'.';
                    };
                    r = w + wb;
                }
            }
        }
        if( cur.value.length == len || cur.value.length > len ) {
            cur.value = cur.value.substring(0 ,len);
            return false;
        }
        else {
            if( r.length <= len ) {
                cur.value = r;
            }
            else {
                cur.value = z;
            };
        }
        break;
    }
}

var valEmail = /^[\w-]+(\.[\w-]+)*@(([A-Za-z\d][A-Za-z\d-]{0,61}[A-Za-z\d]\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
