<?php
/**
 * @version $Id:  $
 */
//no direct access
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'helper.php');

JHTML::script("com_jptp.js", "components" . DS . "com_jptp" . DS . "assets" . DS, TRUE);


echo "<h2>" . $this->event->title . "</h2>";

if ($this->event->start_date == $this->event->end_date) {
    $date = date("F j, Y", strtotime($this->event->start_date));
} else {
    $date = date("F j", strtotime($this->event->start_date)) . ' - ' . date("j, Y", strtotime($this->event->end_date));
}

echo "<strong>" . $date . "</strong>";

list($hour, $minute, $second) = explode(":", $this->event->start_time);
list($year, $month, $day) = explode("-", $this->event->start_date);

$event_start = mktime($hour, $minute, $second, $month, $day, $year); //get event start timestamp

// if event is two days, use the end time from the second day to check if event is finished
if ($this->event->end_date == $this->event->start_date){
    list($hour, $minute, $second) = explode(":", $this->event->end_time);
} else {
    list($hour, $minute, $second) = explode(":", $this->event->end_time2);
}
list($year, $month, $day) = explode("-", $this->event->end_date);
$event_end = mktime($hour, $minute, $second, $month, $day, $year); // get event end timestamp

if( $event_end < time()){
    echo '<p style="color: red;">Thank you for your interest.  This event has ended. 
        Please check the calendar for other training opportunities.</p>';
} else if ( $event_start < time()){
    echo '<p style="color: red;">Thank you for your interest.  This event has already started - online registration is closed. 
        Please check the calendar for other training opportunities.</p>';
} else if($this->event->status == 'closed'){
    echo '<p style="color: red;">  At this time, this event is at capacity  and the wait list is full.  
        Please check the calendar for other training opportunities.</p>';
}

if (!empty($this->event->audience)){
    echo "<h3>Audience: </h3><p>{$this->event->audience}</p>";
}

if(!empty($this->event->prerequisites)){
    echo "<h3>Prerequisites: </h3>{$this->event->prerequisites}";
}
if(!empty($this->event->description)){
    echo "<h3>Description: </h3>{$this->event->description}";
}

if(count($this->trainers) > 0) {
    $presenter = (count($this->trainers) > 1) ? "Presenters" : "Presenter";

    echo "<h3>$presenter:</h3>";

    foreach ($this->trainers as $trainer){
        echo '<p style="margin: 0;">' . $trainer->first_name . " " . $trainer->last_name. ", " . $trainer->credentials ." <br />";
        if(!empty($trainer->title)){
            echo $trainer->title . "<br />";
        }
        if(!empty($trainer->organization)){
            echo $trainer->organization . " ";
        }
        if(!empty($trainer->city) && !empty($trainer->state)){
            echo $trainer->city . ", " . $trainer->state ."</p>";
        }
        if(!empty($trainer->biography)) {
            echo <<<EOL
            <a href="javascript:null()" id="bio_toggle">Presenter Bio</a>
            <div id="trainer_bio" style="margin-bottom: 10px;">
            {$trainer->biography}<br />
            </div>
EOL;
        }
    }
}

if (!empty($this->site->name)){
    echo "<h3>Training Site:</h3>";
    echo $this->site->name . "<br />";
    if (!empty($this->site->address)){
        echo $this->site->address . "<br />";
    }
    if (!empty($this->site->address2)) {
        echo $this->site->address2 . "<br />";
    }
    if (!empty($this->site->city)) {
        echo $this->site->city . ", OK ";
    }
    if (!empty($this->site->zip)) {
        echo $this->site->zip;
    }
}
                
$two_day_event = ($this->event->start_date != $this->event->end_date);

$event_type = ($this->event->event_type_id == '2') ? "Workshop" : "Webinar";                    
echo "<h3>$event_type Hours:</h3>";
if ($this->event->event_type_id == '2') {                    
    echo "Registration at " . JptpHelper::format_time($this->event->registration_time);

    if ($two_day_event){
        echo " (first day only) <br />Day 1: ";
    } else {
        echo "<br />";
    }
}
echo "$event_type hours from " . JptpHelper::format_time($this->event->start_time) . " to " . JptpHelper::format_time($this->event->end_time) . "<br />";
if ($two_day_event){
    echo "Day 2: Workshop hours from " . JptpHelper::format_time($this->event->start_time2) . " to " . JptpHelper::format_time($this->event->end_time2) . "<br />";
}

echo "<h3>Registration:</h3>";
if ($this->registration_open){
    if ($event_end < time()){ //event end before current time
        echo "<p>Thank you for your interest.  This event has ended.  Please check the calendar for other training opportunities.</p>";
    } else if ($event_start < time()){ //event start before current time
        echo '<p>Thank you for your interest. This event has already started - online registration is closed.   
            Please check the calendar for other training opportunities.</p>';    
    } else {
        switch ($this->event->status){
            case 'closed':
                echo "Thank you for your interest.  At this time, this event and the wait list are full.  Please check the calendar for other training opportunities.";
                break;
            case 'wait_list':
                echo "This event is currently full.  You may continue to register to be placed on the waiting list for this event.";
            case 'open':
            default:
                if ( $this->event->event_type_id == '3' ) { //webinar
                    echo '<a href="' . $this->event->link . '" target="_blank">Register Online</a>';
                } else {
                    echo '<a href="' . JRoute::_("index.php?option=com_jptp&controller=registration&event_id=" . $this->event->id ) . '"> Register Online </a>';
                }    
        }
    }
} else {
    echo "Registration for this event begins " .  date("F j, Y", $this->registration_open_time) . ".";
    
}
echo "<h3>Licensing:</h3>";

if(count($this->approvals) > 0){
echo "<p>This workshop has been approved by: ";
    echo "<ul>";
    foreach($this->approvals as $approval){
        echo "<li>" . $approval . "</li>";
    }
    echo "</ul>";
} else {
    echo "None.";
}
echo "</p>";

echo "<h3>CEUs:</h3>";
echo (float)$this->event->ceu_credits . " CEUs are available through The University of Oklahoma.";