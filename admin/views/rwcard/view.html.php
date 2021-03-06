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
class RwcardsViewRwcard extends JViewLegacy
{
    /**
     * View form
     *
     * @var         form
     */
    protected $form = null;
    protected $state = null;
    protected $item = null;
    protected $tmpl;
    protected $cardsCat = null;

    /**
     * display method of Hello view
     * @return void
     */
    public function display($tpl = null)
    {
        // get the Data
        $form = $this->get('Form');

        $item = $this->get('Item');
        $script = $this->get('Script');
        $this->state = $this->get('State');
        // $this->cardsCat = $this->get('', $item->category_id);

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        // Assign the Data
        $this->form = $form;
        $this->item = $item;
        $this->script = $script;
        // Set the toolbar
        $this->addToolBar();
        // Set the submenu
        RwcardsHelper::addSubmenu('cards');
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
        require_once JPATH_COMPONENT . DS . 'helpers' . DS . 'rwcardhelper.php';

        JRequest::setVar('hidemainmenu', true);
        $user = JFactory::getUser();
        $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        $canDo = RwcardHelper::getActions($this->state->get('filter.id'), $this->item->id);
        $isNew = ($this->item->id == 0);
        JToolbarHelper::title($isNew ? JText::_('COM_RWCARD_MANAGER_RWCARD_NEW') : JText::_('COM_RWCARD_RWCARD_EDITING'));
        // If not checked out, can save the item.
        if (!$checkedOut && $canDo->get('core.edit')) {
            JToolBarHelper::apply('rwcard.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('rwcard.save', 'JTOOLBAR_SAVE');
            JToolBarHelper::addNew('rwcard.save2new', 'JTOOLBAR_SAVE_AND_NEW');
        }

        if (empty($this->item->id)) {
            JToolBarHelper::cancel('rwcard.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('rwcard.cancel', 'JTOOLBAR_CLOSE');
        }
    }

    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument()
    {
        $isNew = ($this->item->id < 1);
        $document = JFactory::getDocument();
        $document->setTitle($isNew ? JText::_('COM_RWCARD_MANAGER_RWCARD_NEW') : JText::_('COM_RWCARD_RWCARD_EDITING'));
        $document->addScript(JURI::root() . $this->script);
        $document->addScript(JURI::root() . '/administrator/components/com_rwcards/views/rwcard/submitbutton.js');
        JText::script('COM_RWCARDS_RWCARDS_ERROR_UNACCEPTABLE');
    }
}
