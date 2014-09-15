<?php
/**
 * @version $Id: view.html.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
	
class JptpViewEdit_event extends JView
{
    function display($tpl = null)
    {
        $row =& JTable::getInstance('events', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $id = $cid[0];
        $row->load($id);
        
        $sites = $this->get('sites');
        $trainings = $this->get('trainings');
        $event_types = $this->get('event_types');
        $trainers = $this->get('trainers');
        
        $status = array( array('id' => 'open', 'value' => 'open'), 
                         array('id' => 'wait_list', 'value' => 'wait list'), 
                         array('id' => 'closed', 'value' => 'closed')
                  );
        
        $this->assignRef('status', JHTML::_('select.genericList', $status, 'status', 'class="inputbox" ', 'id', 'value', $row->status));
        
        $this->assignRef('sites', JHTML::_('select.genericList', $sites, 'site_id', 'class="inputbox" ', 'id', 'name', $row->site_id));
        $this->assignRef('trainings', JHTML::_('select.genericList', $trainings, 'training_id', 'class="inputbox" ', 'id', 'title', $row->training_id ));
        $this->assignRef('event_types', JHTML::_('select.genericList', $event_types, 'event_type_id', 'class="inputbox" ', 'id', 'name', $row->event_type_id));
        $this->assignRef('trainers', JHTML::_('select.genericlist', $trainers, 'all_trainers', 'class="inputbox"', 'id', 'name'));
        $this->assignRef('start_date', JHTML::_('calendar', $row->start_date, 'start_date', 'start_date'));
        $this->assignRef('end_date', JHTML::_('calendar', $row->end_date, 'end_date', 'end_date'));
        $this->assignRef('row', $row);
        $this->assignRef('published', JHTML::_('select.booleanlist', 'published', 'class="inputbox"', JRequest::getInt('state', $row->published)));      

        parent::display($tpl);
    }
}
