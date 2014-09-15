<?php
/**
 * @version $Id: registration.php 177 2011-03-03 16:55:21Z chaan $
 */

//No direct acesss
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class JptpModelCalendar extends JModel
{ 
    protected $_events;
    private $_time = null;
    private $_current_year = null;
    private $_current_month = null;
    private $_req_month = null;
    private $_req_year = null;
    private $_first_year = null;
    private $_second_year = null;

    function __construct()
    {
        parent::__construct();

        $this->_time = time();
        $this->_current_month = date('n', $this->_time);
        $this->_current_year = date('Y', $this->_time);
        $this->_first_year = ($this->_current_month < 7 ) ? $this->_current_year - 1  : $this->_current_year;
        $this->_second_year = $this->_first_year + 1;           
        $this->_req_month = $this->getReqMonth();
        $this->_req_year  = $this->getReqYear();
	$this->_view = JRequest::getVar('view', 'calendar');
    }
    
        /**
     *
     * @return int request year
     */
    function getReqYear()
    {      
        $year = JRequest::getInt('year', $this->_current_year );
            if ($year < $this->_first_year) {
                $year = $this->_first_year;
            } elseif ($year > $this->_second_year) {
                $year = $this->_second_year;
            }
        JRequest::setVar('year', $year);
        return $year;
    }

    /**
     *
     * @return int request month
     */
    function getReqMonth()
    {
        $month =  JRequest::getInt('month', $this->_current_month);
            if ($month < 1) {
                $month = 1;
            } elseif ($month > 12) {
                $month = 12;
            }
        JRequest::setVar('month', $month);
        return $month;
    }
    
    function getCurrentMonth(){
        return $this->_current_month;
    }
    
    function getCurrentYear(){
        return $this->_current_year;
    }
    
    function getPrevlink(){
        if ($this->_req_month == 7) {
            $link = "";
        } else {
            if ($this->_req_month == 1) {
                $link_month = 12;
                $link_year = $this->first_year;
            } else {
                $link_month = $this->_req_month - 1;
                $link_year = $this->_req_year;
            }
            $href = JRoute::_('index.php?option=com_jptp&controller=calendar&month=' . $link_month . DS . $link_year );
            $link = '<a style="text-decoration: none;" title="previous month" href="' . $href . '">&laquo;</a>';
        }
        return $link;
    }

    function getNextlink(){
        if ($this->_req_month == 6) {
            $link = "";
        } else {
            if ($this->_req_month == 12) {
                $link_month = 1;
                
                $link_year = $this->_second_year;
            } else {
                $link_month = $this->_req_month + 1;
                $link_year = $this->_req_year;
            }
            $href = JRoute::_('index.php?option=com_jptp&controller=calendar&month=' . $link_month . DS . $link_year );
            $link = '<a style="text-decoration: none;" title="next month" href="' . $href . '">&raquo;</a>';
        }
        return $link;
    }
  
    function _retrieveEvents(){
        $query = 'SELECT e.*, t.title, a.name AS audience '
               . ' FROM #__jptp_events AS e LEFT JOIN #__jptp_trainings AS t ON e.training_id = t.id'
               . ' LEFT JOIN #__jptp_audiences AS a ON a.id = t.audience_id '
               . ' WHERE ((MONTH(start_date) =' . $this->_req_month . ' AND YEAR(start_date) =' . $this->_req_year . ')'
               . ' OR (MONTH(end_date) =' . $this->_req_month . ' AND YEAR(end_date) =' . $this->_req_year . '))'
               . ' AND e.published > 0';
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $events = $db->loadObjectList();
        return $events;
    }   
    
    function getEvents(){
        $events = $this->_retrieveEvents();
        $days = array();
        foreach($events as $event) {
           $class = $event->audience;
           list($hour, $minute, $second) = explode(":", $event->start_time);
           list($year, $month, $day) = explode("-", $event->start_date);
           $event_start = mktime($hour, $minute, $second, $month, $day, $year);
           if($event->status == 'closed' || $event_start < time() || !$this->_registration_open( $month, $year )){ //event closed or already started
               $reg_link = '';         
           } else {
               $reg_link = (!empty($event->link)) ? $event->link : JRoute::_("index.php?option=com_jptp&controller=registration&event_id=" . $event->id);
           }
           $info_link = JRoute::_("index.php?option=com_jptp&controller=description&event_id=" . $event->id);
           $interval = date_diff( date_create( $event->start_date), date_create( $event->end_date));
           $length = $interval->format('%a') + 1;
           if(!array_key_exists($event-> start_date, $days) || !is_array( $days[ $event-> start_date ] )) {
               $days[ $event-> start_date ] = array();
           }
           $days[ $event->start_date ][] = array('title' => $event->title, 'reg_link' => $reg_link, 'info_link' => $info_link, 'class' => $class, 'length' => $length);
           if($event->start_date != $event->end_date){
               $days[ $event->end_date ][] = array('title' => $event->title, 'reg_link' => $reg_link, 'info_link' => $info_link, 'class' => $class, 'length' => $length);               
           }
        }
        return $days;
    }
    
    function getEventsList(){
        $query = 'SELECT e.*, t.title, a.name AS audience, s.city, et.name AS type '
               . ' FROM #__jptp_events AS e LEFT JOIN #__jptp_trainings AS t ON e.training_id = t.id'
               . ' LEFT JOIN #__jptp_audiences AS a ON a.id = t.audience_id '
               . ' LEFT JOIN #__jptp_sites AS s on s.id = e.site_id '
               . ' LEFT JOIN #__jptp_event_types AS et on et.id = e.event_type_id '
               . ' WHERE (YEAR(e.start_date) = ' . $this->_first_year . ' AND MONTH(e.start_date) > 6)'
               . ' OR (YEAR(start_date) = ' . $this->_second_year . ' AND MONTH(e.start_date) < 7)'
               . ' AND e.published > 0'
               . ' ORDER BY e.start_date';
        $db = JFactory::getDBO();
        $db->setQuery($query);
        $events = $db->loadObjectList();
        return $events;
    }
    
    // this function returns true if the current time is past the registration opening time for an event
    function _registration_open( $event_month, $event_year ){
        $open_month = ((floor(($event_month + 1) / 2) - 1) * 2) + (12 - floor(($event_month + 9) / 12) * 12);
        $open_year = $event_year + floor (($event_month + 9) / 12) - 1;
        $open_time = mktime( 0, 0, 0, $open_month, 1, $open_year);
        return $open_time < time();
    } 
    
//    function _get_start_year(){
//        $start_year = ( $this->_current_month < 7 ) ? $this->_current_year - 1 : $this->_current_year;
//        return $start_year;
//    }

    
}
?>
