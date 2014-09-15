<?php
/**
 * @version $Id$
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
	
class JptpViewEdit_licensing_org extends JView
{
    function display($tpl = null)
    {
        $row =& JTable::getInstance('licensing_orgs', 'Table');
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
