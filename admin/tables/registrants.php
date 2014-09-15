<?php
/**
 * @version $Id $
 * 
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableRegistrants extends JTable
{
    var $id = null;
    var $contact_id = null;
    var $first_name = null;
    var $last_name = null;
    var $job_title = null;
    var $phone = null;
    var $email = null;
    var $special_services = null;
    var $cancel_hash = null;
    var $cancel_date = null;
    var $cancelled = null;
	
    function __construct(&$db)
    {
        parent::__construct('#__jptp_registrants', 'id' , $db);
    }
    
}

?>