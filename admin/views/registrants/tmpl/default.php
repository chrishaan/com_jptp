<?php
/**
* @version $Id:  $
* @package	Joomla
* @subpackage JPTP
*/
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JToolBarHelper::title(JText::_( 'Manage Registrants' ), 'generic.png');
JToolBarHelper::publishList();
JToolBarHelper::unpublishList();
//JToolBarHelper::addNew();
JToolBarHelper::editList();
JToolBarHelper::deleteList('Are you certain you want to delete the trainer(s)');

?>
<form action="index.php" method="post" name="adminForm">
    <table style="width: 100%;">
	<tr>
            <td align="left">
                <?php
                echo JText::_( 'SEARCH: ' );
                echo $this->lists['filter'];
                ?>
                <input type="text" name="search" id="search" value="<?php echo $this->lists['search']; ?>" class="text_area" onChange="document.adminForm.submit();" />
                <button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
                <button onclick="this.form.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
            </td>
            <td style="text-align: right;"><?php echo $this->lists['state']; ?></td>
	</tr>
    </table>
<table class="adminlist">
  <thead>
    <tr>
      <th width="20">
        <input type="checkbox" name="toggle"
             value="" onclick="checkAll(<?php echo
             count( $this->rows ); ?>);" />
      </th>
      <th class="title"><?php echo JHTML::_('grid.sort', 'Last Name', 'last_name', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
      <th class="title"><?php echo JHTML::_('grid.sort', 'First Name', 'first_name', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
      <th class="title"><?php echo JHTML::_('grid.sort', 'Phone', 'phone', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
      <th class="title"><?php echo JHTML::_('grid.sort', 'Email', 'email', $this->lists['order_Dir'], $this->lists['order'] ); ?></th> 
      <th class="title"><?php echo JHTML::_('grid.sort', 'Event', 'title', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>  
      <th class="title"><?php echo JHTML::_('grid.sort', 'Date', 'start_date', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>        
      <th width="5%" nowrap="nowrap">Published</th>
    </tr>
  </thead>

  <?php
  jimport('joomla.filter.output');
  $k = 0;
  for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
  {
    $row = &$this->rows[$i];
    $checked = JHTML::_('grid.id', $i, $row->id );
    $published = JHTML::_('grid.published', $row, $i );
	$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&controller=registrants&task=edit&cid[]='. $row->id );
    ?>
    <tr class="<?php echo "row$k"; ?>">
      <td>
        <?php echo $checked; ?>
      </td>
        <td>
            <a href="<?php echo $link; ?>"><?php echo $row->last_name; ?></a>
        </td>
        <td>
            <?php echo $row->first_name; ?>
        </td>
        <td>
            <?php echo $row->phone; ?>
        </td>
        <td>
            <?php echo $row->email; ?>
        </td>
        <td>    
            <?php echo $row->title; ?>
        </td>
        <td>
            <?php echo $row->start_date; ?>
        </td>
        <td align="center">
            <?php echo $published;?>
        </td>
    </tr>
    <?php
    $k = 1 - $k;
  }
  ?>
  <tfoot>
  	<tr>
            <td colspan="8"><?php echo $this->pagination->getListFooter(); ?></td>
  	</tr>
  </tfoot>
</table>
<?php echo JHTML::_('form.token'); ?>
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="registrants" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>