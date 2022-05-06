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

