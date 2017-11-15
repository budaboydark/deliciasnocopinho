<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/save'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
            <label>UF</label>
            <?php
            $options = array(''=>'',
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

            echo form_dropdown('ufcida', $options,$data['uf'], 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"');
            ?>
        </p>
        <p>
            <label>Munic&iacute;pio</label>
            <span id="rescidade" class="field">
                <?php
                foreach ($uf_cidades as $cidade) {
                    $cid[$cidade['idn_cida']] = $cidade['nom_cida'];
                }
                echo form_dropdown('idn_cida', $cid,$data['municipio'], 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"');
                ?>
            </span>            
        </p>
        <p class="stdformbutton">
            <button class="submit radius2">Enviar</button>
        </p>
    </form>
</div>