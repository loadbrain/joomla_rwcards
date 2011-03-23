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
class RwcardsViewRwcard extends JView{

	// Overwriting JView display method
	function display($tpl = null) {
		$app = &JFactory::getApplication();
		$params =& $app->getParams('com_rwcards');
		$this->params = $params ;

		$category_id = JRequest::getVar('category_id', 0, 'request', 'int');

		if ( $category_id == 0 ) $category_id = $params->get( 'category_id', 0 );

		// if it's still zero, look for the the 1st valid one...

		if ( $category_id == 0 ) {
			$category_id = $this->get( 'FirstValidCategory' );
		}

		$this->category_id = $category_id;
		$data = $this->get( 'Items' );
		$this->rwcards = $data;
		$categories = $this->get( 'Categories' );
		$this->categories = $categories;

		$categoryIds = $this->get( 'CategoryIds' );
		$this->categoryIds = $categoryIds;

		// If clicked on rewrite to sender, do not delete session data!
		$reWritetoSender = JRequest::getVar('reWritetoSender', '', 'request', 'string');
		$this->reWritetoSender = $reWritetoSender;
		$sessionId = JRequest::getVar('sessionId', '', 'request', 'string');
		$this->sessionId = $sessionId;
		$this->limitstart = JRequest::getVar('limitstart', 0, 'request', 'int');

		$menu = $app->getMenu();
		$active = $menu->getActive();
		$this->active = $active;
		parent::display($tpl);
	}
}
?>