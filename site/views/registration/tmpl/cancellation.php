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

if($this->registration->cancelled){
    
    echo "<p>This registration has already been cancelled.</p>";    

} else {
    echo "<p>{$this->registration->first_name} {$this->registration->last_name} is currently registered for {$this->event->title} on {$date}. ";
    echo "If he or she cannot attend this event, we encourage you to cancel this registration so that space can be made available for another participant.
    Please click the button below to cancel this registration.</p>";
    
    echo '<form action="' . JRoute::_('index.php?option=com_jptp&controller=registration') .'" method="post">';
    
    echo <<<EOL
    <div align="center">    
        <input type="hidden" name="hash" value="{$this->registration->cancel_hash}" />
        <input type="hidden" name="event_id" value="{$this->event->id}" />
        <input type="hidden" name="controller" value="registration" />
        <input type="hidden" name="task" value="cancel_confirm" />
EOL;
       
    echo JHTML::_('form.token');
     
    echo <<<EOL
        <button type="submit">Cancel Registration</button>
    </div>
</form>

EOL;

}    
?>