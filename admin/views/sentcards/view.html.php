<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');


/**
 * Rwcards View
 */
class RwcardsViewSentcards extends JView{
	/**
	 * Rwcards view display method
	 * @return void
	 */
	function display($tpl = null){

		// Get data from the model
		$items = $this->get('Items');

		$pagination = $this->get('Pagination');
		$this->state = $this->get('State');

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
		$this->get('DeleteOldCards');

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();

	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()	{
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'rwcardhelper.php';

		$user = JFactory::getUser();
		$this->canDo = RwcardHelper::getActions($this->state->get('filter.id'));

		JToolBarHelper::title(JText::_('COM_RWCARDS_MANAGER_RWCARDS'));
			if ($this->canDo->get('core.edit')){
				JToolBarHelper::deleteListX('', 'sentcards.delete');
			}
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
