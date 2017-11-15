<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($post)){    
    //echo $post['txtTELEFONE'];
    echo '<div style="width:400px;border-radius:8px;background-color:green;color:white;padding:5px;">'.$resposta.'</div>';
}
?>
<form name='frmSend' action="enviando" method='post'>
    <table  style="border-collapse:collapse;" border="1">
        <tr>
            <td>Telefone:</td>
            <td><input type="text" name="txtTELEFONE" value="+5551992231841"></td>
        </tr>
        <tr>
            <td>Mensagem:</td>
            <td><textarea name="txtMENSAGEM" maxlength="120" cols="60" rows="10" id="txtMENSAGEM">
            TESTE
        </textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Enviar SMS"></td>
        </tr>
    </table>

</form>
