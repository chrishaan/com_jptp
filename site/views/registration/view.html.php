<?php
/**
 * @version $Id: $
 */
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JptpViewRegistration extends JView
{
    function display($tpl = null)
    {
        $session =& JFactory::getSession();

        $event = $this->get( 'event' );        
        $this->assignRef('event', $event);

        $id = JRequest::getVar('id', $session->get('agency_contact_id'));
        JRequest::setVar('agency_contact_id', $id);
        $layout = JRequest::getVar('layout', '');
        if($layout == 'confirmation'){
         
            $contact = $this->get('contact');
            $this->assignRef('contact', $contact);
                        
            $registrations = $this->get('registrations');
            $this->assignRef('registrations', $registrations);
            
            if (!$session->get('notice')){
                $subject = $event->title . " Registration" ;
                $params = &JComponentHelper::getParams( 'com_jptp' );
                $bcc = explode(",", $params->get('emails'));                         
                
                $sender_email = 'no-reply@nrcys.ou.edu';
                $sender_name = 'National Resource Center for Youth Services';
                $recipient = $contact->email;

                jimport( 'joomla.mail.helper' );
                ob_start(); //capture template ouput to send as email
                parent::display($tpl);
                $body = JMailHelper::cleanBody( ob_get_clean() );

                if ( JUtility::sendMail($sender_email, $sender_name, $recipient, $subject, $body, 'true', '', $bcc) ) {
                     $session->set('notice', true);                             
                } else {
                     JError::raiseNotice( 500, 'E-mail Confirmation Failed.' );
                }                
            }
            
        } else if($layout == 'cancellation' || $layout =='cancel_confirm') {
            $registration = $this->get('registrationbyhash');
            $this->assignRef('registration', $registration);
            
            JRequest::setVar('agency_contact_id', $registration->agency_contact_id);
            $contact = $this->get('contact');
            $this->assignRef('contact', $contact);
            
            JRequest::setVar('event_id', $contact->event_id);
            $event = $this->get('event');
            $this->assignRef('event', $event);
            
            if($layout == 'cancel_confirm'){
                $subject = $event->title . " Cancellation" ;
                $params = &JComponentHelper::getParams( 'com_jptp' );
                $bcc = explode(",", $params->get('emails'));                         
                
                $sender_email = 'no-reply@nrcys.ou.edu';
                $sender_name = 'National Resource Center for Youth Services';
                $recipient = $bcc[0];

                jimport( 'joomla.mail.helper' );
                ob_start(); //capture template ouput to send as email
                parent::display($tpl);
                $body = JMailHelper::cleanBody( ob_get_clean() );

                if ( !JUtility::sendMail($sender_email, $sender_name, $recipient, $subject, $body, 'true', '', $bcc) ) {
                     JError::raiseNotice( 500, 'E-mail Confirmation Failed.' );
                }  
            }
        } else {
            $session->set('saved', false);
            $session->set('notice', false);
            $session->set('agency_contact_id', NULL);
                        
            $agencies = $this->get('agencies');
            $agency_select = JHTML::_('select.genericList', $agencies, 'agency_id', 'class="inputbox" ', 'id', 'name', JRequest::getInt('agency_id'));
            $this->assignRef('agency_select', $agency_select );
        }
        
        parent::display($tpl);
    }
}