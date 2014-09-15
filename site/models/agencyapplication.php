<?php
/**
 * @version $Id: registration.php 177 2011-03-03 16:55:21Z chaan $
 */

//No direct acesss
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class JptpModelAgencyApplication extends JModel
{ 
    protected $_event;

    function checkData()
    {
        $name = JRequest::getString('name', '');
        $address = JRequest::getString('address', '');
        $city = JRequest::getString('city', '');
        $zip = JRequest::getString('zip', '');
        $phone = JRequest::getString('phone', '');
        $director_first_name = JRequest::getString('director_first_name', '');
        $director_last_name = JRequest::getString('director_last_name', '');
        $director_email = JRequest::getString('director_email', '');        

        //Check that the required fields do have content
        $data_ok = true;

        if( empty($name)
            || empty($address)
            || empty($city)
            || empty($director_first_name)
            || empty($director_last_name)                
            || strlen($phone) < 10
        ) {
            JError::raiseWarning( 0, "Please check that all agency information is completed." );
            $data_ok = false;
        }

        if (strlen($zip) < 5 ) {
            JError::raiseWarning(0, "Please check the zip code.");
            $data_ok = false;
        }

        jimport( 'joomla.mail.helper' );
        if (empty($director_email) || !JMailHelper::isEmailAddress($director_email)) {
            JError::raiseWarning(0, 'Director email address appears to be invalid.');
            $data_ok = false;
        }
        
        $services = JRequest::getString('services', '');
        $youth_percent = JRequest::getInt('youth_percent', 0);
        $type = JRequest::getString('type', '');
        $funding_sources = JRequest::getString('funding_sources', '');
        $primary_clientele = JRequest::getString('primary_clientele', '');
        $annual_clientele = JRequest::getInt('annual_clientele', 0);
        $staff_count = JRequest::getInt('staff_count', 0);
        $staff_education = JRequest::getString('staff_education', '');
        
        if( empty($services)
            || empty($youth_percent)
            || empty($type)
            || empty($funding_sources)
            || empty($primary_clientele)
            || $annual_clientele < 1
            || $staff_count < 1
            || empty($staff_education)
        ) {  
            JError::raiseWarning( 0, "Please check that all agency details are completed." );
            $data_ok = false;
        }
            
        return $data_ok;
    }
    
}
?>
