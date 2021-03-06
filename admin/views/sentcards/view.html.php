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
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Rwcards View
 */
class RwcardsViewSentcards extends JViewLegacy
{
	/**
	 * Rwcards view display method
	 * @return void
	 */
	function display($tpl = null)
	{

		$app = JFactory::getApplication('administrator');
		$input = JFactory::getApplication()->input;

		if ($input->getCmd('task') === "getDeleteSentCards") {
			$this->get('DeleteSentCards');
		};
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
		$this->state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;

		// Set the toolbar
		$this->addToolBar();
		$this->get('DeleteOldCards');
		// Set the submenu
		RwcardsHelper::addSubmenu('sentcards');
		// Display the template
		parent::display($tpl);
	}

	/**
	 *
	 */
	public function getDeleteSentCards()
	{
		print_r("getDeleteSentCardsFin");
	}
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		require_once JPATH_COMPONENT . DS . 'helpers' . DS . 'rwcardhelper.php';

		$user = JFactory::getUser();
		$this->canDo = RwcardHelper::getActions($this->state->get('filter.id'));

		JToolBarHelper::title(JText::_('COM_RWCARDS_MANAGER_RWCARDS'));
		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolbarHelper::deleteList('', 'sentcards.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($this->canDo->get('core.edit.state')) {
			// JToolbarHelper::trash('sentcards.trash');
		}
		if ($this->canDo->get('core.edit')) {
			// JToolBarHelper::deleteList('', 'sentcards.delete');
			JToolBarHelper::custom('getDeleteSentCards', 'delete', 'test', 'JTOOLBAR_DELETE', 'werowerwer');
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
			'nameTo' => JText::_('COM_RWCARDS_SENTCARD_HEADING_RECEIVER'),
			'nameFrom' => JText::_('COM_RWCARDS_SENTCARD_HEADING_SENDER'),
			'id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
