<div id="add" class="subcontent">    
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/save'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
            <label>Compet&ecirc;ncia</label>
            <span class="field">
                <?php
                $options = array(
                    '2015-01' => '01/2015',
                    '2015-02' => '02/2015',
                    '2015-03' => '03/2015',
                    '2015-04' => '04/2015',
                    '2015-05' => '05/2015',
                    '2015-06' => '06/2015',
                    '2015-07' => '07/2015',
                    '2015-08' => '08/2015',
                    '2015-09' => '09/2015',
                    '2015-10' => '10/2015',
                    '2015-11' => '11/2015',
                    '2015-12' => '12/2015',
                );

                echo form_dropdown('competencia', $options, 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo Compet&ecirc;ncia &eacute; obrigat&oacute;rio\'}}}"');
                ?>                
                <label for="idtitulo" generated="true" class="error" style="display: none;">O campo Título é obrigatório</label>
            </span>
        </p>
        <p>
            <label>Raz&atilde;o Social Prestador</label>
            <span class="field">
                <input type="text" name="razaosocial_prestador" id="razaosocial_prestador" class="longinput" value="" />
            </span>
        </p>
        <p>
            <label>CPF/CNPJ Prestador</label>
            <span class="field">
                <input type="text" name="cpfcnpj_prestador" id="cpfcnpj_prestador" class="smallinput" value="" />
            </span>
        </p>
        <p>
            <label>Tipo Prestador*:</label>
            <span class="field">
                <?php
                $options = array(
                    '1' => 'PF',
                    '2' => 'PJ',
                    '3' => 'PJ Fora Cidade',
                    '4' => 'PJ Fora Pa&iacute;s',
                );

                echo form_dropdown('tipo_prestador', $options, 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo Tipo Prestador é obrigatório\'}}}"');
                ?>                
                <label for="idtitulo" generated="true" class="error" style="display: none;">O campo Título é obrigatório</label>
            </span>
        </p>
        <p>
            <label>Endere&ccedil;o Prestador</label>
            <span class="field">
                <input type="text" name="endereco_prestador" id="endereco_prestador" class="longinput" value="" />
            </span>
        </p>
        <p>
            <label>Bairro Prestador</label>
            <span class="field">
                <input type="text" name="bairro_prestador" id="bairro_prestador" class="smallinput" value="" />
            </span>
        </p>
        <p>
            <label>UF Prestador</label>
            <?php
            $options = array(
                'AC' => 'AC',
                'AL' => 'AL',
                'AM' => 'AM',
                'AP' => 'AP',
                'BA' => 'BA',
                'CE' => 'CE',
                'DF' => 'DF',
                'ES' => 'ES',
                'GO' => 'GO',
                'MA' => 'MA',
                'MG' => 'MG',
                'MS' => 'MS',
                'MT' => 'MT',
                'PA' => 'PA',
                'PB' => 'PB',
                'PE' => 'PE',
                'PI' => 'PI',
                'PR' => 'PR',
                'RJ' => 'RJ',
                'RN' => 'RN',
                'RO' => 'RO',
                'RR' => 'RR',
                'RS' => 'RS',
                'SC' => 'SC',
                'SE' => 'SE',
                'SP' => 'SP',
                'TO' => 'TO',
            );

            echo form_dropdown('uf_prestador', $options, 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"');
            ?>
        </p>
        <p>
            <label>Cidade Prestador</label>
            <span id="rescidade" class="field">
                <?php 
                foreach($uf_cidades as $cidade){
                    $cid[$cidade['nom_cida']] = $cidade['nom_cida'];
                }
                echo form_dropdown('cidade_prestador', $cid, 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"'); 
                ?>
            </span>            
        </p>
        <p>
            <label>N&uacute;mero Nota Fiscal</label>
            <span class="field">
                <input type="text" name="nronf_prestador" id="nronf_prestador" class="smallinput" value="" />
            </span>
        </p>    
        <p>
            <label>C&oacute;d Servi&ccedil;o</label>
            <span class="field">
                <?php
                $category_value = $data['cod_trib_desif'] != '' ? htmlspecialchars($data['cod_trib_desif']) : $this->error->set_value('cod_trib_desif');
                $category_option[''] = 'Selecione um Servi&ccedil;o';
                foreach ($data_category as $_data_category):
                    $category_option[$_data_category['cod_trib_desif']] = $_data_category['des_trib_desif'];
                endforeach;
                ?>
                <?php echo form_dropdown('codservico_prestador', $category_option, $category_value, ' class="longinput" data-validate="{validate:{required:true, messages:{required:\'O campo Cod Servi&ccedil;o é obrigatório\'}}}"'); ?>
                <label for="codservico_prestador" generated="true" class="error" style="display: none;">O campo Cod Servi&ccedil;o é obrigatório</label>
            </span>
        </p>
        <p>
            <label>Data Servi&ccedil;o</label>
            <span class="field">
                <input type="text" name="dataservico_prestador" id="data_servico_prestador" class="smallinput" value="" />
            </span>
        </p>
        <p>
            <label>Valor Nota Fiscal</label>
            <span class="field">
                <input type="text" name="valornf_prestador" id="valornf_prestador" class="smallinput" value="" />
            </span>
        </p>
        <p>
            <label>Al&iacute;quota %</label>
            <?php
            $options = array(
                '2.00' => '2.00',
                '2.79' => '2.79',
                '3.50' => '3.50',
                '3.84' => '3.84',
                '3.87' => '3.87',
                '4.23' => '4.23',
                '4.26' => '4.26',
                '4.31' => '4.31',
                '4.61' => '4.61',
                '4.65' => '4.65',
                '5.00' => '5.00',
            );

            echo form_dropdown('aliquota_prestador', $options, 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo Al&iacute;quota &eacute; obrigat&oacute;rio\'}}}"');
            ?>
        </p>
        <p>
            <label>Valor ISSQN Retido</label>
            <span class="field">
                <input type="text" name="valorissqn" id="valorissqn" class="smallinput" value="" />
            </span>
        </p> 
        <p class="stdformbutton">
            <button class="submit radius2">
                Declarar
            </button>
        </p>
    </form>
</div>