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
jimport( 'joomla.filesystem.file' );

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

	public function getImages(){
	if(!is_dir(JPath::clean(JPATH_ROOT . "/images/rwcards"))){
		$this->getImageFolder();
	}
		return JFolder::files(JFolder::makeSafe(JPATH_ROOT . "/images/rwcards"), $filter= '.', $recurse=true );

	}

	public function getImageFolder(){
		if(!is_dir(JPath::clean(JPATH_ROOT . "/images/rwcards"))){
			JFolder::create(JPATH_ROOT . "/images/rwcards", 0777 );
		}
	}

	/**
	 * Create the thumbnails
	 */
	function getCreateThumbnails(){

		$params =& JComponentHelper::getParams( 'com_rwcards' );
		$suffix = '@' . $params->get("thumbnail_suffix", 'rwcards' );
		$breite = 160;
		$hoehe = 120;
		$sizemin = array($breite, $hoehe);

		$images = $this->getImages();
		if($images){
		foreach ($images as $file){
			$image = $file;
			$fileExtension = strtolower( substr($image, strrpos($image, ".")) );
			$name = strtolower( substr($image, 0, -4) ) . $suffix . $fileExtension;
			if (JFile::exists(JPATH_ROOT . "/images/rwcards/" . $name)){
				JFile::delete(JPATH_ROOT . "/images/rwcards/" . $name);
			}
		}
		}

		$images = $this->getImages();
		if(!$images){
			$this->getImageFolder();
		}
		if($images){
		foreach ($images as $file){
			$image = $file;
			$fileExtension = strtolower( substr($image, strrpos($image, ".")) );
			$name = strtolower( substr($image, 0, -4) ) . $suffix . $fileExtension;

			$size = GetImageSize (JPATH_ROOT . "/images/rwcards/" . $file);

			if (!JFile::exists($name)){


				// zugross & quer
				if ($size[0] > $breite && $size[1] > $hoehe  && $size[0] >= $size[1])
				{
					if ($size[0] == $size[1])
					{
						$sizemin[0] = $breite;
						$sizemin[1] = $breite;
					}
					else
					{
						$sizemin[0] = $breite;
						$sizemin[1] = $hoehe;
					}
				}

				// zugross & hochkant
				else if ($size[0] > $breite && $size[1] > $hoehe && $size[1] > $size[0])
				{
					$sizemin[0] = $hoehe;
					$sizemin[1] = $breite;
				}
				// breite zu gross:
				else if ($size[0] > $breite )
				{
					$sizemin[0] = $breite;
					$sizemin[1] = $size[1];
				}
				// hoehe zu gross:
				else if ($size[1] > $hoehe )
				{
					$sizemin[0] = $size[0];
					$sizemin[1] = $hoehe;
				}
				// bild ok:
				else
				{
					$sizemin[0] = $sizemin[0];
					$sizemin[1] = $sizemin[1];
				}

				if (eregi( "\.gif", $file ))
				{
					$im = ImageCreateFromGif(JPATH_ROOT . "/images/rwcards/" . $file);
				}
				if (eregi( "\.png", $file )){
					$im = ImageCreateFromPNG(JPATH_ROOT . "/images/rwcards/" . $file);
				}
				if (eregi( "\.jpg", $file ))
				{
					$im = @imagecreatefromjpeg(JPATH_ROOT . "/images/rwcards/" . $file);
				}
				$small = imagecreatetruecolor($sizemin[0], $sizemin[1] );

				ImageCopyResampled($small, $im, 0, 0, 0, 0, $sizemin[0], $sizemin[1], $size[0], $size[1]);
				ImageDestroy($im);

				if (eregi( "\.gif", $file ))
				{
					imagegif($small, JPATH_ROOT . "/images/rwcards/" . $name, "100");
				}
				if (eregi( "\.png", $file ))
				{
					imagepng($small, JPATH_ROOT . "/images/rwcards/" . $name);
				}
				else
				{
					if (!ImageJPEG($small, JPATH_ROOT . "/images/rwcards/" . $name, "100"))
					{
						echo "<font color=red><b>";
						echo _RWCARD_THUMBNAIL_ERROR;
						echo "</b></font><br>\n";
					}
				}
			}

		}
		}
	}

}
?>
