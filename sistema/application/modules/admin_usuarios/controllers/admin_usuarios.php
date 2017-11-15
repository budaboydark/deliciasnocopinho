<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_usuarios extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table = 'user';
        $this->admin_model->directory = './upload/user/';

        /* layout config for login */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Funcion&aacute;rios');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Lista de Funcion&aacute;rios');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Lista de Funcion&aacute;rios',
            'description' => 'Controle de Funcion&aacute;rios',
            'menu_active' => 'dashboard',
            'submenu_active' => 'user'
        );

        /* validate */
        /*
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
        );*/
    }

    public function index($list) {
        $login = $this->session->userdata('admin');

        $this->data['content'] = $this->load->view('list', $rs, TRUE);
        $this->load->view('structure', $this->data);

        // dynamic table
        if ($list == TRUE):
            $sIndexColumn = "id";
            $aColumns = array('1', 'user.id as id', 'user.matricula as matricula', 'user.name as name', 'user.email as email', 'IF(user.status = 1,\'Ativo\',\'Inativo\') as status');
            $aColumns2 = array('1', 'matricula', 'name', 'status', 'email');

            // sql list
            $this->db->select(' SQL_CALC_FOUND_ROWS ' . implode(", ", $aColumns), FALSE);
            $this->db->from($this->admin_model->table);
            $this->db->join('user_group', 'user_group.id = user.user_group_id', 'left');
            $this->db->where(array('type_id =' => '1'));

            // validate groups views
            switch ($login['user_group_id']) {
                case '1':
                    $all;
                    break;
                case '2':
                    $this->db->where(array('user_group_id !=' => '1'));
                    break;
                default:
                    $this->db->where(array('user.id' => $login['user_id']));
                    break;
            }

            // Total data set length
            $query = $this->db->query('SELECT COUNT(1) as total FROM user WHERE type_id = 1')->first_row('array');
            $iTotal = $query['total'];

            // get $_GET values
            $get = $this->input->get(NULL, TRUE);
            extract($get);

            // pagination
            if (isset($get['iDisplayStart']) && $get['iDisplayLength'] != '-1')
                $this->db->limit($get['iDisplayLength'], $get['iDisplayStart']);

            // order
            if (isset($get['iSortCol_0'])) {
                for ($i = 0; $i < intval($get['iSortingCols']); $i++)
                    if ($get['bSortable_' . intval($get['iSortCol_' . $i])] == "true")
                        $this->db->order_by($aColumns2[intval($get['iSortCol_' . $i])], $get['sSortDir_' . $i]);
            } else {
                $this->db->order_by($sIndexColumn, 'DESC');
            }

            // filter
            if (isset($get['sSearch']) && $get['sSearch'] != "")
                for ($i = 0; $i < count($aColumns); $i++)
                    $this->db->or_having("{$aColumns2[$i]} LIKE ", "%{$get[sSearch]}%", FALSE);

            // filter individual
            for ($i = 0; $i < count($aColumns); $i++)
                if (isset($get['bSearchable_' . $i]) && $get['bSearchable_' . $i] == "true" && $get['sSearch_' . $i] != '')
                    $this->db->having("{$aColumns2[$i]} LIKE ", "%" . $get['sSearch_' . $i] . "%", FALSE);

            $rResult = $this->db->get()->result_array();

            // Data set length after filtering
            $query = $this->db->query('SELECT FOUND_ROWS()')->first_row('array');
            $iFilteredTotal = $query['FOUND_ROWS()'];

            // output
            $output = array("sEcho" => intval($get['sEcho']), "iTotalRecords" => $iTotal, "iTotalDisplayRecords" => $iFilteredTotal, "aaData" => array());

            foreach ($rResult as $aRow):
                $row = array();
                $row[] = '<span class="center" style="padding-left: 36px;">' . form_checkbox($data = array('name' => 'delete_id[]', 'value' => $aRow[$sIndexColumn])) . '</span>';
                for ($i = 1; $i < count($aColumns); $i++):
                    // output formatting
                    $row[] = $aRow[$aColumns2[$i]];
                endfor;
                $output['aaData'][] = $row;
            endforeach;
            die(json_encode($output));
        endif;
    }

    public function editar($id) {
        $login = $this->session->userdata('admin');

        if (isset($id)):

            // validate groups views
            switch ($login['user_group_id']) {
                case '1':
                    $all;
                    break;
                case '2':
                    $this->db->where(array('user_group_id !=' => '1'));
                    break;
                default:
                    $this->db->where(array('user.id' => $login['user_id']));
                    break;
            }

            $query = $this->db->select('*')->from($this->admin_model->table)->where(array('id' => $id))->get();
            $rs['data'] = $query->first_row('array');
        endif;

        /* only user get list group */
        // validate groups views
        switch ($login['user_group_id']) {
            case '1':
                $all;
                break;
            case '2':
                $this->db->where(array('id !=' => '1'));
                break;
            default:
                $this->db->where(array('id' => $login['user_group_id']));
                break;
        }

        $query = $this->db->select('*')->from('user_group')->get();

        $rs['data_group'] = $query->result_array();
        /* only user get list group */

        $this->data['content'] = $this->load->view('editar', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function save() {
        /* change password */
        if ($this->input->post('pass') != '' OR $this->input->post('confirm_pass') != ''):
            $this->validate[] = array(
                'field' => 'pass',
                'label' => 'Senha',
                'rules' => 'required|matches[confirm_pass]|min_length[6]|md5'
            );
            $alterPass = TRUE;
        endif;
        /* change password */

        $this->form_validation->set_rules($this->validate);
        
        if ($this->form_validation->run() == FALSE) {
            $this->error->set($this->validate);
            /* message return error */
            $this->admin_model->setAlert(array('type' => 'error', 'msg' => array('Erro no envio dos dados!')));
            redirect('/admin/' . $this->uri->segment(2) . '/' . $this->input->post('id'), 'location');
        } else {
            $data = $this->input->post(NULL, TRUE);
            unset($data['confirm_pass']);
            if ($alterPass == FALSE)
                unset($data['pass']);

            $id = $this->admin_model->save($data);

            /* message return success */
            $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados salvos com sucesso!')));
            redirect('/admin/' . $this->uri->segment(2), 'location');
        }
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

/* End of file admin_user.php */
/* Location: ./application/modules/admin_user/controllers/admin_user.php */