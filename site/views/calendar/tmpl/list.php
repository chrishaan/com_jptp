<?php
/**
 * @version $Id:  $
 */
//no direct access
defined('_JEXEC') or die('Restricted access');

$doc =& JFactory::getDocument();
$doc->addStyleSheet( 'http://' . $_SERVER['SERVER_NAME'] . "/components/com_jptp/assets/calendar.css" );

$first_year = ($this->current_month < 7 ) ? $this->current_year - 1  : $this->current_year;
$second_year = $first_year + 1;

echo "<h1>JPTP Training {$first_year} &mdash; {$second_year}</h1>";
   
echo '<a href="' . JRoute::_('index.php?option=com_jptp&controller=calendar') .'" style="display:inline;">Calendar View</a>';

echo <<<EOL
   <table id="calendar_list">
       <tr>
           <th width="50%">Training</th>
           <th>Type</th>
           <th>Audience</th>
           <th>Location</th>
           <th>Date</th>
       </tr>

EOL;

foreach ($this->events as $event){
echo "<tr>";
$info_link = JRoute::_("index.php?option=com_jptp&controller=description&event_id=" . $event->id);
echo <<<EOL
    <td><a href="{$info_link}">{$event->title}</a></td>
    <td>{$event->type}</td>
    <td>{$event->audience}</td>
    <td>{$event->city}</td>
EOL;

if ($event->start_date == $event->end_date) {
    $date = date("F j, Y", strtotime($event->start_date));
} else {
    $date = date("F j", strtotime($event->start_date)) . ' - ' . date("j, Y", strtotime($event->end_date));
}

    echo "<td>{$date}</td>";
    echo "</tr>";
}

echo "</table>";