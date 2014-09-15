<?php
/**
 * @version $Id: $
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
if($this->event->start_date == $this->event->end_date){
    $date = date( "F j, Y", strtotime ($this->event->start_date));
} else {
    $date = date( "F j", strtotime ($this->event->start_date)) . " - " . date( "j, Y", strtotime ($this->event->end_date));
}

echo <<<EOL
    <h2>Thank you for your interest in this workshop.</h2>
    <p>Please review the information below for accuracy.  You will receive a separate email confirmation of registration
    or notification that you have been placed on a waiting list.</p>

    <p>{$this->event->title}.<br />
    {$this->event->location} &mdash; {$date}</p>

    <p>Agency Information:</p>
    <p>Agency:          <strong>{$this->contact->agency}</strong><br />
    Contact:         <strong>{$this->contact->first_name} {$this->contact->last_name}</strong><br />
    Address:         <strong>{$this->contact->address}</strong><br />
EOL;
    if(!empty($this->contact->address2)){
        echo "Address2:        <strong>{$this->contact->address2}</strong><br />";
    }
echo <<<EOL
    City:            <strong>{$this->contact->city}</strong><br />
    State:           <strong>{$this->contact->state}</strong><br />
    Zip:             <strong>{$this->contact->zip}</strong><br />
    Phone:           <strong>{$this->contact->phone}</strong><br />
EOL;
    if(!empty($this->contact->fax)){
        echo "Fax:             <strong>{$this->contact->fax}</strong><br />";
    }
    echo "</p>";   
?>

<p>Registrants:</p>
<?php 
foreach($this->registrations as $registration)
{
    echo <<<EOL
    <p>Name: <strong>{$registration->first_name} {$registration->last_name}</strong><br />
    Job Title: <strong>{$registration->job_title}</strong><br />
    Phone: <strong>{$registration->phone}</strong><br />
    Email: <strong>{$registration->email}</strong><br />
EOL;
    if(!empty($registration->accommodations)){
        echo "Special Accomodations: <strong>{$registration->accommodations}</strong><br />";
    }
    
    $cancel_link = 'http://' . $_SERVER['SERVER_NAME'] . '/index.php?option=com_jptp&controller=registration&event_id='.$this->event->id . '&task=cancel&hash='.$registration->cancel_hash;
    echo "<a href=" . $cancel_link ."> Cancel registration for ". $registration->first_name . " " . $registration->last_name . "</a>";
    
    echo "</p>";
}
?>
