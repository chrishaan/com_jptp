<?php
/**
 * @version $Id: default.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

    if ($this->row->id)
    {
            JToolBarHelper::title(JText::_('Edit Site'), 'addedit.png');
    }
    else
    {
            JToolBarHelper::title(JText::_('Add Site'), 'addedit.png');
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
    <legend>Site Details</legend>
    <table class="admintable">
    <tr>
        <td width="200" align="right" class="key">Name of Site</td>
        <td>
            <input name="name" id="name" style="width:200px" value="<?php echo $this->row->name; ?>" />
        </td>
    </tr>
    <tr>
        <td align="right" class="key">Address </td>
        <td>
            <input name="address" id="address" style="width:200px" value="<?php echo $this->row->address; ?>" />
        </td>
    </tr>
    <tr>
        <td align="right" class="key">Address 2 </td>
        <td>
            <input name="address2" id="address2" style="width:200px" value="<?php echo $this->row->address2; ?>" />
        </td>
    </tr>
    <tr>
        <td  align="right" class="key" width="200">City </td>
        <td><input name="city" id="city" style="width:200px" value="<?php echo $this->row->city; ?>" /></td>
    </tr>
    <tr>
        <td  align="right" class="key" width="200">State </td>
        <td><input name="state" id="state" style="width:200px" value="<?php echo $this->row->state; ?>" /></td>
    </tr>
    <tr>
        <td  align="right" class="key" width="200">Zip </td>
        <td><input name="zip" id="zip" style="width:200px" value="<?php echo $this->row->zip; ?>" /></td>
    </tr>
    <tr>
        <td  align="right" class="key" width="200">Capacity </td>
        <td><input name="capacity" id="capacity" style="width:200px" value="<?php echo $this->row->capacity; ?>" /></td>
    </tr>
    <tr>
        <td  align="right" class="key" width="200">Notes </td>
        <td><?php echo $this->editor->display( 'notes', $this->row->notes, '100%', '150', '40', '5' ) ; ?></td>
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
    <input type="hidden" name="controller" value="sites" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>