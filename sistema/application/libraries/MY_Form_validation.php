<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Form_validation Class
 *
 * @description Implements Error to application controllers.
 * @extends CI_Formvalidation
 * @author 
 * @package libraries
 */
 
class MY_Form_validation extends CI_Form_validation { 
  
	/**
	 * is_unique
	 * 
	 * @description Validate if a value is unique in database
	 * @access public
	 * @param mixed $str
	 * @param mixed $field
	 * @return void
	 */
	public function is_unique($str, $field) {
		list($table, $field, $field_key, $id)=explode('.', $field);
		
		$this->CI->db->select('*')->from($table);
		$this->CI->db->where($field, $str);
		
		if(intval($id) > 0) $this->CI->db->where($field_key.' !=', $id);
			
		$this->CI->db->limit(1);
		$query = $this->CI->db->get();
		
		return $query->num_rows() === 0;
    }

	/**
	 * url_title
	 * 
	 * @description format url permit . and /
	 * @access public
	 * @param mixed $str
	 * @return void
	 */
	public function url_title($str) {
		/* permit . / */
		$_model = array("-point-", "-slashes-");
		$_find  = array(".", "/");
		
		$str	= str_replace($_find, $_model, $str);
		$str 	= url_title(convert_accented_characters($str));
		$str 	= str_replace($_model,$_find,$str);
	
		return $str;
    }

    /**
     * number_phone 
     *
     * @description validate is phone number is valid
     * @param string $phone
     * @return bool
     */
    function number_phone($phone) {
    	$this->set_message('validate_number_phone','O Campo %s é inválido');
    	
    	if(trim($phone) == '') 		return true;
	    if (strlen($phone) >= 10 ) 	return true; 
	    else						return false;
	}

	/**
	 * check_dob
	 *
	 * @description verify  dob is valid
	 * @param  string  $date
	 * @param  integer $value number min diff
	 * @return bool
	 */
	function check_dob($date,$value=18) {
		$this->set_message('check_dob','O Campo %s é inválido');
		
		if(trim($date) == '') return true;

		$date = from_euro_to_sql($date);

		$diff = (diffDate($date, date('Y-m-d'), $type='Y', $sep='-'));
		if($diff < $value || $diff > 150) return false;

		return true;
	}
}