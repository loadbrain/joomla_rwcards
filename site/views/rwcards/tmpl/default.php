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
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.framework', 'core');

$params = JComponentHelper::getParams('com_rwcards');

$thumb_box_width = $params->get('thumb_box_width', '260'); //default: 260;
$thumb_box_height = $params->get('thumb_box_height', '220'); //default: 220

/**start build additional Stylesheet
 * @see: /components/com_rwcards/css/rwcards.rwcards.css
 */
if (count($this->rwcards) > 0) {
	for ($i = 0; $i < count($this->rwcards); $i++) {
		$style .= "
@media only screen and (min-width:450px){
	#myGallery_rwcards_" . $i . " {width: " . $thumb_box_width . "px; height: " . $thumb_box_height . "px;}
	#rwcardsTable" . $i . "{grid-template-columns: " . $thumb_box_width . "px auto; }
}
@media only screen and (min-width:90px) and (max-width:449px){
	#myGallery_rwcards_" . $i . " { width: " . $thumb_box_width . "px; height: " . $thumb_box_height . "px;}
	#rwcardsTable" . $i . "{ grid-template-rows: " . $thumb_box_height . "px auto; }
}
";
	}
}
// finish build additional Stylesheet by A. Dalebout
$document = JFactory::getDocument();
$document->addStyleDeclaration($style); // send additional Stylesheet to joomlal by A.Dalebout
$document->addScript(JURI::base() . 'components/com_rwcards/js/rwcards.gallery.js');
$document->addStyleSheet(JURI::base() . 'components/com_rwcards/css/rwcards.slideshow.css', 'text/css', null, array('id' => 'StyleSheet'));
$document->addStyleSheet(JURI::base() . 'components/com_rwcards/css/rwcards.rwcards.css', 'text/css', null, array('id' => 'StyleSheet'));
?>

<h1><?php echo ($this->active->query["cats_page_heading"] != "" ? $this->active->query["cats_page_heading"] : JText::_('COM_RWCARDS_VIEW_CARDS')); ?></h1>
<?php
if (count($this->rwcards[0]) > 0) {
	for ($i = 0; $i < count($this->rwcards); $i++) {
?>
		<script type="text/javascript">
			(function($) {
				function startGallery_rwcards_<?php echo $i; ?>() {
					var myGallery = new gallery($('myGallery_rwcards_<?php echo $i; ?>'), {
						timed: true,
						showArrows: false,
						showCarousel: false
					});
				}
				window.addEvent('domready', startGallery_rwcards_<?php echo $i; ?>);
			})(document.id);
		</script>

		<div id="rwcardsTable<?php echo $i; ?>">
			<div id="rwcards_gallery">
				<div id="myGallery_rwcards_<?php echo $i; ?>">
					<?php
					// loop through cards in section
					foreach ($this->rwcards[$i] as $key => $val) {
					?>
						<div class="imageElement">
							<h3><?php echo $val->thumb_title; ?></h3>
							<p><?php echo $val->thumb_desc; ?></p>
							<a href="<?php echo JRoute::_('index.php?view=rwcard&amp;category_id=' . $val->category_id
											. '&amp;reWritetoSender=' . @$this->reWritetoSender
											. '&amp;sessionId=' . @$this->sessionId);
										?>" title="<?php echo htmlentities($val->category_kategorien_name, ENT_QUOTES, 'UTF-8'); ?>" class="open"></a>
							<img src="<?php echo JURI::base(); ?>images/rwcards/<?php echo strtolower(substr($val->picture, 0, -4))
																					. $this->suffix . strtolower(substr($val->picture, strrpos($val->picture, "."))); ?>" class="full" alt="<?php echo nl2br(htmlentities($val->category_kategorien_name, ENT_QUOTES, 'UTF-8')); ?>" />
						</div>

						<script type="text/javascript">
							(function($) {
								function linkToCategory_<?php echo $i; ?>() {
									$$('#myGallery_rwcards_<?php echo $i; ?>').addEvent('click', function() {
										location.href = "<?php echo JRoute::_('index.php?view=rwcard&amp;category_id=' . $val->category_id
																. '&amp;reWritetoSender=' . @$this->reWritetoSender
																. '&amp;sessionId=' . @$this->sessionId);
															?>";
									});
								};

								window.addEvent('domready', linkToCategory_<?php echo $i; ?>);
							})(document.id);
						</script>
					<?php
					}
					?>
				</div>
			</div>
			<div id="description_<?php echo $i; ?>">
				<span class="rwcards_category_heading"><a href="<?php echo JRoute::_('index.php?view=rwcard&category_id=' . $this->categoryData[$i]->id
																	. '&reWritetoSender=' . @$this->reWritetoSender
																	. '&sessionId=' . @$this->sessionId);
																?>" class="open"><?php echo htmlentities($this->categoryData[$i]->category_kategorien_name, ENT_QUOTES, 'UTF-8'); ?></a>
				</span>


				<span class="rwcards_category_description"><?php echo htmlentities($this->categoryData[$i]->category_description, ENT_QUOTES, 'UTF-8'); ?></span>

				<span class="rwcards_category_see_all_cards"><a href="<?php echo JRoute::_('index.php?view=rwcard&amp;category_id=' . $this->categoryData[$i]->id
																			. '&amp;reWritetoSender=' . @$this->reWritetoSender
																			. '&amp;sessionId=' . @$this->sessionId);
																		?>" class="open"><?php echo JText::_('COM_RWCARDS_SEE_ALL_CARDS'); ?></a>
				</span>
			</div>
		</div>


	<?php
	}
} else {
	?>
	<table id="rwcardsTable">
		<tr>
			<td valign="top">
				<span style="font-weight: bold; color:red; font-size:14px;">
					<?php echo JText::_('RWCARDS_NO_CATEGORY_PUBLISHE_OR_CREATED'); ?><br />
					<?php echo JText::_('RWCARDS_NO_PICTURES_PUBLISHE_OR_CREATED'); ?>
				</span>
			</td>
		</tr>
	</table>

<?php
}
?>
