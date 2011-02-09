<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// require helper file
JLoader::register('RwcardsHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'rwcards.php');

// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by Rwcards
$controller = JController::getInstance('Rwcards');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

