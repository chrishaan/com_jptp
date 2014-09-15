<?php
/**
 * @version $Id: $
 */
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JToolBarHelper::title(JText::_( 'JPTP - Registration Calendar' ), 'cpanel.png');
JToolBarHelper::preferences('com_jptp');
?>
<table class="adminlist">
    <tr>
        <td>
            <div id="cpanel">
                <ul>
                    <li><a href='index.php?option=com_jptp&amp;controller=trainers'>Manage Trainers</a></li>          

                    <li><a href='index.php?option=com_jptp&amp;controller=sites'>Manage Sites</a></li>

                    <li><a href='index.php?option=com_jptp&amp;controller=licensing_orgs'>Manage Licensing Organizations</a></li>

                    <li><a href='index.php?option=com_jptp&amp;controller=registrants'>Manage Registrations</a></li>

            <div class="clr"></div>


            </div>
        </td>
    </tr>

    <tfoot>
        <tr>
            <td colspan="2"> <?php echo JText::_( 'Version' );?> : <?php echo $this->com_info['version'];?> Build Date : <?php echo $this->com_info['creationdate'];?> </td>
        </tr>
    </tfoot>
</table>
