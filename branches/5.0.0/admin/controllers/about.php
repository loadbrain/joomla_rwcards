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

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * RwcardsControllerAbout Controller
 */
class RwcardsControllerAbout extends JControllerAdmin
{
        /**
         * Proxy for getModel.
         * @since       1.6
         */
        public function getModel($name = 'Rwcard', $prefix = 'RwcardsModel'){
                $model = parent::getModel($name, $prefix, array('ignore_request' => true));
                return $model;
        }

}

?>
