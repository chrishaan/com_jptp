<?php
/**
 * Joomla! 1.5 component conferences
 *
 * @version $Id: conferences.php 7 2010-01-19 16:19:37Z jalbright $
 * @package Joomla
 * @subpackage conferences
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Define constants for all pages
*/
//define( 'COM_CONFERENCES_DIR', 'images'.DS.'conferences'.DS );
//define( 'COM_CONFERENCES_BASE', JPATH_ROOT.DS.COM_CONFERENCES_DIR );
//define( 'COM_CONFERENCES_BASEURL', JURI::root().str_replace( DS, '/', COM_CONFERENCES_DIR ));
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';

// Require the base controller
//require_once JPATH_COMPONENT.DS.'helpers'.DS.'helper.php';

// Require specific controller if requested
$controller = JRequest::getWord('controller', '');
if (!empty($controller)) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    }
}

//Create the controller
$classname  = 'JptpController'.$controller;
$controller = new $classname( );

// Perform the Request task
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();
?>