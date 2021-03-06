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
 * Rwcards View
 */
class RwcardsViewCats extends JViewLegacy{
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

		// Set the submenu
		RwcardsHelper::addSubmenu('categories');
		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar(){
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'rwcardhelper.php';

		$user = JFactory::getUser();
		$canDo = RwcardHelper::getActions($this->state->get('filter.id'));
		if ($canDo->get('core.edit')){
			JToolBarHelper::title(JText::_('COM_RWCARDS_SUBMENU_CATEGORIES'));
			JToolBarHelper::editList('cat.edit');
			JToolBarHelper::addNew('cat.add');
		if ($canDo->get('core.edit.state'))
		{
			if ($this->state->get('filter.state') != 2)
			{
				JToolbarHelper::publish('cats.publish', 'JTOOLBAR_PUBLISH', true);
				JToolbarHelper::unpublish('cats.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			}

			if ($this->state->get('filter.state') != -1)
			{
				if ($this->state->get('filter.state') != 2)
				{
					JToolbarHelper::archiveList('cats.archive');
				}
				elseif ($this->state->get('filter.state') == 2)
				{
					JToolbarHelper::unarchiveList('cats.publish');
				}
			}
		}
		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::checkin('cats.checkin');
		}
		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'cats.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('cats.trash');
		}

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

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'category_kategorien_name' => JText::_('COM_RWCARDS_CAT_HEADING_NAME'),
			'id' => JText::_('JGRID_HEADING_ID')
		);
	}

}
