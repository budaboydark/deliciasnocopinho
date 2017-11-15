<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sendmail Class
 *
 * @description Implements Sendmail to application controllers.
 * @author Eduardo Messias (eduardo.inf@gmail.com)
 * @package libraries
 */
 
class Sendmail {

    var $mail;
    var $session;
    var $vars;
    var $subject;
    var $body;
    var $bodyComp;
    var $sendFlag;
    var $email_to;
    var $log 	= FALSE;
    var $DEBUG 	= FALSE;

    var $from_name  = 'Teste email';
    var $from_email = 'teste@email.com.br';


    /**
     * __construct
     * 
     * @access public
     * @return void
     */
    function  __construct() {
    	$this->CI =& get_instance();
    	$this->CI->load->library('email');
    }

    /**
     * log_email function.
     * 
     * @description Generate log
     * @access public
     * @param string $name
     * @param string $email
     * @param string $email_to
     * @param string $body
     * @param string $session
     * @param string $status
     * @return void
     */
    public function log_email($name,$email,$email_to,$body,$session,$status) {
        $data = array('date'=>date('Y-m-d H:i:s'), 'name' => $name, 'email' => $email, 'email_to' => $email_to, 'body' => $body, 'metadata' => $this->metadata , 'session' => $session, 'status' => $status);
        
        $this->CI->db->insert('emaillog', $data); 
    }
    
    /**
     * format_email
     * 
     * @description Apply template mail form data
     * @access public
     * @return void
     */
    public function format_email() {
        $data['subject'] = $this->subject;
        $data['body'] 	 = $this->body;
        $data['title'] 	 = "";

        return  $this->CI->load->view('frontend/includes/mail.php',$data,TRUE);
    }
    
    /**
     * get_email_session
     * 
     * @description Get emails to send in session
     * @access public
     * @param mixed $session
     * @param mixed $ids
     * @return void
     */
    public function get_email_session($session,$ids) {
        if($ids != '') {
            $in = implode(',',$ids);
            $where = " AND id IN ($in) ";
        }
		
		$query = $this->CI->db->from('emailto')->where("status IN ('1') AND category_id = '{$session}' {$where}")->get();
        return $query->result_array();
    }
	
	/**
     * get_email_category
     * 
     * @description Get category email to create subject and session
     * @access public
     * @param mixed $session
     * @param mixed $ids
     * @return void
     */
    public function get_email_category($id) {
        $query = $this->CI->db->from('emailto_category')->where("id = '{$id}'")->get();
        $id = $query->result_array();
		foreach ($id as $title) {
			$title_category = $title['title'];
		}
		return $title_category;
    }
    
    /**
     * clear
     * 
     * @description Clear recpients
     * @access public
     * @return void
     */
    public function clear() {
        unset($this->email_to);
	    $this->CI->email->clear();
    }

    /**
     * send
     * 
     * @description Send email 
     * @access public
     * @return void
     */
    function send() {
        $this->CI->email->from($this->from_email,$this->from_name);

		$name = '$this->send_'.$this->session.'();';
		eval($name);

		$body = str_replace('\r\n','<br />',$this->format_email());	
		
		if($this->DEBUG == TRUE) die($body);
		
		$this->CI->email->message($body);
		$this->CI->email->subject($this->subject);
        
        //$this->CI->email->bcc("teste@email.com.br");
        
        if($this->CI->email->send()) 	$this->status = '1';
        else                    	$this->status = '0';

        if($this->log == TRUE) {
            // insert log email 
            $this->log_email($this->name,
                             $this->email,
                             implode(',',$this->email_to),
                             $this->body.$this->bodyComp,
                             $this->session,
                             $this->status);
        }
    }

    /**
     * send_contact
     * 
     * @description Configure a send email contact
     * @access public
     * @return void
     */
    function send_contact() {
        $this->session = 'Contato pelo site';
        $this->subject = 'Contato pelo site por '. $this->vars['email'];
        
        $this->body = '
                <b>Nome :</b> ' . $this->vars['name'] . '<br />
                <b>E-mail :</b> ' . $this->vars['email'] . '<br />
                <b>Telefone :</b> ' . $this->vars['phone'] . '<br />
                <b>Assunto :</b> ' . $this->vars['subject'] . '<br />
                <b>Mensagem :</b> ' . $this->vars['description'] . '<br />
        ';

        $this->CI->email->reply_to($this->vars['email'], $this->vars['name']);
        
		$rs = $this->get_email_session('1');
        foreach ($rs as $r) $this->email_to[] = $r['email'];
        
        $this->CI->email->to($this->email_to);

        $this->log = TRUE;
        $this->email = $this->vars['email'];
        $this->name  = $this->vars['name'];
    }
	
	/**
     * send_standard
     * 
     * @description Configure a send email standard
     * @access public
     * @return void
     */
    function send_standard() {
    	$title_category_email = $this->get_email_category($this->vars['session_id']);
		
        $this->session = $title_category_email.' pelo site';
        $this->subject = $title_category_email.' pelo site por '. $this->vars['email'];
        
		if($this->vars['name'])		{$this->body .= '<b>Nome :</b> ' . $this->vars['name'] . '<br />';}
		if($this->vars['email'])	{$this->body .= '<b>Email :</b> ' . $this->vars['email'] . '<br />';}
		if($this->vars['phone'])	{$this->body .= '<b>Telefone :</b> ' . $this->vars['phone'] . '<br />';}
		if($this->vars['message'])	{$this->body .= '<b>Mensagem :</b> ' . $this->vars['message'] . '<br />';}
		
		if($this->vars['attach']) 	{$this->CI->email->attach($this->vars['attach']);}

        $this->CI->email->reply_to($this->vars['email'], $this->vars['name']);
        
		$rs = $this->get_email_session($this->vars['session_id']);
        foreach ($rs as $r) $this->email_to[] = $r['email'];
        
        $this->CI->email->to($this->email_to);

        $this->log = TRUE;
        $this->email = $this->vars['email'];
        $this->name  = $this->vars['name'];
    }
}