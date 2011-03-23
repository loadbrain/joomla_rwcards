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
 * Rwcards View
 */
class RwcardsViewCats extends JView{
	/**
	 * Rwcards view display method
	 * @return void
	 */
	function display($tpl = null){
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
		$this->state		= $this->get('State');

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
	protected function addToolBar(){
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'rwcardhelper.php';

		$user = JFactory::getUser();
		$this->canDo = RwcardHelper::getActions($this->state->get('filter.id'));
		if ($this->canDo->get('core.edit')){
			JToolBarHelper::title(JText::_('COM_RWCARDS_SUBMENU_CATEGORIES'));
			JToolBarHelper::deleteListX('', 'cats.delete');
			JToolBarHelper::editListX('cat.edit');
			JToolBarHelper::addNewX('cat.add');
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
