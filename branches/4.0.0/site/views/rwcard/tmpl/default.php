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


$suffix = '@' . $this->params->get("thumbnail_suffix", 'rwcards' );

// Load the moo.fx scripts
$document = &JFactory::getDocument();
JHTML::_('behavior.mootools');
if ( $this->params->get('lightbox_type', 0) == 0 ) {
	$document->addScript(JURI::base() . 'components/com_rwcards/js/slimbox.js');
	$document->addStyleSheet( JURI::base() . 'components/com_rwcards/css/slimbox/slimbox.css', 'text/css', null, array( 'id' => 'StyleSheet' ) );
}

$style = "
#card-heading {
	font-weight:bold;
	margin-bottom: 1em;
}
#card-list {
	margin-bottom: 1.5em;
	text-align:center;
}

#category-box {
	font-weight:bold; float:right;
}
.img-thumb {
	border: 1px solid black; margin:5px;
}
.send-this-img {
	float:left; display:inline; width:165px; margin:0 5px 5px 5px; padding-bottom:10px; text-align: center
}
#limit {
	text-align:center;
}
#limit ul.pagination li {
	float: none !important;
	display: inline;
}
";

$document->addStyleDeclaration($style);

?>

<h1><?php echo ($this->active->query["cats_page_heading"] != "" ? $this->active->query["cats_page_heading"] : JText::_('COM_RWCARDS_VIEW_CARDS')); ?></h1>

<div id="category-box">
	<?php echo JText::_('COM_RWCARDS_CHOSEN_CATEGORY') . ": " . $this->categories; ?>
</div>

<?php
if ( count($this->rwcards['rows']) > 0)
{
?>
<div id="card-heading">
	<?php echo JText::_('COM_RWCARDS_CLICK_ON_CARD_TO_PREVIEW'); ?>
</div>

<div id="card-list">
<table border="0">
<tr>
<?php
$k="";
for ($i=0, $n=count( $this->rwcards['rows'] ); $i < $n; $i++)
{
?>
<td>
	<a href="<?php echo JURI::base(); ?>images/rwcards/<?php echo $this->rwcards['rows'][$i]->picture;?>"
		rel="<?php echo $this->params->get('lightbox_type', 0) ? $this->params->get('lightbox_rel') : "lightbox[atomium]"; ?>"
		title="<?php echo strip_tags($this->rwcards['rows'][$i]->description); ?>"><img
		src="<?php echo JURI::base(); ?>images/rwcards/<?php
			echo strtolower(substr($this->rwcards['rows'][$i]->picture, 0, -4) )
			. $suffix
			. strtolower( substr( $this->rwcards['rows'][$i]->picture, strrpos($this->rwcards['rows'][$i]->picture, ".")) );
			 ?>"
		alt="<?php echo strip_tags($this->rwcards['rows'][$i]->description); ?>"
		class="img-thumb" /></a>
	<br />
	<span class="send-this-img">
		<a href="<?php echo JRoute::_('index.php?option=com_rwcards&amp;view=rwcardsfilloutcard&amp;Itemid=' . JRequest::getCmd('Itemid')
			. '&amp;id=' . intval($this->rwcards['rows'][$i]->id)
			. '&amp;category_id=' . JRequest::getInt('category_id')
			. '&amp;reWritetoSender=' . $this->reWritetoSender
			. '&amp;sessionId=' . $this->sessionId
		); ?>"><?php echo JText::_('COM_RWCARDS_SEND_THIS_IMAGE'); ?></a>
	</span>
</td>
<?php
	$k++;
	if($k % $this->rwcards['cardsPerLine'] == 0) {
		echo "</tr><tr>";
	}
}
?>
</tr>
</table>
</div>

<div id="limit"><?php echo $this->rwcards['_pageNav']->getPagesLinks(); ?></div>

<div class="rwcardsClr"></div>
<?php
}
else
{
	JError::raiseWarning('ERROR_CODE', JText::_('COM_COM_RWCARDS_NO_CATEGORY_PUBLISHED_OR_CREATED') . " " . JText::_('COM_RWCARDS_NO_PICTURES_PUBLISHED_OR_CREATED'));
}
?>

<script type="text/javascript">//<![CDATA[

$('category_id').addEvent('change', function()
{
	var chosenCategory = $('category_id').get('value');

	var all_cats = {
	<?php $done = false;
	foreach ( $this->categoryIds as $key=>$categoryId ) {
		if ( $done ) echo ",\n";
		$done = true;
//		echo "'$categoryId': '" . str_replace('&amp;', '&',
//			JRoute::_( 'index.php?option=com_rwcard&view=rwcard&Itemid=' . JRequest::getCmd("Itemid")
//			. '&category_id=' . $categoryId . '&reWritetoSender=' . @$this->reWritetoSender . '&sessionId=' . @$this->sessionId ) ) . "'";

		echo "'$categoryId': '" . str_replace('&amp;', '&',
		JRoute::_('index.php?option=com_rwcards&amp;view=rwcard&amp;Itemid=' . JRequest::getCmd('Itemid')
			. '&amp;category_id=' . $categoryId
			. '&amp;reWritetoSender=' . @$this->reWritetoSender
			. '&amp;sessionId=' . $this->sessionId) ) . "'";
	}
	echo '};';
	?>
	document.location.href = all_cats[ chosenCategory ];
});
//]]></script>