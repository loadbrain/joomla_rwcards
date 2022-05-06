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

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
jimport( 'joomla.filesystem.folder' );
/**
 * Upload Model
 */
class RwcardsModelUpload extends JModelAdmin{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param       type    The table type to instantiate
	 * @param       string  A prefix for the table class name. Optional.
	 * @param       array   Configuration array for model. Optional.
	 * @return      JTable  A database object
	 * @since       1.6
	 */
	public function getTable($type = 'Rwcard', $prefix = 'RwcardsTable', $config = array()){

		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param       array   $data           Data for the form.
	 * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
	 * @return      mixed   A JForm object on success, false on failure
	 * @since       1.6
	 */
	public function getForm($data = array(), $loadData = true){
		// Get the form.
		$form = $this->loadForm('com_rwcards.upload', 'upload', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)){
			return false;
		}
		return $form;
	}

	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string       Script files
	 */
	public function getScript()
	{
		return 'administrator/components/com_rwcards/models/forms/rwcards.js';
	}
	 
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return      mixed   The data for the form.
	 * @since       1.6
	 */
	protected function loadFormData(){
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_rwcards.edit.rwcards.data', array());
		if (empty($data)){
			$data = $this->getItem();
		}
		return $data;
	}


	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	boolean	True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canDelete($record)
	{
		$user = JFactory::getUser();

		if (!empty($record->catid)) {
			return $user->authorise('core.delete', 'com_banners.category.'.(int) $record->catid);
		}
		else {
			return parent::canDelete($record);
		}
	}
	/**
	* @see RWCardsHelper::makeSafe
	*/
	public function getImages(){
		return JFolder::files(RwcardsHelper::makeSafe(JPATH_ROOT . "/images/rwcards"), $filter= '.', $recurse=true );
		
	}
	
	public function getImageFolder(){
		if(!is_dir(JPath::clean(JPATH_ROOT . "/images/rwcards"))){
			JFolder::create(JPATH_ROOT . "/images/rwcards", 0777 );
		}
	}	
}
?>
