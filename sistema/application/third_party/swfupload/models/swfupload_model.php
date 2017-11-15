<?php
/**
 * swfupload_model Class
 *
 * @description SWFupload model to up files
 * @author 
 * @package models
 */

class Swfupload_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public $rel;
    public static $folder = 'gallery';
    public static $table  = 'gallery';
    
    /**
     * run
     *
     * @description load gallery swfupload to file view
     * @param  mixed $rel_id related id table reference
     * @return void
     */
    public function run($rel_id = FALSE) {
        session_start();

        $data = array('rel' => $this->rel, 'folder' => $this->folder );

        // config swfu 
        $data['swfu'] = array(
              'session'             => session_id()
            , 'size'                => "1 MB"
            , 'upload_url'          => base_url()."swfupload/upload/".$this->rel."/".$this->folder
            , 'limit'               => "0"
            , 'format'              => "*.jpg;*.png"
            , 'format_description'  => "arquivos de imagens JPG e PNG"
        );

        if($rel_id != FALSE):
            $this->db->select('id, title, file, order, status')->from(self::$table);
            $this->db->where(array('rel'=>$this->rel,'rel_id'=>$rel_id))->order_by('order','ASC');

            $data['result'] = $this->db->get()->result_array();

            foreach($data['result'] as $_result):
                $_sess[$this->rel][$_result['file']] = $_result;
            endforeach;
        endif;

        $_SESSION['swfupload'] = $_sess;

        $this->load->view('swfupload/swfupload',$data);
    }

    /**
     * save 
     *
     * @description save session data in database
     * @param  mixed $rel_id related id table reference
     * @return void
     */
    public function save($rel_id) {
        session_start();

        // add/update data
        foreach($_SESSION['swfupload'][$this->rel] as $gallery):
            $gallery['rel']          = $this->rel;
            $gallery['rel_id']       = $rel_id;
            $gallery['date_modified'] = date('Y-m-d H:i:s');

            if(isset($gallery['id'])):
                $this->db->where(array('id'=>$gallery['id']))->update(self::$table,$gallery);
                $_id[] = $gallery['id'];
            else:
                $this->db->insert(self::$table,$gallery);
                $_id[] = $this->db->insert_id();
            endif;
        endforeach;

        // delete data
        if(count($_id) > 0)
            $this->db->where_not_in('id',$_id);

        $this->db->where(array('rel'=>$this->rel,'rel_id'=>$rel_id))->delete(self::$table);
        
        unset($_SESSION['swfupload']);
    }

    /**
     * upload
     * 
     * @description upload and save image in method call by swfupload
     * @param  string $rel  relation varible to gallery
     * @param  string $folder
     * @return void
     */
    public function upload($rel,$folder) {
        if(!isset($folder)) $folder = self::$folder;
        
        $folder_thumb   = "media/upload/{$folder}/";
        $folder         = "./upload/{$folder}/";

        if (isset($_POST["PHPSESSID"])) session_id($_POST["PHPSESSID"]);
        session_start();
        
        // Check the upload and do it
        if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0):
            echo "ERROR:invalid upload";
            exit(0);
        endif;
        
        // save file image
        $config['upload_path']      = $folder;
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']         = '1024';
        $config['encrypt_name']     = TRUE;
        $config['overwrite']        = FALSE;
        
        $this->upload->initialize($config);         
        
        if(!$this->upload->do_upload("Filedata")):
            echo $this->upload->display_errors();
            exit(0);
        endif;
        unset($config);
        
        $data = $this->upload->data();
        
        // resize image
        $config['image_library']    = 'gd2';
        $config['source_image']     = $data['full_path'];
        $config['maintain_ratio']   = TRUE;
        
        if($data['image_width'] > 1024 || $data['image_height'] > 768):
             $config['width'] = 1024;
             $config['height'] = 768;
        endif;
        
        $config['quality']          = '90%';

        #@! watermark
        
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        
        /* session configs */
        $this->save_param($rel,$data['file_name'],'file',$data['file_name'],FALSE);
        $this->save_param($rel,$data['file_name'],'status','1',FALSE);
        
        echo "FILEID:" . $data['file_name'];    // Return the file id to the script
    }

    /**
     * thumbnail
     * 
     * @description thumbnail generator by swfupload in view
     * @param  string $rel  relation varible to gallery
     * @param  string $folder
     * @return void
     */
    public function thumbnail($rel, $_folder) {
        if(!isset($_folder)) $_folder = self::$folder;
        
        $folder_thumb = "media/upload/{$_folder}/";
        
        $image_id = isset($_GET["id"]) ? $_GET["id"] : false;
        
        if ($image_id === false) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "No ID";
            exit(0);
        }
        
        header("Content-type: image/jpeg") ;
        header("Content-Length: ");
        echo file_get_contents(base_url().image($folder_thumb.$image_id,'140x100'));
        exit(0);
    }

    /**
     * order
     * 
     * @description save order to all images on session
     * @access public
     * @param  string $rel  relation varible to gallery
     * @return void
     */
    public function order($rel) {
        session_start();
        
        $_files = explode(';',$this->input->post('files',TRUE));
        
        $i = 1;     
        foreach($_files as $file):
            $_SESSION['swfupload'][$rel][$file]['order'] = $i;
            $i++;
        endforeach;
    }

    /**
     * save_edit
     * 
     * @description save data in modal
     * @param  string $rel  relation varible to gallery
     * @param  string $file file name
     * @return void
     */
    public function save_edit($rel,$file) {
        $data = $this->input->post(NULL,TRUE);
        foreach($data as $k=>$value) $this->save_param($rel,$file,$k,$value,FALSE);
    }

    /**
     * edit
     * 
     * @description edit data to modal 
     * @param  string $rel  relation varible to gallery
     * @param  string $file file name
     * @return void
     */
    public function edit($rel,$file) {
        session_start();
        
        $_result = $_SESSION['swfupload'][$rel][$file];
        
        $_result['rel']     = $rel;
        $_result['file']    = $file;
        
        return $this->load->view('swfupload/edit',$_result,TRUE);
    }

    /**
     * get_detail
     *
     * @description get detail to image upload to list imagem in view
     * @access public
     * @param  string $rel    relation variable to gallery
     * @param  string $folder
     * @param  string $file    file name
     * @return void
     */
    public function get_detail($rel,$folder,$file) {
        $_result['rel']     = $rel;
        $_result['file']    = $file;
        $_result['folder']  = $folder;
        
        return $this->load->view('swfupload/detail',$_result,TRUE);
    }

    /**
     * delete_file
     * 
     * @description delete file in session
     * @access public
     * @return void
     */
    public function delete_file($rel,$file) {
        session_start();
        unset($_SESSION['swfupload'][$rel][$file]);
    }

    /**
     * save_param
     * 
     * @description save title to image in session
     * @access public
     * @return void
     */
    public function save_param($rel,$file,$param,$value) {
        session_start();
        
        $_SESSION['swfupload'][$rel][$file][$param] = strval($value);
    }
}