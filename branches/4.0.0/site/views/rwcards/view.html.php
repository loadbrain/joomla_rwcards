<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Rwcards View
 */
class RwcardsViewRwcards extends JView{

        // Overwriting JView display method
        function display($tpl = null){
                // Assign data to the view
                $this->msg = 'Hello World';
 
                // Display the view
                parent::display($tpl);
        }
}
?>
