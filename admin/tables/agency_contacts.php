<?php
/**
 * @version $Id $
 * 
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableAgency_contacts extends JTable
{
    var $id = null;
    var $agency_id = null;
    var $address = null;
    var $address2 = null;
    var $city = null;
    var $state = null;
    var $zip = null;
    var $phone = null;
    var $fax = null;
    var $timestamp = null;
    var $event_id = null;
    var $first_name = null;
    var $last_name = null;
	
    function __construct(&$db)
    {
        parent::__construct('#__jptp_agency_contacts', 'id' , $db);
    }
    
}

?>