<?php
/**
 * @version $Id $
 * 
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableEvent_types extends JTable
{
    var $id = null;
    var $name = null;
    var $description = null;
    var $published = null;
    
    function __construct(&$db)
    {
        parent::__construct('#__jptp_event_types', 'id' , $db);
    }
    
}

?>