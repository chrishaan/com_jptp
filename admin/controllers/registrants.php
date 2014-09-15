<?php
/**
 * @version $Id:  $
 */
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.application.component.controller');

class JptpControllerRegistrants extends JController
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
        JRequest::setVar('view', 'edit_registrant');
        $this->display();
    }

    function save()
    {
        $option = JRequest::getCmd('option', '');
        // if no confid is defined, this will be a new entry. Need to know this
        // to create a new entry in the options table if type == okil
        $new_conference = !JRequest::getInt('id');

        $row =& JTable::getInstance('registrants', 'Table');

        if (!$row->bind(JRequest::get('post'))) {
                JError::raiseError(500, $row->getError() );
        }

        if (!$row->store()) {
                JError::raiseError(500, $row->getError() );
        }

        $msg = '';

        if ($this->getTask() == 'apply') {
            $this->setRedirect('index.php?option=' . $option . '&task=edit&cid[]=' . $row->id  . '&controller=registrants', 'Changes Applied');
        } else {
            $this->setRedirect('index.php?option=' . $option . '&controller=registrants', 'Registrant Saved');
        }
    }

    function publish()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        global $option;

        $cid = JRequest::getVar('cid', array());

        $row =& JTable::getInstance('registrants', 'Table');

        $publish = ($this->getTask() == 'publish') ? 1 : 0;

        if(!$row->publish($cid, $publish)) {
                JError::raiseError(500, $row->getError() );
        }
        
        $msg = 'Registrant';
        $msg .= (count($cid) > 1) ? 's ' : ' ';
        $msg .= $this->getTask() . 'ed';

        $this->setRedirect('index.php?option='.$option, $msg);

    }
    
    function remove()
    {
        JRequest::checkToken() or jexit( 'Invalid Token' );
        $option = JRequest::getCMD('option');

        $cid = JRequest::getVar('cid', array(0));

        $row =& JTable::getInstance('registrants', 'Table');

        foreach ($cid as $id) {
            $id = (int) $id;
            $row->load($id);
            if (!$row->delete($id)) {
                JError::raiseError(500, $row->getError() );
            }
            
            $this->setRedirect('index.php?option=' . $option . '&controller=registrants', 'Registrant Deleted');
        }

        $msg = 'Registrant';
        $msg .= (count($cid) > 1) ? 's ' : ' ';
        $msg .= 'deleted';

        $this->setRedirect('index.php?option=' . $option, $msg );
    }

    function display()
    {
        $view = JRequest::getVar('view');

        if (!$view) {
            JRequest::setVar('view', 'registrants');
        }
        parent::display();
    }
}


?>