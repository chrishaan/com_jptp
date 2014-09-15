<?php
/**
 * @version $Id $
 * 
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableSites extends JTable
{
    var $id = null;
    var $name = null;
    var $address = null;
    var $address2 = null;
    var $city = null;
    var $state = null;
    var $zip = null;
    var $notes = null;
    var $published = null;
    var $capacity = null;
    
    function __construct(&$db)
    {
        parent::__construct('#__jptp_sites', 'id' , $db);
    }
    
}

?>