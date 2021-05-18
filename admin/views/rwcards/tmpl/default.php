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

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'ordering';
$assoc = JLanguageAssociations::isEnabled();

if ($saveOrder) {
	$saveOrderingUrl = 'index.php?option=com_rwcards&task=rwcards.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'rwcardsList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
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
<div style="background:#F06534; padding: 5px; border: 1px solid black; color:#fff;font-weight:bold;">
	<?php echo JText::_('COM_RWCARDS_USAGE_HINT'); ?>
</div>
<br />

<form action="<?php echo JRoute::_('index.php?option=com_rwcards&view=rwcards'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)) : ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
		<?php else : ?>
			<div id="j-main-container">
				<div id="filter-bar" class="btn-toolbar">
					<div class="filter-search btn-group pull-left">
						<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_RWCARDS_SEARCH_IN_TITLE'); ?></label>
						<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_RWCARDS_SEARCH_IN_TITLE'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_RWCARDS_SEARCH_IN_TITLE'); ?>" />
					</div>
					<div class="btn-group pull-left">
						<button type="submit" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
						<button type="button" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
					</div>
					<div class="btn-group pull-right hidden-phone">
						<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
						<?php echo $this->pagination->getLimitBox(); ?>
					</div>
					<div class="btn-group pull-right hidden-phone">
						<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
						<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
							<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
							<option value="asc" <?php if ($listDirn == 'asc') {
													echo 'selected="selected"';
												} ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
							<option value="desc" <?php if ($listDirn == 'desc') {
														echo 'selected="selected"';
													} ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
						</select>
					</div>
					<div class="btn-group pull-right">
						<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
						<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
							<option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
							<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
						</select>
					</div>
					<!-- Get Categories -->
					<div class="btn-group pull-right">
						<?php echo $this->categories; ?>
					</div>
					<div class="btn-group pull-left">
						<select name="filter_published" class="inputbox" onchange="this.form.submit()">
							<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED'); ?></option>
							<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', ['archived' => 0, 'trash' => 0]), 'value', 'text', $this->state->get('filter.state'), true); ?>
						</select>
					</div>
				</div>
				<div class="clr"> </div>
				<table class="table table-striped" id="rwcardsList">
					<thead>
						<tr>
							<th width="1%" class="nowrap center hidden-phone">
								<?php echo JHtml::_('searchtools.sort', '', 'ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
							</th>
							<th width="1%">
								<?php echo JHtml::_('grid.checkall'); ?>
							</th>
							<th width="5%" class="nowrap center">
								<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
							</th>
							<th width="15%" class="title">
								<?php echo JHtml::_('searchtools.sort', 'COM_RWCARDS_RWCARDS_AUTOR', 'autor', $listDirn, $listOrder); ?>
							</th>
							<th width="15%" class="nowrap hidden-phone">
								<?php echo JHtml::_('searchtools.sort', 'COM_RWCARDS_RWCARDS_EMAIL', 'email', $listDirn, $listOrder); ?>
							</th>
							<th width="15%" class="nowrap hidden-phone">
								<?php echo JHtml::_('searchtools.sort', 'COM_RWCARDS_RWCARDS_DESCRIPTION', 'description', $listDirn, $listOrder); ?>
							</th>
							<th width="35%" class="nowrap">
								<?php echo JText::_('COM_RWCARDS_RWCARDS_HEADING_IMAGE'); ?>
							</th>
							<th width="10%" class="nowrap hidden-phone">
								<?php echo JHtml::_('searchtools.sort', 'COM_RWCARDS_CAT_HEADING_CATEGORY', 'category_id', $listDirn, $listOrder); ?>
							</th>
							<th width="1%" class="nowrap hidden-phone">
								<?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?>
							</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td colspan="11">
								<?php echo $this->pagination->getListFooter(); ?>
							</td>
						</tr>
					</tfoot>
					<tbody>
						<?php foreach ($this->items as $i => $item) :
							$ordering = ($listOrder == 'ordering');
							$canCreate = $user->authorise('core.create', 'com_rwcards.rwcards.' . $item->id);
							$canEdit = $user->authorise('core.edit', 'ccom_rwcards.rwcards.' . $item->id);
							$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
							$canChange = $user->authorise('core.edit.state', 'com_rwcards.rwcards.' . $item->id) && $canCheckin;
						?>
							<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->catid; ?>">
								<td class="order nowrap center hidden-phone">
									<?php
									$iconClass = '';
									if (!$canChange) {
										$iconClass = ' inactive';
									} elseif (!$saveOrder) {
										$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::_('tooltipText', 'JORDERINGDISABLED');
									}
									?>
									<span class="sortable-handler<?php echo $iconClass ?>">
										<span class="icon-menu" aria-hidden="true"></span>
									</span>
									<?php if ($canChange && $saveOrder) : ?>
										<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order" />
									<?php endif; ?>
								</td>
								<td class="center">
									<?php echo JHtml::_('grid.id', $i, $item->id); ?>
								</td>
								<td class="center">
									<div class="btn-group">
										<?php echo JHtml::_('jgrid.published', $item->published, $i, 'rwcards.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
										<?php // Create dropdown items and render the dropdown list.
										if ($canChange) {
											JHtml::_('actionsdropdown.' . ((int) $item->published === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'rwcards');
											JHtml::_('actionsdropdown.' . ((int) $item->published === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'rwcards');
											echo JHtml::_('actionsdropdown.render', $this->escape($item->name));
										}
										?>
									</div>
								</td>
								<td class="nowrap has-context">
									<div class="pull-left">
										<?php if ($item->checked_out) : ?>
											<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'rwcards.', $canCheckin); ?>
										<?php endif; ?>
										<?php if ($canEdit) { ?>
											<a href="<?php echo JRoute::_('index.php?option=com_rwcards&task=rwcard.edit&id=' . $item->id); ?>"><?php echo JTEXT::_($item->autor); ?></a>
										<?php } else {
											echo $this->escape($item->autor);
										}
										?>
									</div>
								</td>
								<td class="small hidden-phone">
									<?php echo $this->escape($item->email); ?>
								</td>
								<td class="hidden-phone">
									<?php echo $item->description; ?>
								</td>
								<td class="hidden-phone">
									<?php echo "<img src='../images/rwcards/" . JTEXT::_($item->picture) . "' />"; ?>
								</td>
								<td>
									<?php echo JTEXT::_($item->category_kategorien_name); ?>
								</td>
								<td class="hidden-phone">
									<?php echo (int) $item->id; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php // Load the batch processing form if user is allowed
				?>
				<?php
				/*if ($user->authorise('core.create', 'com_newsfeeds')
                && $user->authorise('core.edit', 'com_newsfeeds')
                && $user->authorise('core.edit.state', 'com_newsfeeds')) : ?>
                <?php echo JHtml::_(
                    'bootstrap.renderModal',
                    'collapseModal',
                    [
                        'title' => JText::_('COM_NEWSFEEDS_BATCH_OPTIONS'),
                        'footer' => $this->loadTemplate('batch_footer'),
                    ],
                    $this->loadTemplate('batch_body')
                ); ?>
            <?php endif; */ ?>
			<?php endif; ?>

			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo JHtml::_('form.token'); ?>
			</div>
</form>
