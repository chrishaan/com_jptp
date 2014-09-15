<?php
/**
 * @version $Id $
 * 
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableLicensing_orgs extends JTable
{
    var $id = null;
    var $name = null;
    var $published = null;
    
    function __construct(&$db)
    {
        parent::__construct('#__jptp_licensing_orgs', 'id' , $db);
    }
    
}

?>