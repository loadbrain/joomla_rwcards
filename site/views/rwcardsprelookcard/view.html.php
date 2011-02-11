<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class RwcardsViewRwcardsprelookcard extends JView{
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

		$app = &JFactory::getApplication();
		$params =& $app->getParams('com_rwcards');
		$this->params = $params;

		parent::display($tpl);
	}
}


?>