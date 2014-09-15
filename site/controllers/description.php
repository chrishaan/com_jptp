<?php
/**
 * @version $Id: $
 * NRC Conferences Controller
 *
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class JptpControllerDescription extends JController
{

    function display()
    {
            $view = JRequest::getVar('view');
            if (!$view) {
                    JRequest::setVar('view', 'description');
            }

            parent::display();
    }     
}

?>