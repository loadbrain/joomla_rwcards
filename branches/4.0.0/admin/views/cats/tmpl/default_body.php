<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_rwcards.cat');
$saveOrder	= 'ordering';
$cntx = 'cat';
?>
<?php foreach($this->items as $i => $item):
$ordering	= ($listOrder == 'ordering');?>
        <tr class="row<?php echo $i % 2; ?>">

                <td colspan="2" align="center">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_rwcards&task=cat.edit&id='.$item->id);?>">
                        <?php echo JTEXT::_($item->category_kategorien_name); ?>
                        </a>
                </td>
                <td>
                        <?php echo JTEXT::_($item->category_description); ?>
                </td>
                <td align="center">
                        <?php echo  JHtml::_('jgrid.published', $item->published, $i, 'cats.'); ?>
                </td>
                <td>
				<?php if ($saveOrder) {
						if ($listDirn == 'asc') {
							echo '<span>'. $this->pagination->orderUpIcon($i, true, $cntx.'.orderup', 'JLIB_HTML_MOVE_UP', $ordering).'</span>';
							echo '<span>'.$this->pagination->orderDownIcon($i, $this->pagination->total, true, $cntx.'.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering).'</span>';
						} else if ($listDirn == 'desc') {
							echo '<span>'. $this->pagination->orderUpIcon($i, true, $cntx.'.orderdown', 'JLIB_HTML_MOVE_UP', $ordering).'</span>';
							echo '<span>'.$this->pagination->orderDownIcon($i, $this->pagination->total, true, $cntx.'.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering).'</span>';
						}
					}
					$disabled = $saveOrder ?  '' : 'disabled="disabled"';
					echo '<input type="text" name="order[]" size="5" value="'.$item->ordering.'" '.$disabled.' class="text-area-order" />';
				 ?>
                </td>
        </tr>
<?php endforeach; ?>

