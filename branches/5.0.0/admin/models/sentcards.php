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

// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * RwcardsList Model
 */
class RwcardsModelSentcards extends JModelList{

	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		// Load the parameters.
		$params = JComponentHelper::getParams('com_rwcards');
		$this->setState('params', $params);
		// List state information.
		parent::populateState('written_on', 'asc');
	}
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery(){
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('*');
		// From the rwcardsconfig table
		$query->from('#__rwcardsdata');
		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0) {
				$query->where('#__rwcardsdata.id = '.(int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('( #__rwcardsdata.nameTo LIKE '.$search.' OR #__rwcardsdata.nameFrom LIKE '.$search.')');
			}
		}
		$query->order('writtenOn');

		//echo nl2br(str_replace('#__', 'jos_', $query->__toString())); //exit;
		return $query;
	}


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Rwcards', $prefix = 'RwcardsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	* Method to delete all records that are older then defined in the configuration tabel
	*
	* @access private
	*/
	function getDeleteOldCards()
	{
		$db = JFactory::getDBO();
		$params = JComponentHelper::getParams('com_rwcards');
		$params->toObject();
		$lifetime = $params->get('lifetime', 7 );
		$lifetimeDate = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-$lifetime, date("Y")));
		$db->setQuery( "select writtenOn FROM #__rwcardsdata" );
		$rows = $db->loadObjectList();
		for ($i=0; $i<count($rows); $i++)
		{
			if ($rows[$i]->writtenOn <= $lifetimeDate)
			{
				//echo "DELETE FROM #__rwcardsdata WHERE writtenOn <= '" . $lifetimeDate . "'<br>";
				$db->query( $db->setQuery("DELETE FROM #__rwcardsdata WHERE writtenOn <= '" . $lifetimeDate . "'" ) );
			}
		}
	}

}
?>
