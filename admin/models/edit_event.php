<?php
/**
 * @version $Id:  $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class JptpModelEdit_event extends JModel
{
    function getEvent_types()
    {
        $blank = array(
            array('id' => '0', 'name' => '')
        );    

        $query = 'SELECT id, name FROM #__jptp_event_types';

        $db = JFactory::getDBO();
        $db->setQuery( $query );
        $list = $db->loadAssocList();
        $event_types = array_merge( $blank, $list );

        return $event_types;
    }
             
    function getSites()
    {
        $blank = array(
            array('id' => '0', 'name' => '')
        );    

        $query = 'SELECT id, name FROM #__jptp_sites WHERE published > 0 ORDER BY name ASC';

        $db = JFactory::getDBO();
        $db->setQuery( $query );
        $list = $db->loadAssocList();
        $sites = array_merge( $blank, $list );

        return $sites;
    }     
    
    function getTrainings()
    {
        $blank = array(
            array('id' => '0', 'title' => '')
        );    

        $query = 'SELECT id, title FROM #__jptp_trainings WHERE published > 0 ORDER BY title ASC';

        $db = JFactory::getDBO();
        $db->setQuery( $query );
        $list = $db->loadAssocList();
        $trainings = array_merge( $blank, $list );

        return $trainings;
    }
    
    function getTrainers()
    {
        $blank = array(
            array('id' => '0', 'name' => '')
        );    

        $query = 'SELECT id, CONCAT(last_name, ", ", first_name) AS name FROM #__jptp_trainers WHERE published > 0 ORDER BY last_name ASC';

        $db = JFactory::getDBO();
        $db->setQuery( $query );
        $list = $db->loadAssocList();
        $trainers = array_merge( $blank, $list );

        return $trainers;
    }       
}