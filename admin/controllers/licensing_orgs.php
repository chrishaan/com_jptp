<?php
/**
 * @version $Id:$
 */
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.application.component.controller');

class JptpControllerLicensing_orgs extends JController
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
        JRequest::setVar('view', 'edit_licensing_org');
        $this->display();
    }

    function save()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $option = JRequest::getCmd('option', '');

        $row =& JTable::getInstance('licensing_orgs', 'Table');

        if (!$row->bind(JRequest::get('post'))) {
                JError::raiseError(500, $row->getError() );
        }

        if (!$row->store()) {
                JError::raiseError(500, $row->getError() );
        }

        $msg = '';

        if ($this->getTask() == 'apply') {
            $this->setRedirect('index.php?option=' . $option . '&task=edit&cid[]=' . $row->id  . '&controller=licensing_orgs', 'Changes Applied');
        } else {
            $this->setRedirect('index.php?option=' . $option . '&controller=licensing_orgs', 'Agency Saved');
        }
    }

    function publish()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        global $option;

        $cid = JRequest::getVar('cid', array());

        $row =& JTable::getInstance('licensing_orgs', 'Table');

        $publish = ($this->getTask() == 'publish') ? 1 : 0;

        if(!$row->publish($cid, $publish)) {
                JError::raiseError(500, $row->getError() );
        }
        
        $msg = 'Licensing Organization';
        $msg .= (count($cid) > 1) ? 's ' : ' ';
        $msg .= $this->getTask() . 'ed';

        $this->setRedirect('index.php?option='.$option.'&controller=licensing_orgs', $msg);

    }
    
    function remove()
    {
        JRequest::checkToken() or jexit( 'Invalid Token' );
        $option = JRequest::getCMD('option');

        $cid = JRequest::getVar('cid', array(0));

        $row =& JTable::getInstance('licensing_orgs', 'Table');

        foreach ($cid as $id) {
            $id = (int) $id;
            $row->load($id);
            if (!$row->delete($id)) {
                JError::raiseError(500, $row->getError() );
            }
            
            $this->setRedirect('index.php?option=' . $option . '&controller=licensing_orgs', 'Audience Deleted');
        }

        $msg = 'Licensing Organization';
        $msg .= (count($cid) > 1) ? 's ' : ' ';
        $msg .= 'deleted';

        $this->setRedirect('index.php?option=' . $option, $msg );
    }

    function display()
    {
        $view = JRequest::getVar('view');

        if (!$view) {
            JRequest::setVar('view', 'licensing_orgs');
        }
        parent::display();
    }
}


?>