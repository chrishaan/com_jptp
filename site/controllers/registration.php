<?php
/**
 * @version $Id: controller.php 182 2011-04-14 15:05:23Z chaan $
 * NRC Conferences Controller
 *
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class JptpControllerRegistration extends JController
{
     /**
     * function save
     *
     */
    function save()
    {   
        JRequest::checkToken() or jexit('Invalid Token');
        $session =& JFactory::getSession();             
        $event_id = JRequest::getString('event_id');
        $model = $this->getModel('registration');

        $data_ok = true;
        
        if(!$session->get('saved')) {        
            if (!$model->checkContact())
            {
                JError::raiseWarning( 0, JText::_("Sorry, it appears you have not filled out all contact information"));
                $data_ok = false;
            }

            if (!$model->checkRegistrations())
            {
                $data_ok = false;
            }             
            
            if(!$data_ok){
                JRequest::setVar('event_id', $event_id);
                JRequest::setVar('view', 'Registration');
                $this->display();
                return;
            }
            
            $contact_id = $model->storeContact();
            if (!$contact_id)
            {
                JError::raiseError(500, 'An error has occurred saving agency contact data to the database.');
                return;
            }

            if (!$model->storeRegistrations($contact_id))
            {
                JError::raiseError(500, 'An error has occurred saving registrations to the database.');
                return;
            }           
            
            $session->set('saved', true);
            $session->set('agency_contact_id', $contact_id);
            JRequest::setVar('agency_contact_id', $contact_id);
        }
       
       
        //Display confirmation page if everything has gone through without errors

       JRequest::setVar('controller', 'registration');
       JRequest::setVar('layout', 'confirmation');
       $this->display();
    }
    
    function cancel(){
            $view = JRequest::getVar('view');
            if (!$view) {
                    JRequest::setVar('view', 'registration');
            }
            JRequest::setVar('layout', 'cancellation');

            parent::display();
    }
    
    function cancel_confirm(){
        JRequest::checkToken() or jexit('Invalid Token');
        
        $cancel_hash = JRequest::getString('hash');
        $query = 'UPDATE #__jptp_registrants SET cancel_date = NOW(), cancelled = 1 WHERE cancel_hash = "' . $cancel_hash . '"';
        $db = JFactory::getDBO();
        $db->setQuery( $query );
        $db->query();
        
        $event_id = JRequest::getInt('event_id');
        $query = 'UPDATE #__jptp_events SET registration_count = registration_count - 1 WHERE id = ' . $event_id;
        $db->setQuery( $query );
        $db->query();

        JRequest::setVar('view', 'registration');
        JRequest::setVar('layout', 'cancel_confirm');

        parent::display();        
        
    }
    
    function display()
    {
            $view = JRequest::getVar('view');
            if (!$view) {
                    JRequest::setVar('view', 'registration');
            }

            parent::display();
    }    
    
}

?>