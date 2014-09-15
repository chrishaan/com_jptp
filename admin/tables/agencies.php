<?php
/**
 * @version $Id $
 * 
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableAgencies extends JTable
{
    var $id = null;
    var $name = null;
    var $published = null;
    var $address = null;
    var $address2 = null;
    var $city = null;
    var $state = null;
    var $zip = null;
    var $phone = null;
    var $fax = null;
    var $director_first_name = null;
    var $director_last_name = null;
    var $director_email = null;
    var $listserv  = null;
    var $services = null;
    var $youth_focus = null;
    var $youth_percent = null;
    var $type = null;
    var $funding_sources = null;
    var $primary_clientele = null;
    var $annual_clientele = null;
    var $staff_count = null;
    var $staff_education = null;
    var $networking_agencies = null;
    var $comments = null;
    var $time = null;
    
    function __construct(&$db)
    {
        parent::__construct('#__jptp_agencies', 'id' , $db);
    }
    
}

?>