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
                JSubMenuHelper::addEntry(JText::_('COM_RWCARDS_SUBMENU_SENT_CARDS'), 'index.php?option=com_rwcards&view=sentcards&extension=com_rwcards', $submenu == 'sentcard');
                JSubMenuHelper::addEntry(JText::_('COM_RWCARDS_SUBMENU_ABOUT'), 'index.php?option=com_rwcards&view=about&extension=com_rwcards', $submenu == 'about');
                // set some global property
                $document = JFactory::getDocument();
                $document->addStyleDeclaration('.icon-48-rwcards {background-image: url(../media/com_rwcards/images/rwcards.png);}');
                        if ($submenu == 'cards')
                {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_CARDS'));
                }
                        if ($submenu == 'categories')
                {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_CATEGORIES'));
                }
                        if ($submenu == 'upload')
                {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_UPLOAD'));
                }
                                if ($submenu == 'sentcard')
                {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_SENT_CARDS'));
                }
                                if ($submenu == 'about')
                {
                        $document->setTitle(JText::_('COM_RWCARDS_SUBMENU_ABOUT'));
                }
        }
}
?>