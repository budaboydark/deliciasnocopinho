<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Acl Class
 *
 * @description Implements ACL to application controllers.
 * @author Eduardo Messias (eduardo.inf@gmail.com)
 * @package hooks
 */

class Acl {
 	
	/**
	 * init
	 * 
	 * @description Init config Acl. This method call by config/hooks.php
	 * @author Eduardo Messias (eduardo.inf@gmail.com)
	 * @return
	 */
	public function init() { 
		
		$CI = get_instance();
		
		$router =& load_class('Router');
		
		$segments = $CI->uri->segments[1];

		// verify ACL 
		switch($segments) {
			case 'admin':
				$CI->load->model('authentication_model');
				$CI->authentication_model->initialize('1,2','admin');
				$CI->authentication_model->check_auth();
			break;
			case 'contribuinte':
				$CI->load->model('authentication_model_contribuinte');
				$CI->authentication_model_contribuinte->initialize('1,2','contribuinte');
				$CI->authentication_model_contribuinte->check_auth();
			break;
		}
			
		$login = $CI->session->userdata($segments);
		
		// public, admin, member
		$user_type = $login['user_group_title'] == '' ? 'public' : $login['user_group_title'];
		
		// superadmin access all
		if($user_type == 'superadmin') return true;
		
		$class  = $CI->router->fetch_class();
		$method = $CI->router->fetch_method();
		
		$CI->db->select('*')->from('core_acl_acos_group aag');
		$CI->db->join('core_acl_acos aa','aag.acl_acos_id = aa.id','left');
		$CI->db->join('user_group ug','ug.id = aag.user_group_id','left');
		$CI->db->join('core_acl_acos aap','aap.id = aa.parent_id','left');
		$CI->db->like('ug.title',$user_type,'none')->like('aap.value',$class,'none')->like('aa.value',$method,'none');
		$CI->db->limit(1);
		
		$query = $CI->db->get();
	
		if(count($query->result()) <= 0):
			$_segment_admin = array('admin','member','contribuinte');
			
			/* redir group admin */
			if(in_array($segments,$_segment_admin)):
				header("location: ".base_url().$segments."/login"); 
				exit;
			endif;
			
			header("location: ".base_url()."unauthorized"); 
			exit;
		else:
			return true;
		endif; 
	}
}