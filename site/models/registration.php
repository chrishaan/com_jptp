<?php
/**
 * @version $Id: registration.php 177 2011-03-03 16:55:21Z chaan $
 */

//No direct acesss
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class JptpModelRegistration extends JModel
{ 
    protected $_event;

    function checkContact()
    {
        $agency_id = JRequest::getInt('agency_id', 0);
        $contact_first_name = JRequest::getString('contact_first_name', '');
        $contact_last_name = JRequest::getString('contact_last_name', '');
        $address = JRequest::getString('address', '');
        $city = JRequest::getString('city', '');
        $zip = JRequest::getString('zip', '');
        $phone = JRequest::getString('phone', '');
        $email = JRequest::getString('email', '');

        //Check that the required fields do have content
        $data_ok = true;

        if( empty($contact_first_name)
            || empty($contact_last_name)
            || $agency_id < 1 
            || empty($address)
            || empty($city)
            || strlen($phone) < 10
        ) {
            JError::raiseWarning( 0, "Sorry, it appears you have not filled out all the required information." );
            $data_ok = false;
        }

        if (strlen($zip) < 5 ) {
            JError::raiseWarning(0, "Please check your zip code.");
            $data_ok = false;
        }

        jimport( 'joomla.mail.helper' );
        if (empty($email) || !JMailHelper::isEmailAddress($email)) {
            JError::raiseWarning(0, 'Contact email address appears to be invalid. Please try again.');
            $data_ok = false;
        }

        return $data_ok;
    }
    
    function storeContact()
    {
        JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
        $row = JTable::getInstance('agency_contacts', 'Table');

        //Capture the incoming data
        $row->first_name = JRequest::getString('contact_first_name', '');
        $row->last_name = JRequest::getString('contact_last_name', '');
        $row->agency_id = JRequest::getString('agency_id', '');
        $row->address = JRequest::getString('address', '');
        $row->address2 = JRequest::getString('address2', '');
        $row->city = JRequest::getString('city', '');
        $row->state = "OK";
        $row->zip = JRequest::getString('zip', '');
        $row->phone = JRequest::getString('phone', '');
        $row->fax = JRequest::getString('fax', '');
        $row->email = JRequest::getString('email', '');
        $row->event_id = JRequest::getString('event_id', '');

        if (!$row->store()) {
            JError::raiseError(500, $row->getError());
            return false;
        }

        return $row->id;
    }
    
    function checkRegistrations()
    {   
        $data_ok = true;
        $registration_add = JRequest::getVar('registration_add', array(), '', 'array');
        
        
        if (!array_sum($registration_add)){
            JError::raiseWarning( 0, JText::_( "Please enter information for at least one registrant."  ));
            return false;            
        }        
        
        $registration_first_name   = JRequest::getVar('registration_first_name', array(), '', 'array');
        $registration_last_name    = JRequest::getVar('registration_last_name', array(), '', 'array');
        $registration_job_title    = JRequest::getVar('registration_job_title', array(), '', 'array');
        $registration_phone        = JRequest::getVar('registration_phone', array(), '', 'array');
        $registration_email        = JRequest::getVar('registration_email', array(), '', 'array');        
        
        
        for( $i = 0; $i < 5; $i++) {
            if (!array_key_exists($i, $registration_add) || $registration_add[$i] != '1') {  // check box or hidden field for add_youth not set
                continue;
            }

            $registrant = (string) $i + 1;
            
            //Check that the required fields do have content
            if (empty($registration_first_name[$i])
                || empty($registration_last_name[$i])
                || empty($registration_job_title[$i])
                || strlen($registration_phone[$i]) < 10
            ){
                JError::raiseWarning( 0, JText::_( "Sorry, it appears you have not filled out all the required information for registrant $registrant."  ));
                $data_ok = false;
            }

            jimport( 'joomla.mail.helper' );
            if(empty($registration_email[$i]) || !JMailHelper::isEmailAddress($registration_email[$i])) {
                JError::raiseWarning(0, "Registrant $registrant email address appears to be invalid. Please try again.");
                $data_ok = false;
            }
        }
        return $data_ok;
    }
    
    function storeRegistrations( $contact_id )
    {   
        $registration_add             = JRequest::getVar('registration_add', array(), '', 'array');
        $registration_first_name      = JRequest::getVar('registration_first_name', array(), '', 'array');
        $registration_last_name       = JRequest::getVar('registration_last_name', array(), '', 'array');
        $registration_job_title       = JRequest::getVar('registration_job_title', array(), '', 'array');
        $registration_phone           = JRequest::getVar('registration_phone', array(), '', 'array');
        $registration_email           = JRequest::getVar('registration_email', array(), '', 'array');
        $registration_accommodations  = JRequest::getVar('registration_accomodations', array(), '', 'array'); 
        $db = JFactory::getDBO();
        $event_id = JRequest::getInt('event_id');
        $query = 'UPDATE #__jptp_events SET registration_count = registration_count + 1 WHERE id = ' . $event_id;
        
        for( $i = 0; $i < 5; $i++) {
            if(!array_key_exists($i, $registration_add) || $registration_add[$i] != '1') {
                continue;
            }
            
            $db->setQuery( $query );
            $db->query();

            $registration =& JTable::getInstance('registrants', 'Table');

            $registration->agency_contact_id = $contact_id;
            $registration->first_name = $registration_first_name[$i];
            $registration->last_name = $registration_last_name[$i];
            $registration->cancel_hash = md5( $registration->first_name . " " . $registration->last_name . " " . time());
            $registration->job_title = $registration_job_title[$i];
            $registration->phone = $registration_phone[$i];
            $registration->email = $registration_email[$i];
            $registration->accommodations = $registration_accommodations[$i];

            if (!$registration->store()) {
                JError::raiseError(500, $registration->getError());
                return false;
            }
        }     
        
        return true;
        
     }
    
    function getEvent(){
        $event_id = JRequest::getInt('event_id');
        $query = 'SELECT e.id, e.start_date, e.end_date, e.end_time, e.end_time2, e.start_time, t.title, CONCAT(s.city, ", OK") AS location'
               . ' FROM #__jptp_events AS e LEFT JOIN #__jptp_trainings AS t ON e.training_id = t.id'
               . ' LEFT JOIN #__jptp_sites AS s ON e.site_id = s.id '
               . ' WHERE e.id = ' . $event_id;
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $event = $db->loadObject();
        return $event;
    }
    
    function getContact(){
        $contact_id = JRequest::getInt('agency_contact_id');
        $query = 'SELECT ac.*, a.name AS agency FROM #__jptp_agency_contacts AS ac LEFT JOIN #__jptp_agencies AS a ON ac.agency_id = a.id'
               . ' WHERE ac.id = '. $contact_id;
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $contact = $db->loadObject();
        return $contact;           
    }
    
    function getRegistrations(){
        $contact_id = JRequest::getInt('agency_contact_id');
        $query = 'SELECT * FROM #__jptp_registrants WHERE agency_contact_id = ' . $contact_id;
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $registrations = $db->loadObjectList();
        return $registrations;         
    }

    function getAgencies(){
        $blank = array(
            array('id' => '0', 'name' => '')
        );    

        $query = 'SELECT id, name FROM #__jptp_agencies WHERE published > 0 ORDER BY name ASC';
        $db = JFactory::getDBO();
        $db->setQuery( $query );
        $list = $db->loadAssocList();
        $agencies = array_merge( $blank, $list );

        return $agencies;
    }
    
    function getRegistrationbyhash(){
        $cancel_hash = JRequest::getString('hash');
        $query = 'SELECT * from #__jptp_registrants WHERE cancel_hash = "' . $cancel_hash . '"';
        $db = JFactory::getDBO();
        $db->setQuery( $query );
        $registration = $db->loadObject();
        return $registration;
        
    }
    
}
?>
