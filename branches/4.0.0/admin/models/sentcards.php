<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * RwcardsList Model
 */
class RwcardsModelSentcards extends JModelList{
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
		$query->order('writtenOn');
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
		$db =& JFactory::getDBO();
		$params = JComponentHelper::getParams('com_rwcards');
		$params->toObject();
		$lifetime = $params->get('lifetime', 1 );

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
