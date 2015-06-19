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

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class RwcardsViewRwcardsprelookcard extends JViewLegacy{
	// Overwriting JView display method
	function display($tpl = null){

		$data = $this->get( 'Data' );
		$this->rwcards = $data;
		$categories = $this->get( 'Categories' );
		$captchaError = false;
		$isCaptcha = true;
		$rwCardsError = 0;
		$Itemid = JRequest::getVar('Itemid', 0, 'request', 'int');
		$id = JRequest::getVar('id', 0, 'request', 'int');
		$this->Itemid = $Itemid;
		$this->id = $id;
		$this->categories = $categories;
		$this->captchaError = $captchaError;
		$this->isCaptcha = $isCaptcha;
		$this->rwCardsError = $rwCardsError;

		$app = JFactory::getApplication();
		$params = $app->getParams('com_rwcards');
		$this->params = $params;

		parent::display($tpl);
	}
}


?>