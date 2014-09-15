<?php
/**
 * @version $Id $
 * 
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableTrainings extends JTable
{
    var $id = null;
    var $title = null;
    var $audience_id = null;
    var $prerequisites = null;
    var $description = null;
    var $ceu_credits = null;
    var $published = null;
    var $participant_limit = null;
    
    function __construct(&$db)
    {
        parent::__construct('#__jptp_trainings', 'id' , $db);
    }

    //function check(){
    //    $this->description = JRequest::getVar('description','','POST','STRING',JREQUEST_ALLOWRAW);
    //    return true;
    //}


}

?>
