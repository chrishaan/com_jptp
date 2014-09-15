<?php
/**
 * @version $Id: $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');
jimport('joomla.application.module.helper');

class JptpViewDefault extends JView
{	
    function display($tpl = null)
    {
        $com_xml = JApplicationHelper::parseXMLInstallFile( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_jptp' .DS. 'jptp.xml' );

        $this->assignRef('com_info', $com_xml);

        parent::display($tpl);
    }
}