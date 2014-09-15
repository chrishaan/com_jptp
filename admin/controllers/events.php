<?php
/**
 * @version $Id:  $
 */
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.application.component.controller');

class JptpControllerEvents extends JController
{
    function __construct($config = array())
    {
        parent::__construct($config);

        $this->registerTask('unpublish', 'publish');
        $this->registerTask('apply', 'save');
        $this->registerTask('add', 'edit');
    }

    function edit()
    {
        JRequest::setVar('view', 'edit_event');
        $this->display();
    }

    function save()
    {
        $option = JRequest::getCmd('option', '');
        //$new_conference = !JRequest::getInt('id');

        $row =& JTable::getInstance('events', 'Table');

        if (!$row->bind(JRequest::get('post'))) {
                JError::raiseError(500, $row->getError() );
        }

        if (!$row->store()) {
                JError::raiseError(500, $row->getError() );
        }

        $msg = '';

        if ($this->getTask() == 'apply') {
            $this->setRedirect('index.php?option=' . $option . '&task=edit&cid[]=' . $row->id  . '&controller=events', 'Changes Applied');
        } else {
            $this->setRedirect('index.php?option=' . $option . '&controller=events', 'Event Saved');
        }
    }

    function publish()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        global $option;

        $cid = JRequest::getVar('cid', array());

        $row =& JTable::getInstance('events', 'Table');

        $publish = ($this->getTask() == 'publish') ? 1 : 0;

        if(!$row->publish($cid, $publish)) {
                JError::raiseError(500, $row->getError() );
        }
        
        $msg = 'Event';
        $msg .= (count($cid) > 1) ? 's ' : ' ';
        $msg .= $this->getTask() . 'ed';

        $this->setRedirect('index.php?option='.$option.'&controller=events', $msg);

    }
    
    function remove()
    {
        JRequest::checkToken() or jexit( 'Invalid Token' );
        $option = JRequest::getCMD('option');

        $cid = JRequest::getVar('cid', array(0));

        $row =& JTable::getInstance('events', 'Table');

        foreach ($cid as $id) {
            $id = (int) $id;
            $row->load($id);
            if (!$row->delete($id)) {
                JError::raiseError(500, $row->getError() );
            }
        }

        $msg = 'Event';
        $msg .= (count($cid) > 1) ? 's ' : ' ';
        $msg .= 'deleted';

        $this->setRedirect('index.php?option=' . $option . '&controller=events', $msg );
    }

    function display()
    {
        $view = JRequest::getVar('view');

        if (!$view) {
            JRequest::setVar('view', 'events');
        }
        parent::display();
    }
    
    
    function add_trainer()
    {
        $event_id = JRequest::getVar('event_id', '');
        $trainer_id = JRequest::getVar('trainer_id', '');
        if (empty($event_id) || empty($trainer_id)){
            exit;
        }
        $query = "INSERT INTO #__jptp_event_trainers (event_id, trainer_id ) VALUES ( {$event_id} , {$trainer_id} )";
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $db->query();
      
        $this->get_trainers();
    }
    
    function remove_trainer()
    {
        // request license_id be removed from training_id, on success, return the license_id removed, on failure, return 0
        $event_id = JRequest::getVar('event_id', '');
        $trainer_id = JRequest::getVar('trainer_id', '');
        if (empty($event_id) || empty($trainer_id)){
            exit;
        }
        $query = "DELETE FROM #__jptp_event_trainers WHERE event_id={$event_id} AND trainer_id={$trainer_id}";
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $db->query();

        $this->get_trainers();
    }
    
    function get_trainers()
    {
        $event_id = JRequest::getVar('event_id', '');
        if(empty($event_id)) {
            exit;
        }
        $query = "SELECT t.id, CONCAT(t.last_name, ', ', t.first_name) AS name FROM #__jptp_trainers AS t LEFT JOIN #__jptp_event_trainers AS et ON et.trainer_id = t.id";
        $query .= " WHERE et.event_id=" . $event_id;
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $result = $db->loadAssocList();

        echo json_encode( $result );
        $mainframe = JFactory::getApplication();
        $mainframe->close();
    }
    
}


?>
