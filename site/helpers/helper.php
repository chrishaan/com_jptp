<?php
defined('_JEXEC') or die('Restricted access');

class JptpHelper
{
    public static function format_time( $time ) {
        $hms = explode(":", $time );
        $ampm = ($hms[0] > 11) ? "pm" : "am";
        $hms[0] = ($hms[0] > 12) ? (int)$hms[0] - 12 : (int)$hms[0];
        
        return $hms[0] . ":" . $hms[1] . " " . $ampm;
    }    
    
}