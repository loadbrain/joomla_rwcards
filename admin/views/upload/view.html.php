<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * RwcardsViewUpload View
 */
class RwcardsViewUpload extends JView{
	/**
	 * Rwcards view display method
	 * @return void
	 */
	function display($tpl = null){

		// Get data from the model
		$this->get('ImageFolder');
		$this->form		= $this->get('Form');
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
		$this->images = $this->get('Images');
		$params =& JComponentHelper::getParams( 'com_rwcards' );
   		$this->params = $params;

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
		// Set the toolbar
		$this->addToolBar();


		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();

	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_RWCARDS_MANAGER_RWCARDS'));
		JToolBarHelper::cancel('rwcard.cancel', 'JTOOLBAR_CANCEL');
	}

        /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument()
        {
                $document = JFactory::getDocument();
                $document->setTitle(JText::_('COM_RWCARDS_ADMINISTRATION'));
        }

}
?>
