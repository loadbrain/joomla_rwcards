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
class RwcardsModelRwcardssendcard extends JModelList{

	/**
	 * RWCards data array
	 *
	 * @var array
	 */
	var $_data;
	/**
	 * Gets the data
	 * @return array The data to be displayed to the user
	 */

	/**
	 * Saves the senders data
	 */
	function getSaveSenderData()
	{
		jimport('joomla.mail.mail');
		$db = JFactory::getDBO();
		$app = JFactory::getApplication();
		$params = $app->getParams('com_rwcards');

		$attachment = $params->get( "attachment", false );

		$Itemid = JRequest::getCmd('Itemid');

		$sess = $_SESSION['rwcardsSession'];

		if ( $sess != "" )
		{
			// All receivers are stored in tbe database
			for ($i = 0; $i < count( $sess['rwCardsFormEmailTo'] ); $i++)
			{
				$query = "INSERT INTO #__rwcardsdata SET picture= '" . $sess['picture']
				. "', nameTo = '" . $sess['rwCardsFormNameTo'][$i]
				. "', nameFrom = '" . $sess['rwCardsFormNameFrom'] 
				. "', emailTo = '" . $sess['rwCardsFormEmailTo'][$i]
				. "', emailFrom = '" . $sess['rwCardsFormEmailFrom'] 
				. "', message = '" . $sess['rwCardsFormMessage'] 
				. "', sessionId = '" . $sess['sessionCode']
				. "' , writtenOn = '" . date("Y-m-d")
				. "' , cardSent = '0'";
				
				$db->setQuery( $query );
				if (!$result = $db->query())
				{
					echo  $db->stderr();
				}

				// Get the ID generated from the previous INSERT operation
				$lastId[$i] = $db->insertid();

				// Send an email to the receiver(s)
				/**
				* Did not work for everyone... LoadBrain, 23.07.2009
				* $mail =& JMail::getInstance();
				*/
				$mail = JFactory::getMailer();

				if (!$sess['rwCardsFormEmailTo'][$i]
				|| !$sess['rwCardsFormNameTo'][$i]
				|| (JMailHelper::isEmailAddress($sess['rwCardsFormEmailTo'][$i]) == false))
				{
					$this->setError(JText::_('COM_RWCARDS_MAIL_PROBLEM'));
					$this->display();
					return false;
				}

				$MailFrom 	= $sess['rwCardsFormEmailFrom'];
				$FromName 	= $sess['rwCardsFormNameFrom'];

				// Prepare email body

				$linkToRWCards = JURI::getInstance()->toString(array("scheme","host"))
				. str_replace( '&amp;', '&', JRoute::_( 'index.php?option=com_rwcards&view=rwcardssendcard&Itemid=' . $Itemid
				. "&sessionId=" . $sess['sessionCode'] . "&id=" . $lastId[$i] . "&task=viewCard&read=1&sendmail=1" ) );
				$linkToViewOnly = JURI::getInstance()->toString(array("scheme","host"))
				. str_replace( '&amp;', '&', JRoute::_( 'index.php?option=com_rwcards&view=rwcardssendcard&Itemid=' . $Itemid
				. "&sessionId=" . $sess['sessionCode'] . "&id=" . $lastId[$i] . "&task=viewCard&sendmail=0" ) );

				$subject = JText::_('COM_RWCARDS_SUBJECT') . " " . $FromName;

				// send link to card
				if ($attachment)
				{
					$message = JText::_('COM_RWCARDS_GREETING') . " "
					. $sess['rwCardsFormNameTo'][$i] . "\n\n"
					. $FromName . " " . JText::_('COM_RWCARDS_MSG_ATTACHEMENT_1') . "\n"
					. JText::_('COM_RWCARDS_MSG_ATTACHEMENT_2') . "\n"
					. JText::_('COM_RWCARDS_MSG_ATTACHEMENT_3') . "\n\n"
					//. nl2br( $sess['rwCardsFormMessage'] )
					. nl2br( $sess['rwCardsFormMessage'] )
					. "\n\n" . JText::_('COM_RWCARDS_MSG_SEPARATOR') . "\n\n"
					.  $params->get('msg_copyright', JText::_('COM_RWCARDS_MSG_COPYRIGHT'));
					$mail->addAttachment("./images/rwcards/" . $sess['picture']);
				}
				else
				{
					$message = JText::_('COM_RWCARDS_GREETING') . " "
					. $sess['rwCardsFormNameTo'][$i] . "\n\n"
					. $FromName . " "
					. JText::_('COM_RWCARDS_MSG_PART_1') . "\n\n"
					. JText::_('COM_RWCARDS_MSG_PART_2') . "\n\n"
					. $linkToRWCards . "\n\n"
					. JText::_('COM_RWCARDS_MSG_SEPARATOR') . "\n"
					. $params->get('msg_copyright', JText::_('COM_RWCARDS_MSG_COPYRIGHT')) . "\n\n";
				}

				$mail->addRecipient( $sess['rwCardsFormEmailTo'][$i] );
				$mail->setSender( array( $MailFrom, $FromName ) );
				$mail->setSubject( $subject );
				$mail->setBody( $message );
				$sent = $mail->Send();

				// Update database and set cardSent to 1 so it does not get send another time
				$db->setQuery("UPDATE #__rwcardsdata SET cardSent = '1' where id = '" . $lastId[$i]
				. "' and sessionId = '" . $sess['sessionCode'] . "'");
				$db->query();

				/**
				 *  email only to one sender no concatenating of all if several, 01.09.2008 RW
				 */
				$mail = null;
			}
		}
		else
		{
			$app->redirect( str_replace('&amp;','&', JRoute::_( 'index.php?option=com_rwcards&Itemid=' . $Itemid )));
		}
	}

	function getViewCardsData()
	{
		jimport('joomla.mail.mail');

		$app = JFactory::getApplication();
		$params = $app->getParams('com_rwcards');

		$sessionId = JRequest::getVar('sessionId', '', 'request', 'string');
		$read = JRequest::getVar('read', '', 'request', 'string');
		$sendmail = JRequest::getVar('sendmail', '', 'request', 'string');
		$id = JRequest::getVar('id', '', 'request', 'string');

		$db = JFactory::getDBO();


		$query = "SELECT * FROM #__rwcardsdata where sessionId = '" . $sessionId . "' and id = '" . $id . "'";
		$this->_data = $this->_getList( $query );

		if ( is_array( $this->_data ) and count ( $this->_data ) )
		{
			if ( $this->_data[0]->cardRead == '0')
			{
				// Send an email to the receiver(s)
				/**
				* Did not work for everyone... LoadBrain, 23.07.2009
				* $mail =& JMail::getInstance();
				*/
				$mail =& JFactory::getMailer();
				$subject =  JText::_('COM_RWCARDS_CARD_READ_SUBJECT');
				$message = JText::_('COM_RWCARDS_GREETING') . " "
				. $this->_data[0]->nameFrom . "\n"
				. $this->_data[0]->nameTo . " "
				. JText::_('COM_RWCARDS_CARD_READ_MSG_1') . " "
				. date("d.m.Y") . " "
				. JText::_('COM_RWCARDS_CARD_READ_MSG_2') . "\n\n"
				. JText::_('COM_RWCARDS_CARD_READ_MSG_3') . "\n\n"
				. JText::_('COM_RWCARDS_MSG_SEPARATOR') . "\n"

				. $params->get('msg_copyright', JText::_('COM_RWCARDS_MSG_COPYRIGHT')) . "\n\n";

				$mail->addRecipient( $this->_data[0]->emailFrom );
				$mail->setSender( array( $this->_data[0]->emailTo, $this->_data[0]->nameTo ) );
				$mail->setSubject( $this->_data[0]->nameFrom.': '.$subject );
				$mail->setBody( $message );
				$sent = $mail->Send();
				// update table so email is only sent once
				$query = "update #__rwcardsdata set cardRead = '1', readOn = '" . date("Y-m-d")
				. "' where sessionId = '" . $sessionId
				. "' and id = '" . $id . "'";
				$db->setQuery( $query );
				$db->query();
			}
		}

		$this->pagewidth = $params->get( "pagewidth", 400 );
		$this->pageheight = $params->get( "pageheight", 300 );

		$this->_data['pagewidth'] = $this->pagewidth;
		$this->_data['pageheight'] = $this->pageheight;
		return $this->_data;
	}
}
?>
