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
 * RwcardsViewAbout View
 */
class RwcardsViewAbout extends JView{
	/**
	 * Rwcards view display method
	 * @return void
	 */
	function display($tpl = null){
		// Get data from the model

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Set the toolbar
		$this->addToolBar();
		
		//get gdInfo
		$gd = $this->get('GdInfo');
		$this->gd = $gd;

		//Get Version
		$this->version =  $this->get('RwcardsVersion');		
		
		

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
