<?php
/**
 * @version $Id: $
 * NRC JPTP Controller
 *
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class JptpController extends JController
{

    function display()
    {
            $view = JRequest::getVar('view');
            if (!$view) {
                    JRequest::setVar('view', 'calendar');
            }

            parent::display();
    }

}
