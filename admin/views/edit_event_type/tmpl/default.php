<?php
/**
 * @version $Id: default.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

    if ($this->row->id)
    {
            JToolBarHelper::title(JText::_('Edit Event Type'), 'addedit.png');
    }
    else
    {
            JToolBarHelper::title(JText::_('Add Event Type '), 'addedit.png');
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
    <legend>Event Type Details</legend>
    <table class="admintable">
    <tr>
        <td width="200" align="right" class="key">Name of Event Type</td>
        <td>
            <input name="name" id="name" style="width:200px" value="<?php echo $this->row->name; ?>" />
        </td>
    </tr> 
    <tr>
        <td  align="right" class="key" width="200">Description </td>
        <td><?php echo $this->editor->display( 'description', $this->row->description, '100%', '150', '40', '5' ) ; ?></td>
    </tr>    
    <tr>
        <td align="right" class="key" width="200">Published</td>
        <td><?php echo $this->published; ?></td>
    </tr>
    </table>
   </fieldset>

    
    <input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="event_types" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>