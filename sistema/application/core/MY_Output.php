<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Layout Class
 *
 * @description Implements the type layout views in the framework.
 * @package core
 */

define('LAYOUTPATH',	APPPATH . 'views/');

class MY_Output extends CI_Output {
 
	public $base_url;
	public $name_layout = 'frontend/layouts/default.php';

	/**
	 * _display 
	 * 
	 * @descrtiption Init config layout. This method call by config/hooks.php
	 * @return
	 */
	public function _display($output = '') {
		
		if (class_exists('CI_Controller')) {
			$CI =& get_instance();
			$CI->load->helper('html');
			$this->CI = $CI;
		
			$this->base_url = $CI->config->slash_item('base_url');

			ob_start();
			$content = $output = parent::_display(); //die($output);
			$output = ob_get_contents();
			ob_get_clean();
			// escape for ajax
			if(!$CI->layout_skip_init):
				switch(current(explode('/',$CI->layout))) {
					default:
						$_ = $this->init_frontend();
					break;
					case 'backend':
						$_ = $this->init_backend();
					break;
				}
				
				// Links CSS and JS call by controller
				$_['css'] = '';
				foreach($CI->css as $_css) $_['css'] .= link_tag($_css);
				
				$_['js'] = '';				
				foreach($CI->js as $_js)   $_['js'] .=  script_tag($_js);

				$_['body_cfg'] 	= (isset($CI->body_cfg)) ? $this->add_body_cfg($CI->body_cfg) : '';
				 
				if(isset($CI->layout) && !preg_match('/(.+).php$/', $CI->layout))
					$CI->layout .= '.php';
				else
					$CI->layout = $this->name_layout;
				
				$layout = LAYOUTPATH . $CI->layout;
				 
				if ($CI->layout !== $this->name_layout && !file_exists($layout))
					if ($CI->layout != '.php') 
						show_error("You have specified a invalid layout: " . $CI->layout);
				 
				if (file_exists($layout)) {
					$layout = $CI->load->file($layout, true);
					
					$this->_arReplace[] = array('key'=>'{main}',			'content'=>$output);
					
					foreach($_ as $k=>$v) $this->_arReplace[] = array('key'=>'{'.$k.'}', 'content'=>$v);
					foreach($this->_arReplace as $rs) $layout = str_replace($rs['key'],$rs['content'],$layout);
					
					$view = $layout;

				} else
					$view = $output;
			else:
				$view = $output;
			endif;
			 
			echo $view;

			// save full cache
			if ($this->cache_expiration > 0 && isset($CI) && ! method_exists($CI, '_output')) {
				$this->_write_cache($view);
			}
		} else {
			echo $output;
		}
	}
	
	/**
	 * init_frontend
	 *
	 * @description Config a layout from frontend
	 * @return void
	 */
	private function init_frontend() {
		
		$CI = $this->CI;
		
		extract($CI->core_config);

		// SEO default tags
		$_['title']  	  = $CI->core_url['title'] != '' 		?  $CI->core_url['title'] 		: $meta_tag_title;
		$_['keywords'] 	  = $CI->core_url['keywords'] != '' 	?  $CI->core_url['keywords'] 	: $meta_tag_keywords;
		$_['description'] = $CI->core_url['description'] != '' 	?  $CI->core_url['description'] : $meta_tag_description;
		$_['spam']		  = $CI->core_url['spam'] != '' 		?  $CI->core_url['spam'] 		: $meta_tag_spam;
		$_['author']	  = $_meta_tag_author;
		$_['copyright']	  = $_meta_tag_copyright;
		
		// Open Graph tags		
		$_['og_type'] 		= $facebook_og_type;
		$_['og_site_name'] 	= $facebook_og_site_name;
		$_['fb_admins'] 	= $facebook_fb_admins;
		$_['og_image'] 		= base_url().'upload/config/'.$facebook_og_image;
		$_['og_title'] 		= $_['title'];
		$_['og_url'] 		= isset($facebook_og_url) 			? $facebook_og_url 			: $this->base_url.$_CI->router->queryString;
		$_['og_description'] = isset($facebook_og_description) 	? $facebook_og_description	: $_['description'];
		
		// GET a Subviews
		$this->_arReplace[] = array('key'=>'{top}',		'content'=>$CI->load->view('frontend/includes/top','',true));
		$this->_arReplace[] = array('key'=>'{bottom}',	'content'=>$CI->load->view('frontend/includes/bottom','',true));
		
		return array_map('htmlspecialchars',$_);
	}
	
	/**
	 * init_backend 
	 *
	 * @description Config a layout from backend
	 * @return void
	 */
	private function init_backend() {
		$CI = $this->CI;
		
		/* load authentication model */
		if($CI->uri->segment(1)=='contribuinte'){
			$CI->load->model('authentication_model_contribuinte');
			$CI->authentication_model_contribuinte->initialize('1,2','contribuinte');
		}else{
			$CI->load->model('authentication_model');
			$CI->authentication_model->initialize('1,2','admin');
		}

		$this->name_layout = 'backend/layouts/backend.php';
		
		extract($CI->core_config);
		
		// SEO default tags
		$_['title']  	  = $CI->core_url['title'] != '' 		?  $CI->core_url['title'] 		: $meta_tag_backend_title;
		$_['keywords'] 	  = $CI->core_url['keywords'] != '' 	?  $CI->core_url['keywords'] 	: $meta_tag_backend_keywords;
		$_['description'] = $CI->core_url['description'] != '' 	?  $CI->core_url['description'] : $meta_tag_backend_description;
		$_['spam']		  = $CI->core_url['spam'] != '' 		?  $CI->core_url['spam'] 		: $meta_tag_backend_spam;
		$_['author']	  = $_meta_tag_backend_author;
		$_['copyright']	  = $_meta_tag_backend_copyright;
		
		if($CI->uri->segment(1)=='contribuinte'){
			if($CI->authentication_model_contribuinte->check_auth()):
				// GET a Subviews for a login user on backend
				$login = $CI->session->userdata('contribuinte');
				$query = $CI->db->select('*')->from('pref_contribuintes')->where(array('id'=>$login['user_id']))->get();
				$data['user'] = $query->first_row('array');
					
				$this->_arReplace[] = array('key'=>'{top}',		'content'=>$CI->load->view('backend/includes/top',$data,true));
				$this->_arReplace[] = array('key'=>'{menu}',	'content'=>$CI->load->view('backend/includes/menu',$data,true));
			endif;
		}else{
			if($CI->authentication_model->check_auth()):
				// GET a Subviews for a login user on backend
				$login = $CI->session->userdata('admin');
				$query = $CI->db->select('*')->from('user')->where(array('id'=>$login['user_id']))->get();
				$data['user'] = $query->first_row('array');
					
				$this->_arReplace[] = array('key'=>'{top}',		'content'=>$CI->load->view('backend/includes/top',$data,true));
				$this->_arReplace[] = array('key'=>'{menu}',	'content'=>$CI->load->view('backend/includes/menu',$data,true));
			endif;
		}
		
		
		return array_map('htmlspecialchars',$_);
	}
	
	/**
	 * add_body_cfg
	 *
	 * @description Create cfg for body
	 * @params $links array data files js
	 * @return void
	 */
	private function add_body_cfg($cfg) {
		return $cfg;
	}
}