<?php
/**
 * @version $Id:  $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class JptpModelTrainers extends JModel
{
    var $_data = null;
	var $_pagination = null;
	var $_total = null;
	var $_search = null;
	var $_query = null;

	function getData()
	{
        $pagination =& $this->getPagination();

        if (empty($this->_data)) {
            $query = $this->buildSearch();
            $this->_data = $this->_getList($query, $pagination->limitstart, $pagination->limit);
        }

        return $this->_data;
	}

	function getPagination()
    {
        if (!$this->_pagination) {
            jimport('joomla.html.pagination');
            $mainframe = JFactory::getApplication();
            $this->_pagination = new JPagination($this->getTotal(), JRequest::getVar('limitstart', 0), JRequest::getVar('limit', $mainframe->getCfg('list_limit')));
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
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();

		$this->_query = 'SELECT *'
		. ' FROM #__jptp_trainers'
		. $where
		. $orderby
		;
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

		$filter_order	  = $mainframe->getUserStateFromRequest( $option.'trainers.filter_order', 'filter_order', 'last_name', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'trainers.filter_order_Dir', 'filter_order_Dir', '', 'word' );

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

		$filter_state 	= $mainframe->getUserStateFromRequest( $option.'trainers.filter_state', 'filter_state', '', 'word' );
		$filter         = $mainframe->getUserStateFromRequest( $option.'trainers.filter', 'filter', '', 'int' );
		$search         = $mainframe->getUserStateFromRequest( $option.'trainers.search', 'search', '', 'string' );
		$search         = $this->_db->getEscaped( trim(JString::strtolower( $search ) ) );

		$where = array();

                if ($filter_state) {
                    switch($filter_state){
			case 'P':
                            $where[] = 'e.published = 1';
                            break;
			case 'U':
                            $where[] = 'e.published = 0';
                            break;
                    }
		}

                if($search) {
                    switch($filter){
                        case '1':
                            $where[] = ' LOWER(last_name) LIKE \'%'.$search.'%\' ';
                            break;
                        case '2':
                            $where[] = ' LOWER(first_name) LIKE \'%'.$search.'%\' ';
                            break;
                        case '3':
                            $where[] = ' LOWER(city) LIKE \'%'.$search.'%\' ';
                            break;                        
                    }

                    $where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

                    return $where;
                }
	}
}