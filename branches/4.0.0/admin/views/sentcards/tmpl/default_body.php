<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $item->id; ?>
                </td>
                <td>
                        <?php
                        if ($this->canDo->get('core.edit')){
                        	echo JHtml::_('grid.id', $i, $item->id);
                        }?>
                </td>
                <td>
                        <?php echo JTEXT::_($item->nameTo); ?> < <?php  echo JTEXT::_($item->emailTo); ?>
                </td>
                <td>
                        <?php echo JTEXT::_($item->nameFrom); ?> <<?php echo JTEXT::_($item->emailFrom); ?>>
                </td>
                <td>
                        <?php echo JTEXT::_($item->picture); ?>
                </td>
                <td>
                        <?php echo JTEXT::_($item->message); ?>
                </td>
                <td>
                        <?php echo JTEXT::_($item->writtenOn); ?>
                </td>
                <td>
                        <?php echo JTEXT::_($item->readOn); ?>
                </td>
                <td>
                        <?php echo ($item->cardSent ) ? "<img src='./components/com_rwcards/images/ok.png' />" : "<img src='./components/com_rwcards/images/no.png' />"; ?>
                </td>
                <td>
                        <?php echo ($item->cardRead) ? "<img src='./components/com_rwcards/images/ok.png' />" : "<img src='./components/com_rwcards/images/no.png' />"; ?>
                </td>
        </tr>
<?php endforeach; ?>

