<?php
/*------------------------------------------------------------------------
# com_rwcards4 - RWCards for Joomla 3.x
# ------------------------------------------------------------------------
# author Ralf Weber, LoadBrain
# copyright (C) 2011 www.weberr.de. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.weberr.de
# Technical Support: Forum - http://www.weberr.de/forum.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of Rwcards component
 */
class RwcardsController extends JControllerLegacy{
        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false, $urlparams = false){
                // set default view if not set
                JRequest::setVar('view', JRequest::getCmd('view', 'rwcards'));

                // call parent behavior
                parent::display($cachable);

                // Set the submenu
                RwcardsHelper::addSubmenu('messages');

        }
}

