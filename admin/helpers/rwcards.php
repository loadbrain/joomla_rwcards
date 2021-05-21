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

/**
 * Rwcards component helper.
 */
abstract class RwcardsHelper
{
        /**
         * Configure the Linkbar.
         */
        public static function addSubmenu($submenu)
        {
                JSubMenuHelper::addEntry(JText::_('COM_RWCARDS_SUBMENU_CARDS'), 'index.php?option=com_rwcards', $submenu == 'cards');
                JSubMenuHelper::addEntry(JText::_('COM_RWCARDS_SUBMENU_CATEGORIES'), 'index.php?option=com_rwcards&view=cats&extension=com_rwcards', $submenu == 'categories');
                JSubMenuHelper::addEntry(JText::_('COM_RWCARDS_SUBMENU_UPLOAD'), 'index.php?option=com_rwcards&view=upload&extension=com_rwcards', $submenu == 'upload');
                JSubMenuHelper::addEntry(JText::_('COM_RWCARDS_SUBMENU_SENT_CARDS'), 'index.php?option=com_rwcards&view=sentcards&extension=com_rwcards', $submenu == 'sentcards');
                JSubMenuHelper::addEntry(JText::_('COM_RWCARDS_SUBMENU_ABOUT'), 'index.php?option=com_rwcards&view=about&extension=com_rwcards', $submenu == 'about');
                // set some global property
                $document = JFactory::getDocument();
                $document->addStyleDeclaration('.icon-48-rwcards {background-image: url(../media/com_rwcards/images/rwcards.png);}');
                if ($submenu == 'cards') {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_CARDS'));
                }
                if ($submenu == 'categories') {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_CATEGORIES'));
                }
                if ($submenu == 'upload') {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_UPLOAD'));
                }
                if ($submenu == 'sentcard') {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_SENT_CARDS'));
                }
                if ($submenu == 'about') {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_ABOUT'));
                }
        }

        /**
         * Overriding JFolder::makeSafe so the dot is not removed from path like /var/www/xxx.net/html...
         */
        public static function makeSafe($path)
        {
                $regex = array('#[^A-Za-z0-9:_.\\\/-]#');
                return preg_replace($regex, '', $path);
        }
}
