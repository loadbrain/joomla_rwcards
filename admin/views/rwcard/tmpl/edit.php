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
<fieldset class="adminform"><legend><?php echo JText::_( 'COM_RWCARDS_RWCARDS_DETAILS' ); ?></legend>
<ul class="adminformlist">
<?php foreach($this->form->getFieldset('details') as $field): ?>
	<li><?php echo $field->label;echo $field->input;?></li>
	<?php
	if($field->type == 'ImageList'){
		echo "<br/><li><img id='rwcardChosenImage' /><br/></li>";
	}
	?>
	<?php endforeach; ?>
</ul>

</div>

<!--
<div class="width-40 fltrt"><?php echo JHtml::_('sliders.start', 'helloworld-slider'); ?>
<?php foreach ($params as $name => $fieldset): ?> <?php echo JHtml::_('sliders.panel', JText::_($fieldset->label), $name.'-params');?>
<?php if (isset($fieldset->description) && trim($fieldset->description)): ?>
<p class="tip"><?php echo $this->escape(JText::_($fieldset->description));?></p>
<?php endif;?>
<fieldset class="panelform">
<ul class="adminformlist">
<?php foreach ($this->form->getFieldset($name) as $field) : ?>
	<li><?php echo $field->label; ?><?php echo $field->input; ?></li>
	<?php endforeach; ?>
</ul>
</fieldset>
<?php endforeach; ?> <?php echo JHtml::_('sliders.end'); ?></div>


<div>
 --><input type="hidden" name="task" value="rwcards.edit" /> <?php echo JHtml::_('form.token'); ?>
</div>
</form>
