<?php
/*------------------------------------------------------------------------
# com_rwcards - RWCards for Joomla 3.x
# ------------------------------------------------------------------------
# author Ralf Weber, LoadBrain
# copyright (C) 2011 www.weberr.de. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.weberr.de
# Technical Support: Forum - http://www.weberr.de/forum.html
 -------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

//print_r($this->rwcards);

	// start build additional Stylesheet by A. Dalebout
	$style = '';
	if ( count($this->rwcards) > 0) {
	    for ($i=0; $i < count($this->rwcards); $i++) {
	    	$thumb_box_width = ($this->active->query["thumb_box_width"] != "" ) ? $this->active->query["thumb_box_width"] : '260px';
	    	$thumb_box_height = ($this->active->query["thumb_box_height"] != "") ? $this->active->query["thumb_box_height"] : '220px';
	        $style .="
#myGallery_rwcards_".$i."
{
	width: " . $thumb_box_width . " !important;
	height: " . $thumb_box_height . " !important;
	border: 1px solid #000;
}

#myGallery_rwcards_".$i." img.thumbnail
{
	display: none;
}
#rwcardsTable
{
	width:100%;
	border:0px;
	padding:1em;
	border:1px solid black;
	margin:2px;
}";
	    }
	  }
	// finish build additional Stylesheet by A. Dalebout
	$document = JFactory::getDocument();
	$document->addStyleDeclaration($style); // send additional Stylesheet to joomlal by A.Dalebout
	$document->addScript(JURI::base() . 'components/com_rwcards/js/mootools-more-1.4.0.1.js');
	$document->addScript(JURI::base() . 'components/com_rwcards/js/rwcards.gallery.js');
	$document->addStyleSheet( JURI::base() . 'components/com_rwcards/css/rwcards.slideshow.css', 'text/css', null, array( 'id' => 'StyleSheet' ) );
?>

	<h1><?php echo ($this->active->query["cats_page_heading"] != "" ? $this->active->query["cats_page_heading"] : JText::_('COM_RWCARDS_VIEW_CARDS')); ?></h1>
<?php
	if ( count($this->rwcards[0]) > 0) {
	    for ($i=0; $i < count($this->rwcards); $i++) {
	?>
<script type="text/javascript">
	function startGallery_rwcards_<?php echo $i; ?>() {
		var myGallery = new gallery($('myGallery_rwcards_<?php echo $i; ?>'), {
			timed: true,
			showArrows: false,
			showCarousel: false
		});
	}
	window.addEvent('domready', startGallery_rwcards_<?php echo $i; ?>);
</script>

<table id="rwcardsTable<?php echo $i;?>" border="0">
<tr>
<td width="150px">
	<div id="rwcards_gallery">
		<div id="myGallery_rwcards_<?php echo $i; ?>">

<?php
			// loop through cards in section
			foreach ($this->rwcards[$i] as $key => $val) {
?>
		<div class="imageElement">
			<h3><?php echo $val->thumb_title; ?></h3>
			<p><?php echo $val->thumb_desc; ?></p>
			<a href="<?php echo JRoute::_('index.php?option=com_rwcards&view=rwcard&amp;Itemid=' . JRequest::getCmd( "Itemid" )
				. '&amp;category_id=' . $val->category_id
				. '&amp;reWritetoSender=' . @$this->reWritetoSender
				. '&amp;sessionId=' . @$this->sessionId);
			?>" title="<?php echo htmlentities( $val->category_kategorien_name, ENT_QUOTES, 'UTF-8' ); ?>" class="open"></a>
			<img src="<?php echo JURI::base(); ?>images/rwcards/<?php echo strtolower(substr($val->picture, 0, -4) )
				. $this->suffix . strtolower( substr($val->picture, strrpos($val->picture, ".")) );
			?>" class="full" alt="<?php echo nl2br( htmlentities( $val->category_kategorien_name, ENT_QUOTES, 'UTF-8' )); ?>" />
		</div>

<?php
			}
?>
		</div>
	</div>
</td>

<td valign="top" style="width:200px; padding: 0px 5px;">
	<span style="font-weight: bold; text-decoration:underline;"><?php //  print_r( $this->rwcards[$i]); // sb ?>
		<a href="<?php echo JRoute::_('index.php?option=com_rwcards&view=rwcard&amp;Itemid=' . JRequest::getCmd( "Itemid" )
			. '&amp;category_id=' . $this->categoryData[$i]->id
			. '&amp;reWritetoSender=' . @$this->reWritetoSender
			. '&amp;sessionId=' . @$this->sessionId );
		?>" class="open"><?php echo htmlentities( $this->categoryData[$i]->category_kategorien_name, ENT_QUOTES, 'UTF-8' ); ?></a>
	</span>
	<br />
	<br />

	<?php echo htmlentities( $this->categoryData[$i]->category_description, ENT_QUOTES, 'UTF-8' ); ?>

	<br /><br /><br /><br />

	<a href="<?php echo JRoute::_('index.php?option=com_rwcards&view=rwcard&amp;Itemid=' . JRequest::getCmd( "Itemid" )
		. '&amp;category_id=' . $this->categoryData[$i]->id
		. '&amp;reWritetoSender=' . @$this->reWritetoSender
		. '&amp;sessionId=' . @$this->sessionId );
	?>" class="open"><?php echo JText::_('COM_RWCARDS_SEE_ALL_CARDS'); ?></a>
</td>
</tr>
</table>
<?php
		}
	}
	else {
?>
<table id="rwcardsTable">
<tr>
	<td valign="top">
		<span style="font-weight: bold; color:red; font-size:14px;">
			<?php echo JText::_('RWCARDS_NO_CATEGORY_PUBLISHE_OR_CREATED'); ?><br />
			<?php echo JText::_('RWCARDS_NO_PICTURES_PUBLISHE_OR_CREATED');?>
		</span>
	</td>
</tr>
</table>

<?php
	}
?>
