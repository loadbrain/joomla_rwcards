<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_rwcards'); ?>" method="post" name="adminForm">
<table class="adminlist">
	<thead>
		<tr>                    
		<td colspan="2" style="font-weight:bold;"><?php echo JText::_('COM_RWCARDS_ABOUT_HEADING_VERSION'); ?></td>      
	</tr>
	</thead>
	<tbody>
		<tr class="row<?php $i++; echo $i % 2; ?>">
			<td><?php echo $this->version; ?></td>
		</tr>
	</tbody>
</table>
<br/>
<table class="adminlist">
	<thead>
		<tr>                    
		<td colspan="2" style="font-weight:bold;"><?php echo JText::_('COM_RWCARDS_ABOUT_HEADING_INFOS'); ?></td>      
	</tr>
	</thead>
	<tbody>
	<tr>
		<td colspan="2" >
			<a href="http://www.weberr.de/" target="_blank"><?php echo JText::_('COM_RWCARDS_ABOUT_HOMEPAGE'); ?></a><br/>
			<a href="http://www.weberr.de/index.php/forum.html" target="_blank"><?php echo JText::_('COM_RWCARDS_ABOUT_FORUM'); ?></a><br/>
			<a href="http://www.weberr.de/index.php/downloads-mainmenu-27.html" target="_blank"><?php echo JText::_('COM_RWCARDS_ABOUT_NEW_VERSION'); ?></a>
		</td>
	</tr>
	</tbody>
</table>
<br/>				
<table class="adminlist">
	<thead>
		<tr>                    
		<th>
				<?php echo JText::_('COM_RWCARDS_ABOUT_HEADING_GD_KEY'); ?>
		</th>
		<th>
				<?php echo JText::_('COM_RWCARDS_ABOUT_HEADING_GD_VALUE'); ?>
		</th>        
	</tr>
	</thead>
	<tbody>
<?php 
$i = count($this->gd);
if (count($this->gd) > 0){
	$jpg = (isset($this->gd["JPEG Support"])) ? $this->gd["JPEG Support"] : $this->gd["JPG Support"];
?>
        <tr class="row<?php $i++; echo $i % 2; ?>">
                <td>GD Version</td>
                <td><?php echo $this->gd["GD Version"]; ?></td>
        </tr>
		<tr class="row<?php $i++; echo $i % 2; ?>">
                <td>FreeType Support</td>
                <td><?php echo ($this->gd["FreeType Support"]) ? "<span style='color:green'>" . JText::_( 'YES' )  : "<span style='color:red'>" . JText::_( 'NO' ); ?></span></td>                
        </tr>
		<tr class="row<?php $i++; echo $i % 2; ?>">
                <td>T1Lib Support</td>
                <td><?php echo ($this->gd["T1Lib Support"]) ? "<span style='color:green'>" . JText::_( 'YES' )  : "<span style='color:red'>" . JText::_( 'NO' ); ?></span></td>                
        </tr> 
		<tr class="row<?php $i++; echo $i % 2; ?>">
                <td>GIF Read Support</td>
                <td><?php echo ($this->gd["GIF Read Support"]) ? "<span style='color:green'>" . JText::_( 'YES' )  : "<span style='color:red'>" . JText::_( 'NO' ); ?></span></td>                
        </tr>    
		<tr class="row<?php $i++; echo $i % 2; ?>">
                <td>GIF Create Support</td>
                <td><?php echo ($this->gd["GIF Create Support"]) ? "<span style='color:green'>" . JText::_( 'YES' )  : "<span style='color:red'>" . JText::_( 'NO' ); ?></span></td>                
        </tr>  
		<tr class="row<?php $i++; echo $i % 2; ?>">
                <td>JPG Support</td>
                <td><?php echo ($jpg) ? "<span style='color:green'>" . JText::_( 'YES' )  : "<span style='color:red'>" . JText::_( 'NO' ); ?></span></td>                
        </tr> 
		<tr class="row<?php $i++; echo $i % 2; ?>">
                <td>PNG Support</td>
                <td><?php echo ($this->gd["PNG Support"]) ? "<span style='color:green'>" . JText::_( 'YES' )  : "<span style='color:red'>" . JText::_( 'NO' ); ?></span></td>                
        </tr> 
		<tr class="row<?php $i++; echo $i % 2; ?>">
                <td>WBMP Support</td>
                <td><?php echo ($this->gd["WBMP Support"]) ? "<span style='color:green'>" . JText::_( 'YES' )  : "<span style='color:red'>" . JText::_( 'NO' ); ?></span></td>                
        </tr> 
		<tr class="row<?php $i++; echo $i % 2; ?>">
                <td>XBM Support</td>
                <td><?php echo ($this->gd["XBM Support"]) ? "<span style='color:green'>" . JText::_( 'YES' )  : "<span style='color:red'>" . JText::_( 'NO' ); ?></span></td>                
        </tr>                                                        
<?php 
}
else
{
?>	        
		<tr class="row<?php echo $i % 2; ?>">
            <td colspan="2"><?php echo JText::_( 'NO_GD' ); ?></td>
        </tr>
<?php 
}
?>
<tr>
        <td colspan="4">RWCards Version - &copy 2011</td>
</tr>				
				</tbody>
                <tfoot>
					<tr>
						<td colspan="4">RWCards Version - &copy 2011</td>
					</tr>
				</tfoot>
        </table>
        <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
      
</form>
