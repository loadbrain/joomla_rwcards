<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * Cat Table class
 */
class RwcardsTableCat extends JTable{
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db){
                parent::__construct('#__rwcards_category', 'id', $db);
        }

}

