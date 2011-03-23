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
