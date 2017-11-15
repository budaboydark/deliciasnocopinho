<?php

class admin_config_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }
    
    public function save($_config) {
	    foreach($_config as $k=>$value): 
	    	$_data = array('option'=>$k,'value'=>$value);
	    	$this->db->where(array('option'=>$k))->update('core_config',$_data);
	    endforeach;
    }

}