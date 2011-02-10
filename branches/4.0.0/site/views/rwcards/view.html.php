<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class RwcardsViewRwcards extends JView
{
	// Overwriting JView display method
	function display($tpl = null){

		$reWritetoSender = false;
		$task = JRequest::getVar('task', '', 'request', 'string');
		$sessionId = JRequest::getVar('sessionId', '', 'request', 'string');

		$params =& JComponentHelper::getParams( 'com_rwcards' );
		$suffix = '@' . $params->get("thumbnail_suffix", 'rwcards' );
		$this->suffix = $suffix;
		$this->params = $params;

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