<?php
/**
 * @version $Id:  $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class JptpModelAgencies extends JModel
{
    var $_data = null;
    var $_pagination = null;
    var $_total = null;
    var $_search = null;
    var $_query = null;

    function __construct()
    {
        parent::__construct();

        $mainframe = JFactory::getApplication();
        $option = Jrequest::getCmd('option');

        // Get the pagination request variables
        $limit      = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( "$option.limitstart", 'limitstart', JRequest::getVar('limitstart', 0), 'int');

        // In case limit has been changed, adjust limitstart accordingly
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function getData()
    {
    if (empty($this->_data)) {
        $query = $this->buildSearch();
        $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
    }

    return $this->_data;
    }

    function getPagination()
    {
    if (!$this->_pagination) {
        jimport('joomla.html.pagination');
        $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
    }

    return $this->_pagination;
    }

    function getTotal()
    {
        if (!$this->_total) {
                $query = $this->buildSearch();
                $this->_total = $this->_getListCount($query);
        }

        return $this->_total;
    }

    function buildSearch()
    {
        //Get the WHERE and ORDER BY clauses for the query
        $where      = $this->_buildContentWhere();
        $orderby    = $this->_buildContentOrderBy();

        $this->_query = 'SELECT *'
        . ' FROM #__jptp_agencies'
        . $where
        . $orderby
        ;
        return $this->_query;
    }
    
    function getQuery() 
    {
        if(!$this->_query){ 
            $this->buildSearch();
        }
        
        return $this->_query;
        
    }

	/**
	 * Build the order clause
	 *
	 * @access private
	 * @return string
	 */
    function _buildContentOrderBy()
    {
        $mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');

        $filter_order	= $mainframe->getUserStateFromRequest( $option.'agencies.filter_order', 'filter_order', 'time', 'cmd' );
        $filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'agencies.filter_order_Dir', 'filter_order_Dir', '', 'word' );

        $orderby = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir;

        return $orderby;
    }

	/**
	 * Build the where clause
	 *
	 * @access private
	 * @return string
	 */
    function _buildContentWhere()
    {
        $mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');

        $filter_state 	= $mainframe->getUserStateFromRequest( $option.'agencies.filter_state', 'filter_state', '', 'word' );
        $filter         = $mainframe->getUserStateFromRequest( $option.'agencies.filter', 'filter', '', 'int' );
        $search         = $mainframe->getUserStateFromRequest( $option.'agencies.search', 'search', '', 'string' );
        $search         = $this->_db->getEscaped( trim(JString::strtolower( $search ) ) );

        $where = array();

        if ($filter_state) {
            switch($filter_state){
                case 'P':
                    $where[] = 'published = 1';
                    break;
                case 'U':
                    $where[] = 'published = 0';
                    break;
            }
        }

        if ($search){
            switch($filter){
                case 1:
                    $where[] = ' LOWER(name) LIKE \'%'.$search.'%\' ';
                    break;
                case 2:
                    $where[] = ' LOWER(city) LIKE \'%'.$search.'%\' ';
                    break;
            }
        }

        $where 	= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

        return $where;
    }
}