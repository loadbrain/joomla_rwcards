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

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_rwcards.cats');
$saveOrder	= 'ordering';
?>
<tr>
        <th width="5">
                <?php echo JText::_('COM_RWCARDS_RWCARDS_HEADING_ID'); ?>
        </th>
        <th width="20">
        <?php if ($this->canDo->get('core.edit')){?>
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        <?php }?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_CAT_HEADING_NAME'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_CAT_HEADING_DESCRIPTION'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_CAT_HEADING_PUBLISHED'); ?>
        </th>
        <th>
            <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'ordering', $listDirn, $listOrder);
		if ($canOrder && $saveOrder) {
			echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'cats.saveorder');
		} ?>
        </th>
</tr>
