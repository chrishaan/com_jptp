<?php
/**
 * @version $Id:  $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class JptpModelEdit_training extends JModel
{
	function getAudiences()
	{

        $blank = array(
            array('id' => '0', 'name' => '')
        );    
        
        $query = 'SELECT id, name FROM #__jptp_audiences WHERE published > 0 ORDER BY name ASC';

        $db = JFactory::getDBO();
        $db->setQuery( $query );
        $list = $db->loadAssocList();
        $audiences = array_merge( $blank, $list );
        
        return $audiences;
	}
             
	function getLicensing_orgs()
	{

        $blank = array(
            array('id' => '0', 'name' => '')
        );    
        
        $query = 'SELECT id, name FROM #__jptp_licensing_orgs WHERE published > 0 ORDER BY name ASC';

        $db = JFactory::getDBO();
        $db->setQuery( $query );
        $list = $db->loadAssocList();
        $lo = array_merge( $blank, $list );
        
        return $lo;
	}        
}