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

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_rwcards.rwcards');
$saveOrder	= 'ordering';
$cntx = 'rwcards';
?>
<?php foreach($this->items as $i => $item):
$ordering	= ($listOrder == 'ordering');?>
        <tr class="row<?php echo $i % 2; ?>">

                <td colspan="2" align="center">
                        <?php
                        if ($this->canDo->get('core.edit')){
                        	echo JHtml::_('grid.id', $i, $item->id);
                        }
                        else{
                        echo $item->id;
                        }?>
                </td>
                <td>
                <?php if ($this->canDo->get('core.edit')){ ?>
		                <a href="<?php echo JRoute::_('index.php?option=com_rwcards&task=rwcard.edit&id='.$item->id);?>">
                <?php }
                        echo JTEXT::_($item->autor); ?>
                        </a>
                </td>
                <td>
                        <?php echo JTEXT::_($item->email); ?>
                </td>
                <td>
                        <?php echo JTEXT::_($item->description); ?>
                </td>
                <td>
                        <?php echo "<img src='../images/rwcards/" .  $item->picture . "' />"; ?>
                </td>
                <td align="center">
                        <?php echo  JHtml::_('jgrid.published', $item->published, $i, 'rwcards.'); ?>
                </td>
                <td>
                        <?php echo JTEXT::_($item->category_kategorien_name); ?>
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

