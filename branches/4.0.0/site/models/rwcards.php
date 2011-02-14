<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport( 'joomla.application.component.helper' );

/**
 * RwcardsList Model
 */
class RwcardsModelRwcards extends JModel{

	/**
	 * RWCards data array
	 *
	 * @var array
	 */
	var $_data;
	var $_categoryData;

	/**
	 * redefine the function an add some properties to make the styling more easy
	 *
	 * @return mixed An array of data items on success, false on failure.
	 */
	public function getItems(){

		$this->_items = array();
		if(!count($this->_items)){
			$app = JFactory::getApplication('site');
			$params =& JComponentHelper::getParams( 'com_rwcards' );
			//var_dump($params);
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			// Select all published categories
			$query->select('#__rwcards_category.*');
			// From the rwcardsconfig table
			$query->from('#__rwcards_category');
			$query->where('#__rwcards_category.published = "1"');
			$query->order('ordering');
			$db->setQuery($query);
			$this->_categoryData  = $db->loadObjectList();

			if ($error = $db->getErrorMsg()) {
				throw new JException($error);
			}

			if (empty($this->_categoryData)) {
				throw new JException(JText::_('ERROR'), 404);
			}

			// Get all Cards for each category to build a slideshow with them
			$i = 0;
			foreach ($this->_categoryData as $val){
				$query = $db->getQuery(true);
				// Select all published categories
				$query->select('#__rwcards.*, #__rwcards_category.id, #__rwcards_category.category_kategorien_name, #__rwcards_category.category_description');
				$query->from(' #__rwcards');
				$query->leftJoin('#__rwcards_category on #__rwcards_category.id = ' . (int)$val->id);
				$query->where('(#__rwcards.category_id = ' . (int)$val->id . ' and #__rwcards.published  = "1")');
				$query->order('#__rwcards.ordering ASC');
				$db->setQuery($query);
				$this->_data[$i++] = $db->loadObjectList();
			}

			// now generate info for placing over the thumbnails, based on the parameters.
			$params =& JComponentHelper::getParams( 'com_rwcards' );

			$menu = $app->getMenu();
			$active = $menu->getActive();
			$this->active = $active;

			$a_prefix	= $this->active->query["titleauthor_prefix"];
			$d_prefix	= $this->active->query["description_prefix"];
			$type		= $this->active->query['thumbnail_data'];

			foreach ($this->_data as $key1=>$value1 ) {
				foreach ($value1 as $key2=>$value2 ) {

					switch( $type ) {
						case 'a-d':
							$this->_data[$key1][$key2]->thumb_title = $a_prefix . $value2->autor;
							$this->_data[$key1][$key2]->thumb_desc = $d_prefix . nl2br( $value2->description );
							break;
						case 'd-a':
							$this->_data[$key1][$key2]->thumb_title = $d_prefix . nl2br( $value2->description );
							$this->_data[$key1][$key2]->thumb_desc = $a_prefix . $value2->autor;
							break;
						case 'a':
							$this->_data[$key1][$key2]->thumb_title = '';
							$this->_data[$key1][$key2]->thumb_desc = $a_prefix . $value2->autor;
							break;
						case 'd':
							$this->_data[$key1][$key2]->thumb_title = '';
							$this->_data[$key1][$key2]->thumb_desc = $d_prefix . nl2br( $value2->description );
							break;
						case 'none':
						default:
							$this->_data[$key1][$key2]->thumb_title = '';
							$this->_data[$key1][$key2]->thumb_desc = '';
					}
				}
			}

			return $this->_data;
		}
	}

	function getCategoryData() {
		return $this->_categoryData;
	}
}
?>
