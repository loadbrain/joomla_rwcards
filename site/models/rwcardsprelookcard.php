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
defined( '_JEXEC' ) or die( 'Restricted access' ); 

// import the Joomla modellist library
jimport('joomla.application.component.modellist');
require_once (JPATH_COMPONENT.DS.'captcha'.DS. 'class.captcha.php');

/**
 * Rwcardsprelookcard Model
 */
class RwcardsModelRwcardsprelookcard extends JModelList{

	/**
	 * RWCards data array
	 *
	 * @var array
	 */
	var $_data;
	var $_categoryData;
	var $category_id;
	/**
	 * Gets the data
	 * @return array The data to be displayed to the user
	 */
	function getItems(){
		$db = JFactory::getDBO();
		$app = JFactory::getApplication();
		$params = $app->getParams('com_rwcards');

		$category_id = JRequest::getVar('category_id', 0, 'request', 'int');
		//var_dump($category_id);
		// All published pictures from this category;
		$query = "select #__rwcards.* from #__rwcards where #__rwcards.category_id = '" . $category_id . "' and #__rwcards.published = '1' order by ordering";
		$this->_data = $this->_getList( $query );

		$this->pagewidth = $params->get( "pagewidth", 400 );
		$this->pageheight = $params->get( "pageheight", 300 );

		$this->_data['pagewidth'] = $this->pagewidth;
		$this->_data['pageheight'] = $this->pageheight;


		return $this->_data;
	}

	function getCategories()
	{
		$db = JFactory::getDBO();

		// First all categories;
		$category_id = JRequest::getVar('category_id', 0, 'request', 'int');
		$categories[] = JHTML::_('select.option',  $category_id, '- '. JText::_( 'ECARD_CHOOSE_CATEGORY' ) .' -' );

		$query = "SELECT id AS value, category_kategorien_name AS text FROM #__rwcards_category order by ordering, category_kategorien_name asc";
		$this->_db->setQuery( $query );
		$categories = array_merge( $categories, $this->_db->loadObjectList() );
		$lists['categories'] = JHTML::_('select.genericlist', $categories, "category_id", "class=\"inputbox\" size=\"1\" onchange=\"changeCategory();\"", 'value', 'text',  $category_id);

		return $lists['categories'];
	}
}
?>
