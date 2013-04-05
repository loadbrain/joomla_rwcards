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

jimport( 'joomla.application.component.view');


class RWCardsViewRwcardssendcard extends JView
{

	function display($tpl = null)
	{
		$task =  JRequest::getVar('task', '', 'request', 'string');

		$app = JFactory::getApplication();
		$params = $app->getParams('com_rwcards');
		$this->params = $params;

		switch($task)
		{
			case "viewCard":
				$this->viewCard( $tpl );
				break;

			default:
				$data = $this->get( 'SaveSenderData' );
				$this->rwcards = $data;
				$Itemid = JRequest::getVar('Itemid', 0, 'request', 'int');
				$this->Itemid = $Itemid;
				$task = JRequest::getVar('task', 0, 'request', 'int');
				$this->task = $task;

				$data = $this->get( 'Data' );
				$this->rwcards = $data;

				$viewCardOnly = false;
				$this->viewCardOnly = $viewCardOnly;

				$viewing = false;
				$this->viewing = $viewing;

				parent::display($tpl);
			break;
		}
	}

	function viewCard( $tpl )
	{
		global $mainframe;

		$Itemid = JRequest::getVar('Itemid', 0, 'request', 'int');
		$this->Itemid = $Itemid;
        $viewCardOnly = JRequest::getVar('read', '', 'request', 'string');
		$this->viewCardOnly = $viewCardOnly;
		$data = $this->get( 'ViewCardsData' );
		$this->rwcards = $data;

		// if there's no data, we can't view it.
		$hasData = ( is_array( $data ) and count( $data ) and array_key_exists( '0', $data ) );
		$this->hasData = $hasData;

		$viewing = true;
		$this->viewing = $viewing;

		parent::display($tpl);
	}
}
?>
