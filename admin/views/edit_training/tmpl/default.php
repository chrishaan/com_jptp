<?php
/**
 * @version $Id: default.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JHTML::script('edit_training.js', 'administrator/components/com_jptp/assets/' );

    if ($this->row->id)
    {
            JToolBarHelper::title(JText::_('Edit Training'), 'addedit.png');
    }
    else
    {
            JToolBarHelper::title(JText::_('Add Training'), 'addedit.png');
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
 
//$pane =& JPane::getInstance( 'sliders' );
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">

<fieldset class="adminform">
    <legend>Training Details</legend>
    <table class="admintable">
    <tr>
        <td width="200" align="right" class="key">Title </td>
        <td>
            <input name="title" id="title" style="width:400px" value="<?php echo $this->row->title; ?>" />
        </td>
    </tr>
    <tr>
        <td align="right" class="key">Audience </td>
        <td> 
            <?php echo $this->audience; ?>
        </td>
    </tr>
    <tr>
        <td align="right" class="key">Prerequisites </td>
        <td>
            <?php echo $this->editor->display( 'prerequisites', $this->row->prerequisites, '100%', '150', '40', '5' ) ; ?>
        </td>
    </tr>
    <tr>
        <td  align="right" class="key" width="200">Description </td>
        <td><?php echo $this->editor->display( 'description', $this->row->description, '100%', '150', '40', '5' ) ; ?></td>
    </tr>
    <tr>
        <td  align="right" class="key" width="200">CEU credits </td>
        <td><input name="ceu_credits" id="ceu_credits" style="width:200px" value="<?php echo $this->row->ceu_credits; ?>" /></td>
    </tr>
    <tr> 
        <td  align="right" class="key" width="200">Approved By </td>       
        <td>
            <?php echo $this->licensing_orgs; ?> &nbsp; <input type="button" id="add_approval" onClick="attach_approval()" value="Add Approval" /><br />
            <div id="approvals">
                <!-- links for removing approvals will be inserted here -->
            </div>                  
        </td>
    </tr>
    <tr> 
        <td  align="right" class="key" width="200">Published </td>       
        <td>
            <?php echo $this->published; ?>
        </td>
    </tr>
    <tr> 
        <td  align="right" class="key" width="200">Participant Limit </td>       
        <td>
            <input name="participant_limit" id="participant_limit" style="width:200px" value="<?php echo $this->row->participant_limit; ?>" />
        </td>
    </tr>      
    </table>
   </fieldset>

    
    <input type="hidden" name="id" id="id" value="<?php echo $this->row->id; ?>" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="trainings" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>