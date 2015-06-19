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

// import the Joomla modellist library
jimport('joomla.application.component.modellist');
require_once (JPATH_COMPONENT.DS.'captcha'.DS. 'class.captcha.php');

/**
 * RwcardsList Model
 */
class RwcardsModelRwcardsfilloutcard extends JModelList{

	/**
	 * RWCards data array
	 *
	 * @var array
	 */
	var $_data;
	var $rwcards_id;
	/**
	 * Gets the data
	 * @return array The data to be displayed to the user
	 */

	public function getItems(){
		$db = JFactory::getDBO();

		$rwcards_id = JRequest::getVar('id', 0, 'request', 'int');
		$sessionId = JRequest::getVar('sessionId', '', 'request', 'string');


		$rwcards_id = $db->escape( $rwcards_id );
		$sessionId = $db->escape( $sessionId );

		// New Card or someone answers
		if ( $sessionId != ""){
			$query = $db->getQuery(true);
			$query->select('#__rwcardsdata.*, #__rwcards.*');
			$query->from('#__rwcardsdata, #__rwcards');
			$query->where('#__rwcards.id = ' . $rwcards_id . ' and #__rwcardsdata.sessionId = "' . $sessionId . '"');
			$db->setQuery( $query );
			//$query = "select #__rwcardsdata.*, #__rwcards.* from #__rwcardsdata, #__rwcards where #__rwcards.id = '" . $rwcards_id . "' and #__rwcardsdata.sessionId = '" . $sessionId ."'";
		}
		else{
			//$query = "select #__rwcards.* from #__rwcards where #__rwcards.id = '" . $rwcards_id . "'";
			$query = $db->getQuery(true);
			$query->select('#__rwcards.*');
			$query->from('#__rwcards');
			$query->where('#__rwcards.id = ' . (int)$rwcards_id);
			$db->setQuery( $query );
		}

		$this->_data = $db->loadObjectList();

		return $this->_data;
	}

	function getCheckCaptcha()
	{
		// check to see if user already completed one, and don't make them do it again.
		if ( array_key_exists( 'captcha_success', $_SESSION ) and $_SESSION['captcha_success'] ) {
			return true;
		}

		$session_code = JRequest::getVar('sessionCode', '', 'request', 'string');
		$captchaCode =  JRequest::getVar('captchaCode', '', 'request', 'string');

		if ( empty( $session_code ) )
		{
			$session_code = md5(round(rand(0,40000)));
		}
		else
		{
			$session_code = $session_code; // FIXME - should this get from the session?
		}

		$my_captcha = new captcha( $session_code, './components/com_rwcards/captcha/__temp__' );

		if ( !$my_captcha->verify( $captchaCode ) )
		{
			//echo "no captcha"; exit;
			return false;
		}
		else
		{
			//echo "yes captcha";
			$_SESSION['captcha_success'] = true;
			return true;
		}

	}
}
?>
