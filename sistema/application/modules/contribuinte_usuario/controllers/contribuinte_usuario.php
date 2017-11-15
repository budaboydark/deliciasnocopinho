<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contribuinte_usuario extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('contribuinte/contribuinte_model');

        $this->admin_model->table_user = 'user';
        $this->admin_model->table_contribuinte = 'pref_contribuintes';
        $this->admin_model->directory = './upload/user/';

        /* layout config for login */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Editar Usu&aacute;rio');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Dados do Usu&aacute;rio');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Editar Usu&aacute;rio',
            'description' => '',
            'menu_active' => 'dashboard',
            'submenu_active' => 'user'
        );

        /* validate */
        $this->validate = array(
            array(
                'field' => 'name',
                'label' => 'Nome',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|trim|is_unique[user.email.id.' . $this->input->post('id') . ']'
            ),
            array(
                'field' => 'user_group_id',
                'label' => 'Grupo de usu&aacute;rios',
                'rules' => 'required|trim'
            )
        );
    }

    public function editar($id) {
        $login = $this->session->userdata('contribuinte');

        if (isset($id)):

            $query = $this->db->select($this->admin_model->table_contribuinte . '.*,u.image as image');
            $query = $this->db->from($this->admin_model->table_contribuinte);
            $query = $this->db->join('user u', 'u.cnpj=pref_contribuintes.cnpj');
            $query = $this->db->where(array('pref_contribuintes.id' => $id))->get();
            $rs['data'] = $query->first_row('array');



        endif;


        $this->data['content'] = $this->load->view('editar', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function salvar() {
        /* change password */
        $data = $this->input->post(NULL, TRUE);
        $data['pass'] = md5($data['confirm_pass']);
        if ($data['id'] != '') {

            $this->admin_model->table = 'user';
            $query2 = $this->db->select('*')->from($this->admin_model->table)->where(array('cnpj' => $data['cnpj']))->get();
            $rs = $query2->first_row('array');
            $pref_usuarios['id'] = $rs['id'];
        } else {
            $this->admin_model->table = 'user';
        }


            $config['upload_path'] = './upload/user/';
            $config['allowed_types'] = '*';
            $config['max_size'] = '0';
            $config['encrypt_name'] = TRUE;
            $config['max_height'] = '0';
            $config['max_width'] = '0';
            $config['overwrite'] = FALSE;


            $this->upload->initialize($config);
            foreach ($_FILES as $_file => $value):
                if ($_FILES[$_file]['size'] > 0):
                    if ($this->upload->do_upload($_file)):
                        $return[$_file] = $this->upload->data();
                        $t = TRUE;
                    else:
                        $return["error"] = $this->upload->display_errors();
                        $t = FALSE;
                    endif;
                endif;
            endforeach;

            if ($t == TRUE) {
                print_r($_FILES) . '<br />';
                print_r($return);
                $pref_usuarios['image'] = $return['image']['file_name'];
                $this->db->set('image', $pref_usuarios['image']);
                
            } else {
                print_r($return);
            }
        //exit;
        if($rs['pass'] == md5($data['confirm_pass'])){
            $pref_usuarios['pass'] = $rs['pass'];
        }else{
            $pref_usuarios['pass'] = md5($data['confirm_pass']);
        }    

        $this->db->set('pass', $pref_usuarios['pass']);
        $this->db->where('id', $pref_usuarios['id']);
        $this->db->update('user');
        $this->contribuinte_model->RegistraLog('Dados atualizados com sucesso!',$this->db->last_query());

        $this->db->set('pass', $pref_usuarios['pass']);
        $this->db->where(array('cnpj' => $data['cnpj']));
        $this->db->update('pref_contribuintes');
        $this->contribuinte_model->RegistraLog('Dados atualizados com sucesso!',$this->db->last_query());

        
        /* message return success */
        redirect('/contribuinte/', 'location');
    }

    public function delete() {
        $id = $this->input->post('id');

        /* validate */
        if (is_array($id)):
            $this->admin_model->delete($id);

            /* message return success */
            $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados exclu&iacute;dos com sucesso!')));
        else:
            /* message return error */
            $this->admin_model->setAlert(array('type' => 'error', 'msg' => array('Nenhum parâmetro passado')));
        endif;

        redirect('/admin/' . $this->uri->segment(2), 'location');
    }

}
