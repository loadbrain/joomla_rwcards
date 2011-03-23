<?php
/*------------------------------------------------------------------------
# com_rwcards4 - RWCards for Joomla 1.6
# ------------------------------------------------------------------------
# author Ralf Weber, LoadBrain
# copyright (C) 2011 www.weberr.de. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.weberr.de
# Technical Support: Forum - http://www.weberr.de/forum.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class RwcardsViewRwcards extends JView
{
	// Overwriting JView display method
	function display($tpl = null){
		$app = JFactory::getApplication();
		$reWritetoSender = false;
		$task = JRequest::getVar('task', '', 'request', 'string');
		$sessionId = JRequest::getVar('sessionId', '', 'request', 'string');

		$params =& JComponentHelper::getParams( 'com_rwcards' );
		$suffix = '@' . $params->get("thumbnail_suffix", 'rwcards' );
		$this->suffix = $suffix;
		$this->params = $params;

		$menu = $app->getMenu();
		$active = $menu->getActive();
		$this->active = $active;

		// Assign data to the view
		$data = $this->get( 'Items' );
		$this->rwcards = $data;
		$categoryData = $this->get( 'CategoryData' );
		$this->categoryData = $categoryData;
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Display the view
		parent::display($tpl);

	}
}


?>