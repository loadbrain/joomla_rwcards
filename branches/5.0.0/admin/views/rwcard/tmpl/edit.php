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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//$params = $this->form->getFieldsets('params');

?>
<form action="<?php echo JRoute::_('index.php?option=com_rwcards&layout=edit&id='.(int) $this->item->id); ?>"method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="span10 form-horizontal">
		<div class="tab-content">
<?php foreach($this->form->getFieldset('details') as $field): ?>
			<div class="control-group">
				<div class="control-label">
						<?php echo $field->label ?>
					</div>
					<div class="controls">
						<?php echo $field->input; ?>
					</div>
				</div>
<?php endforeach; ?>				
		</div>
	</div>

<input type="hidden" name="task" value="rwcards.edit" /> <?php echo JHtml::_('form.token'); ?>

</form>
