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
                JSubMenuHelper::addEntry('<br><br><a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons Lizenzvertrag" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a><br /><a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons - This license allows reusers to distribute, remix, adapt, and build upon the material in any medium or format, so long as attribution is given to the creator. The license allows for commercial use. If you remix, adapt, or build upon the material, you must license the modified material under identical terms</a>.<br><br>
                <strong>CC BY-SA includes the following elements:</strong>
                <br><br>
<strong>BY</strong> <img loading="lazy" class="alignnone " src="https://mirrors.creativecommons.org/presskit/icons/by.xlarge.png" width="30" height="30"><br>– Credit must be given to the creator
<br><br>
<strong>SA</strong> <img loading="lazy" class="alignnone " src="https://mirrors.creativecommons.org/presskit/icons/sa.xlarge.png" width="31" height="31"><br> – Adaptations must be shared under the same terms');

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
