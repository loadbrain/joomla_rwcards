<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//$params = $this->form->getFieldsets('params');

?>
<form
	action="<?php echo JRoute::_('index.php?option=com_rwcards&layout=edit&id='.(int) $this->item->id); ?>"
	method="post" name="adminForm" id="rwcards-form" class="form-validate">
<div class="width-60 fltlft">
<fieldset class="adminform"><legend><?php echo JText::_( 'COM_RWCARDS_CATEGORY_DETAILS' ); ?></legend>
<ul class="adminformlist">
<?php foreach($this->form->getFieldset('details') as $field): ?>
	<li><?php echo $field->label;echo $field->input;?></li>
	<?php endforeach; ?>
</ul>

</div>

<input type="hidden" name="task" value="cats.edit" /> <?php echo JHtml::_('form.token'); ?>
</div>
</form>
