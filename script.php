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

 
 jimport( 'joomla.filesystem.folder' );

/**
 * Script file of RWCards component
 */
class com_rwcardsInstallerScript
{
        /**
         * method to install the component
         *
         * @return void
         */
        function install($parent){
			if(!is_dir(JPath::clean(JPATH_ROOT . "/images/rwcards"))){
				JFolder::create(JPATH_ROOT . "/images/rwcards", 0777 );
				echo '<p>' . JText::_('COM_RWCARDS_INSTALL_IMAGE_DIRECTORY_TEXT') . '</p>';
			}
			if(!is_dir(JPath::clean(JPATH_ROOT . "/components/com_rwcards/captcha"))){
				JFolder::create(JPATH_ROOT . "/components/com_rwcards/captcha", 0777 );
				echo '<p>' . JText::_('COM_RWCARDS_INSTALL_CAPTCHA_DIRECTORY_TEXT') . '</p>';
			}
			if(!is_dir(JPath::clean(JPATH_ROOT . "/components/com_rwcards/captcha/__temp__"))){
				JFolder::create(JPATH_ROOT . "/components/com_rwcards/captcha/__temp__", 0777 );
				echo '<p>' . JText::_('COM_RWCARDS_INSTALL_CAPTCHA_TEMP_DIRECTORY_TEXT') . '</p>';
			}	
			// $parent is the class calling this method
			echo '<p>' . JText::_('COM_RWCARDS_INSTALL_TEXT') . '</p>';
			$parent->getParent()->setRedirectURL('index.php?option=com_rwcards');
        }
 
        /**
         * method to uninstall the component
         *
         * @return void
         */
        function uninstall($parent) {
			if(is_dir(JPath::clean(JPATH_ROOT . "/images/rwcards"))){
				JFolder::delete(JPATH_ROOT . "/images/rwcards", 0777 );
				echo '<p>' . JText::_('COM_RWCARDS_UNINSTALL_IMAGE_DIRECTORY_TEXT') . '</p>';
			}

			if(is_dir(JPath::clean(JPATH_ROOT . "/components/com_rwcards/captcha/__temp__"))){
				JFolder::delete(JPATH_ROOT . "/components/com_rwcards/captcha/__temp__", 0777 );
				echo '<p>' . JText::_('COM_RWCARDS_UNINSTALL_CAPTCHA_TEMP_DIRECTORY_TEXT') . '</p>';
			}
			
			if(is_dir(JPath::clean(JPATH_ROOT . "/components/com_rwcards/captcha"))){
				JFolder::delete(JPATH_ROOT . "/components/com_rwcards/captcha", 0777 );
				echo '<p>' . JText::_('COM_RWCARDS_UNINSTALL_CAPTCHA_DIRECTORY_TEXT') . '</p>';
			}
	
			// $parent is the class calling this method
            echo '<p>' . JText::_('COM_RWCARDS_UNINSTALL_TEXT') . '</p>';
        }
 
        /**
         * method to update the component
         *
         * @return void
         */
        function update($parent) 
        {
                // $parent is the class calling this method
                echo '<p>' . JText::_('COM_RWCARDS_UPDATE_TEXT') . '</p>';
        }
 
        /**
         * method to run before an install/update/uninstall method
         *
         * @return void
         */
        function preflight($type, $parent) 
        {
                // $parent is the class calling this method
                // $type is the type of change (install, update or discover_install)
                echo '<p>' . JText::_('COM_RWCARDS_PREFLIGHT_' . $type . '_TEXT') . '</p>';
        }
 
        /**
         * method to run after an install/update/uninstall method
         *
         * @return void
         */
        function postflight($type, $parent) 
        {
                // $parent is the class calling this method
                // $type is the type of change (install, update or discover_install)
                echo '<p>' . JText::_('COM_RWCARDS_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
        }
}
