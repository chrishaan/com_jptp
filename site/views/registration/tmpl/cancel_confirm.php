<?php
/**
 * @version $Id:  $
 */
//no direct access
defined('_JEXEC') or die('Restricted access');

if ($this->event->start_date == $this->event->end_date) {
    $date = date("F j, Y", strtotime($this->event->start_date));
} else {
    $date = date("F j", strtotime($this->event->start_date)) . ' - ' . date("j, Y", strtotime($this->event->end_date));
}

echo "<h2>Registration Cancellation</h2>";

echo "<p>Cancellation request has been received for {$this->registration->first_name} {$this->registration->last_name} for the following event:<br />
{$this->event->title} on {$date}. ";

?>
