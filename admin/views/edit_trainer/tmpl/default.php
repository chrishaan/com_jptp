<?php
/**
 * @version $Id: default.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

    if ($this->row->id)
    {
            JToolBarHelper::title(JText::_('Edit Trainer'), 'addedit.png');
    }
    else
    {
            JToolBarHelper::title(JText::_('Add Trainer'), 'addedit.png');
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
    <legend>Trainer Details</legend>
    <table class="admintable">
    <tr>
        <td width="200" align="right" class="key">First Name </td>
        <td>
            <input name="first_name" id="first_name" style="width:200px" value="<?php echo $this->row->first_name; ?>" />
        </td>
    </tr>
    <tr>
        <td align="right" class="key">Last Name </td>
        <td>
            <input name="last_name" id="last_name" style="width:200px" value="<?php echo $this->row->last_name; ?>" />
        </td>
    </tr>
    <tr>
        <td align="right" class="key">Credentials </td>
        <td>
            <input name="credentials" id="credentials" style="width:200px" value="<?php echo $this->row->credentials; ?>" />
        </td>
    </tr>
    <tr>
        <td  align="right" class="key" width="200">Title </td>
        <td><input name="title" id="title" style="width:200px" value="<?php echo $this->row->title; ?>" /></td>
    </tr>
    <tr>
        <td  align="right" class="key" width="200">Organization </td>
        <td><input name="organization" id="organization" style="width:200px" value="<?php echo $this->row->organization; ?>" /></td>
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
        <td  align="right" class="key" width="200">Biography </td>
        <td><?php echo $this->editor->display( 'biography', $this->row->biography, '100%', '150', '40', '5' ) ; ?></td>
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
    <input type="hidden" name="controller" value="trainers" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>