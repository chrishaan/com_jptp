<?php
/**
 * @version $Id: $
 */
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JptpViewCalendar extends JView
{
    function display($tpl = null)
    {
        $layout = JRequest::getVar('layout', 'default');

        if($layout == 'list'){
            $events = $this->get('eventslist');
            $this->assignRef('events', $events);
            $this->assignRef('current_month', $this->get('CurrentMonth'));
            $this->assignRef('current_year', $this->get('CurrentYear'));            
        } else {
            $events = $this->get( 'events' );     
            $this->assignRef('events', $events);
            $this->assignRef('req_month', $this->get('ReqMonth'));
            $this->assignRef('req_year', $this->get('ReqYear'));
            $this->assignRef('current_month', $this->get('CurrentMonth'));
            $this->assignRef('current_year', $this->get('CurrentYear'));
            $this->assignRef('prev_link', $this->get('Prevlink'));
            $this->assignRef('next_link', $this->get('Nextlink'));
        }
        parent::display($tpl);
    }
    
    function format_time( $time ) {
        $hms = explode(":", $time );
        $ampm = ($hms[0] > 11) ? "pm" : "am";
        $hms[0] = ($hms[0] > 11) ? (int)$hms[0] - 12 : (int)$hms[0];
        
        return $hms[0] . ":" . $hms[1] . " " . $ampm;
    }
}