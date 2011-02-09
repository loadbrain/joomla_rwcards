<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * RwcardsList Model
 */
class RwcardsModelRwcards extends JModelList{

	protected function populateState()
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$accessId = $app->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', null, 'int');
		$this->setState('filter.access', $accessId);

		$state = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $state);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_rwcards');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('uc.name', 'asc');
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
		$query->select('#__rwcards.* , #__rwcards_category.category_kategorien_name');
		// From the rwcardsconfig table
		$query->from('#__rwcards, #__rwcards_category');
		$query->where('#__rwcards.category_id = #__rwcards_category.id');
		// Filter by published state.
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('#__rwcards.published = '.(int) $published);
		}
		else if ($published === '') {
			$query->where('(#__rwcards.published IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0) {
				$query->where('#__rwcards.id = '.(int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('( #__rwcards.autor LIKE '.$search.' OR #__rwcards.email LIKE '.$search.')');
			}
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		if ($orderCol != 'ordering') {
			$orderCol = 'ordering';
		}
		$query->order($db->getEscaped($orderCol.' '.$orderDirn));
		//echo nl2br(str_replace('#__', 'jos_', $query->__toString()));
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

		public function getCaptchaFolder(){
		if(!is_dir(JPath::clean(JPATH_ROOT . "/components/com_rwcards/captcha"))){
			JFolder::create(JPATH_ROOT . "/components/com_rwcards/captcha", 0777 );
		}
		if(!is_dir(JPath::clean(JPATH_ROOT . "//components/com_rwcards/captcha/__temp__"))){
			JFolder::create(JPATH_ROOT . "/components/com_rwcards/captcha/__temp__", 0777 );
		}		
		
	}
	
}
?>
