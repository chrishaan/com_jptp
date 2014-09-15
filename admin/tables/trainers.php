<?php
/**
 * @version $Id $
 * 
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableTrainers extends JTable
{
    var $id = null;
    var $first_name = null;
    var $last_name = null;
    var $credentials = null;
    var $title = null;
    var $organization = null;
    var $city = null;
    var $state = null;
    var $zip = null;
    var $biography = null;
    var $published = null;
	
    function __construct(&$db)
    {
        parent::__construct('#__jptp_trainers', 'id' , $db);
    }
    
}

?>