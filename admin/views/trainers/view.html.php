<?php 
/**
* @version $Id:  $
* @package Joomla
* @subpackage JPTP
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * View class for the trainers list
 *
 * @package Joomla
 * @subpackage trainers
 * @since
 */


class JptpViewTrainers extends JView
{	
    function display($tpl = null)
    {
        $mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        $db  = & JFactory::getDBO();
        

        $rows =& $this->get('data');
        $pagination =& $this->get('pagination');
        $search =& $this->get('search');

        $filter_order = $mainframe->getUserStateFromRequest( $option.'trainers.filter_order', 'filter_order', 	'title', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'trainers.filter_order_Dir', 'filter_order_Dir',	'', 'word' );
        $filter_state = $mainframe->getUserStateFromRequest( $option.'trainers.filter_state', 'filter_state', 	'*', 'word' );
        $filter = $mainframe->getUserStateFromRequest( $option.'trainers.filter', 'filter', '', 'int' );
        $search = $mainframe->getUserStateFromRequest( $option.'trainers.search', 'search', '', 'string' );
        $search = $db->getEscaped( trim(JString::strtolower( $search ) ) );

        // table ordering
        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;

        //search filter
        $filters = array();
        $filters[] = JHTML::_('select.option', '1', JText::_( 'Last Name' ) );
        $filters[] = JHTML::_('select.option', '2', JText::_( 'First Name' ) );
        $filters[] = JHTML::_('select.option', '3', JText::_( 'City' ) );
         $lists['filter'] = JHTML::_('select.genericlist', $filters, 'filter', 'size="1" class="inputbox"', 'value', 'text', $filter );

        //state filter
        $process = array();
        $process[] = JHTML::_('select.option', 'A', 'All' );
        $process[] = JHTML::_('select.option', 'P', JText::_( 'Published' ) );
        $process[] = JHTML::_('select.option', 'U', JText::_( 'Unpublished' ) );
        $lists['state']	= JHTML::_('select.genericlist', $process, 'filter_state', 'size="1" class="inputbox" onchange="submitform();"', 'value', 'text', $filter_state );
         
        // search filter
        $lists['search']= $search;

        $this->assignRef('rows', $rows);
        $this->assignRef('pagination', $pagination);
        $this->assign('search', $search);
        $this->assignRef( 'lists', $lists );

        parent::display($tpl);
    }
}