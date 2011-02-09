<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

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
