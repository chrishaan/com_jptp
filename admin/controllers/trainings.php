<?php
/**
 * @version $Id:  $
 */
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.application.component.controller');

class JptpControllerTrainings extends JController
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
        JRequest::setVar('view', 'edit_training');
        $this->display();
    }

    function save()
    {
        $option = JRequest::getCmd('option', '');
        // if no confid is defined, this will be a new entry. Need to know this
        // to create a new entry in the options table if type == okil
        $new_conference = !JRequest::getInt('id');

        $row =& JTable::getInstance('trainings', 'Table');

        if (!$row->bind(JRequest::get('post'))) {
                JError::raiseError(500, $row->getError() );
        }

	$row->description = JRequest::getVar('description','','POST','STRING',JREQUEST_ALLOWRAW);
	$row->prerequisites = JRequest::getVar('prerequisites','','POST','STRING',JREQUEST_ALLOWRAW);

        if (!$row->store()) {
                JError::raiseError(500, $row->getError() );
        }

        $msg = '';

        if ($this->getTask() == 'apply') {
            $this->setRedirect('index.php?option=' . $option . '&task=edit&cid[]=' . $row->id  . '&controller=trainings', 'Changes Applied');
        } else {
            $this->setRedirect('index.php?option=' . $option . '&controller=trainings', 'Training Saved');
        }
    }

    function publish()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        global $option;

        $cid = JRequest::getVar('cid', array());

        $row =& JTable::getInstance('trainings', 'Table');

        $publish = ($this->getTask() == 'publish') ? 1 : 0;

        if(!$row->publish($cid, $publish)) {
                JError::raiseError(500, $row->getError() );
        }
        
        $msg = 'Trainer';
        $msg .= (count($cid) > 1) ? 's ' : ' ';
        $msg .= $this->getTask() . 'ed';

        $this->setRedirect('index.php?option='.$option, $msg);

    }
    
    function remove()
    {
        JRequest::checkToken() or jexit( 'Invalid Token' );
        $option = JRequest::getCMD('option');

        $cid = JRequest::getVar('cid', array(0));

        $row =& JTable::getInstance('trainings', 'Table');

        foreach ($cid as $id) {
            $id = (int) $id;
            $row->load($id);
            if (!$row->delete($id)) {
                JError::raiseError(500, $row->getError() );
            }
        }

        $msg = 'Training';
        $msg .= (count($cid) > 1) ? 's ' : ' ';
        $msg .= 'deleted';

        $this->setRedirect('index.php?option=' . $option . '&controller=trainings', $msg );
    }

    function display()
    {
        $view = JRequest::getVar('view');

        if (!$view) {
            JRequest::setVar('view', 'trainings');
        }
        parent::display();
    }
    
    
    function add_approval()
    {
        $training_id = JRequest::getVar('training_id', '');
        $licensing_id = JRequest::getVar('lic_id', '');
        if (empty($training_id) || empty($licensing_id)){
            exit;
        }
        $query = "INSERT INTO #__jptp_training_approvals (training_id, licensing_org_id ) VALUES ( {$training_id} , {$licensing_id} )";
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $db->query();
      
        $this->get_approvals();
    }
    
    function remove_approval()
    {
        // request license_id be removed from training_id, on success, return the license_id removed, on failure, return 0
        $training_id = JRequest::getVar('training_id', '');
        $licensing_id = JRequest::getVar('lic_id', '');
        if (empty($training_id) || empty($licensing_id)){
            exit;
        }
        $query = "DELETE FROM #__jptp_training_approvals WHERE training_id={$training_id} AND licensing_org_id={$licensing_id}";
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $db->query();

        $this->get_approvals();
    }
    
    function get_approvals()
    {
        $training_id = JRequest::getVar('training_id', '');
        if(empty($training_id)) {
            exit;
        }
        $query = "SELECT lo.id, lo.name FROM #__jptp_training_approvals AS ta LEFT JOIN #__jptp_licensing_orgs AS lo ON ta.licensing_org_id = lo.id";
        $query .= " WHERE ta.training_id=" . $training_id;
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $result = $db->loadAssocList();

        echo json_encode( $result );
        $mainframe = JFactory::getApplication();
        $mainframe->close();
    }
    
}


?>
