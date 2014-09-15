<?php
/**
 * @version $Id:  $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class JptpModelTrainings extends JModel
{
    var $_data = null;
    var $_pagination = null;
    var $_total = null;
    var $_search = null;
    var $_query = null;

    function getData(){
        $pagination =& $this->getPagination();

        if (empty($this->_data)) {
            $query = $this->buildSearch();
            $this->_data = $this->_getList($query, $pagination->limitstart, $pagination->limit);
        }

        return $this->_data;
    }

    function getPagination(){
        if (!$this->_pagination){
            jimport('joomla.html.pagination');
            $mainframe = JFactory::getApplication();
            $this->_pagination = new JPagination($this->getTotal(), JRequest::getVar('limitstart', 0), JRequest::getVar('limit', $mainframe->getCfg('list_limit')));
        }

        return $this->_pagination;
    }

    function getTotal(){
        if (!$this->_total){
            $query = $this->buildSearch();
            $this->_total = $this->_getListCount($query);
        }

        return $this->_total;
    }

    function buildSearch(){
        //Get the WHERE and ORDER BY clauses for the query
        $where	= $this->_buildContentWhere();
        $orderby	= $this->_buildContentOrderBy();

        $this->_query = 'SELECT t.id, t.title, CONCAT(SUBSTRING(t.description,1,50), "...") as description, t.ceu_credits, t.published, a.name as audience,'
        . ' (SELECT GROUP_CONCAT(lo.name SEPARATOR "<br />") FROM #__jptp_training_approvals AS ta LEFT JOIN #__jptp_licensing_orgs AS lo on ta.licensing_org_id = lo.id '
        . ' WHERE ta.training_id = t.id) AS approved_by'
        . ' FROM #__jptp_trainings AS t'
        . ' LEFT JOIN #__jptp_audiences AS a on t.audience_id = a.id'
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
    function _buildContentOrderBy(){
        $mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');

        $filter_order	  = $mainframe->getUserStateFromRequest( $option.'trainings.filter_order', 'filter_order', 'title', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'trainings.filter_order_Dir', 'filter_order_Dir', '', 'word' );

        $orderby = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir;

        return $orderby;
    }

	/**
	 * Build the where clause
	 *
	 * @access private
	 * @return string
	 */
    function _buildContentWhere(){
        $mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');

        $filter_state 	= $mainframe->getUserStateFromRequest( $option.'trainings.filter_state', 'filter_state', '', 'word' );
        $filter         = $mainframe->getUserStateFromRequest( $option.'trainings.filter', 'filter', '', 'int' );
        $search         = $mainframe->getUserStateFromRequest( $option.'trainings.search', 'search', '', 'string' );
        $search         = $this->_db->getEscaped( trim(JString::strtolower( $search ) ) );

        $where = array();

        if ($filter_state) {
            switch($filter_state){
                case 'P':
                    $where[] = ' t.published = 1';
                    break;
                case 'U':
                    $where[] = ' t.published = 0';
                    break;
            }
        }

        if($search){
            switch($filter){
                case 1:
                    $where[] = ' LOWER(t.title) LIKE \'%'.$search.'%\' ';
                    break;
                case 2:
                    $where[] = ' LOWER(t.description) LIKE \'%'.$search.'%\' ';
                    break;
            }
        }

        $where = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

        return $where;
    }
}