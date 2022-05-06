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
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * RwcardsList Model
 */
class RwcardsModelSentcards extends JModelList
{

	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'id',
				'nameTo', 'nameTo',
				'nameFrom', 'nameFrom',
				'emailTo', 'emailTo',
				'emailFrom', 'emailFrom',
				'message', 'checked_out',
				'writtenOn', 'writtenOn',
				'readOn', 'readOn',
				'ordering', 'ordering',
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$accessId = $app->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', null, 'int');
		$this->setState('filter.access', $accessId);

		$state = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $state);
		// Load the parameters.
		$params = JComponentHelper::getParams('com_rwcards');
		$this->setState('params', $params);
		// List state information.
		parent::populateState($ordering, $direction);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('*');
		// From the rwcardsconfig table
		$query->from('#__rwcardsdata');
		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('#__rwcardsdata.id = ' . (int) substr($search, 3));
			} else {
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('( #__rwcardsdata.nameTo LIKE ' . $search . ' OR #__rwcardsdata.nameFrom LIKE ' . $search . ' OR #__rwcardsdata.message LIKE ' . $search . ' OR #__rwcardsdata.emailTo LIKE ' . $search . ' OR #__rwcardsdata.emailFrom LIKE ' . $search . ' OR #__rwcardsdata.picture LIKE ' . $search . ' OR #__rwcardsdata.writtenOn LIKE ' . $search . ' OR #__rwcardsdata.readOn LIKE ' . $search . ')');
			}
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'ordering');
		$orderDirn	= $this->state->get('list.direction', 'asc');

		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		// echo nl2br(str_replace('#__', 'jos_', $query->__toString())); //exit;
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
	 * Prepare a helloworld record for saving in the database
	 */
	protected function prepareTable($table)
	{
		// Set ordering to the last item if not set

		if (empty($table->ordering)) {
			$db = $this->getDbo();
			$query = $db->getQuery(true)
				->select('MAX(ordering)')
				->from('#__rwcards_category');

			$db->setQuery($query);
			$max = $db->loadResult();

			$table->ordering = $max + 1;
		}
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
		$lifetime = $params->get('lifetime', 7);
		$lifetimeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $lifetime, date("Y")));
		$db->setQuery("select writtenOn FROM #__rwcardsdata");
		$rows = $db->loadObjectList();
		for ($i = 0; $i < count($rows); $i++) {
			if ($rows[$i]->writtenOn <= $lifetimeDate) {
				//echo "DELETE FROM #__rwcardsdata WHERE writtenOn <= '" . $lifetimeDate . "'<br>";
				$db->query($db->setQuery("DELETE FROM #__rwcardsdata WHERE writtenOn <= '" . $lifetimeDate . "'"));
			}
		}
	}

	/**
	 * Delete cards manually and finallY!
	 */
	public function getDeleteSentCards()
	{
		$toDelete = array();
		$app = JFactory::getApplication('administrator');
		// Load the ids to delete .
		$toDelete = $app->getUserStateFromRequest('cid', 'cid');
		// print_r($toDelete);

		// Database...
		$db = JFactory::getDBO();
		for ($i = 0; $i < count($toDelete); $i++) {
			// echo "DELETE FROM #__rwcardsdata WHERE id = '" . $toDelete[$i] . "'<br>";
			$db->query($db->setQuery("DELETE FROM #__rwcardsdata WHERE id = '" . $toDelete[$i] . "'"));
		}
	}
}
