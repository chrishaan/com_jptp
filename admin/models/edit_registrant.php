<?php
/**
 * @version $Id:  $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class JptpModelEdit_registrant extends JModel
{

    function getAgency_contact()
    {
        $agency_contact = JRequest::getVar('agency_contact');
        $query = 'SELECT ac.*, a.name FROM #__jptp_agency_contacts AS ac'
               . ' LEFT JOIN #__jptp_agencies AS a ON a.id = ac.agency_id'
               . ' WHERE ac.id = ' . $agency_contact;
        $db = Jfactory::getDBO();
        $db->setQuery( $query );
        $agency_contact = $db->loadAssoc();

        return $agency_contact;
    }
                 
}