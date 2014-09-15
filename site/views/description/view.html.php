<?php
/**
 * @version $Id: $
 */
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JptpViewDescription extends JView
{
    function display($tpl = null)
    {

        $event = $this->get( 'event' );
        //$event->registration_time = $this->format_time( $event->registration_time);
        //$event->start_time = $this->format_time( $event->start_time);
        //$event->end_time = $this->format_time( $event->end_time);
        //$event->start_time2 = $this->format_time( $event->start_time2);
        //$event->end_time2 = $this->format_time( $event->end_time2);        
        $this->assignRef('event', $event);
        
        JRequest::setVar('training_id', $event->training_id);
        
        $presenters = $this->get( 'trainers' );
        $this->assignRef('trainers', $presenters);
      
        $site = $this->get('site');
        $this->assignRef('site', $site);
        
        $approvals = $this->get('approvals');
        $this->assignRef('approvals', $approvals);
        
        list($year, $month, $day) = explode("-", $event->start_date);
        
        $this->assign('registration_open', $this->_registration_open( $month, $year ));
        $this->assign('registration_open_time', $this->_registration_open_time( $month, $year ));
        
        parent::display($tpl);
    }
    
    function _registration_open( $event_month, $event_year ){
        return $this->_registration_open_time( $event_month, $event_year ) < time();
    }
    
    function _registration_open_time( $event_month, $event_year ){
        $open_month = ((floor(($event_month + 1) / 2) - 1) * 2) + (12 - floor(($event_month + 9) / 12) * 12);
        $open_year = $event_year + floor (($event_month + 9) / 12) - 1;
        return mktime( 0, 0, 0, $open_month, 1, $open_year);
    }     
}