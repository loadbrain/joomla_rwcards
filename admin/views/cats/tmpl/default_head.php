<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
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
