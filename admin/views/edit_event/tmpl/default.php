<?php
/**
 * @version $Id: default.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JHTML::_('behavior.calendar');

JHTML::script('edit_event.js', 'administrator/components/com_jptp/assets/' );
JHTML::script('time_input.js', 'administrator/components/com_jptp/assets/' );

if ($this->row->id)
{
    JToolBarHelper::title(JText::_('Edit Event'), 'addedit.png');
}
else
{
    JToolBarHelper::title(JText::_('Add Event'), 'addedit.png');
}

JToolBarHelper::save();
JToolBarHelper::apply();


if ($this->row->id)
{
        JToolBarHelper::cancel('cancel', 'Close');
}
else
{
        JToolBarHelper::cancel();
}
    
jimport('joomla.html.pane');
 

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">

<fieldset class="adminform">
    <legend>Event Details</legend>
    <table class="admintable">
    <tr>
        <td align="right" class="key">Training </td>
        <td> 
            <?php echo $this->trainings; ?>
        </td>
    </tr>
    <tr>
        <td align="right" class="key">Site </td>
        <td> 
            <?php echo $this->sites; ?>
        </td>
    </tr>
     <tr>
        <td align="right" class="key">Start Date </td>
        <td> 
            <?php echo $this->start_date; ?>
        </td>
    </tr>
    <tr>
        <td align="right" class="key">End Date </td>
        <td> 
            <?php echo $this->end_date; ?>
        </td>
    </tr>
    <tr>
        <td align="right" class="key">Registration Time </td>
        <td>
            
            <input type="time" id="registration_time" name="registration_time" value="<?php echo $this->row->registration_time; ?>" />
        </td>
    </tr>
     <tr>
        <td align="right" class="key">Day 1 Start Time </td>
        <td>   
            <input type="time" id="start_time" name="start_time" value="<?php echo $this->row->start_time; ?>" />
        </td>
    </tr> 
   <tr>
        <td align="right" class="key">Day 1 End Time </td>
        <td>
            <input type="time" id="end_time" name="end_time" value="<?php echo $this->row->end_time; ?>" />
        </td>
    </tr>
     <tr>
        <td align="right" class="key">Day 2 Start Time </td>
        <td>
            <input type="time" id="start2_time" name="start_time2" value="<?php echo $this->row->start_time2; ?>" />
        </td>
    </tr> 
   <tr>
        <td align="right" class="key">Day 2 End Time </td>
        <td>
            <input type="time" id="end2_time" name="end_time2" value="<?php echo $this->row->end_time2; ?>" />
        </td>
    </tr>
    <tr>
        <td align="right" class="key">Event Type </td>
        <td> 
            <?php echo $this->event_types; ?>
        </td>
    </tr>
    <tr>
        <td align="right" class="key">PIF#</td>
        <td>
            <input type="text" id="pif" name="pif" value="<?php echo $this->row->pif; ?>" /> 
        </td>
    </tr>
    <tr> 
        <td  align="right" class="key" width="200">Trainers </td>       
        <td>
            <?php echo $this->trainers; ?> &nbsp; <input type="button" id="add_trainer" onClick="attach_trainer()" value="Add Trainer" /><br />
            <div id="trainers">
                <!-- links for removing trainers will be inserted here -->
            </div>                  
        </td>
    </tr>
    <tr>
        <td align="right" class="key" width="200">Status </td>
        <td>
            <?php echo $this->status; ?>
        </td>
    </tr>
    <tr>
        <td align="right" class="key" width="200">Registration Count</td>
        <td>
            <input type="text" size="3" name="registration_count" id="registration_count" value="<?php echo $this->row->registration_count; ?>" />
        </td>
    </tr>
    <tr>
        <td align="right" class="key" width="200">Registration Link<br />(for webinars)</td>
        <td>
            <input type="text" size="100" name="link" id="link" value="<?php echo $this->row->link; ?>" />
        </td>
    </tr>
    <tr> 
        <td  align="right" class="key" width="200">Published </td>       
        <td>
            <?php echo $this->published; ?>
        </td>
    </tr>
    </table>
   </fieldset>

    
    <input type="hidden" name="id" id="id" value="<?php echo $this->row->id; ?>" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="events" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>
