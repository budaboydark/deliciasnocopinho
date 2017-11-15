<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Number helper
 *
 * @description Function to help and extensions CI number helper
 * @author 
 * @package helpers
*/
 
/**
 * to_decimal
 * 
 * @description format value to decimal
 * @param string $valor
 * @return void
 */
if ( ! function_exists('to_decimal'))
{
	function to_decimal($valor){
		$valor = str_replace(".","",$valor);
		$valor = str_replace(",",".",$valor);
		
		if(strlen($valor) > 6) {
			$valor = str_replace(",",".",$valor);
		}
		$valor = str_replace(",",".",$valor);
		
		return $valor;
	}
}

/**
 * to_decimal
 * 
 * @description format decimal to value
 * @param string $valor
 * @param string $sigla (default: FALSE)
 * @return void
 */
if ( ! function_exists('to_val'))
{
	function to_val($valor,$sigla=FALSE){
		$valor = number_format((float)$valor,2,",",".");
		if($sigla)	return $sigla.' '.$valor;
		else		return $valor;
	}
}

/* End of file MY_number_helper.php */
/* Location: ./applicaton/helpers/MY_number_helper.php */