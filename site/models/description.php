<?php
/**
 * @version $Id: registration.php 177 2011-03-03 16:55:21Z chaan $
 */

//No direct acesss
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class JptpModelDescription extends JModel
{ 
    protected $_event;
  
    function getEvent(){
        $event_id = JRequest::getInt('event_id');
        $query = 'SELECT e.*, t.title, CONCAT(a.name, " - ", a.description) as audience, '
               . ' t.description, t.prerequisites, t.ceu_credits'
               . ' FROM #__jptp_events AS e LEFT JOIN #__jptp_trainings AS t ON e.training_id = t.id'
               . ' LEFT JOIN #__jptp_audiences AS a ON a.id = t.audience_id '
               . ' WHERE e.id = ' . $event_id;
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $this->_event = $db->loadObject();
        return $this->_event;
    }
    
    function getTrainers(){
        $event_id = JRequest::getInt('event_id');
        $query = 'SELECT t.* FROM #__jptp_trainers AS t LEFT JOIN #__jptp_event_trainers AS et ON t.id = et.trainer_id'
               . ' WHERE et.event_id = ' . $event_id;
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $trainers = $db->loadObjectList();
        return $trainers;
    }
    
    function getSite(){
        $event_id = JRequest::getInt('event_id');
        $query = 'SELECT s.* FROM #__jptp_sites AS s LEFT JOIN #__jptp_events AS e ON s.id = e.site_id WHERE e.id = ' . $event_id;
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $site = $db->loadObject();
        return $site;
    }
    
    function getApprovals(){
        $event_id = JRequest::getInt('event_id');
        $query = 'SELECT lo.name FROM #__jptp_licensing_orgs AS lo LEFT JOIN #__jptp_training_approvals AS ta ON lo.id = ta.licensing_org_id'
               . ' LEFT JOIN #__jptp_events AS e ON ta.training_id = e.training_id'
               . ' WHERE e.id = ' . $event_id;
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $approvals = $db->loadResultArray();
        return $approvals;
    }
}
?>
