<link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>assets/boleto/css/padrao.css" />
<table width="500" border="0" align="center" cellpadding="0" cellspacing="5">
    <tr>
        <td align="center" height="100">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left"><img src="<?php echo base_url(); ?>upload/config/<?php echo $coreconfig->value; ?>" width="60" height="60"></td>
                    <td align="left">
                        <span class="cab01">PREFEITURA DE <?php echo $MUNICIPIO; ?></span><br>
                        <span class="cab01"></span><br><br>
                        <span class="cab02">ISSQN - Guia para Pagamento</span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border:#000000 solid 2px;">CNPJ/Inscr. Municipal/CPF:<br><?php echo $CPFCNPJ; ?></td>
                    <td></td>
                    <td style="border:#000000 solid 2px;">C&oacute;digo da Arrecada&ccedil;&atilde;o<br><?php echo $CODIGO; ?></td>
                </tr>
            </table>    
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border:#000000 solid 2px;">NOME: <br /><?php echo $RAZAO_SOCIAL; ?></td>
                </tr>
            </table>   
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border:#000000 solid 2px;">ENDERE&Ccedil;O:<br><?php echo $ENDERECO; ?></td>
                </tr>
            </table>       
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border:#000000 solid 2px;">ATIVADE(S):<br>01 - PROGRAMA&Ccedil;&Atilde;O.<br /></td>
                </tr>
            </table>           
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border:#000000 solid 2px;" align="center"><span class="cab02">INSTRU&Ccedil;&Otilde;ES PARA RECEBIMENTO</span><br><br>
                        Pagamento somente nas Ag&ecirc;ncias do Banrisul e lot&eacute;ricas		<br><br>
                        VALOR V&Aacute;LIDO PARA PAGAMENTO AT&Eacute; <?php echo $VENCIMENTO; ?>.<br>
                        AP&Oacute;S ESSA DATA, EMITA UMA GUIA ATUALIZADA.
                    </td>
                </tr>
            </table>           
        </td>
    </tr>  
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border:#000000 solid 2px;" align="center"><span class="cab02">GUIA PARA PAGAMENTO DE ISSQN</span><br /><br />
                        Compet&ecirc;ncia: <?php echo $COMPETENCIA; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        Vencimento: <?php echo $VENCIMENTO; ?></td>
                </tr>
            </table>           
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border:#000000 solid 2px;" align="center">
                        <table width="100%" border="0" cellspacing="3" cellpadding="0">
                            <tr>
                                <td align="center">Receita Bruta</td>
                                <td align="center">Multa</td>
                                <td align="center">Juros</td>
                                <td align="center">Imposto</td>
                            </tr>
                            <tr>
                                <td align="center">R$ <?php echo DecToMoeda($BASE_CALCULO); ?></td>
                                <td align="center">R$ <?php echo DecToMoeda($MULTA); ?></td>
                                <td align="center">R$ <?php echo DecToMoeda($JUROS); ?></td>
                                <td align="center">R$ <?php echo DecToMoeda($IMPOSTO); ?></td>
                            </tr>
                        </table>        
                    </td>
                </tr>
            </table>           
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td></td>
                    <td class="cab02" align="right">VALOR A PAGAR&nbsp;&nbsp;</td>
                    <td class="cab02" height="40" align="right" bgcolor="#CCCCCC" style="border:1px solid;">R$ <?php echo DecToMoeda($IMPOSTO); ?></td>
                </tr>
            </table>    
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" style="border:#000000 solid 2px;">
                <tr>
                    <td><img src="<?php echo base_url(); ?>upload/config/<?php echo $coreconfig->value; ?>" width="60" height="60"></td>
                    <td align="right">
                        <table width="100%" border="0" cellspacing="2" cellpadding="0">		
                            <tr>
                                <td align="center">Autentica&ccedil;&atilde;o Mec&acirc;nica<br><?php echo $linhad; ?><br></td>
                            </tr>
                            <tr>
                                <td align="center"> <?php geraCodigoDeBarras($linha); ?></td>
                            </tr>
                        </table>
                    </td>
            </table>        
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td align="right">
                        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                            <tr>
                                <td>
                                    <img src=<?php echo base_url(); ?>assets/boleto/img/cortar.gif width=450 height=60>
                                </td>		
                            </tr>
                        </table>        
                    </td>
                </tr>
            </table>    
        </td>
    </tr>
    <tr>
        <td align="center">
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border:#000000 solid 2px;">CNPJ/Inscr. Municipal/CPF:<br>
                        <?php echo $CPFCNPJ; ?></td>
                    <td></td>
                    <td style="border:#000000 solid 2px;">C&oacute;digo da Arrecada&ccedil;&atilde;o<br>
                        <?php echo $CODIGO; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border:#000000 solid 2px;" align="center">
                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td>Vencimento: <?php echo $VENCIMENTO; ?></td>
                                <td class="cab02" align="right">VALOR A PAGAR&nbsp;&nbsp;</td>
                                <td class="cab02" align="right" style="border:1px solid;" bgcolor="#CCCCCC">R$ <?php echo DecToMoeda($IMPOSTO); ?></td>
                            </tr>
                        </table></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="2" style="border:#000000 solid 2px;">
                <tr>
                    <td><img src="<?php echo base_url(); ?>upload/config/<?php echo $coreconfig->value; ?>" width="60" height="60"></td>
                    <td align="right">
                        <table width="100%" border="0" cellspacing="2" cellpadding="0">		
                            <tr>
                                <td align="center">Autentica&ccedil;&atilde;o Mec&acirc;nica<br><?php echo $linhad; ?><br></td>
                            </tr>
                            <tr>
                                <td align="center"> <?php geraCodigoDeBarras($linha); ?></td>
                            </tr>
                        </table>
                    </td>
            </table></td>
    </tr>
    <tr>
        <td align="center">&nbsp;</td>
    </tr>
</table>

</body>
</html>




