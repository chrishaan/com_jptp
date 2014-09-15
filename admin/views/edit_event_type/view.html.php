<?php
/**
 * @version $Id: view.html.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
	
class JptpViewEdit_event_type extends JView
{
    function display($tpl = null)
    {
        $row =& JTable::getInstance('event_types', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $id = $cid[0];
        $row->load($id);

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
