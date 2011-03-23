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
?>
<tr>
        <th width="5">
                <?php echo JText::_('COM_RWCARDS_RWCARDS_HEADING_ID'); ?>
        </th>
        <th width="20">
        <?php if ($this->canDo->get('core.edit')){?>
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        <?php }  ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_SENTCARD_HEADING_RECEIVER'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_SENTCARD_HEADING_SENDER'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_SENTCARD_HEADING_IMAGE'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_SENTCARD_HEADING_MESSAGE'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_SENTCARD_HEADING_WRITTEN_ON'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_SENTCARD_HEADING_READ_ON'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_SENTCARD_HEADING_CARD_SENT'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_RWCARDS_SENTCARD_HEADING_CARD_READ'); ?>
        </th>
</tr>
