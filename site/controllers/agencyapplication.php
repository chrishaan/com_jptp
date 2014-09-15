<?php
/**
 * @version $Id: controller.php 182 2011-04-14 15:05:23Z chaan $
 * NRC Conferences Controller
 *
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class JptpControllerAgencyApplication extends JController
{
     /**
     * function save
     *
     */
    function save()
    {   
        JRequest::checkToken() or jexit('Invalid Token');
        $session =& JFactory::getSession();             

        $model = $this->getModel('agencyapplication');

        $data_ok = true;
        
        if(!$session->get('saved')) {        
            if (!$model->checkData())
            {
                $data_ok = false;
            }           
            
            if(!$data_ok){;
                JRequest::setVar('view', 'agencyapplication');
                $this->display();
                return;
            }
            
            $row =& JTable::getInstance('agencies', 'Table');

            if (!$row->bind(JRequest::get('post'))) {
                    JError::raiseError(500, $row->getError() );
            }

            if (!$row->store()) {
                    JError::raiseError(500, $row->getError() );
            }
            
            JRequest::setVar('id', $row->id);
            $session->set('saved', true);
        }
       
        //Display confirmation page if everything has gone through without errors

       JRequest::setVar('controller', 'agencyapplication');
       JRequest::setVar('layout', 'confirmation');
       $this->display();
    }
    
    function display()
    {
            $view = JRequest::getVar('view');
            if (!$view) {
                    JRequest::setVar('view', 'agencyapplication');
            }

            parent::display();
    }    
    
}

?>