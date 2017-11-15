
jQuery(document).ready(function () {

    /*
     * Valida a conta
     */

    jQuery("input[name*='auto_conta']").blur(function () {
        if (jQuery(this).val()) {
            var conta = jQuery(this).val();
            var idplano = jQuery("#idplanodecontas option:selected").val();
            jQuery.ajax({
                type: "POST",
                url: "admin/infracao/validaconta",
                cache: false,
                data: {
                    conta: conta,
                    ippi: idplano
                },
                beforeSend: function () {
                    var loaders = '<img src="./assets/backend/img/loaders/loader9.gif" />';
                    jQuery("#validplano").html(loaders);
                },
                success: function (retorno) {
                    jQuery("#validplano").html(retorno);
                }
            });
        }
    });

    /*
     * Lista o plano de contas identificação
     */
    jQuery("select[name='idordemfiscal2']").change(function () {
        if (jQuery(this).val()) {
            var idof = jQuery(this).val();
            jQuery.ajax({
                type: "POST",
                url: "admin/notificacao/planodecontas",
                cache: false,
                data: {
                    idof: idof
                },
                beforeSend: function () {
                    var loaders = '<img src="./assets/backend/img/loaders/loader9.gif" />';
                    jQuery("#idplanodecontas").html(loaders);
                },
                success: function (retorno) {
                    
                    jQuery("#idplanodecontas").html(retorno);
                }
            });
        }
    });

    jQuery("select[name='idordemfiscal']").change(function () {
        if (jQuery(this).val()) {
            var idof = jQuery(this).val();
            jQuery.ajax({
                type: "POST",
                url: "admin/infracao/planodecontas",
                cache: false,
                data: {
                    idof: idof
                },
                beforeSend: function () {
                    var loaders = '<img src="./assets/backend/img/loaders/loader9.gif" />';
                    jQuery("#idplanodecontas").html(loaders);
                },
                success: function (retorno) {
                    jQuery("#idplanodecontas").html(retorno);
                }
            });
        }
    });
    /*
     * Lista o periodo do relatorio selecionado
     */
    jQuery("select[name='uf']").change(function () {
        if (jQuery(this).val()) {
            var iduf = jQuery(this).val();
            jQuery.ajax({
                type: "POST",
                url: "admin/contribuintes/listacidades",
                cache: false,
                data: {
                    iduf: iduf
                },
                beforeSend: function () {
                    jQuery("#rescidade").html("Carregando...");
                },
                success: function (retorno) {
                    jQuery("#rescidade").html(retorno);
                }
            });
        }
    });

    /*
     * Lista o periodo do relatorio selecionado
     */
    jQuery("select[name='ufcida']").change(function () {
        if (jQuery(this).val()) {
            var iduf = jQuery(this).val();
            jQuery.ajax({
                type: "POST",
                url: "admin/titulos/listacidades",
                cache: false,
                data: {
                    iduf: iduf
                },
                beforeSend: function () {
                    jQuery("#rescidade").html("Carregando...");
                },
                success: function (retorno) {
                    jQuery("#rescidade").html(retorno);
                }
            });
        }
    });

    /*
     * Lista o periodo do relatorio selecionado
     */
    jQuery("select[name='uf_prestador']").change(function () {
        if (jQuery(this).val()) {
            var iduf = jQuery(this).val();
            jQuery.ajax({
                type: "POST",
                url: "contribuinte/servicostomados/listacidades",
                cache: false,
                data: {
                    iduf: iduf
                },
                beforeSend: function () {
                    jQuery("#rescidade").html("Carregando...");
                },
                success: function (retorno) {
                    jQuery("#rescidade").html(retorno);
                }
            });
        }
    });




    jQuery("input[id*='data_']").datepicker({
        inline: true,
        dateFormat: 'dd/mm/yy',
        dayNames: [
            'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'
        ],
        dayNamesMin: [
            'D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'
        ],
        dayNamesShort: [
            'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'
        ],
        monthNames: [
            'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
            'Outubro', 'Novembro', 'Dezembro'
        ],
        monthNamesShort: [
            'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
            'Out', 'Nov', 'Dez'
        ],
        nextText: 'Próximo',
        prevText: 'Anterior'


    });


    jQuery('#exportpgcc').click(function () {
        var form = 'exportxls';
        var forms = jQuery('#' + form);
        jQuery('#' + form + ' input').remove();

        jQuery('#dyntable3 input[name="id[]"]:checked').each(function () {
            var value = jQuery(this).val();
            var id = forms.append("<input name='id[]' type='hidden' value='" + value + "'/>");
        });
        forms.submit();


    });



    jQuery('a.btn_document').click(function () {

        var form = '';
        if (this.id === 'incontroversa') {
            form = 'form2';
        } else if (this.id === 'controversa') {
            form = 'form3';
        } else if (this.id === 'imprecisa') {
            form = 'form4';
        }
        jPrompt(this.id + ' , motivo:', '', this.id, function (r) {
            if (r) {
                var obs = r;
                var forms = jQuery('#' + form);
                jQuery(form + ' input').remove();
                jQuery('#dyntable3 input[name="id[]"]:checked').each(function () {
                    var value = jQuery(this).val();
                    var id = forms.append("<input name='id[]' type='hidden' value='" + value + "'/>");
                });
                forms.append('<input type="text" name="observacoes" id="observacoes" value="' + obs + '" />');
                forms.submit();
            } else {
                return false;
            }
        });



    });
    jQuery('a.btn_stop').click(function () {

        if (jQuery('#stitulo').val() != 'cancelar') {
            jPrompt('Deseja recusar o plano de contas, motivo:', '', 'Recusar', function (r) {
                if (r) {
                    jQuery('#observacoes').val(r);
                    jQuery('#form1').submit();
                } else {
                    return false;
                }
            });

        } else {
            jPrompt('Deseja Cancelar, motivo:', '', 'Cancelar', function (r) {
                if (r) {
                    var obs = r;
                    var form = jQuery('#form1');
                    jQuery('#form1 input').remove();
                    jQuery('#dyntable1 input[name="id[]"]:checked').each(function () {
                        var value = jQuery(this).val();
                        var id = form.append("<input name='id[]' type='hidden' value='" + value + "'/>");
                    });
                    form.append('<input type="text" name="observacoes" id="observacoes" value="' + obs + '" />');
                    form.submit();
                } else {
                    return false;
                }
            });
        }
        /*			
         jConfirm('Deseja realmente recusar esta conta', 'Recusar', function(r) {
         if(r == true) {
         form.submit();
         }
         });
         return false;
         */
    });
    /*
     * datatable static
     */
    if (jQuery('#dyntable1').size()) {
        jQuery('#dyntable1 a.btn_inboxi').click(function () {
            dados = jQuery('form').attr('id');
            if (dados == 'guias_escriturar') {
                jConfirm('Deseja realmente escriturar os itens selecionados?', 'Escriturar', function (r) {
                    if (r == true) {
                        var form = jQuery('#' + dados);
                        jQuery('#' + dados + ' input').remove();
                        jQuery('#dyntable1 input[name="escriturar_id[]"]:checked').each(function () {
                            var value = jQuery(this).val();
                            var id = form.append("<input name='escriturar_id[]' type='hidden' value='" + value + "'/>");
                        });
                        form.submit();
                    }
                });
            }
            return false;
        });

        /*
         * click button delete row
         */
        jQuery('#dyntable1 a.btn_book').click(function () {

            jConfirm('Deseja realmente escriturar os itens selecionados?', 'Escriturar', function (r) {
                if (r == true) {
                    var form = jQuery('#form_delete');
                    jQuery('#form_delete input').remove();
                    jQuery('#dyntable1 input[name="id[]"]:checked').each(function () {
                        var value = jQuery(this).val();
                        var id = form.append("<input name='id[]' type='hidden' value='" + value + "'/>");
                    });
                    form.submit();
                }
            });
            return false;
        });
        jQuery('#dyntable1 a.btn_dollartag').click(function () {
            jConfirm('', 'Gerar Guia', function (r) {
                if (r == true) {
                    var form = jQuery('#form_delete');
                    jQuery('#form_delete input').remove();
                    jQuery('#dyntable1 input[name="id[]"]:checked').each(function () {
                        var value = jQuery(this).val();
                        var id = form.append("<input name='id[]' type='hidden' value='" + value + "'/>");
                    });
                    form.submit();
                }
            });
            return false;
        });
        jQuery('#dyntable1 a.btn_print').click(function () {
            var i_d = this.id;
            if (i_d == 'liberar') {
                jConfirm('', 'Imprimir', function (r) {
                    if (r == true) {
                        var form = jQuery('#form_liberar');
                        jQuery('#form_liberar input').remove();
                        jQuery('#dyntable1 input[name="delete_id[]"]:checked').each(function () {
                            var value = jQuery(this).val();
                            var id = form.append("<input name='delete_id[]' type='hidden' value='" + value + "'/>");
                        });
                        form.submit();
                    }
                });

            } else if (i_d == 'guiaprint') {
                window.open(this.href, '_blank');

            } else if (i_d == 'print_prtcl') {
                jConfirm('', 'Imprimir Protocolo', function (r) {
                    if (r == true) {
                        var form = jQuery('#imprimir_protocolo');
                        jQuery('#imprimir_protocolo input').remove();
                        jQuery('#dyntable1 input[name="protocolo_id[]"]:checked').each(function () {
                            var value = jQuery(this).val();
                            var id = form.append("<input name='protocolo_id[]' type='hidden' value='" + value + "'/>");
                        });
                        form.submit();
                    }
                });

            } else {
                jConfirm('', 'Imprimir', function (r) {
                    if (r == true) {
                        var form = jQuery('#guias_imprimir');
                        jQuery('#guias_imprimir input').remove();
                        jQuery('#dyntable1 input[name="print_id[]"]:checked').each(function () {
                            var value = jQuery(this).val();
                            var id = form.append("<input name='print_id[]' type='hidden' value='" + value + "'/>");
                        });
                        form.submit();
                    }
                });
            }
            return false;
        });
        jQuery('#segundavia').click(function () {
            jConfirm('', 'Gerar Segunda Via', function (r) {
                if (r == true) {
                    var form = jQuery('#segundavia_imprimir');
                    jQuery('#segundavia_imprimir input').remove();
                    jQuery('#dyntable1 input[name="print_id[]"]:checked').each(function () {
                        var value = jQuery(this).val();
                        var id = form.append("<input name='print_id[]' type='hidden' value='" + value + "'/>");
                    });
                    form.submit();
                }
            });
            return false;
        });


        jQuery('#dyntable1 a.btn_trash').click(function () {
            jConfirm('Deseja realmente excluir os itens selecionados?', 'Excluir', function (r) {
                if (r == true) {
                    var form = jQuery('#form_delete');
                    jQuery('#form_delete input').remove();
                    jQuery('#dyntable1 input[name="delete_id[]"]:checked').each(function () {
                        var value = jQuery(this).val();
                        var id = form.append("<input name='id[]' type='hidden' value='" + value + "'/>");
                    });
                    form.submit();
                }
            });
            return false;
        });
        /*
         * click on row go to link edit
         */
        jQuery('#dyntable1 tbody tr td').live('click', function () {
            var url_base = jQuery('#dyntable1 tbody').attr('data-rel');
            if (jQuery(this).index() > 0 && !jQuery(this).hasClass('noclick') && !jQuery(this).find('select').size())
                window.location = url_base + "/" + jQuery(this).parents("tr").find('input').val();
        });
        /*jQuery('#dyntable3 tbody tr td').live('click',function(){
         var url_base = jQuery('#dyntable3 tbody').attr('data-rel');	
         
         if(jQuery(this).index() > 0 && !jQuery(this).hasClass('noclick') && !jQuery(this).find('select').size())
         window.location = url_base+"/"+jQuery(this).parents("tr").find('input').val();
         });*/


        dateTable = jQuery('#dyntable1').dataTable({
            "oLanguage": {"sUrl": "assets/backend/js/plugins/dataTables.pt_BR.txt"},
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0, 'asc']],
            "fnDrawCallback": function (oSettings) {
            },
            "fnInitComplete": function (oSettings, json) {
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        jQuery('.stdtable .unique_search input').eq(i).val(oSettings.aoPreSearchCols[i].sSearch);
                    }
                }
            },
            "bStateSave": true
        });
    }
    /*
     novo
     */

    if (jQuery('#dyntable3').size()) {
        /*
         * click button delete row
         */
        jQuery('#dyntable3 a.btn_trash').click(function () {
            jConfirm('Deseja realmente excluir os itens selecionados?', 'Excluir', function (r) {
                if (r == true) {
                    var form = jQuery('#form_delete');
                    jQuery('#form_delete input').remove();
                    jQuery('#dyntable3 input[name="delete_id[]"]:checked').each(function () {
                        var value = jQuery(this).val();
                        var id = form.append("<input name='id[]' type='hidden' value='" + value + "'/>");
                    });
                    form.submit();
                }
            });
            return false;
        });
        /*
         * click on row go to link edit
         */
        jQuery('#dyntable3 tbody tr td').live('click', function () {
            var url_base = jQuery('#dyntable3 tbody').attr('data-rel');
            if (jQuery(this).index() > 0 && !jQuery(this).hasClass('noclick') && !jQuery(this).find('select').size())
                window.location = url_base + "/" + jQuery(this).parents("tr").find('input').val();
        });
        jQuery('#dyntable3 tbody tr td').live('click', function () {
            var url_base = jQuery('#dyntable3 tbody').attr('data-rel');
            if (jQuery(this).index() > 0 && !jQuery(this).hasClass('noclick') && !jQuery(this).find('select').size())
                window.location = url_base + "/" + jQuery(this).parents("tr").find('input').val();
        });
        dateTable = jQuery('#dyntable3').dataTable({
            "oLanguage": {"sUrl": "assets/backend/js/plugins/dataTables.pt_BR.txt"},
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0, 'asc']],
            "fnDrawCallback": function (oSettings) {
            },
            "fnInitComplete": function (oSettings, json) {
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        jQuery('.stdtable .unique_search input').eq(i).val(oSettings.aoPreSearchCols[i].sSearch);
                    }
                }
            },
            "bStateSave": true
        });
    }

    /*
     * datatable dynamic
     */
    if (jQuery('#dyntable2').size()) {
        /*
         * click button delete row
         */
        jQuery('#dyntable2 a.btn_trash').click(function () {
            jConfirm('Deseja realmente excluir os itens selecionados?', 'Excluir', function (r) {
                if (r == true) {
                    var form = jQuery('#form_delete');
                    jQuery('#form_delete input').remove();
                    jQuery('#dyntable2 input[name="delete_id[]"]:checked').each(function () {
                        var value = jQuery(this).val();
                        var id = form.append("<input name='id[]' type='hidden' value='" + value + "'/>");
                    });
                    form.submit();
                }
            });
            return false;
        });
        /*
         * click on row go to link edit
         */
        jQuery('#dyntable2 tbody tr td').live('click', function () {
            var url_base = jQuery('#dyntable2 tbody').attr('data-rel');
            if (jQuery(this).index() > 0 && !jQuery(this).hasClass('noclick') && !jQuery(this).find('select').size())
                window.location = url_base + "/" + jQuery(this).parents("tr").find('input').val();
        });
        dateTable = jQuery('#dyntable2').dataTable({
            "oLanguage": {"sUrl": "assets/backend/js/plugins/dataTables.pt_BR.txt"},
            "sPaginationType": "full_numbers",
            "fnDrawCallback": function (oSettings) {
                jQuery('#dyntable2 tbody tr input[type="checkbox"]').uniform();
            },
            "fnInitComplete": function (oSettings, json) {
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        jQuery('.stdtable .unique_search input').eq(i).val(oSettings.aoPreSearchCols[i].sSearch);
                    }
                }
            },
            "bStateSave": true,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": jQuery('#dyntable2').attr('data-source')
        });
    }


    /*
     * individual search
     */
    jQuery('.stdtable .unique_search input').keyup(function () {
        dateTable.fnFilter(this.value, jQuery('.stdtable .unique_search input').index(this));
    });
});
var dateTable = '';