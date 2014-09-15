<?php 
/**
* @version $Id:  $
* @package Joomla
* @subpackage JPTP
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * View class for the licensing_orgs list
 *
 * @package Joomla
 * @subpackage JPTP
 * @since
 */


class JptpViewLicensing_orgs extends JView
{	
    function display($tpl = null)
    {
        $mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        $db  = & JFactory::getDBO();

        $rows =& $this->get('data');
        $pagination =& $this->get('pagination');
        $search =& $this->get('search');

        $filter_order = $mainframe->getUserStateFromRequest( $option.'licensing_orgs.filter_order', 'filter_order', 'title', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'licensing_orgs.filter_order_Dir', 'filter_order_Dir', '', 'word' );
        $filter_state = $mainframe->getUserStateFromRequest( $option.'licensing_orgs.filter_state', 'filter_state', '*', 'word' );
        $filter = $mainframe->getUserStateFromRequest( $option.'licensing_orgs.filter', 'filter', '', 'int' );
        $search = $mainframe->getUserStateFromRequest( $option.'licensing_orgs.search', 'search', '', 'string' );
        $search = $db->getEscaped( trim(JString::strtolower( $search ) ) );

        // table ordering
        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;

        //search filter
        $filters = array();
        $filters[] = JHTML::_('select.option', '1', JText::_( 'Title' ) );
        //$filters[] = JHTML::_('select.option', '2', JText::_( 'Description' ) );
        //$filters[] = JHTML::_('select.option', '3', JText::_( 'Objectives' ) );
         $lists['filter'] = JHTML::_('select.genericlist', $filters, 'filter', 'size="1" class="inputbox"', 'value', 'text', $filter );

        // search filter
        $lists['search']= $search;

        $this->assignRef('rows', $rows);
        $this->assignRef('pagination', $pagination);
        $this->assign('search', $search);
        $this->assignRef( 'lists', $lists );

        parent::display($tpl);
    }
}