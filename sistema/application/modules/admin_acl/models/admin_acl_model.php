<?php

class admin_acl_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }
    
    public function save($acos_group) {
	    foreach($acos_group as $k=>$v):
			foreach($v as $_k=>$_v):
				$_data[] = array('acl_acos_id' => $k, 'user_group_id' => $_k);
			endforeach;
		endforeach;
		
		$this->db->truncate('core_acl_acos_group');
		$this->db->insert_batch('core_acl_acos_group', $_data);
    }
    
    public function refact() { 
	    foreach(glob(APPPATH . '/modules/*/controllers/*' . EXT) as $controller):
		    $class_name = ucfirst(basename($controller, EXT));
	    	if(!class_exists($class_name)) $this->load->file($controller);
			$_action = get_class_methods($class_name);
			
			foreach($_action as $_method):	
				if(!strstr($_method,'__construct') && !strstr($_method,'get_instance')):
					$_data[$class_name][] = $_method;
				endif;
			endforeach;
		endforeach;
		
		foreach(glob(APPPATH . '/controllers/*' . EXT) as $controller):
			$class_name = ucfirst(basename($controller, EXT));
	    	if(!class_exists($class_name)) $this->load->file($controller);
			$_action = get_class_methods($class_name);
			
			foreach($_action as $_method):	
				if(!strstr($_method,'__construct') && !strstr($_method,'get_instance')):
					$_data[$class_name][] = $_method;
				endif;
			endforeach;
		endforeach;
		
		/* only controllers */
		foreach(array_keys($_data) as $_controller):
			$sql 	= "SELECT * FROM core_acl_acos WHERE value='{$_controller}' AND parent_id is NULL ";
			$query 	= $this->db->query($sql);
			$row 	= $query->first_row('array');
			
			$_id = $row['id'];
			
			if($query->num_rows <= 0):
				$this->db->insert('core_acl_acos', array('value' => $_controller)); 
				$_id = $this->db->insert_id();
			endif;
			
			$_data_controler[$_controller] 	= $_id;
			$_data_exist[$_controller] 		= $_id;
		endforeach;
		
		/* delete controllers */
		$this->db->where('id NOT IN ('.implode(',',$_data_exist).') AND parent_id is NULL')->delete('core_acl_acos');
		
		/* delete method of controllers */
		$this->db->where('parent_id NOT IN ('.implode(',',$_data_exist).') AND parent_id is NOT NULL')->delete('core_acl_acos');
		
		unset($_data_exist);
		
		/* only controllers methods */
		foreach($_data as $_controller=>$method):
			foreach($method as $_method):
				$sql 	= "SELECT * FROM core_acl_acos WHERE value='{$_method}' AND parent_id = '{$_data_controler[$_controller]}' ";
				$query 	= $this->db->query($sql);
				$row 	= $query->first_row('array');
				
				$_id = $row['id'];
				
				if($query->num_rows <= 0):
					$this->db->insert('core_acl_acos', array('value' => $_method,'parent_id' => $_data_controler[$_controller])); 
					$_id = $this->db->insert_id();
				endif;
	
				$_data_exist[] = $_id;
			endforeach;
		endforeach;
		
		/* delete method of controllers */
		$this->db->where('id NOT IN ('.implode(',',$_data_exist).') AND parent_id is NOT NULL')->delete('core_acl_acos');
	    
    }

}