<?php
/**
 * @version $Id: view.html.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
	
class JptpViewAgency extends JView
{
    function display($tpl = null)
    {
        $row =& JTable::getInstance('agencies', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $id = $cid[0];
        $row->load($id);
        $this->assignRef('row', $row);        
        
        $layout = JRequest::getVar('layout', '');

        if ($layout == 'approval') {
            $subject = "JPTP Agency Approval" ;
            //$params = &JComponentHelper::getParams( 'com_jptp' );                       

            $sender_email = 'ltruitt@ou.edu';
            $bcc = 'ltruitt@ou.edu';
            $sender_name = 'Lou Truitt-Flanagan';
            $recipient = $row->director_email;

            jimport( 'joomla.mail.helper' );
            ob_start(); //capture template ouput to send as email
            parent::display($tpl);
            $body = JMailHelper::cleanBody( ob_get_clean() );
            
            if ( !JUtility::sendMail($sender_email, $sender_name, $recipient, $subject, $body, 'true', '', $bcc) ) {
                 JError::raiseNotice( 500, 'E-mail Confirmation Failed.' );
            } else {
                $application = JFactory::getApplication();
                $application->enqueueMessage("Agency approval email sent!");
            }
        }
        
        $this->_layout = 'default';
        
        $editor =& JFactory::getEditor();
        $this->assignRef('editor', $editor);
        $this->assignRef('published', JHTML::_('select.booleanlist', 'published', 'class="inputbox"', JRequest::getInt('published', $row->published)));
        $this->assignRef('youth_focus', JHTML::_('select.booleanlist', 'youth_focus', 'class="inputbox"', JRequest::getInt('youth_focus', $row->youth_focus)));
        $this->assignRef('listserv', JHTML::_('select.booleanlist', 'listserv', 'class="inputbox"', JRequest::getInt('listserv', $row->listserv)));
        $options[] = JHTML::_('select.option', 'for profit', 'for profit');
        $options[] = JHTML::_('select.option', 'not for profit', 'not for profit');
        $options[] = JHTML::_('select.option', 'public', 'public');        
        $this->assignRef('type', JHTML::_('select.radiolist', $options, 'type', 'class="inputbox"','value','text', JRequest::getVar('type', $row->type)));

        parent::display($tpl);

    }
}
