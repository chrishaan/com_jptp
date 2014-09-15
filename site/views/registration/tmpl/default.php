<?php

//no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.html.behavior');
JHTML::_('behavior.mootools');

$ordinals = array('first', 'second', 'third', 'fourth', 'fifth' );
?>

<script type="text/javascript">

    var Site = {

        start: function(){
            if($('vertical')) Site.vertical();

        },

        vertical: function(){
            var list = $$('#vertical form fieldset.collapse');
            var headings = $$('#vertical form label.toggle');

            var collapsibles = new Array();

            headings.each( function(heading, i) {
                var input = $E('input', heading);

                var collapsible = new Fx.Slide(list[i], {
                    duration: 250,
                    transition: Fx.Transitions.linear,
                    onComplete: function(request){
                        var open = request.getStyle('margin-top').toInt();
                        //input = $E('input', heading);
                        input.checked = !input.checked;
                    }
                });

                collapsibles[i] = collapsible;

                heading.onclick = function(){
                    collapsible.toggle();
                    return false;
                }

                if(!input.checked){
                    collapsible.hide();
                }

            });
        }

    };

    window.addEvent('domready', Site.start);
</script>

<?php
if ($this->event->start_date == $this->event->end_date) {
    $date = date("F j, Y", strtotime($this->event->start_date));
} else {
    $date = date("F j", strtotime($this->event->start_date)) . ' - ' . date("j, Y", strtotime($this->event->end_date));
}

if (!($this->event)) {
    echo "<h1>Event Not Found</h1>";
    echo "The specified event was not found or is not accepting registrations at this time.";
} else {
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
    } else {

    
    
?>

<h2 class="center"><?php echo $this->event->title; ?></h2>
<h4 class="center"> <?php echo $date; ?><br />
<?php echo $this->event->location; ?></h4>
<div id="vertical">
    <form action="index.php?option=com_jptp" method="post" name="confreg" id="confreg">

<?php
//get contact variables to echo back to form
$contact_first_name = JRequest::getString('contact_first_name', '');
$contact_last_name = JRequest::getString('contact_last_name', '');
$address = JRequest::getString('address', '');
$address2 = JRequest::getString('address2', '');
$city = JRequest::getString('city', '');
$zip = JRequest::getString('zip', '');
$phone = JRequest::getString('phone', '');
$fax = JRequest::getString('fax', '');
$email = JRequest::getString('email', '');

echo <<<EOL
<fieldset>
    <legend>Agency/Organization Information</legend>
    <ul>
        <li>
            <span class="required">*</span> indicates required fields
        </li>
        <li>
            <label for="agency">Agency <span class="required">*</span></label>
            {$this->agency_select}
        </li>
        <li>
            If your agency is not listed, you will need to fill out the <a href="/jptp-agency-application">online agency registration</a>.
        </li>
        <li>
            <label for="contact_first_name">First Name <span class="required">*</span></label>
            <input type="text" name="contact_first_name" id="contact_first_name" value="{$contact_first_name}" />
        </li>
        <li>
            <label for="contact_last_name">Last Name <span class="required">*</span></label>
            <input type="text" name="contact_last_name" id="contact_last_name" value="{$contact_last_name}" />
        </li>

        <li>
            <label for="address">Address <span class="required">*</span></label>
            <input type="text" name="address" id="address" value="{$address}" />
        </li>
        <li>
            <label for="address2">Address Line 2</label>
            <input type="text" name="address2" id="address2" value="{$address2}" />
        </li>
        <li>
            <label for="city">City <span class="required">*</span></label>
            <input type="text" name="city" id="city" value="{$city}" />
        </li>
        <li>
            <label for="state">State <span class="required">*</span></label>
            <select name="state" id="state">
                <option value="OK">OK</option>
            </select>
        </li>
        <li>
            <label for="zip">Zip <span class="required">*</span></label>
            <input type="text" name="zip" id="zip" maxlength="5" value="{$zip}" />
        </li>
        <li>
            <label for="phone">Agency Phone <span class="required">*</span></label>
            <input type="text" name="phone" id="phone" maxlength="20" value="{$phone}" />
        </li>
        <li>
            <label for="fax">Agency Fax</label>
            <input type="text" name="fax" id="fax" maxlength="20" value="{$fax}" />
        </li>
        <li>
            <label for="email">Confirmation Email <span class="required">*</span></label>
            <input type="email" name="email" id="email" value="{$email}" />
        </li>
    </ul>
            
    <p style="margin-left: 10px;"><strong>Please limit your registration to five or fewer participants (from one agency), per workshop.</strong></p>        
            
            
            
            
</fieldset>
EOL;

    $registration_add		  = JRequest::getVar('registration_add',           array(), '', 'array');
    $registration_first_name      = JRequest::getVar('registration_first_name',    array(), '', 'array');
    $registration_last_name       = JRequest::getVar('registration_last_name',     array(), '', 'array');
    $registration_job_title       = JRequest::getVar('registration_job_title',     array(), '', 'array');
    $registration_accommodations  = JRequest::getVar('registration_accomodations', array(), '', 'array');
    $registration_email           = JRequest::getVar('registration_email',         array(), '', 'array');
    $registration_phone           = JRequest::getVar('registration_phone',         array(), '', 'array');    
                        
    for( $i = 0; $i < 5; $i++ ) {
        $registration_add[$i]            = (array_key_exists($i, $registration_add) && (int) $registration_add[$i] == 1) ? 'checked="checked"' : '';
        $registration_first_name[$i]     = (array_key_exists($i, $registration_first_name)) ? $registration_first_name[$i] : '';
        $registration_last_name[$i]      = (array_key_exists($i, $registration_last_name)) ? $registration_last_name[$i] : '';
        $registration_job_title[$i]      = (array_key_exists($i, $registration_job_title)) ? $registration_job_title[$i] : '';
        $registration_accommodations[$i] = (array_key_exists($i, $registration_accommodations)) ? $registration_accommodations[$i] : '';
        $registration_email[$i]          = (array_key_exists($i, $registration_email)) ? $registration_email[$i] : '';
        $registration_phone[$i]          = (array_key_exists($i, $registration_phone)) ? $registration_phone[$i] : '';        
        $registration_number = $i + 1;
            
    echo <<<EOL
    <label for="registration_add_{$i}" class="toggle">
    <input type="checkbox" name="registration_add[{$i}]" id="registration_add_{$i}" value="1" {$registration_add[$i]} />
    Add {$ordinals[$i]} registrant</label>
    <div style="clear: both;"></div>
    <fieldset class="collapse">
        <legend>Registrant {$registration_number} Information</legend>
        <ul>
            <li>
                <label for="registration_first_name_{$i}">First Name <span class="required">*</span></label>
                <input type="text" name="registration_first_name[{$i}]" id="registration_first_name_{$i}" value="{$registration_first_name[$i]}" />
            </li>
            <li>
                <label for="registration_last_name_{$i}">Last Name <span class="required">*</span></label>
                <input type="text" name="registration_last_name[{$i}]" id="registration_last_name_{$i}" value="{$registration_last_name[$i]}" />
            </li>
            <li>
                <label for="registration_job_title_{$i}">Job Title <span class="required">*</span></label>
                <input type="text" name="registration_job_title[{$i}]" id="registration_job_title_{$i}" value="{$registration_job_title[$i]}" />
            </li>          
            <li>
                <label for="registration_phone_{$i}">Phone <span class="required">*</span></label>
                <input type="text" name="registration_phone[{$i}]" id="youth_phone_{$i}" value="{$registration_phone[$i]}" />
                <em>(Required in case of event cancellation)</em>
            </li>
            <li>
                <label for="registration_email_{$i}">Email <span class="required">*</span></label>
                <input type="email" name="registration_email[{$i}]" id="registration_email_{$i}" value="{$registration_email[$i]}" />
                <em>(Required in case of event cancellation)</em>
            </li>
            <li>
                <label style="width: 100%;" for="registration_accomodations_{$i}">Special Accommodations. Special services are available to those in need. Please enter a note of explanation.</label><br />
                <input type="text" name="registration_accomodations[{$i}]" id="registration_accomodations_{$i}" size="112" value="{$registration_accommodations[$i]}" />
            </li>

        </ul>
    </fieldset>
EOL;
                
}  //endfor
?>

        <fieldset>
            <div align="center">
                <?php echo JHTML::_('form.token'); ?>
                <input type="hidden" name="event_id" value="<?php echo $this->event->id; ?>" />
                <input type="hidden" name="controller" value="registration" />
                <input type="hidden" name="task" value="save" />
                <input type="hidden" name="Itemid" value="<?php echo JRequest::getInt('Itemid', '') ?>" />
                <button type="submit"><?php echo JText::_('Submit'); ?></button>
            </div>
        </fieldset>
    </form>
</div>

<?php }} ?>
