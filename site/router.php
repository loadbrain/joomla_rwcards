<?php

/* ------------------------------------------------------------------------
  # com_rwcards - RWCards for Joomla 3.x
  # ------------------------------------------------------------------------
  # author Ralf Weber, LoadBrain
  # copyright (C) 2011 www.weberr.de. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.weberr.de
  # Technical Support: Forum - http://www.weberr.de/forum.html
  -------------------------------------------------------------------------
 */

defined('_JEXEC') or die;

function RwcardsBuildRoute(&$query) {
    $segments = array();
    if (isset($query['view'])) {
        $segments[] = $query['view'];
        unset($query['view']);
    }
    if (isset($query['id'])) {
        $segments[] = $query['id'];
        unset($query['id']);
    };
    //category_id
    if (isset($query['category_id'])) {
        $segments[] = $query['category_id'];
        unset($query['category_id']);
    }
    //reWritetoSender
    if (isset($query['reWritetoSender'])) {
        $segments[] = $query['reWritetoSender'];
        unset($query['reWritetoSender']);
    }
    //reWritetoSender
    if (isset($query['sessionId'])) {
        $segments[] = $query['sessionId'];
        unset($query['sessionId']);
    }

    //rwcardsfilloutcard
    if (isset($query['rwcardsfilloutcard'])) {
        $segments[] = $query['rwcardsfilloutcard'];
        unset($query['rwcardsfilloutcard']);
    }
    //rwcardssendcard
    if (isset($query['rwcardssendcard'])) {
        $segments[] = $query['rwcardssendcard'];
        unset($query['rwcardssendcard']);
    }
    #print_r($segments); exit;
    return $segments;
}

function RwcardsParseRoute($segments) {
    print_r($segments);
    $vars = array();
    switch ($segments[0]) {
        case 'rwcard':
            $vars['view'] = 'rwcard';
            //$category_id = explode(':', $segments[1]);
            $vars['category_id'] = (int) $segments[1];
            break;
        case 'category':
            $vars['view'] = 'category';
            $id = explode(':', $segments[1]);
            $vars['id'] = (int) $id[0];
            break;
        case 'rwcardsfilloutcard':
            $vars['view'] = 'rwcardsfilloutcard';
            $id = explode(':', $segments[1]);
            $vars['id'] = (int) $id[0];
            break;
        case 'rwcardsprelookcard':
            $vars['view'] = 'rwcardsprelookcard';
            $id = explode(':', $segments[1]);
            $vars['id'] = (int) $id[0];
            break;
        case 'rwcardssendcard':
            $vars['view'] = 'rwcardssendcard';
            $vars['id'] = (int) $segments[1];
			$vars['sessionId'] = $segments[2];
			$vars['sendmail'] = $segments[3];
			$vars['task'] = $segments[4];

            break;
    }
    return $vars;
}
