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

/**
 * Rwcards View
 */
class RwcardsViewRwcards extends JViewLegacy
{
    /**
     * Rwcards view display method
     * @return void
     */
    public function display($tpl = null)
    {
        // Get data from the model
        $this->get('CaptchaFolder');
        $items = $this->get('Items');

        $this->state = $this->get('State');
        $pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        if (is_array($items)) {
            $this->get('CreateThumbnails');
        }

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

        // Display the template
        parent::display($tpl);
    }

    /**
     * Setting the toolbar
     */
    protected function addToolBar()
    {
        require_once JPATH_COMPONENT . DS . 'helpers' . DS . 'rwcardhelper.php';

        $user = JFactory::getUser();
        $canDo = RwcardHelper::getActions($this->state->get('filter.id'));

        if ($canDo->get('core.edit')) {
            JToolBarHelper::title(JText::_('COM_RWCARDS_MANAGER_RWCARDS'));
            //JToolBarHelper::deleteList('', 'rwcards.delete');
            JToolBarHelper::editList('rwcard.edit');
            JToolBarHelper::addNew('rwcard.add');
            JToolBarHelper::preferences('com_rwcards');
            if ($canDo->get('core.edit.state')) {
                if ($this->state->get('filter.state') != 2) {
                    JToolbarHelper::publish('rwcards.publish', 'JTOOLBAR_PUBLISH', true);
                    JToolbarHelper::unpublish('rwcards.unpublish', 'JTOOLBAR_UNPUBLISH', true);
                }

                if ($this->state->get('filter.state') != -1) {
                    if ($this->state->get('filter.state') != 2) {
                        JToolbarHelper::archiveList('rwcards.archive');
                    } elseif ($this->state->get('filter.state') == 2) {
                        JToolbarHelper::unarchiveList('rwcards.publish');
                    }
                }
            }
            if ($canDo->get('core.edit.state')) {
                JToolbarHelper::checkin('rwcards.checkin');
            }
            if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolbarHelper::deleteList('', 'rwcards.delete', 'JTOOLBAR_EMPTY_TRASH');
            } elseif ($canDo->get('core.edit.state')) {
                JToolbarHelper::trash('rwcards.trash');
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
        return [
            'ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'autor' => JText::_('COM_RWCARDS_RWCARDS_AUTOR'),
            'category_id' => JText::_('COM_RWCARDS_CAT_HEADING_NAME'),
            'email' => JText::_('COM_RWCARDS_RWCARDS_EMAIL'),
            'id' => JText::_('JGRID_HEADING_ID')
        ];
    }
}
