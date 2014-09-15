<?php
/**
 * @version: $Id: $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

function JptpBuildRoute(&$query)
{
	$segments = array();
	
	if (isset($query['controller'])) {
		$segments[] = $query['controller'];
		unset($query['controller']);
	}

	if (isset($query['month'])) {
            $segments[] = $query['month'];
            unset($query['month']);
            if (isset($query['year'])) {
                $segments[] = $query['year'];
                unset($query['year']);
            }
	} elseif (isset($query['event_id'])) {
		$segments[] = $query['event_id'];
		unset($query['event_id']);
	}

	return $segments;
}

// urls for this component should look like: calendar/<view name>/<month or id>/<year>
// if view = 'registration', 2nd segment is interpreted as year and a check is made for
// one more segment which is set to the month

function JptpParseRoute($segments)
{
	$vars = array();
	
	if (isset($segments[0])) {
		$vars['controller'] = $segments[0];
	}
	
	if (isset($segments[1])) {
            if($vars['controller'] == 'description' || $vars['controller'] == 'registration'){
		$vars['event_id'] = $segments[1];
            } else {
                $vars['month'] = $segments[1];
                 if (isset($segments[2])) {
                    $vars['year'] = $segments[2];
                }               
            }
	}
	
	return $vars;
}
