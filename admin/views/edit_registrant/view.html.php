<?php
/**
 * @version $Id: view.html.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
	
class JptpViewEdit_registrant extends JView
{
    function display($tpl = null)
    {
        $row =& JTable::getInstance('registrants', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $id = $cid[0];
        $row->load($id);
        $this->assignRef('row', $row);
        
        $agency_contact = $this->get( 'agency_contact');
        $this->assignRef('agency_contact', $agency_contact);
        
        $this->assignRef('published', JHTML::_('select.booleanlist', 'published', 'class="inputbox"', JRequest::getInt('published', $row->published)));      

        parent::display($tpl);
    }
}
