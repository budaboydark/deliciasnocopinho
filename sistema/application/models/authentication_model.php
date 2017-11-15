<?php
/**
 * authentication_model Class
 *
 * @description Authentication in login system
 * @author 
 * @package models
 */

class authentication_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    /**
     * initialize 
     * 
     * @description initializes the class with the parameters
     * @param  string $group
     * @param  string $session_name
     * @return void
     */
    function initialize($group,$session_name = 'admin') {
        $this->group_id     = $group;
        $this->session_name = $session_name;
    }

    /**
     * login 
     *
     * @description login authentication 
     * @param  string  $email
     * @param  string  $pass
     * @param  boolean $expire_close
     * @return bool 
     */
    function login($email, $pass, $expire_close = TRUE) {
   		$this->db->select("user.*, user_group.title group_title");
   		$this->db->from("user");
   		$this->db->join('user_group','user.user_group_id = user_group.id','left');
   		$this->db->where("user.email = ".$this->db->escape($email)." AND user.user_group_id IN ({$this->group_id}) AND user.status = '1' AND user.type_id = '1' ");
        
   		$query = $this->db->get();
   		
        if ($query->num_rows == 1) {
            $row = $query->row();
            
            /* set user_data for box login correct user */
            $_image_user = is_file('./upload/user/'.$row->image) ? $row->image : 'default.jpg';
            
            $this->user_data = array('name' => $row->name, 'email' => $row->email, 'image' => 'upload/user/'.$_image_user);

            if (md5($pass) == $row->pass) {
            	$_userdata = array(
            		'user_id' 			=> $row->id,
            		'user_name' 		=> $row->name,
            		'user_email' 		=> $row->email,
            		'user_nick' 		=> $row->nick,
            		'user_group_id' 	=> $row->user_group_id,
            		'user_group_title'  => $row->group_title,
            		'user_token' 		=> sha1($row->id),
                    'user_session_auth' => $this->session->userdata('session_id')
            	);
                
                // change session
                $this->db->set(array('session_auth'=>$_userdata['user_session_auth']))->where(array('id'=>$_userdata['user_id']))->update('user');

                // persist login
                $this->session->sess_expire_on_close = $expire_close;
                  
                $this->session->set_userdata($this->session_name,$_userdata);

                $return = true;
            } else
                $return = false;
        } else
            $return = false;

        return $return;
    }
    
    /**
     * check_auth
     * 
     * @description check if user enter in system authentication
     * @return bool
     */
    function check_auth() {
    	$_login = $this->session->userdata($this->session_name);    	
        $token 	= sha1($_login['user_id']);
        
        if ($_login['user_token'] == $token) {
            $this->db->select("id");
            $this->db->from("user");
            $this->db->where(array('id'=>$_login['user_id'],'user_group_id IN '=>"({$this->group_id})",'status'=>'1','type_id'=>'1'),'',FALSE);

            // validate 1 user per session
            //$this->db->like(array('session_auth'=>$_login['user_session_auth']));
            
            $query = $this->db->get();
            	
            if ($query->num_rows() != 1) {
                $this->logout();
                return false;
            }
        } else {
            $this->logout();
        	return false;
        }
        
        return true;
    }
    
    /**
     * logout
     * 
     * @description logout in authentication
     * @return void
     */
    function logout() {
        $this->session->unset_userdata($this->session_name);
        return true;
    }
}