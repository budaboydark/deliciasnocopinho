<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sitemap controller
 *
 * @description Generate sitemap.xml 
 * @extends MY_Controller
 */

class Sitemap extends MY_Controller {

    public function index() {
	    header("Content-Type: text/xml; charset=UTF-8");

	    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
		<urlset
		      xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
		      xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
		      xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
		            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">
					";
			
			/* core url */
			$this->db->select('*')->from('core_url')->not_like('url_old','sitemap')->not_like('url_old','administrador');
			$rs = $this->db->get()->result_array();
				
			foreach ($rs as $r) {
				$r['url'] = trim($r['url']);
				$d = date(DATE_ATOM, mktime(date("H"), date("i"), date("s"), date("m"), date("d")-1, date("Y"))); //("l F d, Y"))
				echo "
				<url>
				  <loc><![CDATA[".base_url()."{$r['url']}]]></loc>
				  <lastmod>{$d}</lastmod>
				  <changefreq>weekly</changefreq>
				  <priority>1.00</priority>
				</url>";
			}
		echo "
		</urlset>";
		
        die;
    }
}

/* End of file sitemap.php */
/* Location: ./application/controllers/sitemap.php */