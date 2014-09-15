<?php
/**
 * @version $Id $
 * 
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableEvents extends JTable
{
    var $id = null;
    var $start_date = null;
    var $end_date = null;
    var $training_id = null;
    var $event_type_id = null;
    var $registration_time = null;
    var $start_time = null;    
    var $end_time = null;
    var $start_time2 = null; // day 2
    var $end_time2 = null;   // day 2
    var $link = null;
    var $site_id = null;
    var $published = null;
    var $pif = null;
    var $status = null;
    var $registration_count = null;
	
    function __construct(&$db)
    {
        parent::__construct('#__jptp_events', 'id' , $db);
    }
    
}

?>