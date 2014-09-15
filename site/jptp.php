<?php
/**
 *
 * @version: $Id: $
 *
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';

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

$controller->execute( JRequest::getCmd('task') );

// Redirect if set by the controller
$controller->redirect();
?>