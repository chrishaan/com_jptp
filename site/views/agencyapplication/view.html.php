<?php
/**
 * @version $Id: $
 */
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JptpViewAgencyApplication extends JView
{
    function display($tpl = null)
    {
        $session =& JFactory::getSession();

        $layout = JRequest::getVar('layout', '');
        if($layout == 'confirmation'){
            
            if (!$session->get('notice')){
                $subject = "JPTP Agency Application" ;
                $params = &JComponentHelper::getParams( 'com_jptp' );
                $recipient = explode(",", $params->get('application_emails'));                         
                
                $sender_email = 'no-reply@nrcys.ou.edu';
                $sender_name = 'National Resource Center for Youth Services';
                //$recipient = $contact->email;

                jimport( 'joomla.mail.helper' );

                $body  = "<p>A new JPTP agency application has been received. </p>";
                $body .= '<p>Please login in to <a href="http://www.nrcys.ou.edu/administrator/">http://www.nrcys.ou.edu/administrator/</a> to review the application.</p>';
                $agency_id = JRequest::getVar('id', 0);
                if($agency_id){
                    $link = "http://www.nrcys.ou.edu/administrator/index.php?option=com_jptp&controller=agencies&task=edit&cid[]=" . $agency_id;
                    $body .= "<p>After logging in to Joomla, you may <a href=\"" . $link . "\">click here</a> to go directly to the agency application.</p>";
                }
                
                $body = JMailHelper::cleanBody( $body );

                if ( JUtility::sendMail($sender_email, $sender_name, $recipient, $subject, $body, 'true', '') ) {
                     $session->set('notice', true);                             
                } else {
                     JError::raiseNotice( 500, 'E-mail Confirmation Failed.' );
                }
            }
            
        } else {
            $session->set('saved', false);
            $session->set('notice', false);
            
            $this->assignRef('youth_focus', JHTML::_('select.booleanlist', 'youth_focus', 'class="inputbox"', JRequest::getInt('youth_focus', 0)));
            $this->assignRef('listserv', JHTML::_('select.booleanlist', 'listserv', 'class="inputbox"', JRequest::getInt('listserv', 0)));
            $options[] = JHTML::_('select.option', 'for profit', 'for profit');
            $options[] = JHTML::_('select.option', 'not for profit', 'not for profit');
            $options[] = JHTML::_('select.option', 'public', 'public');        
            $this->assignRef('type', JHTML::_('select.radiolist', $options, 'type', 'class="inputbox"','value','text', JRequest::getVar('type', '')));            
        }
        
        parent::display($tpl);
    }
}
