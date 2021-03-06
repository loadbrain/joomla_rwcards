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
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
/**
 * RwcardsList Model
 */
class RwcardsModelRwcards extends JModelList
{
    /**
     * Constructor.
     *
     * @param	array	An optional associative array of configuration settings.
     * @see		JController
     * @since	1.6
     */
    public function __construct($config = [])
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = [
                'id', 'id',
                'autor', 'autor',
                'email', 'email',
                'checked_out', 'checked_out',
                'checked_out_time', 'checked_out_time',
                'ordering', 'ordering',
                'published', 'published',
                'category_id', 'category_id'
            ];
        }

        parent::__construct($config);
    }

    protected function populateState($ordering = null, $direction = null)
    {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $accessId = $app->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', null, 'int');
        $this->setState('filter.access', $accessId);

        // Filter by published state.
        $published = $app->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', null, 'int');

        $state = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $state);

        $category_id = $app->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id', '', 'int');
        // $state = $this->setState('filter.category_id', $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id', '', 'cmd'));
        $this->setState('filter.category_id', $category_id);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_rwcards');
        $this->setState('params', $params);

        // List state information.
        // parent::populateState('autor', 'asc');
        parent::populateState($ordering, $direction);

        // If there's a forced language then define that filter for the query where clause
        if (!empty($forcedLanguage)) {
            $this->setState('filter.language', $forcedLanguage);
        }
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
        $query->select('#__rwcards.* , #__rwcards_category.category_kategorien_name');
        // From the rwcardsconfig table
        $query->from('#__rwcards, #__rwcards_category');
        $query->where('#__rwcards.category_id = #__rwcards_category.id');
        // Filter by published state.
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('#__rwcards.published = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(#__rwcards.published IN (0, 1))');
        }

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('#__rwcards.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( #__rwcards_category.category_kategorien_name LIKE ' . $search . ' OR #__rwcards.autor LIKE ' . $search . ' OR #__rwcards.email LIKE ' . $search . ' OR #__rwcards.description LIKE ' . $search . ')');
            }
        }

        // Filter by categories
        $catid = $this->getState('filter.category_id');
        if ($catid) {
            $query->where('#__rwcards.category_id = ' . $db->quote($db->escape($catid)));
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'ordering, category_id');
        $orderDirn = $this->state->get('list.direction', 'asc');

        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
        // echo nl2br(str_replace('#__', 'efidk_', $query->__toString())); //exit;
        return $query;
    }

    /**
     * Create a list of categories to filter from
     */
    public function getCategories()
    {
        // Filtered Category?
        $category_id = (isset($category_id) ? $category_id : 0);
        $chosenCategoryId = JRequest::getVar('filter_category_id', 0, 'request', 'int');
        if ($chosenCategoryId == 0) $chosenCategoryId = 0;
        $db = JFactory::getDBO();
        // First all categories;
        $categories[] = JHTML::_('select.option',  $category_id, '- ' . JText::_('COM_RWCARDS_RWCARDS_CATEGORY') . ' -');
        $query = "SELECT id AS value, category_kategorien_name AS text FROM #__rwcards_category where published > 0 order by ordering, category_kategorien_name asc";
        $this->_db->setQuery($query);
        $categories = array_merge($categories, $this->_catIds());
        $lists['categories'] = JHTML::_('select.genericlist', $categories, "filter.category_id", "class=\"inputbox\" size=\"1\" onchange=\"this.form.submit()\"", 'value', 'text',  $chosenCategoryId);

        return $lists['categories'];
    }

    /**
     * Get the categories from database
     * Used for filling select list
     * @see: getCategories
     */

    public function _catIds()
    {
        $db = JFactory::getDBO();
        $query = "SELECT id AS value, category_kategorien_name AS text FROM #__rwcards_category where published > 0 order by ordering, category_kategorien_name asc";
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
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
    public function getTable($type = 'Rwcards', $prefix = 'RwcardsTable', $config = [])
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
                ->from('#__rwcards');

            $db->setQuery($query);
            $max = $db->loadResult();

            $table->ordering = $max + 1;
        }
    }

    public function getCaptchaFolder()
    {
        if (!is_dir(JPath::clean(JPATH_ROOT . '/components/com_rwcards/captcha'))) {
            JFolder::create(JPATH_ROOT . '/components/com_rwcards/captcha', 0777);
        }
        if (!is_dir(JPath::clean(JPATH_ROOT . '//components/com_rwcards/captcha/__temp__'))) {
            JFolder::create(JPATH_ROOT . '/components/com_rwcards/captcha/__temp__', 0777);
        }
    }

    public function getImages()
    {
        if (!is_dir(JPath::clean(JPATH_ROOT . '/images/rwcards'))) {
            $this->getImageFolder();
        }
        /**
         * @see RWCardsHelper::makeSafe
         */
        return JFolder::files(RwcardsHelper::makeSafe(JPATH_ROOT . '/images/rwcards'), $filter = '.', $recurse = true);
    }

    public function getImageFolder()
    {
        if (!is_dir(JPath::clean(JPATH_ROOT . '/images/rwcards'))) {
            JFolder::create(JPATH_ROOT . '/images/rwcards', 0777);
        }
    }

    /**
     * Create the thumbnails
     */
    public function getCreateThumbnails()
    {
        $params = JComponentHelper::getParams('com_rwcards');
        $suffix = '@' . $params->get('thumbnail_suffix', 'rwcards');
        $breite = $params->get('thumbnail_width', '160'); //default: 160;
        $hoehe =  $params->get('thumbnail_height', '120'); //default: 120;
        $sizemin = [$breite, $hoehe];

        $images = $this->getImages();
        if ($images) {
            foreach ($images as $file) {
                $image = $file;
                $fileExtension = strtolower(substr($image, strrpos($image, '.')));
                $name = strtolower(substr($image, 0, -4)) . $suffix . $fileExtension;
                if (JFile::exists(JPATH_ROOT . '/images/rwcards/' . $name)) {
                    JFile::delete(JPATH_ROOT . '/images/rwcards/' . $name);
                }
            }
        }

        $images = $this->getImages();
        if (!$images) {
            $this->getImageFolder();
        }
        if ($images) {
            foreach ($images as $file) {
                $image = $file;
                $fileExtension = strtolower(substr($image, strrpos($image, '.')));
                $name = strtolower(substr($image, 0, -4)) . $suffix . $fileExtension;

                $size = GetImageSize(JPATH_ROOT . '/images/rwcards/' . $file);

                if (!JFile::exists($name)) {
                    // zugross & quer
                    if ($size[0] > $breite && $size[1] > $hoehe && $size[0] >= $size[1]) {
                        if ($size[0] == $size[1]) {
                            $sizemin[0] = $breite;
                            $sizemin[1] = $breite;
                        } else {
                            $sizemin[0] = $breite;
                            $sizemin[1] = $hoehe;
                        }
                    }

                    // zugross & hochkant
                    elseif ($size[0] > $breite && $size[1] > $hoehe && $size[1] > $size[0]) {
                        $sizemin[0] = $hoehe;
                        $sizemin[1] = $breite;
                    }
                    // breite zu gross:
                    elseif ($size[0] > $breite) {
                        $sizemin[0] = $breite;
                        $sizemin[1] = $size[1];
                    }
                    // hoehe zu gross:
                    elseif ($size[1] > $hoehe) {
                        $sizemin[0] = $size[0];
                        $sizemin[1] = $hoehe;
                    }
                    // bild ok:
                    else {
                        $sizemin[0] = $sizemin[0];
                        $sizemin[1] = $sizemin[1];
                    }

                    if (preg_match("/\.gif/i", $file)) {
                        $im = ImageCreateFromGif(JPATH_ROOT . '/images/rwcards/' . $file);
                    }
                    if (preg_match("/\.png/i", $file)) {
                        $im = ImageCreateFromPNG(JPATH_ROOT . '/images/rwcards/' . $file);
                    }
                    if (preg_match("/\.jpe?g/i", $file)) {
                        $im = @imagecreatefromjpeg(JPATH_ROOT . '/images/rwcards/' . $file);
                    }
                    $small = imagecreatetruecolor($sizemin[0], $sizemin[1]);

                    @ImageCopyResampled($small, $im, 0, 0, 0, 0, $sizemin[0], $sizemin[1], $size[0], $size[1]);
                    @ImageDestroy($im);

                    if (preg_match("/\.gif/i", $file)) {
                        imagegif($small, JPATH_ROOT . '/images/rwcards/' . $name, '100');
                    }
                    if (preg_match("/\.png/i", $file)) {
                        imagepng($small, JPATH_ROOT . '/images/rwcards/' . $name);
                    } else {
                        if (!ImageJPEG($small, JPATH_ROOT . '/images/rwcards/' . $name, '100')) {
                            echo '<font color=red><b>';
                            echo _RWCARD_THUMBNAIL_ERROR;
                            echo "</b></font><br>\n";
                        }
                    }
                }
            }
        }
    }
}
