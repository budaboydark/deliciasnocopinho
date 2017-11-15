<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Html helper
 *
 * @description Function to help and extensions CI html helper
 * @author 
 * @package helpers
*/
 
/**
 * script_tag
 *
 * @description Generates script to a JS file
 * @access public
 * @param mixed scripts hrefs or an array
 * @param string type
 * @param string title
 * @param string media
 * @param boolean should index_page be added to the css path
 * @return string
 */
if ( ! function_exists('script_tag'))
{
	function script_tag($href = '', $type = 'text/javascript', $title = '', $media = '', $index_page = FALSE)
	{
		$CI =& get_instance();

		$link = '
		<script ';

		if (is_array($href))
		{
			foreach ($href as $k=>$v)
			{
				if ($k == 'src' AND strpos($v, '://') === FALSE)
				{
					if ($index_page === TRUE)
					{
						$link .= 'src="'.$CI->config->site_url($v).'" ';
					}
					else
					{
						$link .= 'src="'.$CI->config->slash_item('base_url').$v.'" ';
					}
				}
				else
				{
					$link .= "$k=\"$v\" ";
				}
			}

			$link .= "/>";
		}
		else
		{
			if ( strpos($href, '://') !== FALSE)
			{
				$link .= 'src="'.$href.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$link .= 'src="'.$CI->config->site_url($href).'" ';
			}
			else
			{
				$link .= 'src="'.$CI->config->slash_item('base_url').$href.'" ';
			}

			$link .= 'type="'.$type.'" ';

			if ($media	!= '')
			{
				$link .= 'media="'.$media.'" ';
			}

			if ($title	!= '')
			{
				$link .= 'title="'.$title.'" ';
			}

			$link .= '/></script>';
		}


		return $link;
	}
}

/* End of file MY_html_helper.php */
/* Location: ./applicaton/helpers/MY_html_helper.php */