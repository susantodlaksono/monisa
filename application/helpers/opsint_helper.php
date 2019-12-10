<?php 

if (!defined('BASEPATH')) 
	exit('No direct script access allowed');

/**
 *
 * @author SUSANTO DWILAKSONO
 */

// Menghitung sisa hari dari 2 tanggal
if (!function_exists('compare_left_days')) { 
    function compare_left_days($sdate, $edate){
        $interval = $sdate->diff($edate);
		return $interval->days;
    }
}