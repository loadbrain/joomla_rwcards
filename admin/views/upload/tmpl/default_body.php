<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
	<tr>
		<td>
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

	<tr class="row<?php echo $i % 2; ?>">

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

