<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Format Number
 *
 * Given a number of any length, if possible, add commas and periods
 * and return the result.
 *
 * @author      Adam Brenner <aebrenne@uci.edu>
 * @version     2013-09-17
 */
function formatNumber( $number )
{
    return number_format( $number, 0 , '.', ',' );
}

?>