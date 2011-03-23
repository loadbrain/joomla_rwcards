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

