<?php
/**
 * @version $Id: default.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JHTML::script('edit_training.js', 'administrator/components/com_jptp/assets/' );

    if ($this->row->id)
    {
            JToolBarHelper::title(JText::_('Edit Registrant'), 'addedit.png');
    }
    else
    {
            JToolBarHelper::title(JText::_('Add Registrant'), 'addedit.png');
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
    <legend>Registrant Details</legend>
    <table class="admintable">
    <tr>
        <td width="200" align="right" class="key">First Name </td>
        <td>
            <input name="first_name" id="first_name" style="width:400px" value="<?php echo $this->row->first_name; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Last Name </td>
        <td>
            <input name="last_name" id="last_name" style="width:400px" value="<?php echo $this->row->last_name; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Job Title </td>
        <td>
            <input name="job_title" id="job_title" style="width:400px" value="<?php echo $this->row->job_title; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Phone </td>
        <td>
            <input name="phone" id="phone" style="width:400px" value="<?php echo $this->row->phone; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Email </td>
        <td>
            <input name="email" id="email" style="width:400px" value="<?php echo $this->row->email; ?>" />
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
    <input type="hidden" name="controller" value="registrants" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>