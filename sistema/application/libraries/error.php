<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Error Class
 *
 * @description Implements Error to application controllers.
 * @author 
 * @package libraries
 */
 
class Error {
	
	var $CI;
	
	/**
	 * __construct
	 * 
	 * @access public
	 * @return void
	 */
	function __construct() {
		$CI =& get_instance();
		$CI->load->library(array('session','form_validation'));
		$this->CI = $CI;
		
		$this->CI->form_validation->set_error_delimiters('','</label>');
	}
	
	/**
	 * set
	 * 
	 * @description set a error to flashdata
	 * @access public
	 * @param mixed $validate
	 * @return void
	 */
	public function set($validate) {
		$this->CI->session->set_flashdata('validation_errors', validation_errors());
		
		foreach($validate as $value):
			$this->CI->session->set_flashdata('form_error_'.$value['field'], form_error($value['field'],'<label class="error" for="'.$value['field'].'" generated="true">','</label>'));
			$this->CI->session->set_flashdata('set_value_'.$value['field'], set_value($value['field']));
		endforeach;
	}
	
	/**
	 * form_error
	 * 
	 * @access public
	 * @param mixed $value
	 * @return void
	 */
	public function form_error($value) {
		return $this->CI->session->flashdata('form_error_'.$value);
	}
	
	/**
	 * set_value
	 * 
	 * @access public
	 * @param mixed $value
	 * @return void
	 */
	public function set_value($value) {
		return $this->CI->session->flashdata('set_value_'.$value);
	}
}