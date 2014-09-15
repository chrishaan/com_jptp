<?php
/**
 * @version $Id:  $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class JptpModelEvents extends JModel
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
            $where	= $this->_buildContentWhere();
            $orderby	= $this->_buildContentOrderBy();

            $this->_query = 'SELECT e.id, t.title, e.start_date, e.start_time, e.published, e.status, s.name AS site, ety.name AS event_type,'
            . ' (SELECT GROUP_CONCAT(CONCAT( trainer.first_name, " ", trainer.last_name) SEPARATOR "<br />") FROM #__jptp_event_trainers AS et LEFT JOIN #__jptp_trainers AS trainer ON et.trainer_id = trainer.id '
            . ' WHERE e.id = et.event_id) AS trainers'
            . ' FROM #__jptp_events AS e'
            . ' LEFT JOIN #__jptp_trainings AS t ON t.id = e.training_id'
            . ' LEFT JOIN #__jptp_sites AS s ON s.id = e.site_id'
            . ' LEFT JOIN #__jptp_event_types AS ety ON ety.id = e.event_type_id'
            . $where
            . $orderby
            ;
            return $this->_query;
	}
        
        function getQuery(){
            return $this->buildSearch();
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

		$filter_order	  = $mainframe->getUserStateFromRequest( $option.'events.filter_order', 'filter_order', 'title', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'events.filter_order_Dir', 'filter_order_Dir', '', 'word' );

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

            $filter_state   = $mainframe->getUserStateFromRequest( $option.'events.filter_state', 'filter_state', '', 'word' );
            $filter         = $mainframe->getUserStateFromRequest( $option.'events.filter', 'filter', '', 'int' );
            $search         = $mainframe->getUserStateFromRequest( $option.'events.search', 'search', '', 'string' );
            $search         = $this->_db->getEscaped( trim(JString::strtolower( $search ) ) );

            $where = array();


            if ($filter_state) {
                switch($filter_state){
                    case 'P':
                        $where[] = ' WHERE e.published = 1';
                        break;
                    case 'U':
                        $where[] = ' WHERE e.published = 0';
                        break;
                }
            }
                
            if ($search){
                switch($filter){
                    case 1:
                        $where[] = ' WHERE LOWER(title) LIKE \'%'.$search.'%\' ';
                        break;
                    case 2:
                        $where[] = ' HAVING LOWER(trainers) LIKE \'%'.$search.'%\' ';
                        break;
		}
            }
    
            $where 	= ( count( $where ) ? implode( ' AND ', $where ) : '' );

            return $where;
	}
}
