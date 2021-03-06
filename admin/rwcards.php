<?php
/*------------------------------------------------------------------------
# com_rwcards - RWCards for Joomla 3.x
# ------------------------------------------------------------------------
# author Ralf Weber, LoadBrain
# copyright (C) 2011 www.weberr.de. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.weberr.de
# Technical Support: Forum - http://www.weberr.de/forum.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}
// require helper file
JLoader::register('RwcardsHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'rwcards.php');

// import joomla controller library
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('Rwcards'); 

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

