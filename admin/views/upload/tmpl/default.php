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

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');


?>
	<div class="clr"> </div>
<form action="<?php echo JRoute::_('index.php?option=com_rwcards'); ?>" method="post" name="adminForm">
        <table class="table table-striped" id="articleList">
			<thead>
				<tr>
						<th>
								<?php
								if ($this->canDo->get('core.edit')){
									echo JText::_('COM_RWCARDS_UPLOAD_HEADER');
								}?>
						</th>
				</tr>
			</thead>
            <tfoot>
				<tr><td colspan="4">RWCards &copy 2011</td></tr>
			</tfoot>
            <tbody>
			<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->id?>">
					<td class="order nowrap center hidden-phone">
			<div id="image">
					<?php
					if ($this->canDo->get('core.edit')){
					foreach($this->form->getFieldset('image') as $field): ?>
						<?php if (!$field->hidden): ?>
							<?php echo $field->label; ?>
						<?php endif; ?>
						<?php echo $field->input; ?>
					<?php endforeach;
					}
					?>
				</div>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td><h3><?php echo JText::_('COM_RWCARDS_UPLOAD_EXISTING_IMAGES'); ?></h3></td>
	</tr>

	<tr><td>

<?php
$adminimagesperrow = $this->params->get("adminimagesperrow",3);
$suffix = $this->params->get('suffix', '@rwcards');

echo "<table border='0' cellspacing='5' cellpadding='5' width='100%'><tr>";
foreach($this->images as $i => $item){
	if (!preg_match("/\@rwcards/", $item)){
?>
                	<td><img src="../images/rwcards/<?php echo $item; ?>" style="border:1px solid black; margin:10px;" /></td>
       <?php
       $i++;
       	echo ($i % $adminimagesperrow == 0) ? "</tr><tr class='row" . $i % 2 . "'>" : "";
       ?>
<?php
	}
}
echo "</table>";
?>
					</tbody>
        </table>
        <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
      
</form>
