<?php

class admin_model extends CI_Model {

    var $primary_key = 'id';
    var $table = '';
    var $directory = FALSE;
    var $config_directory = "./upload/config/";

    function __construct() {
        parent::__construct();
    }

    public function save($data) {
        $_data = $data;
        unset($_data[$this->primary_key]);
        if ($this->table == 'pref_contribuintes' || $this->table === 'user') {
            if (isset($_data['type_id'])) {
                $_data['user_group_id'] = '1';
            } else {

                $_data['type_id'] = '1';
                $_data['user_group_id'] = '1';
            }
        }

        /* image upload and delete */
        foreach ($data as $k => $v):
            if (strstr($k, 'delete_') == TRUE):
                $_key_field = str_replace('delete_', '', $k);
                if ($data['delete_' . $_key_field] == '1')
                    $_data[$_key_field] = "";
                unset($_data['delete_' . $_key_field]);
            endif;
        endforeach;
        $saveImage = $this->save_image();

        if ($saveImage == FALSE):
            /* message return error imagem */
            $this->setAlert(array('type' => 'error', 'msg' => array('Erro no arquivo de imagem. Tente Novamente!')));
            redirect('/admin/' . $this->uri->segment(2) . '/edit/' . $data[$this->primary_key], 'location');
        else:
            foreach ($saveImage as $k => $image):
                $_data[$k] = $image['file_name'];
            endforeach;
        endif;

        if ($data[$this->primary_key] != '') {
            $this->db->where(array($this->primary_key => $data[$this->primary_key]))->update($this->table, $_data);
            $this->db->set('ip', $this->session->userdata['ip_address']);
            $this->db->set('datahora', date('Y-m-d H:i:s'));
            $this->db->set('modulo', $this->router->base_url . $this->uri->uri_string());
            $this->db->set('user_id', $this->session->userdata['admin']['user_id']);
            $this->db->set('acao', 'Dados Atualizados com Sucesso!');
            $this->db->set('tabela', $this->db->last_query());
            $this->db->insert('pref_logs');
        } else {
            $this->db->insert($this->table, $_data);
            $data[$this->primary_key] = $this->db->insert_id();
            $this->db->set('ip', $this->session->userdata['ip_address']);
            $this->db->set('datahora', date('Y-m-d H:i:s'));
            $this->db->set('modulo', $this->router->base_url . $this->uri->uri_string());
            $this->db->set('user_id', $this->session->userdata['admin']['user_id']);
            $this->db->set('acao', 'Dados Salvos com Sucesso!');
            $this->db->set('tabela', $this->db->last_query());
            $this->db->insert('pref_logs');
        }

        return $data[$this->primary_key];
    }

    public function delete($id) {
        if (is_array($id))
            $aid = implode(",", $id);
        else
            $aid = $id;

        if ($aid != '') {
            $this->db->where("{$this->primary_key} IN ({$aid})")->delete($this->table);
            if ($this->directory):
                $deleta_arquivo;
            endif;
            $this->db->set('ip', $this->session->userdata['ip_address']);
            $this->db->set('datahora', date('Y-m-d H:i:s'));
            $this->db->set('modulo', $this->router->base_url . $this->uri->uri_string());
            $this->db->set('user_id', $this->session->userdata['admin']['user_id']);
            $this->db->set('acao', 'Dados Deletados com Sucesso!');
            $this->db->set('tabela', $this->db->last_query());
            $this->db->insert('pref_logs');

            return TRUE;
        }
        return FALSE;
    }

    function save_image() {
        $return = array();

        /* save file */
        $config['upload_path'] = $this->directory;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '4096';
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = FALSE;

        $this->upload->initialize($config);

        foreach ($_FILES as $_file => $value):
            if ($_FILES[$_file]['size'] > 0):
                if ($this->upload->do_upload($_file)):
                    $return[$_file] = $this->upload->data();
                else:
                    return FALSE;
                endif;
            endif;
        endforeach;

        return count($return) > 0 ? $return : TRUE;
    }

    function check_register($table, $field, $values) {
        $values = str_replace(',', "','", $values);
        $query = $this->db->select('id')->from($table)->where("{$field} IN ('{$values}')")->limit('1')->get();

        if ($query->num_rows > 0)
            return TRUE;

        return FALSE;
    }

    public function breadcrumbs() {
        $data['session'] = $this->breadcrumbs;
        return $this->load->view('backend/includes/breadcrumbs', $data, TRUE);
    }

    public function getAlert() {
        $alert = $this->session->flashdata('alert');

        switch (strtolower($alert['type'])) {
            default:
            case 'info':
                $alert['type'] = 'msginfo';
                break;
            case 'success':
                $alert['type'] = 'msgsuccess';
                break;
            case 'alert':
                $alert['type'] = 'msgalert';
                break;
            case 'error':
                $alert['type'] = 'msgerror';
                break;
            case 'announcement':
                $alert['type'] = 'announcement';
                break;
        }

        if (isset($alert['msg'])):
            return '
			    <div class="notibar ' . $alert['type'] . '"><a class="close"></a>
		            <p>' . implode('<br />', $alert['msg']) . '</p>
		        </div>
	        ';
        else:
            return FALSE;
        endif;
    }
    /*
     * 
     * Função de notificação de mensagens no sistema.
     * 
     */    

    public function setAlert($alert) {
        $this->session->set_flashdata('alert', $alert);
    }
    /*
     * 
     * Função de registro de ações dos usuários no sistema.
     * 
     */    
    public function RegistraLog($acao, $tabela) {
        $this->db->set('ip', $this->session->userdata['ip_address']);
        $this->db->set('datahora', date('Y-m-d H:i:s'));
        $this->db->set('modulo', $this->router->base_url . $this->uri->uri_string());
        $this->db->set('user_id', $this->session->userdata['admin']['user_id']);
        $this->db->set('acao', $acao);
        $this->db->set('tabela', $tabela);
        $this->db->insert('pref_logs');
    }

}
