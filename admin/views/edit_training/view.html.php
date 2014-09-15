<?php
/**
 * @version $Id: view.html.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
	
class JptpViewEdit_training extends JView
{
    function display($tpl = null)
    {
        $row =& JTable::getInstance('trainings', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $id = $cid[0];
        $row->load($id);
        
        $audiences = $this->get('audiences');
        $trainings = $this->get('trainings');
        $event_types = $this->get('event_types');
        $licensing_orgs = $this->get('licensing_orgs');
        
        $this->assignRef('audience', JHTML::_('select.genericList', $audiences, 'audience_id', 'class="inputbox" ', 'id', 'name', $row->audience_id));
        $this->assignRef('trainings', JHTML::_('select.genericList', $trainings, 'training_id', 'class="inputbox" ', 'id', 'title', $row->training_id ));
        $this->assignRef('event_types', JHTML::_('select.genericList', $event_types, 'event_type_id', 'class="inputbox" ', 'id', 'name', $row->event_type_id));
        $this->assignRef('licensing_orgs', JHTML::_('select.genericlist', $licensing_orgs, 'licensing_orgs', 'class="inputbox"', 'id', 'name', 0));

        $this->assignRef('row', $row);
        $editor =& JFactory::getEditor();
        $this->assignRef('editor', $editor);        
        $this->assignRef('published', JHTML::_('select.booleanlist', 'published', 'class="inputbox"', JRequest::getInt('published', $row->published)));
        //$paramsdata = $row->params;
        //$paramsdefs = JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'conferences.xml';
        //$params = new JParameter( $paramsdata, $paramsdefs );
        //$this->assignRef( 'params', $params);        

        parent::display($tpl);
    }
}
