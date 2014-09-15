<?php
/**
 * @version $Id:$
 */
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.application.component.controller');

class JptpControllerAgencies extends JController
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
        JRequest::setVar('view', 'agency');
        $this->display();
    }

    function save()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $option = JRequest::getCmd('option', '');

        $row =& JTable::getInstance('agencies', 'Table');

        if (!$row->bind(JRequest::get('post'))) {
                JError::raiseError(500, $row->getError() );
        }

        if (!$row->store()) {
                JError::raiseError(500, $row->getError() );
        }
        
        $approved_memory = JRequest::getVar('approved_memory');
        $published = JRequest::getVar('published');
        
        if ($approved_memory == "0" && $published == "1" ){
            $this->_task = 'apply';
            JRequest::setVar('view', 'agency');            
            JRequest::setVar('layout', 'approval');
            $this->setRedirect('index.php?option=' . $option . '&task=edit&cid[]=' . $row->id  . '&controller=agencies&layout=approval', 'Changes Applied');
        } else {
            if ($this->getTask() == 'apply') {
                $this->setRedirect('index.php?option=' . $option . '&task=edit&cid[]=' . $row->id  . '&controller=agencies', 'Changes Applied');
            } else {
                $this->setRedirect('index.php?option=' . $option . '&controller=agencies', 'Agency Saved');
            }
        }
    }

    function publish()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        global $option;

        $cid = JRequest::getVar('cid', array());

        $row =& JTable::getInstance('agencies', 'Table');

        $publish = ($this->getTask() == 'publish') ? 1 : 0;

        if(!$row->publish($cid, $publish)) {
                JError::raiseError(500, $row->getError() );
        }
        
        $msg = (count($cid) > 1) ? 'Agencies ' : 'Agency ';
        $msg .= $this->getTask() . 'ed';

        $this->setRedirect('index.php?option='.$option.'&controller=agencies', $msg);

    }
    
    function remove()
    {
        JRequest::checkToken() or jexit( 'Invalid Token' );
        $option = JRequest::getCMD('option');

        $cid = JRequest::getVar('cid', array(0));

        $row =& JTable::getInstance('agencies', 'Table');

        foreach ($cid as $id) {
            $id = (int) $id;
            $row->load($id);
            if (!$row->delete($id)) {
                JError::raiseError(500, $row->getError() );
            }
        }

        $msg = (count($cid) > 1) ? 'Agencies ' : 'Agency ';
        $msg .= 'deleted';

        $this->setRedirect('index.php?option=' . $option . '&controller=agencies', $msg );
    }

    function display()
    {
        $view = JRequest::getVar('view');

        if (!$view) {
            JRequest::setVar('view', 'agencies');
        }
        parent::display();
    }
}


?>