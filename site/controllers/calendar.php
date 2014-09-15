<?php
/**
 * @version $Id: $
 * JPTP Events calendar
 *
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class JptpControllerCalendar extends JController
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

?>