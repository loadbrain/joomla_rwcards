<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
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
