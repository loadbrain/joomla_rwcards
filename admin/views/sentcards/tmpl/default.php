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
defined('_JEXEC') or die('Restricted access');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'ordering';

if ($saveOrder) {
	$saveOrderingUrl = 'index.php?option=com_rwcards&task=sentcards.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
	Joomla.orderTable = function() {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_rwcards&amp;view=sentcards'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)) : ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
		<?php else : ?>
			<div id="j-main-container">
			<?php endif; ?>
			<div id="filter-bar" class="btn-toolbar">
				<div class="filter-search btn-group pull-left">
					<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_RWCARDS_SEARCH_IN_TITLE'); ?></label>
					<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_RWCARDS_SEARCH_IN_TITLE'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_RWCARDS_SEARCH_IN_TITLE'); ?>" />
				</div>
				<div class="btn-group pull-left">
					<button type="submit" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
					<button type="button" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
				</div>

				<div class="btn-group pull-right hidden-phone">
					<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
					<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
						<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
						<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
						<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
					</select>
				</div>
				<div class="btn-group pull-right">
					<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
					<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
						<option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
						<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
					</select>
				</div>
			</div>

			<div class="clr"> </div>
			<table class="table table-striped" id="articleList">
				<thead>
					<tr>
						<!-- <th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
						</th> -->
						<th width="1%" class="hidden-phone">
							<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_RWCARDS_SENTCARD_HEADING_RECEIVER', 'nameTo', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_RWCARDS_SENTCARD_HEADING_SENDER', 'nameFrom', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_RWCARDS_RWCARDS_HEADING_IMAGE', 'picture', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_RWCARDS_SENTCARD_HEADING_MESSAGE', 'message', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_RWCARDS_SENTCARD_HEADING_WRITTEN_ON', 'writtenOn ', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_RWCARDS_SENTCARD_HEADING_READ_ON', 'readOn ', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_RWCARDS_SENTCARD_HEADING_CARD_SENT', 'cardSent ', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_RWCARDS_SENTCARD_HEADING_CARD_READ', 'cardRead ', $listDirn, $listOrder); ?>
						</th>
						<th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="10"><?php echo $this->pagination->getListFooter(); ?></td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($this->items as $i => $item) :
						$ordering	= ($listOrder == 'ordering');
						$canCreate  = $user->authorise('core.create',     'com_rwcards.sentcards.' . $item->id);
						$canEdit    = $user->authorise('core.edit',       'com_rwcards.sentcards.' . $item->id);
						$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
						$canChange  = $user->authorise('core.edit.state', 'com_rwcards.sentcards.' . $item->id) && $canCheckin;

					?>
						<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->id ?>">
							<!-- <td class="order nowrap center hidden-phone">
								<?php if ($canChange) :
									$disableClassName = '';
									$disabledLabel	  = '';
									if (!$saveOrder) :
										$disabledLabel    = JText::_('JORDERINGDISABLED');
										$disableClassName = 'inactive tip-top';
									endif; ?>
									<span class="sortable-handler hasTooltip <?php echo $disableClassName ?>" title="<?php echo $disabledLabel ?>">
										<i class="icon-menu"></i>
									</span>
									<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
								<?php else : ?>
									<span class="sortable-handler inactive">
										<i class="icon-menu"></i>
									</span>
								<?php endif; ?>
							</td> -->
							<td class="center hidden-phone">
								<?php echo JHtml::_('grid.id', $i, $item->id); ?>
							</td>
							<td>
								<?php echo JTEXT::_($item->nameTo); ?> (<?php echo JTEXT::_($item->emailTo); ?>)
							</td>
							<td>
								<?php echo JTEXT::_($item->nameFrom); ?> (<?php echo JTEXT::_($item->emailFrom); ?>)
							</td>
							<td>
								<?php echo "<img src='../images/rwcards/" .  JTEXT::_($item->picture) . "' />"; ?>
							</td>
							<td>
								<?php echo JTEXT::_($item->message); ?>
							</td>
							<td class="center hidden-phone">
								<?php echo JTEXT::_($item->writtenOn); ?>
							</td>
							<td class="center hidden-phone">
								<?php echo JTEXT::_($item->readOn); ?>
							</td>
							<td class="center hidden-phone">
								<?php echo ($item->cardSent) ? "<img src='./components/com_rwcards/images/ok.png' />" : "<img src='./components/com_rwcards/images/no.png' />"; ?>
							</td>
							<td class="center hidden-phone">
								<?php echo ($item->cardRead) ? "<img src='./components/com_rwcards/images/ok.png' />" : "<img src='./components/com_rwcards/images/no.png' />"; ?>
							</td>
							<td class="center hidden-phone">
								<?php echo JTEXT::_($item->id); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div>
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="boxchecked" value="0" />
				<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
				<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
</form>
