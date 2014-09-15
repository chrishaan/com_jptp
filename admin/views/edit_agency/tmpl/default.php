<?php
/**
 * @version $Id: default.php 192 2011-05-27 17:41:20Z chaan $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

    if ($this->row->id)
    {
            JToolBarHelper::title(JText::_('Edit Agency'), 'addedit.png');
    }
    else
    {
            JToolBarHelper::title(JText::_('Add Agency'), 'addedit.png');
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
    <legend>Agency Details</legend>
    <table class="admintable">
    <tr>
        <td width="200" align="right" class="key">Name of Agency</td>
        <td>
            <input name="name" id="name" style="width:200px" value="<?php echo $this->row->name; ?>" />
        </td>
    </tr> 
    <tr>
        <td width="200" align="right" class="key">Address</td>
        <td>
            <input name="address" id="address" style="width:200px" value="<?php echo $this->row->address; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Address 2</td>
        <td>
            <input name="address2" id="address2" style="width:200px" value="<?php echo $this->row->address2; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">City</td>
        <td>
            <input name="city" id="city" style="width:200px" value="<?php echo $this->row->city; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Zip</td>
        <td>
            <input name="zip" id="zip" style="width:200px" value="<?php echo $this->row->zip; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Phone</td>
        <td>
            <input name="phone" id="phone" style="width:200px" value="<?php echo $this->row->phone; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Fax</td>
        <td>
            <input name="fax" id="fax" style="width:200px" value="<?php echo $this->row->fax; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Director First Name</td>
        <td>
            <input name="director_first_name" id="director_first_name" style="width:200px" value="<?php echo $this->row->director_first_name; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Director Last Name</td>
        <td>
            <input name="director_last_name" id="director_last_name" style="width:200px" value="<?php echo $this->row->director_last_name; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Director Email</td>
        <td>
            <input name="director_email" id="director_email" style="width:200px" value="<?php echo $this->row->director_email; ?>" />
        </td>
    </tr>
    
    <tr>
        <td width="200" align="right" class="key">Listserv</td>
        <td>
            <?php echo $this->listserv; ?>
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Services Provided</td>
        <td>
            <textarea name="services" id="services" style="width: 300px; height: 75px;">
                <?php echo $this->row->services; ?>
            </textarea>
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Children / Youth Focus</td>
        <td>
            <?php echo $this->youth_focus; ?>
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Children / Youth Percentage</td>
        <td>
            <input type="text" name="youth_percent" id="youth_percent" value="<?php echo $this->row->youth_percent; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Agency type</td>
        <td>
            <?php echo $this->type; ?>
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Funding Sources</td>
        <td>
            <textarea name="funding_sources" id="funding_sources" style="width: 300px; height: 75px;">
                <?php echo $this->row->funding_sources; ?>
            </textarea>
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Primary Clientele and Referral Sources</td>
        <td>
            <textarea name="primary_clientele" id="primary_clientele" style="width: 300px; height: 75px;">
                <?php echo $this->row->primary_clientele; ?>
            </textarea>
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Clients served per year</td>
        <td>
            <input name="annual_clientele" id="annual_clientele" style="width:200px" value="<?php echo $this->row->annual_clientele; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Staff count</td>
        <td>
            <input name="staff_count" id="staff_count" style="width:200px" value="<?php echo $this->row->staff_count; ?>" />
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Staff Education</td>
        <td>
            <textarea name="staff_education" id="staff_education" style="width: 300px; height: 75px;">
                <?php echo $this->row->staff_education; ?>
            </textarea>
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Networking Agencies</td>
        <td>
            <textarea name="networking_agencies" id="networking_agencies" style="width: 300px; height: 75px;">
                <?php echo $this->row->networking_agencies; ?>
            </textarea>
        </td>
    </tr>
    <tr>
        <td width="200" align="right" class="key">Comments</td>
        <td>
            <textarea name="comments" id="comments" style="width: 300px; height: 75px;">
                <?php echo $this->row->comments; ?>
            </textarea>
        </td>
    </tr>
    <tr>
       <td width="200" align="right" class="key">Approved</td>
       <td>
         <?php echo $this->published; ?>
       </td>
    </tr>    
    </table>
   </fieldset>

    
    <input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="agencies" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>