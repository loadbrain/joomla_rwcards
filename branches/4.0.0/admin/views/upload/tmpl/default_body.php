<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
	<tr>
		<td>
			<div id="image">
					<?php foreach($this->form->getFieldset('image') as $field): ?>
						<?php if (!$field->hidden): ?>
							<?php echo $field->label; ?>
						<?php endif; ?>
						<?php echo $field->input; ?>
					<?php endforeach; ?>
				</div>
		</td>
	</tr>				
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td><h3><?php echo JText::_('COM_RWCARDS_UPLOAD_EXISTING_IMAGES'); ?></h3></td>
	</tr>
	
	<tr class="row<?php echo $i % 2; ?>">
	<td>
<?php 
foreach($this->images as $i => $item){ 
?>
        
                <img src="../images/rwcards/<?php echo $item; ?>" style="border:1px solid black; margin:10px;" />
       <?php
       	if($i % 3 == 2){
       		echo "</td></tr>";
       		?>
       		<tr class="row<?php echo $i % 2; ?>"><td>
       <?php 
       	}
       ?>
<?php 
$i++;
}
?>                                                     

