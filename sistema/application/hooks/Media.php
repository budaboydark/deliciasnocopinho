<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Media Class
 *
 * @author 
 * @package hooks
 * @description Implements system cache and thumb for imgaes
 */

class Media {
 	
	/**
	* Init config Media
	* This method call by hooks.php
	*
	* @author 
	* @return
	*/
	public function init() {
		if(strstr($this->_detect_uri(),'media/')):
			require_once(BASEPATH.'libraries/Image_lib'.EXT); 
			require_once(APPPATH.'libraries/MY_Image_lib'.EXT);
			include APPPATH.'config/config.php';
		    include APPPATH.'config/images.php';
        
			$this->config = $config;
	    	$this->resize();
    	endif;
	}

	private function resize() {

        // basic info
		$path     = str_replace('media/', '', strstr($this->_detect_uri(),'media/'));
		$pathinfo = pathinfo($path);
		$size     = end(explode("-", $pathinfo["filename"]));
		$original = $pathinfo["dirname"] . "/" . str_ireplace("-" . $size, "", $pathinfo["basename"]);
        
        $path = $this->config['cache_path'].'image/'.$pathinfo["basename"];

        // original image not found, show 404
        if (!file_exists($original)) {
            show_404($original);
        }
        
        // load the allowed image sizes
        $allowed = TRUE;
         
        if (stripos($size, "x") !== FALSE) {
            // dimensions are provided as size
            @list($width, $height) = explode("x", $size);

            // security check, to avoid users requesting random sizes
            foreach ($sizes as $s) {
                if ($width == $s[0] && $height == $s[1]) {
                    $allowed = TRUE;
                    break;
                }
            }
        } else {
            $allowed = FALSE;
        }
        
        // only continue with a valid width and height
        if ($allowed && $width >= 0 && $height >= 0) {
            // initialize library
            $config["source_image"]   = $original;
            $config['new_image']      = $path;
            $config["width"]          = $width;
            $config["height"]         = $height;
            $config["dynamic_output"] = FALSE; // always save as cache
            
            if(!is_file($path)):
                $image_lib = new MY_Image_lib();
                $image_lib->initialize($config);
                $image_lib->fit();
            endif;
        }
        
        // check if the resulting image exists, else show the original
        if (file_exists($path)) {
            $output = $path;
        } else {
            $output = $original;
        }
        
        $info = getimagesize($output);
        
        // output the image
        header("Content-Disposition: filename={$output};");
        header("Content-Type: {$info["mime"]}");
        header('Content-Transfer-Encoding: binary');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        
        readfile($output);
        die;
    }

    private function _detect_uri() {        
        if ( ! isset($_SERVER['REQUEST_URI']) OR ! isset($_SERVER['SCRIPT_NAME']))
        {
            return '';
        }

        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
        {
            $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        }
        elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
        {
            $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }

        // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
        // URI is found, and also fixes the QUERY_STRING server var and $_GET array.
        if (strncmp($uri, '?/', 2) === 0)
        {
            $uri = substr($uri, 2);
        }
        $parts = preg_split('#\?#i', $uri, 2);
        $uri = $parts[0];
        if (isset($parts[1]))
        {
            $_SERVER['QUERY_STRING'] = $parts[1];
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        }
        else
        {
            $_SERVER['QUERY_STRING'] = '';
            $_GET = array();
        }

        if ($uri == '/' || empty($uri))
        {
            return '/';
        }

        $uri = parse_url($uri, PHP_URL_PATH);

        // Do some final cleaning of the URI and return it
        return str_replace(array('//', '../'), '/', trim($uri, '/'));
    }

}