<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Email controller
 *
 * @description Standard send email 
 * @extends MY_Controller
 * @author Guilherme Flores (guilhermebflores@gmail.com)
 */

class Email extends MY_Controller {

    public function sendEmail($id,$nameForm){
        if($id&&$nameForm){
        	$this->load->library('user_agent');	
        	$data = $this->input->post(NULL,TRUE);
			extract($data);	        
			$validate=array();
			
			if($name){$validate[] = array('field'=>'name','rules'=>'required|trim');}
	        if($email){$validate[] = array('field'=>'email','rules'=>'required|valid_email|trim');}
			if($phone){$validate[] = array('field'=>'phone','rules'=>'required|trim');}
			if($message){$validate[] = array('field'=>'message','rules'=>'required|trim');}

	        $this->form_validation->set_rules($validate); 
	        
	        if ($this->form_validation->run() == FALSE) {
	            $this->session->set_flashdata('retorno','Erro ao enviar os dados tente mais tarde.');           
	        }
	        else {
	            $this->load->library('sendmail');
	            $_data = array();
				
				$_data['session_id'] = $id;
				if($name){$_data['name'] = $name;}
				if($email){$_data['email'] = $email;}
				if($phone){$_data['phone'] = $phone;}
				if($message){$_data['message'] = $message;}
				if($url){$_data['url'] = $url;}
				if($model){$_data['model'] = $model;}
				if($year){$_data['year'] = $year;}
				if($city){$_data['city'] = $city;}
				if($address){$_data['address'] = $address;}
				if($neigh){$_data['neigh'] = $neigh;}
				if($power){$_data['power'] = $power;}
				if($state){$_data['state'] = $state;}
				if($interest){$_data['interest'] = $interest;}
				if($km){$_data['km'] = $km;}
				if($plaque){$_data['plaque'] = $plaque;}
				if($hour){$_data['hour'] = $hour;}

				if($_FILES['file']){
					$config['upload_path'] 		= './upload/career/';
					$config['allowed_types'] 	= 'doc|docx|pdf|txt|ppt';
					$config['max_size']			= '100000';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('file')) {			
						$file = $this->upload->data();
						
						$_data['attach'] = $file['full_path'];
					}else{
						$this->session->set_flashdata('retorno','Erro ao enviar documento.');   
						redirect($this->agent->referrer(), 'location');
					}
				}
	            $this->sendmail->session    = 'standard';
	            $this->sendmail->metadata   = json_encode($data);
	            $this->sendmail->vars       = $_data;
	            $this->sendmail->send();
	            
	            $this->session->set_flashdata('trackPageViewConvert','/'.$nameForm.'-converteu');
	            $this->session->set_flashdata('retorno','Formulário enviado com sucesso!');
	        }
	        redirect($this->agent->referrer(), 'location');
			
		}else{
			$this->session->set_flashdata('retorno','Erro ao enviar os dados tente mais tarde.');   
			redirect($this->agent->referrer(), 'location');
		}
    }
}

/* End of file email.php */
/* Location: ./application/controllers/email.php */