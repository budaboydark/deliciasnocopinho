<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
 
/**
 * is_euro_date 
 *
 * @description verify date is format euro
 * @param  string $date format 2000-10-01 or 01/10/2000
 * @param  array $regs
 * @return boolean 
 */
function is_euro_date($date, &$regs) {
	$date = trim($date);
	if (ereg("^([0-9]{1,2})(/|\-|\.)([0-9]{1,2})(/|\-|\.)([0-9]{4})([[:space:]]([0-9]{1,2}):([0-9]{1,2}):?([0-9]{1,2})?)?$", $date, $matches)) {
		$regs = array(
			$matches[0], 
			$matches[1], $matches[3], $matches[5], 
			$matches[6], $matches[7], $matches[8]
		);
		return TRUE;
	}
	return FALSE;
}

/**
 * is_sql_date 
 *
 * @description verify date is format sql
 * @param  string $date format 2000-10-01 or 01/10/2000
 * @param  array $regs
 * @return boolean 
 */
function is_sql_date($date, &$regs) {
	$date = trim($date);
	return (ereg("^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})([[:space:]]([0-9]{1,2}):([0-9]{1,2}):?([0-9]{1,2})?)?$", $date, $regs));
}

/**
 * format_euro_to_sql
 *
 * @description format date to format sql
 * @param  string $date format 2000-10-01 or 01/10/2000
 * @return string format 2000-10-01
 */
function format_euro_to_sql($date) {
	if (is_euro_date($date, $regs)) {
		return "$regs[3]-$regs[2]-$regs[1]";
	} else {
		return $date;
	}
}
	
/**
 * format_sql_to_euro
 *
 * @description format date to format euro
 * @param  string $date format 2000-10-01 or 01/10/2000
 * @return string format 01/10/2000
 */
function format_sql_to_euro($date) {
	if (is_sql_date($date, $regs)) {
		return "$regs[3]/$regs[2]/$regs[1]";
	} else {
		return $date;
	}
}

/**
 * format_intdate_to_us
 *
 * @description format date to format sql
 * @param  string $date format 20001001
 * @return string format 2000-10-01
 */
function format_intdate_to_sql($date) {
	if (preg_match('/^\d{4}\d{2}\d{2}$/', $date))
	    return substr($date, 0, 4).'-'.substr($date, 4, 2).'-'.substr($date, 6, 2);
	else
		return $date;
}

/**
 * diff_date description
 * @param  string $d1 date format 2000-10-01
 * @param  string $d2 date format 2000-10-01
 * @param  string $type format return Y = Year, M = Month, D = Day, H = Hour, MI = Minutes
 * @param  string $sep separator format (- or / ), default -
 * @return int 
 */
if (!function_exists('diff_date')) {
	function diff_date($d1, $d2, $type='D', $sep='-') {
		$d1 = explode($sep, $d1);
		$d2 = explode($sep, $d2);
		switch ($type) {
			case 'Y':
				$X = 31536000;
			break;
			case 'M':
				$X = 2592000;
			break;
			default:
			case 'D':
				$X = 86400;
			break;
			case 'H':
				$X = 3600;
			break;
			case 'MI':
				$X = 60;
			break;
		}
		return floor( ( ( mktime(0, 0, 0, $d2[1], $d2[2], $d2[0]) - mktime(0, 0, 0, $d1[1], $d1[2], $d1[0] ) ) / $X ) );
	}
}


/* End of file MY_date_helper.php */
/* Location: ./applicaton/helpers/MY_date_helper.php */